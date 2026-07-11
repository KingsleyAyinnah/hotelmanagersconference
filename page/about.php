<?php
$page_title = 'About Us | HMC Africa';
require_once 'header.php';
?>

<style>
/* Custom style overrides/enhancements for About page */
.about-hero {
    background: linear-gradient(rgba(28, 0, 3, 0.8), rgba(56, 0, 7, 0.85)), url('images/about-hero.jpg') no-repeat center center / cover;
    padding: 120px 0 100px;
    border-bottom: 3px solid var(--gold-400);
    text-align: center;
    position: relative;
}
.about-hero-title {
    font-family: 'Playfair Display', serif;
    font-size: clamp(36px, 5vw, 56px);
    font-weight: 900;
    color: var(--cream);
    margin-bottom: 12px;
}
.about-hero-subtitle {
    font-size: clamp(16px, 2vw, 20px);
    color: var(--gold-200);
    max-width: 800px;
    margin: 0 auto 24px;
    font-weight: 500;
    letter-spacing: 0.05em;
}
.about-hero-breadcrumbs {
    font-size: 13px;
    letter-spacing: 0.15em;
    text-transform: uppercase;
    color: rgba(253, 247, 240, 0.6);
}
.about-hero-breadcrumbs a {
    color: var(--gold-300);
    text-decoration: none;
    font-weight: 600;
    transition: color 0.2s;
}
.about-hero-breadcrumbs a:hover {
    color: var(--gold-200);
    text-decoration: underline;
}

/* Card Styling */
.about-card {
    background: var(--white);
    border-radius: 16px;
    box-shadow: 0 10px 30px rgba(45, 26, 16, 0.05);
    border: 1px solid rgba(56, 0, 7, 0.05);
    padding: 40px;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}
.about-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 20px 45px rgba(45, 26, 16, 0.1);
}

.about-dark-card {
    background: linear-gradient(135deg, var(--maroon-950) 0%, var(--maroon-900) 100%);
    border-radius: 16px;
    border: 1px solid var(--gold-400);
    padding: 40px;
    color: var(--cream);
    box-shadow: 0 15px 35px rgba(28, 0, 3, 0.25);
}

/* Timeline */
.timeline-item {
    position: relative;
    padding-left: 32px;
    border-left: 2px solid var(--gold-300);
    padding-bottom: 24px;
}
.timeline-item::before {
    content: '';
    position: absolute;
    left: -7px;
    top: 5px;
    width: 12px;
    height: 12px;
    border-radius: 50%;
    background: var(--gold-400);
    border: 2px solid var(--white);
}
.timeline-item:last-child {
    border-left: none;
    padding-bottom: 0;
}
.timeline-year {
    font-family: 'Playfair Display', serif;
    font-size: 20px;
    color: var(--maroon-800);
    font-weight: 700;
    margin-bottom: 6px;
}

/* Badge Tags for Media */
.media-badges {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    margin-top: 16px;
}
.media-badge {
    background: var(--maroon-100);
    color: var(--maroon-900);
    font-size: 13px;
    font-weight: 500;
    padding: 6px 14px;
    border-radius: 50px;
    border: 1px solid var(--maroon-200);
    transition: all 0.2s;
}
.media-badge:hover {
    background: var(--maroon-900);
    color: var(--white);
    border-color: var(--maroon-900);
}

/* Stat Box */
.stat-box {
    text-align: center;
    padding: 24px;
    border-radius: 12px;
    background: var(--gold-50);
    border: 1px solid rgba(212, 175, 55, 0.15);
}
.stat-number {
    font-family: 'Playfair Display', serif;
    font-size: 36px;
    font-weight: 900;
    color: var(--maroon-800);
    line-height: 1.1;
    margin-bottom: 4px;
}
.stat-label {
    font-size: 13px;
    color: var(--ink);
    opacity: 0.8;
    font-weight: 500;
}

/* Highlight / Info Box */
.info-box {
    border-left: 4px solid var(--gold-400);
    padding: 16px 20px;
    background: var(--cream);
    border-radius: 0 12px 12px 0;
    margin: 20px 0;
}

/* Image container styling */
.about-img-frame {
    position: relative;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
    border: 3px solid var(--white);
    outline: 1px solid var(--gold-400);
    transition: transform 0.3s ease;
}
.about-img-frame:hover {
    transform: scale(1.02);
}
.about-img-frame img {
    width: 100%;
    display: block;
    height: auto;
}
</style>

