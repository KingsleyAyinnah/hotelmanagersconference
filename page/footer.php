<!-- FOOTER -->
<footer>
<div class="container">
<div class="footer-grid">
<div>
<div class="footer-brand">
<img src="<?php echo htmlspecialchars($project_base); ?>images/logo.png" alt="HMC Africa" style="height: 40px;">
</div>
<p class="footer-desc"><?php echo htmlspecialchars($footer_description); ?></p>
</div>
<div>
<div class="footer-heading">Contact</div>
<ul class="footer-links">
<li><?php echo htmlspecialchars($footer_address); ?></li>
<li><a href="mailto:<?php echo htmlspecialchars($email); ?>"><?php echo htmlspecialchars($email); ?></a></li>
<li><a href="tel:<?php echo $phone_number_link; ?>"><?php echo htmlspecialchars($phone_number_display); ?></a></li>
</ul>
</div>
<div>
<div class="footer-heading">Register</div>
<ul class="footer-links">
<li><a href="<?php echo htmlspecialchars($ticket_link); ?>" style="color:var(--gold-300);font-weight:700">Reserve My Seat Now →</a></li>
<li><a href="<?php echo htmlspecialchars(($current_page === 'index.php' || $current_page === 'landing.php') ? '#tickets' : 'tickets'); ?>">Ticket Options</a></li>
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
if (document.getElementById('cd-days') || document.getElementById('cd2-days')) {
    updateCountdown();
    setInterval(updateCountdown,1000);
}

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

// MOBILE HAMBURGER MENU TOGGLE
var menuToggle = document.getElementById('menuToggle');
var navLinksWrapper = document.getElementById('navLinksWrapper');
if (menuToggle && navLinksWrapper) {
    menuToggle.addEventListener('click', function() {
        menuToggle.classList.toggle('active');
        navLinksWrapper.classList.toggle('active');
    });
}
</script>
</body>
</html>
