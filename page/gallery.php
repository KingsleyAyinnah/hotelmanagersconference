<?php
$page_title = 'Event Gallery | HMC Africa';
require_once 'header.php';

$gallery_list = [];
if ($pdo) {
    try {
        $gallery_list = $pdo->query("SELECT * FROM `gallery` ORDER BY `year` DESC, `id` ASC")->fetchAll();
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
<a href="./">Home</a> &nbsp;»&nbsp; Gallery
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
    .gallery-filter-container {
        display: flex;
        justify-content: center;
        flex-wrap: wrap;
        gap: 12px;
        margin-bottom: 48px;
    }
    .filter-chip {
        background: var(--cream);
        border: 1.5px solid var(--maroon-200);
        color: var(--maroon-900);
        padding: 10px 24px;
        border-radius: 50px;
        font-size: 13px;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        text-transform: uppercase;
        letter-spacing: 0.05em;
        box-shadow: 0 2px 6px rgba(0,0,0,0.02);
        user-select: none;
    }
    .filter-chip:hover {
        transform: translateY(-2px);
        border-color: var(--gold-400);
        color: var(--gold-600);
        box-shadow: 0 4px 12px rgba(212,175,55,0.15);
    }
    .filter-chip.active {
        background: var(--gold-400);
        border-color: var(--gold-400);
        color: var(--maroon-950);
        box-shadow: 0 4px 12px rgba(212,175,55,0.25);
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
    .gallery-card-item:hover {
        transform: translateY(-6px);
        border-color: var(--gold-400);
        box-shadow: 0 12px 30px rgba(0,0,0,0.15);
    }
    .gallery-card-item:hover .gallery-img {
        transform: scale(1.05);
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

    <?php
    $grouped_gallery = [];
    foreach ($gallery_list as $item) {
        $yr = isset($item['year']) ? intval($item['year']) : 2026;
        $cat = (!empty($item['category'])) ? strtolower($item['category']) : 'general';
        $grouped_gallery[$yr][$cat][] = $item;
    }
    // Sort years descending
    krsort($grouped_gallery);
    ?>

    <!-- FILTER BAR CHIPS -->
    <div class="gallery-filter-container">
        <button class="filter-chip active" data-filter="all">All Categories</button>
        <button class="filter-chip" data-filter="general">General Highlights</button>
        <button class="filter-chip" data-filter="panels">Keynotes &amp; Panels</button>
        <button class="filter-chip" data-filter="exhibits">Exhibitions</button>
        <button class="filter-chip" data-filter="cocktails">Networking &amp; Cocktails</button>
        <button class="filter-chip" data-filter="awards">Awards Ceremony</button>
    </div>

    <?php if (empty($grouped_gallery)): ?>
        <p style="text-align: center; color: var(--gold-600); font-weight: 600;">No gallery items configured.</p>
    <?php else: ?>
        <?php foreach ($grouped_gallery as $year => $categories): ?>
            <div class="gallery-year-section" style="margin-bottom: 64px;">
                <h3 class="font-display" style="font-size: 28px; color: var(--maroon-900); border-bottom: 2.5px solid var(--gold-400); padding-bottom: 8px; margin-bottom: 32px;">
                    Event Year: <?php echo htmlspecialchars($year); ?>
                </h3>
                
                <?php foreach ($categories as $cat => $items): ?>
                    <?php 
                        $cat_display = ucfirst($cat);
                        if ($cat === 'panels') $cat_display = 'Keynotes & Panels';
                        elseif ($cat === 'exhibits') $cat_display = 'Exhibitions';
                        elseif ($cat === 'cocktails') $cat_display = 'Networking & Cocktails';
                        elseif ($cat === 'awards') $cat_display = 'Awards Ceremony';
                        elseif ($cat === 'general') $cat_display = 'General Highlights';
                    ?>
                    <div class="gallery-category-section" data-category="<?php echo htmlspecialchars($cat); ?>" style="margin-bottom: 48px;">
                        <h4 class="font-display" style="font-size: 20px; color: var(--maroon-800); margin-bottom: 20px; display: flex; align-items: center; gap: 8px;">
                            <span style="color: var(--gold-500);">✦</span>
                            <?php echo htmlspecialchars($cat_display); ?>
                        </h4>
                        
                        <div class="gallery-grid-full" style="margin-bottom: 24px;">
                            <?php foreach ($items as $item): ?>
                                <div class="gallery-card-item">
                                    <?php if (!empty($item['image_path'])): ?>
                                        <img src="<?php echo htmlspecialchars($item['image_path']); ?>" alt="Gallery Image" style="width: 100%; height: 100%; object-fit: cover; display: block; transition: transform 0.5s ease;" class="gallery-img">
                                    <?php else: ?>
                                        <div style="font-size: 40px; color: var(--gold-300); display:flex; align-items:center; justify-content:center; height:100%;">📷</div>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
</section>

<!-- REGISTER CTA -->
<section style="background: var(--cream); padding: 80px 0;">
<div class="container-md" style="text-align: center;">
    <h3 class="font-display" style="font-size: 26px; color: var(--maroon-900); margin-bottom: 16px;">Capture Memories at HMC 2026</h3>
    <p style="color: rgba(45,26,16,0.85); font-size: 15px; line-height: 1.8; margin-bottom: 24px; max-width: 600px; margin-left: auto; margin-right: auto;">
        Join 900+ industry colleagues live at Lagos Continental. Secure your ticket today to participate in all conference sessions, cocktail dinners, and awards gala.
    </p>
    <a href="tickets" class="btn-primary">Reserve My Seat Now →</a>
</div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var chips = document.querySelectorAll('.filter-chip');
    var yearSections = document.querySelectorAll('.gallery-year-section');

    chips.forEach(function(chip) {
        chip.addEventListener('click', function() {
            // Toggle active chips
            chips.forEach(function(c) { c.classList.remove('active'); });
            chip.classList.add('active');

            var filterValue = chip.getAttribute('data-filter');

            yearSections.forEach(function(yearSec) {
                var catSections = yearSec.querySelectorAll('.gallery-category-section');
                var visibleCatsCount = 0;

                catSections.forEach(function(catSec) {
                    var category = catSec.getAttribute('data-category');
                    if (filterValue === 'all' || category === filterValue) {
                        catSec.style.display = 'block';
                        visibleCatsCount++;
                    } else {
                        catSec.style.display = 'none';
                    }
                });

                // Hide the whole year section if it contains no matching category photos
                if (visibleCatsCount > 0) {
                    yearSec.style.display = 'block';
                } else {
                    yearSec.style.display = 'none';
                }
            });
        });
    });
});
</script>

<?php
require_once 'footer.php';
?>
