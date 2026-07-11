<?php
$page_title = 'Hotel Managers Conference Africa 2026';
require_once 'header.php';

// Fetch dynamic data from database
$speakers_list = [];
$tickets_list = [];
$international_tickets = [];
$hotels_list = [];
$headline_sponsors = [];
$regular_sponsors = [];
$blog_posts_list = [];

if ($pdo) {
    try {
        $speakers_list = $pdo->query("SELECT * FROM `speakers` ORDER BY CASE WHEN LOWER(`category`) = 'keynote speaker' THEN 0 ELSE 1 END ASC, `id` ASC LIMIT 4")->fetchAll();
        $tickets_list = $pdo->query("SELECT * FROM `tickets` WHERE `is_international` = 0 ORDER BY `id` ASC")->fetchAll();
        $international_tickets = $pdo->query("SELECT * FROM `tickets` WHERE `is_international` = 1 ORDER BY `id` ASC")->fetchAll();
        $hotels_list = $pdo->query("SELECT * FROM `hotels` ORDER BY `id` ASC LIMIT 3")->fetchAll();
        $headline_sponsors = $pdo->query("SELECT * FROM `sponsors` WHERE `type` = 'Headline' ORDER BY `order_index` ASC, `id` ASC")->fetchAll();
        $regular_sponsors = $pdo->query("SELECT * FROM `sponsors` WHERE `type` = 'Sponsor' ORDER BY `order_index` ASC, `id` ASC")->fetchAll();
        $blog_posts_list = $pdo->query("SELECT * FROM `blog_posts` ORDER BY `created_at` DESC LIMIT 3")->fetchAll();
    } catch (PDOException $e) {
        // Fail silently
    }
}
?>

<!-- ════════════════════════════════════════════ -->
<!-- 1. HERO VIDEO SECTION -->
<!-- ════════════════════════════════════════════ -->
<section class="hero-video-section"
    style="background: var(--maroon-950); padding: 80px 0; border-bottom: 2px solid var(--gold-400); position: relative; overflow: hidden;">
    <div class="container">
        <div class="hero-grid">
            <!-- Left Column: Content -->
            <div
                style="color: var(--cream); display: flex; flex-direction: column; justify-content: center; align-items: flex-start;">
                <div class="hero-badge"
                    style="background: rgba(212,175,55,0.1); border: 1px solid rgba(212,175,55,0.35); border-radius: 50px; padding: 6px 16px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.1em; color: var(--gold-300); margin-bottom: 24px; display: inline-flex; align-items: center; gap: 8px;">
                    <span
                        style="width: 6px; height: 6px; background: #22c55e; border-radius: 50%; display: inline-block; animation: pulse 2s infinite;"></span>
                    HMC Africa 2026
                </div>
                <h1 class="font-display"
                    style="font-size: clamp(32px, 4.5vw, 52px); font-weight: 900; line-height: 1.15; margin-bottom: 24px; color: var(--cream);">
                    Hotel Managers Conference <br>
                    <span
                        style="background: linear-gradient(90deg, var(--gold-200), var(--gold-400), var(--gold-200)); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">Africa
                        2026</span>
                </h1>
                <p
                    style="font-size: clamp(16px, 1.8vw, 20px); color: var(--gold-200); font-weight: 600; margin-bottom: 12px; letter-spacing: 0.05em;">
                    📍 Lagos Continental Hotel, Victoria Island
                </p>
                <p
                    style="font-size: 15px; color: rgba(253, 247, 240, 0.85); font-weight: 500; margin-bottom: 36px; letter-spacing: 0.05em; text-transform: uppercase;">
                    📅 July 11th &amp; 12th, 2026
                </p>
                <div style="display: flex; gap: 16px; flex-wrap: wrap;">
                    <a href="https://forms.gle/ry9FiboPx33XobwK9" class="btn-primary"
                        style="background: var(--gold-400); color: var(--maroon-950); padding: 14px 32px; border-radius: 50px; font-weight: 700; font-size: 13px; text-transform: uppercase; letter-spacing: 0.08em; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; transition: background 0.2s;">Register
                        Here</a>
                    <a href="about" class="btn-outline"
                        style="border: 2px solid var(--gold-400); color: var(--gold-300); padding: 12px 28px; border-radius: 50px; font-weight: 700; font-size: 13px; text-transform: uppercase; letter-spacing: 0.08em; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; transition: all 0.2s;">About
                        Event</a>
                </div>
            </div>

            <!-- Right Column: Video Block -->
            <div
                style="position: relative; width: 100%; aspect-ratio: 16/9; border-radius: 16px; overflow: hidden; border: 2.5px solid var(--gold-400); box-shadow: 0 15px 40px rgba(0,0,0,0.5); background: #000;">
                <video id="heroVideo" autoplay loop playsinline
                    style="width: 100%; height: 100%; object-fit: contain; display: block;">
                    <source src="images/HOTEL.mp4" type="video/mp4">
                </video>

                <!-- Sound Toggle Icon Button -->
                <button id="soundToggleBtn"
                    style="position: absolute; top: 16px; right: 16px; z-index: 10; background: rgba(28, 0, 3, 0.85); border: 1.5px solid var(--gold-400); color: var(--gold-300); width: 44px; height: 44px; border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.2s ease; box-shadow: 0 4px 12px rgba(0,0,0,0.35);"
                    title="Mute Sound">
                    <span id="soundIcon" style="font-size: 18px; line-height: 1;">🔊</span>
                </button>
            </div>
        </div>
    </div>
