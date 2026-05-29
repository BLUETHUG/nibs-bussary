<?php 
    $pageTitle = "Our Founder — NIBS Technical College";
?>
<!DOCTYPE html>
<html lang="en" data-theme="">
<?php include 'includes/head.php'; ?>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&family=Playfair+Display:ital,wght@0,400;0,700;1,400&display=swap" rel="stylesheet">
<style>
:root {
    --founder-navy: #1A237E;
    --founder-gold: #FFD54F;
    --founder-navy-dark: #0D1442;
    --founder-navy-light: #283593;
}
[data-theme="dark"] {
    --founder-navy: #3949AB;
    --founder-navy-dark: #1a1a2e;
    --founder-navy-light: #5C6BC0;
}
.founder-page {
    font-family: 'Poppins', sans-serif;
    overflow-x: hidden;
}
.founder-hero {
    position: relative;
    min-height: 85vh;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(145deg, var(--founder-navy-dark) 0%, var(--founder-navy) 50%, var(--founder-navy-light) 100%);
    overflow: hidden;
    padding-top: 80px;
}
.founder-hero::before {
    content: '';
    position: absolute;
    inset: 0;
    background: radial-gradient(ellipse at 20% 50%, rgba(255,213,79,0.1) 0%, transparent 50%),
                radial-gradient(ellipse at 80% 20%, rgba(255,213,79,0.06) 0%, transparent 50%);
    pointer-events: none;
}
.founder-hero-pattern {
    position: absolute;
    inset: 0;
    opacity: 0.03;
    background-image: 
        linear-gradient(45deg, var(--founder-gold) 1px, transparent 1px),
        linear-gradient(-45deg, var(--founder-gold) 1px, transparent 1px);
    background-size: 60px 60px;
}
.founder-hero-content {
    position: relative;
    z-index: 2;
    text-align: center;
    padding: 0 5%;
    max-width: 900px;
    animation: founderFadeUp 0.8s 0.2s both;
}
.founder-hero-subtitle {
    color: var(--founder-gold);
    text-transform: uppercase;
    letter-spacing: 6px;
    font-weight: 600;
    font-size: 0.85rem;
    margin-bottom: 1.5rem;
    opacity: 0.9;
}
.founder-hero-name {
    font-family: 'Playfair Display', serif;
    font-size: clamp(2.5rem, 6vw, 5rem);
    color: #fff;
    margin-bottom: 0.5rem;
    line-height: 1.1;
    font-weight: 700;
}
.founder-hero-years {
    font-size: 1.3rem;
    color: rgba(255,255,255,0.5);
    font-style: italic;
    font-family: 'Playfair Display', serif;
    margin-bottom: 2rem;
}
.founder-hero-quote {
    font-size: clamp(1rem, 2vw, 1.2rem);
    color: rgba(255,255,255,0.85);
    max-width: 700px;
    margin: 0 auto;
    line-height: 1.9;
    font-style: italic;
    padding: 1.5rem 2rem;
    border-left: 3px solid var(--founder-gold);
    background: rgba(255,255,255,0.05);
    border-radius: 0 12px 12px 0;
}
.founder-section {
    padding: 6rem 5%;
    max-width: 1200px;
    margin: 0 auto;
}
.founder-bio {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 5rem;
    align-items: center;
}
.founder-image-wrap {
    position: relative;
}
.founder-image-frame {
    position: relative;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 30px 60px rgba(0,0,0,0.12);
}
.founder-image-frame img {
    width: 100%;
    display: block;
    transition: transform 0.6s ease;
}
.founder-image-frame:hover img {
    transform: scale(1.03);
}
.founder-image-frame::after {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(to top, rgba(26,35,126,0.15), transparent 50%);
    pointer-events: none;
}
.founder-badge {
    position: absolute;
    bottom: -1.5rem;
    right: -1.5rem;
    background: var(--founder-navy);
    color: var(--founder-gold);
    padding: 1.25rem;
    border-radius: 16px;
    text-align: center;
    min-width: 120px;
    box-shadow: 0 12px 30px rgba(26,35,126,0.3);
    animation: founderFloat 3s ease-in-out infinite;
}
.founder-badge h3 {
    font-size: 1.8rem;
    font-weight: 800;
    margin: 0;
    line-height: 1;
}
.founder-badge p {
    font-size: 0.65rem;
    text-transform: uppercase;
    letter-spacing: 1px;
    margin: 0.25rem 0 0;
    opacity: 0.8;
}
.founder-bio-text h2 {
    font-family: 'Playfair Display', serif;
    font-size: clamp(1.8rem, 3vw, 2.8rem);
    color: var(--founder-navy);
    margin-bottom: 1.5rem;
    line-height: 1.2;
}
[data-theme="dark"] .founder-bio-text h2 { color: #fff; }
.founder-bio-text p {
    font-size: 1rem;
    color: var(--text-secondary);
    line-height: 1.9;
    margin-bottom: 1.25rem;
}
.founder-milestones {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1.5rem;
    margin-top: 2.5rem;
}
.founder-milestone {
    border-left: 4px solid var(--founder-navy);
    padding-left: 1.25rem;
}
.founder-milestone h3 {
    font-size: 2rem;
    color: var(--founder-navy);
    margin: 0;
    font-weight: 800;
}
[data-theme="dark"] .founder-milestone h3 { color: var(--founder-gold); }
.founder-milestone p {
    font-size: 0.7rem;
    text-transform: uppercase;
    font-weight: 600;
    color: var(--text-muted);
    margin: 0.25rem 0 0;
    letter-spacing: 1px;
}
.founder-legacy {
    background: linear-gradient(145deg, var(--founder-navy-dark), var(--founder-navy));
    color: #fff;
    text-align: center;
    padding: 6rem 5%;
}
.founder-legacy-inner {
    max-width: 800px;
    margin: 0 auto;
}
.founder-legacy-subtitle {
    color: var(--founder-gold);
    text-transform: uppercase;
    letter-spacing: 4px;
    font-weight: 600;
    font-size: 0.8rem;
    margin-bottom: 1rem;
}
.founder-legacy h2 {
    font-family: 'Playfair Display', serif;
    font-size: clamp(2rem, 4vw, 3rem);
    margin-bottom: 1.5rem;
}
.founder-legacy p {
    color: rgba(255,255,255,0.75);
    font-size: 1.05rem;
    line-height: 1.8;
    max-width: 650px;
    margin: 0 auto 2rem;
}
.founder-legacy .btn {
    display: inline-flex;
    align-items: center;
    gap: 0.75rem;
    padding: 1rem 2.5rem;
    background: var(--founder-gold);
    color: var(--founder-navy-dark);
    font-weight: 700;
    font-size: 1rem;
    border-radius: 12px;
    text-decoration: none;
    transition: all 0.3s ease;
    border: none;
    cursor: pointer;
    font-family: 'Poppins', sans-serif;
}
.founder-legacy .btn:hover {
    transform: translateY(-3px);
    box-shadow: 0 12px 30px rgba(255,213,79,0.3);
}
.founder-values {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 2rem;
    margin: 4rem 0;
}
.founder-value-card {
    text-align: center;
    padding: 2rem 1.5rem;
    background: var(--bg-card);
    border: 1px solid var(--border);
    border-radius: 16px;
    transition: all 0.3s ease;
}
.founder-value-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 16px 40px rgba(0,0,0,0.08);
    border-color: var(--founder-navy);
}
.founder-value-icon {
    width: 56px;
    height: 56px;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--founder-navy), var(--founder-navy-light));
    color: var(--founder-gold);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.3rem;
    margin: 0 auto 1rem;
}
.founder-value-card h3 {
    font-size: 1.1rem;
    color: var(--text);
    margin-bottom: 0.5rem;
    font-weight: 600;
}
.founder-value-card p {
    font-size: 0.85rem;
    color: var(--text-secondary);
    line-height: 1.6;
}
@keyframes founderFadeUp {
    from { opacity: 0; transform: translateY(30px); }
    to { opacity: 1; transform: translateY(0); }
}
@keyframes founderFloat {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-8px); }
}
.founder-anim-1 { animation: founderFadeUp 0.6s 0.1s both; }
.founder-anim-2 { animation: founderFadeUp 0.6s 0.2s both; }
.founder-anim-3 { animation: founderFadeUp 0.6s 0.3s both; }
.founder-anim-4 { animation: founderFadeUp 0.6s 0.4s both; }
@keyframes countUp {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}
@media (max-width: 768px) {
    .founder-bio { grid-template-columns: 1fr; gap: 3rem; }
    .founder-values { grid-template-columns: 1fr; }
    .founder-milestones { grid-template-columns: 1fr; }
    .founder-badge { right: 0; }
    .founder-hero-name { font-size: 2.5rem; }
    .founder-hero-quote { padding: 1rem 1.25rem; font-size: 0.95rem; }
    .founder-section { padding: 3rem 5%; }
}
</style>
<body>
    <?php include 'includes/navbar.php'; ?>
    <main class="founder-page">
        <!-- Hero -->
        <section class="founder-hero">
            <div class="founder-hero-pattern"></div>
            <div class="founder-hero-content">
                <p class="founder-hero-subtitle">Honoring the Legacy of</p>
                <h1 class="founder-hero-name">Lizzie Muthoni Wanyoike</h1>
                <p class="founder-hero-years">1951 — 2024</p>
                <div class="founder-hero-quote">
                    "Education is the most powerful weapon which you can use to change the world. My dream is to see every child in Kenya empowered through knowledge."
                </div>
            </div>
        </section>

        <!-- Biography -->
        <section class="founder-section founder-anim-2">
            <div class="founder-bio">
                <div class="founder-image-wrap">
                    <div class="founder-image-frame">
                        <img src="assets/img/lizzie_wanyoike.png" alt="Lizzie Wanyoike — Founder of NIBS Technical College" loading="lazy">
                    </div>
                    <div class="founder-badge">
                        <h3>25k+</h3>
                        <p>Graduates</p>
                    </div>
                </div>
                <div class="founder-bio-text">
                    <h2>A Visionary Educator &amp; Philanthropist</h2>
                    <p>Lizzie Wanyoike was more than just the founder of NIBS Technical College; she was a beacon of hope for thousands of young Kenyans. Starting with just a handful of students, her unwavering dedication to technical excellence transformed NIBS into a premier academic institution.</p>
                    <p>Her philosophy was simple: financial constraints should never stand in the way of talent. This Bursary System is a direct continuation of her life's work—ensuring that the doors of opportunity remain open for all.</p>
                    <div class="founder-milestones">
                        <div class="founder-milestone">
                            <h3>1999</h3>
                            <p>Founded NIBS</p>
                        </div>
                        <div class="founder-milestone">
                            <h3>25k+</h3>
                            <p>Graduates Empowered</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Values -->
        <section class="founder-section founder-anim-3" style="padding-top:0;">
            <div class="founder-values">
                <div class="founder-value-card">
                    <div class="founder-value-icon"><i class="fa-solid fa-graduation-cap"></i></div>
                    <h3>Education for All</h3>
                    <p>Believed every Kenyan deserves access to quality technical education regardless of background.</p>
                </div>
                <div class="founder-value-card">
                    <div class="founder-value-icon"><i class="fa-solid fa-heart"></i></div>
                    <h3>Compassionate Leadership</h3>
                    <p>Led with empathy, personally sponsoring hundreds of students through their academic journey.</p>
                </div>
                <div class="founder-value-card">
                    <div class="founder-value-icon"><i class="fa-solid fa-seedling"></i></div>
                    <h3>Lasting Impact</h3>
                    <p>Built an institution that continues to transform lives, with graduates serving communities across Kenya.</p>
                </div>
            </div>
        </section>

        <!-- Legacy -->
        <section class="founder-legacy founder-anim-4">
            <div class="founder-legacy-inner">
                <p class="founder-legacy-subtitle">Her Legacy</p>
                <h2>The Lizzie Wanyoike Endowment</h2>
                <p>Established to preserve her legacy, this fund provides full-tuition coverage for exceptional students from historically underserved communities. Every application processed through this bursary system is a tribute to her vision.</p>
                <a href="apply.php" class="btn">Apply for Legacy Scholarship <i class="fa-solid fa-arrow-right"></i></a>
            </div>
        </section>
    </main>
    <?php include 'includes/footer.php'; ?>
    <script>
    (function() {
        var saved = localStorage.getItem('nibs-theme');
        if (saved === 'dark') document.documentElement.setAttribute('data-theme', 'dark');
    })();
    </script>
</body>
</html>