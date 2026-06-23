<?php
$page_title = 'Site Settings';
$page_header = 'Overall Site Settings';
require_once 'admin_header.php';

$success_message = '';
$error_message = '';

// Handle Settings Update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $updated_settings = [
        'phone_display' => isset($_POST['phone_display']) ? trim($_POST['phone_display']) : '',
        'phone_link' => isset($_POST['phone_link']) ? trim($_POST['phone_link']) : '',
        'email' => isset($_POST['email']) ? trim($_POST['email']) : '',
        'event_date' => isset($_POST['event_date']) ? trim($_POST['event_date']) : '',
        'event_date_range' => isset($_POST['event_date_range']) ? trim($_POST['event_date_range']) : '',
        'event_location' => isset($_POST['event_location']) ? trim($_POST['event_location']) : '',
        'event_location_short' => isset($_POST['event_location_short']) ? trim($_POST['event_location_short']) : '',
        'header_announcement' => isset($_POST['header_announcement']) ? trim($_POST['header_announcement']) : '',
        'header_urgency' => isset($_POST['header_urgency']) ? trim($_POST['header_urgency']) : '',
        'footer_description' => isset($_POST['footer_description']) ? trim($_POST['footer_description']) : '',
        'footer_address' => isset($_POST['footer_address']) ? trim($_POST['footer_address']) : '',
        'cloudinary_cloud_name' => isset($_POST['cloudinary_cloud_name']) ? trim($_POST['cloudinary_cloud_name']) : '',
        'cloudinary_api_key' => isset($_POST['cloudinary_api_key']) ? trim($_POST['cloudinary_api_key']) : '',
        'cloudinary_api_secret' => isset($_POST['cloudinary_api_secret']) ? trim($_POST['cloudinary_api_secret']) : ''
    ];

    if ($pdo) {
        try {
            $pdo->beginTransaction();
            $stmt = $pdo->prepare("UPDATE `settings` SET `value` = :value WHERE `name` = :name");
            foreach ($updated_settings as $name => $value) {
                $stmt->execute(['value' => $value, 'name' => $name]);
            }
            $pdo->commit();
            $success_message = 'Settings updated successfully!';
            
            // Refresh configs in current request scope
            $phone_number_display = $updated_settings['phone_display'];
            $phone_number_link = $updated_settings['phone_link'];
            $email = $updated_settings['email'];
            $event_date = $updated_settings['event_date'];
            $event_date_range = $updated_settings['event_date_range'];
            $event_location = $updated_settings['event_location'];
            $event_location_short = $updated_settings['event_location_short'];
            $header_announcement = $updated_settings['header_announcement'];
            $header_urgency = $updated_settings['header_urgency'];
            $footer_description = $updated_settings['footer_description'];
            $footer_address = $updated_settings['footer_address'];
        } catch (PDOException $e) {
            $pdo->rollBack();
            $error_message = 'Failed to update settings: ' . $e->getMessage();
        }
    } else {
        $error_message = 'Database connection not available.';
    }
}

// Fetch current settings from database
$settings_map = [];
if ($pdo) {
    try {
        $stmt = $pdo->query("SELECT * FROM `settings`");
        $settings_map = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
    } catch (PDOException $e) {
        $error_message = 'Failed to fetch active settings: ' . $e->getMessage();
    }
}