</section>

<style>
    .hero-grid {
        display: grid;
        grid-template-columns: 1.1fr 0.9fr;
        gap: 48px;
        align-items: center;
    }

    @keyframes pulse {
        0% {
            transform: scale(0.95);
            opacity: 0.5;
        }

        50% {
            transform: scale(1);
            opacity: 1;
        }

        100% {
            transform: scale(0.95);
            opacity: 0.5;
        }
    }

    @media (max-width: 991px) {
        .hero-grid {
            grid-template-columns: 1fr !important;
            gap: 32px;
            text-align: center;
        }

        .hero-grid>div:first-child {
            align-items: center !important;
            order: 1;
        }

        .hero-grid>div:last-child {
            order: 2;
            width: 100%;
            max-width: 560px;
            margin: 0 auto;
        }

        .hero-grid>div:first-child>div[style*="flex"] {
            justify-content: center;
        }
    }

    @media (max-width: 480px) {
        .hero-grid {
            gap: 24px;
        }

        .hero-grid>div:last-child {
            max-width: 100%;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var video = document.getElementById('heroVideo');
        var soundBtn = document.getElementById('soundToggleBtn');
        var soundIcon = document.getElementById('soundIcon');
        if (video && soundBtn && soundIcon) {
            // Default sound: ON (unmuted)
            video.muted = false;

            // Autoplay play check
            var playPromise = video.play();
            if (playPromise !== undefined) {
                playPromise.catch(function (error) {
                    // Autoplay unmuted is blocked by browser policy. Fallback to playing muted.
                    video.muted = true;
                    soundIcon.textContent = '🔇';
                    soundBtn.setAttribute('title', 'Unmute Sound');
                    video.play();
                });
            }

            soundBtn.addEventListener('click', function (e) {
                e.preventDefault();
                video.muted = !video.muted;
                if (video.muted) {
                    soundIcon.textContent = '🔇';
                    soundBtn.setAttribute('title', 'Unmute Sound');
                } else {
                    soundIcon.textContent = '🔊';
                    soundBtn.setAttribute('title', 'Mute Sound');
                }
            });
        }
    });
</script>

<!-- ════════════════════════════════════════════ -->
<!-- 1B. HERO THEME BLOCK (BELOW VIDEO) -->
<!-- ════════════════════════════════════════════ -->
<section class="theme-banner"
    style="background: linear-gradient(135deg, var(--maroon-900) 0%, var(--maroon-950) 100%); border-bottom: 2px solid var(--gold-400); padding: 56px 0;">
    <div class="container">
        <div class="grid-2" style="align-items: center; gap: 40px;">
            <div>
                <span
                    style="font-size: 11px; text-transform: uppercase; font-weight: 700; color: var(--gold-400); letter-spacing: 0.15em; display: block; margin-bottom: 8px;">HMC
                    Africa 2026 Theme</span>
                <h2 class="font-display"
                    style="font-size: clamp(24px, 3vw, 36px); color: var(--cream); font-weight: 700; line-height: 1.25;">
                    "Raising the Bar: <br>
                    <span style="color: var(--gold-300)">Sales, Service &amp; Standards</span> <br>
                    for Competitive Africa"
                </h2>
            </div>
            <div style="display: flex; flex-direction: column; gap: 16px; align-items: flex-start;">
                <p style="color: rgba(253, 247, 240, 0.8); font-size: 14px; line-height: 1.6;">
                    Strengthening the competitiveness of the African hospitality sector by improving sales performance,
                    delivering exceptional service, and embracing adaptable standards.
                </p>
                <div style="display: flex; gap: 12px; flex-wrap: wrap;">
                    <a href="https://forms.gle/ry9FiboPx33XobwK9" class="btn-primary"
                        style="padding: 12px 24px; font-size: 13px;">Register Here</a>
                    <a href="about" class="btn-outline"
                        style="padding: 11px 22px; font-size: 13px; border-color: rgba(253,247,240,0.35);">About
                        Event</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ════════════════════════════════════════════ -->
