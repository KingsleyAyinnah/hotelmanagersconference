<?php
// Cloudinary Signature Generator for Secure Frontend Uploads
require_once 'auth.php';
require_once '../config/db.php';

header('Content-Type: application/json');

$cloudinary_api_key = '';
$cloudinary_api_secret = '';

if ($pdo) {
    try {
        $stmt = $pdo->query("SELECT `name`, `value` FROM `settings` WHERE `name` IN ('cloudinary_api_key', 'cloudinary_api_secret')");
        $settings = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
        $cloudinary_api_key = isset($settings['cloudinary_api_key']) ? $settings['cloudinary_api_key'] : '';
        $cloudinary_api_secret = isset($settings['cloudinary_api_secret']) ? $settings['cloudinary_api_secret'] : '';
    } catch (PDOException $e) {
        echo json_encode(['error' => 'Database connection error: ' . $e->getMessage()]);
        exit;
    }
}

if (empty($cloudinary_api_key) || empty($cloudinary_api_secret)) {
    echo json_encode(['error' => 'Cloudinary API credentials are not configured in Site Settings.']);
    exit;
}

$timestamp = time();
$folder = 'hmc_uploads';

// In Cloudinary, parameters to sign must be sorted alphabetically by key.
// Our parameters: folder, timestamp
$string_to_sign = "folder=" . $folder . "&timestamp=" . $timestamp . $cloudinary_api_secret;
$signature = sha1($string_to_sign);

echo json_encode([
    'signature' => $signature,
    'timestamp' => $timestamp,
    'api_key' => $cloudinary_api_key,
    'folder' => $folder
]);
?>
