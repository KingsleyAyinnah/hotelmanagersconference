<?php
require_once '../config/config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>HMC Africa 2026 | <?php echo isset($page_title) ? htmlspecialchars($page_title) : 'Hospitality Leadership Conference'; ?></title>
<link rel="preconnect" href="https://fonts.googleapis.com"/>
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin/>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;0,900;1,700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet"/>
<base href="<?php echo htmlspecialchars($project_base); ?>">
<style>
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
:root{
--maroon-950:#1c0003;
--maroon-900:#380007;
--maroon-800:#5c030d;
--maroon-700:#880515;
--maroon-200:#fcd8dc;
--maroon-100:#fdf2f3;
--gold-200:#f5e6a3;
--gold-300:#e8cc6a;
--gold-400:#d4af37;
--gold-500:#b8942a;
--gold-600:#9a7a22;
--gold-50:#fdf8e8;
--cream:#fdf7f0;
--ink:#2d1a10;
--white:#ffffff;
}
html{scroll-behavior:smooth}
body{font-family:'Inter',sans-serif;background:var(--cream);color:var(--ink);overflow-x:hidden;line-height:1.6}
.font-display{font-family:'Playfair Display',serif}
.text-gold{color:var(--gold-400)}
.text-gold-light{color:var(--gold-200)}
.text-gold-dark{color:var(--gold-600)}
.text-cream{color:var(--cream)}
.text-muted{color:rgba(253,247,240,0.7)}
.italic{font-style:italic}
.uppercase{text-transform:uppercase}
.text-center{text-align:center}
.fw-bold{font-weight:700}
.fw-black{font-weight:900}

/* LAYOUT */
.container{max-width:1200px;margin:0 auto;padding:0 24px}
.container-md{max-width:900px;margin:0 auto;padding:0 24px}
.container-sm{max-width:700px;margin:0 auto;padding:0 24px}
.grid-2{display:grid;grid-template-columns:1fr 1fr;gap:20px}
.grid-3{display:grid;grid-template-columns:repeat(3,1fr);gap:24px}
.grid-4{display:grid;grid-template-columns:repeat(4,1fr);gap:20px}
.grid-hero{display:grid;grid-template-columns:7fr 5fr;gap:48px;align-items:center}

/* ANNOUNCEMENT BAR */
.ann-bar{background:var(--maroon-950);color:var(--gold-200);text-align:center;font-size:11px;font-weight:600;letter-spacing:.12em;text-transform:uppercase;padding:8px 16px}
.ann-bar span{margin:0 12px;opacity:.5}

/* URGENCY BAR */
.urgency-bar{background:var(--gold-400);color:var(--maroon-950);text-align:center;font-size:13px;font-weight:700;padding:10px 16px;letter-spacing:.04em}

/* HEADER NAVIGATION */
.header-nav-container {
    background: var(--maroon-950);
    border-bottom: 1px solid rgba(212, 175, 55, 0.2);
    position: sticky;
    top: 0;
    z-index: 1000;
    box-shadow: 0 4px 20px rgba(0,0,0,0.15);
}
.header-nav {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 16px 0;
}
.nav-logo {
    display: flex;
    align-items: center;
    text-decoration: none;
}
.nav-links-wrapper {
    display: flex;
    align-items: center;
    gap: 32px;
}
.nav-links {
    display: flex;
    align-items: center;
    gap: 28px;
    list-style: none;
}
.nav-links a {
    color: var(--cream);
    text-decoration: none;
    font-size: 13px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.08em;
    transition: all 0.2s ease;
    font-family: 'Inter', sans-serif;
    padding: 6px 0;
}
.nav-links a:hover,
.nav-links a.active {
    color: var(--gold-300);
}
.nav-links a.active {
    border-bottom: 2px solid var(--gold-400);
}
.nav-cta {
    background: var(--gold-400);
    color: var(--maroon-950);
    padding: 10px 22px;
    border-radius: 50px;
    font-weight: 700;
    font-size: 12px;
    text-transform: uppercase;
    letter-spacing: 0.08em;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    transition: background .2s;
}
.nav-cta:hover {
    background: var(--gold-300);
}

/* Mobile menu toggle */
.menu-toggle {
    display: none;
    flex-direction: column;
    justify-content: space-between;
    width: 24px;
    height: 18px;
    background: transparent;
    border: none;
    cursor: pointer;
    padding: 0;
    z-index: 1100;
}
.menu-toggle span {
    width: 100%;
    height: 2px;
    background-color: var(--gold-300);
    transition: all 0.3s ease;
}

@media (max-width: 1024px) {
    .menu-toggle {
        display: flex;
    }
    .nav-links-wrapper {
        position: fixed;
        top: 0;
        right: -100%;
        width: 280px;
        height: 100vh;
        background: var(--maroon-950);
        flex-direction: column;
        align-items: center;
        justify-content: flex-start;
        padding: 80px 24px;
        gap: 40px;
        transition: right 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        border-left: 1px solid rgba(212, 175, 55, 0.2);
        box-shadow: -10px 0 30px rgba(0,0,0,0.5);
    }
    .nav-links-wrapper.active {
        right: 0;
    }
    .nav-links {
        flex-direction: column;
        width: 100%;
        gap: 24px;
        align-items: center;
    }
    .nav-links a {
        font-size: 15px;
        width: 100%;
        text-align: center;
    }
    .menu-toggle.active span:nth-child(1) {
        transform: translateY(8px) rotate(45deg);
    }
    .menu-toggle.active span:nth-child(2) {
        opacity: 0;
    }
    .menu-toggle.active span:nth-child(3) {
        transform: translateY(-8px) rotate(-45deg);
    }
}

