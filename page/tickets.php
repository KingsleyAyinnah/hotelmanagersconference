<?php
$page_title = 'Buy Tickets | HMC Africa';
require_once 'header.php';

$tickets_list = [];
if ($pdo) {
    try {
        $tickets_list = $pdo->query("SELECT * FROM `tickets` ORDER BY `id` ASC")->fetchAll();
    } catch (PDOException $e) {
        // Fallback
    }
}

// Form processing logic
$form_submitted = false;
$error_msg = '';
$success_msg = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = isset($_POST['fullname']) ? trim($_POST['fullname']) : '';
    $user_email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $user_phone = isset($_POST['phone']) ? trim($_POST['phone']) : '';
    $organization = isset($_POST['org']) ? trim($_POST['org']) : '';
    $ticket_type = isset($_POST['ticket_type']) ? trim($_POST['ticket_type']) : '';

    if (empty($full_name) || empty($user_email) || empty($user_phone) || empty($ticket_type)) {
        $error_msg = 'Please fill in all required fields marked with an asterisk (*).';
    } else {
        $form_submitted = true;
        $success_msg = 'Thank you, ' . htmlspecialchars($full_name) . '! Your reservation request for a <strong>' . htmlspecialchars($ticket_type) . '</strong> has been logged. An email invoice with bank payment details has been sent to <strong>' . htmlspecialchars($user_email) . '</strong>. Call us directly on ' . htmlspecialchars($phone_number_display) . ' to fast-track your confirmation.';
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
        </div>

        <!-- RIGHT COLUMN: REGISTRATION FORM -->
        <div>
            <div class="ticket-form-card">
                <h3 class="font-display" style="font-size: 24px; color: var(--gold-200); margin-bottom: 24px; border-bottom: 1px solid rgba(212,175,55,0.2); padding-bottom: 12px;">Seat Reservation</h3>
                
                <?php if (!empty($error_msg)): ?>
                    <div class="alert alert-danger"><?php echo $error_msg; ?></div>
                <?php endif; ?>

                <?php if ($form_submitted): ?>
                    <div class="alert alert-success"><?php echo $success_msg; ?></div>
                <?php endif; ?>

                <form method="POST" action="tickets">
                    <div class="form-group">
                        <label class="form-label" for="fullname">Full Name *</label>
                        <input type="text" name="fullname" id="fullname" class="form-input" required placeholder="e.g. John Doe" value="<?php echo isset($_POST['fullname']) && !$form_submitted ? htmlspecialchars($_POST['fullname']) : ''; ?>">
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="email">Work Email *</label>
                        <input type="email" name="email" id="email" class="form-input" required placeholder="e.g. name@property.com" value="<?php echo isset($_POST['email']) && !$form_submitted ? htmlspecialchars($_POST['email']) : ''; ?>">
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="phone">Phone Number *</label>
                        <input type="tel" name="phone" id="phone" class="form-input" required placeholder="e.g. +234 911 236 8692" value="<?php echo isset($_POST['phone']) && !$form_submitted ? htmlspecialchars($_POST['phone']) : ''; ?>">
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="org">Organization / Hotel Name</label>
                        <input type="text" name="org" id="org" class="form-input" placeholder="e.g. Lagos Continental Hotel" value="<?php echo isset($_POST['org']) && !$form_submitted ? htmlspecialchars($_POST['org']) : ''; ?>">
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="ticket_type">Selected Pass Tier *</label>
                        <select name="ticket_type" id="ticket_type" class="form-select" required>
                            <?php foreach ($tickets_list as $t): ?>
                                <?php 
                                    $is_selected = false;
                                    if (isset($_POST['ticket_type'])) {
                                        if ($_POST['ticket_type'] === $t['name']) $is_selected = true;
                                    } elseif (isset($_GET['ticket_type'])) {
                                        if (urldecode($_GET['ticket_type']) === $t['name']) $is_selected = true;
                                    }
                                ?>
                                <option value="<?php echo htmlspecialchars($t['name']); ?>" <?php echo $is_selected ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($t['name']); ?> (<?php echo htmlspecialchars($t['price_ngn']); ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <button type="submit" class="btn-primary" style="width: 100%; border: none; justify-content: center; font-size: 13px; padding: 16px; cursor: pointer;">Submit Seat Reservation →</button>
                </form>
            </div>
        </div>

    </div>
</div>
</section>

<script>
// JavaScript to sync selected ticket type with the select input in the form
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
});
</script>

<?php
require_once 'footer.php';
?>
