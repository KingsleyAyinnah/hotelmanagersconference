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
        display: flex;
        align-items: stretch;
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
        width: 50%;
        position: relative;
        overflow: hidden;
        box-sizing: border-box;
    }
    .hotel-img-panel.has-image {
        padding: 0;
    }
    .hotel-img-panel .hotel-img-cover {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
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
        width: 50%;
        box-sizing: border-box;
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
            flex-direction: column;
            align-items: stretch;
        }
        .hotel-img-panel {
            width: 100%;
            height: auto;
            aspect-ratio: 16 / 10;
            border-right: none;
            border-bottom: 1.5px solid rgba(212,175,55,0.15);
        }
        .hotel-details-panel {
            padding: 24px;
            width: 100%;
            box-sizing: border-box;
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
                        <?php if (!empty($h['address'])): ?>
                            <div style="font-size: 13px; color: rgba(45,26,16,0.65); display: flex; align-items: flex-start; gap: 6px; margin-bottom: 14px; font-weight: 500; line-height: 1.4;">
                                <span style="color: var(--gold-600);">📍</span>
                                <span><?php echo htmlspecialchars($h['address']); ?></span>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($h['description']) && trim($h['description']) !== ''): ?>
                            <p style="font-size:14px; color:rgba(45,26,16,0.75); line-height:1.7; margin-bottom: 16px;">
                                <?php echo htmlspecialchars($h['description']); ?>
                            </p>
                        <?php endif; ?>
                        
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
                            <?php if (!empty($h['price'])): ?>
                                <div>
                                    <div style="font-size: 10px; text-transform: uppercase; color: rgba(45,26,16,0.5); font-weight: 700; margin-bottom: 2px;">Exclusive HMC Rate</div>
                                    <div style="font-size: 20px; font-weight: bold; color: var(--maroon-800); font-family: 'Playfair Display', serif;"><?php echo htmlspecialchars($h['price']); ?></div>
                                </div>
                            <?php else: ?>
                                <div></div>
                            <?php endif; ?>
                            <?php if (!empty($h['website_url'])): ?>
                                <div>
                                    <a href="<?php echo htmlspecialchars($h['website_url']); ?>" target="_blank" rel="noopener noreferrer" style="display: inline-flex; align-items: center; gap: 6px; background: var(--gold-400); color: var(--maroon-950); padding: 8px 18px; border-radius: 50px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; text-decoration: none; transition: background 0.2s; box-shadow: 0 4px 10px rgba(212,175,55,0.15);">
                                        Visit Website ↗
                                    </a>
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

<!-- BECOME A PARTNER HOTEL CTA -->
<section style="background: var(--white); padding: 0 0 80px 0;">
<div class="container-md">
    <div style="background: linear-gradient(135deg, var(--maroon-900) 0%, var(--maroon-950) 100%); color: var(--cream); border-radius: 20px; padding: 40px; border: 1.5px solid var(--gold-400); text-align: center; box-shadow: 0 10px 30px rgba(0,0,0,0.15);">
        <h3 class="font-display" style="font-size: 24px; color: var(--gold-200); margin-bottom: 12px;">Are you a Hotel Owner/Operator?</h3>
        <p style="color: rgba(253,247,240,0.85); font-size: 14px; margin-bottom: 24px; max-width: 520px; margin-left: auto; margin-right: auto; line-height: 1.6;">
            List your accommodation as an official HMC Africa partner hotel to welcome delegates and enjoy peak bookings during the conference.
        </p>
        <a href="https://wa.me/2349112368692?text=Hello,%20I%20would%20like%20to%20register%20our%20hotel%20as%20a%20partner%20for%20HMC%20Africa." target="_blank" rel="noopener noreferrer" style="display: inline-flex; align-items: center; gap: 8px; text-decoration: none; padding: 12px 28px; background: #25d366; color: white; border: none; font-weight: bold; border-radius: 50px; font-size: 13px; text-transform: uppercase; letter-spacing: 0.05em; transition: all 0.2s; box-shadow: 0 4px 12px rgba(37,211,102,0.25);">
            <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24" style="margin-top: -2px;"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946C.06 5.348 5.397.01 12.008.01c3.202.001 6.212 1.246 8.477 3.514 2.266 2.268 3.507 5.28 3.505 8.484-.004 6.657-5.34 11.997-11.953 11.997-2.005-.001-3.973-.502-5.724-1.455L0 24zm6.59-4.846c1.6.95 3.188 1.449 4.825 1.451 5.436 0 9.86-4.37 9.863-9.73 0-2.597-1.01-5.038-2.846-6.874-1.837-1.836-4.279-2.847-6.88-2.847-5.442 0-9.87 4.373-9.873 9.734-.001 1.713.453 3.385 1.317 4.854L1.93 21.147l4.717-1.993zM18.06 14.51c-.33-.165-1.957-.966-2.26-1.076-.303-.11-.522-.165-.742.165-.219.33-.852 1.076-1.044 1.296-.192.22-.384.247-.714.082-1.842-.922-3.136-1.637-4.39-3.799-.328-.566-.064-.87.202-1.134.24-.237.528-.61.792-.916.264-.306.352-.522.528-.871.176-.349.088-.655-.044-.82-.132-.165-1.044-2.515-1.43-3.447-.375-.902-.756-.78-1.044-.795-.264-.015-.567-.015-.87-.015-.303 0-.796.113-1.213.567-.417.454-1.591 1.554-1.591 3.79 0 2.237 1.629 4.397 1.854 4.727.225.33 3.206 4.896 7.766 6.861 1.085.467 1.931.747 2.592.956 1.09.347 2.083.298 2.87.18.875-.13 1.956-.8 2.233-1.536.278-.737.278-1.37.194-1.503-.084-.13-.307-.294-.637-.459z"/></svg>
            Become Our Partner Hotel
        </a>
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
