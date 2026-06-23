<?php
$page_title = 'Manage Speakers';
$page_header = 'Keynote Speakers';
require_once 'admin_header.php';
require_once 'upload_widget.php';

$action = isset($_GET['action']) ? $_GET['action'] : 'list';
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

$success_message = '';
$error_message = '';

// Handle CRUD Operations
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['save_speaker'])) {
        $name  = trim($_POST['name']);
        $title = trim($_POST['title']);
        $image = trim($_POST['image']); // Cloudinary URL from hidden input

        if (empty($name) || empty($title)) {
            $error_message = 'Name and Professional Title are required fields.';
        } else {
            try {
                if ($id > 0) {
                    $stmt = $pdo->prepare("UPDATE `speakers` SET `name` = :name, `title` = :title, `image` = :image WHERE `id` = :id");
                    $stmt->execute(['name' => $name, 'title' => $title, 'image' => $image, 'id' => $id]);
                    $success_message = 'Speaker details updated successfully.';
                } else {
                    $stmt = $pdo->prepare("INSERT INTO `speakers` (`name`, `title`, `image`) VALUES (:name, :title, :image)");
                    $stmt->execute(['name' => $name, 'title' => $title, 'image' => $image]);
                    $success_message = 'New speaker added successfully.';
                }
                $action = 'list';
            } catch (PDOException $e) {
                $error_message = 'Database error: ' . $e->getMessage();
            }
        }
    }
}

// Handle Delete
if ($action === 'delete' && $id > 0) {
    try {
        $stmt = $pdo->prepare("DELETE FROM `speakers` WHERE `id` = :id");
        $stmt->execute(['id' => $id]);
        $success_message = 'Speaker deleted successfully.';
        $action = 'list';
    } catch (PDOException $e) {
        $error_message = 'Failed to delete speaker: ' . $e->getMessage();
        $action = 'list';
    }
}

// Fetch single speaker for edit
$speaker = null;
if ($action === 'edit' && $id > 0) {
    try {
        $stmt = $pdo->prepare("SELECT * FROM `speakers` WHERE `id` = :id");
        $stmt->execute(['id' => $id]);
        $speaker = $stmt->fetch();
        if (!$speaker) {
            $error_message = 'Speaker record not found.';
            $action = 'list';
        }
    } catch (PDOException $e) {
        $error_message = 'Database error: ' . $e->getMessage();
        $action = 'list';
    }
}

// Fetch all speakers
$speakers = [];
if ($action === 'list') {
    try {
        $speakers = $pdo->query("SELECT * FROM `speakers` ORDER BY `id` ASC")->fetchAll();
    } catch (PDOException $e) {
        $error_message = 'Failed to retrieve speakers: ' . $e->getMessage();
    }
}
?>

<?php if ($success_message): ?>
    <div class="alert alert-success">
        <strong>Success!</strong> <?php echo htmlspecialchars($success_message); ?>
    </div>
<?php endif; ?>

<?php if ($error_message): ?>
    <div class="alert alert-error">
        <strong>Error:</strong> <?php echo htmlspecialchars($error_message); ?>
    </div>
<?php endif; ?>

<?php if ($action === 'list'): ?>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">All Speakers</h3>
            <a href="speakers.php?action=add" class="btn btn-primary">Add New Speaker +</a>
        </div>

        <?php if (empty($speakers)): ?>
            <p style="font-size:13px; color:#64748b; text-align:center; padding: 24px 0;">No speakers configured. Click 'Add New Speaker' to populate the records.</p>
        <?php else: ?>
            <div class="table-responsive">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th style="width: 70px;">Photo</th>
                            <th>Name</th>
                            <th>Professional Title</th>
                            <th style="width: 160px; text-align: right;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($speakers as $s): ?>
                            <tr>
                                <td>
                                    <?php if (!empty($s['image'])): ?>
                                        <img src="<?php echo htmlspecialchars($s['image']); ?>" alt="<?php echo htmlspecialchars($s['name']); ?>" style="width: 48px; height: 48px; object-fit: cover; border-radius: 50%; border: 2px solid rgba(212, 175, 55, 0.4);">
                                    <?php else: ?>
                                        <div style="width: 48px; height: 48px; background: #e2e8f0; color: #64748b; display: flex; align-items: center; justify-content: center; border-radius: 50%; font-weight:700; font-size: 18px;">?</div>
                                    <?php endif; ?>
                                </td>
                                <td style="font-weight: 600; color: var(--maroon-900);">
                                    <?php echo htmlspecialchars($s['name']); ?>
                                </td>
                                <td>
                                    <?php echo htmlspecialchars($s['title']); ?>
                                </td>
                                <td style="text-align: right;">
                                    <a href="speakers.php?action=edit&id=<?php echo $s['id']; ?>" class="btn btn-gold btn-sm">Edit</a>
                                    <a href="speakers.php?action=delete&id=<?php echo $s['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete <?php echo htmlspecialchars(addslashes($s['name'])); ?>?');">Delete</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>

<?php elseif ($action === 'add' || $action === 'edit'): ?>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title"><?php echo ($action === 'edit') ? 'Edit Speaker Details' : 'Add New Keynote Speaker'; ?></h3>
            <a href="speakers.php" class="btn btn-secondary btn-sm">← Back to List</a>
        </div>

        <form action="speakers.php<?php echo ($action === 'edit') ? '?id=' . $id : ''; ?>" method="POST">
            <input type="hidden" name="save_speaker" value="1">

            <div class="form-group">
                <label class="form-label" for="name">Speaker Full Name</label>
                <input type="text" id="name" name="name" class="form-input" required value="<?php echo ($speaker) ? htmlspecialchars($speaker['name']) : ''; ?>" placeholder="e.g. Prof Wasiu Babalola">
            </div>

            <div class="form-group">
                <label class="form-label" for="title">Title / Role Designation</label>
                <input type="text" id="title" name="title" class="form-input" required value="<?php echo ($speaker) ? htmlspecialchars($speaker['title']) : ''; ?>" placeholder="e.g. SVP Africa - Continent Worldwide Hotels">
            </div>

            <?php
            render_image_upload_widget([
                'field_name'  => 'image',
                'widget_id'   => 'speaker',
                'current_url' => ($speaker && !empty($speaker['image'])) ? $speaker['image'] : '',
                'label'       => 'Speaker Headshot / Profile Photo',
                'optional'    => true
            ]);
            ?>

            <div style="margin-top: 24px; display: flex; gap: 12px; flex-wrap: wrap;">
                <button type="submit" class="btn btn-primary">Save Speaker Profile</button>
                <a href="speakers.php" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
<?php endif; ?>

<?php
require_once 'admin_footer.php';
?>
