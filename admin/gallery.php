<?php
$page_title = 'Manage Gallery';
$page_header = 'Gallery Images';
require_once 'admin_header.php';
require_once 'upload_widget.php';

$action = isset($_GET['action']) ? $_GET['action'] : 'list';
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

$success_message = '';
$error_message = '';

// Handle CRUD Operations
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['save_gallery'])) {
        $category   = trim($_POST['category']);
        $title      = trim($_POST['title']);
        $description = trim($_POST['description']);
        $image_path = trim($_POST['image_path']); // Cloudinary URL from hidden input

        if (empty($category) || empty($title)) {
            $error_message = 'Category and Title are required fields.';
        } else {
            try {
                if ($id > 0) {
                    $stmt = $pdo->prepare("UPDATE `gallery` SET `category` = :category, `title` = :title, `description` = :description, `image_path` = :image_path WHERE `id` = :id");
                    $stmt->execute([
                        'category'   => $category,
                        'title'      => $title,
                        'description' => $description,
                        'image_path' => $image_path,
                        'id'         => $id
                    ]);
                    $success_message = 'Gallery item updated successfully.';
                } else {
                    $stmt = $pdo->prepare("INSERT INTO `gallery` (`category`, `title`, `description`, `image_path`) VALUES (:category, :title, :description, :image_path)");
                    $stmt->execute([
                        'category'   => $category,
                        'title'      => $title,
                        'description' => $description,
                        'image_path' => $image_path
                    ]);
                    $success_message = 'New gallery item added successfully.';
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
        $stmt = $pdo->prepare("DELETE FROM `gallery` WHERE `id` = :id");
        $stmt->execute(['id' => $id]);
        $success_message = 'Gallery item deleted successfully.';
        $action = 'list';
    } catch (PDOException $e) {
        $error_message = 'Failed to delete gallery item: ' . $e->getMessage();
        $action = 'list';
    }
}

// Fetch single gallery item for edit
$gallery_item = null;
if ($action === 'edit' && $id > 0) {
    try {
        $stmt = $pdo->prepare("SELECT * FROM `gallery` WHERE `id` = :id");
        $stmt->execute(['id' => $id]);
        $gallery_item = $stmt->fetch();
        if (!$gallery_item) {
            $error_message = 'Gallery record not found.';
            $action = 'list';
        }
    } catch (PDOException $e) {
        $error_message = 'Database error: ' . $e->getMessage();
        $action = 'list';
    }
}

// Fetch all gallery items
$gallery_items = [];
if ($action === 'list') {
    try {
        $gallery_items = $pdo->query("SELECT * FROM `gallery` ORDER BY `id` ASC")->fetchAll();
    } catch (PDOException $e) {
        $error_message = 'Failed to retrieve gallery items: ' . $e->getMessage();
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
            <h3 class="card-title">All Gallery Photos</h3>
            <a href="gallery.php?action=add" class="btn btn-primary">Add New Image +</a>
        </div>

        <?php if (empty($gallery_items)): ?>
            <p style="font-size:13px; color:#64748b; text-align:center; padding: 24px 0;">No gallery items configured. Click 'Add New Image' to seed some images.</p>
        <?php else: ?>
            <div class="table-responsive">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th style="width: 100px;">Preview</th>
                            <th>Title</th>
                            <th>Category</th>
                            <th>Description</th>
                            <th style="width: 160px; text-align: right;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($gallery_items as $item): ?>
                            <tr>
                                <td>
                                    <?php if (!empty($item['image_path'])): ?>
                                        <img src="<?php echo htmlspecialchars($item['image_path']); ?>" alt="<?php echo htmlspecialchars($item['title']); ?>" style="width: 80px; height: 52px; object-fit: cover; border-radius: 6px; border: 1px solid rgba(0,0,0,0.08);">
                                    <?php else: ?>
                                        <div style="width: 80px; height: 52px; background: #e2e8f0; color: #94a3b8; display: flex; align-items: center; justify-content: center; border-radius: 6px; font-size:10px; font-weight:700; text-align:center;">No Image</div>
                                    <?php endif; ?>
                                </td>
                                <td style="font-weight: 600; color: var(--maroon-900);">
                                    <?php echo htmlspecialchars($item['title']); ?>
                                </td>
                                <td>
                                    <span class="badge badge-accredited">
                                        <?php echo htmlspecialchars($item['category']); ?>
                                    </span>
                                </td>
                                <td style="max-width: 220px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                    <?php echo htmlspecialchars($item['description']); ?>
                                </td>
                                <td style="text-align: right;">
                                    <a href="gallery.php?action=edit&id=<?php echo $item['id']; ?>" class="btn btn-gold btn-sm">Edit</a>
                                    <a href="gallery.php?action=delete&id=<?php echo $item['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this gallery item?');">Delete</a>
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
            <h3 class="card-title"><?php echo ($action === 'edit') ? 'Edit Gallery Photo Details' : 'Add New Gallery Photo'; ?></h3>
            <a href="gallery.php" class="btn btn-secondary btn-sm">← Back to List</a>
        </div>

        <form action="gallery.php<?php echo ($action === 'edit') ? '?id=' . $id : ''; ?>" method="POST">
            <input type="hidden" name="save_gallery" value="1">

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label" for="title">Image Caption Title</label>
                    <input type="text" id="title" name="title" class="form-input" required value="<?php echo ($gallery_item) ? htmlspecialchars($gallery_item['title']) : ''; ?>" placeholder="e.g. Gala Dinner Celebrations">
                </div>

                <div class="form-group">
                    <label class="form-label" for="category">Category Filter</label>
                    <select id="category" name="category" class="form-select">
                        <option value="awards" <?php echo ($gallery_item && $gallery_item['category'] === 'awards') ? 'selected' : ''; ?>>Awards Gala Dinner</option>
                        <option value="panels" <?php echo ($gallery_item && $gallery_item['category'] === 'panels') ? 'selected' : ''; ?>>Panels & Discussions</option>
                        <option value="exhibits" <?php echo ($gallery_item && $gallery_item['category'] === 'exhibits') ? 'selected' : ''; ?>>Exhibits & Showcases</option>
                        <option value="cocktails" <?php echo ($gallery_item && $gallery_item['category'] === 'cocktails') ? 'selected' : ''; ?>>Networking & Cocktails</option>
                    </select>
                </div>
            </div>

            <?php
            render_image_upload_widget([
                'field_name'  => 'image_path',
                'widget_id'   => 'gallery',
                'current_url' => ($gallery_item && !empty($gallery_item['image_path'])) ? $gallery_item['image_path'] : '',
                'label'       => 'Gallery Photo',
                'optional'    => false
            ]);
            ?>

            <div class="form-group" style="margin-top: 20px;">
                <label class="form-label" for="description">Short Description Context</label>
                <textarea id="description" name="description" class="form-textarea" placeholder="e.g. Presenting trophies to hotel managers of the year..."><?php echo ($gallery_item) ? htmlspecialchars($gallery_item['description']) : ''; ?></textarea>
            </div>

            <div style="margin-top: 24px; display: flex; gap: 12px; flex-wrap: wrap;">
                <button type="submit" class="btn btn-primary">Save Gallery Photo</button>
                <a href="gallery.php" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
<?php endif; ?>

<?php
require_once 'admin_footer.php';
?>
