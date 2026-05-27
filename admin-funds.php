<?php 
    header('Location: /admin/funds', true, 301);
    exit;
    $pageTitle = "Fund Management - NIBS Admin";
?>
<!DOCTYPE html>
<html lang="en">
<?php include 'includes/head.php'; ?>
<body style="background: #f8fafc; display: flex;">
    
    <?php 
        if (!isset($_SESSION['role'])) $_SESSION['role'] = 'admin'; 
        include 'includes/sidebar.php'; 
    ?>

    <div style="flex: 1; min-width: 0;">
        <!-- Top bar -->
        <div style="background: white; padding: 1.2rem 3rem; display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #edf2f7; position: sticky; top: 0; z-index: 100;">
            <h2 style="margin: 0; font-size: 1.4rem; color: var(--text-dark);">Bursary Fund Control</h2>
            <button style="width: auto; background: var(--primary-blue); color: white; padding: 0.8rem 2rem; font-size: 0.9rem; border-radius: 10px;"><i class="fa-solid fa-wallet"></i> Top-up Budget</button>
        </div>

        <main style="padding: 3rem;">
            
            <!-- Overall Health -->
            <div class="glass-panel" style="background: var(--primary-blue); border: none; color: white; padding: 4rem; display: flex; justify-content: space-between; align-items: center; margin-bottom: 3rem; overflow: hidden; position: relative;">
                <div style="position: absolute; right: -50px; top: -50px; opacity: 0.05; font-size: 20rem;"><i class="fa-solid fa-sack-dollar"></i></div>
                <div style="position: relative; z-index: 2;">
                    <p style="text-transform: uppercase; letter-spacing: 2px; font-weight: 700; font-size: 0.8rem; opacity: 0.8; margin-bottom: 1rem;">Total Available Allocation</p>
                    <h1 style="color: white; font-size: 4rem; margin: 0; font-weight: 900;">KES 12,450,000</h1>
                    <div style="display: flex; gap: 3rem; margin-top: 2rem;">
                        <div>
                            <p style="font-size: 0.75rem; opacity: 0.7; font-weight: 700; text-transform: uppercase;">Allocated (65%)</p>
                            <h3 style="color: white; margin: 0;">KES 8.1M</h3>
                        </div>
                        <div style="border-left: 1px solid rgba(255,255,255,0.2); padding-left: 3rem;">
                            <p style="font-size: 0.75rem; opacity: 0.7; font-weight: 700; text-transform: uppercase;">Remaining (35%)</p>
                            <h3 style="color: var(--primary-red); margin: 0;">KES 4.35M</h3>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Fund Sources -->
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 2rem;">
                
                <div class="glass-panel" style="background: white; border: none; padding: 2.5rem;">
                    <h3 style="margin-bottom: 2rem;">Government Allocation</h3>
                    <p style="font-size: 1.8rem; font-weight: 800; color: var(--text-dark);">KES 6.0M</p>
                    <div style="width: 100%; height: 8px; background: #f0f7ff; border-radius: 10px; margin: 1.5rem 0; overflow: hidden;"><div style="width: 45%; height: 100%; background: var(--primary-blue); border-radius: 10px;"></div></div>
                    <p style="font-size: 0.8rem; color: var(--text-muted); font-weight: 600;">Utilized: 45% (KES 2.7M)</p>
                </div>

                <div class="glass-panel" style="background: white; border: none; padding: 2.5rem;">
                    <h3 style="margin-bottom: 2rem;">Private Donors</h3>
                    <p style="font-size: 1.8rem; font-weight: 800; color: var(--text-dark);">KES 4.2M</p>
                    <div style="width: 100%; height: 8px; background: #fff5f5; border-radius: 10px; margin: 1.5rem 0; overflow: hidden;"><div style="width: 82%; height: 100%; background: var(--primary-red); border-radius: 10px;"></div></div>
                    <p style="font-size: 0.8rem; color: var(--text-muted); font-weight: 600;">Utilized: 82% (KES 3.4M)</p>
                </div>

                <div class="glass-panel" style="background: white; border: none; padding: 2.5rem;">
                    <h3 style="margin-bottom: 2rem;">Scholarship Partner Fund</h3>
                    <p style="font-size: 1.8rem; font-weight: 800; color: var(--text-dark);">KES 2.25M</p>
                    <div style="width: 100%; height: 8px; background: #f0fff4; border-radius: 10px; margin: 1.5rem 0; overflow: hidden;"><div style="width: 12%; height: 100%; background: #38a169; border-radius: 10px;"></div></div>
                    <p style="font-size: 0.8rem; color: var(--text-muted); font-weight: 600;">Utilized: 12% (KES 270K)</p>
                </div>

            </div>

        </main>
    </div>

    <script src="js/app.js"></script>
</body>
</html>
