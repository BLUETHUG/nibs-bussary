<?php 
    $pageTitle = "NIBS Bursary Portal — Empowering Academic Excellence";
    if (session_status() === PHP_SESSION_NONE) session_start();
    if (empty($_SESSION['_old_csrf_token'])) {
        $_SESSION['_old_csrf_token'] = bin2hex(random_bytes(32));
    }
    $csrfToken = $_SESSION['_old_csrf_token'];
?>
<!DOCTYPE html>
<html lang="en">
<?php include 'includes/head.php'; ?>
<body>
    <?php include 'includes/navbar.php'; ?>

    <main>
        <!-- ─── Hero ─── -->
        <section class="hero" id="hero">
            <div class="hero-particles" id="particles"></div>
            <div class="hero-content">
                <div class="hero-text">
                    <div class="subtitle" style="display:inline-block;font-size:0.75rem;font-weight:700;text-transform:uppercase;letter-spacing:3px;color:var(--accent);margin-bottom:1.5rem;"><?= date('Y') ?> Academic Year</div>
                    <h1>Empowering<br><span class="highlight">Academic Excellence</span></h1>
                    <p>The NIBS Bursary Management System provides a transparent, efficient, and merit-based platform for students to access financial support for their education.</p>
                    <div class="hero-buttons">
                        <a href="apply.php" class="btn btn-primary">Apply for Bursary <i class="fa-solid fa-arrow-right"></i></a>
                        <a href="#how-it-works" class="btn btn-outline">How It Works</a>
                    </div>
                    <div class="hero-stats">
                        <div class="hero-stat">
                            <h3><span class="counter" data-target="12500">0</span>+</h3>
                            <p>Students Funded</p>
                        </div>
                        <div class="hero-stat">
                            <h3><span class="counter" data-target="35">0</span>K</h3>
                            <p>Avg. Allocation</p>
                        </div>
                        <div class="hero-stat">
                            <h3><span class="counter" data-target="74">0</span>%</h3>
                            <p>Success Rate</p>
                        </div>
                    </div>
                </div>
                <div class="hero-card">
                    <h3>Student Portal</h3>
                    <p>Secure access to your applications</p>
                    <form id="login-form" action="backend/auth.php?action=login" method="POST">
                        <div class="form-group">
                            <label>Student Email</label>
                            <input type="email" name="email" id="login-email" required placeholder="name@nibs.ac.ke">
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" name="password" id="login-password" required placeholder="••••••••">
                        </div>
                        <input type="hidden" name="_csrf_token" id="login-csrf" value="<?= htmlspecialchars($csrfToken) ?>">
                        <button type="submit" class="btn btn-primary">Launch Dashboard <i class="fa-solid fa-arrow-right"></i></button>
                    </form>
                    <p class="form-footer">
                        Don't have an account? <a href="/register">Create one free</a>
                    </p>
                </div>
            </div>
        </section>

        <!-- ─── How It Works ─── -->
        <section class="section" id="how-it-works">
            <div class="section-inner">
                <div class="section-header reveal">
                    <span class="subtitle">Simple Process</span>
                    <h2>How the Bursary Works</h2>
                    <p>A streamlined four-step process designed to make financial support accessible to every deserving student.</p>
                </div>
                <div class="steps-grid">
                    <div class="step-card reveal">
                        <div class="step-number">1</div>
                        <h3>Register</h3>
                        <p>Create your student profile with your academic and personal details to get started.</p>
                    </div>
                    <div class="step-card reveal">
                        <div class="step-number">2</div>
                        <h3>Apply</h3>
                        <p>Complete the comprehensive bursary application form with all required documentation.</p>
                    </div>
                    <div class="step-card reveal">
                        <div class="step-number">3</div>
                        <h3>Verification</h3>
                        <p>Our AI-powered system and review committee evaluate your application thoroughly.</p>
                    </div>
                    <div class="step-card reveal">
                        <div class="step-number">4</div>
                        <h3>Allocation</h3>
                        <p>Successful applicants receive funding disbursed directly to their fee accounts.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- ─── Impact Stats ─── -->
        <section class="impact-section section">
            <div class="section-inner">
                <div class="section-header reveal">
                    <span class="subtitle">Our Impact</span>
                    <h2>Making a Difference</h2>
                    <p>Since inception, the NIBS Bursary Program has transformed thousands of lives through financial empowerment.</p>
                </div>
                <div class="impact-grid">
                    <div class="impact-card reveal">
                        <div class="icon"><i class="fa-solid fa-graduation-cap"></i></div>
                        <div class="number"><span class="counter" data-target="12500">0</span>+</div>
                        <div class="label">Students Supported</div>
                    </div>
                    <div class="impact-card reveal">
                        <div class="icon"><i class="fa-solid fa-kenya-shilling"></i></div>
                        <div class="number">KES <span class="counter" data-target="350">0</span>M+</div>
                        <div class="label">Total Disbursed</div>
                    </div>
                    <div class="impact-card reveal">
                        <div class="icon"><i class="fa-solid fa-building-columns"></i></div>
                        <div class="number"><span class="counter" data-target="15">0</span>+</div>
                        <div class="label">Partner Institutions</div>
                    </div>
                    <div class="impact-card reveal">
                        <div class="icon"><i class="fa-solid fa-star"></i></div>
                        <div class="number"><span class="counter" data-target="92">0</span>%</div>
                        <div class="label">Completion Rate</div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ─── Bursary Programs ─── -->
        <section class="section">
            <div class="section-inner">
                <div class="section-header reveal">
                    <span class="subtitle">Funding Options</span>
                    <h2>Bursary Programs</h2>
                    <p>We offer a range of financial support programs tailored to different student needs and circumstances.</p>
                </div>
                <div class="programs-grid">
                    <div class="program-card reveal">
                        <div class="icon"><i class="fa-solid fa-landmark"></i></div>
                        <h3>Government Supplement</h3>
                        <p>Partial government-funded bursary for students from low-income households pursuing diploma and certificate courses.</p>
                        <a href="sponsors.php" class="learn-more">Learn more <i class="fa-solid fa-arrow-right"></i></a>
                    </div>
                    <div class="program-card reveal">
                        <div class="icon"><i class="fa-solid fa-trophy"></i></div>
                        <h3>NIBS Excellence Fund</h3>
                        <p>Merit-based scholarship awarded to students who demonstrate outstanding academic performance and leadership potential.</p>
                        <a href="sponsors.php" class="learn-more">Learn more <i class="fa-solid fa-arrow-right"></i></a>
                    </div>
                    <div class="program-card reveal">
                        <div class="icon"><i class="fa-solid fa-hand-holding-heart"></i></div>
                        <h3>Donor Scholarships</h3>
                        <p>Sponsored by our generous partners and alumni, these scholarships support students with special circumstances and exceptional promise.</p>
                        <a href="sponsors.php" class="learn-more">Learn more <i class="fa-solid fa-arrow-right"></i></a>
                    </div>
                </div>
            </div>
        </section>

        <!-- ─── Testimonials ─── -->
        <section class="testimonials-section section">
            <div class="section-inner">
                <div class="section-header reveal">
                    <span class="subtitle">Testimonials</span>
                    <h2>What Students Say</h2>
                    <p>Hear from our beneficiaries about how the bursary program has impacted their academic journey.</p>
                </div>
                <div class="testimonial-grid">
                    <div class="testimonial-card reveal">
                        <p class="quote">"The NIBS bursary lifted a huge financial burden off my family. I was able to focus on my studies and graduate with distinction."</p>
                        <div class="author">
                            <div class="avatar">AK</div>
                            <div>
                                <div class="name">Alice Kamau</div>
                                <div class="role">Diploma in ICT, 2024</div>
                            </div>
                        </div>
                    </div>
                    <div class="testimonial-card reveal">
                        <p class="quote">"As a first-generation university student, this bursary made my dream of studying Business Management a reality. Grateful beyond words."</p>
                        <div class="author">
                            <div class="avatar">GM</div>
                            <div>
                                <div class="name">George Maina</div>
                                <div class="role">Business Management, 2023</div>
                            </div>
                        </div>
                    </div>
                    <div class="testimonial-card reveal">
                        <p class="quote">"The application process was straightforward and transparent. I received my disbursement on time and could clear my fee balance."</p>
                        <div class="author">
                            <div class="avatar">SW</div>
                            <div>
                                <div class="name">Sarah Wanjiku</div>
                                <div class="role">Hospitality, 2024</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ─── Partners ─── -->
        <section class="partners-section section">
            <div class="section-inner">
                <div class="section-header reveal" style="margin-bottom:2rem;">
                    <span class="subtitle">Our Partners</span>
                </div>
                <div class="partner-logos">
                    <span class="partner-logo">EQUITY BANK</span>
                    <span class="partner-logo">SAFARICOM</span>
                    <span class="partner-logo">KCB BANK</span>
                    <span class="partner-logo">UNESCO</span>
                    <span class="partner-logo">HELB</span>
                </div>
            </div>
        </section>

        <!-- ─── CTA ─── -->
        <section class="cta-section reveal">
            <div class="section-inner">
                <h2>Ready to Apply?</h2>
                <p>Take the first step toward securing your financial future. Applications are now open for the current academic year.</p>
                <a href="apply.php" class="btn btn-primary" style="font-size:1.05rem;padding:1rem 3rem;">Start Your Application <i class="fa-solid fa-arrow-right"></i></a>
            </div>
        </section>
    </main>

    <?php include 'includes/footer.php'; ?>

    <script src="js/app.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', () => {
        // ─── Particles ───
        const container = document.getElementById('particles');
        if (container) {
            for (let i = 0; i < 40; i++) {
                const p = document.createElement('div');
                p.className = 'particle';
                p.style.left = Math.random() * 100 + '%';
                p.style.animationDuration = (8 + Math.random() * 12) + 's';
                p.style.animationDelay = Math.random() * 10 + 's';
                p.style.width = p.style.height = (2 + Math.random() * 4) + 'px';
                container.appendChild(p);
            }
        }

        // ─── Scroll Reveal ───
        const reveal = new IntersectionObserver((entries) => {
            entries.forEach(e => { if (e.isIntersecting) e.target.classList.add('visible'); });
        }, { threshold: 0.1 });
        document.querySelectorAll('.reveal').forEach(el => reveal.observe(el));

        // ─── Counters ───
        const counterObserver = new IntersectionObserver((entries) => {
            entries.forEach(e => {
                if (!e.isIntersecting) return;
                const el = e.target;
                const target = parseInt(el.dataset.target);
                if (!target) return;
                let current = 0;
                const step = Math.ceil(target / 60);
                const timer = setInterval(() => {
                    current += step;
                    if (current >= target) { current = target; clearInterval(timer); }
                    el.textContent = current.toLocaleString();
                }, 25);
                counterObserver.unobserve(el);
            });
        }, { threshold: 0.5 });
        document.querySelectorAll('.counter').forEach(el => counterObserver.observe(el));

        // ─── Mobile Hamburger ───
        const hamburger = document.getElementById('hamburger');
        const navLinks = document.getElementById('nav-links');
        if (hamburger && navLinks) {
            hamburger.addEventListener('click', () => {
                hamburger.classList.toggle('active');
                navLinks.classList.toggle('open');
            });
        }

        // ─── CSRF + Login ───
        (async function initCsrf() {
            try {
                const res = await fetch('backend/auth.php?action=csrf');
                const json = await res.json();
                const inp = document.getElementById('login-csrf');
                if (inp) inp.value = json.token;
            } catch(e) {}
        })();

        const loginForm = document.getElementById('login-form');
        if (loginForm) {
            loginForm.addEventListener('submit', async (e) => {
                e.preventDefault();
                const email = document.getElementById('login-email').value;
                const password = document.getElementById('login-password').value;
                const csrf = document.getElementById('login-csrf').value;
                try {
                    const res = await fetch('backend/auth.php?action=login', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify({ email, password, _csrf_token: csrf })
                    });
                    const data = await res.json();
                    if (data.success) {
                        window.location.href = data.role === 'admin' ? '/admin/dashboard' : '/student/dashboard';
                    } else {
                        alert(data.error || 'Login failed');
                    }
                } catch(e) {
                    alert('Connection error');
                }
            });
        }
    });
    </script>
</body>
</html>
