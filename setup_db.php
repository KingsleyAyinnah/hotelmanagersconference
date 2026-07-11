<?php
// Database Setup & Seeding Script for Hotel Managers Conference Africa (HMC Africa)

// Load connection settings from the central configuration
require_once __DIR__ . '/config/db.php';

try {
    // 1. Connect to MySQL Server (host only, to ensure database can be created if missing)
    $pdo_setup = new PDO("mysql:host=$host;charset=utf8mb4", $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    ]);
    echo "Connected to MySQL successfully.\n";

    // 2. Create Database
    $pdo_setup->exec("CREATE DATABASE IF NOT EXISTS `$dbname` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    echo "Database '$dbname' created or already exists.\n";

    // 3. Connect to the Database
    $pdo_setup->exec("USE `$dbname`");
    
    // Assign setup connection to $pdo for the table creation/seeding queries below
    $pdo = $pdo_setup;

    // 4. Create Tables
    
    // Settings Table
    $pdo->exec("CREATE TABLE IF NOT EXISTS `settings` (
        `name` VARCHAR(50) PRIMARY KEY,
        `value` TEXT NULL
    ) ENGINE=InnoDB;");
    echo "Table 'settings' verified.\n";

    // Speakers Table
    $pdo->exec("CREATE TABLE IF NOT EXISTS `speakers` (
        `id` INT AUTO_INCREMENT PRIMARY KEY,
        `name` VARCHAR(100) NOT NULL,
        `title` VARCHAR(255) NOT NULL,
        `image` VARCHAR(255) NULL,
        `category` VARCHAR(50) DEFAULT 'Speaker'
    ) ENGINE=InnoDB;");
    echo "Table 'speakers' verified.\n";

    // Migrate Speakers table if it already exists
    try {
        $columns = [];
        $stmt_cols = $pdo->query("DESCRIBE `speakers`");
        while ($col = $stmt_cols->fetch(PDO::FETCH_ASSOC)) {
            $columns[] = strtolower($col['Field']);
        }
        if (!in_array('category', $columns)) {
            $pdo->exec("ALTER TABLE `speakers` ADD `category` VARCHAR(50) DEFAULT 'Speaker'");
            echo "Added 'category' column to speakers table.\n";
        }
    } catch (PDOException $mig_err) {
        echo "Speakers migration note: " . $mig_err->getMessage() . "\n";
    }

    // Hotels Table
    $pdo->exec("CREATE TABLE IF NOT EXISTS `hotels` (
        `id` INT AUTO_INCREMENT PRIMARY KEY,
        `name` VARCHAR(100) NOT NULL,
        `description` TEXT NULL,
        `address` VARCHAR(255) NOT NULL,
        `amenities` TEXT NULL,
        `price` VARCHAR(50) NULL,
        `website_url` VARCHAR(500) NULL,
        `type` VARCHAR(50) NULL,
        `image` VARCHAR(500) NULL
    ) ENGINE=InnoDB;");
    echo "Table 'hotels' verified.\n";

    // Migrate Hotels table columns if they already exist from older versions
    try {
        $pdo->exec("ALTER TABLE `hotels` MODIFY `description` TEXT NULL");
        
        $columns = [];
        $stmt_cols = $pdo->query("DESCRIBE `hotels`");
        while ($col = $stmt_cols->fetch(PDO::FETCH_ASSOC)) {
            $columns[] = strtolower($col['Field']);
        }
        
        if (in_array('discount_code', $columns) && !in_array('website_url', $columns)) {
            $pdo->exec("ALTER TABLE `hotels` CHANGE `discount_code` `website_url` VARCHAR(500) NULL");
            echo "Migrated 'discount_code' column to 'website_url' in hotels table.\n";
        }
        
        if (!in_array('image', $columns)) {
            $pdo->exec("ALTER TABLE `hotels` ADD `image` VARCHAR(500) NULL");
            echo "Added 'image' column to hotels table.\n";
        }
    } catch (PDOException $mig_err) {
        echo "Migration note: " . $mig_err->getMessage() . "\n";
    }

    // Awards Table
    $pdo->exec("CREATE TABLE IF NOT EXISTS `awards` (
        `id` INT AUTO_INCREMENT PRIMARY KEY,
        `name` VARCHAR(100) NOT NULL,
        `description` TEXT NULL,
        `icon` VARCHAR(10) NULL,
        `year` INT DEFAULT 2026
    ) ENGINE=InnoDB;");
    echo "Table 'awards' verified.\n";

    // Migrate Awards table if it already exists
    try {
        $pdo->exec("ALTER TABLE `awards` MODIFY `description` TEXT NULL");
    } catch (PDOException $mig_err) {
        echo "Awards migration note: " . $mig_err->getMessage() . "\n";
    }

    // Tickets Table
    $pdo->exec("CREATE TABLE IF NOT EXISTS `tickets` (
        `id` INT AUTO_INCREMENT PRIMARY KEY,
        `name` VARCHAR(100) NOT NULL,
        `description` TEXT NOT NULL,
        `price_ngn` VARCHAR(50) NOT NULL,
        `price_usd` VARCHAR(50) NOT NULL,
        `features` TEXT NULL,
        `type` VARCHAR(50) NULL,
        `is_international` INT DEFAULT 0
    ) ENGINE=InnoDB;");
    echo "Table 'tickets' verified.\n";

    // Gallery Table
    $pdo->exec("CREATE TABLE IF NOT EXISTS `gallery` (
        `id` INT AUTO_INCREMENT PRIMARY KEY,
        `category` VARCHAR(50) NULL DEFAULT 'general',
        `year` INT NULL DEFAULT 2026,
        `image_path` VARCHAR(500) NULL
    ) ENGINE=InnoDB;");
    echo "Table 'gallery' verified.\n";

    // Migrate Gallery table if it already exists
    try {
        $columns = [];
        $stmt_cols = $pdo->query("DESCRIBE `gallery`");
        while ($col = $stmt_cols->fetch(PDO::FETCH_ASSOC)) {
            $columns[] = strtolower($col['Field']);
        }
        if (!in_array('year', $columns)) {
            $pdo->exec("ALTER TABLE `gallery` ADD `year` INT NULL DEFAULT 2026");
            echo "Added 'year' column to gallery table.\n";
        }
        $pdo->exec("ALTER TABLE `gallery` MODIFY `category` VARCHAR(50) NULL DEFAULT 'general'");
    } catch (PDOException $mig_err) {
        echo "Gallery migration note: " . $mig_err->getMessage() . "\n";
    }

    // Reservations Table
    $pdo->exec("CREATE TABLE IF NOT EXISTS `reservations` (
        `id` INT AUTO_INCREMENT PRIMARY KEY,
        `fullname` VARCHAR(100) NOT NULL,
        `email` VARCHAR(100) NOT NULL,
        `phone` VARCHAR(50) NOT NULL,
        `org` VARCHAR(100) NULL,
        `ticket_type` VARCHAR(100) NOT NULL,
        `amount` VARCHAR(50) NOT NULL,
        `payment_method` VARCHAR(50) NULL,
        `payment_status` VARCHAR(50) DEFAULT 'Pending',
        `payment_reference` VARCHAR(100) UNIQUE NULL,
        `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB;");
    echo "Table 'reservations' verified.\n";

    // Sponsors Table
    $pdo->exec("CREATE TABLE IF NOT EXISTS `sponsors` (
        `id` INT AUTO_INCREMENT PRIMARY KEY,
        `name` VARCHAR(100) NOT NULL,
        `logo` VARCHAR(500) NULL,
        `type` VARCHAR(50) DEFAULT 'Sponsor',
        `order_index` INT DEFAULT 0
    ) ENGINE=InnoDB;");
    echo "Table 'sponsors' verified.\n";

    // Blog Posts Table
    $pdo->exec("CREATE TABLE IF NOT EXISTS `blog_posts` (
        `id` INT AUTO_INCREMENT PRIMARY KEY,
        `title` VARCHAR(255) NOT NULL,
        `excerpt` VARCHAR(500) NOT NULL,
        `content` TEXT NOT NULL,
        `category` VARCHAR(50) NOT NULL,
        `image` VARCHAR(500) NULL,
        `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB;");
    echo "Table 'blog_posts' verified.\n";

    // 4b. Add image column to hotels, awards, tickets if not exists
    $pdo->exec("ALTER TABLE `hotels` ADD COLUMN IF NOT EXISTS `image` VARCHAR(500) NULL");
    $pdo->exec("ALTER TABLE `awards` ADD COLUMN IF NOT EXISTS `image` VARCHAR(500) NULL");
    $pdo->exec("ALTER TABLE `awards` ADD COLUMN IF NOT EXISTS `year` INT DEFAULT 2026");
    $pdo->exec("ALTER TABLE `tickets` ADD COLUMN IF NOT EXISTS `image` VARCHAR(500) NULL");
    $pdo->exec("ALTER TABLE `tickets` ADD COLUMN IF NOT EXISTS `is_international` INT DEFAULT 0");
    echo "Image and international columns verified on hotels, awards, tickets.\n";

    // 5. Seed Tables (Only if empty)
    
    // Seed Settings
    $stmt = $pdo->query("SELECT COUNT(*) FROM `settings`");
    if ($stmt->fetchColumn() == 0) {
        $default_settings = [
            'phone_display' => '+234 911 236 8692',
            'phone_link' => '+2349112368692',
            'email' => 'hotelmanagersconference@gmail.com',
            'event_date' => 'July 11 & 12, 2026',
            'event_date_range' => 'July 11–12, 2026',
            'event_location' => 'Lagos Continental Hotel, Victoria Island',
            'event_location_short' => 'Lagos Continental Hotel',
            'header_announcement' => '🏆 8th Annual Edition | July 11 & 12, 2026 | Lagos Continental Hotel, Victoria Island',
            'header_urgency' => '🔥 EARLY BIRD CLOSING SOON — Save ₦50,000 when you register before the deadline',
            'footer_description' => 'Hotel Managers Conference Africa is the continent\'s flagship gathering of hospitality leadership. Built by hoteliers, for hoteliers — to synergise for sustainable growth through global best practices.',
            'footer_address' => '31, Yussuf Street, Iyana Ipaja, Lagos',
            'paystack_public_key' => '',
            'paystack_secret_key' => '',
            'cloudinary_cloud_name' => '',
            'cloudinary_api_key' => '',
            'cloudinary_api_secret' => '',
            'bank_name' => 'Zenith Bank',
            'bank_account_number' => '1017482811',
            'bank_account_name' => 'Hotel Managers Conference',
            'smtp_enabled' => '0',
            'smtp_host' => 'smtp.gmail.com',
            'smtp_port' => '465',
            'smtp_secure' => 'ssl',
            'smtp_username' => '',
            'smtp_password' => '',
            'smtp_from_email' => 'reservations@hotelmanagersconference.com',
            'smtp_from_name' => 'Hotel Managers Conference Africa'
        ];
        
        $insert_setting = $pdo->prepare("INSERT INTO `settings` (`name`, `value`) VALUES (?, ?)");
        foreach ($default_settings as $name => $value) {
            $insert_setting->execute([$name, $value]);
        }
        echo "Settings seeded successfully.\n";
    } else {
        // Ensure new settings are seeded even if settings were already initialized
        $bank_check = $pdo->query("SELECT COUNT(*) FROM `settings` WHERE `name` = 'bank_name'")->fetchColumn();
        if ($bank_check == 0) {
            $insert_setting = $pdo->prepare("INSERT INTO `settings` (`name`, `value`) VALUES (?, ?)");
            $insert_setting->execute(['bank_name', 'Zenith Bank']);
            $insert_setting->execute(['bank_account_number', '1017482811']);
            $insert_setting->execute(['bank_account_name', 'Hotel Managers Conference']);
            echo "Bank settings appended to settings table.\n";
        }
        
        $smtp_check = $pdo->query("SELECT COUNT(*) FROM `settings` WHERE `name` = 'smtp_enabled'")->fetchColumn();
        if ($smtp_check == 0) {
            $insert_setting = $pdo->prepare("INSERT INTO `settings` (`name`, `value`) VALUES (?, ?)");
            $insert_setting->execute(['smtp_enabled', '0']);
            $insert_setting->execute(['smtp_host', 'smtp.gmail.com']);
            $insert_setting->execute(['smtp_port', '465']);
            $insert_setting->execute(['smtp_secure', 'ssl']);
            $insert_setting->execute(['smtp_username', '']);
            $insert_setting->execute(['smtp_password', '']);
            $insert_setting->execute(['smtp_from_email', 'reservations@hotelmanagersconference.com']);
            $insert_setting->execute(['smtp_from_name', 'Hotel Managers Conference Africa']);
            echo "SMTP settings appended to settings table.\n";
        }
    }

    // Seed Speakers
    $stmt = $pdo->query("SELECT COUNT(*) FROM `speakers`");
    if ($stmt->fetchColumn() == 0) {
        $default_speakers = [
            [
                'name' => 'Prof Wasiu Babalola',
                'title' => 'Atiba University Oyo/SVP Africa – Continent Worldwide hotels Turkiye',
                'image' => 'https://i0.wp.com/hotelmanagersconference.com/wp-content/uploads/2025/05/4.png?fit=600%2C600&ssl=1'
            ],
            [
                'name' => 'Karl Hala',
                'title' => 'Group General Manager – Continental Hotels in Nigeria',
                'image' => 'https://i0.wp.com/hotelmanagersconference.com/wp-content/uploads/2021/10/speakers-1.png?fit=600%2C600&ssl=1'
            ],
            [
                'name' => 'Barr. Chike Ogeah',
                'title' => 'Managing Director/CEO of Mac. Folly Hospitality Ltd (Owners of the Lagos Marriott Hotel)',
                'image' => 'https://i0.wp.com/hotelmanagersconference.com/wp-content/uploads/2026/05/5.png?fit=600%2C600&ssl=1'
            ],
            [
                'name' => 'Dr. Michael Pinder',
                'title' => 'General Manager – JS Signature Hotel Port Harcourt Nigeria',
                'image' => 'https://i0.wp.com/hotelmanagersconference.com/wp-content/uploads/2025/05/JS-Signature-logo.png?fit=600%2C600&ssl=1'
            ]
        ];

        $insert_speaker = $pdo->prepare("INSERT INTO `speakers` (`name`, `title`, `image`) VALUES (:name, :title, :image)");
        foreach ($default_speakers as $speaker) {
            $insert_speaker->execute($speaker);
        }
        echo "Speakers seeded successfully.\n";
    }

    // Seed Hotels
    $stmt = $pdo->query("SELECT COUNT(*) FROM `hotels`");
    if ($stmt->fetchColumn() == 0) {
        $default_hotels = [
            [
                'name' => 'Lagos Continental',
                'description' => 'Stay where all conference sessions, panel debates, exhibition halls, and the awards gala dinner are hosted. Skip local traffic and enjoy luxury lodging.',
                'address' => '52a Kofo Abayomi St, Victoria Island, Lagos',
                'amenities' => 'Five Restaurants & Bars, High-speed Guest WiFi, Outdoor Infinity Pool, 24/7 Security & Concierge',
                'price' => '$290 / night',
                'website_url' => 'https://www.lagoscontinental.com',
                'type' => 'Venue'
            ],
            [
                'name' => 'Best Western Plus Elomaz Hotel',
                'description' => 'A premium lodging choice situated in close proximity to the venue. Complimentary daily shuttle transfers to the conference venue are provided for all booked delegates.',
                'address' => 'Plot 22 A/B-27 Core Area, DBS Road, GRA, Asaba',
                'amenities' => 'Daily Shuttle to Venue, Complimentary Breakfast, Modern Fitness Center, 24-Hour Business Bureau',
                'price' => '$180 / night',
                'website_url' => 'https://www.bestwestern.com',
                'type' => 'Accredited'
            ],
            [
                'name' => 'La Campagne Tropicana Resort Lagos',
                'description' => 'Perfect for junior operations staff and cost-conscious delegates. All budget options are located within a 15-minute radius of Lagos Continental Hotel.',
                'address' => 'Ikegun, Ibeju-Lekki Area, Off Lekki/Epe Expressway, Lagos',
                'amenities' => 'Secure Gate Operations, 24/7 Power Support, Standard Guest WiFi, On-Premise Dining',
                'price' => 'from $90 / night',
                'website_url' => 'https://www.lacampagnetropicana.com',
                'type' => 'Budget'
            ]
        ];

        $insert_hotel = $pdo->prepare("INSERT INTO `hotels` (`name`, `description`, `address`, `amenities`, `price`, `website_url`, `type`) VALUES (:name, :description, :address, :amenities, :price, :website_url, :type)");
        foreach ($default_hotels as $hotel) {
            $insert_hotel->execute($hotel);
        }
        echo "Hotels seeded successfully.\n";
    }

    // Seed Awards
    $stmt = $pdo->query("SELECT COUNT(*) FROM `awards`");
    if ($stmt->fetchColumn() == 0) {
        $default_awards = [
            [
                'name' => 'General Manager of the Year',
                'description' => 'Celebrating the property manager who demonstrated exceptional leadership, revenue targets alignment, and team retention metrics.',
                'icon' => '👔'
            ],
            [
                'name' => 'Hotel of the Year (Nigeria)',
                'description' => 'Recognizing the hotel property demonstrating leading standards in service consistency, guest reviews, and local community alignment.',
                'icon' => '🏢'
            ],
            [
                'name' => 'Best Boutique Hotel of the Year',
                'description' => 'Honoring boutique hotels (under 60 keys) displaying superior design identity, personalized guest service, and high yield index.',
                'icon' => '💎'
            ],
            [
                'name' => 'Hospitality Training Brand',
                'description' => 'Commending training providers, academies, or initiatives raising hospitality standard through workforce skill enhancement.',
                'icon' => '🎓'
            ],
            [
                'name' => 'F&B Operations Excellence',
                'description' => 'Awarded to properties showing superior culinary standards, supply chain management, and restaurant margin protection.',
                'icon' => '🍽'
            ],
            [
                'name' => 'Lifetime Achievement Award',
                'description' => 'Presented to a hospitality pioneer who has dedicated over 20 years to building institutional capacity and hotel assets in Africa.',
                'icon' => '🏆'
            ]
        ];

        $insert_award = $pdo->prepare("INSERT INTO `awards` (`name`, `description`, `icon`) VALUES (:name, :description, :icon)");
        foreach ($default_awards as $award) {
            $insert_award->execute($award);
        }
        echo "Awards seeded successfully.\n";
    }

    // Seed Tickets
    $stmt = $pdo->query("SELECT COUNT(*) FROM `tickets`");
    if ($stmt->fetchColumn() == 0) {
        $default_tickets = [
            [
                'name' => 'Virtual Pass',
                'description' => 'Online & International delegates',
                'price_ngn' => '₦60,000',
                'price_usd' => '$40',
                'features' => "HD Live Broadcast Access\nFull Session Slides PDF\nQ&A Chat Portal\nDigital CPD Certificate",
                'type' => 'Virtual',
                'is_international' => 0
            ],
            [
                'name' => 'Regular Pass',
                'description' => 'Owners, Operators, Consultants',
                'price_ngn' => '₦150,000',
                'price_usd' => '$100',
                'features' => "Full Physical Venue Entry\nMasterclass Workshops\nExhibition Hall Access\nNetworking Cocktail Lunch",
                'type' => 'Regular',
                'is_international' => 0
            ],
            [
                'name' => 'Combo Package',
                'description' => 'Regional & Overseas delegates',
                'price_ngn' => 'from $472',
                'price_usd' => 'from $472',
                'features' => "Standard Room (2 nights)\nAirport Coordination\nVisa Invitation Support\nFull Conference Pass",
                'type' => 'Combo',
                'is_international' => 1
            ]
        ];

        $insert_ticket = $pdo->prepare("INSERT INTO `tickets` (`name`, `description`, `price_ngn`, `price_usd`, `features`, `type`, `is_international`) VALUES (:name, :description, :price_ngn, :price_usd, :features, :type, :is_international)");
        foreach ($default_tickets as $ticket) {
            $insert_ticket->execute($ticket);
        }
        echo "Tickets seeded successfully.\n";
    }

    // Seed Gallery
    $stmt = $pdo->query("SELECT COUNT(*) FROM `gallery`");
    if ($stmt->fetchColumn() == 0) {
        $default_gallery = [
            [
                'category' => 'awards',
                'year' => 2026,
                'image_path' => ''
            ],
            [
                'category' => 'panels',
                'year' => 2026,
                'image_path' => ''
            ],
            [
                'category' => 'exhibits',
                'year' => 2026,
                'image_path' => ''
            ],
            [
                'category' => 'general',
                'year' => 2026,
                'image_path' => ''
            ]
        ];

        $insert_gallery = $pdo->prepare("INSERT INTO `gallery` (`category`, `year`, `image_path`) VALUES (:category, :year, :image_path)");
        foreach ($default_gallery as $item) {
            $insert_gallery->execute($item);
        }
        echo "Gallery seeded successfully.\n";
    }

    // Seed Sponsors
    $stmt = $pdo->query("SELECT COUNT(*) FROM `sponsors`");
    if ($stmt->fetchColumn() == 0) {
        $default_sponsors = [
            ['name' => 'Lagos Continental', 'logo' => '', 'type' => 'Headline', 'order_index' => 0],
            ['name' => 'OPay', 'logo' => '', 'type' => 'Sponsor', 'order_index' => 1],
            ['name' => 'Huawei', 'logo' => '', 'type' => 'Sponsor', 'order_index' => 2],
            ['name' => 'IDS Next', 'logo' => '', 'type' => 'Sponsor', 'order_index' => 3],
            ['name' => 'Staycore', 'logo' => '', 'type' => 'Sponsor', 'order_index' => 4],
            ['name' => 'Presken Hotels', 'logo' => '', 'type' => 'Sponsor', 'order_index' => 5],
        ];
        $insert_sponsor = $pdo->prepare("INSERT INTO `sponsors` (`name`, `logo`, `type`, `order_index`) VALUES (:name, :logo, :type, :order_index)");
        foreach ($default_sponsors as $item) {
            $insert_sponsor->execute($item);
        }
        echo "Sponsors seeded successfully.\n";
    }

    // Seed Blog Posts
    $stmt = $pdo->query("SELECT COUNT(*) FROM `blog_posts`");
    if ($stmt->fetchColumn() == 0) {
        $default_blog_posts = [
            [
                'title' => 'Disruptive Revenue & PMS Technology for 2026',
                'excerpt' => 'How African property managers are integrating cloud management tools to protect operating margins amid inflation.',
                'content' => 'Full article content for Disruptive Revenue & PMS Technology for 2026 goes here. Hospitality tech is moving fast. Learn how West African hotels are adapting to Cloud PMS, RMS integrations, and mobile guest journeys to improve efficiency.',
                'category' => 'Operations',
                'image' => ''
            ],
            [
                'title' => 'Developing 5-Star Hospitality Talent locally',
                'excerpt' => 'Key training principles and retention programs designed to decrease staff turnover rates inside regional cities.',
                'content' => 'Full article content for Developing 5-Star Hospitality Talent locally. Workforce stability is critical. Explore training initiatives and employer branding that decreases staff churn in African hotels.',
                'category' => 'HR & Leadership',
                'image' => ''
            ],
            [
                'title' => 'Reducing Operating Overheads: Energy efficiency',
                'excerpt' => 'Practical guide for properties transitioning to smart solar grids and reducing dependency on local generators.',
                'content' => 'Full article content for Reducing Operating Overheads: Energy efficiency. Clean energy transition is no longer optional. Smart solar storage and load shedding technology allow properties to stabilize operational cost structures.',
                'category' => 'Sustainability',
                'image' => ''
            ]
        ];
        $insert_post = $pdo->prepare("INSERT INTO `blog_posts` (`title`, `excerpt`, `content`, `category`, `image`) VALUES (:title, :excerpt, :content, :category, :image)");
        foreach ($default_blog_posts as $post) {
            $insert_post->execute($post);
        }
        echo "Blog posts seeded successfully.\n";
    }

    echo "Database setup completed successfully!\n";

} catch (PDOException $e) {
    die("Database setup failed: " . $e->getMessage() . "\n");
}
?>
