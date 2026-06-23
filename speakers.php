<?php
$page_title = 'Speakers | HMC Africa';
require_once 'header.php';

$speakers_list = [];
if ($pdo) {
    try {
        $speakers_list = $pdo->query("SELECT * FROM `speakers` ORDER BY `id` ASC")->fetchAll();
    } catch (PDOException $e) {
        // Silent fail
    }
}
?>

<!-- SUBPAGE HERO -->
<section class="sub-hero">
<div class="container">
<h1 class="sub-hero-title">Our <span class="shine">Speakers</span></h1>
<div class="sub-hero-breadcrumbs">
<a href="index.php">Home</a> &nbsp;»&nbsp; Speakers
</div>
</div>
</section>

<!-- SPEAKERS GRID -->
<section style="background: var(--white); padding: 80px 0;">
<div class="container">
    <div class="text-center" style="max-width: 720px; margin: 0 auto 56px;">
        <div class="section-eyebrow eyebrow-light">Industry Experts</div>
        <h2 class="section-h2 font-display" style="color: var(--maroon-900);">Learn From Verified Practitioners</h2>
        <p class="section-p" style="margin-bottom: 0;">We do not invite influencers. Every speaker on stage runs a major property, conducts active research, or structures international lodging brands.</p>
    </div>

    <style>
    .speakers-page-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 32px;
    }
    .speaker-page-card {
        border: 1px solid var(--maroon-100);
        border-radius: 16px;
        overflow: hidden;
        background: var(--cream);
        position: relative;
        transition: transform 0.3s ease, border-color 0.3s ease, box-shadow 0.3s ease;
        display: flex;
        flex-direction: column;
    }
    .speaker-page-card:hover {
        transform: translateY(-8px);
        border-color: var(--gold-400);
        box-shadow: 0 15px 40px rgba(0,0,0,0.1);
    }
    .speaker-page-img-wrapper {
        width: 100%;
        aspect-ratio: 1.1;
        overflow: hidden;
        position: relative;
    }
    .speaker-page-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }
    .speaker-page-card:hover .speaker-page-img {
        transform: scale(1.06);
    }
    .speaker-page-content {
        padding: 24px;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }
    .speaker-page-name {
        font-family: 'Playfair Display', serif;
        font-size: 20px;
        color: var(--maroon-950);
        font-weight: 700;
        margin-bottom: 6px;
    }
    .speaker-page-role {
        font-size: 13px;
        font-weight: 700;
        color: var(--gold-600);
        margin-bottom: 4px;
        text-transform: uppercase;
        letter-spacing: 0.04em;
    }
    .speaker-page-org {
        font-size: 12px;
        color: rgba(45,26,16,0.6);
        font-weight: 600;
        margin-bottom: 16px;
    }
    .speaker-page-topic {
        border-top: 1px solid var(--maroon-200);
        padding-top: 16px;
        margin-top: auto;
    }
    .speaker-page-topic-label {
        font-size: 10px;
        text-transform: uppercase;
        letter-spacing: 0.12em;
        color: var(--maroon-700);
        font-weight: 700;
        margin-bottom: 4px;
    }
    .speaker-page-topic-title {
        font-size: 14px;
        font-style: italic;
        color: var(--ink);
        line-height: 1.5;
    }
    @media (max-width: 1024px) {
        .speakers-page-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 24px;
        }
    }
    @media (max-width: 600px) {
        .speakers-page-grid {
            grid-template-columns: 1fr;
        }
    }
    </style>

    <div class="speakers-page-grid">
        <?php if (empty($speakers_list)): ?>
            <p style="grid-column: 1/-1; text-align: center; color: var(--gold-600); font-weight: 600;">No speakers configured.</p>
        <?php else: ?>
            <?php foreach ($speakers_list as $s): ?>
                <div class="speaker-page-card">
                    <div class="speaker-page-img-wrapper">
                        <?php if (!empty($s['image'])): ?>
                            <img src="<?php echo htmlspecialchars($s['image']); ?>" alt="<?php echo htmlspecialchars($s['name']); ?>" class="speaker-page-img" loading="lazy"/>
                        <?php else: ?>
                            <div style="font-size: 50px; color: var(--gold-300); display:flex; align-items:center; justify-content:center; height:100%; width:100%; background: linear-gradient(135deg, var(--maroon-900) 0%, var(--maroon-950) 100%);">
                                👤
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="speaker-page-content">
                        <div class="speaker-page-name"><?php echo htmlspecialchars($s['name']); ?></div>
                        <div class="speaker-page-role"><?php echo htmlspecialchars($s['title']); ?></div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>
</section>

<!-- PANEL DETAILS / CALL TO SPEAKERS -->
<section style="background: var(--cream); padding: 80px 0;">
<div class="container-md" style="text-align: center;">
    <h3 class="font-display" style="font-size: 26px; color: var(--maroon-900); margin-bottom: 16px;">Call for Co-Speakers &amp; Panelists</h3>
    <p style="color: rgba(45,26,16,0.85); font-size: 15px; line-height: 1.8; margin-bottom: 24px; max-width: 600px; margin-left: auto; margin-right: auto;">
        Are you actively steering a hospitality brand, consulting on regional tourism, or scaling operations inside Africa? Apply to join our panels or present during our masterclasses.
    </p>
    <a href="mailto:<?php echo htmlspecialchars($email); ?>?subject=Speaker Application HMC 2026" class="btn-primary" style="box-shadow: none;">Apply to Speak →</a>
</div>
</section>

<?php
require_once 'footer.php';
?>
