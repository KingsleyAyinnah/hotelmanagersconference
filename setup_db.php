<?php
// Database Setup & Seeding Script for Hotel Managers Conference Africa (HMC Africa)

$host = 'localhost';
$user = 'root';
$pass = '';

try {
    // 1. Connect to MySQL Server (host only)
    $pdo = new PDO("mysql:host=$host;charset=utf8mb4", $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    ]);
    echo "Connected to MySQL successfully.\n";

    // 2. Create Database 'hmc'
    $pdo->exec("CREATE DATABASE IF NOT EXISTS `hmc` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    echo "Database 'hmc' created or already exists.\n";

    // 3. Connect to the 'hmc' Database
    $pdo->exec("USE `hmc`");

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
        `image` VARCHAR(255) NULL
    ) ENGINE=InnoDB;");
    echo "Table 'speakers' verified.\n";

    // Hotels Table
    $pdo->exec("CREATE TABLE IF NOT EXISTS `hotels` (
        `id` INT AUTO_INCREMENT PRIMARY KEY,
        `name` VARCHAR(100) NOT NULL,
        `description` TEXT NOT NULL,
        `address` VARCHAR(255) NOT NULL,
        `amenities` TEXT NULL,
        `price` VARCHAR(50) NULL,
        `discount_code` VARCHAR(50) NULL,
        `type` VARCHAR(50) NULL
    ) ENGINE=InnoDB;");
    echo "Table 'hotels' verified.\n";

    // Awards Table
    $pdo->exec("CREATE TABLE IF NOT EXISTS `awards` (
        `id` INT AUTO_INCREMENT PRIMARY KEY,
        `name` VARCHAR(100) NOT NULL,
        `description` TEXT NOT NULL,
        `icon` VARCHAR(10) NULL
    ) ENGINE=InnoDB;");
    echo "Table 'awards' verified.\n";

    // Tickets Table
    $pdo->exec("CREATE TABLE IF NOT EXISTS `tickets` (
        `id` INT AUTO_INCREMENT PRIMARY KEY,
        `name` VARCHAR(100) NOT NULL,
        `description` TEXT NOT NULL,
        `price_ngn` VARCHAR(50) NOT NULL,
        `price_usd` VARCHAR(50) NOT NULL,
        `features` TEXT NULL,
        `type` VARCHAR(50) NULL
    ) ENGINE=InnoDB;");
    echo "Table 'tickets' verified.\n";

    // Gallery Table
    $pdo->exec("CREATE TABLE IF NOT EXISTS `gallery` (
        `id` INT AUTO_INCREMENT PRIMARY KEY,
        `category` VARCHAR(50) NOT NULL,
        `title` VARCHAR(100) NOT NULL,
        `description` TEXT NULL,
        `image_path` VARCHAR(500) NULL
    ) ENGINE=InnoDB;");
    echo "Table 'gallery' verified.\n";

    // 4b. Add image column to hotels, awards, tickets if not exists
    $pdo->exec("ALTER TABLE `hotels` ADD COLUMN IF NOT EXISTS `image` VARCHAR(500) NULL");
    $pdo->exec("ALTER TABLE `awards` ADD COLUMN IF NOT EXISTS `image` VARCHAR(500) NULL");
    $pdo->exec("ALTER TABLE `tickets` ADD COLUMN IF NOT EXISTS `image` VARCHAR(500) NULL");
    echo "Image columns verified on hotels, awards, tickets.\n";

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
            'cloudinary_api_secret' => ''
        ];
        
        $insert_setting = $pdo->prepare("INSERT INTO `settings` (`name`, `value`) VALUES (?, ?)");
        foreach ($default_settings as $name => $value) {
            $insert_setting->execute([$name, $value]);
        }
        echo "Settings seeded successfully.\n";
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
                'discount_code' => 'HMC2026-CONF',
                'type' => 'Venue'
            ],
            [
                'name' => 'Best Western Plus Elomaz Hotel',
                'description' => 'A premium lodging choice situated in close proximity to the venue. Complimentary daily shuttle transfers to the conference venue are provided for all booked delegates.',
                'address' => 'Plot 22 A/B-27 Core Area, DBS Road, GRA, Asaba',
                'amenities' => 'Daily Shuttle to Venue, Complimentary Breakfast, Modern Fitness Center, 24-Hour Business Bureau',
                'price' => '$180 / night',
                'discount_code' => 'HMC2026-BWPLUS',
                'type' => 'Accredited'
            ],
            [
                'name' => 'La Campagne Tropicana Resort Lagos',
                'description' => 'Perfect for junior operations staff and cost-conscious delegates. All budget options are located within a 15-minute radius of Lagos Continental Hotel.',
                'address' => 'Ikegun, Ibeju-Lekki Area, Off Lekki/Epe Expressway, Lagos',
                'amenities' => 'Secure Gate Operations, 24/7 Power Support, Standard Guest WiFi, On-Premise Dining',
                'price' => 'from $90 / night',
                'discount_code' => 'HMC2026-BUDGET',
                'type' => 'Budget'
            ]
        ];

        $insert_hotel = $pdo->prepare("INSERT INTO `hotels` (`name`, `description`, `address`, `amenities`, `price`, `discount_code`, `type`) VALUES (:name, :description, :address, :amenities, :price, :discount_code, :type)");
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
                'type' => 'Virtual'
            ],
            [
                'name' => 'Regular Pass',
                'description' => 'Owners, Operators, Consultants',
                'price_ngn' => '₦150,000',
                'price_usd' => '$100',
                'features' => "Full Physical Venue Entry\nMasterclass Workshops\nExhibition Hall Access\nNetworking Cocktail Lunch",
                'type' => 'Regular'
            ],
            [
                'name' => 'Combo Package',
                'description' => 'Regional & Overseas delegates',
                'price_ngn' => 'from $472',
                'price_usd' => 'from $472',
                'features' => "Standard Room (2 nights)\nAirport Coordination\nVisa Invitation Support\nFull Conference Pass",
                'type' => 'Combo'
            ]
        ];

        $insert_ticket = $pdo->prepare("INSERT INTO `tickets` (`name`, `description`, `price_ngn`, `price_usd`, `features`, `type`) VALUES (:name, :description, :price_ngn, :price_usd, :features, :type)");
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
                'title' => 'Gala Dinner Celebrations',
                'description' => 'Presenting trophies to hotel managers of the year.',
                'image_path' => ''
            ],
            [
                'category' => 'panels',
                'title' => 'Hospitality Outlook 2026',
                'description' => 'Panelists discussing expansion frameworks inside West Africa.',
                'image_path' => ''
            ],
            [
                'category' => 'exhibits',
                'title' => 'Vendor Showcases',
                'description' => 'PMS developers demoing cloud platforms to general managers.',
                'image_path' => ''
            ],
            [
                'category' => 'cocktails',
                'title' => 'Networking Terrace Reception',
                'description' => 'Delegates exchanging business contacts and alignment leads.',
                'image_path' => ''
            ],
            [
                'category' => 'panels',
                'title' => 'Talent Masterclass',
                'description' => 'LBS facilitators hosting interactive operational strategy workshops.',
                'image_path' => ''
            ],
            [
                'category' => 'exhibits',
                'title' => 'Supply Chain Display',
                'description' => 'F&B and equipment manufacturers showing local sourcing assets.',
                'image_path' => ''
            ]
        ];

        $insert_gallery = $pdo->prepare("INSERT INTO `gallery` (`category`, `title`, `description`, `image_path`) VALUES (:category, :title, :description, :image_path)");
        foreach ($default_gallery as $item) {
            $insert_gallery->execute($item);
        }
        echo "Gallery seeded successfully.\n";
    }

    echo "Database setup completed successfully!\n";

} catch (PDOException $e) {
    die("Database setup failed: " . $e->getMessage() . "\n");
}
?>
