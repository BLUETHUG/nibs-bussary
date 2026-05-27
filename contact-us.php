<?php 
    $pageTitle = "Contact Us - NIBS Bursary Portal";
    if (session_status() === PHP_SESSION_NONE) session_start();
    if (empty($_SESSION['_old_csrf_token'])) {
        $_SESSION['_old_csrf_token'] = bin2hex(random_bytes(32));
    }
    $csrfToken = $_SESSION['_old_csrf_token'];

    $success = isset($_GET['success']);
    $error   = isset($_GET['error']);
?>
<!DOCTYPE html>
<html lang="en">
<?php include 'includes/head.php'; ?>
<body style="<?= isset($_SESSION['user_id']) ? 'background:var(--off-white);display:flex;' : '' ?>">
    <?php if (isset($_SESSION['user_id'])): ?>
        <?php include 'includes/sidebar.php'; ?>
        <div style="flex:1;min-width:0;">
            <div style="background:var(--white);padding:1.2rem 3rem;display:flex;align-items:center;border-bottom:1px solid var(--border);position:sticky;top:0;z-index:100;">
                <h2 style="margin:0;font-size:1.4rem;color:var(--primary);"><i class="fa-solid fa-headset" style="color:var(--accent);margin-right:0.5rem;"></i>Contact Support</h2>
            </div>
            <main style="padding:2rem 3rem;flex:1;">
    <?php else: ?>
    <?php include 'includes/navbar.php'; ?>
    <main>
        <section class="hero" style="min-height:60vh;padding-top:6rem;">
    <?php endif; ?>
            <div class="hero-content" style="grid-template-columns:1fr;text-align:center;justify-items:center;">
                <div class="hero-text reveal">
                    <div style="display:inline-block;font-size:0.75rem;font-weight:700;text-transform:uppercase;letter-spacing:3px;color:var(--accent);margin-bottom:1.5rem;">Contact Us</div>
                    <h1>Get in <span class="highlight">Touch</span></h1>
                    <p style="max-width:600px;margin:0 auto;">Have questions about the bursary application process? Our dedicated support team is here to help you navigate your financial aid journey.</p>
                </div>
            </div>
        </section>

        <section class="section">
            <div class="section-inner" style="display:grid;grid-template-columns:1fr 1fr;gap:4rem;align-items:start;">
                <!-- Contact Info -->
                <div class="reveal">
                    <div style="display:flex;flex-direction:column;gap:2rem;">
                        <?php
                        $contacts = [
                            ['fa-location-dot', 'Main Campus', 'Thika Road, Kimbo, Ruiru, Kenya'],
                            ['fa-phone', 'Call Us', '+254 722 000 000 / +254 733 000 000'],
                            ['fa-envelope', 'Email', 'bursary@nibs.ac.ke'],
                            ['fa-clock', 'Office Hours', 'Monday — Friday, 8:00 AM — 5:00 PM (EAT)'],
                        ];
                        foreach ($contacts as $c):
                        ?>
                        <div style="display:flex;gap:1.5rem;align-items:start;">
                            <div style="width:50px;height:50px;background:var(--off-white);border-radius:15px;display:flex;align-items:center;justify-content:center;font-size:1.2rem;color:var(--accent);flex-shrink:0;">
                                <i class="fa-solid <?= $c[0] ?>"></i>
                            </div>
                            <div>
                                <h4 style="margin:0 0 0.2rem 0;font-size:1rem;"><?= $c[1] ?></h4>
                                <p style="margin:0;font-size:0.9rem;"><?= $c[2] ?></p>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Contact Form -->
                <div class="reveal" style="background:var(--white);border:1px solid var(--border);border-radius:var(--radius-md);padding:2.5rem;box-shadow:var(--shadow-md);">
                    <?php if ($success): ?>
                        <div style="background:#f0fff4;border-left:4px solid var(--success-green);padding:1.2rem;margin-bottom:2rem;border-radius:var(--radius-sm);">
                            <h4 style="color:#276749;margin-bottom:0.3rem;font-size:0.9rem;"><i class="fa-solid fa-circle-check"></i> Message Sent!</h4>
                            <p style="color:#2f855a;font-size:0.85rem;margin:0;">Thank you for reaching out. We'll respond shortly.</p>
                        </div>
                    <?php endif; ?>

                    <?php if ($error): ?>
                        <div style="background:#fff5f5;border-left:4px solid var(--accent);padding:1.2rem;margin-bottom:2rem;border-radius:var(--radius-sm);">
                            <h4 style="color:var(--primary-red);margin-bottom:0.3rem;font-size:0.9rem;"><i class="fa-solid fa-triangle-exclamation"></i> Error</h4>
                            <p style="color:#991B1B;font-size:0.85rem;margin:0;">Something went wrong. Please try again later.</p>
                        </div>
                    <?php endif; ?>

                    <form action="backend/contact-handler.php" method="POST" style="display:flex;flex-direction:column;gap:1.2rem;">
                        <input type="hidden" name="_csrf_token" value="<?= htmlspecialchars($csrfToken) ?>">
                        <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
                            <div class="form-group" style="margin:0;">
                                <label style="font-size:0.75rem;font-weight:700;text-transform:uppercase;letter-spacing:1px;color:var(--text-muted);margin-bottom:0.3rem;">Your Name</label>
                                <input type="text" name="name" required style="padding:0.8rem 1rem;font-size:0.9rem;">
                            </div>
                            <div class="form-group" style="margin:0;">
                                <label style="font-size:0.75rem;font-weight:700;text-transform:uppercase;letter-spacing:1px;color:var(--text-muted);margin-bottom:0.3rem;">Email Address</label>
                                <input type="email" name="email" required style="padding:0.8rem 1rem;font-size:0.9rem;">
                            </div>
                        </div>
                        <div class="form-group" style="margin:0;">
                            <label style="font-size:0.75rem;font-weight:700;text-transform:uppercase;letter-spacing:1px;color:var(--text-muted);margin-bottom:0.3rem;">Subject</label>
                            <input type="text" name="subject" required style="padding:0.8rem 1rem;font-size:0.9rem;">
                        </div>
                        <div class="form-group" style="margin:0;">
                            <label style="font-size:0.75rem;font-weight:700;text-transform:uppercase;letter-spacing:1px;color:var(--text-muted);margin-bottom:0.3rem;">Message</label>
                            <textarea name="message" required style="width:100%;min-height:130px;padding:0.8rem 1rem;font-size:0.9rem;resize:vertical;font-family:inherit;"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary" style="justify-content:center;padding:1rem;">Send Message <i class="fa-solid fa-paper-plane"></i></button>
                    </form>
                </div>
            </div>
    <?php if (isset($_SESSION['user_id'])): ?>
            </main>
        </div>
    <?php else: ?>
        </section>
    </main>
        <?php include 'includes/footer.php'; ?>
    <?php endif; ?>
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