<!-- 2. WELCOME SECTION -->
<!-- ════════════════════════════════════════════ -->
<section id="welcome-section" style="background: var(--white); padding: 80px 0;">
    <div class="container">
        <div class="grid-2" style="align-items: center; gap: 48px;">
            <!-- Left Side Text Content -->
            <div>
                <div class="section-eyebrow eyebrow-light">Welcome</div>
                <h2 class="font-display"
                    style="font-size: clamp(28px, 4vw, 38px); color: var(--maroon-900); margin-bottom: 20px; line-height: 1.2;">
                    Welcome to Hotel Managers <br>
                    Conference Africa
                </h2>

                <div
                    style="background: var(--cream); border-left: 4px solid var(--gold-400); padding: 16px 20px; border-radius: 4px; margin-bottom: 24px;">
                    <h3
                        style="font-size: 14px; font-weight: 700; color: var(--maroon-800); margin-bottom: 6px; text-transform: uppercase; letter-spacing: 0.05em;">
                        Conference Theme</h3>
                    <p
                        style="font-family: 'Playfair Display', serif; font-size: 17px; font-style: italic; color: var(--ink); line-height: 1.5;">
                        "Raising the Bar: Sales, Service &amp; Standards for Competitive Africa"
                    </p>
                </div>

                <div
                    style="color: rgba(45,26,16,0.8); font-size: 15px; line-height: 1.8; display: flex; flex-direction: column; gap: 16px; margin-bottom: 28px;">
                    <p>
                        <strong>"Raising the Bar: Sales, Service &amp; Standards for Competitive Africa"</strong> is a
                        forward-looking conference theme aimed at exploring how the hospitality industry can strengthen
                        its competitiveness by improving sales performance, delivering exceptional service, and
                        embracing great and adaptable standards.
                    </p>
                    <p>
                        The discussions will focus on practical strategies that drive growth, enhance guest experiences,
                        and create lasting value across the sector. The conference will bring together hospitality
                        leaders, owners, operators, investors, tourism stakeholders, suppliers, and professionals from
                        across Africa.
                    </p>
                    <p>
                        Through the exchange of ideas, industry insights, and collaborative partnerships, participants
                        will explore ways to build a stronger, more resilient, and globally competitive hospitality
                        industry for the continent.
                    </p>
                </div>
                <a href="about" class="btn-cta-outline"
                    style="border: 2px solid var(--maroon-800); color: var(--maroon-900); font-weight: 700; padding: 12px 28px;">Read
                    More</a>
            </div>

            <!-- Right Side Graphic Overlay (Theme Illustration) -->
            <div
                style="position: relative; border-radius: 20px; overflow: hidden; background: linear-gradient(135deg, var(--maroon-900) 0%, var(--maroon-950) 100%); padding: 56px 40px; border: 2px solid var(--gold-400); box-shadow: 0 15px 40px rgba(0,0,0,0.15); color: var(--cream); text-align: center;">
                <span style="font-size: 64px; margin-bottom: 16px; display: block;">🏆</span>
                <h3 class="font-display" style="font-size: 24px; color: var(--gold-200); margin-bottom: 12px;">8th
                    Edition Highlights</h3>
                <p style="font-size: 14px; line-height: 1.7; opacity: 0.85; max-width: 320px; margin: 0 auto 24px;">
                    Experience immersive masterclasses, dynamic presentations, product exhibitions, and strategic B2B
                    networking rooms under one roof.
                </p>
                <div
                    style="border-top: 1px solid rgba(212,175,55,0.25); padding-top: 20px; display: flex; justify-content: space-around;">
                    <div>
                        <strong
                            style="font-size: 28px; color: var(--gold-300); display: block; font-family: 'Playfair Display', serif;">900+</strong>
                        <span
                            style="font-size: 10px; text-transform: uppercase; opacity: 0.6; letter-spacing: 0.05em;">Attendees</span>
                    </div>
                    <div>
                        <strong
                            style="font-size: 28px; color: var(--gold-300); display: block; font-family: 'Playfair Display', serif;">16+</strong>
                        <span
                            style="font-size: 10px; text-transform: uppercase; opacity: 0.6; letter-spacing: 0.05em;">Countries</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ════════════════════════════════════════════ -->
<!-- 3. WHY JOIN SECTION (join THE EVENT) -->
<!-- ════════════════════════════════════════════ -->
<section style="background: var(--cream); padding: 80px 0;">
    <div class="container">
        <div class="text-center" style="max-width: 720px; margin: 0 auto 56px;">
            <div class="section-eyebrow eyebrow-light">Join The Event</div>
            <h2 class="section-h2 font-display" style="color: var(--maroon-900);">
                Why Join Hotel Managers Conference?
            </h2>
        </div>

        <style>
            .why-join-grid {
                display: grid;
                grid-template-columns: repeat(4, 1fr);
                gap: 24px;
            }

            .why-join-card {
                background: var(--white);
                border: 1px solid var(--maroon-100);
                border-radius: 16px;
                padding: 32px 24px;
                text-align: center;
                position: relative;
                transition: all 0.25s ease;
            }

            .why-join-card:hover {
                transform: translateY(-5px);
                border-color: var(--gold-400);
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.06);
            }

            .why-join-num {
                position: absolute;
                top: 20px;
                right: 20px;
                font-family: 'Playfair Display', serif;
                font-size: 24px;
                font-weight: 900;
                color: rgba(212, 175, 55, 0.25);
                line-height: 1;
            }

            .why-join-card:hover .why-join-num {
                color: var(--gold-400);
            }

            .why-join-icon {
                font-size: 36px;
                margin-bottom: 16px;
                display: block;
            }

            .why-join-card h3 {
                font-family: 'Playfair Display', serif;
                font-size: 19px;
                color: var(--maroon-950);
                margin-bottom: 12px;
            }

            .why-join-card p {
                font-size: 13px;
                color: rgba(45, 26, 16, 0.7);
                line-height: 1.6;
            }

            @media (max-width: 1024px) {
                .why-join-grid {
                    grid-template-columns: repeat(2, 1fr);
                }
            }

            @media (max-width: 600px) {
                .why-join-grid {
                    grid-template-columns: 1fr;
                }
            }
        </style>

        <div class="why-join-grid">
            <!-- Training -->
            <div class="why-join-card">
                <span class="why-join-num">01</span>
                <span class="why-join-icon">🎓</span>
                <h3>Training</h3>
                <p>Participate in executive training masterclasses designed to equip managers with operational SOP
                    playbooks and cost containment formulas.</p>
            </div>

            <!-- Exhibition -->
            <div class="why-join-card">
                <span class="why-join-num">01</span>
                <span class="why-join-icon">🏢</span>
                <h3>Exhibition</h3>
                <p>Touch, feel, and evaluate solutions from 200+ top industry PMS, RMS, F&amp;B supply, security, and
                    kitchen equipment vendors.</p>
            </div>

            <!-- Networking -->
            <div class="why-join-card">
                <span class="why-join-num">02</span>
                <span class="why-join-icon">🤝</span>
                <h3>Networking</h3>
                <p>Build valuable business connections with 900+ owners, operating managers, and development groups
                    representing 16+ countries.</p>
            </div>

            <!-- Awards -->
            <div class="why-join-card">
                <span class="why-join-num">03</span>
                <span class="why-join-icon">🏆</span>
                <h3>Awards</h3>
                <p>Celebrate and acknowledge top properties, general managers, and brands in African hospitality during
                    our black-tie ceremony.</p>
            </div>
        </div>
    </div>