<!-- SUBPAGE HERO -->
<section class="about-hero">
    <div class="container">
        <h1 class="about-hero-title">About <span class="shine">HMC Africa</span></h1>
        <p class="about-hero-subtitle">Welcome to Hotel Managers Conference Africa</p>
        <div class="about-hero-breadcrumbs">
            <a href="./">Home</a> &nbsp;»&nbsp; About Us
        </div>
    </div>
</section>

<!-- EXECUTIVE SUMMARY SECTION -->
<section style="background: var(--white); padding: 80px 0;">
    <div class="container">
        <div class="grid-2" style="align-items: center; gap: 48px;">
            <div>
                <div class="section-eyebrow eyebrow-light" style="margin-bottom: 12px; color: var(--gold-600); text-transform: uppercase; font-size: 12px; font-weight: 700; letter-spacing: 0.15em;">EXECUTIVE SUMMARY</div>
                <h2 class="font-display" style="font-size: clamp(28px, 4vw, 38px); color: var(--maroon-900); margin-bottom: 24px; line-height: 1.2;">
                    Upgrading Hospitality Operations <br><span class="italic" style="color: var(--gold-600)">Across Africa.</span>
                </h2>
                <p style="color: var(--ink); font-size: 18px; line-height: 1.8; margin-bottom: 20px; font-weight: 500; opacity: 0.95;">
                    The Hotel Managers Conference & Awards was envisioned for hotel managers in Africa for skills upgrade, networking, and hotel job opportunities.
                </p>
                <p style="color: var(--ink); font-size: 16px; line-height: 1.8; margin-bottom: 16px; opacity: 0.85;">
                    Hotel Managers Conference & Awards recognizes the prime importance of the role staff play in giving hotels their standard in Africa and globally. Hence, the Hotel Managers Conference seeks to upgrade the total hotel business operations in Nigeria and Africa to match what is obtainable in other hotels internationally.
                </p>
                <p style="color: var(--ink); font-size: 16px; line-height: 1.8; opacity: 0.85;">
                    So, our core focus is towards building capacities in the human resources in hospitality brands in Africa, both international and indigenous brands, both in administration and general operations standards. The Hotel Managers Conference is a platform where hotel general managers and heads of departments of various hospitality brands including Quick Service Restaurants (QSR), bars, and all the organizations within the hospitality value chain are privileged to meet with hospitality experts with global relevance to draw timely knowledge for professional exploits.
                </p>
            </div>
            
            <div class="about-dark-card">
                <h3 class="font-display" style="font-size: 24px; color: var(--gold-200); margin-bottom: 16px;">Core Values & Pillars</h3>
                <p style="font-size: 15px; line-height: 1.75; margin-bottom: 24px; opacity: 0.9;">
                    Bridging gaps in standards among hotels while building capacities in the workforce of hotels across the African continent.
                </p>
                <div style="border-top: 1px solid rgba(212,175,55,0.3); padding-top: 20px; margin-bottom: 20px;">
                    <h4 style="font-size: 12px; text-transform: uppercase; letter-spacing: 0.15em; color: var(--gold-300); margin-bottom: 12px;">Core Focus Areas</h4>
                    <ul style="list-style: none; display: flex; flex-direction: column; gap: 10px; font-size: 14px;">
                        <li style="display: flex; align-items: center; gap: 8px;">
                            <span style="color: var(--gold-400);">✓</span> Skills Upgrade & Professional Exploits
                        </li>
                        <li style="display: flex; align-items: center; gap: 8px;">
                            <span style="color: var(--gold-400);">✓</span> Admin & General Operations Standards
                        </li>
                        <li style="display: flex; align-items: center; gap: 8px;">
                            <span style="color: var(--gold-400);">✓</span> Human Resource Capacity Building
                        </li>
                        <li style="display: flex; align-items: center; gap: 8px;">
                            <span style="color: var(--gold-400);">✓</span> Industry-wide Networking
                        </li>
                    </ul>
                </div>
                <div style="border-top: 1px solid rgba(212,175,55,0.3); padding-top: 20px;">
                    <div class="grid-2" style="gap: 16px;">
                        <div style="text-align: center;">
                            <div style="font-size: 28px; font-weight: bold; color: var(--gold-200); font-family: 'Playfair Display', serif;">5+</div>
                            <div style="font-size: 11px; opacity: 0.8; text-transform: uppercase; letter-spacing: 0.05em;">Editions</div>
                        </div>
                        <div style="text-align: center;">
                            <div style="font-size: 28px; font-weight: bold; color: var(--gold-200); font-family: 'Playfair Display', serif;">1k+</div>
                            <div style="font-size: 11px; opacity: 0.8; text-transform: uppercase; letter-spacing: 0.05em;">Community</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- HOTEL MANAGERS AWARDS SECTION -->
