<?php
$page_title = 'Manage Sponsors';
$page_header = 'Sponsors & Partners';
require_once 'admin_header.php';
require_once 'upload_widget.php';

$action = isset($_GET['action']) ? $_GET['action'] : 'list';
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

$success_message = '';
$error_message = '';

// Handle CRUD Operations
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['save_sponsor'])) {
        $name        = trim($_POST['name']);
        $type        = trim($_POST['type']);
        $order_index = intval($_POST['order_index']);
        $logo        = trim($_POST['logo']); // Cloudinary URL

        if (empty($name)) {
            $error_message = 'Sponsor Name is a required field.';
        } else {
            try {
                if ($id > 0) {
                    $stmt = $pdo->prepare("UPDATE `sponsors` SET `name` = :name, `type` = :type, `order_index` = :order_index, `logo` = :logo WHERE `id` = :id");
                    $stmt->execute([
                        'name'        => $name,
                        'type'        => $type,
                        'order_index' => $order_index,
                        'logo'        => $logo,
                        'id'          => $id
                    ]);
                    $success_message = 'Sponsor updated successfully.';
                } else {
                    $stmt = $pdo->prepare("INSERT INTO `sponsors` (`name`, `type`, `order_index`, `logo`) VALUES (:name, :type, :order_index, :logo)");
                    $stmt->execute([
                        'name'        => $name,
                        'type'        => $type,
                        'order_index' => $order_index,
                        'logo'        => $logo
                    ]);
                    $success_message = 'New sponsor added successfully.';
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
        $stmt = $pdo->prepare("DELETE FROM `sponsors` WHERE `id` = :id");
        $stmt->execute(['id' => $id]);
        $success_message = 'Sponsor deleted successfully.';
        $action = 'list';
    } catch (PDOException $e) {
        $error_message = 'Failed to delete sponsor: ' . $e->getMessage();
        $action = 'list';
    }
}

// Fetch single sponsor for edit
$sponsor = null;
if ($action === 'edit' && $id > 0) {
    try {
        $stmt = $pdo->prepare("SELECT * FROM `sponsors` WHERE `id` = :id");
        $stmt->execute(['id' => $id]);
        $sponsor = $stmt->fetch();
        if (!$sponsor) {
            $error_message = 'Sponsor record not found.';
            $action = 'list';
        }
    } catch (PDOException $e) {
        $error_message = 'Database error: ' . $e->getMessage();
        $action = 'list';
    }
}

// Fetch all sponsors
$sponsors = [];
if ($action === 'list') {
    try {
        $sponsors = $pdo->query("SELECT * FROM `sponsors` ORDER BY `type` ASC, `order_index` ASC, `id` ASC")->fetchAll();
    } catch (PDOException $e) {
        $error_message = 'Failed to retrieve sponsors: ' . $e->getMessage();
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
            <h3 class="card-title">All Sponsors & Partners</h3>
            <a href="sponsors.php?action=add" class="btn btn-primary">Add New Sponsor +</a>
        </div>

        <?php if (empty($sponsors)): ?>
            <p style="font-size:13px; color:#64748b; text-align:center; padding: 24px 0;">No sponsors configured. Click 'Add New Sponsor' to add one.</p>
        <?php else: ?>
            <div class="table-responsive">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th style="width: 100px; text-align: center;">Logo</th>
                            <th>Sponsor Name</th>
                            <th>Type</th>
                            <th>Order Index</th>
                            <th style="width: 160px; text-align: right;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($sponsors as $sp): ?>
                            <tr>
                                <td style="text-align: center; vertical-align: middle;">
                                    <?php if (!empty($sp['logo'])): ?>
                                        <img src="<?php echo htmlspecialchars($sp['logo']); ?>" alt="<?php echo htmlspecialchars($sp['name']); ?>" style="max-width: 80px; max-height: 40px; object-fit: contain; border-radius: 4px; border: 1px solid rgba(0,0,0,0.1); padding: 2px; background: #fff;">
                                    <?php else: ?>
                                        <span style="font-size: 11px; color: #94a3b8; font-style: italic;">No Logo</span>
                                    <?php endif; ?>
                                </td>
                                <td style="font-weight: 600; color: var(--maroon-900);">
                                    <?php echo htmlspecialchars($sp['name']); ?>
                                </td>
                                <td>
                                    <?php if ($sp['type'] === 'Headline'): ?>
                                        <span class="badge" style="background: var(--gold-50); border: 1px solid var(--gold-400); color: var(--gold-600); padding: 4px 8px; border-radius: 4px; font-size: 11px; font-weight: 700;">⭐ Headline</span>
                                    <?php else: ?>
                                        <span class="badge" style="background: #f1f5f9; border: 1px solid #cbd5e1; color: #475569; padding: 4px 8px; border-radius: 4px; font-size: 11px;">Regular</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php echo htmlspecialchars($sp['order_index']); ?>
                                </td>
                                <td style="text-align: right;">
                                    <a href="sponsors.php?action=edit&id=<?php echo $sp['id']; ?>" class="btn btn-gold btn-sm">Edit</a>
                                    <a href="sponsors.php?action=delete&id=<?php echo $sp['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete <?php echo htmlspecialchars(addslashes($sp['name'])); ?>?');">Delete</a>
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
            <h3 class="card-title"><?php echo ($action === 'edit') ? 'Edit Sponsor Details' : 'Add New Sponsor / Partner'; ?></h3>
            <a href="sponsors.php" class="btn btn-secondary btn-sm">← Back to List</a>
        </div>

        <form action="sponsors.php<?php echo ($action === 'edit') ? '?id=' . $id : ''; ?>" method="POST">
            <input type="hidden" name="save_sponsor" value="1">

            <div class="form-group">
                <label class="form-label" for="name">Sponsor Name</label>
                <input type="text" id="name" name="name" class="form-input" required value="<?php echo ($sponsor) ? htmlspecialchars($sponsor['name']) : ''; ?>" placeholder="e.g. Lagos Continental">
            </div>

            <div class="form-row">
                <div class="form-group" style="flex: 1;">
                    <label class="form-label" for="type">Sponsor Type</label>
                    <select id="type" name="type" class="form-input" style="height: 42px; background: #fff;">
                        <option value="Sponsor" <?php echo ($sponsor && $sponsor['type'] === 'Sponsor') ? 'selected' : ''; ?>>Regular Sponsor</option>
                        <option value="Headline" <?php echo ($sponsor && $sponsor['type'] === 'Headline') ? 'selected' : ''; ?>>Headline Sponsor</option>
                    </select>
                </div>

                <div class="form-group" style="flex: 1;">
                    <label class="form-label" for="order_index">Order Index (Sort Priority)</label>
                    <input type="number" id="order_index" name="order_index" class="form-input" value="<?php echo ($sponsor) ? htmlspecialchars($sponsor['order_index']) : '0'; ?>" placeholder="e.g. 0, 1, 2">
                </div>
            </div>

            <?php
            render_image_upload_widget([
                'field_name'  => 'logo',
                'widget_id'   => 'sponsor',
                'current_url' => ($sponsor && !empty($sponsor['logo'])) ? $sponsor['logo'] : '',
                'label'       => 'Sponsor Logo Image',
                'optional'    => true
            ]);
            ?>

            <div style="margin-top: 24px; display: flex; gap: 12px; flex-wrap: wrap;">
                <button type="submit" class="btn btn-primary">Save Sponsor</button>
                <a href="sponsors.php" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
<?php endif; ?>

<?php
require_once 'admin_footer.php';
?>