</section>

<!-- ════════════════════════════════════════════ -->
<!-- 4. SPEAKERS SECTION -->
<!-- ════════════════════════════════════════════ -->
<section style="background: var(--white); padding: 80px 0;">
    <div class="container">
        <div class="text-center" style="max-width: 720px; margin: 0 auto 56px;">
            <div class="section-eyebrow eyebrow-light">Speakers</div>
            <h2 class="section-h2 font-display" style="color: var(--maroon-900);">Event Speakers</h2>
        </div>

        <style>
            .home-speakers-grid {
                display: grid;
                grid-template-columns: repeat(4, 1fr);
                gap: 24px;
            }

            .home-speaker-card {
                border: 1px solid var(--maroon-100);
                border-radius: 12px;
                overflow: hidden;
                background: var(--cream);
                transition: all 0.25s ease;
                text-align: center;
                display: flex;
                flex-direction: column;
                height: 100%;
            }

            .home-speaker-card:hover {
                transform: translateY(-5px);
                border-color: var(--gold-400);
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.06);
            }

            .home-speaker-img-box {
                width: 100%;
                aspect-ratio: 1;
                background: linear-gradient(135deg, var(--maroon-900) 0%, var(--maroon-950) 100%);
                display: flex;
                align-items: center;
                justify-content: center;
                overflow: hidden;
                border-bottom: 1.5px solid rgba(212, 175, 55, 0.15);
                position: relative;
            }

            .home-speaker-badge {
                position: absolute;
                top: 12px;
                left: 12px;
                background: var(--gold-400);
                color: var(--maroon-950);
                padding: 4px 10px;
                border-radius: 50px;
                font-size: 8px;
                font-weight: 700;
                text-transform: uppercase;
                letter-spacing: 0.08em;
                z-index: 10;
                box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
                border: 1px solid var(--gold-200);
                line-height: 1;
            }

            .home-speaker-badge.regular-speaker {
                background: var(--maroon-900);
                color: var(--cream);
                border-color: rgba(255, 255, 255, 0.15);
            }

            .home-speaker-avatar {
                width: 100%;
                height: 100%;
                object-fit: cover;
            }

            .home-speaker-info {
                padding: 20px 16px;
                flex-grow: 1;
                display: flex;
                flex-direction: column;
            }

            .home-speaker-name {
                font-family: 'Playfair Display', serif;
                font-size: 17px;
                font-weight: 700;
                color: var(--maroon-950);
                margin-bottom: 6px;
            }

            .home-speaker-title {
                font-size: 12px;
                color: var(--gold-600);
                font-weight: 700;
                margin-top: auto;
                line-height: 1.4;
            }

            @media (max-width: 1024px) {
                .home-speakers-grid {
                    grid-template-columns: repeat(2, 1fr);
                }
            }

            @media (max-width: 600px) {
                .home-speakers-grid {
                    grid-template-columns: 1fr;
                }
            }
        </style>

        <div class="home-speakers-grid">
            <?php if (empty($speakers_list)): ?>
                <p style="grid-column: 1/-1; text-align: center; color: var(--gold-600); font-weight: 600;">No speakers
                    configured.</p>
            <?php else: ?>
                <?php foreach ($speakers_list as $s): ?>
                    <div class="home-speaker-card">
                        <div class="home-speaker-img-box">
                            <?php
                            $cat = isset($s['category']) ? $s['category'] : 'Speaker';
                            $badge_class = (strtolower($cat) === 'keynote speaker') ? '' : 'regular-speaker';
                            ?>
                            <span
                                class="home-speaker-badge <?php echo $badge_class; ?>"><?php echo htmlspecialchars($cat); ?></span>
                            <?php if (!empty($s['image'])): ?>
                                <img src="<?php echo htmlspecialchars($s['image']); ?>"
                                    alt="<?php echo htmlspecialchars($s['name']); ?>" class="home-speaker-avatar" loading="lazy">
                            <?php else: ?>
                                <div
                                    style="font-size: 40px; color: var(--gold-300); display:flex; align-items:center; justify-content:center; height:100%;">
                                    👤</div>
                            <?php endif; ?>
                        </div>
                        <div class="home-speaker-info">
                            <div class="home-speaker-name"><?php echo htmlspecialchars($s['name']); ?></div>
                            <div class="home-speaker-title"><?php echo htmlspecialchars($s['title']); ?></div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <div class="text-center" style="margin-top: 40px;">
            <a href="speakers" class="btn-cta-outline"
                style="border: 2px solid var(--maroon-800); color: var(--maroon-900); font-weight: 700; padding: 12px 28px;">All
                Speakers</a>
        </div>
    </div>