// Fallback values if missing in DB
$current_phone_display = isset($settings_map['phone_display']) ? $settings_map['phone_display'] : '+234 911 236 8692';
$current_phone_link = isset($settings_map['phone_link']) ? $settings_map['phone_link'] : '+2349112368692';
$current_email = isset($settings_map['email']) ? $settings_map['email'] : 'hotelmanagersconference@gmail.com';
$current_event_date = isset($settings_map['event_date']) ? $settings_map['event_date'] : 'July 11 & 12, 2026';
$current_event_date_range = isset($settings_map['event_date_range']) ? $settings_map['event_date_range'] : 'July 11–12, 2026';
$current_event_location = isset($settings_map['event_location']) ? $settings_map['event_location'] : 'Lagos Continental Hotel, Victoria Island';
$current_event_location_short = isset($settings_map['event_location_short']) ? $settings_map['event_location_short'] : 'Lagos Continental Hotel';
$current_header_announcement = isset($settings_map['header_announcement']) ? $settings_map['header_announcement'] : '';
$current_header_urgency = isset($settings_map['header_urgency']) ? $settings_map['header_urgency'] : '';
$current_footer_description = isset($settings_map['footer_description']) ? $settings_map['footer_description'] : '';
$current_footer_address = isset($settings_map['footer_address']) ? $settings_map['footer_address'] : '';
$current_cloudinary_cloud_name = isset($settings_map['cloudinary_cloud_name']) ? $settings_map['cloudinary_cloud_name'] : '';
$current_cloudinary_api_key = isset($settings_map['cloudinary_api_key']) ? $settings_map['cloudinary_api_key'] : '';
$current_cloudinary_api_secret = isset($settings_map['cloudinary_api_secret']) ? $settings_map['cloudinary_api_secret'] : '';
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