<section style="background: var(--cream); padding: 80px 0; border-top: 1px solid rgba(56, 0, 7, 0.05); border-bottom: 1px solid rgba(56, 0, 7, 0.05);">
    <div class="container">
        <div class="grid-2" style="align-items: center; gap: 48px;">
            <div style="order: 2; border-left: 2px solid var(--gold-400); padding-left: 32px;">
                <div class="section-eyebrow eyebrow-light" style="margin-bottom: 12px; color: var(--gold-600); text-transform: uppercase; font-size: 12px; font-weight: 700; letter-spacing: 0.15em;">PRESTIGE & RECOGNITION</div>
                <h2 class="font-display" style="font-size: clamp(28px, 4vw, 38px); color: var(--maroon-900); margin-bottom: 20px; line-height: 1.2;">
                    Hotel Managers Awards
                </h2>
                <p style="color: var(--ink); font-size: 16px; line-height: 1.8; margin-bottom: 16px; opacity: 0.85;">
                    The Hotel Managers Awards was included into the hotel managers conference as an instrument to recognize and celebrate the outstanding and resilient efforts and progress hotels are making in setting and sustaining lofty standards, consistently in the business. It also serves to inspire other hospitality brands to aspire to greater accomplishments and excellence in their operations.
                </p>
                <p style="color: var(--ink); font-size: 16px; line-height: 1.8; opacity: 0.85;">
                    Hotel managers awards winners are selected through voting. The voting process for the awards are designed to be fair and unbiased. It consists industry professionals, hospitality, travel and tourism experts, travel media practitioners and the general travel public.
                </p>
            </div>
            
            <div style="order: 1; display: flex; flex-direction: column; gap: 20px;">
                <div class="about-card" style="border-left: 4px solid var(--maroon-800);">
                    <h3 class="font-display" style="font-size: 20px; color: var(--maroon-900); margin-bottom: 12px;">Fair & Unbiased Selection</h3>
                    <p style="font-size: 15px; color: var(--ink); opacity: 0.8; line-height: 1.6;">
                        Our rigorous voting process incorporates diverse perspectives to honor the absolute best in African hospitality.
                    </p>
                    <div style="margin-top: 20px; display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
                        <div style="background: var(--cream); padding: 12px; border-radius: 8px; text-align: center; border: 1px solid rgba(212,175,55,0.2);">
                            <strong style="color: var(--maroon-800); display: block; font-size: 14px;">Industry Professionals</strong>
                        </div>
                        <div style="background: var(--cream); padding: 12px; border-radius: 8px; text-align: center; border: 1px solid rgba(212,175,55,0.2);">
                            <strong style="color: var(--maroon-800); display: block; font-size: 14px;">Hospitality Experts</strong>
                        </div>
                        <div style="background: var(--cream); padding: 12px; border-radius: 8px; text-align: center; border: 1px solid rgba(212,175,55,0.2);">
                            <strong style="color: var(--maroon-800); display: block; font-size: 14px;">Travel Media Practitioners</strong>
                        </div>
                        <div style="background: var(--cream); padding: 12px; border-radius: 8px; text-align: center; border: 1px solid rgba(212,175,55,0.2);">
                            <strong style="color: var(--maroon-800); display: block; font-size: 14px;">General Travel Public</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- WHY THE CHOICE OF THE THEME? SECTION -->
<section style="background: var(--white); padding: 80px 0;">
    <div class="container-md">
        <div class="text-center" style="max-width: 750px; margin: 0 auto 40px;">
            <div class="section-eyebrow eyebrow-light" style="margin-bottom: 12px; color: var(--gold-600); text-transform: uppercase; font-size: 12px; font-weight: 700; letter-spacing: 0.15em;">CONFERENCE THEME</div>
            <h2 class="font-display" style="font-size: clamp(28px, 4vw, 38px); color: var(--maroon-900); margin-bottom: 20px; line-height: 1.2;">
                Why the choice of the theme?
            </h2>
            <p style="color: var(--ink); font-size: 16px; line-height: 1.8; margin-bottom: 16px; opacity: 0.85;">
                In the dynamic landscape of hospitality, innovation becomes the cornerstone for fostering resilience and achieving excellence in guest experience. This conference will unravel groundbreaking strategies that go beyond conventional approaches.
            </p>
            <p style="color: var(--ink); font-size: 16px; line-height: 1.8; opacity: 0.85;">
                From harnessing cutting-edge technologies to cultivating a resilient mindset, attendees will explore how innovation becomes the catalyst for elevating guest experiences to unprecedented levels.
            </p>
        </div>
        
        <!-- Theme Body Image -->
        <div style="max-width: 800px; margin: 0 auto 20px;">
            <div class="about-img-frame">
                <img src="images/about-body.jpeg" alt="Why the Choice of the Theme">
            </div>
            <div style="text-align: center; margin-top: 12px; font-size: 13px; font-style: italic; color: var(--gold-600); font-weight: 500;">
                Innovation as the catalyst for elevating guest experiences to unprecedented levels.
            </div>
        </div>
    </div>
