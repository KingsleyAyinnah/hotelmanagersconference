<?php
$page_title = 'Partner Hotels | HMC Africa';
require_once 'header.php';

$hotels_list = [];
if ($pdo) {
    try {
        $hotels_list = $pdo->query("SELECT * FROM `hotels` ORDER BY `id` ASC")->fetchAll();
    } catch (PDOException $e) {
        // Silent fail
    }
}
?>

<!-- SUBPAGE HERO -->
<section class="sub-hero">
<div class="container">
<h1 class="sub-hero-title">Partner <span class="shine">Hotels</span></h1>
<div class="sub-hero-breadcrumbs">
<a href="./">Home</a> &nbsp;»&nbsp; Partner Hotels
</div>
</div>
</section>

<!-- HOTELS CONTENT -->
<section style="background: var(--white); padding: 80px 0;">
<div class="container">
    <div class="text-center" style="max-width: 720px; margin: 0 auto 56px;">
        <div class="section-eyebrow eyebrow-light">Accommodation</div>
        <h2 class="section-h2 font-display" style="color: var(--maroon-900);">Approved Lodging for Delegates</h2>
        <p class="section-p" style="margin-bottom: 0;">Special rates are available for HMC Africa delegates booking room blocks between July 10 and July 13, 2026. Use the HMC discount code upon booking.</p>
    </div>

    <style>
    .hotel-list {
        display: flex;
        flex-direction: column;
        gap: 40px;
    }
    .hotel-card-item {
        display: grid;
        grid-template-columns: 0.95fr 1.05fr;
        border: 1.5px solid var(--maroon-100);
        border-radius: 20px;
        overflow: hidden;
        background: var(--cream);
        box-shadow: 0 4px 15px rgba(0,0,0,0.02);
        transition: border-color 0.25s ease, box-shadow 0.25s ease;
    }
    .hotel-card-item:hover {
        border-color: var(--gold-400);
        box-shadow: 0 10px 30px rgba(0,0,0,0.06);
    }
    .hotel-img-panel {
        background: linear-gradient(135deg, var(--maroon-900) 0%, var(--maroon-950) 100%);
        color: var(--cream);
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        padding: 48px;
        text-align: center;
        border-right: 1.5px solid rgba(212,175,55,0.15);
        min-height: 240px;
        position: relative;
        overflow: hidden;
    }
    .hotel-img-panel.has-image {
        padding: 0;
    }
    .hotel-img-panel .hotel-img-cover {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
        min-height: 240px;
        position: absolute;
        inset: 0;
    }
    .hotel-img-panel .hotel-img-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(to top, rgba(28,0,3,0.88) 0%, rgba(28,0,3,0.2) 65%, transparent 100%);
        display: flex;
        flex-direction: column;
        justify-content: flex-end;
        padding: 28px;
        color: var(--cream);
    }
    .hotel-details-panel {
        padding: 40px;
        display: flex;
        flex-direction: column;
    }
    .hotel-name-display {
        font-family: 'Playfair Display', serif;
        font-size: 24px;
        color: var(--maroon-950);
        font-weight: 700;
        margin-bottom: 8px;
    }
    .hotel-badge-tag {
        display: inline-block;
        background: var(--gold-50);
        border: 1px solid rgba(212,175,55,0.3);
        border-radius: 50px;
        padding: 4px 14px;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        color: var(--gold-600);
        margin-bottom: 16px;
        align-self: flex-start;
    }
    .hotel-features-list {
        list-style: none;
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 12px;
        font-size: 13px;
        color: rgba(45,26,16,0.75);
        margin-bottom: 24px;
        border-top: 1px dashed var(--maroon-200);
        padding-top: 16px;
    }
    @media (max-width: 768px) {
        .hotel-card-item {
            grid-template-columns: 1fr;
        }
        .hotel-img-panel {
            border-right: none;
            border-bottom: 1.5px solid rgba(212,175,55,0.15);
            min-height: 200px;
        }
        .hotel-details-panel {
            padding: 24px;
        }
    }
    </style>

    <div class="hotel-list">
        <?php if (empty($hotels_list)): ?>
            <p style="grid-column: 1/-1; text-align: center; color: var(--gold-600); font-weight: 600;">No partner accommodations configured.</p>
        <?php else: ?>
            <?php foreach ($hotels_list as $h): ?>
                <?php 
                    $icon = '🏨';
                    $badge_label = 'Accredited Partner';
                    if (strtolower($h['type']) === 'venue') {
                        $icon = '🏢';
                        $badge_label = 'Conference Venue';
                    } elseif (strtolower($h['type']) === 'budget') {
                        $icon = '🏘️';
                        $badge_label = 'Budget Selection';
                    }
                    $has_image = !empty($h['image']);
                ?>
                <div class="hotel-card-item">
                    <div class="hotel-img-panel <?php echo $has_image ? 'has-image' : ''; ?>">
                        <?php if ($has_image): ?>
                            <img src="<?php echo htmlspecialchars($h['image']); ?>" alt="<?php echo htmlspecialchars($h['name']); ?>" class="hotel-img-cover">
                            <div class="hotel-img-overlay">
                                <h3 class="font-display" style="font-size: 24px; color: var(--gold-200); margin-bottom: 4px;"><?php echo htmlspecialchars($h['name']); ?></h3>
                                <p style="font-size: 12px; opacity: 0.8;">Approved partner accommodation</p>
                            </div>
                        <?php else: ?>
                            <span style="font-size: 48px; margin-bottom: 16px;"><?php echo $icon; ?></span>
                            <h3 class="font-display" style="font-size: 26px; color: var(--gold-200); margin-bottom: 8px;"><?php echo htmlspecialchars($h['name']); ?></h3>
                            <p style="font-size: 13px; opacity: 0.8; max-width: 280px; line-height: 1.6;">Approved partner accommodation offering dynamic pricing blocks for delegates.</p>
                        <?php endif; ?>
                    </div>
                    <div class="hotel-details-panel">
                        <span class="hotel-badge-tag"><?php echo htmlspecialchars($badge_label); ?></span>
                        <h4 class="hotel-name-display"><?php echo htmlspecialchars($h['name']); ?></h4>
                        <p style="font-size:14px; color:rgba(45,26,16,0.75); line-height:1.7; margin-bottom: 16px;">
                            <?php echo htmlspecialchars($h['description']); ?>
                        </p>
                        
                        <?php if (!empty($h['amenities'])): ?>
                            <ul class="hotel-features-list">
                                <?php 
                                    $features = explode(",", $h['amenities']);
                                    foreach ($features as $f) {
                                        $f = trim($f);
                                        if (!empty($f)) {
                                            echo "<li>✓ " . htmlspecialchars($f) . "</li>";
                                        }
                                    }
                                ?>
                            </ul>
                        <?php endif; ?>

                        <div style="border-top: 1.5px solid var(--maroon-100); padding-top: 16px; display: flex; flex-wrap: wrap; justify-content: space-between; align-items: center; gap: 16px; margin-top: auto;">
                            <div>
                                <div style="font-size: 10px; text-transform: uppercase; color: rgba(45,26,16,0.5); font-weight: 700; margin-bottom: 2px;">Exclusive HMC Rate</div>
                                <div style="font-size: 20px; font-weight: bold; color: var(--maroon-800); font-family: 'Playfair Display', serif;"><?php echo htmlspecialchars($h['price']); ?></div>
                            </div>
                            <?php if (!empty($h['discount_code'])): ?>
                                <div>
                                    <div style="font-size: 10px; text-transform: uppercase; color: rgba(45,26,16,0.5); font-weight: 700; margin-bottom: 2px;">Discount Code</div>
                                    <div style="font-size: 14px; font-weight: bold; color: var(--gold-600); letter-spacing: 0.05em; background: var(--white); border: 1px solid var(--gold-300); padding: 4px 10px; border-radius: 4px;"><?php echo htmlspecialchars($h['discount_code']); ?></div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>
