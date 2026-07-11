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
        $bank_n = isset($_POST['bank_name']) ? trim($_POST['bank_name']) : '';
        $bank_an = isset($_POST['bank_account_number']) ? trim($_POST['bank_account_number']) : '';
        $bank_ac = isset($_POST['bank_account_name']) ? trim($_POST['bank_account_name']) : '';

        try {
            $stmt = $pdo->prepare("UPDATE `settings` SET `value` = :value WHERE `name` = :name");
            $stmt->execute(['value' => $pub_key, 'name' => 'paystack_public_key']);
            $stmt->execute(['value' => $sec_key, 'name' => 'paystack_secret_key']);
            $stmt->execute(['value' => $bank_n, 'name' => 'bank_name']);
            $stmt->execute(['value' => $bank_an, 'name' => 'bank_account_number']);
            $stmt->execute(['value' => $bank_ac, 'name' => 'bank_account_name']);
            $success_message = 'Payment settings and bank transfer details saved successfully.';
        } catch (PDOException $e) {
            $error_message = 'Failed to save settings: ' . $e->getMessage();
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
        $is_international = isset($_POST['is_international']) ? intval($_POST['is_international']) : 0;

        if (empty($name) || empty($description) || empty($price_ngn) || empty($price_usd)) {
            $error_message = 'Ticket Name, Description, NGN Price, and USD Price are required fields.';
        } else {
            try {
                if ($id > 0) {
                    $stmt = $pdo->prepare("UPDATE `tickets` SET `name` = :name, `description` = :description, `price_ngn` = :price_ngn, `price_usd` = :price_usd, `features` = :features, `type` = :type, `image` = :image, `is_international` = :is_international WHERE `id` = :id");
                    $stmt->execute([
                        'name'             => $name,
                        'description'      => $description,
                        'price_ngn'        => $price_ngn,
                        'price_usd'        => $price_usd,
                        'features'         => $features,
                        'type'             => $type,
                        'image'            => $image,
                        'is_international' => $is_international,
                        'id'               => $id
                    ]);
                    $success_message = 'Ticket details updated successfully.';
                } else {
                    $stmt = $pdo->prepare("INSERT INTO `tickets` (`name`, `description`, `price_ngn`, `price_usd`, `features`, `type`, `image`, `is_international`) VALUES (:name, :description, :price_ngn, :price_usd, :features, :type, :image, :is_international)");
                    $stmt->execute([
                        'name'             => $name,
                        'description'      => $description,
                        'price_ngn'        => $price_ngn,
                        'price_usd'        => $price_usd,
                        'features'         => $features,
                        'type'             => $type,
                        'image'            => $image,
                        'is_international' => $is_international
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

// Fetch Paystack and Bank configurations
$paystack_pub = '';
$paystack_sec = '';
$bank_name_val = '';
$bank_acc_num = '';
$bank_acc_name = '';
try {
    $stmt = $pdo->query("SELECT `name`, `value` FROM `settings` WHERE `name` IN ('paystack_public_key', 'paystack_secret_key', 'bank_name', 'bank_account_number', 'bank_account_name')");
    $paystack_settings = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
    if (isset($paystack_settings['paystack_public_key'])) $paystack_pub = $paystack_settings['paystack_public_key'];
    if (isset($paystack_settings['paystack_secret_key'])) $paystack_sec = $paystack_settings['paystack_secret_key'];
    if (isset($paystack_settings['bank_name'])) $bank_name_val = $paystack_settings['bank_name'];
    if (isset($paystack_settings['bank_account_number'])) $bank_acc_num = $paystack_settings['bank_account_number'];
    if (isset($paystack_settings['bank_account_name'])) $bank_acc_name = $paystack_settings['bank_account_name'];
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
$international_tickets = [];
if ($action === 'list') {
    try {
        $tickets = $pdo->query("SELECT * FROM `tickets` WHERE `is_international` = 0 ORDER BY `id` ASC")->fetchAll();
        $international_tickets = $pdo->query("SELECT * FROM `tickets` WHERE `is_international` = 1 ORDER BY `id` ASC")->fetchAll();
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
    <!-- Payment & Bank Settings Card -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">🔑 Payment Gateway & Bank Account Settings</h3>
        </div>
        <form action="tickets.php" method="POST">
            <input type="hidden" name="save_paystack" value="1">
            
            <h4 style="font-size: 13px; font-weight: 600; text-transform: uppercase; color: var(--maroon-700); margin-bottom: 12px; border-bottom: 1px solid rgba(0,0,0,0.05); padding-bottom: 6px;">Paystack API Credentials</h4>
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
            
            <h4 style="font-size: 13px; font-weight: 600; text-transform: uppercase; color: var(--maroon-700); margin-bottom: 12px; margin-top: 12px; border-bottom: 1px solid rgba(0,0,0,0.05); padding-bottom: 6px;">Bank Transfer Information</h4>
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label" for="bank_name">Bank Name</label>
                    <input type="text" id="bank_name" name="bank_name" class="form-input" value="<?php echo htmlspecialchars($bank_name_val); ?>" placeholder="e.g. Zenith Bank">
                </div>

                <div class="form-group">
                    <label class="form-label" for="bank_account_number">Account Number</label>
                    <input type="text" id="bank_account_number" name="bank_account_number" class="form-input" value="<?php echo htmlspecialchars($bank_acc_num); ?>" placeholder="e.g. 1017482811">
                </div>

                <div class="form-group">
                    <label class="form-label" for="bank_account_name">Account Name</label>
                    <input type="text" id="bank_account_name" name="bank_account_name" class="form-input" value="<?php echo htmlspecialchars($bank_acc_name); ?>" placeholder="e.g. Hotel Managers Conference">
                </div>
            </div>
            
            <button type="submit" class="btn btn-primary btn-sm">Save Payment Settings</button>
        </form>
    </div>

    <!-- Ticket List Card -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">🎟️ Available Ticket Passes</h3>
            <a href="tickets.php?action=add&is_international=0" class="btn btn-primary">Add New Ticket +</a>
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

    <!-- International Ticket List Card -->
    <div class="card" style="margin-top: 32px;">
        <div class="card-header">
            <h3 class="card-title">🌍 International Delegate Passes</h3>
            <a href="tickets.php?action=add&is_international=1" class="btn btn-primary">Add International Ticket +</a>
        </div>

        <?php if (empty($international_tickets)): ?>
            <p style="font-size:13px; color:#64748b; text-align:center; padding: 24px 0;">No international delegate passes configured. Click 'Add International Ticket' to get started.</p>
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
                        <?php foreach ($international_tickets as $t): ?>
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

            <div class="form-group" style="margin-top: 16px; margin-bottom: 24px;">
                <label class="form-label" style="display: flex; align-items: center; gap: 8px; cursor: pointer; text-transform: none;">
                    <input type="checkbox" name="is_international" value="1" <?php echo ($ticket && $ticket['is_international']) || (isset($_GET['is_international']) && $_GET['is_international'] == 1) ? 'checked' : ''; ?> style="width: 18px; height: 18px; cursor: pointer;">
                    <span style="font-size: 13px; font-weight: 600; color: var(--maroon-700);">This is an International Delegate ticket/package (will display in the international section)</span>
                </label>
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
