<?php
$page_title = 'Manage Seat Reservations';
$page_header = 'Seat Reservations & Ticketing Ledger';
require_once 'admin_header.php';

$action = isset($_GET['action']) ? $_GET['action'] : 'list';
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

$success_message = '';
$error_message = '';

// Handle Status Modifications & Deletions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['update_status'])) {
        $res_id = intval($_POST['reservation_id']);
        $new_status = trim($_POST['status']);
        $new_method = trim($_POST['payment_method']);

        if ($res_id > 0 && in_array($new_status, ['Pending', 'Confirmed', 'Failed'])) {
            try {
                $stmt = $pdo->prepare("UPDATE `reservations` SET `payment_status` = :status, `payment_method` = :method WHERE `id` = :id");
                $stmt->execute([
                    'status' => $new_status,
                    'method' => $new_method,
                    'id' => $res_id
                ]);
                $success_message = 'Reservation details updated successfully.';

                // Fetch reservation details to send status update notification
                $stmt_res = $pdo->prepare("SELECT * FROM `reservations` WHERE `id` = :id");
                $stmt_res->execute(['id' => $res_id]);
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

                    // Choose styling based on new status
                    $status_color = '#d97706'; // Pending (Yellow)
                    $status_bg = '#fdf7f0';
                    $status_border = '#f5e6a3';
                    $status_text_color = '#b45309';
                    
                    if ($new_status === 'Confirmed') {
                        $status_color = '#166534'; // Green
                        $status_bg = '#f0fdf4';
                        $status_border = '#bbf7d0';
                        $status_text_color = '#15803d';
                    } elseif ($new_status === 'Failed') {
                        $status_color = '#991b1b'; // Red
                        $status_bg = '#fef2f2';
                        $status_border = '#fecaca';
                        $status_text_color = '#b91c1c';
                    }

                    $email_subject = "HMC Africa - Seat Reservation Status Updated [{$r['payment_reference']}]";
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
                            .status-box { background-color: ' . $status_bg . '; border: 1.5px solid ' . $status_border . '; border-radius: 8px; padding: 20px; text-align: center; margin-bottom: 30px; }
                            .status-title { font-size: 14px; font-weight: 600; color: #64748b; margin-bottom: 6px; text-transform: uppercase; }
                            .status-badge { font-size: 20px; font-weight: 700; color: ' . $status_text_color . '; }
                            .details-card { background-color: #fcfcfc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 24px; margin-bottom: 30px; }
                            .details-title { font-size: 16px; font-weight: 700; color: #380007; margin-top: 0; margin-bottom: 16px; border-bottom: 1px solid #e2e8f0; padding-bottom: 8px; }
                            .details-row { margin-bottom: 12px; font-size: 14px; line-height: 1.5; }
                            .details-label { font-weight: 600; color: #5c030d; display: inline-block; width: 150px; }
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
                                        We are writing to notify you that your seat reservation status for the 8th Annual Hotel Managers Conference Africa has been updated by our administration team.
                                    </div>
                                    
                                    <div class="status-box">
                                        <div class="status-title">New Reservation Status</div>
                                        <div class="status-badge">' . htmlspecialchars($new_status) . '</div>
                                    </div>

                                    <div class="details-card">
                                        <div class="details-title">Reservation Details</div>
                                        <div class="details-row">
                                            <span class="details-label">Reference Number:</span>
                                            <span class="details-value" style="font-family: monospace; font-weight: 700; color: #ad071b;">' . htmlspecialchars($r['payment_reference']) . '</span>
                                        </div>
                                        <div class="details-row">
                                            <span class="details-label">Access Pass:</span>
                                            <span class="details-value">' . htmlspecialchars($r['ticket_type']) . '</span>
                                        </div>
                                        <div class="details-row">
                                            <span class="details-label">Amount:</span>
                                            <span class="details-value" style="font-weight: 700;">' . htmlspecialchars($r['amount']) . '</span>
                                        </div>
                                        <div class="details-row">
                                            <span class="details-label">Payment Method:</span>
                                            <span class="details-value">' . htmlspecialchars($new_method ?: 'Not Specified') . '</span>
                                        </div>
                                    </div>

                                    ' . ($new_status === 'Confirmed' ? '<p style="font-size:14px; line-height:1.6; color:#166534;"><strong>What this means:</strong> Your seat at the conference is fully secured! Please bring a copy of this email or your reference number to the reception desk for badge pick-up.</p>' : '') . '
                                    ' . ($new_status === 'Failed' ? '<p style="font-size:14px; line-height:1.6; color:#991b1b;"><strong>What this means:</strong> Your reservation status has been marked as failed. If you believe this is an error or need assistance resolving your payment, please contact our support team immediately.</p>' : '') . '
                                    ' . ($new_status === 'Pending' ? '<p style="font-size:14px; line-height:1.6; color:#d97706;"><strong>What this means:</strong> Your reservation is currently awaiting verification or receipt of payment.</p>' : '') . '

                                    <div class="event-info">
                                        <div class="event-info-title">📅 Event Schedule & Location</div>
                                        <strong>Date:</strong> ' . htmlspecialchars($mail_event_date) . '<br>
                                        <strong>Venue:</strong> ' . htmlspecialchars($mail_event_loc) . '
                                    </div>
                                </div>
                                <div class="footer">
                                    If you have any questions or need to make changes to your reservation, please reply to this email at <a href="mailto:' . htmlspecialchars($mail_email) . '" style="color: #ad071b;">' . htmlspecialchars($mail_email) . '</a> or call ' . htmlspecialchars($mail_phone) . '.<br><br>
                                    &copy; ' . date('Y') . ' Hotel Managers Conference Africa. All rights reserved.
                                </div>
                            </div>
                        </div>
                    </body>
                    </html>';

                    SmtpMailer::send($r['email'], $email_subject, $email_body);
                }
            } catch (PDOException $e) {
                $error_message = 'Failed to update reservation: ' . $e->getMessage();
            }
        }
    }
}

if ($action === 'delete' && $id > 0) {
    try {
        $stmt = $pdo->prepare("DELETE FROM `reservations` WHERE `id` = :id");
        $stmt->execute(['id' => $id]);
        $success_message = 'Reservation log deleted successfully.';
        $action = 'list';
    } catch (PDOException $e) {
        $error_message = 'Failed to delete reservation: ' . $e->getMessage();
        $action = 'list';
    }
}

// Fetch all for stats
$stats = [
    'total' => 0,
    'confirmed' => 0,
    'pending' => 0,
    'revenue_ngn' => 0,
    'revenue_usd' => 0
];

if ($pdo) {
    try {
        $all_res = $pdo->query("SELECT * FROM `reservations`")->fetchAll();
        foreach ($all_res as $r) {
            $stats['total']++;
            if ($r['payment_status'] === 'Confirmed') {
                $stats['confirmed']++;
                $amt_str = $r['amount'];
                $clean = preg_replace('/[^\d.]/', '', $amt_str);
                $num = floatval($clean);
                if (strpos($amt_str, '$') !== false) {
                    $stats['revenue_usd'] += $num;
                } else {
                    $stats['revenue_ngn'] += $num;
                }
            } elseif ($r['payment_status'] === 'Pending') {
                $stats['pending']++;
            }
        }
    } catch (PDOException $e) {
        // Suppress
    }
}

// Fetch lists based on filters
$status_filter = isset($_GET['status']) ? trim($_GET['status']) : '';
$method_filter = isset($_GET['method']) ? trim($_GET['method']) : '';

$where_clauses = [];
$params = [];

if ($status_filter !== '') {
    $where_clauses[] = "`payment_status` = :status";
    $params['status'] = $status_filter;
}
if ($method_filter !== '') {
    $where_clauses[] = "`payment_method` = :method";
    $params['method'] = $method_filter;
}

$query_str = "SELECT * FROM `reservations`";
if (!empty($where_clauses)) {
    $query_str .= " WHERE " . implode(" AND ", $where_clauses);
}
$query_str .= " ORDER BY `created_at` DESC";

$reservations = [];
if ($pdo) {
    try {
        $stmt = $pdo->prepare($query_str);
        $stmt->execute($params);
        $reservations = $stmt->fetchAll();
    } catch (PDOException $e) {
        $error_message = 'Failed to load reservations list: ' . $e->getMessage();
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

<!-- STATS CARDS GRID -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 20px; margin-bottom: 28px;">
    <!-- Stat 1: Total Reservations -->
    <div style="background: var(--white); border-radius: 12px; border: 1px solid rgba(0, 0, 0, 0.05); padding: 20px; display: flex; align-items: center; justify-content: space-between; box-shadow: 0 4px 15px rgba(0,0,0,0.02);">
        <div>
            <p style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.08em; color: #64748b; font-weight: 600; margin-bottom: 4px;">Total Bookings</p>
            <h3 style="font-size: 26px; color: var(--maroon-900); font-family: 'Playfair Display', serif; font-weight: 700;"><?php echo $stats['total']; ?></h3>
        </div>
        <div style="width: 48px; height: 48px; background: rgba(56, 0, 7, 0.06); color: var(--maroon-900); border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 22px;">📋</div>
    </div>
    
    <!-- Stat 2: Confirmed Tiers -->
    <div style="background: var(--white); border-radius: 12px; border: 1px solid rgba(0, 0, 0, 0.05); padding: 20px; display: flex; align-items: center; justify-content: space-between; box-shadow: 0 4px 15px rgba(0,0,0,0.02);">
        <div>
            <p style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.08em; color: #64748b; font-weight: 600; margin-bottom: 4px;">Confirmed Seats</p>
            <h3 style="font-size: 26px; color: #166534; font-family: 'Playfair Display', serif; font-weight: 700;"><?php echo $stats['confirmed']; ?> <span style="font-size: 12px; font-family: 'Inter', sans-serif; font-weight: 500; color: #64748b;">(<?php echo $stats['total'] > 0 ? round(($stats['confirmed'] / $stats['total']) * 100) : 0; ?>%)</span></h3>
        </div>
        <div style="width: 48px; height: 48px; background: rgba(34, 197, 94, 0.1); color: #166534; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 22px;">✅</div>
    </div>

    <!-- Stat 3: NGN Revenue -->
    <div style="background: var(--white); border-radius: 12px; border: 1px solid rgba(0, 0, 0, 0.05); padding: 20px; display: flex; align-items: center; justify-content: space-between; box-shadow: 0 4px 15px rgba(0,0,0,0.02);">
        <div>
            <p style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.08em; color: #64748b; font-weight: 600; margin-bottom: 4px;">NGN Revenue</p>
            <h3 style="font-size: 24px; color: var(--gold-600); font-family: 'Playfair Display', serif; font-weight: 700;">₦<?php echo number_format($stats['revenue_ngn']); ?></h3>
        </div>
        <div style="width: 48px; height: 48px; background: rgba(212, 175, 55, 0.1); color: var(--gold-600); border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 22px;">💰</div>
    </div>

    <!-- Stat 4: USD Revenue -->
    <div style="background: var(--white); border-radius: 12px; border: 1px solid rgba(0, 0, 0, 0.05); padding: 20px; display: flex; align-items: center; justify-content: space-between; box-shadow: 0 4px 15px rgba(0,0,0,0.02);">
        <div>
            <p style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.08em; color: #64748b; font-weight: 600; margin-bottom: 4px;">USD Revenue</p>
            <h3 style="font-size: 24px; color: #1e40af; font-family: 'Playfair Display', serif; font-weight: 700;">$<?php echo number_format($stats['revenue_usd']); ?></h3>
        </div>
        <div style="width: 48px; height: 48px; background: #eff6ff; color: #1e40af; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 22px;">🌍</div>
    </div>
</div>

<!-- FILTER CARD -->
<div class="card" style="padding: 16px 24px; margin-bottom: 24px;">
    <form method="GET" action="reservations.php" style="display: flex; flex-wrap: wrap; gap: 16px; align-items: flex-end;">
        <div style="flex: 1; min-width: 150px;">
            <label class="form-label" for="status">Filter by Status</label>
            <select name="status" id="status" class="form-select" style="padding: 8px 12px;">
                <option value="">All Statuses</option>
                <option value="Pending" <?php echo ($status_filter === 'Pending') ? 'selected' : ''; ?>>Pending</option>
                <option value="Confirmed" <?php echo ($status_filter === 'Confirmed') ? 'selected' : ''; ?>>Confirmed</option>
                <option value="Failed" <?php echo ($status_filter === 'Failed') ? 'selected' : ''; ?>>Failed</option>
            </select>
        </div>
        
        <div style="flex: 1; min-width: 150px;">
            <label class="form-label" for="method">Payment Method</label>
            <select name="method" id="method" class="form-select" style="padding: 8px 12px;">
                <option value="">All Methods</option>
                <option value="Paystack" <?php echo ($method_filter === 'Paystack') ? 'selected' : ''; ?>>Paystack</option>
                <option value="Bank Transfer" <?php echo ($method_filter === 'Bank Transfer') ? 'selected' : ''; ?>>Bank Transfer</option>
            </select>
        </div>

        <div style="display: flex; gap: 8px;">
            <button type="submit" class="btn btn-primary" style="padding: 8px 16px; font-size: 12px; height: 38px;">Apply Filters</button>
            <a href="reservations.php" class="btn btn-secondary" style="padding: 8px 16px; font-size: 12px; height: 38px; display: flex; align-items: center; justify-content: center;">Reset</a>
        </div>
    </form>
</div>

<!-- LEDGER TABLE CARD -->
<div class="card">
    <div class="card-header">
        <h3 class="card-title">🧾 Reservations Ledger</h3>
        <span style="font-size: 12px; color: #64748b; font-weight: 500;">Showing <?php echo count($reservations); ?> transaction logs</span>
    </div>

    <?php if (empty($reservations)): ?>
        <p style="font-size:13px; color:#64748b; text-align:center; padding: 40px 0;">No seat reservations match the current filter requirements.</p>
    <?php else: ?>
        <div class="table-responsive">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Attendee Details</th>
                        <th>Organization</th>
                        <th>Ticket Class</th>
                        <th>Amount</th>
                        <th>Payment Detail</th>
                        <th>Status</th>
                        <th>Registration Date</th>
                        <th style="width: 160px; text-align: right;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($reservations as $r): ?>
                        <?php 
                            $status_class = '';
                            if ($r['payment_status'] === 'Confirmed') {
                                $status_class = 'badge-accredited'; // green-ish in theme or we customize
                            } elseif ($r['payment_status'] === 'Failed') {
                                $status_class = 'btn-danger'; // red
                            } else {
                                $status_class = 'badge-venue'; // yellow
                            }
                        ?>
                        <tr>
                            <td>
                                <strong style="color: var(--maroon-950); display: block; font-size: 14px;"><?php echo htmlspecialchars($r['fullname']); ?></strong>
                                <span style="font-size: 11px; color: #64748b; display: block; margin-top: 2px;">
                                    📧 <?php echo htmlspecialchars($r['email']); ?><br>
                                    📞 <?php echo htmlspecialchars($r['phone']); ?>
                                </span>
                            </td>
                            <td>
                                <?php echo !empty($r['org']) ? htmlspecialchars($r['org']) : '<span style="color:#94a3b8; font-style:italic;">Not Specified</span>'; ?>
                            </td>
                            <td style="font-weight: 600; color: var(--maroon-900);">
                                <?php echo htmlspecialchars($r['ticket_type']); ?>
                            </td>
                            <td style="font-weight: 700; color: var(--gold-600);">
                                <?php echo htmlspecialchars($r['amount']); ?>
                            </td>
                            <td>
                                <strong style="font-size: 12px; color: #334155; display: block;">
                                    <?php echo !empty($r['payment_method']) ? htmlspecialchars($r['payment_method']) : '<span style="color:#94a3b8; font-weight:normal;">Unselected</span>'; ?>
                                </strong>
                                <span style="font-family: monospace; font-size: 10px; color: #64748b; display: block; margin-top: 2px;">
                                    Ref: <?php echo !empty($r['payment_reference']) ? htmlspecialchars($r['payment_reference']) : 'N/A'; ?>
                                </span>
                            </td>
                            <td>
                                <?php if ($r['payment_status'] === 'Confirmed'): ?>
                                    <span class="badge" style="background: #dcfce7; color: #15803d; border: 1px solid #bbf7d0;">Confirmed</span>
                                <?php elseif ($r['payment_status'] === 'Failed'): ?>
                                    <span class="badge" style="background: #fee2e2; color: #b91c1c; border: 1px solid #fecaca;">Failed</span>
                                <?php else: ?>
                                    <span class="badge" style="background: #fef3c7; color: #b45309; border: 1px solid #fde68a;">Pending</span>
                                <?php endif; ?>
                            </td>
                            <td style="font-size: 11px; color: #64748b;">
                                <?php echo date('M d, Y h:i A', strtotime($r['created_at'])); ?>
                            </td>
                            <td style="text-align: right;">
                                <!-- Update trigger form -->
                                <button type="button" class="btn btn-gold btn-sm edit-status-trigger" 
                                        data-id="<?php echo $r['id']; ?>"
                                        data-status="<?php echo htmlspecialchars($r['payment_status']); ?>"
                                        data-method="<?php echo htmlspecialchars($r['payment_method']); ?>"
                                        data-name="<?php echo htmlspecialchars($r['fullname']); ?>"
                                        style="margin-bottom: 4px;">Update</button>
                                <a href="reservations.php?action=delete&id=<?php echo $r['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this reservation log for <?php echo htmlspecialchars(addslashes($r['fullname'])); ?>?');" style="margin-bottom: 4px;">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<!-- EDIT STATUS MODAL (styled inline to keep it completely self-contained) -->
<div id="statusModal" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 2000; align-items: center; justify-content: center;">
    <div style="background: var(--white); border-radius: 12px; width: 90%; max-width: 460px; padding: 24px; box-shadow: 0 10px 25px rgba(0,0,0,0.15); animation: zoomIn 0.25s ease;">
        <h3 class="card-title" style="margin-bottom: 16px; border-bottom: 1px solid rgba(0,0,0,0.05); padding-bottom: 12px;">Modify Reservation Status</h3>
        <p style="font-size: 13px; color: #475569; margin-bottom: 16px;">Updating record for: <strong id="modalAttendeeName" style="color: var(--maroon-900);"></strong></p>
        
        <form method="POST" action="reservations.php">
            <input type="hidden" name="update_status" value="1">
            <input type="hidden" name="reservation_id" id="modalResId" value="">
            
            <div class="form-group">
                <label class="form-label" for="modalStatus">Payment Status</label>
                <select name="status" id="modalStatus" class="form-select" required>
                    <option value="Pending">Pending</option>
                    <option value="Confirmed">Confirmed</option>
                    <option value="Failed">Failed</option>
                </select>
            </div>
            
            <div class="form-group">
                <label class="form-label" for="modalMethod">Payment Method Setting</label>
                <select name="payment_method" id="modalMethod" class="form-select">
                    <option value="">Not Selected</option>
                    <option value="Paystack">Paystack</option>
                    <option value="Bank Transfer">Bank Transfer</option>
                </select>
            </div>
            
            <div style="display: flex; gap: 12px; justify-content: flex-end; margin-top: 24px;">
                <button type="button" class="btn btn-secondary btn-sm" id="closeModalBtn">Cancel</button>
                <button type="submit" class="btn btn-primary btn-sm">Save Changes</button>
            </div>
        </form>
    </div>
</div>

<style>
@keyframes zoomIn {
    from { opacity: 0; transform: scale(0.95); }
    to { opacity: 1; transform: scale(1); }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var modal = document.getElementById('statusModal');
    var closeBtn = document.getElementById('closeModalBtn');
    var triggers = document.querySelectorAll('.edit-status-trigger');
    
    triggers.forEach(function(trigger) {
        trigger.addEventListener('click', function() {
            var id = trigger.getAttribute('data-id');
            var status = trigger.getAttribute('data-status');
            var method = trigger.getAttribute('data-method');
            var name = trigger.getAttribute('data-name');
            
            document.getElementById('modalResId').value = id;
            document.getElementById('modalAttendeeName').textContent = name;
            
            // set status
            var statusSel = document.getElementById('modalStatus');
            for(var i=0; i<statusSel.options.length; i++) {
                if(statusSel.options[i].value === status) {
                    statusSel.selectedIndex = i;
                    break;
                }
            }
            
            // set method
            var methodSel = document.getElementById('modalMethod');
            for(var j=0; j<methodSel.options.length; j++) {
                if(methodSel.options[j].value === method) {
                    methodSel.selectedIndex = j;
                    break;
                }
            }
            
            modal.style.display = 'flex';
        });
    });
    
    closeBtn.addEventListener('click', function() {
        modal.style.display = 'none';
    });
    
    // Close if clicking overlay outside modal container
    modal.addEventListener('click', function(e) {
        if (e.target === modal) {
            modal.style.display = 'none';
        }
    });
});
</script>

<?php
require_once 'admin_footer.php';
?>