</section>

<!-- ════════════════════════════════════════════ -->
<!-- 5. TICKETS & PAYMENT SECTION -->
<!-- ════════════════════════════════════════════ -->
<section id="tickets" class="tickets-section" style="padding: 80px 0;">
    <div class="container">
        <div class="text-center" style="max-width: 680px; margin: 0 auto 56px;">
            <div class="section-eyebrow eyebrow-dark">Tickets</div>
            <h2 class="section-h2 font-display">Purchase Your Ticket</h2>
        </div>

        <div class="ticket-grid">
            <?php if (empty($tickets_list)): ?>
                <p style="grid-column: 1/-1; text-align: center; color: var(--gold-600); font-weight: 600;">No ticket
                    classes configured.</p>
            <?php else: ?>
                <?php foreach ($tickets_list as $t): ?>
                    <?php
                    $is_featured = (strtolower($t['name']) === 'regular pass');
                    $card_class = $is_featured ? 'ticket-card featured' : 'ticket-card';
                    $btn_class = $is_featured ? 'ticket-btn ticket-btn-primary' : 'ticket-btn ticket-btn-outline';
                    ?>
                    <div class="<?php echo $card_class; ?>">
                        <?php if ($is_featured): ?>
                            <div class="ticket-featured-badge">⭐ Recommended</div>
                        <?php endif; ?>
                        <div class="ticket-for"><?php echo htmlspecialchars($t['description']); ?></div>
                        <div class="ticket-type"><?php echo htmlspecialchars($t['type']); ?></div>
                        <div class="ticket-name font-display"><?php echo htmlspecialchars($t['name']); ?></div>
                        <div class="ticket-price">
                            <span class="ticket-price-main"><?php echo htmlspecialchars($t['price_ngn']); ?></span>
                            <?php if (!empty($t['price_usd']) && $t['price_usd'] !== $t['price_ngn']): ?>
                                <span class="ticket-price-alt">or <?php echo htmlspecialchars($t['price_usd']); ?></span>
                            <?php endif; ?>
                        </div>
                        <div class="ticket-savings" style="margin-bottom: 20px;">
                            <?php
                            $feats = explode("\n", $t['features']);
                            foreach ($feats as $f) {
                                $f = trim($f);
                                if (!empty($f)) {
                                    echo "✓ " . htmlspecialchars($f) . "<br>";
                                }
                            }
                            ?>
                        </div>
                        <a href="tickets?ticket_type=<?php echo urlencode($t['name']); ?>" class="<?php echo $btn_class; ?>"
                            style="margin-top: auto;">Make Payment</a>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <!-- INTERNATIONAL DELEGATES SPECIAL BANNER -->
        <div
            style="background: rgba(255,255,255,0.03); border: 1.5px solid rgba(212,175,55,0.3); border-radius: 16px; padding: 40px; margin-top: 56px;">
            <h3 class="font-display text-center"
                style="font-size: 24px; color: var(--gold-200); margin-bottom: 16px; text-transform: uppercase; letter-spacing: 0.05em;">
                🌍 International Delegate Packages</h3>

            <?php if (!empty($international_tickets)): ?>
                <div class="ticket-grid" style="margin-top: 32px; justify-content: center;">
                    <?php foreach ($international_tickets as $t): ?>
                        <?php
                        $is_featured = (strtolower($t['name']) === 'combo package' || count($international_tickets) === 1);
                        $card_class = $is_featured ? 'ticket-card featured' : 'ticket-card';
                        $btn_class = $is_featured ? 'ticket-btn ticket-btn-primary' : 'ticket-btn ticket-btn-outline';
                        ?>
                        <div class="<?php echo $card_class; ?>" style="text-align: left;">
                            <?php if ($is_featured): ?>
                                <div class="ticket-featured-badge">⭐ Recommended Pass</div>
                            <?php endif; ?>
                            <div class="ticket-for"><?php echo htmlspecialchars($t['description']); ?></div>
                            <div class="ticket-type"><?php echo htmlspecialchars($t['type']); ?></div>
                            <div class="ticket-name font-display"><?php echo htmlspecialchars($t['name']); ?></div>
                            <div class="ticket-price">
                                <span class="ticket-price-main"><?php echo htmlspecialchars($t['price_ngn']); ?></span>
                                <?php if (!empty($t['price_usd']) && $t['price_usd'] !== $t['price_ngn']): ?>
                                    <span class="ticket-price-alt">or <?php echo htmlspecialchars($t['price_usd']); ?></span>
                                <?php endif; ?>
                            </div>
                            <div class="ticket-savings" style="margin-bottom: 20px; text-align: left;">
                                <?php
                                $feats = explode("\n", $t['features']);
                                foreach ($feats as $f) {
                                    $f = trim($f);
                                    if (!empty($f)) {
                                        echo "✓ " . htmlspecialchars($f) . "<br>";
                                    }
                                }
                                ?>
                            </div>
                            <a href="tickets?ticket_type=<?php echo urlencode($t['name']); ?>" class="<?php echo $btn_class; ?>"
                                style="margin-top: auto;">Make Payment</a>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p
                    style="color: rgba(253, 247, 240, 0.85); font-size: 14px; line-height: 1.7; max-width: 600px; margin: 0 auto 20px; text-align: center;">
                    Coming from outside Nigeria? We provide comprehensive visa endorsement support letters, dedicated
                    airport coordination, and premium transport shuttles. Select the **Combo Package** or email the
                    registry.
                </p>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- ════════════════════════════════════════════ -->