</section>

<!-- VISION, MISSION & CORE VALUES SECTION -->
<section style="background: var(--cream); padding: 80px 0; border-top: 1px solid rgba(56, 0, 7, 0.05); border-bottom: 1px solid rgba(56, 0, 7, 0.05);">
    <div class="container">
        <div class="grid-3" style="gap: 30px;">
            <!-- VISION CARD -->
            <div class="about-card" style="display: flex; flex-direction: column; height: 100%;">
                <div style="background: var(--maroon-100); width: 50px; height: 50px; border-radius: 12px; display: flex; align-items: center; justify-content: center; margin-bottom: 24px; border: 1px solid var(--maroon-200);">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="var(--maroon-800)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
                </div>
                <h3 class="font-display" style="font-size: 22px; color: var(--maroon-900); margin-bottom: 16px;">Vision</h3>
                <p style="color: var(--ink); font-size: 15px; line-height: 1.7; opacity: 0.85; flex-grow: 1;">
                    To improve the performance of hotel and hospitality managers in Africa.
                </p>
            </div>
            
            <!-- MISSION CARD -->
            <div class="about-card" style="display: flex; flex-direction: column; height: 100%;">
                <div style="background: var(--maroon-100); width: 50px; height: 50px; border-radius: 12px; display: flex; align-items: center; justify-content: center; margin-bottom: 24px; border: 1px solid var(--maroon-200);">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="var(--maroon-800)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="6"/><circle cx="12" cy="12" r="2"/></svg>
                </div>
                <h3 class="font-display" style="font-size: 22px; color: var(--maroon-900); margin-bottom: 16px;">Mission Statement</h3>
                <div style="color: var(--ink); font-size: 14px; line-height: 1.7; opacity: 0.85; flex-grow: 1; display: flex; flex-direction: column; gap: 12px;">
                    <p>
                        To build capacity in hotel Managers across Africa with a commitment to keep pushing, bridging gaps in standards among hotels while building capacities in the workforce of hotels.
                    </p>
                    <p>
                        Through real-world case studies and interactive discussions, participants will gain actionable insights to navigate challenges, adapt to ever-changing guest expectations, and emerge as trailblazers in the pursuit of service excellence within the hospitality industry.
                    </p>
                    <p>
                        Join us as we delve into the forefront of innovation, cultivating an environment where resilience and excellence converge to shape the future of guest experiences.
                    </p>
                </div>
            </div>
            
            <!-- CORE VALUES CARD -->
            <div class="about-card" style="display: flex; flex-direction: column; height: 100%;">
                <div style="background: var(--maroon-100); width: 50px; height: 50px; border-radius: 12px; display: flex; align-items: center; justify-content: center; margin-bottom: 24px; border: 1px solid var(--maroon-200);">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="var(--maroon-800)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10Z"/></svg>
                </div>
                <h3 class="font-display" style="font-size: 22px; color: var(--maroon-900); margin-bottom: 16px;">Core Values</h3>
                <ul style="list-style: none; display: flex; flex-direction: column; gap: 14px; flex-grow: 1; justify-content: center;">
                    <li style="display: flex; align-items: center; gap: 12px; padding-bottom: 8px; border-bottom: 1px solid rgba(56, 0, 7, 0.05);">
                        <span style="color: var(--gold-600); font-weight: bold; font-size: 18px;">✓</span>
                        <strong style="color: var(--maroon-900); font-size: 15px;">Capacity Building</strong>
                    </li>
                    <li style="display: flex; align-items: center; gap: 12px; padding-bottom: 8px; border-bottom: 1px solid rgba(56, 0, 7, 0.05);">
                        <span style="color: var(--gold-600); font-weight: bold; font-size: 18px;">✓</span>
                        <strong style="color: var(--maroon-900); font-size: 15px;">Professionalism</strong>
                    </li>
                    <li style="display: flex; align-items: center; gap: 12px; padding-bottom: 8px; border-bottom: 1px solid rgba(56, 0, 7, 0.05);">
                        <span style="color: var(--gold-600); font-weight: bold; font-size: 18px;">✓</span>
                        <strong style="color: var(--maroon-900); font-size: 15px;">Competency</strong>
                    </li>
                    <li style="display: flex; align-items: center; gap: 12px; padding-bottom: 8px;">
                        <span style="color: var(--gold-600); font-weight: bold; font-size: 18px;">✓</span>
                        <strong style="color: var(--maroon-900); font-size: 15px;">Networking</strong>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>

