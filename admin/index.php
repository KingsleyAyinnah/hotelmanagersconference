<?php
$page_title = 'Dashboard Overview';
$page_header = 'Dashboard Overview';
require_once 'admin_header.php';

// Fetch counts for dashboard stats
$speaker_count = 0;
$hotel_count = 0;
$award_count = 0;
$ticket_count = 0;
$gallery_count = 0;

if ($pdo) {
    try {
        $speaker_count = $pdo->query("SELECT COUNT(*) FROM `speakers`")->fetchColumn();
        $hotel_count = $pdo->query("SELECT COUNT(*) FROM `hotels`")->fetchColumn();
        $award_count = $pdo->query("SELECT COUNT(*) FROM `awards`")->fetchColumn();
        $ticket_count = $pdo->query("SELECT COUNT(*) FROM `tickets`")->fetchColumn();
        $gallery_count = $pdo->query("SELECT COUNT(*) FROM `gallery`")->fetchColumn();
    } catch (PDOException $e) {
        // Fallback to zero
    }
}
?>

<style>
    .stats-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 24px;
        margin-bottom: 32px;
    }

    .stat-card {
        background: var(--white);
        border: 1px solid rgba(0, 0, 0, 0.05);
        border-radius: 12px;
        padding: 24px;
        display: flex;
        align-items: center;
        gap: 20px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.02);
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 30px rgba(0,0,0,0.05);
        border-color: rgba(212, 175, 55, 0.3);
    }

    .stat-icon {
        width: 52px;
        height: 52px;
        border-radius: 10px;
        background: rgba(107, 26, 67, 0.08);
        color: var(--maroon-900);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
    }

    .stat-info {
        flex-grow: 1;
    }

    .stat-num {
        font-size: 28px;
        font-weight: 700;
        color: var(--maroon-950);
        line-height: 1.2;
    }

    .stat-label {
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        color: #64748b;
        font-weight: 600;
        margin-top: 4px;
    }

    .quick-actions {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 24px;
    }

    .welcome-banner {
        background: linear-gradient(135deg, var(--maroon-950) 0%, var(--maroon-900) 50%, var(--maroon-800) 100%);
        border: 1px solid var(--gold-400);
        border-radius: 16px;
        padding: 32px;
        color: var(--cream);
        margin-bottom: 32px;
        box-shadow: 0 10px 30px rgba(45, 10, 30, 0.15);
    }

    .welcome-banner h1 {
        font-family: 'Playfair Display', serif;
        font-size: 28px;
        font-weight: 700;
        color: var(--gold-300);
        margin-bottom: 8px;
    }

    .welcome-banner p {
        font-size: 14px;
        opacity: 0.85;
        max-width: 600px;
        line-height: 1.6;
    }

    .action-list {
        list-style: none;
        margin-top: 16px;
    }

    .action-item {
        margin-bottom: 12px;
    }

    .action-link {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 14px 18px;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        color: var(--maroon-950);
        text-decoration: none;
        font-size: 13px;
        font-weight: 600;
        transition: all 0.2s ease;
    }

    .action-link:hover {
        background: var(--white);
        border-color: var(--gold-400);
        transform: translateX(4px);
    }
</style>

<div class="welcome-banner">
    <h1>Welcome, Administrator</h1>
    <p>Use this central command panel to customize and control every aspect of the Hotel Managers Conference Africa 2026. Any changes made here are immediately saved to the MySQL database and updated across the live web portal.</p>
</div>

<!-- Counters Grid -->
<div class="stats-row">
    <div class="stat-card">
        <div class="stat-icon">🎤</div>
        <div class="stat-info">
            <div class="stat-num"><?php echo $speaker_count; ?></div>
            <div class="stat-label">Speakers Loaded</div>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon">🏨</div>
        <div class="stat-info">
            <div class="stat-num"><?php echo $hotel_count; ?></div>
            <div class="stat-label">Partner Hotels</div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon">🏆</div>
        <div class="stat-info">
            <div class="stat-num"><?php echo $award_count; ?></div>
            <div class="stat-label">Awards Categories</div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon">🎟️</div>
        <div class="stat-info">
            <div class="stat-num"><?php echo $ticket_count; ?></div>
            <div class="stat-label">Ticket Passes</div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon">🖼️</div>
        <div class="stat-info">
            <div class="stat-num"><?php echo $gallery_count; ?></div>
            <div class="stat-label">Gallery Items</div>
        </div>
    </div>
</div>

<div class="quick-actions">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Quick Administration Actions</h3>
        </div>
        <p style="font-size:13px; color:#64748b; margin-bottom:12px;">Common workflows for managing the conference resources:</p>
        <ul class="action-list">
            <li class="action-item">
                <a href="settings.php" class="action-link">
                    <span>⚙️ Modify Contact Details & Announcements</span>
                    <span>→</span>
                </a>
            </li>
            <li class="action-item">
                <a href="speakers.php?action=add" class="action-link">
                    <span>🎤 Recruit / Add a Keynote Speaker</span>
                    <span>→</span>
                </a>
            </li>
            <li class="action-item">
                <a href="tickets.php" class="action-link">
                    <span>💳 Setup Paystack Keys & Edit Pricing</span>
                    <span>→</span>
                </a>
            </li>
            <li class="action-item">
                <a href="hotels.php?action=add" class="action-link">
                    <span>🏨 Register a new Partner Accommodation</span>
                    <span>→</span>
                </a>
            </li>
        </ul>
    </div>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">System Status & Environment</h3>
        </div>
        <div class="table-responsive" style="margin-top: 8px;">
            <table class="admin-table">
                <tr>
                    <td style="font-weight: 600; width: 140px;">Database Status</td>
                    <td><span class="badge" style="background:#dcfce7; color:#15803d;">Connected</span></td>
                </tr>
                <tr>
                    <td style="font-weight: 600;">Engine</td>
                    <td>MySQL (PDO Connection)</td>
                </tr>
                <tr>
                    <td style="font-weight: 600;">PHP Version</td>
                    <td><?php echo phpversion(); ?></td>
                </tr>
                <tr>
                    <td style="font-weight: 600;">Active Account</td>
                    <td>hotelmanagersconference@gmail.com</td>
                </tr>
                <tr>
                    <td style="font-weight: 600;">Portal Status</td>
                    <td><span class="badge" style="background:#dbeafe; color:#1e40af;">Production Ready</span></td>
                </tr>
            </table>
        </div>
    </div>
</div>

<?php
require_once 'admin_footer.php';
?>