<!-- 6. SPONSORS SECTION -->
<!-- ════════════════════════════════════════════ -->
<section style="background: var(--white); padding: 80px 0; border-bottom: 1px solid var(--maroon-100);">
    <div class="container">
        <!-- Headline Sponsor -->
        <?php if (!empty($headline_sponsors)): ?>
            <div style="text-align: center; margin-bottom: 56px;">
                <div
                    style="font-size: 11px; text-transform: uppercase; font-weight: 700; color: var(--maroon-700); letter-spacing: 0.2em; margin-bottom: 16px;">
                    Headline Sponsor</div>
                <div
                    style="display: flex; flex-direction: column; align-items: center; gap: 16px; justify-content: center;">
                    <?php foreach ($headline_sponsors as $hs): ?>
                        <div
                            style="display: inline-flex; align-items: center; justify-content: center; border: 1.5px solid var(--gold-400); background: var(--cream); border-radius: 12px; box-shadow: 0 8px 24px rgba(212,175,55,0.12); width: 500px; height: 250px; overflow: hidden; padding: 24px; box-sizing: border-box; max-width: 100%;">
                            <?php if (!empty($hs['logo'])): ?>
                                <img src="<?php echo htmlspecialchars($hs['logo']); ?>"
                                    alt="<?php echo htmlspecialchars($hs['name']); ?>"
                                    style="width: 100%; height: 100%; object-fit: contain; display: block;">
                            <?php else: ?>
                                <div
                                    style="font-family: 'Playfair Display', serif; font-size: 32px; font-weight: 900; color: var(--maroon-950); padding: 24px; line-height: 1.2;">
                                    ⭐ <?php echo htmlspecialchars($hs['name']); ?> ⭐
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php else: ?>
            <!-- Fallback Headline Sponsor if empty -->
            <div style="text-align: center; margin-bottom: 56px;">
                <div
                    style="font-size: 11px; text-transform: uppercase; font-weight: 700; color: var(--maroon-700); letter-spacing: 0.2em; margin-bottom: 16px;">
                    Headline Sponsor</div>
                <div
                    style="display: inline-flex; align-items: center; justify-content: center; width: 500px; height: 250px; border: 1.5px solid var(--gold-400); background: var(--cream); border-radius: 12px; font-family: 'Playfair Display', serif; font-size: 32px; font-weight: 900; color: var(--maroon-950); box-shadow: 0 8px 24px rgba(212,175,55,0.12); padding: 24px; box-sizing: border-box; line-height: 1.2; text-align: center; max-width: 100%;">
                    ⭐ LAGOS CONTINENTAL ⭐
                </div>
            </div>
        <?php endif; ?>

        <!-- Sponsors Grid -->
        <div style="text-align: center;">
            <div
                style="font-size: 11px; text-transform: uppercase; font-weight: 700; color: var(--maroon-700); letter-spacing: 0.2em; margin-bottom: 24px;">
                Sponsors</div>
            <div style="display: flex; justify-content: center; align-items: center; flex-wrap: wrap; gap: 24px;">
                <?php if (empty($regular_sponsors)): ?>
                    <p style="color: #64748b; font-style: italic; font-size: 14px;">No sponsors configured.</p>
                <?php else: ?>
                    <?php foreach ($regular_sponsors as $rs): ?>
                        <div
                            style="width: 250px; height: 250px; border: 1px solid var(--maroon-100); background: var(--cream); border-radius: 8px; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 12px rgba(0,0,0,0.02); overflow: hidden; padding: 20px; box-sizing: border-box; flex-shrink: 0; max-width: 100%;">
                            <?php if (!empty($rs['logo'])): ?>
                                <img src="<?php echo htmlspecialchars($rs['logo']); ?>"
                                    alt="<?php echo htmlspecialchars($rs['name']); ?>"
                                    style="width: 100%; height: 100%; object-fit: contain; display: block;">
                            <?php else: ?>
                                <span
                                    style="font-weight: 700; color: var(--maroon-800); font-size: 20px; padding: 16px; line-height: 1.3; overflow: hidden; text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 4; -webkit-box-orient: vertical;"><?php echo htmlspecialchars($rs['name']); ?></span>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<!-- ════════════════════════════════════════════ -->
