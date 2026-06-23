<?php
$page_title = 'Manage Tickets & Paystack';
$page_header = 'Ticket Passes & Payment Setup';
require_once 'admin_header.php';
require_once 'upload_widget.php';

$action = isset($_GET['action']) ? $_GET['action'] : 'list';
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

$success_message = '';
$error_message = '';

// Handle CRUD Operations
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // 1. Handle Paystack Settings Update
    if (isset($_POST['save_paystack'])) {
        $pub_key = trim($_POST['paystack_public_key']);
        $sec_key = trim($_POST['paystack_secret_key']);

        try {
            $stmt = $pdo->prepare("UPDATE `settings` SET `value` = :value WHERE `name` = :name");
            $stmt->execute(['value' => $pub_key, 'name' => 'paystack_public_key']);
            $stmt->execute(['value' => $sec_key, 'name' => 'paystack_secret_key']);
            $success_message = 'Paystack API Credentials saved successfully.';
        } catch (PDOException $e) {
            $error_message = 'Failed to save Paystack credentials: ' . $e->getMessage();
        }
    }

    // 2. Handle Ticket Operations
    if (isset($_POST['save_ticket'])) {
        $name        = trim($_POST['name']);
        $description = trim($_POST['description']);
        $price_ngn   = trim($_POST['price_ngn']);
        $price_usd   = trim($_POST['price_usd']);
        $features    = trim($_POST['features']);
        $type        = trim($_POST['type']);
        $image       = trim($_POST['image']); // Cloudinary URL

        if (empty($name) || empty($description) || empty($price_ngn) || empty($price_usd)) {
            $error_message = 'Ticket Name, Description, NGN Price, and USD Price are required fields.';
        } else {
            try {
                if ($id > 0) {
                    $stmt = $pdo->prepare("UPDATE `tickets` SET `name` = :name, `description` = :description, `price_ngn` = :price_ngn, `price_usd` = :price_usd, `features` = :features, `type` = :type, `image` = :image WHERE `id` = :id");
                    $stmt->execute([
                        'name'        => $name,
                        'description' => $description,
                        'price_ngn'   => $price_ngn,
                        'price_usd'   => $price_usd,
                        'features'    => $features,
                        'type'        => $type,
                        'image'       => $image,
                        'id'          => $id
                    ]);
                    $success_message = 'Ticket details updated successfully.';
                } else {
                    $stmt = $pdo->prepare("INSERT INTO `tickets` (`name`, `description`, `price_ngn`, `price_usd`, `features`, `type`, `image`) VALUES (:name, :description, :price_ngn, :price_usd, :features, :type, :image)");
                    $stmt->execute([
                        'name'        => $name,
                        'description' => $description,
                        'price_ngn'   => $price_ngn,
                        'price_usd'   => $price_usd,
                        'features'    => $features,
                        'type'        => $type,
                        'image'       => $image
                    ]);
                    $success_message = 'New ticket option added successfully.';
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
        $stmt = $pdo->prepare("DELETE FROM `tickets` WHERE `id` = :id");
        $stmt->execute(['id' => $id]);
        $success_message = 'Ticket option deleted successfully.';
        $action = 'list';
    } catch (PDOException $e) {
        $error_message = 'Failed to delete ticket: ' . $e->getMessage();
        $action = 'list';
    }
}

// Fetch Paystack configurations
$paystack_pub = '';
$paystack_sec = '';
try {
    $stmt = $pdo->query("SELECT `name`, `value` FROM `settings` WHERE `name` IN ('paystack_public_key', 'paystack_secret_key')");
    $paystack_settings = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
    if (isset($paystack_settings['paystack_public_key'])) $paystack_pub = $paystack_settings['paystack_public_key'];
    if (isset($paystack_settings['paystack_secret_key'])) $paystack_sec = $paystack_settings['paystack_secret_key'];
} catch (PDOException $e) {
    // Suppress
}

// Fetch single ticket for edit
$ticket = null;
if ($action === 'edit' && $id > 0) {
    try {
        $stmt = $pdo->prepare("SELECT * FROM `tickets` WHERE `id` = :id");
        $stmt->execute(['id' => $id]);
        $ticket = $stmt->fetch();
        if (!$ticket) {
            $error_message = 'Ticket record not found.';
            $action = 'list';
        }
    } catch (PDOException $e) {
        $error_message = 'Database error: ' . $e->getMessage();
        $action = 'list';
    }
}

// Fetch all tickets
$tickets = [];
if ($action === 'list') {
    try {
        $tickets = $pdo->query("SELECT * FROM `tickets` ORDER BY `id` ASC")->fetchAll();
    } catch (PDOException $e) {
        $error_message = 'Failed to retrieve tickets: ' . $e->getMessage();
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
    <!-- Paystack Settings Card -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">🔑 Paystack Integration Settings</h3>
        </div>
        <form action="tickets.php" method="POST">
            <input type="hidden" name="save_paystack" value="1">
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label" for="paystack_public_key">Paystack Public Key</label>
                    <input type="text" id="paystack_public_key" name="paystack_public_key" class="form-input" value="<?php echo htmlspecialchars($paystack_pub); ?>" placeholder="pk_live_... or pk_test_...">
                </div>

                <div class="form-group">
                    <label class="form-label" for="paystack_secret_key">Paystack Secret Key</label>
                    <input type="password" id="paystack_secret_key" name="paystack_secret_key" class="form-input" value="<?php echo htmlspecialchars($paystack_sec); ?>" placeholder="sk_live_... or sk_test_...">
                </div>
            </div>
            <button type="submit" class="btn btn-primary btn-sm">Update Gateway Keys</button>
        </form>
    </div>

    <!-- Ticket List Card -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">🎟️ Available Ticket Passes</h3>
            <a href="tickets.php?action=add" class="btn btn-primary">Add New Ticket +</a>
        </div>

        <?php if (empty($tickets)): ?>
            <p style="font-size:13px; color:#64748b; text-align:center; padding: 24px 0;">No ticket options configured. Click 'Add New Ticket' to get started.</p>
        <?php else: ?>
            <div class="table-responsive">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th style="width: 80px;">Image</th>
                            <th>Ticket Name</th>
                            <th>Type</th>
                            <th>Price (NGN)</th>
                            <th>Price (USD)</th>
                            <th style="width: 160px; text-align: right;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($tickets as $t): ?>
                            <tr>
                                <td>
                                    <?php if (!empty($t['image'])): ?>
                                        <img src="<?php echo htmlspecialchars($t['image']); ?>" alt="<?php echo htmlspecialchars($t['name']); ?>" style="width: 64px; height: 44px; object-fit: cover; border-radius: 6px; border: 1px solid rgba(0,0,0,0.08);">
                                    <?php else: ?>
                                        <div style="width: 64px; height: 44px; background: #e2e8f0; color: #94a3b8; display: flex; align-items: center; justify-content: center; border-radius: 6px; font-size: 20px;">🎟️</div>
                                    <?php endif; ?>
                                </td>
                                <td style="font-weight: 600; color: var(--maroon-900);">
                                    <?php echo htmlspecialchars($t['name']); ?>
                                </td>
                                <td>
                                    <span class="badge badge-accredited">
                                        <?php echo htmlspecialchars($t['type']); ?>
                                    </span>
                                </td>
                                <td style="font-weight: 600;">
                                    <?php echo htmlspecialchars($t['price_ngn']); ?>
                                </td>
                                <td style="font-weight: 600;">
                                    <?php echo htmlspecialchars($t['price_usd']); ?>
                                </td>
                                <td style="text-align: right;">
                                    <a href="tickets.php?action=edit&id=<?php echo $t['id']; ?>" class="btn btn-gold btn-sm">Edit</a>
                                    <a href="tickets.php?action=delete&id=<?php echo $t['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete <?php echo htmlspecialchars(addslashes($t['name'])); ?>?');">Delete</a>
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
            <h3 class="card-title"><?php echo ($action === 'edit') ? 'Edit Ticket Details' : 'Create New Ticket Option'; ?></h3>
            <a href="tickets.php" class="btn btn-secondary btn-sm">← Back to List</a>
        </div>

        <form action="tickets.php<?php echo ($action === 'edit') ? '?id=' . $id : ''; ?>" method="POST">
            <input type="hidden" name="save_ticket" value="1">

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label" for="name">Ticket Option Title</label>
                    <input type="text" id="name" name="name" class="form-input" required value="<?php echo ($ticket) ? htmlspecialchars($ticket['name']) : ''; ?>" placeholder="e.g. Regular Pass, Executive VIP, Virtual Entry">
                </div>

                <div class="form-group">
                    <label class="form-label" for="type">Class Type</label>
                    <input type="text" id="type" name="type" class="form-input" value="<?php echo ($ticket) ? htmlspecialchars($ticket['type']) : ''; ?>" placeholder="e.g. Regular, VIP, Virtual, Combo">
                </div>
            </div>

            <div class="form-group">
                <label class="form-label" for="description">Target Attendee Description</label>
                <input type="text" id="description" name="description" class="form-input" required value="<?php echo ($ticket) ? htmlspecialchars($ticket['description']) : ''; ?>" placeholder="e.g. Owners, Operators, Consultants">
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label" for="price_ngn">Price (NGN Format)</label>
                    <input type="text" id="price_ngn" name="price_ngn" class="form-input" required value="<?php echo ($ticket) ? htmlspecialchars($ticket['price_ngn']) : ''; ?>" placeholder="e.g. ₦150,000">
                </div>

                <div class="form-group">
                    <label class="form-label" for="price_usd">Price (USD Format)</label>
                    <input type="text" id="price_usd" name="price_usd" class="form-input" required value="<?php echo ($ticket) ? htmlspecialchars($ticket['price_usd']) : ''; ?>" placeholder="e.g. $100">
                </div>
            </div>

            <div class="form-group">
                <label class="form-label" for="features">Key Ticket Inclusions / Features (One per line)</label>
                <textarea id="features" name="features" class="form-textarea" required placeholder="Full Physical Entry&#10;Workshop Masterclass&#10;Cocktail Networking&#10;Certificate of Attendance" style="height: 140px;"><?php echo ($ticket) ? htmlspecialchars($ticket['features']) : ''; ?></textarea>
                <small style="display:block; font-size:11px; color:#64748b; margin-top: 6px;">List features line-by-line. They will render as individual checklist bullets on the registration portal.</small>
            </div>

            <?php
            render_image_upload_widget([
                'field_name'  => 'image',
                'widget_id'   => 'ticket',
                'current_url' => ($ticket && !empty($ticket['image'])) ? $ticket['image'] : '',
                'label'       => 'Ticket Banner / Feature Image',
                'optional'    => true
            ]);
            ?>

            <div style="margin-top: 24px; display: flex; gap: 12px; flex-wrap: wrap;">
                <button type="submit" class="btn btn-primary">Save Ticket Option</button>
                <a href="tickets.php" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
<?php endif; ?>

<?php
require_once 'admin_footer.php';
?>