<!-- MILESTONES SECTION -->
<section style="background: var(--white); padding: 80px 0;">
    <div class="container">
        <div class="text-center" style="max-width: 700px; margin: 0 auto 56px;">
            <div class="section-eyebrow eyebrow-light" style="margin-bottom: 12px; color: var(--gold-600); text-transform: uppercase; font-size: 12px; font-weight: 700; letter-spacing: 0.15em;">OUR JOURNEY</div>
            <h2 class="font-display" style="font-size: clamp(28px, 4vw, 38px); color: var(--maroon-900); margin-bottom: 16px;">Milestones</h2>
            <p style="color: var(--ink); opacity: 0.8; font-size: 16px;">
                Hotel Managers Conference has successfully held five editions. The fifth edition was held in Owerri in 2023. Let's look back at how we have grown.
            </p>
        </div>
        
        <!-- Timeline Grid -->
        <div class="grid-2" style="gap: 48px; margin-bottom: 60px;">
            <!-- Timeline Column -->
            <div>
                <h3 class="font-display" style="font-size: 22px; color: var(--maroon-900); margin-bottom: 24px; border-bottom: 2px solid var(--gold-400); padding-bottom: 8px;">Edition Progress</h3>
                
                <div class="timeline-item">
                    <div class="timeline-year">First Edition (2016)</div>
                    <p style="font-size: 14px; color: var(--ink); opacity: 0.85; line-height: 1.6;">
                        Recorded <strong>86 Participants</strong> from <strong>5 states</strong> in Nigeria.
                    </p>
                </div>
                
                <div class="timeline-item">
                    <div class="timeline-year">Second Edition</div>
                    <p style="font-size: 14px; color: var(--ink); opacity: 0.85; line-height: 1.6;">
                        Recorded <strong>120 participants</strong> from <strong>9 states</strong>.
                    </p>
                </div>
                
                <div class="timeline-item">
                    <div class="timeline-year">HMC 2021</div>
                    <p style="font-size: 14px; color: var(--ink); opacity: 0.85; line-height: 1.6;">
                        Recorded <strong>150 participants</strong> from <strong>12 states</strong> of the federation.
                    </p>
                </div>
                
                <div class="timeline-item">
                    <div class="timeline-year">HMC Port Harcourt 2022</div>
                    <p style="font-size: 14px; color: var(--ink); opacity: 0.85; line-height: 1.6;">
                        Recorded <strong>205 participants</strong> from <strong>18 States</strong> in Nigeria cutting across all the 6 geopolitical zones, with <strong>300 participants</strong> who joined us online across Africa.
                    </p>
                </div>
                
                <div class="timeline-item">
                    <div class="timeline-year">The 5th HMC Owerri 2023</div>
                    <p style="font-size: 14px; color: var(--ink); opacity: 0.85; line-height: 1.6; margin-bottom: 8px;">
                        By far exceeded in delegates, exhibitors and VIPs who attended the conference.
                    </p>
                    <p style="font-size: 14px; color: var(--ink); opacity: 0.85; line-height: 1.6;">
                        The 5th HMC Owerri 2023 edition had about <strong>300 participants</strong> from <strong>24 States</strong> in Nigeria including <strong>5 countries</strong> from UK, China, Korea and India.
                    </p>
                </div>
            </div>
            
            <!-- Milestones Cards / Engagement -->
            <div style="display: flex; flex-direction: column; gap: 24px;">
                <h3 class="font-display" style="font-size: 22px; color: var(--maroon-900); margin-bottom: 24px; border-bottom: 2px solid var(--gold-400); padding-bottom: 8px;">HMC Engagement</h3>
                
                <div class="about-card" style="padding: 24px; border-left: 4px solid var(--gold-400);">
                    <h4 style="font-size: 16px; color: var(--maroon-900); margin-bottom: 8px; font-weight: 700;">Active Community</h4>
                    <p style="font-size: 14px; color: var(--ink); opacity: 0.85; line-height: 1.6;">
                        HMC has a growing WhatsApp group of nearly <strong>1,000 members</strong> cutting across Owners, Consultants, General Managers, HODs of Hotels, Resorts, Apartments, Lounges, QSR & Bars from all the six Geographical Zones in Nigeria and across Africa.
                    </p>
                </div>
                
                <div class="about-card" style="padding: 24px; border-left: 4px solid var(--gold-400);">
                    <h4 style="font-size: 16px; color: var(--maroon-900); margin-bottom: 8px; font-weight: 700;">Monthly Masterclasses</h4>
                    <p style="font-size: 14px; color: var(--ink); opacity: 0.85; line-height: 1.6; margin-bottom: 12px;">
                        Hotel Mangers Conference hosts a Monthly Masterclass online where specific skills necessary for excellent hotel operations are treated.
                    </p>
                    <div style="background: var(--gold-50); padding: 8px 12px; border-radius: 6px; font-size: 13px; font-weight: bold; color: var(--maroon-900); display: inline-block;">
                        September Masterclass Record: 100 participants
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Media Mileage / Coverage -->
        <div class="about-card" style="margin-bottom: 60px; background: var(--cream); border-left: 4px solid var(--maroon-800);">
            <h3 class="font-display" style="font-size: 22px; color: var(--maroon-900); margin-bottom: 12px;">Global Media Mileage</h3>
            <p style="font-size: 14px; color: var(--ink); opacity: 0.85; line-height: 1.6; margin-bottom: 20px;">
                Creating impressive and global media mileage, media features of HMC stories and news appeared on National dailies and Televisions. Pre-event and Post event media coverages were featured in:
            </p>
            <div class="media-badges">
                <span class="media-badge">NTA features (television)</span>
                <span class="media-badge">BusinessDay newspaper</span>
                <span class="media-badge">New Telegraph newspaper</span>
                <span class="media-badge">The Tribune newspaper</span>
                <span class="media-badge">The Guardian newspaper</span>
                <span class="media-badge">Thewillnews.com</span>
                <span class="media-badge">Paulukpabio.com</span>
                <span class="media-badge">Travelscope Magazine</span>
                <span class="media-badge">My Experience Africa</span>
                <span class="media-badge">The Independent Newspaper</span>
                <span class="media-badge">Independent.ng</span>
                <span class="media-badge">Thenumbers.ng</span>
                <span class="media-badge">A4anews.com</span>
            </div>
        </div>

        <!-- Reputable Brands Previously Attended -->
        <div>
            <h3 class="font-display text-center" style="font-size: 22px; color: var(--maroon-900); margin-bottom: 16px;">Exhibitors & Attendees from Previous Editions</h3>
            <p style="font-size: 14px; color: var(--ink); opacity: 0.8; line-height: 1.6; text-align: center; max-width: 800px; margin: 0 auto 30px;">
                Reputable hotels and brands both International and Local brands have attended and exhibited at previous editions of HMC.
            </p>
            <div style="display: flex; flex-wrap: wrap; justify-content: center; gap: 12px; max-width: 900px; margin: 0 auto;">
                <span style="background: var(--white); border: 1px solid rgba(56, 0, 7, 0.1); padding: 8px 16px; border-radius: 8px; font-size: 13px; font-weight: 600; color: var(--maroon-900); box-shadow: 0 4px 10px rgba(0,0,0,0.03);">Continent Worldwide</span>
                <span style="background: var(--white); border: 1px solid rgba(56, 0, 7, 0.1); padding: 8px 16px; border-radius: 8px; font-size: 13px; font-weight: 600; color: var(--maroon-900); box-shadow: 0 4px 10px rgba(0,0,0,0.03);">Best Western Hotels</span>
                <span style="background: var(--white); border: 1px solid rgba(56, 0, 7, 0.1); padding: 8px 16px; border-radius: 8px; font-size: 13px; font-weight: 600; color: var(--maroon-900); box-shadow: 0 4px 10px rgba(0,0,0,0.03);">Golden Tulip</span>
                <span style="background: var(--white); border: 1px solid rgba(56, 0, 7, 0.1); padding: 8px 16px; border-radius: 8px; font-size: 13px; font-weight: 600; color: var(--maroon-900); box-shadow: 0 4px 10px rgba(0,0,0,0.03);">Swiss International</span>
                <span style="background: var(--white); border: 1px solid rgba(56, 0, 7, 0.1); padding: 8px 16px; border-radius: 8px; font-size: 13px; font-weight: 600; color: var(--maroon-900); box-shadow: 0 4px 10px rgba(0,0,0,0.03);">Continental Hotel Group</span>
                <span style="background: var(--white); border: 1px solid rgba(56, 0, 7, 0.1); padding: 8px 16px; border-radius: 8px; font-size: 13px; font-weight: 600; color: var(--maroon-900); box-shadow: 0 4px 10px rgba(0,0,0,0.03);">Elomaz Group</span>
                <span style="background: var(--white); border: 1px solid rgba(56, 0, 7, 0.1); padding: 8px 16px; border-radius: 8px; font-size: 13px; font-weight: 600; color: var(--maroon-900); box-shadow: 0 4px 10px rgba(0,0,0,0.03);">Monty Group</span>
                <span style="background: var(--white); border: 1px solid rgba(56, 0, 7, 0.1); padding: 8px 16px; border-radius: 8px; font-size: 13px; font-weight: 600; color: var(--maroon-900); box-shadow: 0 4px 10px rgba(0,0,0,0.03);">Old English Group</span>
                <span style="background: var(--white); border: 1px solid rgba(56, 0, 7, 0.1); padding: 8px 16px; border-radius: 8px; font-size: 13px; font-weight: 600; color: var(--maroon-900); box-shadow: 0 4px 10px rgba(0,0,0,0.03);">Ikogosi</span>
                <span style="background: var(--white); border: 1px solid rgba(56, 0, 7, 0.1); padding: 8px 16px; border-radius: 8px; font-size: 13px; font-weight: 600; color: var(--maroon-900); box-shadow: 0 4px 10px rgba(0,0,0,0.03);">Nordic Hotels</span>
                <span style="background: var(--white); border: 1px solid rgba(56, 0, 7, 0.1); padding: 8px 16px; border-radius: 8px; font-size: 13px; font-weight: 600; color: var(--maroon-900); box-shadow: 0 4px 10px rgba(0,0,0,0.03);">LG Electronics West Africa</span>
                <span style="background: var(--white); border: 1px solid rgba(56, 0, 7, 0.1); padding: 8px 16px; border-radius: 8px; font-size: 13px; font-weight: 600; color: var(--maroon-900); box-shadow: 0 4px 10px rgba(0,0,0,0.03);">Wakanow</span>
                <span style="background: var(--white); border: 1px solid rgba(56, 0, 7, 0.1); padding: 8px 16px; border-radius: 8px; font-size: 13px; font-weight: 600; color: var(--maroon-900); box-shadow: 0 4px 10px rgba(0,0,0,0.03);">Winsar Group Information Technology Company (WinCloud PMS) India</span>
                <span style="background: var(--white); border: 1px solid rgba(56, 0, 7, 0.1); padding: 8px 16px; border-radius: 8px; font-size: 13px; font-weight: 600; color: var(--maroon-900); box-shadow: 0 4px 10px rgba(0,0,0,0.03);">Marasoftpay</span>
            </div>
        </div>
    </div>
