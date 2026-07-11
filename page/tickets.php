<?php
require_once '../config/config.php';

// Helper functions for currency/parsing and verification
function getNumericPriceAndCurrency($ticket) {
    $amount = 0;
    $currency = 'NGN';
    
    if ($ticket['is_international'] == 1 || strpos($ticket['price_ngn'], '$') !== false) {
        $currency = 'USD';
        $price_str = $ticket['price_usd'];
    } else {
        $currency = 'NGN';
        $price_str = $ticket['price_ngn'];
    }
    
    $clean_str = preg_replace('/[^\d.]/', '', $price_str);
    $amount = floatval($clean_str);
    
    return ['amount' => $amount, 'currency' => $currency];
}

function verifyPaystackPayment($reference, $secret_key) {
    $url = 'https://api.paystack.co/transaction/verify/' . urlencode($reference);
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Authorization: Bearer " . $secret_key,
        "Cache-Control: no-cache"
    ]);
    
    $response = curl_exec($ch);
    $err = curl_error($ch);
    curl_close($ch);
    
    if ($err) {
        return ['success' => false, 'message' => 'Curl Error: ' . $err];
    }
    
    $result = json_decode($response, true);
    if ($result && isset($result['data']) && $result['data']['status'] === 'success') {
        return ['success' => true, 'data' => $result['data']];
    }
    
    return ['success' => false, 'message' => isset($result['message']) ? $result['message'] : 'Verification failed'];
}

