<?php
$page_title = 'HMC Africa Awards 2026';
require_once 'header.php';

$awards_list = [];
if ($pdo) {
    try {
        $awards_list = $pdo->query("SELECT * FROM `awards` ORDER BY `year` DESC, `id` ASC")->fetchAll();
    } catch (PDOException $e) {
        // Silent fail
    }
}
?>

<!-- SUBPAGE HERO -->
<section class="sub-hero">
<div class="container">
<h1 class="sub-hero-title">HMC Africa <span class="shine">Awards</span></h1>
<div class="sub-hero-breadcrumbs">
<a href="./">Home</a> &nbsp;»&nbsp; Awards
</div>
</div>
</section>



<!-- CATEGORIES -->
<section style="background: var(--cream); padding: 80px 0;">
<div class="container">
    <div class="text-center" style="max-width: 700px; margin: 0 auto 56px;">
        <div class="section-eyebrow eyebrow-light">Categories</div>
        <h2 class="section-h2 font-display" style="color: var(--maroon-900);">Award Categories by Year</h2>
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
    .award-card h3:last-child {
        margin-bottom: 0;
    }
    .award-card p {
        font-size: 14px;
        color: rgba(45,26,16,0.7);
        line-height: 1.6;
    }
    </style>

        <?php 
        $grouped_awards = [];
        foreach ($awards_list as $aw) {
            $yr = isset($aw['year']) ? intval($aw['year']) : 2026;
            $grouped_awards[$yr][] = $aw;
        }
        ?>

        <?php if (empty($grouped_awards)): ?>
            <p style="text-align: center; color: var(--gold-600); font-weight: 600;">No award categories configured.</p>
        <?php else: ?>
            <?php foreach ($grouped_awards as $year => $year_awards): ?>
                <h3 class="font-display" style="font-size: 24px; color: var(--maroon-900); margin-top: 40px; margin-bottom: 24px; border-bottom: 2px solid var(--gold-400); padding-bottom: 8px; grid-column: 1/-1;">
                    Awards Year: <?php echo htmlspecialchars($year); ?>
                </h3>
                <div class="grid-3" style="gap: 24px; margin-bottom: 48px; grid-column: 1/-1;">
                    <?php foreach ($year_awards as $aw): ?>
                        <?php 
                            $is_special = (strtolower($aw['name']) === 'lifetime achievement award' || $aw['icon'] === '🏆');
                            $card_style = $is_special ? 'style="border: 2px solid var(--gold-400); background: linear-gradient(135deg, var(--gold-50), var(--cream));"' : '';
                            $icon_style = $is_special ? 'style="background: var(--gold-400); border-color: var(--gold-500); color: var(--maroon-950);"' : '';
                            $has_image = !empty($aw['image']);
                        ?>
                        <div class="award-card" <?php echo $card_style; ?>>
                            <?php if ($has_image): ?>
                                <div style="margin: -32px -28px 20px; border-radius: 16px 16px 0 0; overflow: hidden; aspect-ratio: 1080 / 1350;">
                                    <img src="<?php echo htmlspecialchars($aw['image']); ?>" alt="<?php echo htmlspecialchars($aw['name']); ?>" style="width: 100%; height: 100%; object-fit: cover; display: block;">
                                </div>
                            <?php else: ?>
                                <div class="award-icon-box" <?php echo $icon_style; ?>><?php echo htmlspecialchars($aw['icon']); ?></div>
                            <?php endif; ?>
                            <h3><?php echo htmlspecialchars($aw['name']); ?></h3>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
</div>
</section>
<!-- VOTING INFO -->
<section style="background: var(--white); padding: 80px 0;">
<div class="container-md">
    <div style="text-align: center; border: 1.5px solid var(--gold-300); border-radius: 20px; padding: 48px; background: var(--cream);">
        <div class="section-eyebrow eyebrow-light">Voting Open</div>
        <h3 class="font-display" style="font-size: 26px; color: var(--maroon-900); margin-bottom: 16px;">2026 Awards Voting Now Open</h3>
        <p style="color: rgba(45,26,16,0.85); font-size: 15px; line-height: 1.75; margin-bottom: 24px; max-width: 600px; margin-left: auto; margin-right: auto;">
            Cast your vote for General Manager of the Year, Boutique Hotel, and training brands. Help recognize exceptional hospitality service and leadership across Africa.
        </p>
        <div class="cta-block-btns" style="justify-content: center;">
            <a href="https://forms.gle/1h5vhku8CiTFBZCj7" target="_blank" class="btn-primary" style="box-shadow: none;">Cast Your Vote Now →</a>
        </div>
    </div>
</div>
</section>

<?php
require_once 'footer.php';
?>
