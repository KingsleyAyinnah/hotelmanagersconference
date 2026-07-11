<?php
require_once '../config/config.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$post = null;

if ($pdo && $id > 0) {
    try {
        $stmt = $pdo->prepare("SELECT * FROM `blog_posts` WHERE `id` = :id");
        $stmt->execute(['id' => $id]);
        $post = $stmt->fetch();
    } catch (PDOException $e) {
        // Fail silently
    }
}

if (!$post) {
    $page_title = 'Article Not Found';
    require_once 'header.php';
    ?>
    <section class="sub-hero">
        <div class="container">
            <h1 class="sub-hero-title">Article <span class="shine">Not Found</span></h1>
            <div class="sub-hero-breadcrumbs">
                <a href="./">Home</a> &nbsp;»&nbsp; <a href="./">Blog</a> &nbsp;»&nbsp; Error
            </div>
        </div>
    </section>

    <section style="background: var(--white); padding: 80px 0; text-align: center;">
        <div class="container">
            <h2 class="font-display" style="font-size: 28px; color: var(--maroon-900); margin-bottom: 20px;">The requested article could not be found.</h2>
            <p style="color: rgba(45,26,16,.7); margin-bottom: 30px;">It may have been deleted or the link is incorrect.</p>
            <a href="./" class="btn-primary" style="padding: 12px 28px;">← Back to Home</a>
        </div>
    </section>
    <?php
    require_once 'footer.php';
    exit;
}

$page_title = $post['title'];
require_once 'header.php';
?>

<!-- SUBPAGE HERO -->
<section class="sub-hero" style="background: linear-gradient(135deg, var(--maroon-950) 0%, var(--maroon-900) 100%);">
    <div class="container">
        <div style="max-width: 800px; margin: 0 auto; text-align: center; color: var(--cream);">
            <div style="font-size: 11px; text-transform: uppercase; font-weight: 700; color: var(--gold-300); letter-spacing: 0.15em; margin-bottom: 16px;">
                <?php echo htmlspecialchars($post['category']); ?>
            </div>
            <h1 class="font-display" style="font-size: clamp(24px, 4vw, 42px); line-height: 1.2; font-weight: 700; color: var(--cream); margin-bottom: 16px;">
                <?php echo htmlspecialchars($post['title']); ?>
            </h1>
            <div style="font-size: 13px; color: rgba(253, 247, 240, 0.7); letter-spacing: 0.05em;">
                📅 Published on <?php echo date('F d, Y', strtotime($post['created_at'])); ?>
            </div>
        </div>
    </div>
</section>

<!-- MAIN ARTICLE CONTENT -->
<section style="background: var(--white); padding: 60px 0;">
    <div class="container-md">
        <!-- Feature Image -->
        <?php if (!empty($post['image'])): ?>
            <div style="margin-bottom: 40px; border-radius: 16px; overflow: hidden; border: 1.5px solid var(--gold-300); box-shadow: 0 10px 35px rgba(0,0,0,0.08); aspect-ratio: 16/9; background: #000;">
                <img src="<?php echo htmlspecialchars($post['image']); ?>" alt="<?php echo htmlspecialchars($post['title']); ?>" style="width: 100%; height: 100%; object-fit: cover;">
            </div>
        <?php endif; ?>

        <!-- Content Area -->
        <article style="color: rgba(45,26,16,0.85); font-size: 16px; line-height: 1.8; font-family: 'Inter', sans-serif;">
            <p class="font-display" style="font-size: 18px; line-height: 1.6; color: var(--maroon-900); font-weight: 600; margin-bottom: 30px; border-left: 4px solid var(--gold-400); padding-left: 20px; font-style: italic;">
                <?php echo nl2br(htmlspecialchars($post['excerpt'])); ?>
            </p>
            
            <div style="margin-bottom: 40px; white-space: pre-line;">
                <?php echo htmlspecialchars($post['content']); ?>
            </div>
        </article>

        <!-- Back Button -->
        <div style="border-top: 1px solid var(--maroon-100); padding-top: 30px; margin-top: 40px; display: flex; justify-content: space-between; align-items: center;">
            <a href="./" class="btn-cta-outline" style="border: 2px solid var(--maroon-800); color: var(--maroon-900); padding: 10px 24px; font-weight: 700; text-decoration: none; border-radius: 4px;">← Back to Homepage</a>
            <div style="font-size: 12px; color: #64748b;">
                Share: <strong style="color: var(--maroon-900);">HMC Africa 2026</strong>
            </div>
        </div>
    </div>
</section>

<?php
require_once 'footer.php';
?>
