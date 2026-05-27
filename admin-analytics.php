<?php 
    header('Location: /admin/reports', true, 301);
    exit;
    $pageTitle = "System Analytics - NIBS Admin";
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
            <h2 style="margin: 0; font-size: 1.4rem; color: var(--text-dark);">Advanced Data Analytics</h2>
            <div style="display: flex; gap: 1rem;">
                <select style="width: auto; padding: 0.6rem 1.2rem; font-size: 0.85rem; border-radius: 8px;"><option>Year 2024</option></select>
                <button class="btn-secondary" style="width: auto; padding: 0.6rem 1.5rem; font-size: 0.85rem; border-radius: 8px; margin: 0;">Download PDF</button>
            </div>
        </div>

        <main style="padding: 3rem;">
            
            <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 2rem; margin-bottom: 3rem;">
                <StatCard label="Total Impact" val="12,500+" desc="Students funded since 2010" />
                <StatCard label="Avg. Allocation" val="KES 35K" desc="Per successful applicant" />
                <StatCard label="Success Rate" val="74%" desc="Total approved vs submitted" />
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem;">
                <!-- Demographic Map Placeholder -->
                <div class="glass-panel" style="background: white; border: none; padding: 3rem;">
                    <h3>Regional Distribution (Kenya)</h3>
                    <p style="color: var(--text-muted); font-size: 0.9rem; margin-bottom: 2rem;">Bursary applicants by county origins</p>
                    <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                        <CountyItem name="Nairobi" percent="35" color="var(--primary-blue)" />
                        <CountyItem name="Kiambu" percent="28" color="var(--primary-blue)" />
                        <CountyItem name="Murang'a" percent="18" color="var(--primary-blue)" />
                        <CountyItem name="Nakuru" percent="12" color="var(--primary-blue)" />
                        <CountyItem name="Mombasa" percent="7" color="var(--primary-blue)" />
                    </div>
                </div>

                <!-- Trend Line -->
                <div class="glass-panel" style="background: white; border: none; padding: 3rem;">
                    <h3>Application Trends</h3>
                    <p style="color: var(--text-muted); font-size: 0.9rem; margin-bottom: 2rem;">Submissions over the last 12 months</p>
                    <div style="height: 300px; display: flex; align-items: flex-end; justify-content: space-between; padding-top: 1rem; border-left: 2px solid #edf2f7; border-bottom: 2px solid #edf2f7;">
                         <Dot height="20%" label="Jan" />
                         <Dot height="35%" label="Feb" />
                         <Dot height="85%" label="Mar" />
                         <Dot height="45%" label="Apr" />
                         <Dot height="50%" label="May" />
                         <Dot height="30%" label="Jun" />
                    </div>
                </div>
            </div>

        </main>
    </div>

    <?php 
        function StatCard($props) {
            echo '<div class="glass-panel" style="background: white; border: none; padding: 2.5rem; text-align: center;">
                    <p style="text-transform: uppercase; font-weight: 800; font-size: 0.75rem; color: var(--text-muted); margin-bottom: 0.5rem; letter-spacing: 1px;">' . $props['label'] . '</p>
                    <h2 style="font-size: 2.5rem; margin: 0 0 0.5rem;">' . $props['val'] . '</h2>
                    <p style="font-size: 0.85rem; color: #a0aec0;">' . $props['desc'] . '</p>
                  </div>';
        }
        function CountyItem($props) {
            echo '<div style="margin-bottom: 1rem;">
                    <div style="display: flex; justify-content: space-between; font-size: 0.85rem; margin-bottom: 0.5rem;"><span>' . $props['name'] . '</span><span style="font-weight: 800;">' . $props['percent'] . '%</span></div>
                    <div style="width: 100%; height: 6px; background: #f8fafc; border-radius: 10px; overflow: hidden;"><div style="width: ' . $props['percent'] . '%; height: 100%; background: ' . $props['color'] . '; border-radius: 10px;"></div></div>
                  </div>';
        }
        function Dot($height, $label) {
            echo '<div style="flex: 1; display: flex; flex-direction: column; align-items:center; position: relative;">
                    <div style="width: 12px; height: 12px; background: var(--primary-red); border-radius: 50%; box-shadow: 0 0 0 5px rgba(16, 185, 129, 0.1); margin-bottom: ' . $height . ';"></div>
                    <span style="font-size: 0.65rem; color: var(--text-muted); font-weight: 600; margin-bottom: -1.5rem;">' . $label . '</span>
                  </div>';
        }
    ?>
    <script src="js/app.js"></script>
</body>
</html>
