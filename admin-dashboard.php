<?php 
    header('Location: /admin/dashboard', true, 301);
    exit;
    $pageTitle = "Admin Dashboard - NIBS Bursary Portal";
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
            <h2 style="margin: 0; font-size: 1.4rem; color: var(--text-dark);">Command Center Overview</h2>
            <div style="display: flex; align-items: center; gap: 2rem;">
                <button class="btn-secondary" style="width: auto; padding: 0.7rem 1.5rem; font-size: 0.85rem; border-radius: 8px; margin: 0;"><i class="fa-solid fa-file-export"></i> Export Report</button>
                <div style="width: 45px; height: 45px; background: var(--primary-red); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: white; font-weight: 800;">AD</div>
            </div>
        </div>

        <main style="padding: 3rem;">
            <!-- Stats -->
            <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 2rem; margin-bottom: 3rem;">
                <div class="glass-panel" style="background: white; border: none; padding: 2rem;">
                    <p style="color: var(--text-muted); font-size: 0.8rem; font-weight: 700; text-transform: uppercase;">Total Apps</p>
                    <h3 style="margin: 0.5rem 0; font-size: 2.2rem;">2,543</h3>
                    <p style="font-size: 0.75rem; color: #38a169; font-weight: 700;"><i class="fa-solid fa-arrow-up"></i> 12% increase</p>
                </div>
                <div class="glass-panel" style="background: white; border: none; padding: 2rem;">
                    <p style="color: var(--text-muted); font-size: 0.8rem; font-weight: 700; text-transform: uppercase;">Pending Review</p>
                    <h3 style="margin: 0.5rem 0; font-size: 2.2rem; color: var(--primary-blue);">142</h3>
                    <p style="font-size: 0.75rem; color: #718096;">Requires action</p>
                </div>
                <div class="glass-panel" style="background: white; border: none; padding: 2rem;">
                    <p style="color: var(--text-muted); font-size: 0.8rem; font-weight: 700; text-transform: uppercase;">Funds Allocated</p>
                    <h3 style="margin: 0.5rem 0; font-size: 2.2rem;">5.2M</h3>
                    <p style="font-size: 0.75rem; color: #38a169; font-weight: 700;">KES (This Year)</p>
                </div>
                <div class="glass-panel" style="background: white; border: none; padding: 2rem;">
                    <p style="color: var(--text-muted); font-size: 0.8rem; font-weight: 700; text-transform: uppercase;">Security Alerts</p>
                    <h3 style="margin: 0.5rem 0; font-size: 2.2rem; color: var(--primary-red);">03</h3>
                    <p style="font-size: 0.75rem; color: #e53e3e; font-weight: 700;">Potential fraud</p>
                </div>
            </div>

            <!-- Plots Placeholder -->
            <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 2rem;">
                <div class="glass-panel" style="background: white; border: none; padding: 2.5rem; min-height: 400px;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
                        <h3>Bursary Distribution by Department</h3>
                        <select style="width: auto; padding: 0.4rem 1rem; font-size: 0.8rem;"><option>All Departments</option></select>
                    </div>
                    <div style="height: 300px; display: flex; align-items: flex-end; justify-content: space-around; padding-bottom: 2rem; border-bottom: 2px solid #edf2f7; gap: 1rem;">
                        <Bar height="100%" color="var(--primary-blue)" label="IT" />
                        <Bar height="85%" color="var(--primary-blue)" label="Business" />
                        <Bar height="60%" color="var(--primary-blue)" label="Hospitality" />
                        <Bar height="40%" color="var(--primary-blue)" label="Engineering" />
                        <Bar height="30%" color="var(--primary-blue)" label="Health" />
                        <Bar height="15%" color="var(--primary-blue)" label="Other" />
                    </div>
                </div>

                <div class="glass-panel" style="background: white; border: none; padding: 2.5rem;">
                    <h3 style="margin-bottom: 2rem;">Allocation Status</h3>
                    <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                        <div style="display: flex; justify-content: space-between; font-size: 0.9rem;"><span>Approved</span><span style="font-weight: 700;">68%</span></div>
                        <div style="width: 100%; height: 10px; background: #f0fff4; border-radius: 10px;"><div style="width: 68%; height: 100%; background: #38a169; border-radius: 10px;"></div></div>
                        
                        <div style="display: flex; justify-content: space-between; font-size: 0.9rem; margin-top: 1rem;"><span>Pending</span><span style="font-weight: 700;">22%</span></div>
                        <div style="width: 100%; height: 10px; background: #fffaf0; border-radius: 10px;"><div style="width: 22%; height: 100%; background: #ed8936; border-radius: 10px;"></div></div>
                        
                        <div style="display: flex; justify-content: space-between; font-size: 0.9rem; margin-top: 1rem;"><span>Rejected</span><span style="font-weight: 700;">10%</span></div>
                        <div style="width: 100%; height: 10px; background: #fff5f5; border-radius: 10px;"><div style="width: 10%; height: 100%; background: #e53e3e; border-radius: 10px;"></div></div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <?php 
        function Bar($height, $color, $label) {
            echo '<div style="flex: 1; display:flex; flex-direction:column; align-items:center; gap: 1rem;">
                    <div style="width: 70%; height: ' . $height . '; background: ' . $color . '; opacity: 0.8; border-radius: 8px 8px 0 0; transition: transform 0.3s ease;" onmouseover="this.style.transform=\'scaleY(1.05)\'" onmouseout="this.style.transform=\'scaleY(1)\'"></div>
                    <span style="font-size: 0.75rem; font-weight: 700; color: var(--text-muted);">' . $label . '</span>
                  </div>';
        }
    ?>
    <script src="js/app.js"></script>
</body>
</html>
