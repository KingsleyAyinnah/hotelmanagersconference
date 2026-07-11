<?php
$page_title = 'Manage Awards';
$page_header = 'Awards Categories';
require_once 'admin_header.php';
require_once 'upload_widget.php';

$action = isset($_GET['action']) ? $_GET['action'] : 'list';
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

$success_message = '';
$error_message = '';

// Handle CRUD Operations
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['save_award'])) {
        $name        = trim($_POST['name']);
        $description = trim($_POST['description']);
        $icon        = trim($_POST['icon']);
        $image       = trim($_POST['image']); // Cloudinary URL
        $year        = isset($_POST['year']) ? intval($_POST['year']) : 2026;

        if (empty($name)) {
            $error_message = 'Award Name is a required field.';
        } else {
            try {
                if ($id > 0) {
                    $stmt = $pdo->prepare("UPDATE `awards` SET `name` = :name, `description` = :description, `icon` = :icon, `image` = :image, `year` = :year WHERE `id` = :id");
                    $stmt->execute(['name' => $name, 'description' => $description, 'icon' => $icon, 'image' => $image, 'year' => $year, 'id' => $id]);
                    $success_message = 'Award category updated successfully.';
                } else {
                    $stmt = $pdo->prepare("INSERT INTO `awards` (`name`, `description`, `icon`, `image`, `year`) VALUES (:name, :description, :icon, :image, :year)");
                    $stmt->execute(['name' => $name, 'description' => $description, 'icon' => $icon, 'image' => $image, 'year' => $year]);
                    $success_message = 'New award category created successfully.';
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
        $stmt = $pdo->prepare("DELETE FROM `awards` WHERE `id` = :id");
        $stmt->execute(['id' => $id]);
        $success_message = 'Award category deleted successfully.';
        $action = 'list';
    } catch (PDOException $e) {
        $error_message = 'Failed to delete award: ' . $e->getMessage();
        $action = 'list';
    }
}

// Fetch single award for edit
$award = null;
if ($action === 'edit' && $id > 0) {
    try {
        $stmt = $pdo->prepare("SELECT * FROM `awards` WHERE `id` = :id");
        $stmt->execute(['id' => $id]);
        $award = $stmt->fetch();
        if (!$award) {
            $error_message = 'Award record not found.';
            $action = 'list';
        }
    } catch (PDOException $e) {
        $error_message = 'Database error: ' . $e->getMessage();
        $action = 'list';
    }
}

// Fetch all awards
$awards = [];
if ($action === 'list') {
    try {
        $awards = $pdo->query("SELECT * FROM `awards` ORDER BY `year` DESC, `id` ASC")->fetchAll();
    } catch (PDOException $e) {
        $error_message = 'Failed to retrieve awards: ' . $e->getMessage();
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
            <h3 class="card-title">All Award Categories</h3>
            <a href="awards.php?action=add" class="btn btn-primary">Add New Category +</a>
        </div>

        <?php if (empty($awards)): ?>
            <p style="font-size:13px; color:#64748b; text-align:center; padding: 24px 0;">No awards categories configured. Click 'Add New Category' to populate them.</p>
        <?php else: ?>
            <div class="table-responsive">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th style="width: 70px; text-align: center;">Image</th>
                            <th>Category Name</th>
                            <th style="width: 100px;">Year</th>
                            <th>Description</th>
                            <th style="width: 160px; text-align: right;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($awards as $aw): ?>
                            <tr>
                                <td style="text-align: center; vertical-align: middle;">
                                    <?php if (!empty($aw['image'])): ?>
                                        <img src="<?php echo htmlspecialchars($aw['image']); ?>" alt="<?php echo htmlspecialchars($aw['name']); ?>" style="width: 48px; height: 48px; object-fit: cover; border-radius: 8px; border: 1px solid rgba(212,175,55,0.3);">
                                    <?php else: ?>
                                        <span style="font-size: 26px;"><?php echo htmlspecialchars($aw['icon']); ?></span>
                                    <?php endif; ?>
                                </td>
                                <td style="font-weight: 600; color: var(--maroon-900);">
                                    <?php echo htmlspecialchars($aw['name']); ?>
                                </td>
                                <td style="font-weight: 600; color: var(--gold-600);">
                                    <?php echo htmlspecialchars(isset($aw['year']) ? $aw['year'] : '2026'); ?>
                                </td>
                                <td style="max-width: 320px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                    <?php echo htmlspecialchars($aw['description']); ?>
                                </td>
                                <td style="text-align: right;">
                                    <a href="awards.php?action=edit&id=<?php echo $aw['id']; ?>" class="btn btn-gold btn-sm">Edit</a>
                                    <a href="awards.php?action=delete&id=<?php echo $aw['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete <?php echo htmlspecialchars(addslashes($aw['name'])); ?>?');">Delete</a>
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
            <h3 class="card-title"><?php echo ($action === 'edit') ? 'Edit Award Category' : 'Create New Award Category'; ?></h3>
            <a href="awards.php" class="btn btn-secondary btn-sm">← Back to List</a>
        </div>

        <form action="awards.php<?php echo ($action === 'edit') ? '?id=' . $id : ''; ?>" method="POST">
            <input type="hidden" name="save_award" value="1">

            <div class="form-row">
                <div class="form-group" style="flex: 2;">
                    <label class="form-label" for="name">Award Category Name</label>
                    <input type="text" id="name" name="name" class="form-input" required value="<?php echo ($award) ? htmlspecialchars($award['name']) : ''; ?>" placeholder="e.g. General Manager of the Year">
                </div>

                <div class="form-group" style="flex: 1;">
                    <label class="form-label" for="year">Award Year</label>
                    <input type="number" id="year" name="year" class="form-input" required value="<?php echo ($award && isset($award['year'])) ? htmlspecialchars($award['year']) : '2026'; ?>" placeholder="e.g. 2026">
                </div>

                <div class="form-group" style="flex: 1;">
                    <label class="form-label" for="icon">Category Icon (Emoji — Fallback)</label>
                    <input type="text" id="icon" name="icon" class="form-input" value="<?php echo ($award) ? htmlspecialchars($award['icon']) : '🏆'; ?>" placeholder="e.g. 👔, 🏢, 🍽, 🏆" maxlength="10">
                    <small style="display:block; font-size:11px; color:#64748b; margin-top: 6px;">Shown on frontend if no image is uploaded.</small>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label" for="description">Award Eligibility & Criteria Description (Optional)</label>
                <textarea id="description" name="description" class="form-textarea" placeholder="Describe the evaluation metrics, who is eligible, what values are celebrated..."><?php echo ($award) ? htmlspecialchars($award['description']) : ''; ?></textarea>
            </div>

            <?php
            render_image_upload_widget([
                'field_name'  => 'image',
                'widget_id'   => 'award',
                'current_url' => ($award && !empty($award['image'])) ? $award['image'] : '',
                'label'       => 'Award Category Image / Banner',
                'optional'    => true
            ]);
            ?>

            <div style="margin-top: 24px; display: flex; gap: 12px; flex-wrap: wrap;">
                <button type="submit" class="btn btn-primary">Save Award Category</button>
                <a href="awards.php" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
<?php endif; ?>

<?php
require_once 'admin_footer.php';
?>