<form action="settings.php" method="POST">
    <!-- General Contact Section -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">1. General Contact Information</h3>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label class="form-label" for="phone_display">Phone Number (Display Format)</label>
                <input type="text" id="phone_display" name="phone_display" class="form-input" required value="<?php echo htmlspecialchars($current_phone_display); ?>">
            </div>
            
            <div class="form-group">
                <label class="form-label" for="phone_link">Phone Number (Link Format - Digits Only)</label>
                <input type="text" id="phone_link" name="phone_link" class="form-input" required value="<?php echo htmlspecialchars($current_phone_link); ?>">
            </div>

            <div class="form-group">
                <label class="form-label" for="email">Conference Email Address</label>
                <input type="email" id="email" name="email" class="form-input" required value="<?php echo htmlspecialchars($current_email); ?>">
            </div>
        </div>
    </div>

    <!-- Event Settings Section -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">2. Event Details & Scheduling</h3>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label class="form-label" for="event_date">Event Date (Full Display)</label>
                <input type="text" id="event_date" name="event_date" class="form-input" required value="<?php echo htmlspecialchars($current_event_date); ?>">
            </div>

            <div class="form-group">
                <label class="form-label" for="event_date_range">Event Date Range (Compact)</label>
                <input type="text" id="event_date_range" name="event_date_range" class="form-input" required value="<?php echo htmlspecialchars($current_event_date_range); ?>">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label class="form-label" for="event_location">Venue Location (Full Address)</label>
                <input type="text" id="event_location" name="event_location" class="form-input" required value="<?php echo htmlspecialchars($current_event_location); ?>">
            </div>

            <div class="form-group">
                <label class="form-label" for="event_location_short">Venue Location (Short Name)</label>
                <input type="text" id="event_location_short" name="event_location_short" class="form-input" required value="<?php echo htmlspecialchars($current_event_location_short); ?>">
            </div>
        </div>
    </div>

    <!-- Banner Announcements Section -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">3. Header Notification Announcements</h3>
        </div>
        <div class="form-group">
            <label class="form-label" for="header_announcement">Top Header Announcement Bar Text</label>
            <input type="text" id="header_announcement" name="header_announcement" class="form-input" value="<?php echo htmlspecialchars($current_header_announcement); ?>" placeholder="🏆 8th Annual Edition | July 11 & 12, 2026 | Lagos Continental Hotel, Victoria Island">
        </div>
        <div class="form-group">
            <label class="form-label" for="header_urgency">Top Header Urgency Bar Text</label>
            <input type="text" id="header_urgency" name="header_urgency" class="form-input" value="<?php echo htmlspecialchars($current_header_urgency); ?>" placeholder="🔥 EARLY BIRD CLOSING SOON — Save ₦50,000 when you register before the deadline">
        </div>
    </div>

    <!-- Footer Copy Section -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">4. Footer Branding & Coordinates</h3>
        </div>
        <div class="form-group">
            <label class="form-label" for="footer_description">Footer Description Bio</label>
            <textarea id="footer_description" name="footer_description" class="form-textarea" required><?php echo htmlspecialchars($current_footer_description); ?></textarea>
        </div>
        <div class="form-group">
            <label class="form-label" for="footer_address">Footer Physical Office Address</label>
            <input type="text" id="footer_address" name="footer_address" class="form-input" required value="<?php echo htmlspecialchars($current_footer_address); ?>">
        </div>
    </div>

    <!-- Cloudinary Image Storage Section -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">5. ☁️ Cloudinary Image Storage</h3>
        </div>
        <div style="margin-bottom: 16px; padding: 12px 16px; background: #fffbeb; border: 1px solid #fde68a; border-radius: 8px; font-size: 13px; color: #78350f; line-height: 1.6;">
            <strong>Setup:</strong> Create a free account at <a href="https://cloudinary.com" target="_blank" style="color: var(--maroon-700);">cloudinary.com</a>. Find your Cloud Name, API Key, and API Secret on your Cloudinary Console dashboard and enter them below to enable secure, signed uploads.
        </div>
        <div class="form-row">
            <div class="form-group">
                <label class="form-label" for="cloudinary_cloud_name">Cloud Name</label>
                <input type="text" id="cloudinary_cloud_name" name="cloudinary_cloud_name" class="form-input" value="<?php echo htmlspecialchars($current_cloudinary_cloud_name); ?>" placeholder="e.g. my-hmc-cloud">
                <small style="display:block; font-size:11px; color:#64748b; margin-top:6px;">Found on your Cloudinary Dashboard.</small>
            </div>
            <div class="form-group">
                <label class="form-label" for="cloudinary_api_key">API Key</label>
                <input type="text" id="cloudinary_api_key" name="cloudinary_api_key" class="form-input" value="<?php echo htmlspecialchars($current_cloudinary_api_key); ?>" placeholder="e.g. 123456789012345">
                <small style="display:block; font-size:11px; color:#64748b; margin-top:6px;">Found on your Cloudinary Dashboard.</small>
            </div>
            <div class="form-group">
                <label class="form-label" for="cloudinary_api_secret">API Secret</label>
                <input type="password" id="cloudinary_api_secret" name="cloudinary_api_secret" class="form-input" value="<?php echo htmlspecialchars($current_cloudinary_api_secret); ?>" placeholder="••••••••••••••••">
                <small style="display:block; font-size:11px; color:#64748b; margin-top:6px;">Kept secure on the server; never exposed to users.</small>
            </div>
        </div>
        <?php if (!empty($current_cloudinary_cloud_name) && !empty($current_cloudinary_api_key) && !empty($current_cloudinary_api_secret)): ?>
            <div style="padding: 10px 14px; background: #f0fdf4; border: 1px solid #dcfce7; border-radius: 6px; font-size: 12px; color: #166534; display: flex; align-items: center; gap: 8px;">
                ✅ <strong>Cloudinary is active (Signed Uploads).</strong> Secure image uploads are active across all admin forms.
            </div>
        <?php else: ?>
            <div style="padding: 10px 14px; background: #fef2f2; border: 1px solid #fee2e2; border-radius: 6px; font-size: 12px; color: #991b1b; display: flex; align-items: center; gap: 8px;">
                ⚠️ <strong>Cloudinary not configured.</strong> Image uploads are disabled until you set all three fields above.
            </div>
        <?php endif; ?>
    </div>

    <div style="margin-bottom: 40px; display: flex; gap: 16px; flex-wrap: wrap;">
        <button type="submit" class="btn btn-primary">Save Settings Configuration</button>
        <a href="index.php" class="btn btn-secondary">Discard Changes</a>
    </div>
</form>

<?php
require_once 'admin_footer.php';
?>
