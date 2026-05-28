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

    <div id="cinema-loader" class="cinema-loader">
        <div class="bar"><div class="bar-inner"></div></div>
    </div>

    <main>
        <!-- ─── Cinematic Hero ─── -->
        <section class="hero" id="hero">
            <div class="hero-ambient">
                <div class="orb"></div>
                <div class="orb"></div>
                <div class="orb"></div>
            </div>
            <div class="hero-particles" id="particles"></div>
            <div class="hero-content">
                <div class="hero-text">
                    <div class="hero-badge stagger-1" style="animation:slideUpElastic 0.6s var(--spring) 0.2s both;"><?= date('Y') ?> Academic Year</div>
                    <h1 class="stagger-2" style="animation:slideUpElastic 0.6s var(--spring) 0.3s both;">Empowering<br><span class="highlight">Academic Excellence</span></h1>
                    <p class="stagger-3" style="animation:slideUpElastic 0.6s var(--spring) 0.4s both;">The NIBS Bursary Management System provides a transparent, efficient, and merit-based platform for students to access financial support for their education.</p>
                    <div class="hero-buttons stagger-4" style="animation:slideUpElastic 0.6s var(--spring) 0.5s both;">
                        <a href="<?= !empty($_SESSION['user_id']) ? '/student/apply' : '/login' ?>" class="btn btn-primary btn-glow"><?= !empty($_SESSION['user_id']) ? 'Apply for Bursary' : 'Student Portal' ?> <i class="fa-solid fa-arrow-right"></i></a>
                        <a href="#how-it-works" class="btn btn-outline">How It Works</a>
                    </div>
                    <div class="hero-stats stagger-5" style="animation:slideUpElastic 0.6s var(--spring) 0.6s both;">
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
                <div class="hero-card glass stagger-6" style="animation:slideUpElastic 0.6s var(--spring) 0.7s both;">
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
                        <button type="submit" class="btn btn-primary btn-glow" style="width:100%;justify-content:center;">Launch Dashboard <i class="fa-solid fa-arrow-right"></i></button>
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
                    <div class="step-card reveal stagger-1">
                        <div class="step-number">1</div>
                        <h3>Register</h3>
                        <p>Create your student profile with your academic and personal details to get started.</p>
                    </div>
                    <div class="step-card reveal stagger-2">
                        <div class="step-number">2</div>
                        <h3>Apply</h3>
                        <p>Complete the comprehensive bursary application form with all required documentation.</p>
                    </div>
                    <div class="step-card reveal stagger-3">
                        <div class="step-number">3</div>
                        <h3>Verification</h3>
                        <p>Our AI-powered system and review committee evaluate your application thoroughly.</p>
                    </div>
                    <div class="step-card reveal stagger-4">
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
                    <div class="impact-card reveal stagger-1">
                        <div class="icon"><i class="fa-solid fa-graduation-cap"></i></div>
                        <div class="number"><span class="counter" data-target="12500">0</span>+</div>
                        <div class="label">Students Supported</div>
                    </div>
                    <div class="impact-card reveal stagger-2">
                        <div class="icon"><i class="fa-solid fa-kenya-shilling"></i></div>
                        <div class="number">KES <span class="counter" data-target="350">0</span>M+</div>
                        <div class="label">Total Disbursed</div>
                    </div>
                    <div class="impact-card reveal stagger-3">
                        <div class="icon"><i class="fa-solid fa-building-columns"></i></div>
                        <div class="number"><span class="counter" data-target="15">0</span>+</div>
                        <div class="label">Partner Institutions</div>
                    </div>
                    <div class="impact-card reveal stagger-4">
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
                    <div class="program-card reveal stagger-1">
                        <div class="icon"><i class="fa-solid fa-landmark"></i></div>
                        <h3>Government Supplement</h3>
                        <p>Partial government-funded bursary for students from low-income households pursuing diploma and certificate courses.</p>
                        <a href="sponsors.php" class="learn-more">Learn more <i class="fa-solid fa-arrow-right"></i></a>
                    </div>
                    <div class="program-card reveal stagger-2">
                        <div class="icon"><i class="fa-solid fa-trophy"></i></div>
                        <h3>NIBS Excellence Fund</h3>
                        <p>Merit-based scholarship awarded to students who demonstrate outstanding academic performance and leadership potential.</p>
                        <a href="sponsors.php" class="learn-more">Learn more <i class="fa-solid fa-arrow-right"></i></a>
                    </div>
                    <div class="program-card reveal stagger-3">
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
                    <div class="testimonial-card reveal stagger-1">
                        <p class="quote">"The NIBS bursary lifted a huge financial burden off my family. I was able to focus on my studies and graduate with distinction."</p>
                        <div class="author">
                            <div class="avatar">AK</div>
                            <div>
                                <div class="name">Alice Kamau</div>
                                <div class="role">Diploma in ICT, 2024</div>
                            </div>
                        </div>
                    </div>
                    <div class="testimonial-card reveal stagger-2">
                        <p class="quote">"As a first-generation university student, this bursary made my dream of studying Business Management a reality. Grateful beyond words."</p>
                        <div class="author">
                            <div class="avatar">GM</div>
                            <div>
                                <div class="name">George Maina</div>
                                <div class="role">Business Management, 2023</div>
                            </div>
                        </div>
                    </div>
                    <div class="testimonial-card reveal stagger-3">
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
                <a href="<?= !empty($_SESSION['user_id']) ? '/student/apply' : '/login' ?>" class="btn btn-primary btn-glow" style="font-size:1.05rem;padding:1rem 3rem;"><?= !empty($_SESSION['user_id']) ? 'Start Your Application' : 'Get Started' ?> <i class="fa-solid fa-arrow-right"></i></a>
            </div>
        </section>
    </main>

    <?php include 'includes/footer.php'; ?>

    <div id="toast-container" role="status" aria-live="polite"></div>

    <script src="js/app.js"></script>
    <script>
    (function() {
        var loader = document.getElementById('cinema-loader');
        if (loader) setTimeout(function() { loader.classList.add('hidden'); }, 600);

        // ─── Dark Mode ───
        var saved = localStorage.getItem('nibs-theme');
        if (saved === 'dark') document.documentElement.setAttribute('data-theme', 'dark');

        // ─── Navbar Scroll ───
        var nav = document.getElementById('navbar');
        var onScroll = function() {
            if (window.scrollY > 40) { nav.classList.add('scrolled'); }
            else { nav.classList.remove('scrolled'); }
        };
        window.addEventListener('scroll', onScroll, { passive: true });
        onScroll();

        // ─── Cinematic Particles ───
        (function initParticles() {
            var container = document.getElementById('particles');
            if (!container) return;
            for (var i = 0; i < 50; i++) {
                var p = document.createElement('div');
                p.className = 'hero-particle';
                p.style.left = Math.random() * 100 + '%';
                p.style.animationDuration = (10 + Math.random() * 20) + 's';
                p.style.animationDelay = (Math.random() * 15) + 's';
                p.style.width = p.style.height = (1.5 + Math.random() * 3) + 'px';
                p.style.opacity = 0.2 + Math.random() * 0.5;
                container.appendChild(p);
            }
        })();

        // ─── Scroll Reveal ───
        var reveal = new IntersectionObserver(function(entries) {
            entries.forEach(function(e) {
                if (e.isIntersecting) { e.target.classList.add('visible'); reveal.unobserve(e.target); }
            });
        }, { threshold: 0.1, rootMargin: '0px 0px -50px 0px' });
        document.querySelectorAll('.reveal').forEach(function(el) { reveal.observe(el); });

        // ─── Counters ───
        var counterObserver = new IntersectionObserver(function(entries) {
            entries.forEach(function(e) {
                if (!e.isIntersecting) return;
                var el = e.target;
                var target = parseInt(el.dataset.target);
                if (!target) return;
                var current = 0;
                var step = Math.ceil(target / 60);
                var timer = setInterval(function() {
                    current += step;
                    if (current >= target) { current = target; clearInterval(timer); }
                    el.textContent = current.toLocaleString();
                }, 25);
                counterObserver.unobserve(el);
            });
        }, { threshold: 0.5 });
        document.querySelectorAll('.counter').forEach(function(el) { counterObserver.observe(el); });

        // ─── Mobile Hamburger ───
        var hamburger = document.getElementById('hamburger');
        var navLinks = document.getElementById('nav-links');
        if (hamburger && navLinks) {
            hamburger.addEventListener('click', function() {
                hamburger.classList.toggle('active');
                navLinks.classList.toggle('open');
            });
            document.addEventListener('click', function(e) {
                if (!e.target.closest('#navbar')) { navLinks.classList.remove('open'); hamburger.classList.remove('active'); }
            });
        }

        // ─── Hero Parallax ───
        var hero = document.getElementById('hero');
        if (hero) {
            window.addEventListener('mousemove', function(e) {
                var x = (e.clientX / window.innerWidth - 0.5) * 6;
                var y = (e.clientY / window.innerHeight - 0.5) * 6;
                hero.style.setProperty('--mx', x + 'px');
                hero.style.setProperty('--my', y + 'px');
            }, { passive: true });
        }

        // ─── CSRF + Login ───
        (function initCsrf() {
            fetch('backend/auth.php?action=csrf')
                .then(function(r) { return r.json(); })
                .then(function(json) {
                    var inp = document.getElementById('login-csrf');
                    if (inp) inp.value = json.token;
                })
                .catch(function() {});
        })();

        var loginForm = document.getElementById('login-form');
        if (loginForm) {
            loginForm.addEventListener('submit', function(e) {
                e.preventDefault();
                var btn = loginForm.querySelector('button[type="submit"]');
                btn.disabled = true; btn.innerHTML = 'Signing in... <i class="fa-solid fa-spinner fa-spin"></i>';
                var email = document.getElementById('login-email').value;
                var password = document.getElementById('login-password').value;
                var csrf = document.getElementById('login-csrf').value;
                fetch('backend/auth.php?action=login', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ email: email, password: password, _csrf_token: csrf })
                })
                .then(function(r) { return r.json(); })
                .then(function(data) {
                    if (data.success) {
                        window.location.href = data.role === 'admin' ? '/admin/dashboard' : '/student/dashboard';
                    } else {
                        btn.disabled = false; btn.innerHTML = 'Launch Dashboard <i class="fa-solid fa-arrow-right"></i>';
                        showToast(data.error || 'Login failed', 'error');
                    }
                })
                .catch(function() {
                    btn.disabled = false; btn.innerHTML = 'Launch Dashboard <i class="fa-solid fa-arrow-right"></i>';
                    showToast('Connection error', 'error');
                });
            });
        }

        // ─── Toast helper ───
        window.showToast = function(msg, type) {
            type = type || 'success';
            var c = document.getElementById('toast-container');
            if (!c) return;
            var t = document.createElement('div');
            t.className = 'toast ' + type;
            var icon = type === 'success' ? '<i class="fa-solid fa-check-circle" style="color:var(--success)"></i> ' :
                       type === 'error' ? '<i class="fa-solid fa-circle-exclamation" style="color:var(--error)"></i> ' :
                       '<i class="fa-solid fa-info-circle" style="color:var(--primary)"></i> ';
            t.innerHTML = icon + msg;
            c.appendChild(t);
            setTimeout(function() { t.style.opacity = '0'; t.style.transition = 'opacity 0.3s'; setTimeout(function() { t.remove(); }, 300); }, 4000);
        };

        // ─── Scroll To Top Button ───
        var stBtn = document.createElement('a');
        stBtn.href = '#';
        stBtn.className = 'scroll-top';
        stBtn.setAttribute('aria-label', 'Scroll to top');
        stBtn.innerHTML = '<i class="fa-solid fa-arrow-up"></i>';
        document.body.appendChild(stBtn);
        window.addEventListener('scroll', function() {
            stBtn.classList.toggle('visible', window.scrollY > 300);
        }, { passive: true });
        stBtn.addEventListener('click', function(e) {
            e.preventDefault();
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    })();
    </script>
</body>
</html>