</section>

<!-- RESERVATION ASSISTANCE -->
<section style="background: var(--cream); padding: 80px 0;">
<div class="container-md">
    <div style="background: var(--maroon-950); color: var(--cream); border-radius: 20px; padding: 48px; border: 1px solid rgba(212,175,55,0.25); text-align: center;">
        <h3 class="font-display" style="font-size: 26px; color: var(--gold-200); margin-bottom: 12px;">Need Help with Booking?</h3>
        <p style="color: rgba(253,247,240,0.75); font-size: 15px; margin-bottom: 28px; max-width: 500px; margin-left: auto; margin-right: auto; line-height: 1.7;">
            Our airport pickup, transportation, and visa support committee can assist you. Speak with us to fast-track bookings.
        </p>
        <div class="cta-block-btns" style="justify-content: center;">
            <a href="tickets?ticket_type=Combo+Package" class="btn-cta-primary" style="background: var(--gold-400); color: var(--maroon-950); text-decoration: none;">Book Combo Package →</a>
            <a href="tel:<?php echo $phone_number_link; ?>" class="btn-cta-outline" style="border-color: var(--gold-400); color: var(--gold-300);">📞 Contact Concierge</a>
        </div>
    </div>
</div>
</section>

<?php
require_once 'footer.php';
?>