/* SUBPAGE HERO HEADER */
.sub-hero {
    background: linear-gradient(135deg, var(--maroon-950) 0%, #5c030d 40%, var(--maroon-900) 100%);
    color: var(--cream);
    padding: 60px 0;
    border-bottom: 2px solid var(--gold-400);
    text-align: center;
}
.sub-hero-title {
    font-family: 'Playfair Display', serif;
    font-size: clamp(28px, 4vw, 44px);
    font-weight: 900;
    margin-bottom: 12px;
}
.sub-hero-title .shine {
    background: linear-gradient(90deg, var(--gold-200), var(--gold-400), var(--gold-200));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}
.sub-hero-breadcrumbs {
    font-size: 13px;
    letter-spacing: 0.1em;
    text-transform: uppercase;
    color: rgba(253, 247, 240, 0.6);
}
.sub-hero-breadcrumbs a {
    color: var(--gold-300);
    text-decoration: none;
    font-weight: 600;
}
.sub-hero-breadcrumbs a:hover {
    text-decoration: underline;
}

/* HERO SECTION ON HOMEPAGE */
.hero{background:linear-gradient(135deg,var(--maroon-950) 0%,#5c030d 40%,var(--maroon-900) 100%);color:var(--cream);position:relative;overflow:hidden}
.hero::before{content:'';position:absolute;inset:0;background:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='60' height='60'%3E%3Ccircle cx='1' cy='1' r='1' fill='rgba(212,175,55,0.04)'/%3E%3C/svg%3E");pointer-events:none}
.hero-badge{display:inline-flex;align-items:center;gap:8px;border:1px solid rgba(212,175,55,.4);background:rgba(45,10,30,.4);border-radius:50px;padding:6px 16px;font-size:11px;letter-spacing:.2em;text-transform:uppercase;color:var(--gold-300);margin-bottom:24px}
.hero-badge-dot{width:8px;height:8px;border-radius:50%;background:var(--gold-400);animation:pulse 2s infinite}
@keyframes pulse{0%,100%{opacity:1}50%{opacity:.4}}
.hero-h1{font-family:'Playfair Display',serif;font-size:clamp(32px,5vw,62px);font-weight:900;line-height:1.05;margin-bottom:16px}
.hero-h1 .shine{background:linear-gradient(90deg,var(--gold-200),var(--gold-400),var(--gold-200));-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text}
.hero-h1 .gold{color:var(--gold-300)}
.hero-subhead{font-size:clamp(15px,1.6vw,19px);color:var(--gold-200);font-weight:600;margin-bottom:14px;letter-spacing:.02em}
.hero-sub{font-size:clamp(14px,1.5vw,17px);color:rgba(253,247,240,.85);line-height:1.7;max-width:620px;margin-bottom:24px}
.hero-sub .gold{color:var(--gold-300);font-weight:600}

/* HERO TRUST INDICATORS */
.hero-trust-grid{display:flex;flex-wrap:wrap;gap:10px;margin-bottom:28px}
.hero-trust-item{display:flex;align-items:center;gap:7px;background:rgba(212,175,55,.1);border:1px solid rgba(212,175,55,.25);border-radius:50px;padding:6px 14px;font-size:12px;color:var(--gold-200);font-weight:600;letter-spacing:.04em}
.hero-trust-item svg{color:var(--gold-400);flex-shrink:0}

.hero-btns{display:flex;flex-wrap:wrap;gap:12px;margin-bottom:28px}
.btn-primary{background:var(--gold-400);color:var(--maroon-950);padding:15px 30px;border-radius:50px;font-weight:800;font-size:14px;text-transform:uppercase;letter-spacing:.08em;text-decoration:none;display:inline-flex;align-items:center;gap:8px;transition:background .2s;box-shadow:0 8px 30px rgba(212,175,55,.3)}
.btn-primary:hover{background:var(--gold-300)}
.btn-outline{border:1.5px solid rgba(253,247,240,.4);color:var(--cream);padding:14px 24px;border-radius:50px;font-weight:600;font-size:14px;text-decoration:none;display:inline-flex;align-items:center;gap:8px;transition:all .2s}
.btn-outline:hover{border-color:var(--gold-300);color:var(--gold-300)}
.hero-meta{display:flex;flex-wrap:wrap;gap:20px;font-size:13px;color:rgba(253,247,240,.65)}
.hero-meta-item{display:flex;align-items:center;gap:6px}
.hero-meta-item svg{color:var(--gold-300)}

/* COUNTDOWN CARD */
.countdown-card{background:linear-gradient(135deg,rgba(45,10,30,.7),rgba(26,5,16,.9));border:1px solid rgba(212,175,55,.3);border-radius:16px;padding:32px;backdrop-filter:blur(8px);box-shadow:0 24px 60px rgba(0,0,0,.5);position:relative}
.countdown-label{position:absolute;top:-12px;left:50%;transform:translateX(-50%);background:var(--gold-400);color:var(--maroon-950);font-size:10px;font-weight:800;letter-spacing:.2em;text-transform:uppercase;padding:4px 14px;border-radius:50px;white-space:nowrap}
.countdown-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:8px;margin-bottom:24px}
.cd-unit{background:rgba(26,5,16,.6);border:1px solid rgba(212,175,55,.15);border-radius:10px;padding:12px 8px;text-align:center}
.cd-num{font-family:'Playfair Display',serif;font-size:32px;font-weight:700;color:var(--gold-200);line-height:1;display:block}
.cd-lbl{font-size:9px;text-transform:uppercase;letter-spacing:.15em;color:rgba(253,247,240,.5);margin-top:4px;display:block}
.card-divider{height:1px;background:linear-gradient(90deg,transparent,rgba(212,175,55,.3),transparent);margin:0 0 20px}
.card-checks{display:flex;flex-direction:column;gap:10px;margin-bottom:20px}
.card-check{display:flex;align-items:flex-start;gap:10px;font-size:13px;color:rgba(253,247,240,.9)}
.card-check svg{color:var(--gold-300);flex-shrink:0;margin-top:2px}
.card-price-box{background:rgba(26,5,16,.7);border:1px solid rgba(212,175,55,.2);border-radius:10px;padding:14px;text-align:center;margin-bottom:16px}
.card-price-label{font-size:10px;letter-spacing:.2em;text-transform:uppercase;color:rgba(232,204,106,.8);margin-bottom:4px}
.card-price-main{display:flex;align-items:baseline;justify-content:center;gap:8px}
.card-price-main span:first-child{font-family:'Playfair Display',serif;font-size:30px;font-weight:700;color:var(--gold-200)}
.card-price-main span:last-child{font-size:13px;color:rgba(253,247,240,.4)}
.card-price-sub{font-size:10px;color:rgba(253,247,240,.4);margin-top:4px}
.card-btns{display:grid;grid-template-columns:1fr 1fr;gap:8px}
.card-btn-primary{background:var(--gold-400);color:var(--maroon-950);border:none;border-radius:50px;padding:12px;font-weight:800;font-size:11px;text-transform:uppercase;letter-spacing:.1em;cursor:pointer;text-decoration:none;text-align:center;display:block;transition:background .2s}
.card-btn-primary:hover{background:var(--gold-300)}
.card-btn-outline{border:1px solid var(--gold-400);background:transparent;border-radius:50px;padding:12px;font-weight:700;font-size:11px;text-transform:uppercase;letter-spacing:.1em;cursor:pointer;color:var(--gold-300);text-decoration:none;text-align:center;display:block;transition:all .2s}
.card-btn-outline:hover{background:var(--gold-400);color:var(--maroon-950)}

/* TICKER */
.ticker-wrap{border-top:1px solid rgba(212,175,55,.2);background:rgba(26,5,16,.6);padding:18px 0;overflow:hidden}
.ticker-label{text-align:center;font-size:10px;letter-spacing:.3em;text-transform:uppercase;color:rgba(212,175,55,.6);margin-bottom:10px}
.ticker-track{display:flex;gap:48px;white-space:nowrap;animation:ticker 40s linear infinite;width:max-content}
.ticker-track span{font-family:'Playfair Display',serif;font-size:17px;color:rgba(253,247,240,.45);transition:color .2s;cursor:default}
.ticker-track span:hover{color:var(--gold-300)}
@keyframes ticker{0%{transform:translateX(0)}100%{transform:translateX(-50%)}}

/* SECTIONS */
section{padding:80px 0}
.section-eyebrow{display:inline-block;font-size:10px;letter-spacing:.3em;text-transform:uppercase;font-weight:700;border-radius:50px;padding:6px 16px;margin-bottom:20px}
.eyebrow-light{color:var(--maroon-700);border:1px solid rgba(136,5,21,.3)}
.eyebrow-dark{color:var(--gold-300);border:1px solid rgba(212,175,55,.4)}
.section-h2{font-family:'Playfair Display',serif;font-size:clamp(28px,4vw,50px);font-weight:700;line-height:1.15;margin-bottom:20px}
.section-p{font-size:17px;color:rgba(45,26,16,.7);line-height:1.75;max-width:680px;margin:0 auto 48px}
.section-p.dark{color:rgba(253,247,240,.7)}

/* CTA BLOCK */
.cta-block{background:linear-gradient(135deg,var(--maroon-950),#5c030d);border:1px solid rgba(212,175,55,.2);border-radius:20px;padding:48px;text-align:center;margin:0}
.cta-block h3{font-family:'Playfair Display',serif;font-size:clamp(22px,3vw,32px);color:var(--cream);margin-bottom:12px;line-height:1.2}
.cta-block p{font-size:15px;color:rgba(253,247,240,.7);margin-bottom:28px;max-width:520px;margin-left:auto;margin-right:auto;line-height:1.7}
.cta-block-btns{display:flex;justify-content:center;flex-wrap:wrap;gap:12px}
.btn-cta-primary{background:var(--gold-400);color:var(--maroon-950);padding:14px 32px;border-radius:50px;font-weight:800;font-size:13px;text-transform:uppercase;letter-spacing:.08em;text-decoration:none;display:inline-flex;align-items:center;gap:8px;transition:background .2s;box-shadow:0 8px 24px rgba(212,175,55,.3)}
.btn-cta-primary:hover{background:var(--gold-300)}
.btn-cta-outline{border:1.5px solid rgba(212,175,55,.5);color:var(--gold-300);padding:14px 24px;border-radius:50px;font-weight:600;font-size:13px;text-decoration:none;display:inline-flex;align-items:center;gap:8px;transition:all .2s}
.btn-cta-outline:hover{background:var(--gold-400);color:var(--maroon-950)}
.cta-section-wrap{background:var(--maroon-950);padding:56px 0}
.cta-section-wrap.light{background:var(--cream)}

/* WHAT IS HMC */
.what-section{background:var(--cream);padding:80px 0}
.what-card{background:var(--white);border:1px solid var(--maroon-100);border-radius:16px;padding:32px 28px;text-align:center;position:relative;overflow:hidden;transition:all .25s}
.what-card:hover{box-shadow:0 20px 50px rgba(0,0,0,.1);transform:translateY(-4px);border-color:var(--gold-400)}
.what-card-icon{width:56px;height:56px;border-radius:50%;background:linear-gradient(135deg,var(--gold-50),var(--gold-200));display:flex;align-items:center;justify-content:center;margin:0 auto 16px;font-size:24px}
.what-card h3{font-family:'Playfair Display',serif;font-size:20px;font-weight:700;color:var(--maroon-900);margin-bottom:10px}
.what-card p{font-size:14px;color:rgba(45,26,16,.7);line-height:1.7}
.what-card-tag{display:inline-block;background:var(--gold-50);border:1px solid rgba(212,175,55,.3);border-radius:50px;padding:3px 12px;font-size:10px;font-weight:700;letter-spacing:.15em;text-transform:uppercase;color:var(--gold-600);margin-bottom:12px}

/* WHO SHOULD ATTEND */
.who-section{background:linear-gradient(180deg,var(--maroon-950),var(--maroon-900));padding:80px 0;color:var(--cream)}
.who-card{background:rgba(255,255,255,.04);border:1px solid rgba(212,175,55,.15);border-radius:16px;padding:24px 20px;text-align:center;transition:all .25s;cursor:default}
.who-card:hover{background:rgba(212,175,55,.08);border-color:rgba(212,175,55,.4);transform:translateY(-4px)}
.who-card-icon{font-size:32px;margin-bottom:12px;display:block}
.who-card h3{font-family:'Playfair Display',serif;font-size:17px;color:var(--gold-200);margin-bottom:6px}
.who-card p{font-size:13px;color:rgba(253,247,240,.6);line-height:1.6}
.who-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:16px}

/* PAIN CARDS */
.pain-card{background:var(--white);border:1px solid var(--maroon-200);border-radius:16px;padding:28px;box-shadow:0 2px 8px rgba(0,0,0,.04);transition:all .25s}
.pain-card:hover{box-shadow:0 12px 40px rgba(0,0,0,.1);border-color:var(--gold-400)}
.quote-icon{width:32px;height:32px;color:var(--gold-500);margin-bottom:12px}
.pain-card p{font-family:'Playfair Display',serif;font-size:19px;color:var(--maroon-900);font-style:italic;line-height:1.5}

/* TRUST / CREDIBILITY */
.trust-section{background:var(--cream);padding:80px 0}
.trust-logo-grid{display:grid;grid-template-columns:repeat(7,1fr);gap:10px;margin-top:40px}
.trust-logo-tile{height:80px;border:1px solid var(--maroon-100);background:var(--white);border-radius:12px;display:flex;align-items:center;justify-content:center;padding:10px;text-align:center;transition:all .2s}
.trust-logo-tile:hover{border-color:var(--gold-400);box-shadow:0 4px 20px rgba(0,0,0,.08)}
.trust-logo-tile span{font-family:'Playfair Display',serif;font-size:13px;font-weight:600;color:var(--maroon-800);line-height:1.3}

/* PROMISE SECTION */
.promise-section{background:linear-gradient(180deg,var(--maroon-950),var(--maroon-900));color:var(--cream)}
.promise-grid{display:grid;grid-template-columns:1fr 1fr;gap:20px}
.promise-card{display:flex;gap:16px;background:rgba(26,5,16,.4);border:1px solid rgba(212,175,55,.15);border-radius:16px;padding:24px;transition:all .25s}
.promise-card:hover{border-color:rgba(212,175,55,.5);background:rgba(45,10,30,.6)}
.promise-num{width:44px;height:44px;border-radius:50%;background:rgba(212,175,55,.15);border:1px solid rgba(212,175,55,.4);display:flex;align-items:center;justify-content:center;font-family:'Playfair Display',serif;font-weight:700;color:var(--gold-300);flex-shrink:0;font-size:13px;transition:all .25s}
.promise-card:hover .promise-num{background:var(--gold-400);color:var(--maroon-950)}
.promise-card h3{font-family:'Playfair Display',serif;font-size:18px;color:var(--gold-200);margin-bottom:6px}
.promise-card p{font-size:14px;color:rgba(253,247,240,.75);line-height:1.7}

/* STATS */
.stats-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:24px;margin-bottom:64px}
.stat-card{background:var(--white);border:1px solid var(--maroon-100);border-radius:16px;padding:28px;text-align:center;box-shadow:0 2px 8px rgba(0,0,0,.03)}
.stat-num{font-family:'Playfair Display',serif;font-size:52px;font-weight:700;color:var(--maroon-800);line-height:1}
.stat-label{font-size:11px;text-transform:uppercase;letter-spacing:.18em;color:rgba(136,5,21,.7);margin-top:8px}

/* TICKETS */
.tickets-section{background:linear-gradient(180deg,var(--maroon-950),#0a0307);color:var(--cream)}
.ticket-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:24px;margin-top:56px}
.ticket-card{border:1px solid rgba(212,175,55,.2);background:rgba(45,10,30,.5);border-radius:16px;padding:28px;display:flex;flex-direction:column}
.ticket-card.featured{border:2px solid var(--gold-400);background:linear-gradient(180deg,var(--maroon-800),var(--maroon-950));transform:translateY(-16px);box-shadow:0 24px 60px rgba(212,175,55,.2);position:relative}
.ticket-featured-badge{position:absolute;top:-13px;left:50%;transform:translateX(-50%);background:var(--gold-400);color:var(--maroon-950);font-size:10px;font-weight:800;letter-spacing:.15em;text-transform:uppercase;padding:4px 14px;border-radius:50px;white-space:nowrap}
.ticket-for{font-size:11px;color:rgba(212,175,55,.7);font-style:italic;margin-bottom:8px}
.ticket-type{font-size:10px;letter-spacing:.2em;text-transform:uppercase;color:var(--gold-300);margin-bottom:4px}
.ticket-name{font-family:'Playfair Display',serif;font-size:22px;font-weight:700;margin-bottom:20px}
.ticket-price{display:flex;align-items:baseline;gap:8px;margin-bottom:4px}
.ticket-price-main{font-family:'Playfair Display',serif;font-size:36px;font-weight:700;color:var(--gold-200)}
.ticket-price-alt{font-size:13px;color:rgba(253,247,240,.35)}
.ticket-price-sub{font-size:11px;color:rgba(253,247,240,.5);margin-bottom:24px}
.ticket-savings{background:rgba(212,175,55,.15);border:1px solid rgba(212,175,55,.3);border-radius:8px;padding:8px 12px;font-size:12px;color:var(--gold-300);font-weight:600;margin-bottom:16px;text-align:center}
.ticket-features{list-style:none;display:flex;flex-direction:column;gap:10px;flex:1;margin-bottom:24px}
.ticket-features li{display:flex;align-items:flex-start;gap:8px;font-size:13px;color:rgba(253,247,240,.85)}
.ticket-btn{text-align:center;border-radius:50px;padding:14px;font-weight:700;font-size:12px;text-transform:uppercase;letter-spacing:.1em;text-decoration:none;display:block;transition:all .2s}
.ticket-btn-primary{background:var(--gold-400);color:var(--maroon-950)}
.ticket-btn-primary:hover{background:var(--gold-300)}
.ticket-btn-outline{border:1px solid var(--gold-400);color:var(--gold-300)}
.ticket-btn-outline:hover{background:var(--gold-400);color:var(--maroon-950)}
.combo-options{display:flex;flex-direction:column;gap:10px;flex:1;margin-bottom:16px}
.combo-option{background:rgba(26,5,16,.5);border:1px solid rgba(212,175,55,.2);border-radius:10px;padding:12px}
.combo-option-top{display:flex;justify-content:space-between;align-items:baseline}
.combo-option-top span:first-child{font-weight:600;color:var(--gold-100,#f0d87a);font-size:14px}
.combo-price{font-family:'Playfair Display',serif;font-size:18px;font-weight:700;color:var(--gold-200)}
.combo-sub{font-size:11px;color:rgba(253,247,240,.5);margin-top:2px}
.ticket-combo-btns{display:grid;grid-template-columns:1fr 1fr;gap:8px}

/* SPEAKERS */
.speakers-section{background:var(--maroon-950);color:var(--cream)}
.speaker-card{border:1px solid rgba(212,175,55,.15);border-radius:16px;overflow:hidden;background:linear-gradient(180deg,var(--maroon-900),var(--maroon-950));position:relative;transition:border-color .25s;height:100%}
.speaker-card:hover{border-color:rgba(212,175,55,.5)}
.speaker-img{width:100%;aspect-ratio:1;object-fit:cover;display:block;transition:transform .7s}
.speaker-card:hover .speaker-img{transform:scale(1.05)}
.speaker-info{position:absolute;inset:0;top:auto;padding:20px;background:linear-gradient(transparent,rgba(26,5,16,.95) 40%)}
.speaker-info h3{font-family:'Playfair Display',serif;font-size:19px;font-weight:700;color:var(--gold-100,#f0d87a)}
.speaker-info .role{font-size:13px;color:var(--gold-300);margin-top:2px}
.speaker-info .org{font-size:11px;color:rgba(253,247,240,.55);margin-top:2px}

/* EVENT HIGHLIGHTS */
.highlights-section{background:var(--maroon-900);padding:80px 0;color:var(--cream)}
.highlights-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:16px;margin-top:48px}
.highlight-card{border-radius:16px;overflow:hidden;position:relative;aspect-ratio:4/3;background:linear-gradient(135deg,var(--maroon-800),var(--maroon-950));display:flex;align-items:center;justify-content:center;border:1px solid rgba(212,175,55,.15);transition:all .3s}
.highlight-card:hover{border-color:rgba(212,175,55,.5);transform:scale(1.02)}
.highlight-card.large{grid-column:span 2;aspect-ratio:2/1}
.highlight-card-inner{text-align:center;padding:32px}
.highlight-icon{font-size:40px;margin-bottom:12px;display:block}
.highlight-card h3{font-family:'Playfair Display',serif;font-size:20px;color:var(--gold-200);margin-bottom:8px}
.highlight-card p{font-size:13px;color:rgba(253,247,240,.6);line-height:1.6}
.highlight-stat{font-family:'Playfair Display',serif;font-size:36px;font-weight:700;color:var(--gold-300);display:block;margin-bottom:4px}

/* TESTIMONIALS */
.testimonial-card{background:var(--white);border:1px solid var(--maroon-100);border-radius:16px;padding:28px;box-shadow:0 2px 8px rgba(0,0,0,.03);display:flex;flex-direction:column}
.testimonial-avatar{width:52px;height:52px;border-radius:50%;background:linear-gradient(135deg,var(--maroon-700),var(--maroon-900));display:flex;align-items:center;justify-content:center;font-family:'Playfair Display',serif;font-weight:700;color:var(--gold-300);font-size:20px;flex-shrink:0;margin-bottom:16px}
.stars{display:flex;gap:2px;margin-bottom:12px}
.star{color:var(--gold-500);font-size:16px}
.testimonial-card blockquote{font-family:'Playfair Display',serif;font-size:16px;color:var(--maroon-900);font-style:italic;line-height:1.6;flex:1;margin-bottom:20px}
.testimonial-author{border-top:1px solid var(--maroon-100);padding-top:16px}
.testimonial-author strong{display:block;color:var(--maroon-800);font-weight:700;font-size:15px}
.testimonial-author .position{font-size:13px;color:var(--maroon-700);font-weight:600;margin-top:1px}
.testimonial-author span{font-size:12px;color:rgba(45,26,16,.5);display:block;margin-top:2px}
.testimonial-result{display:inline-block;background:var(--gold-50);border:1px solid rgba(212,175,55,.3);border-radius:8px;padding:6px 12px;font-size:11px;font-weight:700;color:var(--gold-600);margin-top:10px;text-transform:uppercase;letter-spacing:0.06em}

/* PROGRAM */
.program-section{background:linear-gradient(180deg,var(--maroon-900),var(--maroon-950));color:var(--cream)}
.program-row{display:grid;grid-template-columns:200px 1fr;gap:24px;align-items:start;border:1px solid rgba(212,175,55,.15);background:rgba(26,5,16,.5);border-radius:12px;padding:20px 24px;transition:all .25s;margin-bottom:12px}
.program-row:last-child{margin-bottom:0}
.program-row:hover{background:rgba(45,10,30,.7);border-color:rgba(212,175,55,.4)}
.program-day{font-size:10px;letter-spacing:.2em;text-transform:uppercase;color:rgba(232,204,106,.8)}
.program-row h3{font-family:'Playfair Display',serif;font-size:19px;color:var(--gold-200);margin-bottom:4px}
.program-row p{font-size:13px;color:rgba(253,247,240,.65);line-height:1.6}

/* ROI SECTION */
.roi-section{background:var(--cream);padding:80px 0}
.roi-compare-grid{display:grid;grid-template-columns:1fr auto 1fr;gap:24px;align-items:center;margin-top:48px}
.roi-vs{font-family:'Playfair Display',serif;font-size:28px;font-weight:900;color:var(--maroon-700);text-align:center}
.roi-card{background:var(--white);border:1px solid var(--maroon-100);border-radius:16px;padding:32px}
.roi-card.opportunity{border:2px solid var(--gold-400);background:linear-gradient(135deg,var(--gold-50),var(--cream));box-shadow:0 16px 40px rgba(212,175,55,.12)}
.roi-card h3{font-family:'Playfair Display',serif;font-size:20px;color:var(--maroon-900);margin-bottom:20px}
.roi-card.opportunity h3{color:var(--gold-700,#7a5a1a)}
.roi-item{display:flex;align-items:flex-start;gap:12px;padding:12px 0;border-bottom:1px solid var(--maroon-100)}
.roi-item:last-child{border-bottom:none}
.roi-item-label{font-size:14px;color:rgba(45,26,16,.8);flex:1}
.roi-item-value{font-family:'Playfair Display',serif;font-size:18px;font-weight:700;color:var(--maroon-800);flex-shrink:0}
.roi-item.opportunity .roi-item-value{color:var(--gold-600)}
.roi-ticket-highlight{text-align:center;margin-top:40px;padding:32px;background:linear-gradient(135deg,var(--maroon-950),#3d0828);border-radius:16px;color:var(--cream)}
.roi-ticket-highlight p{color:rgba(253,247,240,.75);margin-bottom:8px;font-size:15px}
.roi-ticket-highlight strong{font-family:'Playfair Display',serif;font-size:36px;color:var(--gold-300)}

/* FOUNDER STORY */
.founder-section{background:linear-gradient(180deg,var(--maroon-950),var(--maroon-900));padding:80px 0;color:var(--cream)}
.founder-grid{display:grid;grid-template-columns:1fr 2fr;gap:64px;align-items:start}
.founder-avatar{width:100%;aspect-ratio:1;border-radius:20px;background:linear-gradient(135deg,var(--maroon-800),var(--maroon-950));border:2px solid rgba(212,175,55,.3);display:flex;align-items:center;justify-content:center;flex-direction:column;gap:12px;padding:40px}
.founder-avatar-initial{font-family:'Playfair Display',serif;font-size:72px;font-weight:900;color:var(--gold-300);line-height:1}
.founder-avatar-name{font-family:'Playfair Display',serif;font-size:16px;color:var(--gold-200);text-align:center}
.founder-avatar-title{font-size:12px;color:rgba(253,247,240,.5);text-align:center;letter-spacing:.1em;text-transform:uppercase}
.founder-content h2{font-family:'Playfair Display',serif;font-size:clamp(24px,3.5vw,40px);color:var(--gold-200);margin-bottom:8px;line-height:1.15}
.founder-content .subtitle{font-size:16px;color:var(--gold-400);font-style:italic;margin-bottom:28px}
.founder-content p{font-size:15px;color:rgba(253,247,240,.78);line-height:1.8;margin-bottom:16px}
.founder-stats{display:flex;gap:32px;margin-top:28px;padding-top:28px;border-top:1px solid rgba(212,175,55,.2)}
.founder-stat strong{font-family:'Playfair Display',serif;font-size:32px;color:var(--gold-300);display:block}
.founder-stat span{font-size:12px;color:rgba(253,247,240,.5);text-transform:uppercase;letter-spacing:.12em}

/* COST COMPARE */
.cost-grid{display:grid;grid-template-columns:1fr 1fr;gap:20px;margin-top:48px}
.cost-bad{border:2px solid var(--maroon-200);background:var(--white);border-radius:16px;padding:28px}
.cost-good{border:2px solid var(--gold-400);background:linear-gradient(135deg,var(--gold-50),var(--cream));border-radius:16px;padding:28px;position:relative;box-shadow:0 16px 40px rgba(212,175,55,.12)}
.cost-rec-badge{position:absolute;top:-12px;left:24px;background:var(--gold-400);color:var(--maroon-950);font-size:10px;font-weight:800;letter-spacing:.2em;text-transform:uppercase;padding:4px 14px;border-radius:50px}
.cost-header{display:flex;align-items:center;gap:8px;font-weight:700;text-transform:uppercase;letter-spacing:.08em;font-size:13px;margin-bottom:20px}
.cost-header.bad{color:var(--maroon-700)}
.cost-header.good{color:var(--gold-700,#7a5a1a)}
.cost-list{list-style:none;display:flex;flex-direction:column;gap:12px;margin-bottom:24px}
.cost-list li{display:flex;align-items:flex-start;gap:10px;font-size:14px;color:rgba(45,26,16,.8)}
.cost-total-label{font-size:11px;text-transform:uppercase;letter-spacing:.18em;color:rgba(136,5,21,.65);margin-bottom:4px}
.cost-total-label.good{color:rgba(122,90,26,.7)}
.cost-total-num{font-family:'Playfair Display',serif;font-size:30px;font-weight:700;color:var(--maroon-800)}
.cost-total-sub{font-size:12px;color:rgba(45,26,16,.45);margin-top:2px}
.cost-divider{height:1px;background:var(--maroon-100);margin-bottom:20px}
.cost-divider.good{background:rgba(212,175,55,.3)}

/* PILLAR CARDS */
.pillar-card{background:var(--white);border:1px solid var(--maroon-100);border-radius:16px;padding:28px;position:relative;overflow:hidden;transition:all .25s}
.pillar-card:hover{box-shadow:0 20px 50px rgba(0,0,0,.1);transform:translateY(-4px)}
.pillar-bg-num{position:absolute;top:-8px;right:-8px;font-family:'Playfair Display',serif;font-size:80px;font-weight:900;color:var(--maroon-100);line-height:1;transition:color .25s}
.pillar-card:hover .pillar-bg-num{color:rgba(212,175,55,.15)}
.pillar-card h3{font-family:'Playfair Display',serif;font-size:22px;font-weight:700;color:var(--maroon-900);position:relative}
.pillar-divider{width:40px;height:2px;background:var(--gold-400);margin:12px 0 16px;position:relative}
.pillar-card p{font-size:14px;color:rgba(45,26,16,.7);line-height:1.7;position:relative}

/* FAQ */
.faq-section{background:var(--white)}
.faq-item{border:1px solid var(--maroon-100);background:rgba(253,247,240,.4);border-radius:12px;margin-bottom:10px;overflow:hidden;transition:border-color .2s}
.faq-item[open]{background:var(--white);border-color:var(--gold-400)}
.faq-summary{cursor:pointer;list-style:none;padding:18px 20px;display:flex;align-items:center;justify-content:space-between;gap:16px}
.faq-summary::-webkit-details-marker{display:none}
.faq-summary span:first-child{font-family:'Playfair Display',serif;font-size:17px;font-weight:600;color:var(--maroon-900)}
.faq-toggle{width:28px;height:28px;border-radius:50%;border:1px solid var(--maroon-200);display:flex;align-items:center;justify-content:center;font-weight:700;color:var(--maroon-800);flex-shrink:0;font-size:18px;transition:all .2s}
.faq-item[open] .faq-toggle{background:var(--gold-400);border-color:var(--gold-400);transform:rotate(45deg)}
.faq-body{padding:0 20px 18px;font-size:15px;color:rgba(45,26,16,.72);line-height:1.75}

/* FINAL CTA */
.final-cta{background:linear-gradient(135deg,var(--maroon-950),#5c030d,var(--maroon-900));color:var(--cream);text-align:center;padding:100px 0}
.final-cta h2{font-family:'Playfair Display',serif;font-size:clamp(28px,4.5vw,52px);font-weight:700;line-height:1.1;margin-bottom:20px}
.final-cta h2 .shine{background:linear-gradient(90deg,var(--gold-200),var(--gold-400),var(--gold-200));-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text}
.final-cta .subtitle{font-family:'Playfair Display',serif;font-size:clamp(18px,2.5vw,26px);color:var(--gold-200);margin-bottom:32px;line-height:1.4;font-style:italic}
.final-meta-row{display:flex;flex-wrap:wrap;justify-content:center;gap:16px;margin-bottom:36px}
.final-meta-item{display:flex;align-items:center;gap:8px;background:rgba(212,175,55,.1);border:1px solid rgba(212,175,55,.2);border-radius:50px;padding:8px 18px;font-size:13px;color:var(--gold-200);font-weight:600}
.final-cta-btns{display:flex;justify-content:center;flex-wrap:wrap;gap:16px;margin-bottom:20px}
.btn-final{background:var(--gold-400);color:var(--maroon-950);padding:18px 40px;border-radius:50px;font-weight:900;font-size:15px;text-transform:uppercase;letter-spacing:.1em;text-decoration:none;display:inline-flex;align-items:center;gap:8px;transition:background .2s;box-shadow:0 8px 40px rgba(212,175,55,.4)}
.btn-final:hover{background:var(--gold-300)}
.btn-final-outline{border:2px solid var(--gold-400);color:var(--gold-300);padding:16px 32px;border-radius:50px;font-weight:700;font-size:15px;text-transform:uppercase;letter-spacing:.1em;text-decoration:none;display:inline-flex;align-items:center;gap:8px;transition:all .2s}
.btn-final-outline:hover{background:var(--gold-400);color:var(--maroon-950)}
.final-urgency{background:rgba(212,175,55,.12);border:1px solid rgba(212,175,55,.3);border-radius:12px;padding:14px 24px;font-size:14px;color:var(--gold-200);font-weight:600;margin-bottom:24px;display:inline-block}
.final-cta-note{font-size:13px;color:rgba(253,247,240,.55);margin-bottom:24px}
.final-cta-note a{color:var(--gold-300);text-decoration:underline;font-weight:600}
.final-cta-trust{display:flex;flex-wrap:wrap;justify-content:center;gap:24px;font-size:11px;text-transform:uppercase;letter-spacing:.15em;color:rgba(253,247,240,.5);margin-bottom:40px}
.trust-item{display:flex;align-items:center;gap:6px}
.final-quote{font-style:italic;font-size:13px;color:rgba(253,247,240,.4);max-width:520px;margin:0 auto}

/* FOOTER */
footer{background:#0a0307;color:rgba(253,247,240,.65);padding:56px 0 24px;border-top:1px solid rgba(212,175,55,.1)}
.footer-grid{display:grid;grid-template-columns:2fr 1fr 1fr;gap:40px;margin-bottom:48px}
.footer-brand{display:flex;align-items:center;gap:12px;margin-bottom:16px}
.footer-desc{font-size:13px;line-height:1.8;max-width:400px}
.footer-heading{font-size:11px;text-transform:uppercase;letter-spacing:.2em;color:var(--gold-300);font-weight:700;margin-bottom:16px}
.footer-links{list-style:none;display:flex;flex-direction:column;gap:8px;font-size:13px}
.footer-links a{color:rgba(253,247,240,.65);text-decoration:none;transition:color .2s}
.footer-links a:hover{color:var(--gold-300)}
.footer-bottom{border-top:1px solid rgba(212,175,55,.1);padding-top:24px;display:flex;flex-wrap:wrap;justify-content:space-between;gap:8px;font-size:11px;color:rgba(253,247,240,.35)}

/* STICKY CTA */
.sticky-cta{position:fixed;bottom:0;left:0;right:0;z-index:999;background:rgba(26,5,16,.97);border-top:1px solid rgba(212,175,55,.3);padding:12px 24px;display:flex;align-items:center;gap:12px;backdrop-filter:blur(8px)}
.sticky-cta-inner{max-width:1200px;margin:0 auto;width:100%;display:flex;align-items:center;justify-content:space-between;gap:16px}
.sticky-cta-text{font-size:13px;color:rgba(253,247,240,.8)}
.sticky-cta-text strong{color:var(--gold-300)}
.sticky-cta-btns{display:flex;gap:8px;flex-shrink:0}
.sticky-cta-btn{background:var(--gold-400);color:var(--maroon-950);padding:10px 20px;border-radius:50px;font-weight:700;font-size:12px;text-transform:uppercase;letter-spacing:.08em;text-decoration:none;transition:background .2s;white-space:nowrap}
.sticky-cta-btn:hover{background:var(--gold-300)}
.sticky-cta-btn-secondary{border:1px solid var(--gold-400);color:var(--gold-300);padding:10px 20px;border-radius:50px;font-weight:700;font-size:12px;text-transform:uppercase;letter-spacing:.08em;text-decoration:none;transition:all .2s;white-space:nowrap}
.sticky-cta-btn-secondary:hover{background:var(--gold-400);color:var(--maroon-950)}

/* RESPONSIVE */
@media(max-width:1200px){
.container{padding:0 20px}
}
@media(max-width:1024px){
.grid-hero{grid-template-columns:1fr !important;gap:40px}
.promise-grid{grid-template-columns:1fr}
.trust-logo-grid{grid-template-columns:repeat(5,1fr)}
.stats-grid{grid-template-columns:repeat(2,1fr)}
.ticket-grid{grid-template-columns:1fr}
.ticket-card.featured{transform:none}
.founder-grid{grid-template-columns:1fr}
.founder-avatar{aspect-ratio:auto;padding:32px;flex-direction:row;gap:24px;align-items:center}
.who-grid{grid-template-columns:repeat(2,1fr)}
.roi-compare-grid{grid-template-columns:1fr;gap:16px}
.roi-vs{display:none}
.footer-grid{grid-template-columns:1fr 1fr}
/* Tickets page 2-col layout */
.tickets-main-grid{grid-template-columns:1fr !important}
}
@media(max-width:768px){
.grid-2,.grid-3,.grid-4{grid-template-columns:1fr}
.cost-grid{grid-template-columns:1fr}
.trust-logo-grid{grid-template-columns:repeat(3,1fr)}
.program-row{grid-template-columns:1fr}
.who-grid{grid-template-columns:repeat(2,1fr)}
.highlights-grid{grid-template-columns:1fr}
.highlight-card.large{grid-column:span 1;aspect-ratio:4/3}
.sticky-cta-text{display:none}
.footer-grid{grid-template-columns:1fr}
.founder-stats{flex-wrap:wrap;gap:16px}
/* Hero video section mobile */
.hero-video-section{padding:48px 0 !important}
/* Section padding reduction */
section{padding:64px 0}
.sub-hero{padding:44px 0}
/* Announcement bar text sizing */
.ann-bar{font-size:10px;padding:7px 12px}
.urgency-bar{font-size:12px}
/* CTA block padding */
.cta-block{padding:32px 24px}
/* Final CTA */
.final-cta{padding:72px 0}
/* Ticket form sticky disabled on mobile */
.ticket-form-card{position:static !important}
/* Tickets page grid stacking */
.tickets-main-grid{grid-template-columns:1fr !important;gap:32px !important}
}
@media(max-width:600px){
.card-btns{grid-template-columns:1fr}
.ticket-combo-btns{grid-template-columns:1fr}
.hero-btns{flex-direction:column;align-items:stretch}
.hero-btns .btn-primary,.hero-btns .btn-outline{text-align:center;justify-content:center}
.cta-block-btns{flex-direction:column;align-items:stretch}
.cta-block-btns a{text-align:center;justify-content:center}
.final-cta-btns{flex-direction:column;align-items:center}
.sticky-cta-btns{flex-direction:column;gap:6px}
.sticky-cta-btn,.sticky-cta-btn-secondary{font-size:11px;padding:8px 14px}
}
@media(max-width:480px){
section{padding:52px 0}
.trust-logo-grid{grid-template-columns:repeat(2,1fr)}
.stats-grid{grid-template-columns:1fr 1fr}
.countdown-grid{grid-template-columns:repeat(4,1fr)}
.cd-num{font-size:22px}
.cd-lbl{font-size:8px}
.who-grid{grid-template-columns:1fr 1fr}
.container{padding:0 16px}
.container-md{padding:0 16px}
.container-sm{padding:0 16px}
/* Nav logo sizing */
.nav-logo img{height:32px !important}
/* Footer adjustments */
footer{padding:44px 0 20px}
.footer-bottom{flex-direction:column;gap:6px;text-align:center}
/* Announcement / urgency bars */
.ann-bar{font-size:9px;padding:6px 10px;letter-spacing:0.07em}
.urgency-bar{font-size:11px;padding:8px 12px}
/* Section headings */
.sub-hero{padding:36px 0}
}
@media(prefers-reduced-motion:reduce){
.ticker-track{animation:none}
*{transition:none!important}
}
</style>
</head>
<body>

<!-- ANNOUNCEMENT BAR -->
<div class="ann-bar">
<?php echo htmlspecialchars($header_announcement); ?>
</div>

<!-- URGENCY BAR -->
<div class="urgency-bar">
<?php echo htmlspecialchars($header_urgency); ?>
</div>

<!-- HEADER NAVIGATION CONTAINER -->
<div class="header-nav-container">
    <div class="container">
        <nav class="header-nav">
            <a href="./" class="nav-logo">
                <img src="https://hotelmanagersconference.com/landingpage/images/hmc_logo.png" alt="HMC Africa" style="height: 40px;">
            </a>
            
            <button class="menu-toggle" id="menuToggle" aria-label="Toggle navigation">
                <span></span>
                <span></span>
                <span></span>
            </button>
            
            <div class="nav-links-wrapper" id="navLinksWrapper">
                <ul class="nav-links">
                    <?php foreach ($menu_items as $name => $link): ?>
                        <?php 
                            // Determine if this item is the active page
                            $active_class = (basename($current_page, '.php') === $link) ? 'class="active"' : '';
                        ?>
                        <li><a href="<?php echo htmlspecialchars($link); ?>" <?php echo $active_class; ?>><?php echo htmlspecialchars($name); ?></a></li>
                    <?php endforeach; ?>
                </ul>
                <a href="<?php echo htmlspecialchars($ticket_link); ?>" class="nav-cta">Register Now →</a>
            </div>
        </nav>
    </div>
</div>
