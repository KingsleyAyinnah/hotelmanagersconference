<?php
$page_title = 'HMC Africa Awards 2026';
require_once 'header.php';

$awards_list = [];
if ($pdo) {
    try {
        $awards_list = $pdo->query("SELECT * FROM `awards` ORDER BY `id` ASC")->fetchAll();
    } catch (PDOException $e) {
        // Silent fail
    }
}
?>

<!-- SUBPAGE HERO -->
<section class="sub-hero">
<div class="container">
<h1 class="sub-hero-title">HMC Africa <span class="shine">Awards 2026</span></h1>
<div class="sub-hero-breadcrumbs">
<a href="index.php">Home</a> &nbsp;»&nbsp; Awards
</div>
</div>
</section>

<!-- MAIN AWARDS CONTENT -->
<section style="background: var(--white); padding: 80px 0;">
<div class="container">
    <div class="grid-2" style="align-items: center; gap: 48px;">
        <div>
            <div class="section-eyebrow eyebrow-light">Celebrating Excellence</div>
            <h2 class="font-display" style="font-size: 32px; color: var(--maroon-900); margin-bottom: 20px; line-height: 1.2;">
                Africa's Most Prestigious <br>
                <span class="italic" style="color: var(--gold-600)">Hospitality Awards</span>
            </h2>
            <p style="color: rgba(45,26,16,.8); font-size: 16px; line-height: 1.8; margin-bottom: 16px;">
                The HMC Africa Awards Ceremony recognizes exceptional property management, operational innovation, service excellence, and commercial resilience. Hosted annually during the black-tie Gala Dinner on the final evening of the conference, the awards serve as a benchmarks of quality in African hospitality.
            </p>
            <p style="color: rgba(45,26,16,.8); font-size: 16px; line-height: 1.8;">
                Our independent judging panel reviews submissions based on service feedback index, employee retention rates, operational sustainability, and brand consistency. Nominees are celebrated in front of 900+ industry colleagues and investors.
            </p>
        </div>
        <div style="background: linear-gradient(135deg, var(--maroon-950) 0%, var(--maroon-800) 100%); border-radius: 20px; padding: 40px; border: 1px solid rgba(212,175,55,0.25); color: var(--cream);">
            <div style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.15em; color: var(--gold-300); margin-bottom: 8px; font-weight: 700;">Event Details</div>
            <h3 class="font-display" style="font-size: 22px; color: var(--gold-100); margin-bottom: 24px;">Gala Dinner &amp; Awards Ceremony</h3>
            <ul style="list-style: none; display: flex; flex-direction: column; gap: 16px; font-size: 14px;">
                <li style="display: flex; gap: 12px; align-items: flex-start;">
                    <span style="color: var(--gold-400); font-weight: bold;">📅 Date:</span>
                    <span>July 12, 2026 (Evening)</span>
                </li>
                <li style="display: flex; gap: 12px; align-items: flex-start;">
                    <span style="color: var(--gold-400); font-weight: bold;">📍 Venue:</span>
                    <span>Grand African Ballroom, Lagos Continental Hotel</span>
                </li>
                <li style="display: flex; gap: 12px; align-items: flex-start;">
                    <span style="color: var(--gold-400); font-weight: bold;">👔 Dress Code:</span>
                    <span>Black Tie / Tuxedo / Formal Traditional Attire</span>
                </li>
                <li style="display: flex; gap: 12px; align-items: flex-start;">
                    <span style="color: var(--gold-400); font-weight: bold;">🎟️ Access:</span>
                    <span>Included in In-Person Tickets and Combo Packages</span>
                </li>
            </ul>
        </div>
    </div>
</div>
</section>