<!-- 7. AWARDS & 2025 WINNERS SECTION -->
<!-- ════════════════════════════════════════════ -->
<section style="background: var(--cream); padding: 80px 0;">
    <div class="container">
        <div class="grid-2" style="align-items: center; gap: 48px;">
            <div>
                <div class="section-eyebrow eyebrow-light">Awards</div>
                <h2 class="font-display"
                    style="font-size: clamp(28px, 3.5vw, 36px); color: var(--maroon-900); margin-bottom: 20px; line-height: 1.2;">
                    Acknowledging African <br>
                    <span class="italic" style="color: var(--gold-600)">Hospitality Excellence</span>
                </h2>
                <p style="color: rgba(45,26,16,0.8); font-size: 15px; line-height: 1.75; margin-bottom: 24px;">
                    The HMC Africa Awards celebrate the properties, management teams, and service innovators raising
                    standard quality criteria across the continent. Review the benchmarks met by previous winners.
                </p>
                <a href="awards" class="btn-primary" style="padding: 12px 28px;">See Winners of HMC 2025 Awards</a>
            </div>

            <div
                style="background: linear-gradient(135deg, var(--maroon-900) 0%, var(--maroon-950) 100%); color: var(--cream); border-radius: 20px; padding: 40px; border: 1px solid var(--gold-400); text-align: center;">
                <span style="font-size: 48px; margin-bottom: 12px; display: block;">🏆</span>
                <h3 class="font-display" style="font-size: 20px; color: var(--gold-200); margin-bottom: 8px;">2026
                    Voting Open</h3>
                <p style="font-size: 13px; opacity: 0.8; margin-bottom: 20px; line-height: 1.6;">Voting is now open for
                    the General Manager of the Year, Boutique Hotel, and training brands.</p>
                <a href="https://forms.gle/1h5vhku8CiTFBZCj7" target="_blank"
                    style="color: var(--gold-300); text-decoration: underline; font-weight: 700; font-size: 14px;">Vote
                    Now →</a>
            </div>
        </div>
    </div>
</section>

<!-- ════════════════════════════════════════════ -->
<!-- 8. BLOG POST SECTION -->
<!-- ════════════════════════════════════════════ -->
<section style="background: var(--white); padding: 80px 0;">
    <div class="container">
        <div class="text-center" style="max-width: 720px; margin: 0 auto 56px;">
            <div class="section-eyebrow eyebrow-light">Blog Post</div>
            <h2 class="section-h2 font-display" style="color: var(--maroon-900);">Latest News &amp; Blog</h2>
        </div>

        <style>
            .blog-grid {
                display: grid;
                grid-template-columns: repeat(3, 1fr);
                gap: 24px;
            }

            .blog-card {
                border: 1px solid var(--maroon-100);
                background: var(--cream);
                border-radius: 12px;
                overflow: hidden;
                transition: all 0.25s ease;
                display: flex;
                flex-direction: column;
                height: 100%;
            }

            .blog-card:hover {
                transform: translateY(-5px);
                border-color: var(--gold-400);
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.06);
            }

            .blog-img-box {
                width: 100%;
                aspect-ratio: 1.6;
                background: linear-gradient(135deg, var(--maroon-800) 0%, var(--maroon-950) 100%);
                display: flex;
                align-items: center;
                justify-content: center;
                overflow: hidden;
                border-bottom: 1px solid rgba(212, 175, 55, 0.15);
            }

            .blog-content {
                padding: 24px;
                flex-grow: 1;
                display: flex;
                flex-direction: column;
            }

            .blog-meta-tag {
                font-size: 10px;
                text-transform: uppercase;
                font-weight: 700;
                color: var(--gold-600);
                letter-spacing: 0.1em;
                margin-bottom: 8px;
            }

            .blog-title {
                font-family: 'Playfair Display', serif;
                font-size: 18px;
                color: var(--maroon-950);
                line-height: 1.4;
                font-weight: 700;
                margin-bottom: 12px;
            }

            .blog-desc {
                font-size: 13px;
                color: rgba(45, 26, 16, 0.7);
                line-height: 1.6;
                margin-bottom: 16px;
            }

            .blog-link {
                font-size: 12px;
                font-weight: 700;
                color: var(--maroon-800);
                text-decoration: none;
                margin-top: auto;
                display: inline-flex;
                align-items: center;
                gap: 4px;
            }

            .blog-link:hover {
                color: var(--gold-600);
            }

            @media (max-width: 1024px) {
                .blog-grid {
                    grid-template-columns: repeat(2, 1fr);
                }
            }

            @media (max-width: 600px) {
                .blog-grid {
                    grid-template-columns: 1fr;
                }
            }
        </style>

        <div class="blog-grid">
            <?php if (empty($blog_posts_list)): ?>
                <p
                    style="grid-column: 1/-1; text-align: center; color: var(--gold-600); font-weight: 600; padding: 40px 0;">
                    No articles published yet.</p>
            <?php else: ?>
                <?php foreach ($blog_posts_list as $bp): ?>
                    <div class="blog-card">
                        <div class="blog-img-box">
                            <?php if (!empty($bp['image'])): ?>
                                <img src="<?php echo htmlspecialchars($bp['image']); ?>"
                                    alt="<?php echo htmlspecialchars($bp['title']); ?>"
                                    style="width:100%; height:100%; object-fit:cover; display:block;">
                            <?php else: ?>
                                <span style="font-size: 40px;">📰</span>
                            <?php endif; ?>
                        </div>
                        <div class="blog-content">
                            <div class="blog-meta-tag"><?php echo htmlspecialchars($bp['category']); ?> ·
                                <?php echo date('F Y', strtotime($bp['created_at'])); ?></div>
                            <h3 class="blog-title"><?php echo htmlspecialchars($bp['title']); ?></h3>
                            <p class="blog-desc"><?php echo htmlspecialchars($bp['excerpt']); ?></p>
                            <a href="post?id=<?php echo $bp['id']; ?>" class="blog-link">Read Article →</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- ════════════════════════════════════════════ -->
