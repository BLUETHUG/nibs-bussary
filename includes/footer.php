<footer class="footer">
    <div class="footer-grid">
        <div class="footer-brand">
            <span class="logo">NIBS<span>Bursary</span></span>
            <p>Official Bursary Management System for NIBS Technical College. Empowering students through transparent and accessible financial support since 2010.</p>
        </div>
        <div>
            <h4>Quick Links</h4>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="apply.php">Apply Now</a></li>
                <li><a href="sponsors.php">Our Sponsors</a></li>
                <li><a href="tribute.php">Founder Tribute</a></li>
                <li><a href="contact-us.php">Contact Us</a></li>
                <li><a href="https://www.nibs.ac.ke" target="_blank" rel="noopener">NIBS Official Website <i class="fa-solid fa-external-link" style="font-size:0.75rem;"></i></a></li>
            </ul>
        </div>
        <div>
            <h4>For Students</h4>
            <ul>
                <li><a href="login.php">Student Portal</a></li>
                <li><a href="/register">Create Account</a></li>
                <li><a href="my-applications.php">My Applications</a></li>
                <li><a href="messages.php">Messages</a></li>
            </ul>
        </div>
        <div>
            <h4>Contact</h4>
            <ul>
                <li><a href="mailto:support@nibs.ac.ke">support@nibs.ac.ke</a></li>
                <li><a href="tel:+254700000000">+254 700 000 000</a></li>
                <li style="color:rgba(255,255,255,0.5);font-size:0.85rem;">Thika Road, Kimbo<br>Ruiru, Kenya</li>
            </ul>
        </div>
    </div>
    <div class="footer-bottom">
        <span>&copy; <?= date('Y') ?> NIBS Technical College. All Rights Reserved.</span>
        <div class="social-links">
            <a href="#" aria-label="Facebook"><i class="fa-brands fa-facebook-f"></i></a>
            <a href="#" aria-label="Twitter"><i class="fa-brands fa-x-twitter"></i></a>
            <a href="#" aria-label="Instagram"><i class="fa-brands fa-instagram"></i></a>
            <a href="#" aria-label="LinkedIn"><i class="fa-brands fa-linkedin-in"></i></a>
        </div>
    </div>
</footer>

<div id="toast-container"></div>

<button id="scroll-top" aria-label="Scroll to top">
    <i class="fa-solid fa-arrow-up"></i>
</button>
<script>
(function(){
    var btn = document.getElementById('scroll-top');
    if (!btn) return;
    btn.addEventListener('click', function() { window.scrollTo({ top: 0, behavior: 'smooth' }); });
    window.addEventListener('scroll', function() {
        btn.classList.toggle('visible', window.scrollY > 400);
    });
})();
</script>