</section>

<!-- CHOICE OF LAGOS SECTION -->
<section style="background: var(--cream); padding: 80px 0; border-top: 1px solid rgba(56, 0, 7, 0.05);">
    <div class="container">
        <div class="grid-2" style="align-items: center; gap: 48px;">
            <!-- Text Content -->
            <div>
                <div class="section-eyebrow eyebrow-light" style="margin-bottom: 12px; color: var(--gold-600); text-transform: uppercase; font-size: 12px; font-weight: 700; letter-spacing: 0.15em;">HMC LAGOS 2025</div>
                <h2 class="font-display" style="font-size: clamp(28px, 4vw, 38px); color: var(--maroon-900); margin-bottom: 24px; line-height: 1.2;">
                    Choice of Lagos for Hotel Managers Conference & Awards 2025
                </h2>
                <div style="color: var(--ink); font-size: 16px; line-height: 1.8; display: flex; flex-direction: column; gap: 16px; opacity: 0.85;">
                    <p>
                        Lagos is one of the fastest-growing cities in the world relying on its population growth and commercial activities. According to research by Mustard Insights, the city has 3,412 hotels, making it the highest number of hotels in any City in Nigeria.
                    </p>
                    <p>
                        Hospitality business in Lagos is driven by the influx of business and leisure travel in the State. This factor is a reflection of the level of hospitality and the huge variety of accommodations in the state. With the number of hotels in Lagos, it is obvious that the need to host HMC & Awards in Lagos seems long overdue.
                    </p>
                    <p>
                        Interestingly, all the airlines that operate in Nigeria have Lagos as a prime route for their operations, hence facilitating quick transits and business development in the Lagos State.
                    </p>
                </div>
            </div>
            
            <!-- Graphic Card for Lagos Stats -->
            <div class="about-dark-card" style="background: linear-gradient(135deg, var(--maroon-900) 0%, var(--maroon-800) 100%);">
                <div style="display: flex; align-items: center; gap: 16px; margin-bottom: 24px;">
                    <div style="background: var(--gold-400); width: 48px; height: 48px; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: var(--maroon-950); font-weight: bold; font-size: 20px;">
                        📍
                    </div>
                    <div>
                        <h4 style="font-size: 18px; color: var(--gold-200); font-weight: bold;">Lagos, Nigeria</h4>
                        <p style="font-size: 12px; text-transform: uppercase; letter-spacing: 0.15em; opacity: 0.8;">The Commercial Hub of Africa</p>
                    </div>
                </div>
                
                <div style="display: flex; flex-direction: column; gap: 20px;">
                    <div style="background: rgba(255,255,255,0.05); padding: 20px; border-radius: 12px; border-left: 4px solid var(--gold-400);">
                        <div style="font-size: 32px; font-weight: 900; color: var(--gold-300); font-family: 'Playfair Display', serif;">3,412</div>
                        <div style="font-size: 13px; opacity: 0.9; margin-top: 4px; font-weight: 500;">Registered Hotels in Lagos</div>
                        <p style="font-size: 12px; opacity: 0.7; margin-top: 4px; line-height: 1.4;">According to research by Mustard Insights (highest count in Nigeria).</p>
                    </div>
                    
                    <div style="background: rgba(255,255,255,0.05); padding: 20px; border-radius: 12px; border-left: 4px solid var(--gold-400);">
                        <div style="font-size: 20px; font-weight: 700; color: var(--gold-300); margin-bottom: 6px;">Prime Travel Infrastructure</div>
                        <p style="font-size: 13px; opacity: 0.85; line-height: 1.5;">All domestic and regional airlines feature Lagos as their primary operational hub, ensuring seamless transport logistics for delegates across the continent.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- SPONSORSHIP OPPORTUNITIES SECTION -->
