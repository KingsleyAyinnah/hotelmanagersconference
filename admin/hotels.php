<?php
$page_title = 'Manage Partner Hotels';
$page_header = 'Partner Hotels';
require_once 'admin_header.php';
require_once 'upload_widget.php';

$action = isset($_GET['action']) ? $_GET['action'] : 'list';
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

$success_message = '';
$error_message = '';

// Handle CRUD Operations
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['save_hotel'])) {
        $name          = trim($_POST['name']);
        $description   = trim($_POST['description']);
        $address       = trim($_POST['address']);
        $amenities     = trim($_POST['amenities']);
        $price         = trim($_POST['price']);
        $discount_code = trim($_POST['discount_code']);
        $type          = trim($_POST['type']);
        $image         = trim($_POST['image']); // Cloudinary URL

        if (empty($name) || empty($description) || empty($address)) {
            $error_message = 'Hotel Name, Description, and Address are required fields.';
        } else {
            try {
                if ($id > 0) {
                    $stmt = $pdo->prepare("UPDATE `hotels` SET `name` = :name, `description` = :description, `address` = :address, `amenities` = :amenities, `price` = :price, `discount_code` = :discount_code, `type` = :type, `image` = :image WHERE `id` = :id");
                    $stmt->execute([
                        'name'          => $name,
                        'description'   => $description,
                        'address'       => $address,
                        'amenities'     => $amenities,
                        'price'         => $price,
                        'discount_code' => $discount_code,
                        'type'          => $type,
                        'image'         => $image,
                        'id'            => $id
                    ]);
                    $success_message = 'Hotel details updated successfully.';
                } else {
                    $stmt = $pdo->prepare("INSERT INTO `hotels` (`name`, `description`, `address`, `amenities`, `price`, `discount_code`, `type`, `image`) VALUES (:name, :description, :address, :amenities, :price, :discount_code, :type, :image)");
                    $stmt->execute([
                        'name'          => $name,
                        'description'   => $description,
                        'address'       => $address,
                        'amenities'     => $amenities,
                        'price'         => $price,
                        'discount_code' => $discount_code,
                        'type'          => $type,
                        'image'         => $image
                    ]);
                    $success_message = 'New partner hotel added successfully.';
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
        $stmt = $pdo->prepare("DELETE FROM `hotels` WHERE `id` = :id");
        $stmt->execute(['id' => $id]);
        $success_message = 'Hotel record deleted successfully.';
        $action = 'list';
    } catch (PDOException $e) {
        $error_message = 'Failed to delete hotel: ' . $e->getMessage();
        $action = 'list';
    }
}

// Fetch single hotel for edit
$hotel = null;
if ($action === 'edit' && $id > 0) {
    try {
        $stmt = $pdo->prepare("SELECT * FROM `hotels` WHERE `id` = :id");
        $stmt->execute(['id' => $id]);
        $hotel = $stmt->fetch();
        if (!$hotel) {
            $error_message = 'Hotel record not found.';
            $action = 'list';
        }
    } catch (PDOException $e) {
        $error_message = 'Database error: ' . $e->getMessage();
        $action = 'list';
    }
}

// Fetch all hotels
$hotels = [];
if ($action === 'list') {
    try {
        $hotels = $pdo->query("SELECT * FROM `hotels` ORDER BY `id` ASC")->fetchAll();
    } catch (PDOException $e) {
        $error_message = 'Failed to retrieve hotels: ' . $e->getMessage();
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
            <h3 class="card-title">All Partner Accommodations</h3>
            <a href="hotels.php?action=add" class="btn btn-primary">Add New Hotel +</a>
        </div>

        <?php if (empty($hotels)): ?>
            <p style="font-size:13px; color:#64748b; text-align:center; padding: 24px 0;">No partner hotels configured. Click 'Add New Hotel' to create records.</p>
        <?php else: ?>
            <div class="table-responsive">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th style="width: 80px;">Image</th>
                            <th>Name</th>
                            <th>Category</th>
                            <th>Price / Night</th>
                            <th>Promo Code</th>
                            <th style="width: 160px; text-align: right;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($hotels as $h): ?>
                            <tr>
                                <td>
                                    <?php if (!empty($h['image'])): ?>
                                        <img src="<?php echo htmlspecialchars($h['image']); ?>" alt="<?php echo htmlspecialchars($h['name']); ?>" style="width: 64px; height: 44px; object-fit: cover; border-radius: 6px; border: 1px solid rgba(0,0,0,0.08);">
                                    <?php else: ?>
                                        <div style="width: 64px; height: 44px; background: #e2e8f0; color: #94a3b8; display: flex; align-items: center; justify-content: center; border-radius: 6px; font-size: 20px;">🏨</div>
                                    <?php endif; ?>
                                </td>
                                <td style="font-weight: 600; color: var(--maroon-900);">
                                    <?php echo htmlspecialchars($h['name']); ?>
                                </td>
                                <td>
                                    <?php
                                    $badge_class = 'badge-budget';
                                    if (strtolower($h['type']) === 'venue') $badge_class = 'badge-venue';
                                    elseif (strtolower($h['type']) === 'accredited') $badge_class = 'badge-accredited';
                                    ?>
                                    <span class="badge <?php echo $badge_class; ?>">
                                        <?php echo htmlspecialchars($h['type']); ?>
                                    </span>
                                </td>
                                <td style="font-weight: 500;">
                                    <?php echo htmlspecialchars($h['price']); ?>
                                </td>
                                <td>
                                    <code><?php echo htmlspecialchars($h['discount_code']); ?></code>
                                </td>
                                <td style="text-align: right;">
                                    <a href="hotels.php?action=edit&id=<?php echo $h['id']; ?>" class="btn btn-gold btn-sm">Edit</a>
                                    <a href="hotels.php?action=delete&id=<?php echo $h['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete <?php echo htmlspecialchars(addslashes($h['name'])); ?>?');">Delete</a>
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
            <h3 class="card-title"><?php echo ($action === 'edit') ? 'Edit Hotel Details' : 'Add New Partner Accommodation'; ?></h3>
            <a href="hotels.php" class="btn btn-secondary btn-sm">← Back to List</a>
        </div>

        <form action="hotels.php<?php echo ($action === 'edit') ? '?id=' . $id : ''; ?>" method="POST">
            <input type="hidden" name="save_hotel" value="1">

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label" for="name">Hotel Name</label>
                    <input type="text" id="name" name="name" class="form-input" required value="<?php echo ($hotel) ? htmlspecialchars($hotel['name']) : ''; ?>" placeholder="e.g. Lagos Continental Hotel">
                </div>

                <div class="form-group">
                    <label class="form-label" for="type">Hotel Category Classification</label>
                    <select id="type" name="type" class="form-select">
                        <option value="Venue" <?php echo ($hotel && $hotel['type'] === 'Venue') ? 'selected' : ''; ?>>Venue (Primary Conference Host)</option>
                        <option value="Accredited" <?php echo ($hotel && $hotel['type'] === 'Accredited') ? 'selected' : ''; ?>>Accredited Partner (With Shuttle support)</option>
                        <option value="Budget" <?php echo ($hotel && $hotel['type'] === 'Budget') ? 'selected' : ''; ?>>Budget Option (15-min radius)</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label" for="description">Short Marketing Bio / Pitch</label>
                <textarea id="description" name="description" class="form-textarea" required placeholder="Describe proximity to venue, transfers support, catering quality, etc..."><?php echo ($hotel) ? htmlspecialchars($hotel['description']) : ''; ?></textarea>
            </div>

            <div class="form-group">
                <label class="form-label" for="address">Full Location Address</label>
                <input type="text" id="address" name="address" class="form-input" required value="<?php echo ($hotel) ? htmlspecialchars($hotel['address']) : ''; ?>" placeholder="e.g. Plot 52a Kofo Abayomi Street, Victoria Island, Lagos">
            </div>

            <div class="form-group">
                <label class="form-label" for="amenities">Key Amenities / Features (Comma separated list)</label>
                <input type="text" id="amenities" name="amenities" class="form-input" value="<?php echo ($hotel) ? htmlspecialchars($hotel['amenities']) : ''; ?>" placeholder="e.g. Free Shuttle to Venue, Outdoor Pool, Complimentary Breakfast, 24/7 Security">
                <small style="display:block; font-size:11px; color:#64748b; margin-top: 6px;">Separate features by a comma so they display as list bullets on the frontend hotel selector.</small>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label" for="price">Display Price / Rate per Night</label>
                    <input type="text" id="price" name="price" class="form-input" value="<?php echo ($hotel) ? htmlspecialchars($hotel['price']) : ''; ?>" placeholder="e.g. $290 / night or ₦120,000 / night">
                </div>

                <div class="form-group">
                    <label class="form-label" for="discount_code">Delegate Promo Code</label>
                    <input type="text" id="discount_code" name="discount_code" class="form-input" value="<?php echo ($hotel) ? htmlspecialchars($hotel['discount_code']) : ''; ?>" placeholder="e.g. HMC2026-CONF">
                </div>
            </div>

            <?php
            render_image_upload_widget([
                'field_name'  => 'image',
                'widget_id'   => 'hotel',
                'current_url' => ($hotel && !empty($hotel['image'])) ? $hotel['image'] : '',
                'label'       => 'Hotel Cover / Feature Image',
                'optional'    => true
            ]);
            ?>

            <div style="margin-top: 24px; display: flex; gap: 12px; flex-wrap: wrap;">
                <button type="submit" class="btn btn-primary">Save Accommodation Profile</button>
                <a href="hotels.php" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
<?php endif; ?>

<?php
require_once 'admin_footer.php';
?>