<!-- 9. PARTNER HOTELS SECTION -->
<!-- ════════════════════════════════════════════ -->
<section style="background: var(--cream); padding: 80px 0;">
    <div class="container">
        <div class="text-center" style="max-width: 720px; margin: 0 auto 56px;">
            <div class="section-eyebrow eyebrow-light">Partner Hotels</div>
            <h2 class="section-h2 font-display" style="color: var(--maroon-900);">Explore Hotels</h2>
            <p class="section-p"
                style="margin-bottom: 0; font-weight: 700; text-transform: uppercase; letter-spacing: 0.1em; color: var(--gold-600); font-size: 13px;">
                OUR ACCREDITED HOTELS &amp; RESTAURANTS
            </p>
        </div>

        <style>
            .partner-hotels-grid {
                display: grid;
                grid-template-columns: repeat(3, 1fr);
                gap: 24px;
            }

            .partner-hotel-card {
                background: var(--white);
                border: 1px solid var(--maroon-100);
                border-radius: 16px;
                overflow: hidden;
                transition: all 0.25s ease;
                display: flex;
                flex-direction: column;
                height: 100%;
            }

            .partner-hotel-card:hover {
                transform: translateY(-5px);
                border-color: var(--gold-400);
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.06);
            }

            .partner-hotel-img-wrapper {
                width: 100%;
                aspect-ratio: 1.5;
                background: linear-gradient(135deg, var(--maroon-900) 0%, var(--maroon-950) 100%);
                display: flex;
                align-items: center;
                justify-content: center;
                overflow: hidden;
                border-bottom: 1.5px solid rgba(212, 175, 55, 0.15);
            }

            .partner-hotel-content {
                padding: 24px;
                flex-grow: 1;
                display: flex;
                flex-direction: column;
            }

            .partner-hotel-name {
                font-family: 'Playfair Display', serif;
                font-size: 20px;
                color: var(--maroon-950);
                font-weight: 700;
                margin-bottom: 12px;
            }

            .partner-hotel-address {
                font-size: 13px;
                color: rgba(45, 26, 16, 0.7);
                line-height: 1.6;
                margin-bottom: 16px;
                display: flex;
                align-items: flex-start;
                gap: 6px;
            }

            .partner-hotel-address svg {
                color: var(--gold-500);
                margin-top: 3px;
                flex-shrink: 0;
            }

            .partner-hotel-btn {
                font-size: 12px;
                font-weight: 700;
                color: var(--maroon-800);
                text-decoration: none;
                margin-top: auto;
                display: inline-flex;
                align-items: center;
                gap: 4px;
            }

            .partner-hotel-btn:hover {
                color: var(--gold-600);
            }

            @media (max-width: 1024px) {
                .partner-hotels-grid {
                    grid-template-columns: repeat(2, 1fr);
                }
            }

            @media (max-width: 600px) {
                .partner-hotels-grid {
                    grid-template-columns: 1fr;
                }
            }
        </style>

        <div class="partner-hotels-grid">
            <?php if (empty($hotels_list)): ?>
                <p style="grid-column: 1/-1; text-align: center; color: var(--gold-600); font-weight: 600;">No partner
                    hotels configured.</p>
            <?php else: ?>
                <?php foreach ($hotels_list as $h): ?>
                    <?php
                    $icon = '🏨';
                    if (strtolower($h['type']) === 'venue')
                        $icon = '🏢';
                    elseif (strtolower($h['type']) === 'budget')
                        $icon = '🌴';
                    ?>
                    <div class="partner-hotel-card">
                        <div class="partner-hotel-img-wrapper">
                            <?php if (!empty($h['image'])): ?>
                                <img src="<?php echo htmlspecialchars($h['image']); ?>"
                                    alt="<?php echo htmlspecialchars($h['name']); ?>"
                                    style="width: 100%; height: 100%; object-fit: cover; display: block;">
                            <?php else: ?>
                                <span style="font-size: 44px;"><?php echo $icon; ?></span>
                            <?php endif; ?>
                        </div>
                        <div class="partner-hotel-content">
                            <h3 class="partner-hotel-name"><?php echo htmlspecialchars($h['name']); ?></h3>
                            <div class="partner-hotel-address">
                                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z" />
                                    <circle cx="12" cy="9" r="2.5" />
                                </svg>
                                <span><?php echo htmlspecialchars($h['address']); ?></span>
                            </div>
                            <?php if (!empty($h['website_url'])): ?>
                                <a href="<?php echo htmlspecialchars($h['website_url']); ?>" target="_blank"
                                    rel="noopener noreferrer" class="partner-hotel-btn">Visit Website ↗</a>
                            <?php else: ?>
                                <a href="hotels" class="partner-hotel-btn">Visit Website ↗</a>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <div class="text-center" style="margin-top: 40px;">
            <a href="hotels" class="btn-cta-outline"
                style="border: 2px solid var(--maroon-800); color: var(--maroon-900); font-weight: 700; padding: 12px 28px; text-decoration: none; display: inline-block; border-radius: 50px; transition: all 0.2s;">See
                All Partner Hotels</a>
        </div>
    </div>
</section>

<?php
require_once 'footer.php';
?>