<!-- CATEGORIES -->
<section style="background: var(--cream); padding: 80px 0;">
<div class="container">
    <div class="text-center" style="max-width: 700px; margin: 0 auto 56px;">
        <div class="section-eyebrow eyebrow-light">Categories</div>
        <h2 class="section-h2 font-display" style="color: var(--maroon-900);">Award Categories for 2026</h2>
        <p class="section-p" style="margin-bottom: 0;">We honor excellence across five main organizational divisions representing lodging, cuisine, and human resource management.</p>
    </div>

    <style>
    .award-card {
        background: var(--white);
        border: 1px solid var(--maroon-100);
        border-radius: 16px;
        padding: 32px 28px;
        transition: all 0.25s ease;
    }
    .award-card:hover {
        transform: translateY(-4px);
        border-color: var(--gold-400);
        box-shadow: 0 10px 30px rgba(0,0,0,0.06);
    }
    .award-icon-box {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background: var(--gold-50);
        border: 1.5px solid var(--gold-200);
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 20px;
        font-size: 22px;
    }
    .award-card h3 {
        font-family: 'Playfair Display', serif;
        font-size: 19px;
        color: var(--maroon-950);
        margin-bottom: 12px;
    }
    .award-card p {
        font-size: 14px;
        color: rgba(45,26,16,0.7);
        line-height: 1.6;
    }
    </style>

        <div class="grid-3" style="gap: 24px;">
        <?php if (empty($awards_list)): ?>
            <p style="grid-column: 1/-1; text-align: center; color: var(--gold-600); font-weight: 600;">No award categories configured.</p>
        <?php else: ?>
            <?php foreach ($awards_list as $aw): ?>
                <?php 
                    $is_special = (strtolower($aw['name']) === 'lifetime achievement award' || $aw['icon'] === '🏆');
                    $card_style = $is_special ? 'style="border: 2px solid var(--gold-400); background: linear-gradient(135deg, var(--gold-50), var(--cream));"' : '';
                    $icon_style = $is_special ? 'style="background: var(--gold-400); border-color: var(--gold-500); color: var(--maroon-950);"' : '';
                    $has_image = !empty($aw['image']);
                ?>
                <div class="award-card" <?php echo $card_style; ?>>
                    <?php if ($has_image): ?>
                        <div style="margin: -32px -28px 20px; border-radius: 16px 16px 0 0; overflow: hidden; height: 160px;">
                            <img src="<?php echo htmlspecialchars($aw['image']); ?>" alt="<?php echo htmlspecialchars($aw['name']); ?>" style="width: 100%; height: 100%; object-fit: cover; display: block;">
                        </div>
                    <?php else: ?>
                        <div class="award-icon-box" <?php echo $icon_style; ?>><?php echo htmlspecialchars($aw['icon']); ?></div>
                    <?php endif; ?>
                    <h3><?php echo htmlspecialchars($aw['name']); ?></h3>
                    <p><?php echo htmlspecialchars($aw['description']); ?></p>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>
</section>

<!-- NOMINATIONS INFO -->
<section style="background: var(--white); padding: 80px 0;">
<div class="container-md">
    <div style="text-align: center; border: 1.5px solid var(--gold-300); border-radius: 20px; padding: 48px; background: var(--cream);">
        <div class="section-eyebrow eyebrow-light">Submit Nomination</div>
        <h3 class="font-display" style="font-size: 26px; color: var(--maroon-900); margin-bottom: 16px;">Award Nominations Now Open</h3>
        <p style="color: rgba(45,26,16,0.85); font-size: 15px; line-height: 1.75; margin-bottom: 24px; max-width: 600px; margin-left: auto; margin-right: auto;">
            Self-nominations and colleague endorsements are open until June 15, 2026. Submit your operational case study, team retention data, and guest reviews to our registry.
        </p>
        <div class="cta-block-btns" style="justify-content: center;">
            <a href="mailto:<?php echo htmlspecialchars($email); ?>?subject=Nomination Submission HMC Awards 2026" class="btn-primary" style="box-shadow: none;">Submit Entry via Email →</a>
            <a href="tel:<?php echo $phone_number_link; ?>" class="btn-outline" style="border-color: var(--maroon-800); color: var(--maroon-900);">📞 Contact Committee</a>
        </div>
    </div>
</div>
</section>

<?php
require_once 'footer.php';
?>
