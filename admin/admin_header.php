<?php
require_once 'auth.php';
require_once '../db.php';

// Determine active page
$active_script = basename($_SERVER['PHP_SELF']);

// Load Cloudinary settings from DB for use in upload widget
$cloudinary_cloud_name = '';
$cloudinary_api_key = '';
if ($pdo) {
    try {
        $stmt = $pdo->query("SELECT `name`, `value` FROM `settings` WHERE `name` IN ('cloudinary_cloud_name', 'cloudinary_api_key')");
        $cloud_settings = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
        $cloudinary_cloud_name = isset($cloud_settings['cloudinary_cloud_name']) ? $cloud_settings['cloudinary_cloud_name'] : '';
        $cloudinary_api_key = isset($cloud_settings['cloudinary_api_key']) ? $cloud_settings['cloudinary_api_key'] : '';
    } catch (PDOException $e) {
        // Suppress
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? $page_title : 'Admin Dashboard'; ?> | HMC Africa</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,600;0,700;1,600&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --maroon-950: #1a0510;
            --maroon-900: #2d0a1e;
            --maroon-800: #4a1030;
            --maroon-700: #6b1a43;
            --maroon-600: #882255;
            --gold-200: #f5e6a3;
            --gold-300: #e8cc6a;
            --gold-400: #d4af37;
            --gold-500: #b8942a;
            --gold-600: #9a7a22;
            --cream: #fdf7f0;
            --ink: #2d1a10;
            --white: #ffffff;
            --sidebar-width: 260px;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: #faf4ed;
            color: var(--ink);
            min-height: 100vh;
            display: flex;
            overflow-x: hidden;
        }

        /* Side Navigation */
        .sidebar {
            width: var(--sidebar-width);
            background: var(--maroon-950);
            border-right: 1px solid rgba(212, 175, 55, 0.2);
            color: var(--cream);
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            z-index: 100;
            transition: transform 0.3s ease;
        }

        .sidebar-brand {
            padding: 20px 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-bottom: 1px solid rgba(212, 175, 55, 0.15);
            background: var(--maroon-900);
        }

        .sidebar-brand img {
            height: 44px;
            object-fit: contain;
        }

        .sidebar-menu {
            list-style: none;
            padding: 20px 12px;
            flex-grow: 1;
            overflow-y: auto;
        }

        .sidebar-item {
            margin-bottom: 6px;
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            color: rgba(253, 247, 240, 0.7);
            text-decoration: none;
            font-size: 13px;
            font-weight: 500;
            border-radius: 8px;
            transition: all 0.2s ease;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .sidebar-link i {
            font-size: 16px;
            width: 20px;
            text-align: center;
        }

        .sidebar-link:hover, .sidebar-link.active {
            color: var(--gold-300);
            background: rgba(212, 175, 55, 0.1);
        }

        .sidebar-link.active {
            font-weight: 700;
            border-left: 3px solid var(--gold-400);
            background: rgba(212, 175, 55, 0.15);
            padding-left: 13px;
        }

        .sidebar-footer {
            padding: 20px 24px;
            border-top: 1px solid rgba(212, 175, 55, 0.15);
            background: var(--maroon-900);
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .sidebar-user {
            font-size: 11px;
            color: rgba(253, 247, 240, 0.5);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .logout-btn {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #ff8884;
            text-decoration: none;
            font-size: 12px;
            font-weight: 600;
            transition: color 0.2s;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .logout-btn:hover {
            color: #ff5550;
        }

        /* Main Content Layout */
        .main-content {
            margin-left: var(--sidebar-width);
            flex-grow: 1;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            transition: margin-left 0.3s ease;
        }

        /* Header Bar */
        .topbar {
            height: 70px;
            background: var(--white);
            border-bottom: 1px solid rgba(0, 0, 0, 0.06);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 32px;
            position: sticky;
            top: 0;
            z-index: 90;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.02);
        }

        .topbar-title {
            font-family: 'Playfair Display', serif;
            font-size: 20px;
            color: var(--maroon-950);
            font-weight: 700;
        }

        .hamburger {
            display: none;
            background: none;
            border: none;
            cursor: pointer;
            padding: 8px;
        }

        .hamburger span {
            display: block;
            width: 22px;
            height: 2px;
            background: var(--maroon-950);
            margin-bottom: 4px;
            transition: all 0.2s ease;
        }

        .hamburger span:last-child {
            margin-bottom: 0;
        }

        /* Sidebar Overlay for mobile */
        .sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.45);
            z-index: 99;
        }

        .sidebar-overlay.active {
            display: block;
        }

        /* Dashboard Content Area */
        .content-body {
            padding: 32px;
            flex-grow: 1;
            max-width: 1300px;
            width: 100%;
            margin: 0 auto;
        }

        /* Common Premium Components */
        .card {
            background: var(--white);
            border-radius: 12px;
            border: 1px solid rgba(0, 0, 0, 0.05);
            box-shadow: 0 4px 20px rgba(0,0,0,0.02);
            padding: 24px;
            margin-bottom: 24px;
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 16px;
            border-bottom: 1px solid rgba(0,0,0,0.05);
            flex-wrap: wrap;
            gap: 12px;
        }

        .card-title {
            font-family: 'Playfair Display', serif;
            font-size: 18px;
            color: var(--maroon-900);
            font-weight: 700;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 10px 20px;
            font-size: 13px;
            font-weight: 600;
            border-radius: 6px;
            border: none;
            cursor: pointer;
            transition: all 0.2s ease;
            text-decoration: none;
            font-family: 'Inter', sans-serif;
            white-space: nowrap;
        }

        .btn-primary {
            background: var(--maroon-900);
            color: var(--white);
        }

        .btn-primary:hover {
            background: var(--maroon-800);
        }

        .btn-gold {
            background: var(--gold-400);
            color: var(--maroon-950);
        }

        .btn-gold:hover {
            background: var(--gold-300);
        }

        .btn-secondary {
            background: #e2e8f0;
            color: #475569;
        }

        .btn-secondary:hover {
            background: #cbd5e1;
        }

        .btn-danger {
            background: #ef4444;
            color: var(--white);
        }

        .btn-danger:hover {
            background: #dc2626;
        }

        .btn-sm {
            padding: 6px 12px;
            font-size: 11px;
            border-radius: 4px;
        }

        /* Alert styling */
        .alert {
            padding: 12px 16px;
            border-radius: 6px;
            font-size: 13px;
            margin-bottom: 24px;
            border-left: 4px solid transparent;
        }

        .alert-success {
            background: #f0fdf4;
            color: #166534;
            border-left-color: #22c55e;
            border: 1px solid #dcfce7;
        }

        .alert-error {
            background: #fef2f2;
            color: #991b1b;
            border-left-color: #ef4444;
            border: 1px solid #fee2e2;
        }

        /* Table styles */
        .table-responsive {
            width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        .admin-table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
            font-size: 13px;
            min-width: 600px;
        }

        .admin-table th {
            background: #f8fafc;
            color: #64748b;
            font-weight: 600;
            padding: 14px 16px;
            border-bottom: 1px solid #e2e8f0;
            text-transform: uppercase;
            font-size: 10px;
            letter-spacing: 0.05em;
            white-space: nowrap;
        }

        .admin-table td {
            padding: 16px;
            border-bottom: 1px solid #f1f5f9;
            color: #334155;
            vertical-align: middle;
        }

        .admin-table tr:hover td {
            background: #fafbfe;
        }

        /* Forms */
        .form-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group.full-width {
            grid-column: 1 / -1;
        }

        .form-label {
            display: block;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #64748b;
            margin-bottom: 8px;
        }

        .form-input, .form-textarea, .form-select {
            width: 100%;
            background: var(--white);
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            padding: 10px 14px;
            font-size: 13px;
            color: var(--ink);
            font-family: 'Inter', sans-serif;
            transition: all 0.2s;
        }

        .form-input:focus, .form-textarea:focus, .form-select:focus {
            outline: none;
            border-color: var(--maroon-700);
            box-shadow: 0 0 0 3px rgba(107, 26, 67, 0.1);
        }

        .form-textarea {
            resize: vertical;
            min-height: 100px;
        }

        /* Badges */
        .badge {
            display: inline-flex;
            align-items: center;
            padding: 4px 8px;
            font-size: 10px;
            font-weight: 700;
            border-radius: 4px;
            text-transform: uppercase;
            letter-spacing: 0.03em;
        }

        .badge-venue {
            background: #fef3c7;
            color: #92400e;
        }

        .badge-accredited {
            background: #dbeafe;
            color: #1e40af;
        }

        .badge-budget {
            background: #e2e8f0;
            color: #475569;
        }

        /* ===== IMAGE UPLOAD WIDGET ===== */
        .image-upload-widget {
            position: relative;
        }

        .upload-drop-zone {
            border: 2px dashed #e2e8f0;
            border-radius: 10px;
            padding: 24px 20px;
            text-align: center;
            background: #f8fafc;
            cursor: pointer;
            transition: all 0.2s ease;
            position: relative;
        }

        .upload-drop-zone:hover,
        .upload-drop-zone.drag-over {
            border-color: var(--maroon-700);
            background: rgba(107, 26, 67, 0.03);
        }

        .upload-drop-zone input[type="file"] {
            position: absolute;
            inset: 0;
            opacity: 0;
            cursor: pointer;
            width: 100%;
            height: 100%;
        }

        .upload-drop-zone .upload-icon {
            font-size: 28px;
            margin-bottom: 8px;
            display: block;
        }

        .upload-drop-zone .upload-text {
            font-size: 13px;
            color: #64748b;
            font-weight: 500;
        }

        .upload-drop-zone .upload-subtext {
            font-size: 11px;
            color: #94a3b8;
            margin-top: 4px;
        }

        .upload-preview {
            display: none;
            margin-top: 12px;
            position: relative;
        }

        .upload-preview.visible {
            display: block;
        }

        .upload-preview img {
            width: 100%;
            max-height: 180px;
            object-fit: cover;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
        }

        .upload-preview .upload-clear {
            position: absolute;
            top: 8px;
            right: 8px;
            background: rgba(0,0,0,0.6);
            color: white;
            border: none;
            border-radius: 50%;
            width: 28px;
            height: 28px;
            cursor: pointer;
            font-size: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background 0.2s;
        }

        .upload-preview .upload-clear:hover {
            background: rgba(239,68,68,0.85);
        }

        .upload-progress {
            display: none;
            margin-top: 10px;
            padding: 10px 14px;
            background: #eff6ff;
            border: 1px solid #bfdbfe;
            border-radius: 6px;
            font-size: 12px;
            color: #1d4ed8;
            align-items: center;
            gap: 8px;
        }

        .upload-progress.visible {
            display: flex;
        }

        .upload-progress-spinner {
            width: 14px;
            height: 14px;
            border: 2px solid #bfdbfe;
            border-top-color: #1d4ed8;
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
        }

        .upload-error {
            display: none;
            margin-top: 8px;
            padding: 8px 12px;
            background: #fef2f2;
            border: 1px solid #fee2e2;
            border-radius: 6px;
            font-size: 12px;
            color: #991b1b;
        }

        .upload-error.visible {
            display: block;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 1024px) {
            .sidebar {
                transform: translateX(-100%);
            }
            .sidebar.active {
                transform: translateX(0);
            }
            .main-content {
                margin-left: 0;
            }
            .hamburger {
                display: block;
            }
            .content-body {
                padding: 24px;
            }
        }

        @media (max-width: 768px) {
            .content-body {
                padding: 16px;
            }
            .topbar {
                padding: 0 16px;
            }
            .topbar-title {
                font-size: 16px;
            }
            .topbar > div:last-child {
                display: none;
            }
            .card {
                padding: 16px;
            }
            .card-header {
                flex-direction: column;
                align-items: flex-start;
            }
            .admin-table td, .admin-table th {
                padding: 12px 10px;
                font-size: 12px;
            }
            .form-row {
                grid-template-columns: 1fr;
            }
            .btn {
                padding: 8px 14px;
                font-size: 12px;
            }
        }

        @media (max-width: 480px) {
            .sidebar-brand img {
                height: 36px;
            }
            .content-body {
                padding: 12px;
            }
            .topbar {
                height: 58px;
            }
            .topbar-title {
                font-size: 15px;
            }
        }
    </style>
</head>
<body>

    <!-- Sidebar Overlay (mobile) -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- Sidebar Menu Drawer -->
    <div class="sidebar" id="adminSidebar">
        <div class="sidebar-brand">
            <img src="https://hotelmanagersconference.com/landingpage/images/hmc_logo.png" alt="HMC Africa Logo">
        </div>
        <ul class="sidebar-menu">
            <li class="sidebar-item">
                <a href="index.php" class="sidebar-link <?php echo ($active_script === 'index.php') ? 'active' : ''; ?>">
                    <i>📊</i> Dashboard Overview
                </a>
            </li>
            <li class="sidebar-item">
                <a href="settings.php" class="sidebar-link <?php echo ($active_script === 'settings.php') ? 'active' : ''; ?>">
                    <i>⚙️</i> Site Settings
                </a>
            </li>
            <li class="sidebar-item">
                <a href="speakers.php" class="sidebar-link <?php echo ($active_script === 'speakers.php') ? 'active' : ''; ?>">
                    <i>🎤</i> Speakers
                </a>
            </li>
            <li class="sidebar-item">
                <a href="hotels.php" class="sidebar-link <?php echo ($active_script === 'hotels.php') ? 'active' : ''; ?>">
                    <i>🏨</i> Partner Hotels
                </a>
            </li>
            <li class="sidebar-item">
                <a href="awards.php" class="sidebar-link <?php echo ($active_script === 'awards.php') ? 'active' : ''; ?>">
                    <i>🏆</i> Awards
                </a>
            </li>
            <li class="sidebar-item">
                <a href="tickets.php" class="sidebar-link <?php echo ($active_script === 'tickets.php') ? 'active' : ''; ?>">
                    <i>🎟️</i> Tickets & Paystack
                </a>
            </li>
            <li class="sidebar-item">
                <a href="gallery.php" class="sidebar-link <?php echo ($active_script === 'gallery.php') ? 'active' : ''; ?>">
                    <i>🖼️</i> Gallery Images
                </a>
            </li>
        </ul>
        <div class="sidebar-footer">
            <div class="sidebar-user">
                Logged in as:<br>
                <strong><?php echo htmlspecialchars($_SESSION['admin_email']); ?></strong>
            </div>
            <a href="logout.php" class="logout-btn">
                <i>🚪</i> Log Out Securely
            </a>
        </div>
    </div>

    <!-- Main Workspace Container -->
    <div class="main-content">
        <header class="topbar">
            <button class="hamburger" id="adminHamburger" aria-label="Toggle Sidebar">
                <span></span>
                <span></span>
                <span></span>
            </button>
            <div class="topbar-title">
                <?php echo isset($page_header) ? $page_header : 'Dashboard'; ?>
            </div>
            <div style="font-size:13px; color:#64748b;">
                Hotel Managers Conference Africa 2026
            </div>
        </header>
        
        <main class="content-body">

<script>
// ====================================================
// Shared Cloudinary Upload Helper
// Usage: initImageUploadWidget(config)
// ====================================================
const HMC_CLOUDINARY = {
    cloudName: <?php echo json_encode($cloudinary_cloud_name); ?>,
    apiKey: <?php echo json_encode($cloudinary_api_key); ?>
};

/**
 * Initialize a Cloudinary image upload widget on a container element.
 * @param {Object} config
 * @param {string} config.dropZoneId     - ID of the .upload-drop-zone element
 * @param {string} config.fileInputId    - ID of the <input type="file"> inside dropzone
 * @param {string} config.hiddenInputId  - ID of the <input type="hidden"> to store Cloudinary URL
 * @param {string} config.previewId      - ID of the .upload-preview container
 * @param {string} config.previewImgId   - ID of the <img> inside preview
 * @param {string} config.progressId     - ID of the .upload-progress element
 * @param {string} config.errorId        - ID of the .upload-error element
 * @param {string} config.clearBtnId     - ID of the clear button inside preview
 */
function initImageUploadWidget(config) {
    const dropZone = document.getElementById(config.dropZoneId);
    const fileInput = document.getElementById(config.fileInputId);
    const hiddenInput = document.getElementById(config.hiddenInputId);
    const preview = document.getElementById(config.previewId);
    const previewImg = document.getElementById(config.previewImgId);
    const progress = document.getElementById(config.progressId);
    const errorEl = document.getElementById(config.errorId);
    const clearBtn = document.getElementById(config.clearBtnId);

    if (!dropZone || !fileInput || !hiddenInput) return;

    // Drag and drop styling
    dropZone.addEventListener('dragover', function(e) {
        e.preventDefault();
        dropZone.classList.add('drag-over');
    });
    dropZone.addEventListener('dragleave', function() {
        dropZone.classList.remove('drag-over');
    });
    dropZone.addEventListener('drop', function(e) {
        e.preventDefault();
        dropZone.classList.remove('drag-over');
        const files = e.dataTransfer.files;
        if (files && files[0]) {
            handleFileUpload(files[0]);
        }
    });

    fileInput.addEventListener('change', function() {
        if (fileInput.files && fileInput.files[0]) {
            handleFileUpload(fileInput.files[0]);
        }
    });

    if (clearBtn) {
        clearBtn.addEventListener('click', function(e) {
            e.preventDefault();
            hiddenInput.value = '';
            if (preview) preview.classList.remove('visible');
            if (previewImg) previewImg.src = '';
            fileInput.value = '';
            hideError();
        });
    }

    function hideError() {
        if (errorEl) {
            errorEl.classList.remove('visible');
            errorEl.textContent = '';
        }
    }

    function showError(msg) {
        if (errorEl) {
            errorEl.textContent = msg;
            errorEl.classList.add('visible');
        }
    }

    function handleFileUpload(file) {
        hideError();

        // Validate file type
        if (!file.type.startsWith('image/')) {
            showError('Please select an image file (JPG, PNG, WebP, GIF).');
            return;
        }

        // Validate file size (10MB max)
        if (file.size > 10 * 1024 * 1024) {
            showError('Image must be under 10MB.');
            return;
        }

        // Check if Cloudinary is configured
        if (!HMC_CLOUDINARY.cloudName || !HMC_CLOUDINARY.apiKey) {
            // Fallback: show local preview, use object URL as placeholder
            showLocalPreview(file);
            showError('⚠️ Cloudinary is not configured yet. Go to Site Settings → Cloudinary to set it up. The image will not be saved until Cloudinary is configured.');
            return;
        }

        // Show uploading progress
        if (progress) progress.classList.add('visible');
        if (preview) preview.classList.remove('visible');

        // Fetch signed parameters from backend
        fetch('cloudinary_sign.php')
        .then(function(res) {
            if (!res.ok) throw new Error('Failed to retrieve upload signature from server.');
            return res.json();
        })
        .then(function(signData) {
            if (signData.error) {
                throw new Error(signData.error);
            }

            const formData = new FormData();
            formData.append('file', file);
            formData.append('api_key', signData.api_key);
            formData.append('timestamp', signData.timestamp);
            formData.append('signature', signData.signature);
            formData.append('folder', signData.folder);

            return fetch('https://api.cloudinary.com/v1_1/' + HMC_CLOUDINARY.cloudName + '/image/upload', {
                method: 'POST',
                body: formData
            });
        })
        .then(function(res) {
            if (!res) return;
            if (!res.ok) throw new Error('Upload failed: ' + res.status);
            return res.json();
        })
        .then(function(data) {
            if (!data) return;
            if (progress) progress.classList.remove('visible');
            if (data.secure_url) {
                hiddenInput.value = data.secure_url;
                if (previewImg) previewImg.src = data.secure_url;
                if (preview) preview.classList.add('visible');
            } else {
                showError('Upload succeeded but no URL was returned. Please try again.');
            }
        })
        .catch(function(err) {
            if (progress) progress.classList.remove('visible');
            showError('Upload failed: ' + err.message + '. Check your Cloudinary settings.');
        });
    }

    function showLocalPreview(file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            if (previewImg) previewImg.src = e.target.result;
            if (preview) preview.classList.add('visible');
        };
        reader.readAsDataURL(file);
    }
}

// Hamburger / Sidebar toggle
document.addEventListener('DOMContentLoaded', function() {
    const hamburger = document.getElementById('adminHamburger');
    const sidebar = document.getElementById('adminSidebar');
    const overlay = document.getElementById('sidebarOverlay');

    function openSidebar() {
        sidebar.classList.add('active');
        overlay.classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    function closeSidebar() {
        sidebar.classList.remove('active');
        overlay.classList.remove('active');
        document.body.style.overflow = '';
    }

    if (hamburger) {
        hamburger.addEventListener('click', function() {
            if (sidebar.classList.contains('active')) {
                closeSidebar();
            } else {
                openSidebar();
            }
        });
    }

    if (overlay) {
        overlay.addEventListener('click', closeSidebar);
    }
});
</script>
