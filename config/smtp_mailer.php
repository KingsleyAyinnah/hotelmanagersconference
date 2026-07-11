<?php
// SMTP Mailer Helper for Hotel Managers Conference Africa (HMC Africa)
// Utilises PHPMailer loaded manually from the PHPMailer subdirectory.

require_once __DIR__ . '/PHPMailer/Exception.php';
require_once __DIR__ . '/PHPMailer/PHPMailer.php';
require_once __DIR__ . '/PHPMailer/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class SmtpMailer {
    /**
     * Send an HTML email using SMTP configuration stored in database.
     *
     * @param string $to Recipient email
     * @param string $subject Email subject
     * @param string $body HTML body
     * @return array Array with keys 'success' (bool) and 'message' (string)
     */
    public static function send($to, $subject, $body) {
        global $pdo;

        if (!$pdo) {
            return ['success' => false, 'message' => 'Database connection not available.'];
        }

        try {
            $stmt = $pdo->query("SELECT `name`, `value` FROM `settings` WHERE `name` LIKE 'smtp_%'");
            $settings = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
        } catch (PDOException $e) {
            return ['success' => false, 'message' => 'Failed to fetch SMTP settings from DB: ' . $e->getMessage()];
        }

        $enabled = isset($settings['smtp_enabled']) ? (int)$settings['smtp_enabled'] : 0;
        if (!$enabled) {
            return ['success' => false, 'message' => 'SMTP is not enabled in settings.'];
        }

        $host = isset($settings['smtp_host']) ? trim($settings['smtp_host']) : '';
        $port = isset($settings['smtp_port']) ? (int)$settings['smtp_port'] : 25;
        $username = isset($settings['smtp_username']) ? trim($settings['smtp_username']) : '';
        $password = isset($settings['smtp_password']) ? trim($settings['smtp_password']) : '';
        $secure = isset($settings['smtp_secure']) ? trim(strtolower($settings['smtp_secure'])) : 'none'; // 'ssl', 'tls', or 'none'
        $fromEmail = isset($settings['smtp_from_email']) ? trim($settings['smtp_from_email']) : 'reservations@hotelmanagersconference.com';
        $fromName = isset($settings['smtp_from_name']) ? trim($settings['smtp_from_name']) : 'Hotel Managers Conference Africa';

        if (empty($host)) {
            return ['success' => false, 'message' => 'SMTP Host is not configured.'];
        }

        return self::rawSend($host, $port, $username, $password, $secure, $fromEmail, $fromName, $to, $subject, $body);
    }

    /**
     * Internal raw send function that runs the PHPMailer logic.
     */
    public static function rawSend($host, $port, $username, $password, $secure, $fromEmail, $fromName, $to, $subject, $body) {
        $mail = new PHPMailer(true);

        try {
            // Server settings
            $mail->isSMTP();
            $mail->Host       = $host;
            $mail->Port       = $port;

            // Authentication
            if (!empty($username) && !empty($password)) {
                $mail->SMTPAuth   = true;
                $mail->Username   = $username;
                $mail->Password   = $password;
            } else {
                $mail->SMTPAuth   = false;
            }

            // Encryption
            if ($secure === 'ssl') {
                $mail->SMTPSecure = 'ssl';
            } elseif ($secure === 'tls') {
                $mail->SMTPSecure = 'tls';
            } else {
                $mail->SMTPSecure = '';
                $mail->SMTPAutoTLS = false;
            }

            // Charset and formatting
            $mail->CharSet = 'UTF-8';
            $mail->isHTML(true);

            // Recipients
            $mail->setFrom($fromEmail, $fromName);
            $mail->addAddress($to);

            // Content
            $mail->Subject = $subject;
            $mail->Body    = $body;
            
            // Clean plain text version
            $alt = str_replace(['<br>', '<br/>', '<br />', '</p>'], "\n", $body);
            $alt = strip_tags($alt);
            $mail->AltBody = trim($alt);

            $mail->send();
            return ['success' => true, 'message' => 'Email sent successfully.'];
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Mailer Error: ' . $mail->ErrorInfo];
        }
    }
}
