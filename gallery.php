<?php
$page_title = 'Event Gallery | HMC Africa';
require_once 'header.php';

$gallery_list = [];
if ($pdo) {
    try {
        $gallery_list = $pdo->query("SELECT * FROM `gallery` ORDER BY `id` ASC")->fetchAll();
    } catch (PDOException $e) {
        // Silent fail
    }
}
?>

<!-- SUBPAGE HERO -->
<section class="sub-hero">
<div class="container">
<h1 class="sub-hero-title">Event <span class="shine">Gallery</span></h1>
<div class="sub-hero-breadcrumbs">
<a href="index.php">Home</a> &nbsp;»&nbsp; Gallery
</div>
</div>
</section>

<!-- FILTERABLE GALLERY SECTION -->
<section style="background: var(--white); padding: 80px 0;">
<div class="container">
    <div class="text-center" style="max-width: 720px; margin: 0 auto 48px;">
        <div class="section-eyebrow eyebrow-light">Past Highlights</div>
        <h2 class="section-h2 font-display" style="color: var(--maroon-900);">Visual Memories of HMC</h2>
        <p class="section-p" style="margin-bottom: 0;">Explore snapshots of keynotes, panel discussions, interactive masterclasses, and corporate partnerships formed during past HMC Africa editions.</p>
    </div>

    <style>
    .gallery-filter-bar {
        display: flex;
        justify-content: center;
        flex-wrap: wrap;
        gap: 12px;
        margin-bottom: 40px;
    }
    .filter-btn {
        background: var(--cream);
        border: 1px solid var(--maroon-200);
        color: var(--maroon-900);
        padding: 8px 20px;
        border-radius: 50px;
        font-size: 13px;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.25s ease;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }
    .filter-btn:hover,
    .filter-btn.active {
        background: var(--gold-400);
        border-color: var(--gold-400);
        color: var(--maroon-950);
    }
    .gallery-grid-full {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 24px;
        transition: all 0.3s ease;
    }
    .gallery-card-item {
        position: relative;
        border-radius: 16px;
        overflow: hidden;
        aspect-ratio: 4/3;
        background: var(--maroon-900);
        border: 1.5px solid rgba(212,175,55,0.15);
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        transition: transform 0.3s ease, border-color 0.3s ease, opacity 0.3s ease;
    }
    .gallery-card-item.hidden {
        display: none;
        opacity: 0;
    }
    .gallery-card-item:hover {
        transform: translateY(-6px);
        border-color: var(--gold-400);
        box-shadow: 0 12px 30px rgba(0,0,0,0.15);
    }
    .gallery-info-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(to top, rgba(28,0,3,0.95) 20%, rgba(28,0,3,0.25));
        display: flex;
        flex-direction: column;
        justify-content: flex-end;
        padding: 24px;
        color: var(--cream);
    }
    .gallery-info-overlay span {
        font-size: 10px;
        text-transform: uppercase;
        font-weight: 700;
        color: var(--gold-300);
        letter-spacing: 0.1em;
        margin-bottom: 6px;
    }
    .gallery-info-overlay h4 {
        font-family: 'Playfair Display', serif;
        font-size: 18px;
        font-weight: 700;
        margin-bottom: 4px;
    }
    .gallery-info-overlay p {
        font-size: 12px;
        opacity: 0.8;
        line-height: 1.5;
    }
    @media (max-width: 1024px) {
        .gallery-grid-full {
            grid-template-columns: repeat(2, 1fr);
        }
    }
    @media (max-width: 600px) {
        .gallery-grid-full {
            grid-template-columns: 1fr;
        }
    }
    </style>

    <!-- FILTER BAR -->
    <div class="gallery-filter-bar">
        <button class="filter-btn active" data-filter="all">All Photos</button>
        <button class="filter-btn" data-filter="panels">Keynotes &amp; Panels</button>
        <button class="filter-btn" data-filter="exhibits">Exhibitions</button>
        <button class="filter-btn" data-filter="cocktails">Networking &amp; Cocktails</button>
        <button class="filter-btn" data-filter="awards">Awards Ceremony</button>
    </div>

    <!-- GALLERY GRID -->
    <div class="gallery-grid-full" id="galleryGrid">
        <?php if (empty($gallery_list)): ?>
            <p style="grid-column: 1/-1; text-align: center; color: var(--gold-600); font-weight: 600;">No gallery items configured.</p>
        <?php else: ?>
            <?php foreach ($gallery_list as $item): ?>
                <?php 
                    $bg_style = '';
                    if (!empty($item['image_path'])) {
                        $bg_style = 'style="background-image: url(\'' . htmlspecialchars($item['image_path']) . '\'); background-size: cover; background-position: center;"';
                    }
                    
                    $cat_display = ucfirst($item['category']);
                    if (strtolower($item['category']) === 'panels') $cat_display = 'Keynotes';
                    elseif (strtolower($item['category']) === 'exhibits') $cat_display = 'Exhibition';
                    elseif (strtolower($item['category']) === 'cocktails') $cat_display = 'Networking';
                    elseif (strtolower($item['category']) === 'awards') $cat_display = 'Awards Gala';
                ?>
                <div class="gallery-card-item" data-category="<?php echo htmlspecialchars($item['category']); ?>" <?php echo $bg_style; ?>>
                    <div class="gallery-info-overlay" style="background: linear-gradient(to top, rgba(28,0,3,0.95) 20%, rgba(28,0,3,0.15) 100%);">
                        <span><?php echo htmlspecialchars($cat_display); ?></span>
                        <h4><?php echo htmlspecialchars($item['title']); ?></h4>
                        <p><?php echo htmlspecialchars($item['description']); ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>
</section>

<!-- REGISTER CTA -->
<section style="background: var(--cream); padding: 80px 0;">
<div class="container-md" style="text-align: center;">
    <h3 class="font-display" style="font-size: 26px; color: var(--maroon-900); margin-bottom: 16px;">Capture Memories at HMC 2026</h3>
    <p style="color: rgba(45,26,16,0.85); font-size: 15px; line-height: 1.8; margin-bottom: 24px; max-width: 600px; margin-left: auto; margin-right: auto;">
        Join 900+ industry colleagues live at Lagos Continental. Secure your ticket today to participate in all conference sessions, cocktail dinners, and awards gala.
    </p>
    <a href="tickets.php" class="btn-primary">Reserve My Seat Now →</a>
</div>
</section>

<script>
// Filter gallery items dynamically
document.addEventListener('DOMContentLoaded', function() {
    var filterButtons = document.querySelectorAll('.filter-btn');
    var galleryCards = document.querySelectorAll('.gallery-card-item');

    filterButtons.forEach(function(btn) {
        btn.addEventListener('click', function() {
            // Toggle active classes on buttons
            filterButtons.forEach(function(b) { b.classList.remove('active'); });
            btn.classList.add('active');

            var filterValue = btn.getAttribute('data-filter');

            galleryCards.forEach(function(card) {
                var category = card.getAttribute('data-category');
                if (filterValue === 'all' || category === filterValue) {
                    card.classList.remove('hidden');
                } else {
                    card.classList.add('hidden');
                }
            });
        });
    });
});
</script>

<?php
require_once 'footer.php';
?>
