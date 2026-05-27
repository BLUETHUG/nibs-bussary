<?php 
    $pageTitle = "Our Sponsors - NIBS Bursary Portal";
?>
<!DOCTYPE html>
<html lang="en">
<?php include 'includes/head.php'; ?>
<body>
    <?php include 'includes/navbar.php'; ?>

    <main>
        <section class="hero" style="min-height:60vh;padding-top:6rem;">
            <div class="hero-content" style="grid-template-columns:1fr;text-align:center;justify-items:center;">
                <div class="hero-text" style="max-width:800px;">
                    <div style="display:inline-block;font-size:0.75rem;font-weight:700;text-transform:uppercase;letter-spacing:3px;color:var(--accent);margin-bottom:1.5rem;">Our Partners</div>
                    <h1>Trusted <span class="highlight">Partners</span></h1>
                    <p style="max-width:600px;margin:0 auto 1.5rem;">The NIBS Bursary Fund is made possible through the generous contributions of corporate partners, government programs, and private individuals who believe in the power of education.</p>
                </div>
            </div>
        </section>

        <section class="section">
            <div class="section-inner">
                <div class="programs-grid">
                    <?php
                    $sponsors = [
                        ['Equity Group Foundation', 'Gold Partner', 'Supporting thousands of NIBS students through their Wings to Fly and Elimu scholarship integration.'],
                        ['Safaricom Foundation', 'Platinum Partner', 'Providing digital learning tools and financial aid to needy students in the School of ICT.'],
                        ['KCB Foundation', 'Silver Partner', 'Empowering vocational training and entrepreneurship through targeted bursary allocations.'],
                        ['HELB Kenya', 'Government Partner', 'Official loan and bursary disbursement partner for higher education accessibility.'],
                        ['The Lizzie Wanyoike Legacy', 'Founding Sponsor', 'The core endowment established by our late founder to ensure no student is left behind.'],
                        ['Standard Chartered', 'Corporate Partner', 'Supporting women in technology and business leadership programs at NIBS.'],
                    ];
                    foreach ($sponsors as $s):
                    ?>
                    <div class="program-card reveal">
                        <div class="icon"><i class="fa-solid fa-handshake"></i></div>
                        <p style="font-size:0.7rem;font-weight:800;text-transform:uppercase;color:var(--accent);letter-spacing:1px;margin-bottom:0.5rem;"><?= $s[1] ?></p>
                        <h3><?= $s[0] ?></h3>
                        <p><?= $s[2] ?></p>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

        <section class="cta-section reveal">
            <div class="section-inner">
                <h2>Invest in the Future</h2>
                <p>Join our network of sponsors and help provide life-changing opportunities to talented students across Kenya.</p>
                <div style="display:flex;gap:1.5rem;justify-content:center;flex-wrap:wrap;">
                    <a href="contact-us.php" class="btn btn-primary" style="padding:1rem 2.5rem;">Partner with Us <i class="fa-solid fa-arrow-right"></i></a>
                </div>
            </div>
        </section>
    </main>

    <?php include 'includes/footer.php'; ?>
    <script src="js/app.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', () => {
        const reveal = new IntersectionObserver((entries) => {
            entries.forEach(e => { if (e.isIntersecting) e.target.classList.add('visible'); });
        }, { threshold: 0.15 });
        document.querySelectorAll('.reveal').forEach(el => reveal.observe(el));
    });
    </script>
</body>
</html>
