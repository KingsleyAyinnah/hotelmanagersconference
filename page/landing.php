<?php
require_once '../config/config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>Hotel Managers Conference Africa 2026 | <?php echo htmlspecialchars($event_date_range); ?>, Lagos</title>
<link rel="preconnect" href="https://fonts.googleapis.com"/>
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin/>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;0,900;1,700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet"/>
<base href="<?php echo htmlspecialchars($project_base); ?>">
<link rel="icon" type="image/png" href="<?php echo htmlspecialchars($project_base); ?>images/favicon.png?v=2"/>
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

/* HERO */
.hero{background:linear-gradient(135deg,var(--maroon-950) 0%,#5c030d 40%,var(--maroon-900) 100%);color:var(--cream);position:relative;overflow:hidden}
.hero::before{content:'';position:absolute;inset:0;background:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='60' height='60'%3E%3Ccircle cx='1' cy='1' r='1' fill='rgba(212,175,55,0.04)'/%3E%3C/svg%3E");pointer-events:none}
.hero-nav{display:flex;align-items:center;justify-content:space-between;padding:24px 0}
.nav-logo{display:flex;align-items:center;gap:12px}
.nav-logo-icon{width:40px;height:40px;border-radius:50%;background:linear-gradient(135deg,var(--gold-300),var(--gold-500));display:flex;align-items:center;justify-content:center;font-family:'Playfair Display',serif;font-weight:900;color:var(--maroon-950);font-size:18px}
.nav-logo-text{font-family:'Playfair Display',serif;font-size:20px;font-weight:700;color:var(--cream)}
.nav-logo-text span{color:var(--gold-300)}
.nav-cta{background:var(--gold-400);color:var(--maroon-950);padding:10px 20px;border-radius:50px;font-weight:700;font-size:13px;text-decoration:none;display:inline-flex;align-items:center;gap:6px;transition:background .2s}
.nav-cta:hover{background:var(--gold-300)}

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
.countdown-card{background:linear-gradient(135deg,rgba(56,0,7,.7),rgba(28,0,3,.9));border:1px solid rgba(212,175,55,.3);border-radius:16px;padding:32px;backdrop-filter:blur(8px);box-shadow:0 24px 60px rgba(0,0,0,.5);position:relative}
.countdown-label{position:absolute;top:-12px;left:50%;transform:translateX(-50%);background:var(--gold-400);color:var(--maroon-950);font-size:10px;font-weight:800;letter-spacing:.2em;text-transform:uppercase;padding:4px 14px;border-radius:50px;white-space:nowrap}
.countdown-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:8px;margin-bottom:24px}
.cd-unit{background:rgba(28,0,3,.6);border:1px solid rgba(212,175,55,.15);border-radius:10px;padding:12px 8px;text-align:center}
.cd-num{font-family:'Playfair Display',serif;font-size:32px;font-weight:700;color:var(--gold-200);line-height:1;display:block}
.cd-lbl{font-size:9px;text-transform:uppercase;letter-spacing:.15em;color:rgba(253,247,240,.5);margin-top:4px;display:block}
.card-divider{height:1px;background:linear-gradient(90deg,transparent,rgba(212,175,55,.3),transparent);margin:0 0 20px}
.card-checks{display:flex;flex-direction:column;gap:10px;margin-bottom:20px}
.card-check{display:flex;align-items:flex-start;gap:10px;font-size:13px;color:rgba(253,247,240,.9)}
.card-check svg{color:var(--gold-300);flex-shrink:0;margin-top:2px}
.card-price-box{background:rgba(28,0,3,.7);border:1px solid rgba(212,175,55,.2);border-radius:10px;padding:14px;text-align:center;margin-bottom:16px}
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
.ticker-wrap{border-top:1px solid rgba(212,175,55,.2);background:rgba(28,0,3,.6);padding:18px 0;overflow:hidden}
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
.promise-card{display:flex;gap:16px;background:rgba(28,0,3,.4);border:1px solid rgba(212,175,55,.15);border-radius:16px;padding:24px;transition:all .25s}
.promise-card:hover{border-color:rgba(212,175,55,.5);background:rgba(56,0,7,.6)}
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
.ticket-card{border:1px solid rgba(212,175,55,.2);background:rgba(56,0,7,.5);border-radius:16px;padding:28px;display:flex;flex-direction:column}
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
.combo-option{background:rgba(28,0,3,.5);border:1px solid rgba(212,175,55,.2);border-radius:10px;padding:12px}
.combo-option-top{display:flex;justify-content:space-between;align-items:baseline}
.combo-option-top span:first-child{font-weight:600;color:var(--gold-100,#f0d87a);font-size:14px}
.combo-price{font-family:'Playfair Display',serif;font-size:18px;font-weight:700;color:var(--gold-200)}
.combo-sub{font-size:11px;color:rgba(253,247,240,.5);margin-top:2px}
.ticket-combo-btns{display:grid;grid-template-columns:1fr 1fr;gap:8px}

/* SPEAKERS */
.speakers-section{background:var(--maroon-950);color:var(--cream)}
.speaker-card{border:1px solid rgba(212,175,55,.15);border-radius:16px;overflow:hidden;background:linear-gradient(180deg,var(--maroon-900),var(--maroon-950));position:relative;transition:border-color .25s}
.speaker-card:hover{border-color:rgba(212,175,55,.5)}
.landing-speaker-badge{position:absolute;top:16px;left:16px;background:var(--gold-400);color:var(--maroon-950);padding:4px 10px;border-radius:50px;font-size:8px;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;z-index:10;box-shadow:0 4px 10px rgba(0,0,0,0.15);border:1px solid var(--gold-200);line-height:1}
.landing-speaker-badge.regular-speaker{background:var(--maroon-800);color:var(--cream);border-color:rgba(255,255,255,0.15)}
.speaker-img{width:100%;aspect-ratio:1;object-fit:cover;display:block;transition:transform .7s}
.speaker-card:hover .speaker-img{transform:scale(1.05)}
.speaker-info{position:absolute;inset:0;top:auto;padding:20px;background:linear-gradient(transparent,rgba(28,0,3,.95) 40%)}
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
.testimonial-result{display:inline-block;background:var(--gold-50);border:1px solid rgba(212,175,55,.3);border-radius:8px;padding:6px 12px;font-size:11px;font-weight:700;color:var(--gold-600);margin-top:10px;text-transform:uppercase;letter-spacing:.06em}

/* PROGRAM */
.program-section{background:linear-gradient(180deg,var(--maroon-900),var(--maroon-950));color:var(--cream)}
.program-row{display:grid;grid-template-columns:200px 1fr;gap:24px;align-items:start;border:1px solid rgba(212,175,55,.15);background:rgba(28,0,3,.5);border-radius:12px;padding:20px 24px;transition:all .25s;margin-bottom:12px}
.program-row:last-child{margin-bottom:0}
.program-row:hover{background:rgba(56,0,7,.7);border-color:rgba(212,175,55,.4)}
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
.roi-ticket-highlight{text-align:center;margin-top:40px;padding:32px;background:linear-gradient(135deg,var(--maroon-950),#5c030d);border-radius:16px;color:var(--cream)}
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
.sticky-cta{position:fixed;bottom:0;left:0;right:0;z-index:999;background:rgba(28,0,3,.97);border-top:1px solid rgba(212,175,55,.3);padding:12px 24px;display:flex;align-items:center;gap:12px;backdrop-filter:blur(8px)}
.sticky-cta-inner{max-width:1200px;margin:0 auto;width:100%;display:flex;align-items:center;justify-content:space-between;gap:16px}
.sticky-cta-text{font-size:13px;color:rgba(253,247,240,.8)}
.sticky-cta-text strong{color:var(--gold-300)}
.sticky-cta-btns{display:flex;gap:8px;flex-shrink:0}
.sticky-cta-btn{background:var(--gold-400);color:var(--maroon-950);padding:10px 20px;border-radius:50px;font-weight:700;font-size:12px;text-transform:uppercase;letter-spacing:.08em;text-decoration:none;transition:background .2s;white-space:nowrap}
.sticky-cta-btn:hover{background:var(--gold-300)}
.sticky-cta-btn-secondary{border:1px solid var(--gold-400);color:var(--gold-300);padding:10px 20px;border-radius:50px;font-weight:700;font-size:12px;text-transform:uppercase;letter-spacing:.08em;text-decoration:none;transition:all .2s;white-space:nowrap}
.sticky-cta-btn-secondary:hover{background:var(--gold-400);color:var(--maroon-950)}

/* STICKY CTA FOOTER */
.sticky-cta-footer{position:fixed;bottom:0;left:0;right:0;z-index:998;background:rgba(28,0,3,.95);padding:8px 24px;display:flex;align-items:center;gap:12px;backdrop-filter:blur(8px)}
.sticky-cta-footer-inner{max-width:1200px;margin:0 auto;width:100%;text-align:center;font-size:11px;color:rgba(253,247,240,.6)}
.sticky-cta-footer-link{color:var(--gold-300);text-decoration:none;font-weight:600;transition:color .2s}
.sticky-cta-footer-link:hover{color:var(--gold-200);text-decoration:underline}

/* Adjust sticky CTA position to make room for footer */
.sticky-cta{bottom:30px}

/* RESPONSIVE */
@media(max-width:1024px){
.grid-hero{grid-template-columns:1fr;gap:40px}
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
}
@media(max-width:480px){
section{padding:60px 0}
.trust-logo-grid{grid-template-columns:repeat(2,1fr)}
.stats-grid{grid-template-columns:1fr 1fr}
.countdown-grid{grid-template-columns:repeat(4,1fr)}
.cd-num{font-size:24px}
.who-grid{grid-template-columns:1fr 1fr}
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
🏆 8th Annual Edition
<span>|</span>
<?php echo htmlspecialchars($event_date); ?>
<span>|</span>
<?php echo htmlspecialchars($event_location); ?>
</div>

<!-- URGENCY BAR -->
<div class="urgency-bar">
🔥 EARLY BIRD CLOSING SOON — Save ₦50,000 when you register before the deadline
</div>

<!-- ════════════════════════════════════════════ -->
<!-- 1. HERO -->
<!-- ════════════════════════════════════════════ -->
<section class="hero">
<div class="container">
<!-- NAV — Logo + Register only -->
<nav class="hero-nav">
<a href="./" class="nav-logo">
<img src="<?php echo htmlspecialchars($project_base); ?>images/logo.png" alt="HMC Africa" style="height: 40px;">
</a>
<a href="<?php echo htmlspecialchars($ticket_link); ?>" class="nav-cta">Reserve My Seat Now →</a>
</nav>

<!-- HERO CONTENT -->
<div class="grid-hero" style="padding:60px 0 80px">
<!-- LEFT -->
<div>
<div class="hero-badge">
<span class="hero-badge-dot"></span>
Africa's Premier Hospitality Leadership Conference
</div>

<h1 class="hero-h1 font-display">
<span class="shine">AFRICA'S PREMIER</span><br>
Hospitality Leadership<br>
<span class="gold">Conference</span>
</h1>

<p class="hero-subhead">For Hotel Owners, General Managers, Investors &amp; Hospitality Executives</p>

<p class="hero-sub">
Join <span class="gold">900+ hospitality leaders</span> from <span class="gold">16+ countries</span> for two days of executive learning, strategic partnerships, exhibitions, awards, networking and business growth opportunities.
</p>

<!-- TRUST INDICATORS -->
<div class="hero-trust-grid">
<div class="hero-trust-item">
<svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
8th Annual Edition
</div>
<div class="hero-trust-item">
<svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
900+ Delegates
</div>
<div class="hero-trust-item">
<svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
16 Countries
</div>
<div class="hero-trust-item">
<svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
20+ Industry Speakers
</div>
<div class="hero-trust-item">
<svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
200+ Hospitality Brands
</div>
</div>

<div class="hero-btns">
<a href="<?php echo htmlspecialchars($ticket_link); ?>" class="btn-primary">Reserve My Seat Now →</a>
<a href="tel:<?php echo $phone_number_link; ?>" class="btn-outline">📞 Speak With Us</a>
</div>

<div class="hero-meta">
<div class="hero-meta-item">
<svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
<?php echo htmlspecialchars($event_date_range); ?>
</div>
<div class="hero-meta-item">
<svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z"/><circle cx="12" cy="9" r="2.5"/></svg>
<?php echo htmlspecialchars($event_location); ?>
</div>
</div>
</div>

<!-- RIGHT – COUNTDOWN CARD -->
<div>
<div class="countdown-card">
<div class="countdown-label">Doors Open In</div>
<div class="countdown-grid" id="countdown">
<div class="cd-unit"><span class="cd-num" id="cd-days">00</span><span class="cd-lbl">Days</span></div>
<div class="cd-unit"><span class="cd-num" id="cd-hours">00</span><span class="cd-lbl">Hours</span></div>
<div class="cd-unit"><span class="cd-num" id="cd-mins">00</span><span class="cd-lbl">Mins</span></div>
<div class="cd-unit"><span class="cd-num" id="cd-secs">00</span><span class="cd-lbl">Secs</span></div>
</div>
<div class="card-divider"></div>
<div class="card-checks">
<div class="card-check"><svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>2 full days of executive masterclasses</div>
<div class="card-check"><svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>Gala dinner + HMC Awards ceremony</div>
<div class="card-check"><svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>Direct access to brand owners &amp; investors</div>
<div class="card-check"><svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>Certificate of Attendance (CPD-recognized)</div>
</div>
<div class="card-price-box">
<div class="card-price-label">Conference Ticket From</div>
<div class="card-price-main"><span>₦150,000</span><span>or $100</span></div>
<div class="card-price-sub">Virtual: ₦60,000 / $40 · Combo from $472</div>
</div>
<div class="card-btns">
<a href="<?php echo htmlspecialchars($ticket_link); ?>" class="card-btn-primary">Reserve My Seat Now</a>
<a href="tel:<?php echo $phone_number_link; ?>" class="card-btn-outline">📞 Call Us</a>
</div>
</div>
</div>
</div><!-- /grid-hero -->
</div><!-- /container -->

<!-- TICKER -->
<div class="ticker-wrap">
<div class="ticker-label">Trusted by 200+ Industry Leaders Across Africa</div>
<div style="overflow:hidden">
<div class="ticker-track" id="ticker">
<span>OPay</span><span>Lagos Continental</span><span>Nigerian Bottling Company</span><span>Huawei</span><span>Ikogosi</span><span>Presken Hotels</span><span>Staycore</span><span>Ogeyi Place Hotel</span><span>Sheraton Lagos</span><span>Radisson Blu</span><span>Elomaz Hotels</span><span>JS Signature House</span><span>Hotelinn</span><span>Locient</span><span>Serene Hospitality</span><span>Marriott Lagos Ikeja</span><span>IDS Next Dubai</span><span>Hotel Managers School</span>
<span>OPay</span><span>Lagos Continental</span><span>Nigerian Bottling Company</span><span>Huawei</span><span>Ikogosi</span><span>Presken Hotels</span><span>Staycore</span><span>Ogeyi Place Hotel</span><span>Sheraton Lagos</span><span>Radisson Blu</span><span>Elomaz Hotels</span><span>JS Signature House</span><span>Hotelinn</span><span>Locient</span><span>Serene Hospitality</span><span>Marriott Lagos Ikeja</span><span>IDS Next Dubai</span><span>Hotel Managers School</span>
</div>
</div>
</div>
</section>

<!-- ════════════════════════════════════════════ -->
<!-- 2. WHAT IS HMC AFRICA? -->
<!-- ════════════════════════════════════════════ -->
<section class="what-section">
<div class="container">
<div class="text-center" style="max-width:720px;margin:0 auto 56px">
<div class="section-eyebrow eyebrow-light">What Exactly Is This?</div>
<h2 class="section-h2 font-display" style="color:var(--maroon-900)">
What Exactly Is Hotel Managers<br><span class="italic" style="color:var(--gold-600)">Conference Africa?</span>
</h2>
<p class="section-p" style="margin-bottom:0">
You will understand exactly what you are registering for in the next 60 seconds. HMC Africa is not just a conference — it is <strong>five high-value experiences</strong> rolled into one two-day event.
</p>
</div>
<div class="grid-3" style="gap:20px">
<div class="what-card">
<div class="what-card-tag">Day 1 &amp; 2</div>
<div class="what-card-icon">🎓</div>
<h3>Executive Conference</h3>
<p>20+ expert-led keynotes, panels and masterclasses on operations, revenue, talent, technology and leadership — built specifically for African hospitality.</p>
</div>
<div class="what-card">
<div class="what-card-tag">Both Days</div>
<div class="what-card-icon">🏢</div>
<h3>Industry Exhibition</h3>
<p>200+ hospitality brands, PMS vendors, F&amp;B suppliers, tech providers and investors exhibiting. Touch the products. Negotiate live. Make decisions on the spot.</p>
</div>
<div class="what-card">
<div class="what-card-tag">Exclusive</div>
<div class="what-card-icon">🎓</div>
<h3>Executive Masterclasses</h3>
<p>Deep-dive working sessions with practitioners actively running flagship African properties. Bring your challenge. Leave with a 90-day action plan.</p>
</div>
<div class="what-card">
<div class="what-card-tag">Structured</div>
<div class="what-card-icon">🤝</div>
<h3>Strategic Networking</h3>
<p>900+ peers from 16 countries. Structured introductions, cocktail receptions and a black-tie gala dinner. Real relationships, not LinkedIn requests.</p>
</div>
<div class="what-card">
<div class="what-card-tag">Annual</div>
<div class="what-card-icon">🏆</div>
<h3>HMC Awards Ceremony</h3>
<p>Africa's most prestigious hospitality awards — recognising excellence across properties, professionals and brands continent-wide. Be nominated. Be celebrated.</p>
</div>
<div class="what-card" style="border:2px solid var(--gold-400);background:linear-gradient(135deg,var(--gold-50),var(--cream))">
<div class="what-card-tag" style="background:var(--gold-400);color:var(--maroon-950);border-color:var(--gold-400)">July 11–12</div>
<div class="what-card-icon" style="background:linear-gradient(135deg,var(--maroon-100),var(--maroon-200))">📍</div>
<h3 style="color:var(--maroon-900)">All Under One Roof</h3>
<p style="color:rgba(45,26,16,.75)">Lagos Continental Hotel, Victoria Island — West Africa's most prestigious event venue. One ticket. Five experiences. Two transformational days.</p>
</div>
</div>

<!-- CTA BLOCK AFTER WHAT IS HMC -->
<div style="margin-top:56px">
<div class="cta-block">
<h3>Ready to experience all five?</h3>
<p>Join 900+ hospitality leaders from 16 countries. Secure your place before Early Bird pricing ends.</p>
<div class="cta-block-btns">
<a href="<?php echo htmlspecialchars($ticket_link); ?>" class="btn-cta-primary">Reserve My Seat Now →</a>
<a href="tel:<?php echo $phone_number_link; ?>" class="btn-cta-outline">📞 Speak With Us</a>
</div>
</div>
</div>
</div>
</section>

<!-- ════════════════════════════════════════════ -->
<!-- 3. WHO SHOULD ATTEND -->
<!-- ════════════════════════════════════════════ -->
<section class="who-section">
<div class="container">
<div class="text-center" style="max-width:720px;margin:0 auto 56px">
<div class="section-eyebrow eyebrow-dark">Who is this for?</div>
<h2 class="section-h2 font-display">If you are on this list, <span class="shine italic">you belong in the room.</span></h2>
<p class="section-p dark" style="margin-bottom:0">HMC Africa is built specifically for leaders responsible for driving revenue, managing talent, and ensuring operational standard in African properties.</p>
</div>
<div class="who-grid">
<div class="who-card"><span class="who-card-icon">🏢</span><h3>Hotel Owners &amp; Investors</h3><p>Ensure your asset is performing. Meet operators, brands and vendors to scale your hospitality portfolio.</p></div>
<div class="who-card"><span class="who-card-icon">💼</span><h3>General Managers</h3><p>Learn global best practices, see new technology, and network with peers running flagship African properties.</p></div>
<div class="who-card"><span class="who-card-icon">📈</span><h3>Directors of F&amp;B</h3><p>Discover new suppliers, PMS/RMS tools, and kitchen optimization systems that protect your margins.</p></div>
<div class="who-card"><span class="who-card-icon">👥</span><h3>HR Directors</h3><p>Source talent, benchmark compensation packages, and learn retention strategies directly from industry academics.</p></div>
</div>
</div>
</section>

<!-- ════════════════════════════════════════════ -->
<!-- 4. PAIN POINTS / PROBLEMS -->
<!-- ════════════════════════════════════════════ -->
<section style="background:var(--cream);padding:80px 0">
<div class="container">
<div class="text-center" style="max-width:720px;margin:0 auto 56px">
<div class="section-eyebrow eyebrow-light">The Challenge</div>
<h2 class="section-h2 font-display" style="color:var(--maroon-900)">
Hospitality in Africa <span class="italic" style="color:var(--gold-600)">isn't copy-paste.</span>
</h2>
<p class="section-p" style="margin-bottom:0">What works in London or Dubai doesn't work in Lagos or Nairobi. Here, hoteliers deal with challenges global textbooks never mention.</p>
</div>
<div class="grid-3" style="gap:20px">
<div class="pain-card">
<svg class="quote-icon" fill="currentColor" viewBox="0 0 24 24"><path d="M13 14.725c0-5.141 3.892-10.519 10-11.725l.944 2c-3.059 1.157-4.944 4.503-4.944 7.725h4v9h-10v-7zm-13 0c0-5.141 3.892-10.519 10-11.725l.944 2c-3.059 1.157-4.944 4.503-4.944 7.725h4v9h-10v-7z"/></svg>
<p>"I spent years trying to apply standard PMS playbooks, only to find our local infrastructure needed a completely custom integration."</p>
</div>
<div class="pain-card">
<svg class="quote-icon" fill="currentColor" viewBox="0 0 24 24"><path d="M13 14.725c0-5.141 3.892-10.519 10-11.725l.944 2c-3.059 1.157-4.944 4.503-4.944 7.725h4v9h-10v-7zm-13 0c0-5.141 3.892-10.519 10-11.725l.944 2c-3.059 1.157-4.944 4.503-4.944 7.725h4v9h-10v-7z"/></svg>
<p>"Finding and retaining 5-star hospitality talent in West Africa is an ongoing challenge. The turnover rates are unsustainable."</p>
</div>
<div class="pain-card">
<svg class="quote-icon" fill="currentColor" viewBox="0 0 24 24"><path d="M13 14.725c0-5.141 3.892-10.519 10-11.725l.944 2c-3.059 1.157-4.944 4.503-4.944 7.725h4v9h-10v-7zm-13 0c0-5.141 3.892-10.519 10-11.725l.944 2c-3.059 1.157-4.944 4.503-4.944 7.725h4v9h-10v-7z"/></svg>
<p>"Energy costs and supply chain delays eat our F&amp;B margins before we even open the doors. We have to learn local efficiencies."</p>
</div>
</div>
</div>
</section>

<!-- ════════════════════════════════════════════ -->
<!-- 5. THE PROMISE / SOLUTION -->
<!-- ════════════════════════════════════════════ -->
<section class="promise-section">
<div class="container">
<div class="text-center" style="max-width:720px;margin:0 auto 56px">
<div class="section-eyebrow eyebrow-dark">The Promise</div>
<h2 class="section-h2 font-display">Six ways HMC Africa will <span class="shine italic">transform your year.</span></h2>
<p class="section-p dark" style="margin-bottom:0">We don't do generic panels. Every session is engineered to give you a concrete, executable playbook you can implement the very next Monday.</p>
</div>
<div class="promise-grid">
<div class="promise-card"><div class="promise-num">01</div><div><h3>Tested Operations Playbooks</h3><p>Get the exact SOPs and operational checklists used by flagship properties to maintain 5-star standards in Africa.</p></div></div>
<div class="promise-card"><div class="promise-num">02</div><div><h3>Revenue &amp; Margin Protection</h3><p>Learn how to optimize your room rates, manage energy costs, and protect F&amp;B margins despite inflation.</p></div></div>
<div class="promise-card"><div class="promise-num">03</div><div><h3>Direct Vendor Access</h3><p>Skip the middleman. Meet the top PMS, RMS, kitchen and energy vendors exhibiting live in the hall.</p></div></div>
<div class="promise-card"><div class="promise-num">04</div><div><h3>Talent Retention Systems</h3><p>Discover human resource systems built to find, train, and keep top-tier hospitality professionals in Africa.</p></div></div>
<div class="promise-card"><div class="promise-num">05</div><div><h3>Strategic Partnerships</h3><p>Network with owners, GMs, and investors from 16 countries. Make the connections that lead to new management contracts.</p></div></div>
<div class="promise-card"><div class="promise-num">06</div><div><h3>Recognised Certification</h3><p>Every delegate receives a CPD-recognised Certificate of Attendance to validate their executive training.</p></div></div>
</div>
</div>
</section>

<!-- ════════════════════════════════════════════ -->
<!-- 6. NUMBERS / STATS / SOCIAL PROOF -->
<!-- ════════════════════════════════════════════ -->
<section style="background:var(--cream);padding:80px 0">
<div class="container">
<div class="stats-grid">
<div class="stat-card"><div class="stat-num font-display">8th</div><div class="stat-label">Annual Edition</div></div>
<div class="stat-card"><div class="stat-num font-display">900+</div><div class="stat-label">Delegates</div></div>
<div class="stat-card"><div class="stat-num font-display">16+</div><div class="stat-label">Countries</div></div>
<div class="stat-card"><div class="stat-num font-display">200+</div><div class="stat-label">Hospitality Brands</div></div>
</div>

<div class="text-center" style="max-width:720px;margin:0 auto 56px">
<div class="section-eyebrow eyebrow-light">Proven Track Record</div>
<h2 class="section-h2 font-display" style="color:var(--maroon-900)">
We've been doing this <span class="italic" style="color:var(--gold-600)">since 2018.</span>
</h2>
<p class="section-p" style="margin-bottom:0">Seven annual editions across Africa. Thousands of hoteliers trained. Millions of dollars in deals facilitated. HMC Africa is the continent's most trusted hospitality platform.</p>
</div>

<div class="trust-logo-grid">
<div class="trust-logo-tile"><span>OPay</span></div>
<div class="trust-logo-tile"><span>Lagos Continental</span></div>
<div class="trust-logo-tile"><span>Presken Hotels</span></div>
<div class="trust-logo-tile"><span>Huawei</span></div>
<div class="trust-logo-tile"><span>IDS Next Dubai</span></div>
<div class="trust-logo-tile"><span>Staycore</span></div>
<div class="trust-logo-tile"><span>Radisson Blu</span></div>
</div>

<!-- CTA BLOCK IN MIDDLE -->
<div style="margin-top:56px">
<div class="cta-block" style="background:rgba(255,255,255,.04);border-color:rgba(212,175,55,.3)">
<h3>These outcomes are reserved for delegates in the room.</h3>
<p style="color:rgba(253,247,240,.7)">Virtual access available. But the real transformations happen in person. Secure your physical seat before they sell out.</p>
<div class="cta-block-btns">
<a href="<?php echo htmlspecialchars($ticket_link); ?>" class="btn-cta-primary">Reserve My Seat Now →</a>
<a href="tel:<?php echo $phone_number_link; ?>" class="btn-cta-outline">📞 Speak With Us</a>
</div>
</div>
</div>
</div>
</section>

<!-- ════════════════════════════════════════════ -->
<!-- 7. TICKET OPTIONS (moved higher) -->
<!-- ════════════════════════════════════════════ -->
<section id="tickets" class="tickets-section" style="padding:80px 0">
<div class="container">
<div class="text-center" style="max-width:680px;margin:0 auto">
<div class="section-eyebrow eyebrow-dark">Reserve Your Seat</div>
<h2 class="section-h2 font-display">Three ways to <span class="shine italic">be in the room.</span></h2>
<p style="color:rgba(253,247,240,.65);margin-bottom:0">Prices rise after Early Bird closes. Once seats are gone, they are gone. Register now to lock in your rate.</p>
</div>
<div class="ticket-grid">

<!-- VIRTUAL -->
<div class="ticket-card">
<div class="ticket-for">Perfect For: Remote Teams &amp; International Delegates</div>
<div class="ticket-type">Live Online Access</div>
<div class="ticket-name font-display">Virtual Pass</div>
<div class="ticket-price"><span class="ticket-price-main">₦60,000</span><span class="ticket-price-alt">or $40</span></div>
<div class="ticket-price-sub">Any country · Any timezone</div>
<div class="ticket-savings">✓ Most affordable entry — access Africa's top conference from anywhere</div>
<ul class="ticket-features">
<li><svg width="16" height="16" fill="none" stroke="var(--gold-300)" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>Live HD broadcast of both days</li>
<li><svg width="16" height="16" fill="none" stroke="var(--gold-300)" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>All keynotes &amp; masterclasses</li>
<li><svg width="16" height="16" fill="none" stroke="var(--gold-300)" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>Full conference materials &amp; slides</li>
<li><svg width="16" height="16" fill="none" stroke="var(--gold-300)" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>Certificate of Training</li>
<li><svg width="16" height="16" fill="none" stroke="var(--gold-300)" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>On-demand replay access (30 days)</li>
<li><svg width="16" height="16" fill="none" stroke="var(--gold-300)" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>Virtual speaker Q&amp;A</li>
</ul>
<a href="<?php echo htmlspecialchars($ticket_link); ?>" class="ticket-btn ticket-btn-outline">Register For HMC 2026 →</a>
</div>

<!-- REGULAR (FEATURED) -->
<div class="ticket-card featured">
<div class="ticket-featured-badge">⭐ Most Popular · Perfect For General Managers</div>
<div class="ticket-for">Perfect For: Hotel Owners &amp; GMs in Nigeria</div>
<div class="ticket-type">In-Person · Lagos Continental</div>
<div class="ticket-name font-display">Regular Conference</div>
<div class="ticket-price"><span class="ticket-price-main">₦150,000</span><span class="ticket-price-alt">or $100</span></div>
<div class="ticket-price-sub">Conference pass · Accommodation optional add-on</div>
<div class="ticket-savings">🔥 Early Bird — Save ₦50,000 before price increases</div>
<ul class="ticket-features">
<li><svg width="16" height="16" fill="none" stroke="var(--gold-300)" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>Full physical access — both days, July 11 &amp; 12</li>
<li><svg width="16" height="16" fill="none" stroke="var(--gold-300)" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>Grand African Ballroom, Lagos Continental</li>
<li><svg width="16" height="16" fill="none" stroke="var(--gold-300)" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>All masterclasses, panels &amp; workshops</li>
<li><svg width="16" height="16" fill="none" stroke="var(--gold-300)" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>Exhibition hall — meet 200+ vendors live</li>
<li><svg width="16" height="16" fill="none" stroke="var(--gold-300)" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>Coffee breaks, networking lunch &amp; refreshments</li>
<li><svg width="16" height="16" fill="none" stroke="var(--gold-300)" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>Networking cocktail with industry leaders</li>
<li><svg width="16" height="16" fill="none" stroke="var(--gold-300)" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>Hard-copy Certificate of Training (CPD)</li>
<li><svg width="16" height="16" fill="none" stroke="var(--gold-300)" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>Full conference materials &amp; operating playbooks</li>
</ul>
<a href="<?php echo htmlspecialchars($ticket_link); ?>" class="ticket-btn ticket-btn-primary">Reserve My Seat Now →</a>
</div>

<!-- COMBO -->
<div class="ticket-card">
<div class="ticket-for">Perfect For: Executive Teams &amp; International Delegates</div>
<div class="ticket-type">Conference + Accommodation</div>
<div class="ticket-name font-display">Combo Package</div>
<div class="ticket-price-sub" style="margin-bottom:20px">USD pricing for international delegates — everything included</div>
<div class="ticket-savings">✓ Conference + hotel + airport coordination + visa letter</div>
<div class="combo-options">
<div class="combo-option">
<div class="combo-option-top"><span>5★ Stay · 2 nights</span><span class="combo-price">$1,045</span></div>
<div class="combo-sub">Lagos Continental / Victoria Island</div>
</div>
<div class="combo-option">
<div class="combo-option-top"><span>3★ Stay · 2 nights</span><span class="combo-price">$672</span></div>
<div class="combo-sub">Best Western Plus / partner hotels</div>
</div>
<div class="combo-option" style="border-color:rgba(212,175,55,.4)">
<div class="combo-option-top"><span>Budget · 2 nights</span><span class="combo-price">$472</span></div>
<div class="combo-sub">HMC-accredited partner hotels</div>
</div>
<p style="font-size:12px;color:rgba(253,247,240,.6);font-style:italic">All combo packages include: full conference access, airport coordination &amp; visa support letter on request.</p>
</div>
<div class="ticket-combo-btns">
<a href="<?php echo htmlspecialchars($ticket_link); ?>" class="ticket-btn ticket-btn-primary">Secure My Ticket →</a>
<a href="tel:<?php echo $phone_number_link; ?>" class="ticket-btn-outline" style="text-align:center;border-radius:50px;padding:14px;font-weight:700;font-size:12px;text-transform:uppercase;letter-spacing:.1em;text-decoration:none;display:block;transition:all .2s">📞 Call Us</a>
</div>
</div>
</div>
<p style="margin-top:40px;text-align:center;font-size:13px;color:rgba(253,247,240,.5)">Prices in NGN · USD and bank transfer options available on the registration form · Corporate Table: ₦650,000 for 5 seats · Sponsorship &amp; Exhibitor packages on request</p>
</div>
</section>

<!-- ════════════════════════════════════════════ -->
<!-- 8. SPEAKERS -->
<!-- ════════════════════════════════════════════ -->
<section id="speakers" class="speakers-section" style="padding:80px 0">
<div class="container">
<div class="text-center" style="max-width:720px;margin:0 auto 56px">
<div class="section-eyebrow eyebrow-dark">The Voices on Stage</div>
<h2 class="section-h2 font-display">
These aren't influencers.<br>
<span class="shine italic">They've already solved</span> what you're struggling with.
</h2>
<p class="section-p dark" style="margin-bottom:0">GMs running flagship 5-stars. Academics shaping the next generation of hoteliers. Brand owners deciding the future of African hospitality. All in one room.</p>
</div>
<?php
$landing_speakers = [];
if ($pdo) {
    try {
        $landing_speakers = $pdo->query("SELECT * FROM `speakers` ORDER BY CASE WHEN LOWER(`category`) = 'keynote speaker' THEN 0 ELSE 1 END ASC, `id` ASC LIMIT 4")->fetchAll();
    } catch (PDOException $e) {
        // Silent fallback
    }
}
?>
<div class="grid-4">
<?php if (!empty($landing_speakers)): ?>
    <?php foreach ($landing_speakers as $s): ?>
        <?php
        $role = $s['title'];
        $org = '';
        if (strpos($s['title'], ',') !== false) {
            $parts = explode(',', $s['title'], 2);
            $role = trim($parts[0]);
            $org = trim($parts[1]);
        } elseif (strpos($s['title'], '-') !== false) {
            $parts = explode('-', $s['title'], 2);
            $role = trim($parts[0]);
            $org = trim($parts[1]);
        }
        
        $img_src = !empty($s['image']) ? htmlspecialchars($s['image']) : '';
        ?>
        <div class="speaker-card" style="height: 100%;">
            <?php 
                $cat = isset($s['category']) ? $s['category'] : 'Speaker';
                $badge_class = (strtolower($cat) === 'keynote speaker') ? '' : 'regular-speaker';
            ?>
            <span class="landing-speaker-badge <?php echo $badge_class; ?>"><?php echo htmlspecialchars($cat); ?></span>
            <?php if (!empty($img_src)): ?>
                <img src="<?php echo $img_src; ?>" alt="<?php echo htmlspecialchars($s['name']); ?>" class="speaker-img" loading="lazy"/>
            <?php else: ?>
                <div style="aspect-ratio: 1; font-size: 50px; color: var(--gold-300); display:flex; align-items:center; justify-content:center; background: linear-gradient(135deg, var(--maroon-900) 0%, var(--maroon-950) 100%);">
                    👤
                </div>
            <?php endif; ?>
            <div class="speaker-info">
                <h3><?php echo htmlspecialchars($s['name']); ?></h3>
                <div class="role"><?php echo htmlspecialchars($role); ?></div>
                <?php if (!empty($org)): ?>
                    <div class="org"><?php echo htmlspecialchars($org); ?></div>
                <?php endif; ?>
            </div>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <div class="speaker-card"><img src="https://i0.wp.com/hotelmanagersconference.com/wp-content/uploads/2024/05/Speaker-1.png?fit=600%2C600&ssl=1" alt="Ahmed Raza" class="speaker-img" loading="lazy"/><div class="speaker-info"><h3>Ahmed Raza</h3><div class="role">General Manager</div><div class="org">Radisson Blu, Victoria Island Lagos</div></div></div>
    <div class="speaker-card"><img src="https://i0.wp.com/hotelmanagersconference.com/wp-content/uploads/2025/05/speakers-1.png?fit=600%2C600&ssl=1" alt="Dr. Belinda Nwosu, FIH" class="speaker-img" loading="lazy"/><div class="speaker-info"><h3>Dr. Belinda Nwosu, FIH</h3><div class="role">Faculty &amp; Director, LBS Hospitality Initiative</div><div class="org">Lagos Business School</div></div></div>
    <div class="speaker-card"><img src="https://i0.wp.com/hotelmanagersconference.com/wp-content/uploads/2025/05/4.png?fit=600%2C600&ssl=1" alt="Prof. Wasiu Babalola" class="speaker-img" loading="lazy"/><div class="speaker-info"><h3>Prof. Wasiu Babalola</h3><div class="role">SVP Africa, Continent Worldwide Hotels (Türkiye)</div><div class="org">Atiba University, Oyo</div></div></div>
    <div class="speaker-card"><img src="https://i0.wp.com/hotelmanagersconference.com/wp-content/uploads/2021/10/speakers-1.png?fit=600%2C600&ssl=1" alt="Karl Hala" class="speaker-img" loading="lazy"/><div class="speaker-info"><h3>Karl Hala</h3><div class="role">Group General Manager</div><div class="org">Continental Hotels, Nigeria</div></div></div>
<?php endif; ?>
</div>
<div style="text-align:center;margin-top:40px">
    <a href="tickets" class="btn-outline" style="border-color:var(--gold-400);color:var(--gold-300);text-decoration:none;">See All Speakers</a>
</div>

<!-- CTA BLOCK AFTER SPEAKERS -->
<div style="margin-top:56px">
<div class="cta-block">
<h3>Want to learn from these leaders in person?</h3>
<p>Don't watch from a screen. Be in the room. Ask your question directly. Make the connection face to face.</p>
<div class="cta-block-btns">
<a href="<?php echo htmlspecialchars($ticket_link); ?>" class="btn-cta-primary">Reserve My Seat Now →</a>
<a href="tel:<?php echo $phone_number_link; ?>" class="btn-cta-outline">📞 <?php echo htmlspecialchars($phone_number_display); ?></a>
</div>
</div>
</div>
</div>
</section>

<!-- ════════════════════════════════════════════ -->
<!-- 9. EVENT HIGHLIGHTS / PREVIOUS EDITIONS -->
<!-- ════════════════════════════════════════════ -->
<section class="highlights-section">
<div class="container">
<div class="text-center" style="max-width:720px;margin:0 auto 16px">
<div class="section-eyebrow eyebrow-dark">Previous Editions</div>
<h2 class="section-h2 font-display">
See what happens when <span class="shine italic">Africa's best</span> gather in one room.
</h2>
<p class="section-p dark" style="margin-bottom:0">Seven editions. Thousands of careers elevated. Hundreds of deals made. Every year, bigger and better. HMC 2026 will be the largest yet.</p>
</div>
<div class="highlights-grid">
<div class="highlight-card large">
<div class="highlight-card-inner">
<span class="highlight-stat">900+</span>
<h3>Delegates Per Edition</h3>
<p>The Grand African Ballroom packed with the continent's most influential hospitality leaders — owners, GMs, investors, and operators all under one roof.</p>
</div>
</div>
<div class="highlight-card">
<div class="highlight-card-inner">
<span class="highlight-icon">🤝</span>
<h3>Strategic Networking</h3>
<p>Structured sessions where partnerships, hiring decisions, and deals are made — not just business cards exchanged.</p>
</div>
</div>
<div class="highlight-card">
<div class="highlight-card-inner">
<span class="highlight-icon">🏆</span>
<h3>HMC Awards Gala</h3>
<p>A black-tie celebration of Africa's finest hoteliers. Past winners have seen their careers transformed overnight.</p>
</div>
</div>
<div class="highlight-card">
<div class="highlight-card-inner">
<span class="highlight-icon">🏢</span>
<h3>Exhibition Hall</h3>
<p>200+ brands. Live product demos. Decision-ready buyers meeting solution-ready vendors face to face.</p>
</div>
</div>
<div class="highlight-card">
<div class="highlight-card-inner">
<span class="highlight-icon">🌍</span>
<h3>16 African Countries</h3>
<p>Delegates fly in from across the continent — Nigeria, Kenya, Uganda, Cameroon, Ghana, Rwanda and beyond.</p>
</div>
</div>
<div class="highlight-card">
<div class="highlight-card-inner">
<span class="highlight-icon">🎓</span>
<h3>Executive Masterclasses</h3>
<p>Intimate working sessions where real challenges get real solutions — not theory, but executable playbooks.</p>
</div>
</div>
</div>
<div style="text-align:center;margin-top:48px">
<a href="<?php echo htmlspecialchars($ticket_link); ?>" class="btn-cta-primary" style="background:var(--gold-400);color:var(--maroon-950);padding:15px 36px;border-radius:50px;font-weight:800;font-size:13px;text-transform:uppercase;letter-spacing:.08em;text-decoration:none;display:inline-flex;align-items:center;gap:8px;box-shadow:0 8px 24px rgba(212,175,55,.3)">Register For HMC 2026 — Secure Your Place →</a>
</div>
</div>
</section>

<!-- ════════════════════════════════════════════ -->
<!-- 10. TESTIMONIALS -->
<!-- ════════════════════════════════════════════ -->
<section style="background:var(--cream);padding:80px 0">
<div class="container">
<div class="text-center" style="max-width:720px;margin:0 auto 56px">
<div class="section-eyebrow eyebrow-light">What Delegates Say</div>
<h2 class="section-h2 font-display" style="color:var(--maroon-900)">
Don't take our word for it.<br>
<span class="italic" style="color:var(--gold-600)">Take theirs.</span>
</h2>
</div>
<div class="grid-3">
<div class="testimonial-card">
<div class="testimonial-avatar">A</div>
<div class="stars"><span class="star">★</span><span class="star">★</span><span class="star">★</span><span class="star">★</span><span class="star">★</span></div>
<blockquote>"I closed a partnership at HMC that added an extra ₦40 million to my F&amp;B revenue the following year. The ROI is laughable. I'll never miss it."</blockquote>
<div class="testimonial-author">
<strong>Adaeze Okonkwo</strong>
<div class="position">Group F&amp;B Director</div>
<span>Prestige Hospitality Group, Lagos</span>
<span class="testimonial-result">Result: +₦40M Annual F&amp;B Revenue</span>
</div>
</div>
<div class="testimonial-card">
<div class="testimonial-avatar">E</div>
<div class="stars"><span class="star">★</span><span class="star">★</span><span class="star">★</span><span class="star">★</span><span class="star">★</span></div>
<blockquote>"I sent three of my department heads. They came back with a turnaround plan we'd been trying to write for two years. HMC is non-negotiable on our annual calendar."</blockquote>
<div class="testimonial-author">
<strong>Emmanuel Eze</strong>
<div class="position">Managing Director</div>
<span>Heritage Hotels &amp; Suites, Abuja</span>
<span class="testimonial-result">Result: Complete Ops Turnaround in 6 months</span>
</div>
</div>
<div class="testimonial-card">
<div class="testimonial-avatar">C</div>
<div class="stars"><span class="star">★</span><span class="star">★</span><span class="star">★</span><span class="star">★</span><span class="star">★</span></div>
<blockquote>"Forget the sessions for a second — the connections alone justified the trip from Nairobi five times over. This is THE African hospitality event."</blockquote>
<div class="testimonial-author">
<strong>Christine Wanjiku</strong>
<div class="position">General Manager</div>
<span>Sovereign Hotel Group, Nairobi, Kenya</span>
<span class="testimonial-result">Result: 3 strategic partnerships formed</span>
</div>
</div>
</div>

<!-- CTA BLOCK AFTER TESTIMONIALS -->
<div style="margin-top:56px">
<div class="cta-block">
<h3>These results are waiting for you in July.</h3>
<p>Partnerships. Insights. Connections. Playbooks. Two days that pay for themselves ten times over. Will you be in the room?</p>
<div class="cta-block-btns">
<a href="<?php echo htmlspecialchars($ticket_link); ?>" class="btn-cta-primary">Reserve My Seat Now →</a>
<a href="tel:<?php echo $phone_number_link; ?>" class="btn-cta-outline">📞 Speak With Us</a>
</div>
</div>
</div>
</div>
</section>

<!-- ════════════════════════════════════════════ -->
<!-- 11. PROGRAM AGENDA -->
<!-- ════════════════════════════════════════════ -->
<section id="program" class="program-section" style="padding:80px 0">
<div class="container-md">
<div class="text-center" style="max-width:680px;margin:0 auto 56px">
<div class="section-eyebrow eyebrow-dark">Inside The Two Days</div>
<h2 class="section-h2 font-display">
A program engineered for <span class="shine italic">decision-makers,</span> not spectators.
</h2>
</div>
<div class="program-row"><div class="program-day">Day 1 · Morning</div><div><h3 class="font-display">Opening Keynote &amp; Africa Hospitality Outlook 2026–2030</h3><p>Setting the scene: where the money, growth and opportunity is moving across the continent.</p></div></div>
<div class="program-row"><div class="program-day">Day 1 · Midday</div><div><h3 class="font-display">Masterclass: Operational Excellence Through Global Best Practices</h3><p>A working session — bring your operations challenge, leave with a 90-day plan.</p></div></div>
<div class="program-row"><div class="program-day">Day 1 · Afternoon</div><div><h3 class="font-display">Panel: Brand Owners &amp; The Future of Africa's Hotel Landscape</h3><p>Karl Hala, Barr. Chike Ogeah, Ahmed Raza and more — unfiltered conversation, live Q&amp;A.</p></div></div>
<div class="program-row"><div class="program-day">Day 1 · Evening</div><div><h3 class="font-display">Networking Cocktail at the Lagos Continental Terrace</h3><p>The room where deals actually get done. Dress code: smart elegant.</p></div></div>
<div class="program-row"><div class="program-day">Day 2 · Morning</div><div><h3 class="font-display">Workshop: Building a 5-Star Talent &amp; Service Culture</h3><p>Dr. Belinda Nwosu (LBS) leads a deep-dive into people systems that retain top talent.</p></div></div>
<div class="program-row"><div class="program-day">Day 2 · Midday</div><div><h3 class="font-display">Exhibition Hall + Tech Demos (IDS Next &amp; more)</h3><p>Hands-on with the PMS, RMS, energy and F&amp;B tech that will define the next 5 years.</p></div></div>
<div class="program-row"><div class="program-day">Day 2 · Evening</div><div><h3 class="font-display">Gala Dinner &amp; The HMC Africa Awards 2026</h3><p>A black-tie celebration of the people and properties shaping hospitality excellence across Africa.</p></div></div>

<!-- CTA BLOCK AFTER PROGRAM -->
<div style="margin-top:48px">
<div class="cta-block">
<h3>Your seat at this program is waiting.</h3>
<p>Every session above is included in your conference ticket. Reserve now before Early Bird pricing closes.</p>
<div class="cta-block-btns">
<a href="<?php echo htmlspecialchars($ticket_link); ?>" class="btn-cta-primary">Secure My Ticket →</a>
<a href="tel:<?php echo $phone_number_link; ?>" class="btn-cta-outline">📞 Call <?php echo htmlspecialchars($phone_number_display); ?></a>
</div>
</div>
</div>
</div>
</section>

<!-- ════════════════════════════════════════════ -->
<!-- 12. ROI JUSTIFICATION SECTION -->
<!-- ════════════════════════════════════════════ -->
<section class="roi-section">
<div class="container">
<div class="text-center" style="max-width:720px;margin:0 auto 16px">
<div class="section-eyebrow eyebrow-light">The Business Case</div>
<h2 class="section-h2 font-display" style="color:var(--maroon-900)">
What Could One Strategic Connection<br>
<span class="italic" style="color:var(--gold-600)">Be Worth?</span>
</h2>
<p class="section-p" style="margin-bottom:0">Compare the potential value of a single opportunity discovered at HMC Africa — against the cost of your ticket.</p>
</div>

<div class="roi-compare-grid">
<div class="roi-card opportunity">
<div style="font-size:11px;text-transform:uppercase;letter-spacing:.2em;color:var(--gold-600);font-weight:700;margin-bottom:16px">The Opportunity</div>
<h3>One Connection. One Deal.</h3>
<div class="roi-item">
<div class="roi-item-label">One Partnership Contract Signed</div>
<div class="roi-item-value opportunity" style="color:var(--gold-600)">₦5M–₦50M+</div>
</div>
<div class="roi-item">
<div class="roi-item-label">One Investor Relationship Formed</div>
<div class="roi-item-value opportunity" style="color:var(--gold-600)">Priceless</div>
</div>
<div class="roi-item">
<div class="roi-item-label">One Group Booking Contract</div>
<div class="roi-item-value opportunity" style="color:var(--gold-600)">₦10M+</div>
</div>
<div class="roi-item">
<div class="roi-item-label">One Technology Discovery (cost saving)</div>
<div class="roi-item-value opportunity" style="color:var(--gold-600)">₦2M–₦20M/yr</div>
</div>
<div class="roi-item">
<div class="roi-item-label">One Operational Improvement (profit recovery)</div>
<div class="roi-item-value opportunity" style="color:var(--gold-600)">₦3M–₦30M/yr</div>
</div>
<div class="roi-item">
<div class="roi-item-label">Career Advancement / Executive Positioning</div>
<div class="roi-item-value opportunity" style="color:var(--gold-600)">Life-changing</div>
</div>
</div>

<div class="roi-vs">VS</div>

<div class="roi-card">
<div style="font-size:11px;text-transform:uppercase;letter-spacing:.2em;color:var(--maroon-700);font-weight:700;margin-bottom:16px">Your Investment</div>
<h3>The Conference Ticket</h3>
<div class="roi-item">
<div class="roi-item-label">Regular Conference (In-Person, Lagos)</div>
<div class="roi-item-value">₦150,000</div>
</div>
<div class="roi-item">
<div class="roi-item-label">Virtual Conference (Any Country)</div>
<div class="roi-item-value">₦60,000</div>
</div>
<div class="roi-item">
<div class="roi-item-label">Combo Package (Conference + Hotel)</div>
<div class="roi-item-value">from $472</div>
</div>
<div class="roi-item">
<div class="roi-item-label">Corporate Table (5 delegates)</div>
<div class="roi-item-value">₦650,000</div>
</div>
<div class="roi-item">
<div class="roi-item-label">14-Day Money-Back Guarantee</div>
<div class="roi-item-value" style="color:var(--maroon-700)">✓ Protected</div>
</div>
<div class="roi-item">
<div class="roi-item-label">Transferable Seat Policy</div>
<div class="roi-item-value" style="color:var(--maroon-700)">✓ Flexible</div>
</div>
</div>
</div>

<div class="roi-ticket-highlight">
<p>The ticket is not the expense. <strong>Missing the opportunity is.</strong></p>
<strong>₦150,000</strong>
<p style="margin-top:8px;font-size:13px;color:rgba(253,247,240,.6)">That's the entire investment for two days that could change the trajectory of your career, your property, and your business.</p>
<div style="margin-top:20px">
<a href="<?php echo htmlspecialchars($ticket_link); ?>" style="background:var(--gold-400);color:var(--maroon-950);padding:14px 32px;border-radius:50px;font-weight:800;font-size:13px;text-transform:uppercase;letter-spacing:.08em;text-decoration:none;display:inline-flex;align-items:center;gap:8px">Reserve My Seat Now →</a>
</div>
</div>

<!-- COST COMPARISON -->
<div style="margin-top:64px">
<div class="text-center" style="margin-bottom:48px">
<div class="section-eyebrow eyebrow-light">Let's Be Honest</div>
<h3 class="font-display" style="font-size:clamp(22px,3.5vw,36px);color:var(--maroon-900)">₦150,000 is what you spend on <span class="italic">one bad week</span> of underperformance.</h3>
<p style="font-size:16px;color:rgba(45,26,16,.65);margin-top:12px">Run the maths. Then ask yourself which decision is more expensive.</p>
</div>
<div class="cost-grid">
<div class="cost-bad">
<div class="cost-header bad"><svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>The Cost of NOT Attending</div>
<ul class="cost-list">
<li><svg width="18" height="18" fill="none" stroke="var(--maroon-600,#8a2252)" stroke-width="2.5" viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>One key hire who walks out within 6 months</li>
<li><svg width="18" height="18" fill="none" stroke="var(--maroon-600,#8a2252)" stroke-width="2.5" viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>One missed partnership with an international brand</li>
<li><svg width="18" height="18" fill="none" stroke="var(--maroon-600,#8a2252)" stroke-width="2.5" viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>One owner-meeting where you can't defend your numbers</li>
<li><svg width="18" height="18" fill="none" stroke="var(--maroon-600,#8a2252)" stroke-width="2.5" viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>Another year of guessing what 'global standard' means</li>
<li><svg width="18" height="18" fill="none" stroke="var(--maroon-600,#8a2252)" stroke-width="2.5" viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>Watching competitors lock in the deals you should have made</li>
</ul>
<div class="cost-divider"></div>
<div class="cost-total-label">Estimated annual cost</div>
<div class="cost-total-num font-display">₦10,000,000+</div>
</div>
<div class="cost-good">
<div class="cost-rec-badge">Recommended</div>
<div class="cost-header good"><svg width="20" height="20" fill="none" stroke="var(--gold-600)" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>The Cost of Showing Up</div>
<ul class="cost-list">
<li><svg width="18" height="18" fill="none" stroke="var(--gold-600)" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>Two days. ₦150,000. Lagos Continental.</li>
<li><svg width="18" height="18" fill="none" stroke="var(--gold-600)" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>A working playbook you actually use Monday morning</li>
<li><svg width="18" height="18" fill="none" stroke="var(--gold-600)" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>Direct relationships with brand owners and investors</li>
<li><svg width="18" height="18" fill="none" stroke="var(--gold-600)" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>Vendor decisions made — not pushed to next quarter</li>
<li><svg width="18" height="18" fill="none" stroke="var(--gold-600)" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>Your name in the room when the future is being decided</li>
</ul>
<div class="cost-divider good"></div>
<div class="cost-total-label good">Total investment — Regular</div>
<div class="cost-total-num font-display">₦150,000 <span style="font-size:15px;font-weight:400;color:rgba(45,26,16,.4)">or $100</span></div>
<div class="cost-total-sub">Virtual: ₦60K / $40 · Combo from $472</div>
</div>
</div>
</div>
</div>
</section>

<!-- ════════════════════════════════════════════ -->
<!-- 13. FOUNDER STORY -->
<!-- ════════════════════════════════════════════ -->
<section class="founder-section">
<div class="container">
<div class="text-center" style="max-width:720px;margin:0 auto 56px">
<div class="section-eyebrow eyebrow-dark">The Story Behind HMC Africa</div>
<h2 class="section-h2 font-display">
Why This Conference <span class="shine italic">Had to Exist.</span>
</h2>
</div>
<div class="founder-grid">
<div>
<div class="founder-avatar">
<div class="founder-avatar-initial">H</div>
<div class="founder-avatar-name">HMC Africa</div>
<div class="founder-avatar-title">Est. 2018 · Lagos, Nigeria</div>
</div>
<div class="founder-stats">
<div class="founder-stat"><strong>8</strong><span>Editions</span></div>
<div class="founder-stat"><strong>7K+</strong><span>Careers Impacted</span></div>
<div class="founder-stat"><strong>16</strong><span>Countries</span></div>
</div>
</div>
<div class="founder-content">
<h2>Built By Hoteliers. For Hoteliers.</h2>
<p class="subtitle">Synergising For Sustainable Growth Through Global Best Practices.</p>
<p>In 2018, there was no gathering in Africa dedicated entirely to the people who actually run hotels — the General Managers, operators, owners, and executives grinding daily to deliver world-class hospitality on African soil.</p>
<p>The knowledge existed. The talent existed. The ambition existed. But there was no platform where African hospitality professionals could gather, compare notes, learn from one another, connect with global brands, and be celebrated for their excellence.</p>
<p>So Hotel Managers Conference Africa was founded to fill that gap — not as a one-off event, but as the annual gathering point for everyone serious about elevating African hospitality to world-class standards.</p>
<p>Seven editions later, HMC Africa has become the continent's most anticipated hospitality event. Delegates now fly in from 16 countries. Brands queue to exhibit. Awards are the most coveted in the industry. And the conference keeps growing — because the mission has never changed:</p>
<p><strong style="color:var(--gold-300)">To give every African hotelier access to the knowledge, networks, and opportunities they need to build something truly world-class.</strong></p>
<p>HMC Africa 2026 — the 8th Edition — will be the largest, most impactful gathering yet. 900+ delegates. 20+ speakers. Two days. One room. One decision.</p>
<p style="color:rgba(253,247,240,.5);font-style:italic;font-size:14px">Will you be in it?</p>
</div>
</div>
</div>
</section>

<!-- ════════════════════════════════════════════ -->
<!-- 14. FAQ -->
<!-- ════════════════════════════════════════════ -->
<section class="faq-section" style="padding:80px 0">
<div class="container-sm">
<div class="text-center" style="margin-bottom:48px">
<div class="section-eyebrow eyebrow-light">Frequently Asked</div>
<h2 class="section-h2 font-display" style="color:var(--maroon-900)">The questions every hotelier asks before booking.</h2>
</div>
<details class="faq-item">
<summary class="faq-summary"><span>I'm a GM with limited time off — is two days really worth it?</span><span class="faq-toggle">+</span></summary>
<div class="faq-body">Every speaker on stage runs a property like yours. They've made the mistakes you're about to make, and the ones you're already making. Two days here saves you twenty-four months of trial and error. Delegates consistently report that a single insight from HMC pays for the ticket within 30 days.</div>
</details>
<details class="faq-item">
<summary class="faq-summary"><span>What if I'm not based in Nigeria?</span><span class="faq-toggle">+</span></summary>
<div class="faq-body">Past delegates have flown in from Kenya, Uganda, Cameroon, Ghana, Rwanda and beyond. We provide visa support letters, partner-hotel discount rates, and airport pickup coordination for international attendees. The Combo Package is specifically designed for you.</div>
</details>
<details class="faq-item">
<summary class="faq-summary"><span>Can I send my management team instead?</span><span class="faq-toggle">+</span></summary>
<div class="faq-body">Absolutely — and we strongly recommend it. The Corporate Table (₦650,000 for 5) is purpose-built for that. Send your DOSM, EAM, FOM, Chief Engineer and Exec Chef. They'll come back with a unified transformation plan.</div>
</details>
<details class="faq-item">
<summary class="faq-summary"><span>Is there a refund policy?</span><span class="faq-toggle">+</span></summary>
<div class="faq-body">Yes. Full refund within 14 days of registration, no questions asked. After that, your seat is fully transferable to a colleague. Either way, you're protected. We stand behind the value of HMC Africa completely.</div>
</details>
<details class="faq-item">
<summary class="faq-summary"><span>How do I pay?</span><span class="faq-toggle">+</span></summary>
<div class="faq-body">After clicking Register, you'll receive an invoice with bank transfer, card, and USD payment options. We confirm your seat the moment payment lands. Need to pay in instalments? Call us — we'll find a way to get you in the room.</div>
</details>
<details class="faq-item">
<summary class="faq-summary"><span>Will sessions be recorded?</span><span class="faq-toggle">+</span></summary>
<div class="faq-body">Select keynotes will be available to in-person ticket holders post-event. But the real value — the conversations, the deals, the connections — only happens in the room. That part isn't recorded. And it's worth more than anything you'll watch on replay.</div>
</details>
<details class="faq-item">
<summary class="faq-summary"><span>What is the dress code?</span><span class="faq-toggle">+</span></summary>
<div class="faq-body">Business professional for conference sessions. Smart elegant for the networking cocktail on Day 1 evening. Black tie / formal for the Gala Dinner &amp; HMC Awards on Day 2 evening. You'll be among Africa's most senior hospitality leaders — dress accordingly.</div>
</details>
<details class="faq-item">
<summary class="faq-summary"><span>Where exactly is the venue?</span><span class="faq-toggle">+</span></summary>
<div class="faq-body">Grand African Ballroom, Lagos Continental Hotel — 52a Kofo Abayomi Street, Victoria Island, Lagos. 25 minutes from Murtala Muhammed International Airport. Partner hotel discounts available at Lagos Continental, Best Western Plus Elomaz (Asaba), and La Campagne Tropicana Resort.</div>
</details>
</div>
</section>

<!-- ════════════════════════════════════════════ -->
<!-- 15. FINAL CTA -->
<!-- ════════════════════════════════════════════ -->
<section id="register" class="final-cta">
<div class="container-md">
<div class="section-eyebrow eyebrow-dark" style="margin-bottom:24px">The Decision</div>
<h2 class="font-display">
The Future Of African Hospitality<br>
<span class="shine">Will Be Discussed In This Room.</span>
</h2>
<p class="subtitle">The Only Question Is Whether You'll Be In It.</p>

<div class="final-meta-row">
<div class="final-meta-item">
<svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
<?php echo htmlspecialchars($event_date_range); ?>
</div>
<div class="final-meta-item">
<svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z"/><circle cx="12" cy="9" r="2.5"/></svg>
<?php echo htmlspecialchars($event_location_short); ?>
</div>
<div class="final-meta-item">
<svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
900+ Delegates
</div>
<div class="final-meta-item">
<svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
16 Countries
</div>
<div class="final-meta-item">
<svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
20+ Speakers
</div>
</div>

<div style="max-width:440px;margin:0 auto 40px">
<div class="countdown-grid" id="countdown2">
<div class="cd-unit"><span class="cd-num" id="cd2-days">00</span><span class="cd-lbl">Days</span></div>
<div class="cd-unit"><span class="cd-num" id="cd2-hours">00</span><span class="cd-lbl">Hours</span></div>
<div class="cd-unit"><span class="cd-num" id="cd2-mins">00</span><span class="cd-lbl">Mins</span></div>
<div class="cd-unit"><span class="cd-num" id="cd2-secs">00</span><span class="cd-lbl">Secs</span></div>
</div>
</div>

<div class="final-urgency">⏰ Early Bird Pricing Closes Soon — Register Now To Lock In Your Rate</div>

<div class="final-cta-btns">
<a href="<?php echo htmlspecialchars($ticket_link); ?>" class="btn-final">Reserve My Seat Now →</a>
<a href="tel:<?php echo $phone_number_link; ?>" class="btn-final-outline">📞 Speak With Us</a>
</div>

<p class="final-cta-note">Still deciding? Call us on <a href="tel:<?php echo $phone_number_link; ?>"><?php echo htmlspecialchars($phone_number_display); ?></a> and we'll walk you through it personally.</p>

<div class="final-cta-trust">
<div class="trust-item"><svg width="14" height="14" fill="none" stroke="var(--gold-300)" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>14-day money-back guarantee</div>
<div class="trust-item"><svg width="14" height="14" fill="none" stroke="var(--gold-300)" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>Transferable seat</div>
<div class="trust-item"><svg width="14" height="14" fill="none" stroke="var(--gold-300)" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>Secure payment</div>
<div class="trust-item"><svg width="14" height="14" fill="none" stroke="var(--gold-300)" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>8th annual edition</div>
</div>

<p class="final-quote">"The best time to invest in your career was five years ago. The second-best time is before the Early Bird closes."</p>
</div>
</section>

<!-- FOOTER -->
<footer>
<div class="container">
<div class="footer-grid">
<div>
<a href="./" class="footer-brand">
<img src="<?php echo htmlspecialchars($project_base); ?>images/logo.png" alt="HMC Africa" style="height: 40px;">
</a>
<p class="footer-desc">Hotel Managers Conference Africa is the continent's flagship gathering of hospitality leadership. Built by hoteliers, for hoteliers — to synergise for sustainable growth through global best practices.</p>
</div>
<div>
<div class="footer-heading">Contact</div>
<ul class="footer-links">
<li>31, Yussuf Street, Iyana Ipaja, Lagos</li>
<li><a href="mailto:<?php echo htmlspecialchars($email); ?>"><?php echo htmlspecialchars($email); ?></a></li>
<li><a href="tel:<?php echo $phone_number_link; ?>"><?php echo htmlspecialchars($phone_number_display); ?></a></li>
</ul>
</div>
<div>
<div class="footer-heading">Register</div>
<ul class="footer-links">
<li><a href="<?php echo htmlspecialchars($ticket_link); ?>" style="color:var(--gold-300);font-weight:700">Reserve My Seat Now →</a></li>
<li><a href="#tickets">Ticket Options</a></li>
<li><a href="tel:<?php echo $phone_number_link; ?>">Call Us</a></li>
<li><a href="mailto:<?php echo htmlspecialchars($email); ?>">Email Us</a></li>
</ul>
</div>
</div>
<div class="footer-bottom">
<div>© 2026 Hotel Managers Conference Africa. All rights reserved.</div>
<div>Synergising for Sustainable Growth Through Global Best Practices</div>
</div>
</div>
</footer>

<!-- STICKY CTA BAR -->
<div class="sticky-cta" id="stickyCTA" style="display:none">
<div class="sticky-cta-inner">
<div class="sticky-cta-text"><strong>HMC Africa 2026</strong> · July 11–12, Lagos · <strong>Early Bird Closing Soon</strong></div>
<div class="sticky-cta-btns">
<a href="<?php echo htmlspecialchars($ticket_link); ?>" class="sticky-cta-btn">Reserve My Seat Now</a>
<a href="tel:<?php echo $phone_number_link; ?>" class="sticky-cta-btn-secondary">📞 Call Us</a>
</div>
</div>
</div>

<!-- STICKY CTA FOOTER -->
<div class="sticky-cta-footer" id="stickyCTAFooter" style="display:none">
<div class="sticky-cta-footer-inner">
© 2026 All rights reserved. Built and Powered by <a href="https://www.dreem.com.ng/" target="_blank" class="sticky-cta-footer-link">DreemTec</a>.
</div>
</div>

<script>
// COUNTDOWN
function updateCountdown(){
var target=new Date('2026-07-11T08:00:00+01:00');
var now=new Date();
var diff=target-now;
if(diff<0)diff=0;
var d=Math.floor(diff/86400000);
var h=Math.floor((diff%86400000)/3600000);
var m=Math.floor((diff%3600000)/60000);
var s=Math.floor((diff%60000)/1000);
var fmt=function(n){return String(n).padStart(2,'0')};
['days','hours','mins','secs'].forEach(function(unit,i){
var val=[d,h,m,s][i];
var el1=document.getElementById('cd-'+unit);
var el2=document.getElementById('cd2-'+unit);
if(el1)el1.textContent=fmt(val);
if(el2)el2.textContent=fmt(val);
});
}
updateCountdown();
setInterval(updateCountdown,1000);

// STICKY CTA
var sticky=document.getElementById('stickyCTA');
var stickyFooter=document.getElementById('stickyCTAFooter');
if (sticky && stickyFooter) {
    window.addEventListener('scroll',function(){
    var showSticky=window.scrollY>600;
    sticky.style.display=showSticky?'flex':'none';
    stickyFooter.style.display=showSticky?'flex':'none';
    },{passive:true});
}
</script>
</body>
</html>