<section style="background: linear-gradient(135deg, var(--maroon-950) 0%, var(--maroon-900) 100%); color: var(--cream); padding: 80px 0; border-top: 3px solid var(--gold-400);">
    <div class="container">
        <div class="text-center" style="max-width: 800px; margin: 0 auto 48px;">
            <div style="display: inline-block; background: rgba(212,175,55,0.15); border: 1px solid var(--gold-400); color: var(--gold-300); font-size: 11px; text-transform: uppercase; letter-spacing: 0.2em; padding: 6px 16px; border-radius: 50px; margin-bottom: 20px; font-weight: bold;">SPONSORSHIP & PARTNERSHIP</div>
            <h2 class="font-display" style="font-size: clamp(30px, 5vw, 44px); color: var(--gold-200); margin-bottom: 20px; line-height: 1.15;">
                Hotel Managers Conference & Awards Sponsorship Opportunities
            </h2>
            <p style="font-size: 16px; line-height: 1.8; opacity: 0.9; margin-bottom: 0;">
                Hotel Managers Conference & Awards is a very unique event which creates multiple value offerings for businesses that cover the totality of the African hospitality sphere. 
            </p>
        </div>
        
        <div class="about-card" style="background: rgba(255,255,255,0.03); border: 1px solid rgba(212,175,55,0.25); color: var(--cream); margin-bottom: 48px;">
            <h3 class="font-display" style="font-size: 22px; color: var(--gold-300); margin-bottom: 20px; text-align: center;">Quantum Growth Opportunities</h3>
            <p style="font-size: 15px; line-height: 1.8; opacity: 0.85; text-align: center; max-width: 900px; margin: 0 auto 24px;">
                Hence it is one platform which offers opportunities for business turnovers for producers, distributors, service providers, hospitality operations hardware and software, building materials, wine producers and distributors, farmers and their distribution chains, hospitality device equipment manufacturers and their distributors, travel and tours agencies, airlines, freight forwarders and handlers etc all have quantum opportunities to turn their businesses around through sponsorship and partnership with the <strong>Hotel Managers Conference & Awards Lagos 2024</strong>.
            </p>
            <div style="border-top: 1px solid rgba(212, 175, 55, 0.15); padding-top: 24px; display: flex; flex-wrap: wrap; justify-content: center; gap: 16px; font-size: 13px; text-transform: uppercase; letter-spacing: 0.05em; color: var(--gold-200); font-weight: bold;">
                <span>• Producers & Distributors</span>
                <span>• Hospitality Tech Providers</span>
                <span>• Equipment Manufacturers</span>
                <span>• Travel & Tours Agencies</span>
                <span>• Logistics & Freight Handlers</span>
            </div>
        </div>
        
        <div class="text-center">
            <a href="tickets" class="btn-primary" style="background: var(--gold-400); color: var(--maroon-950); padding: 16px 36px; border-radius: 50px; font-weight: bold; text-decoration: none; display: inline-block; font-size: 14px; text-transform: uppercase; letter-spacing: 0.1em; box-shadow: 0 10px 25px rgba(212,175,55,0.25); transition: all 0.2s;">
                Become a Sponsor / Partner →
            </a>
        </div>
    </div>
</section>

<?php
require_once 'footer.php';
?>
