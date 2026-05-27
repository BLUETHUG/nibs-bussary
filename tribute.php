<?php 
    $pageTitle = "In Memory of Lizzie Wanyoike - NIBS Technical College";
?>
<!DOCTYPE html>
<html lang="en">
<?php include 'includes/head.php'; ?>
<body>
    <?php include 'includes/navbar.php'; ?>

    <main>
        <!-- Hero Section -->
        <section style="min-height: 80vh; background: url('assets/img/lizzie_wanyoike.png') center/cover no-repeat; display: flex; align-items: center; justify-content: center; position: relative; padding-top: 80px;">
            <div style="position: absolute; inset: 0; background: linear-gradient(to bottom, rgba(11, 61, 145, 0.95), rgba(11, 61, 145, 0.6));"></div>
            <div style="position: relative; z-index: 10; text-align: center; color: white; padding: 0 5%;">
                <h4 style="color: white; text-transform: uppercase; letter-spacing: 4px; font-weight: 700; margin-bottom: 2rem; opacity: 0.8;">Honoring the Legacy of</h4>
                <h1 style="font-family: 'Playfair Display', serif; font-size: 5rem; margin-bottom: 1rem; color: white;">Lizzie Muthoni Wanyoike</h1>
                <p style="font-size: 1.5rem; opacity: 0.8; font-style: italic;">1951 — 2024</p>
                <p style="margin-top: 2rem; font-size: 1.2rem; opacity: 0.9; max-width: 700px; margin-left: auto; margin-right: auto; line-height: 1.8;">"Education is the most powerful weapon which you can use to change the world. My dream is to see every child in Kenya empowered through knowledge."</p>
            </div>
        </section>

        <!-- Biography Section -->
        <section style="padding: 10rem 5%; background: white;">
            <div style="max-width: 1200px; margin: 0 auto; display: grid; grid-template-columns: 1fr 1fr; gap: 8rem; align-items: center;">
                <div>
                     <div style="position: relative;">
                        <div style="position: absolute; top: -30px; left: -30px; width: 100%; height: 100%; border: 15px solid var(--neutral-gray); z-index: 1; border-radius: 20px;"></div>
                        <img src="assets/img/lizzie_wanyoike.png" style="width: 100%; position: relative; z-index: 2; border-radius: 20px; box-shadow: 0 30px 60px rgba(0,0,0,0.1);" alt="Lizzie Wanyoike">
                     </div>
                </div>
                <div>
                    <h2 style="font-size: 3rem; margin-bottom: 2.5rem; font-family: 'Playfair Display', serif;">A Visionary Educator & Philanthropist</h2>
                    <p style="font-size: 1.1rem; color: var(--text-dark); line-height: 2; margin-bottom: 2rem;">Lizzie Wanyoike was more than just the founder of NIBS Technical College; she was a beacon of hope for thousands of young Kenyans. Starting with just a handful of students, her unwavering dedication to technical excellence transformed NIBS into a premier academic institution.</p>
                    <p style="font-size: 1.1rem; color: var(--text-dark); line-height: 2; margin-bottom: 3rem;">Her philosophy was simple: financial constraints should never stand in the way of talent. This Bursary System is a direct continuation of her life's work—ensuring that the doors of opportunity remain open for all.</p>
                    
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem;">
                        <div style="border-left: 4px solid var(--primary-red); padding-left: 1.5rem;">
                            <h3 style="margin: 0; font-size: 2.5rem;">1999</h3>
                            <p style="color: var(--text-muted); text-transform: uppercase; font-weight: 700; font-size: 0.7rem;">Founded NIBS</p>
                        </div>
                        <div style="border-left: 4px solid var(--primary-blue); padding-left: 1.5rem;">
                            <h3 style="margin: 0; font-size: 2.5rem;">25k+</h3>
                            <p style="color: var(--text-muted); text-transform: uppercase; font-weight: 700; font-size: 0.7rem;">Graduates Empowered</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Legacy Funds -->
        <section class="impact-section section" style="text-align:center;">
            <div class="section-inner">
                <div class="section-header">
                    <span class="subtitle">Her Legacy</span>
                    <h2 style="color:var(--white);">The Lizzie Wanyoike Endowment</h2>
                    <p style="color:rgba(255,255,255,0.7);max-width:700px;margin:0 auto 2rem;">Established to preserve her legacy, this fund provides full-tuition coverage for exceptional students from historically underserved communities.</p>
                    <a href="apply.php" class="btn btn-primary" style="padding:1rem 3rem;font-size:1.05rem;">Apply for Legacy Scholarship <i class="fa-solid fa-arrow-right"></i></a>
                </div>
            </div>
        </section>

    </main>

    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;1,400&display=swap" rel="stylesheet">
    <?php include 'includes/footer.php'; ?>
</body>
</html>