// 1. AJAX Action: Log seat reservation and generate payment context
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['action']) && $_GET['action'] === 'reserve') {
    header('Content-Type: application/json');
    $full_name = isset($_POST['fullname']) ? trim($_POST['fullname']) : '';
    $user_email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $user_phone = isset($_POST['phone']) ? trim($_POST['phone']) : '';
    $organization = isset($_POST['org']) ? trim($_POST['org']) : '';
    $ticket_type = isset($_POST['ticket_type']) ? trim($_POST['ticket_type']) : '';

    if (empty($full_name) || empty($user_email) || empty($user_phone) || empty($ticket_type)) {
        echo json_encode(['success' => false, 'message' => 'Please fill in all required fields marked with an asterisk (*).']);
        exit;
    }

    // Get ticket details
    $ticket = null;
    if ($pdo) {
        try {
            $stmt = $pdo->prepare("SELECT * FROM `tickets` WHERE `name` = :name");
            $stmt->execute(['name' => $ticket_type]);
            $ticket = $stmt->fetch();
        } catch (PDOException $e) {
            // Error
        }
    }

    if (!$ticket) {
        echo json_encode(['success' => false, 'message' => 'The selected ticket pass tier is invalid.']);
        exit;
    }

    $price_info = getNumericPriceAndCurrency($ticket);
    $amount_numeric = $price_info['amount'];
    $currency = $price_info['currency'];
    
    $amount_db = ($currency === 'USD') ? ('$' . number_format($amount_numeric, 2)) : ('₦' . number_format($amount_numeric));
    $reference = 'HMC-' . strtoupper(uniqid()) . '-' . time();

    if ($pdo) {
        try {
            $stmt = $pdo->prepare("INSERT INTO `reservations` (`fullname`, `email`, `phone`, `org`, `ticket_type`, `amount`, `payment_status`, `payment_reference`) VALUES (:fullname, :email, :phone, :org, :ticket_type, :amount, 'Pending', :reference)");
            $stmt->execute([
                'fullname' => $full_name,
                'email' => $user_email,
                'phone' => $user_phone,
                'org' => $organization,
                'ticket_type' => $ticket_type,
                'amount' => $amount_db,
                'reference' => $reference
            ]);

            // Fetch active bank, event and contact settings for the confirmation email
            $bank_name_val = 'Zenith Bank';
            $bank_acc_num_val = '1017482811';
            $bank_acc_name_val = 'Hotel Managers Conference';
            $mail_event_date = 'July 11 & 12, 2026';
            $mail_event_loc = 'Lagos Continental Hotel, Victoria Island';
            $mail_phone = '+234 911 236 8692';
            $mail_email = 'reservations@hotelmanagersconference.com';

            try {
                $stmt_email = $pdo->query("SELECT `name`, `value` FROM `settings` WHERE `name` IN ('bank_name', 'bank_account_number', 'bank_account_name', 'event_date', 'event_location', 'phone_display', 'email')");
                $email_settings = $stmt_email->fetchAll(PDO::FETCH_KEY_PAIR);
                if (isset($email_settings['bank_name']) && !empty($email_settings['bank_name'])) $bank_name_val = $email_settings['bank_name'];
                if (isset($email_settings['bank_account_number']) && !empty($email_settings['bank_account_number'])) $bank_acc_num_val = $email_settings['bank_account_number'];
                if (isset($email_settings['bank_account_name']) && !empty($email_settings['bank_account_name'])) $bank_acc_name_val = $email_settings['bank_account_name'];
                if (isset($email_settings['event_date']) && !empty($email_settings['event_date'])) $mail_event_date = $email_settings['event_date'];
                if (isset($email_settings['event_location']) && !empty($email_settings['event_location'])) $mail_event_loc = $email_settings['event_location'];
                if (isset($email_settings['phone_display']) && !empty($email_settings['phone_display'])) $mail_phone = $email_settings['phone_display'];
                if (isset($email_settings['email']) && !empty($email_settings['email'])) $mail_email = $email_settings['email'];
            } catch (PDOException $e_sets) {
                // Keep defaults
            }

            // Construct HTML Email body
            $email_subject = "HMC Africa - Seat Reservation Placed [{$reference}]";
            $email_body = '
            <!DOCTYPE html>
            <html>
            <head>
                <meta charset="utf-8">
                <style>
                    body { font-family: "Inter", Helvetica, Arial, sans-serif; background-color: #faf4ed; color: #2d1a10; margin: 0; padding: 0; }
                    .wrapper { width: 100%; background-color: #faf4ed; padding: 30px 0; }
                    .container { max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 12px; overflow: hidden; border: 1px solid #e2e8f0; box-shadow: 0 4px 15px rgba(0,0,0,0.05); }
                    .header { background-color: #380007; padding: 35px 20px; text-align: center; border-bottom: 3px solid #d4af37; }
                    .header h1 { color: #ffffff; font-size: 22px; margin: 0; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; }
                    .content { padding: 40px 30px; }
                    .greeting { font-size: 18px; font-weight: 600; margin-bottom: 20px; color: #380007; }
                    .intro { font-size: 15px; line-height: 1.6; margin-bottom: 30px; }
                    .details-card { background-color: #fdf7f0; border: 1px solid #f5e6a3; border-radius: 8px; padding: 24px; margin-bottom: 30px; }
                    .details-title { font-size: 16px; font-weight: 700; color: #380007; margin-top: 0; margin-bottom: 16px; border-bottom: 1px solid #e8cc6a; padding-bottom: 8px; }
                    .details-row { margin-bottom: 12px; font-size: 14px; line-height: 1.5; }
                    .details-label { font-weight: 600; color: #5c030d; display: inline-block; width: 150px; }
                    .details-value { display: inline-block; }
                    .instructions { background-color: #f8fafc; border-left: 4px solid #380007; padding: 16px; font-size: 14px; line-height: 1.6; margin-bottom: 30px; border-radius: 0 8px 8px 0; }
                    .event-info { background-color: #f1f5f9; border-radius: 8px; padding: 20px; font-size: 14px; margin-bottom: 30px; }
                    .event-info-title { font-weight: 700; color: #380007; margin-bottom: 10px; }
                    .footer { background-color: #f8fafc; padding: 24px 20px; text-align: center; font-size: 12px; color: #64748b; border-top: 1px solid #e2e8f0; }
                </style>
            </head>
            <body>
                <div class="wrapper">
                    <div class="container">
                        <div class="header">
                            <h1>Hotel Managers Conference</h1>
                        </div>
                        <div class="content">
                            <div class="greeting">Dear ' . htmlspecialchars($full_name) . ',</div>
                            <div class="intro">
                                Thank you for reserving your seat for the 8th Annual Hotel Managers Conference Africa. We have successfully logged your reservation. Here are your reservation details:
                            </div>
                            
                            <div class="details-card">
                                <div class="details-title">Reservation Details</div>
                                <div class="details-row">
                                    <span class="details-label">Reference Number:</span>
                                    <span class="details-value" style="font-family: monospace; font-weight: 700; color: #ad071b;">' . htmlspecialchars($reference) . '</span>
                                </div>
                                <div class="details-row">
                                    <span class="details-label">Access Pass:</span>
                                    <span class="details-value">' . htmlspecialchars($ticket_type) . '</span>
                                </div>
                                <div class="details-row">
                                    <span class="details-label">Amount:</span>
                                    <span class="details-value" style="font-weight: 700; color: #380007;">' . htmlspecialchars($amount_db) . '</span>
                                </div>
                                <div class="details-row">
                                    <span class="details-label">Attendee Name:</span>
                                    <span class="details-value">' . htmlspecialchars($full_name) . '</span>
                                </div>
                                ' . (!empty($organization) ? '
                                <div class="details-row">
                                    <span class="details-label">Organization:</span>
                                    <span class="details-value">' . htmlspecialchars($organization) . '</span>
                                </div>' : '') . '
                                <div class="details-row">
                                    <span class="details-label">Status:</span>
                                    <span class="details-value" style="font-weight: 700; color: #d97706;">Pending Payment</span>
                                </div>
                            </div>
                            
                            <div class="instructions">
                                <strong style="color: #380007;">Payment Instructions:</strong><br>
                                • <strong>Paystack:</strong> If you complete your payment online using Paystack, your reservation will update to <strong>Confirmed</strong> automatically.<br>
                                • <strong>Bank Transfer:</strong> If paying via bank transfer, please transfer the exact amount to the following details:<br>
                                <span style="display: block; margin: 8px 0; padding-left: 12px; border-left: 2px solid #d4af37;">
                                    <strong>Bank:</strong> ' . htmlspecialchars($bank_name_val) . '<br>
                                    <strong>Account Name:</strong> ' . htmlspecialchars($bank_acc_name_val) . '<br>
                                    <strong>Account Number:</strong> ' . htmlspecialchars($bank_acc_num_val) . '
                                </span>
                                Please email your proof of transfer along with your reservation reference to <a href="mailto:' . htmlspecialchars($mail_email) . '" style="color: #ad071b; font-weight: 600;">' . htmlspecialchars($mail_email) . '</a> for manual confirmation.
                            </div>

                            <div class="event-info">
                                <div class="event-info-title">📅 Event Schedule & Location</div>
                                <strong>Date:</strong> ' . htmlspecialchars($mail_event_date) . '<br>
                                <strong>Venue:</strong> ' . htmlspecialchars($mail_event_loc) . '
                            </div>
                        </div>
                        <div class="footer">
                            This is an automated receipt for your reservation. If you need any assistance, contact us at <a href="mailto:' . htmlspecialchars($mail_email) . '" style="color: #ad071b;">' . htmlspecialchars($mail_email) . '</a> or call ' . htmlspecialchars($mail_phone) . '.<br><br>
                            &copy; ' . date('Y') . ' Hotel Managers Conference Africa. All rights reserved.
                        </div>
                    </div>
                </div>
            </body>
            </html>';

            SmtpMailer::send($user_email, $email_subject, $email_body);

            // Construct and send HTML email to the admin
            $admin_subject = "[New Reservation] HMC Africa - Seat Reservation Placed [{$reference}]";
            $admin_body = '
            <!DOCTYPE html>
            <html>
            <head>
                <meta charset="utf-8">
                <style>
                    body { font-family: "Inter", Helvetica, Arial, sans-serif; background-color: #faf4ed; color: #2d1a10; margin: 0; padding: 0; }
                    .wrapper { width: 100%; background-color: #faf4ed; padding: 30px 0; }
                    .container { max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 12px; overflow: hidden; border: 1px solid #e2e8f0; box-shadow: 0 4px 15px rgba(0,0,0,0.05); }
                    .header { background-color: #380007; padding: 35px 20px; text-align: center; border-bottom: 3px solid #d4af37; }
                    .header h1 { color: #ffffff; font-size: 22px; margin: 0; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; }
                    .content { padding: 40px 30px; }
                    .greeting { font-size: 18px; font-weight: 600; margin-bottom: 20px; color: #380007; }
                    .intro { font-size: 15px; line-height: 1.6; margin-bottom: 30px; }
                    .details-card { background-color: #fdf7f0; border: 1px solid #f5e6a3; border-radius: 8px; padding: 24px; margin-bottom: 30px; }
                    .details-title { font-size: 16px; font-weight: 700; color: #380007; margin-top: 0; margin-bottom: 16px; border-bottom: 1px solid #e8cc6a; padding-bottom: 8px; }
                    .details-row { margin-bottom: 12px; font-size: 14px; line-height: 1.5; }
                    .details-label { font-weight: 600; color: #5c030d; display: inline-block; width: 150px; }
                    .details-value { display: inline-block; }
                    .footer { background-color: #f8fafc; padding: 24px 20px; text-align: center; font-size: 12px; color: #64748b; border-top: 1px solid #e2e8f0; }
                </style>
            </head>
            <body>
                <div class="wrapper">
                    <div class="container">
                        <div class="header">
                            <h1>Hotel Managers Conference</h1>
                        </div>
                        <div class="content">
                            <div class="greeting">Hello Admin,</div>
                            <div class="intro">
                                A new seat reservation has been placed by an attendee on the HMC website. Here are the details:
                            </div>
                            
                            <div class="details-card">
                                <div class="details-title">New Reservation Summary</div>
                                <div class="details-row">
                                    <span class="details-label">Reference Number:</span>
                                    <span class="details-value" style="font-family: monospace; font-weight: 700; color: #ad071b;">' . htmlspecialchars($reference) . '</span>
                                </div>
                                <div class="details-row">
                                    <span class="details-label">Access Pass:</span>
                                    <span class="details-value">' . htmlspecialchars($ticket_type) . '</span>
                                </div>
                                <div class="details-row">
                                    <span class="details-label">Amount:</span>
                                    <span class="details-value" style="font-weight: 700; color: #380007;">' . htmlspecialchars($amount_db) . '</span>
                                </div>
                                <div class="details-row">
                                    <span class="details-label">Attendee Name:</span>
                                    <span class="details-value">' . htmlspecialchars($full_name) . '</span>
                                </div>
                                <div class="details-row">
                                    <span class="details-label">Attendee Email:</span>
                                    <span class="details-value">' . htmlspecialchars($user_email) . '</span>
                                </div>
                                <div class="details-row">
                                    <span class="details-label">Attendee Phone:</span>
                                    <span class="details-value">' . htmlspecialchars($user_phone) . '</span>
                                </div>
                                ' . (!empty($organization) ? '
                                <div class="details-row">
                                    <span class="details-label">Organization:</span>
                                    <span class="details-value">' . htmlspecialchars($organization) . '</span>
                                </div>' : '') . '
                            </div>
                            
                            <p style="font-size:14px; line-height:1.6;">You can view and manage this reservation on the admin dashboard reservations ledger.</p>
                        </div>
                        <div class="footer">
                            &copy; ' . date('Y') . ' Hotel Managers Conference Africa. All rights reserved.
                        </div>
                    </div>
                </div>
            </body>
            </html>';

            SmtpMailer::send('hotelmanagersconference@gmail.com', $admin_subject, $admin_body);

            // Get Paystack Public Key
            $paystack_pub = '';
            $stmt_key = $pdo->query("SELECT `value` FROM `settings` WHERE `name` = 'paystack_public_key'");
            $paystack_pub = $stmt_key->fetchColumn() ?: '';

            // Calculate kobo/cents
            $amount_cents = round($amount_numeric * 100);

            echo json_encode([
                'success' => true,
                'reference' => $reference,
                'email' => $user_email,
                'amount_cents' => $amount_cents,
                'currency' => $currency,
                'paystack_public_key' => $paystack_pub,
                'amount_formatted' => $amount_db
            ]);
            exit;
        } catch (PDOException $e) {
            echo json_encode(['success' => false, 'message' => 'Database error during reservation: ' . $e->getMessage()]);
            exit;
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Database connection failed.']);
        exit;
    }
}

// 2. AJAX Action: Update reservation to Bank Transfer payment method
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['action']) && $_GET['action'] === 'choose_bank') {
    header('Content-Type: application/json');
    $reference = isset($_POST['reference']) ? trim($_POST['reference']) : '';

    if (empty($reference)) {
        echo json_encode(['success' => false, 'message' => 'Invalid transaction reference.']);
        exit;
    }

    if ($pdo) {
        try {
            $stmt = $pdo->prepare("UPDATE `reservations` SET `payment_method` = 'Bank Transfer', `payment_status` = 'Pending' WHERE `payment_reference` = :reference");
            $stmt->execute(['reference' => $reference]);
            echo json_encode(['success' => true]);
            exit;
        } catch (PDOException $e) {
            echo json_encode(['success' => false, 'message' => 'Failed to update payment method: ' . $e->getMessage()]);
            exit;
        }
    }
}

// 3. GET Action: Verification of Paystack payment reference
$error_msg = '';
if (isset($_GET['action']) && $_GET['action'] === 'verify_paystack' && isset($_GET['reference'])) {
    $reference = trim($_GET['reference']);
    
    $paystack_sec = '';
    if ($pdo) {
        try {
            $stmt_key = $pdo->query("SELECT `value` FROM `settings` WHERE `name` = 'paystack_secret_key'");
            $paystack_sec = $stmt_key->fetchColumn() ?: '';
        } catch (PDOException $e) {
            // handle
        }
    }

    $verify_result = verifyPaystackPayment($reference, $paystack_sec);

    if ($verify_result['success']) {
        if ($pdo) {
            try {
                $stmt = $pdo->prepare("UPDATE `reservations` SET `payment_method` = 'Paystack', `payment_status` = 'Confirmed' WHERE `payment_reference` = :reference");
                $stmt->execute(['reference' => $reference]);
                
                // Fetch reservation details to send confirmation email
                $stmt_res = $pdo->prepare("SELECT * FROM `reservations` WHERE `payment_reference` = :reference");
                $stmt_res->execute(['reference' => $reference]);
                $r = $stmt_res->fetch();
                
                if ($r) {
                    $mail_event_date = 'July 11 & 12, 2026';
                    $mail_event_loc = 'Lagos Continental Hotel, Victoria Island';
                    $mail_phone = '+234 911 236 8692';
                    $mail_email = 'reservations@hotelmanagersconference.com';

                    try {
                        $stmt_email = $pdo->query("SELECT `name`, `value` FROM `settings` WHERE `name` IN ('event_date', 'event_location', 'phone_display', 'email')");
                        $email_settings = $stmt_email->fetchAll(PDO::FETCH_KEY_PAIR);
                        if (isset($email_settings['event_date']) && !empty($email_settings['event_date'])) $mail_event_date = $email_settings['event_date'];
                        if (isset($email_settings['event_location']) && !empty($email_settings['event_location'])) $mail_event_loc = $email_settings['event_location'];
                        if (isset($email_settings['phone_display']) && !empty($email_settings['phone_display'])) $mail_phone = $email_settings['phone_display'];
                        if (isset($email_settings['email']) && !empty($email_settings['email'])) $mail_email = $email_settings['email'];
                    } catch (PDOException $e_sets) {
                        // Keep defaults
                    }

                    $email_subject = "HMC Africa - Seat Reservation Confirmed [{$reference}]";
                    $email_body = '
                    <!DOCTYPE html>
                    <html>
                    <head>
                        <meta charset="utf-8">
                        <style>
                            body { font-family: "Inter", Helvetica, Arial, sans-serif; background-color: #faf4ed; color: #2d1a10; margin: 0; padding: 0; }
                            .wrapper { width: 100%; background-color: #faf4ed; padding: 30px 0; }
                            .container { max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 12px; overflow: hidden; border: 1px solid #e2e8f0; box-shadow: 0 4px 15px rgba(0,0,0,0.05); }
                            .header { background-color: #380007; padding: 35px 20px; text-align: center; border-bottom: 3px solid #d4af37; }
                            .header h1 { color: #ffffff; font-size: 22px; margin: 0; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; }
                            .content { padding: 40px 30px; }
                            .greeting { font-size: 18px; font-weight: 600; margin-bottom: 20px; color: #380007; }
                            .intro { font-size: 15px; line-height: 1.6; margin-bottom: 30px; }
                            .details-card { background-color: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 8px; padding: 24px; margin-bottom: 30px; }
                            .details-title { font-size: 16px; font-weight: 700; color: #166534; margin-top: 0; margin-bottom: 16px; border-bottom: 1px solid #86efac; padding-bottom: 8px; }
                            .details-row { margin-bottom: 12px; font-size: 14px; line-height: 1.5; }
                            .details-label { font-weight: 600; color: #14532d; display: inline-block; width: 150px; }
                            .details-value { display: inline-block; }
                            .event-info { background-color: #f1f5f9; border-radius: 8px; padding: 20px; font-size: 14px; margin-bottom: 30px; }
                            .event-info-title { font-weight: 700; color: #380007; margin-bottom: 10px; }
                            .footer { background-color: #f8fafc; padding: 24px 20px; text-align: center; font-size: 12px; color: #64748b; border-top: 1px solid #e2e8f0; }
                        </style>
                    </head>
                    <body>
                        <div class="wrapper">
                            <div class="container">
                                <div class="header">
                                    <h1>Hotel Managers Conference</h1>
                                </div>
                                <div class="content">
                                    <div class="greeting">Dear ' . htmlspecialchars($r['fullname']) . ',</div>
                                    <div class="intro">
                                        We are pleased to inform you that your payment has been verified. Your seat reservation for the 8th Annual Hotel Managers Conference Africa is now <strong>Confirmed</strong>!
                                    </div>
                                    
                                    <div class="details-card">
                                        <div class="details-title">Confirmed Ticket Details</div>
                                        <div class="details-row">
                                            <span class="details-label">Reference Number:</span>
                                            <span class="details-value" style="font-family: monospace; font-weight: 700; color: #166534;">' . htmlspecialchars($reference) . '</span>
                                        </div>
                                        <div class="details-row">
                                            <span class="details-label">Access Pass:</span>
                                            <span class="details-value">' . htmlspecialchars($r['ticket_type']) . '</span>
                                        </div>
                                        <div class="details-row">
                                            <span class="details-label">Amount Paid:</span>
                                            <span class="details-value" style="font-weight: 700;">' . htmlspecialchars($r['amount']) . '</span>
                                        </div>
                                        <div class="details-row">
                                            <span class="details-label">Payment Method:</span>
                                            <span class="details-value">Paystack Online Payment</span>
                                        </div>
                                        <div class="details-row">
                                            <span class="details-label">Ticket Status:</span>
                                            <span class="details-value" style="font-weight: 700; color: #166534;">Confirmed</span>
                                        </div>
                                    </div>

                                    <div class="event-info">
                                        <div class="event-info-title">📅 Event Schedule & Location</div>
                                        <strong>Date:</strong> ' . htmlspecialchars($mail_event_date) . '<br>
                                        <strong>Venue:</strong> ' . htmlspecialchars($mail_event_loc) . '
                                    </div>
                                    
                                    <p style="font-size: 14px; line-height: 1.6;">Please keep this email safe as it contains your reference code. We look forward to welcoming you at the venue!</p>
                                </div>
                                <div class="footer">
                                    This is an automated confirmation receipt. For any assistance, contact us at <a href="mailto:' . htmlspecialchars($mail_email) . '" style="color: #ad071b;">' . htmlspecialchars($mail_email) . '</a> or call ' . htmlspecialchars($mail_phone) . '.<br><br>
                                    &copy; ' . date('Y') . ' Hotel Managers Conference Africa. All rights reserved.
                                </div>
                            </div>
                        </div>
                    </body>
                    </html>';

                    SmtpMailer::send($r['email'], $email_subject, $email_body);
                }
                
                header("Location: tickets?status=confirmed&reference=" . urlencode($reference));
                exit;
            } catch (PDOException $e) {
                $error_msg = 'Payment verified, but database update failed: ' . $e->getMessage();
            }
        }
    } else {
        $error_msg = 'Payment verification failed: ' . htmlspecialchars($verify_result['message']);
    }
}

$page_title = 'Buy Tickets | HMC Africa';
require_once 'header.php';

// Fetch active bank details
$bank_name = 'Zenith Bank';
$bank_acc_num = '1017482811';
$bank_acc_name = 'Hotel Managers Conference';
$paystack_public_key_val = '';
$tickets_list = [];
$international_tickets = [];

if ($pdo) {
    try {
        $tickets_list = $pdo->query("SELECT * FROM `tickets` WHERE `is_international` = 0 ORDER BY `id` ASC")->fetchAll();
        $international_tickets = $pdo->query("SELECT * FROM `tickets` WHERE `is_international` = 1 ORDER BY `id` ASC")->fetchAll();
        
        $stmt_bk = $pdo->query("SELECT `name`, `value` FROM `settings` WHERE `name` IN ('bank_name', 'bank_account_number', 'bank_account_name', 'paystack_public_key')");
        $bk_settings = $stmt_bk->fetchAll(PDO::FETCH_KEY_PAIR);
        if (isset($bk_settings['bank_name']) && !empty($bk_settings['bank_name'])) $bank_name = $bk_settings['bank_name'];
        if (isset($bk_settings['bank_account_number']) && !empty($bk_settings['bank_account_number'])) $bank_acc_num = $bk_settings['bank_acc_num'] = $bk_settings['bank_account_number'];
        if (isset($bk_settings['bank_account_name']) && !empty($bk_settings['bank_account_name'])) $bank_acc_name = $bk_settings['bank_account_name'];
        if (isset($bk_settings['paystack_public_key'])) $paystack_public_key_val = trim($bk_settings['paystack_public_key']);
    } catch (PDOException $e) {
        // Fallback
    }
}
?>

<!-- SUBPAGE HERO -->
<section class="sub-hero">
<div class="container">
<h1 class="sub-hero-title">Reserve Your <span class="shine">Seat</span></h1>
<div class="sub-hero-breadcrumbs">
<a href="./">Home</a> &nbsp;»&nbsp; Buy Tickets
</div>
</div>
</section>

<!-- TICKETS & FORM SECTION -->
<section style="background: var(--white); padding: 80px 0;">
<div class="container">
    <div class="grid-hero tickets-main-grid" style="grid-template-columns: 1.1fr 0.9fr; gap: 48px; align-items: start;">
        
        <!-- LEFT COLUMN: TICKET INFORMATION -->
        <div>
            <div class="section-eyebrow eyebrow-light">Available Passes</div>
            <h2 class="font-display" style="font-size: 32px; color: var(--maroon-900); margin-bottom: 24px; line-height: 1.2;">
                Choose Your Access Tier
            </h2>

            <style>
            .tickets-list {
                display: flex;
                flex-direction: column;
                gap: 20px;
            }
            .ticket-list-item {
                border: 1.5px solid var(--maroon-100);
                border-radius: 12px;
                padding: 24px;
                background: var(--cream);
                transition: all 0.25s ease;
                cursor: pointer;
            }
            .ticket-list-item:hover {
                border-color: var(--gold-400);
                box-shadow: 0 8px 24px rgba(0,0,0,0.05);
            }
            .ticket-list-item.selected {
                border-color: var(--gold-500);
                background: var(--white);
                box-shadow: 0 8px 30px rgba(212,175,55,0.15);
            }
            .ticket-list-header {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-bottom: 12px;
            }
            .ticket-list-name {
                font-family: 'Playfair Display', serif;
                font-size: 20px;
                color: var(--maroon-950);
                font-weight: 700;
            }
            .ticket-list-price {
                font-family: 'Playfair Display', serif;
                font-size: 22px;
                color: var(--gold-600);
                font-weight: 700;
            }
            .ticket-list-features {
                margin-top: 12px;
                padding-top: 12px;
                border-top: 1px dashed var(--maroon-200);
                font-size: 13px;
                color: rgba(45,26,16,0.7);
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 8px;
            }
            .ticket-form-card {
                background: var(--maroon-950);
                color: var(--cream);
                border-radius: 20px;
                padding: 36px;
                border: 1px solid rgba(212,175,55,0.25);
                position: sticky;
                top: 100px;
            }
            .form-group {
                margin-bottom: 20px;
            }
            .form-label {
                display: block;
                font-size: 11px;
                text-transform: uppercase;
                letter-spacing: 0.12em;
                color: var(--gold-300);
                margin-bottom: 6px;
                font-weight: 600;
            }
            .form-input {
                width: 100%;
                background: rgba(255,255,255,0.05);
                border: 1px solid rgba(212,175,55,0.3);
                border-radius: 8px;
                padding: 12px;
                color: var(--cream);
                font-family: 'Inter', sans-serif;
                font-size: 14px;
                transition: border-color 0.2s;
            }
            .form-input:focus {
                outline: none;
                border-color: var(--gold-400);
            }
            .form-select {
                width: 100%;
                background: var(--maroon-900);
                border: 1px solid rgba(212,175,55,0.3);
                border-radius: 8px;
                padding: 12px;
                color: var(--cream);
                font-family: 'Inter', sans-serif;
                font-size: 14px;
                cursor: pointer;
            }
            .form-select:focus {
                outline: none;
                border-color: var(--gold-400);
            }
            .alert {
                border-radius: 10px;
                padding: 16px 20px;
                font-size: 14px;
                margin-bottom: 24px;
                line-height: 1.6;
            }
            .alert-danger {
                background: #fdf2f2;
                border: 1px solid #f8b4b4;
                color: #9b1c1c;
            }
            .alert-success {
                background: #f3faf7;
                border: 1px solid #def7ec;
                color: #03543f;
            }
            @media (max-width: 600px) {
                .ticket-list-features {
                    grid-template-columns: 1fr;
                }
                .ticket-list-header {
                    flex-direction: column;
                    align-items: flex-start;
                    gap: 6px;
                }
                .ticket-form-card {
                    padding: 24px 20px;
                }
            }
            .payment-section {
                margin-top: 24px;
                padding-top: 24px;
                border-top: 1px solid rgba(212,175,55,0.2);
                display: none;
                animation: slideDown 0.4s ease forwards;
            }
            @keyframes slideDown {
                from { opacity: 0; transform: translateY(-10px); }
                to { opacity: 1; transform: translateY(0); }
            }
            .payment-title {
                font-size: 12px;
                font-weight: 600;
                color: var(--gold-300);
                margin-bottom: 16px;
                text-transform: uppercase;
                letter-spacing: 0.08em;
                text-align: center;
            }
            .payment-options-grid {
                display: grid;
                grid-template-columns: 1fr;
                gap: 16px;
            }
            @media (min-width: 480px) {
                .payment-options-grid {
                    grid-template-columns: 1fr 1fr;
                }
            }
            .payment-card {
                background: rgba(255, 255, 255, 0.03);
                border: 1.5px solid rgba(212, 175, 55, 0.2);
                border-radius: 12px;
                padding: 16px 12px;
                text-align: center;
                cursor: pointer;
                transition: all 0.25s ease;
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: flex-start;
            }
            .payment-card:hover {
                border-color: var(--gold-400);
                background: rgba(255, 255, 255, 0.08);
                transform: translateY(-2px);
                box-shadow: 0 6px 15px rgba(0,0,0,0.15);
            }
            .payment-card.selected {
                border-color: var(--gold-400);
                background: rgba(212, 175, 55, 0.1);
            }
            .payment-card img {
                height: 32px;
                max-width: 100%;
                object-fit: contain;
                margin-bottom: 12px;
            }
            .payment-card-title {
                font-size: 13px;
                font-weight: 700;
                color: var(--white);
                margin-bottom: 6px;
            }
            .payment-card-desc {
                font-size: 10px;
                color: rgba(253, 247, 240, 0.65);
                line-height: 1.3;
            }
            .bank-info-box {
                margin-top: 20px;
                background: rgba(212, 175, 55, 0.06);
                border: 1px dashed var(--gold-400);
                border-radius: 10px;
                padding: 16px;
                font-size: 12px;
                color: var(--cream);
                display: none;
                animation: fadeIn 0.3s ease;
            }
            .bank-details-row {
                display: flex;
                justify-content: space-between;
                margin-bottom: 8px;
                border-bottom: 1px solid rgba(255,255,255,0.05);
                padding-bottom: 6px;
            }
            .bank-details-row:last-child {
                border-bottom: none;
                margin-bottom: 0;
                padding-bottom: 0;
            }
            .bank-label {
                color: var(--gold-200);
                font-weight: 500;
            }
            .bank-value {
                font-family: monospace;
                font-weight: bold;
                color: var(--white);
                font-size: 13px;
            }
            @keyframes fadeIn {
                from { opacity: 0; }
                to { opacity: 1; }
            }
            </style>

            <div class="tickets-list">
                <?php if (empty($tickets_list)): ?>
                    <p style="text-align: center; color: var(--gold-600); font-weight: 600;">No ticket classes configured.</p>
                <?php else: ?>
                    <?php foreach ($tickets_list as $index => $t): ?>
                        <?php 
                            $is_selected = false;
                            if (isset($_GET['ticket_type'])) {
                                if (urldecode($_GET['ticket_type']) === $t['name']) {
                                    $is_selected = true;
                                }
                            } else {
                                if ($index === 0) {
                                    $is_selected = true;
                                }
                            }
                            $selected_class = $is_selected ? 'selected' : '';
                        ?>
                        <div class="ticket-list-item select-ticket-trigger <?php echo $selected_class; ?>" data-type="<?php echo htmlspecialchars($t['name']); ?>">
                            <?php if (!empty($t['image'])): ?>
                                <div style="margin: -24px -24px 16px; border-radius: 12px 12px 0 0; overflow: hidden; height: 130px;">
                                    <img src="<?php echo htmlspecialchars($t['image']); ?>" alt="<?php echo htmlspecialchars($t['name']); ?>" style="width: 100%; height: 100%; object-fit: cover; display: block;">
                                </div>
                            <?php endif; ?>
                            <div class="ticket-list-header">
                                <span class="ticket-list-name"><?php echo htmlspecialchars($t['name']); ?></span>
                                <span class="ticket-list-price">
                                    <?php echo htmlspecialchars($t['price_ngn']); ?>
                                    <?php if (!empty($t['price_usd']) && $t['price_usd'] !== $t['price_ngn']): ?>
                                        / <?php echo htmlspecialchars($t['price_usd']); ?>
                                    <?php endif; ?>
                                </span>
                            </div>
                            <p style="font-size:13px; color:rgba(45,26,16,0.65);"><?php echo htmlspecialchars($t['description']); ?></p>
                            <div class="ticket-list-features">
                                <?php 
                                    $feats = explode("\n", $t['features']);
                                    foreach ($feats as $f) {
                                        $f = trim($f);
                                        if (!empty($f)) {
                                            echo "<div>✓ " . htmlspecialchars($f) . "</div>";
                                        }
                                    }
                                ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
            
            <div style="margin-top: 32px; background: var(--cream); border-radius: 12px; padding: 24px; font-size: 13px; line-height: 1.6; color: rgba(45,26,16,0.75); border: 1px solid var(--maroon-100);">
                <strong>Group Discounts &amp; Tables:</strong> Corporate reservations of 5 seats or more qualify for our Corporate Table rate of ₦650,000. For custom corporate tables or sponsorship options, please reach out directly at <a href="mailto:<?php echo htmlspecialchars($email); ?>"><?php echo htmlspecialchars($email); ?></a> or via phone call.
            </div>

            <?php if (!empty($international_tickets)): ?>
                <div style="margin-top: 48px;">
                    <h3 class="font-display" style="font-size: 22px; color: var(--maroon-900); margin-bottom: 20px; text-transform: uppercase; letter-spacing: 0.05em;">🌍 International Delegate Packages</h3>
                    <div class="tickets-list">
                        <?php foreach ($international_tickets as $t): ?>
                            <?php 
                                $is_selected = false;
                                if (isset($_GET['ticket_type'])) {
                                    if (urldecode($_GET['ticket_type']) === $t['name']) {
                                        $is_selected = true;
                                    }
                                }
                                $selected_class = $is_selected ? 'selected' : '';
                            ?>
                            <div class="ticket-list-item select-ticket-trigger <?php echo $selected_class; ?>" data-type="<?php echo htmlspecialchars($t['name']); ?>">
                                <?php if (!empty($t['image'])): ?>
                                    <div style="margin: -24px -24px 16px; border-radius: 12px 12px 0 0; overflow: hidden; height: 130px;">
                                        <img src="<?php echo htmlspecialchars($t['image']); ?>" alt="<?php echo htmlspecialchars($t['name']); ?>" style="width: 100%; height: 100%; object-fit: cover; display: block;">
                                    </div>
                                <?php endif; ?>
                                <div class="ticket-list-header">
                                    <span class="ticket-list-name"><?php echo htmlspecialchars($t['name']); ?></span>
                                    <span class="ticket-list-price">
                                        <?php echo htmlspecialchars($t['price_ngn']); ?>
                                        <?php if (!empty($t['price_usd']) && $t['price_usd'] !== $t['price_ngn']): ?>
                                            / <?php echo htmlspecialchars($t['price_usd']); ?>
                                        <?php endif; ?>
                                    </span>
                                </div>
                                <p style="font-size:13px; color:rgba(45,26,16,0.65);"><?php echo htmlspecialchars($t['description']); ?></p>
                                <div class="ticket-list-features">
                                    <?php 
                                        $feats = explode("\n", $t['features']);
                                        foreach ($feats as $f) {
                                            $f = trim($f);
                                            if (!empty($f)) {
                                                echo "<div>✓ " . htmlspecialchars($f) . "</div>";
                                            }
                                        }
                                    ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <!-- RIGHT COLUMN: REGISTRATION FORM & PAYMENT -->
        <div>
            <div class="ticket-form-card" id="reservation-card-container">
                <?php if (isset($_GET['status']) && $_GET['status'] === 'confirmed' && isset($_GET['reference'])): ?>
                    <!-- Success Paystack Screen -->
                    <div style="text-align: center; padding: 20px 10px;">
                        <div style="font-size: 56px; color: #22c55e; margin-bottom: 20px;">✓</div>
                        <h3 class="font-display" style="font-size: 24px; color: var(--gold-200); margin-bottom: 12px;">Seat Reserved!</h3>
                        <p style="font-size: 14px; color: var(--cream); line-height: 1.6; margin-bottom: 24px;">
                            Thank you! Your transaction has been processed instantly using Paystack. Your seat at the conference is fully confirmed.
                        </p>
                        <div style="background: rgba(255,255,255,0.05); border: 1px solid rgba(212,175,55,0.3); border-radius: 8px; padding: 16px; margin-bottom: 24px; text-align: left;">
                            <div style="display:flex; justify-content:space-between; margin-bottom:8px; font-size:12px;">
                                <span style="color:var(--gold-300);">Reference:</span>
                                <span style="font-family:monospace; color:var(--white);"><?php echo htmlspecialchars($_GET['reference']); ?></span>
                            </div>
                            <div style="display:flex; justify-content:space-between; font-size:12px;">
                                <span style="color:var(--gold-300);">Status:</span>
                                <span style="color:#22c55e; font-weight:bold;">CONFIRMED</span>
                            </div>
                        </div>
                        <a href="tickets" class="btn-primary" style="display:inline-flex; width: 100%; border: none; justify-content: center; font-size: 13px; padding: 14px; text-decoration:none;">Reserve Another Seat →</a>
                    </div>
                <?php elseif (isset($_GET['status']) && $_GET['status'] === 'bank_pending' && isset($_GET['reference'])): ?>
                    <!-- Success Bank Screen -->
                    <div style="padding: 10px 0;">
                        <div style="font-size: 56px; color: var(--gold-300); margin-bottom: 20px; text-align: center;">🏦</div>
                        <h3 class="font-display" style="font-size: 24px; color: var(--gold-200); margin-bottom: 12px; text-align: center;">Reservation Logged!</h3>
                        <p style="font-size: 13px; color: var(--cream); line-height: 1.6; margin-bottom: 20px; text-align: center;">
                            Your reservation is pending manual review. Please complete the bank transfer of your ticket price to finalize your booking.
                        </p>
                        
                        <div style="background: rgba(255,255,255,0.05); border: 1px solid rgba(212,175,55,0.3); border-radius: 8px; padding: 16px; margin-bottom: 20px;">
                            <div class="bank-details-row" style="display:flex; justify-content:space-between; margin-bottom:8px; font-size:12px; border-bottom: 1px dashed rgba(255,255,255,0.1); padding-bottom:6px;">
                                <span style="color:var(--gold-300);">Bank Name:</span>
                                <span style="color:var(--white); font-weight:600;"><?php echo htmlspecialchars($bank_name); ?></span>
                            </div>
                            <div class="bank-details-row" style="display:flex; justify-content:space-between; margin-bottom:8px; font-size:12px; border-bottom: 1px dashed rgba(255,255,255,0.1); padding-bottom:6px;">
                                <span style="color:var(--gold-300);">Account Number:</span>
                                <span style="color:var(--white); font-weight:600; font-family:monospace; font-size:13px;"><?php echo htmlspecialchars($bank_acc_num); ?></span>
                            </div>
                            <div class="bank-details-row" style="display:flex; justify-content:space-between; margin-bottom:8px; font-size:12px; border-bottom: 1px dashed rgba(255,255,255,0.1); padding-bottom:6px;">
                                <span style="color:var(--gold-300);">Account Name:</span>
                                <span style="color:var(--white); font-weight:600;"><?php echo htmlspecialchars($bank_acc_name); ?></span>
                            </div>
                            <div class="bank-details-row" style="display:flex; justify-content:space-between; font-size:12px;">
                                <span style="color:var(--gold-300);">Payment Reference:</span>
                                <span style="color:var(--white); font-weight:600; font-family:monospace;"><?php echo htmlspecialchars($_GET['reference']); ?></span>
                            </div>
                        </div>

                        <p style="font-size: 11px; color: rgba(253, 247, 240, 0.7); line-height: 1.5; margin-bottom: 20px; text-align: center;">
                            Please use the <strong>Payment Reference</strong> above as your transfer description. Someone from our logistics team will contact you once the payment is verified.
                        </p>

                        <a href="tickets" class="btn-primary" style="display:inline-flex; width: 100%; border: none; justify-content: center; font-size: 13px; padding: 14px; text-decoration:none;">Book Another Seat →</a>
                    </div>
                <?php else: ?>
                    <!-- Standard Registration Form (rendered inside container) -->
                    <h3 class="font-display" style="font-size: 24px; color: var(--gold-200); margin-bottom: 24px; border-bottom: 1px solid rgba(212,175,55,0.2); padding-bottom: 12px;">Seat Reservation</h3>
                    
                    <?php if (!empty($error_msg)): ?>
                        <div class="alert alert-danger" id="form-error-alert"><?php echo $error_msg; ?></div>
                    <?php endif; ?>
                    
                    <div class="alert alert-danger" id="js-error-alert" style="display:none; background:#fdf2f2; border: 1px solid #f8b4b4; color:#9b1c1c; border-radius:10px; padding:16px 20px; font-size:14px; margin-bottom:24px;"></div>

                    <form id="reservation-form" method="POST" action="tickets">
                        <div class="form-group">
                            <label class="form-label" for="fullname">Full Name *</label>
                            <input type="text" name="fullname" id="fullname" class="form-input" required placeholder="e.g. John Doe" value="">
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="email">Work Email *</label>
                            <input type="email" name="email" id="email" class="form-input" required placeholder="e.g. name@property.com" value="">
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="phone">Phone Number *</label>
                            <input type="tel" name="phone" id="phone" class="form-input" required placeholder="e.g. +234 911 236 8692" value="">
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="org">Organization / Hotel Name</label>
                            <input type="text" name="org" id="org" class="form-input" placeholder="e.g. Lagos Continental Hotel" value="">
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="ticket_type">Selected Pass Tier *</label>
                            <select name="ticket_type" id="ticket_type" class="form-select" required>
                                <?php 
                                $all_tickets = array_merge($tickets_list, $international_tickets);
                                foreach ($all_tickets as $t): 
                                    $is_selected = false;
                                    if (isset($_GET['ticket_type'])) {
                                        if (urldecode($_GET['ticket_type']) === $t['name']) $is_selected = true;
                                    }
                                ?>
                                    <option value="<?php echo htmlspecialchars($t['name']); ?>" <?php echo $is_selected ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($t['name']); ?> (<?php echo htmlspecialchars($t['price_ngn']); ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <button type="submit" id="submit-btn" class="btn-primary" style="width: 100%; border: none; justify-content: center; font-size: 13px; padding: 16px; cursor: pointer;">Submit Seat Reservation →</button>
                    </form>

                    <!-- Payment Options Panel (dynamically expanded below submit button via JS) -->
                    <div id="payment-methods-section" class="payment-section">
                        <div class="payment-title">Select Payment Method</div>
                        <div class="payment-options-grid">
                            <!-- Option 1: Paystack -->
                            <?php if (!empty($paystack_public_key_val)): ?>
                                <div class="payment-card" id="paystack-card">
                                    <img src="images/Paystack.png" alt="Pay with Paystack">
                                    <div class="payment-card-title">Paystack Checkout</div>
                                    <div class="payment-card-desc">Automatic Instant payment and confirmation using Paystack</div>
                                </div>
                            <?php else: ?>
                                <div class="payment-card disabled" id="paystack-card" style="opacity: 0.55; cursor: not-allowed; pointer-events: none; border-color: rgba(255,255,255,0.1);">
                                    <img src="images/Paystack.png" alt="Pay with Paystack" style="filter: grayscale(1);">
                                    <div class="payment-card-title" style="color: rgba(255,255,255,0.4);">Paystack Checkout</div>
                                    <div class="payment-card-desc" style="color: #f87171; font-weight: 500;">Paystack is not available right now, use bank transfer payment</div>
                                </div>
                            <?php endif; ?>
                            
                            <!-- Option 2: Bank Transfer -->
                            <div class="payment-card" id="bank-card">
                                <img src="images/bank.png" alt="Pay with Bank Transfer">
                                <div class="payment-card-title">Bank Transfer</div>
                                <div class="payment-card-desc">Transfer directly to our account and someone will reach out to you</div>
                            </div>
                        </div>
                        
                        <!-- Bank Coordinates (hidden until Bank Transfer is selected) -->
                        <div class="bank-info-box" id="bank-details-box">
                            <h4 style="font-size: 12px; font-weight:700; color:var(--gold-300); margin-bottom:12px; text-transform:uppercase; letter-spacing:0.04em;">🏦 Bank Transfer Coordinates</h4>
                            
                            <div class="bank-details-row">
                                <span class="bank-label">Bank Name:</span>
                                <span class="bank-value" style="font-family:'Inter', sans-serif;"><?php echo htmlspecialchars($bank_name); ?></span>
                            </div>
                            
                            <div class="bank-details-row">
                                <span class="bank-label">Account No:</span>
                                <span class="bank-value" id="bank-display-acc"><?php echo htmlspecialchars($bank_acc_num); ?></span>
                            </div>
                            
                            <div class="bank-details-row">
                                <span class="bank-label">Account Name:</span>
                                <span class="bank-value" style="font-family:'Inter', sans-serif;"><?php echo htmlspecialchars($bank_acc_name); ?></span>
                            </div>
                            
                            <div class="bank-details-row">
                                <span class="bank-label">Ref Code:</span>
                                <span class="bank-value" id="bank-display-ref" style="color:var(--gold-300);"></span>
                            </div>
                            
                            <p style="font-size: 10px; color: rgba(253, 247, 240, 0.65); line-height: 1.4; margin-top: 12px; text-align: center;">
                                Please use the <strong>Ref Code</strong> above as the transaction description. We will reach out to confirm your booking.
                            </p>
                            
                            <button type="button" id="confirm-bank-transfer-btn" class="btn-primary" style="width: 100%; border: none; justify-content: center; font-size: 12px; padding: 12px; cursor: pointer; margin-top: 14px; background:var(--gold-500); color:var(--maroon-950);">I Have Completed the Transfer →</button>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>

    </div>
</div>
</section>

<script src="https://js.paystack.co/v1/inline.js"></script>
<script>
// JavaScript to sync selected ticket type with the select input in the form and handle payment integration
document.addEventListener('DOMContentLoaded', function() {
    var ticketCards = document.querySelectorAll('.select-ticket-trigger');
    var selectField = document.getElementById('ticket_type');

    ticketCards.forEach(function(card) {
        card.addEventListener('click', function() {
            // Remove selected class from others
            ticketCards.forEach(function(c) { c.classList.remove('selected'); });
            // Add to clicked card
            card.classList.add('selected');
            
            // Get data-type attribute
            var type = card.getAttribute('data-type');
            if (selectField) {
                // Find matching option
                for (var i = 0; i < selectField.options.length; i++) {
                    if (selectField.options[i].value === type) {
                        selectField.selectedIndex = i;
                        break;
                    }
                }
            }
        });
    });

    // Handle AJAX form submission and payment methods slide down
    var resForm = document.getElementById('reservation-form');
    var submitBtn = document.getElementById('submit-btn');
    var paymentSection = document.getElementById('payment-methods-section');
    var jsErrorAlert = document.getElementById('js-error-alert');
    var reservationContext = null;

    if (resForm) {
        resForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            jsErrorAlert.style.display = 'none';
            jsErrorAlert.textContent = '';
            submitBtn.disabled = true;
            submitBtn.textContent = 'Processing Seat Reservation...';

            var formData = new FormData(resForm);
            
            fetch('tickets?action=reserve', {
                method: 'POST',
                body: formData
            })
            .then(function(res) {
                return res.json();
            })
            .then(function(data) {
                if (data.success) {
                    reservationContext = data;
                    
                    // Disable form fields
                    var inputs = resForm.querySelectorAll('.form-input, .form-select');
                    inputs.forEach(function(inp) {
                        inp.disabled = true;
                    });
                    
                    // Update submit button style and label
                    submitBtn.style.background = '#059669';
                    submitBtn.textContent = '✓ Reservation Logged';
                    
                    // Show payment options
                    paymentSection.style.display = 'block';
                    
                    // Sync reference display
                    var refDisplay = document.getElementById('bank-display-ref');
                    if (refDisplay) refDisplay.textContent = data.reference;
                } else {
                    submitBtn.disabled = false;
                    submitBtn.textContent = 'Submit Seat Reservation →';
                    jsErrorAlert.textContent = data.message || 'An error occurred logging your reservation.';
                    jsErrorAlert.style.display = 'block';
                    jsErrorAlert.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
            })
            .catch(function(err) {
                submitBtn.disabled = false;
                submitBtn.textContent = 'Submit Seat Reservation →';
                jsErrorAlert.textContent = 'Network connection failed. Please check your connectivity and try again.';
                jsErrorAlert.style.display = 'block';
            });
        });
    }

    // Paystack option click handler
    var paystackCard = document.getElementById('paystack-card');
    if (paystackCard) {
        paystackCard.addEventListener('click', function() {
            if (!reservationContext) return;
            
            if (!reservationContext.paystack_public_key) {
                alert('Paystack gateway credentials are not configured. Please proceed with Bank Transfer.');
                return;
            }
            
            // Highlight selected card
            paystackCard.classList.add('selected');
            var bankCard = document.getElementById('bank-card');
            if (bankCard) bankCard.classList.remove('selected');
            var bankDetailsBox = document.getElementById('bank-details-box');
            if (bankDetailsBox) bankDetailsBox.style.display = 'none';

            var handler = PaystackPop.setup({
                key: reservationContext.paystack_public_key,
                email: reservationContext.email,
                amount: reservationContext.amount_cents,
                currency: reservationContext.currency,
                ref: reservationContext.reference,
                callback: function(response) {
                    window.location.href = 'tickets?action=verify_paystack&reference=' + encodeURIComponent(response.reference);
                },
                onClose: function() {
                    paystackCard.classList.remove('selected');
                    alert('Transaction cancelled. You can retry paying or select bank transfer.');
                }
            });
            handler.openIframe();
        });
    }

    // Bank Transfer option click handler
    var bankCard = document.getElementById('bank-card');
    var bankDetailsBox = document.getElementById('bank-details-box');
    if (bankCard) {
        bankCard.addEventListener('click', function() {
            bankCard.classList.add('selected');
            if (paystackCard) paystackCard.classList.remove('selected');
            
            if (bankDetailsBox) {
                bankDetailsBox.style.display = 'block';
                bankDetailsBox.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
        });
    }

    // Confirm manual transfer button click handler
    var confirmBankBtn = document.getElementById('confirm-bank-transfer-btn');
    if (confirmBankBtn) {
        confirmBankBtn.addEventListener('click', function() {
            if (!reservationContext) return;
            
            confirmBankBtn.disabled = true;
            confirmBankBtn.textContent = 'Recording Transfer...';
            
            var formData = new FormData();
            formData.append('reference', reservationContext.reference);
            
            fetch('tickets?action=choose_bank', {
                method: 'POST',
                body: formData
            })
            .then(function(res) {
                return res.json();
            })
            .then(function(data) {
                if (data.success) {
                    window.location.href = 'tickets?status=bank_pending&reference=' + encodeURIComponent(reservationContext.reference);
                } else {
                    confirmBankBtn.disabled = false;
                    confirmBankBtn.textContent = 'I Have Completed the Transfer →';
                    alert(data.message || 'Failed to update bank payment status.');
                }
            })
            .catch(function() {
                confirmBankBtn.disabled = false;
                confirmBankBtn.textContent = 'I Have Completed the Transfer →';
                alert('Connection failure. Unable to submit payment selection details.');
            });
        });
    }
});
</script>

<?php
require_once 'footer.php';
?>
