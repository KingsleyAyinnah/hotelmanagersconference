<?php
// Central Configuration File for Hotel Managers Conference Africa (HMC Africa)

// Calculate dynamic project base directory for clean URLs and absolute assets
$script_name = isset($_SERVER['SCRIPT_NAME']) ? $_SERVER['SCRIPT_NAME'] : '';
$base_dir = !empty($script_name) ? str_replace(basename($script_name), '', $script_name) : '/';
$project_base = preg_replace('/(page|admin)\/$/', '', $base_dir);

require_once __DIR__ . '/db.php';

// Default fallback settings
$phone_number_display = '+234 911 236 8692';
$phone_number_link = '+2349112368692';
$email = 'hotelmanagersconference@gmail.com';
$event_date = 'July 11 & 12, 2026';
$event_date_range = 'July 11–12, 2026';
$event_location = 'Lagos Continental Hotel, Victoria Island';
$event_location_short = 'Lagos Continental Hotel';
$ticket_link = 'tickets';

$header_announcement = '🏆 8th Annual Edition | July 11 & 12, 2026 | Lagos Continental Hotel, Victoria Island';
$header_urgency = '🔥 EARLY BIRD CLOSING SOON — Save ₦50,000 when you register before the deadline';
$footer_description = 'Hotel Managers Conference Africa is the continent\'s flagship gathering of hospitality leadership. Built by hoteliers, for hoteliers — to synergise for sustainable growth through global best practices.';
$footer_address = '31, Yussuf Street, Iyana Ipaja, Lagos';

$paystack_public_key = '';
$paystack_secret_key = '';

if ($pdo) {
    try {
        $stmt = $pdo->query("SELECT * FROM `settings`");
        $db_settings = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
        
        if (!empty($db_settings)) {
            if (isset($db_settings['phone_display'])) $phone_number_display = $db_settings['phone_display'];
            if (isset($db_settings['phone_link'])) $phone_number_link = $db_settings['phone_link'];
            if (isset($db_settings['email'])) $email = $db_settings['email'];
            if (isset($db_settings['event_date'])) $event_date = $db_settings['event_date'];
            if (isset($db_settings['event_date_range'])) $event_date_range = $db_settings['event_date_range'];
            if (isset($db_settings['event_location'])) $event_location = $db_settings['event_location'];
            if (isset($db_settings['event_location_short'])) $event_location_short = $db_settings['event_location_short'];
            if (isset($db_settings['header_announcement'])) $header_announcement = $db_settings['header_announcement'];
            if (isset($db_settings['header_urgency'])) $header_urgency = $db_settings['header_urgency'];
            if (isset($db_settings['footer_description'])) $footer_description = $db_settings['footer_description'];
            if (isset($db_settings['footer_address'])) $footer_address = $db_settings['footer_address'];
            if (isset($db_settings['paystack_public_key'])) $paystack_public_key = $db_settings['paystack_public_key'];
            if (isset($db_settings['paystack_secret_key'])) $paystack_secret_key = $db_settings['paystack_secret_key'];
        }
    } catch (PDOException $e) {
        // Fall back to defaults
    }
}

// Navigation Menu Items (Clean URLs format)
$menu_items = [
    'About' => 'about',
    'Speakers' => 'speakers',
    'Buy Tickets' => 'tickets',
    'Awards' => 'awards',
    'Partner Hotels' => 'hotels',
    'Gallery' => 'gallery'
];

// Helper to determine the current page filename
$current_page = basename($_SERVER['PHP_SELF']);
?>

