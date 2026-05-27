<?php 
    if (session_status() === PHP_SESSION_NONE) session_start();
    if (!isset($_SESSION['user_id']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'tech') {
        header('Location: login.php', true, 302); exit;
    }
    $pageTitle = "Tech Dashboard - NIBS Console";
?>
<!DOCTYPE html>
<html lang="en">
<?php include 'includes/head.php'; ?>
<body style="background: #f8fafc; display: flex;">
    
    <?php include 'includes/sidebar.php'; ?>

    <div style="flex: 1; min-width: 0;">
        <!-- Top bar -->
        <div style="background: white; padding: 1.2rem 3rem; display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #edf2f7; position: sticky; top: 0; z-index: 100;">
            <h2 style="margin: 0; font-size: 1.4rem; color: var(--text-dark);">System Status & Monitoring</h2>
            <div style="display: flex; align-items: center; gap: 2rem;">
                <span style="font-size: 0.8rem; background: #dcfce7; color: #166534; padding: 0.4rem 1rem; border-radius: 20px; font-weight: 700;">SERVER ONLINE</span>
                <div style="width: 45px; height: 45px; background: var(--primary-blue); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: white; font-weight: 800;">TS</div>
            </div>
        </div>

        <main style="padding: 3rem;">
            <!-- Health Stats -->
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 2rem; margin-bottom: 3rem;">
                <div class="glass-panel" style="background: white; border: none; padding: 2rem; display: flex; align-items: center; gap: 1.5rem;">
                    <div style="width: 50px; height: 50px; background: #ebf4ff; color: var(--primary-blue); border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.2rem;"><i class="fa-solid fa-microchip"></i></div>
                    <div><p style="color: var(--text-muted); font-size: 0.75rem; font-weight: 700; text-transform: uppercase;">CPU Load</p><h3 style="margin: 0;">12.4%</h3></div>
                </div>
                <div class="glass-panel" style="background: white; border: none; padding: 2rem; display: flex; align-items: center; gap: 1.5rem;">
                    <div style="width: 50px; height: 50px; background: #ebf4ff; color: var(--primary-blue); border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.2rem;"><i class="fa-solid fa-memory"></i></div>
                    <div><p style="color: var(--text-muted); font-size: 0.75rem; font-weight: 700; text-transform: uppercase;">Memory Usage</p><h3 style="margin: 0;">256MB / 2GB</h3></div>
                </div>
                <div class="glass-panel" style="background: white; border: none; padding: 2rem; display: flex; align-items: center; gap: 1.5rem;">
                    <div style="width: 50px; height: 50px; background: #fff5f5; color: var(--primary-red); border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.2rem;"><i class="fa-solid fa-database"></i></div>
                    <div><p style="color: var(--text-muted); font-size: 0.75rem; font-weight: 700; text-transform: uppercase;">DB Queries</p><h3 style="margin: 0;">42/sec</h3></div>
                </div>
                <div class="glass-panel" style="background: white; border: none; padding: 2rem; display: flex; align-items: center; gap: 1.5rem;">
                    <div style="width: 50px; height: 50px; background: #ebf4ff; color: var(--primary-blue); border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.2rem;"><i class="fa-solid fa-bolt"></i></div>
                    <div><p style="color: var(--text-muted); font-size: 0.75rem; font-weight: 700; text-transform: uppercase;">API Latency</p><h3 style="margin: 0;">24ms</h3></div>
                </div>
            </div>

            <!-- Sub Systems -->
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem;">
                <div class="glass-panel" style="background: white; border: none; padding: 2.5rem;">
                    <h3 style="margin-bottom: 2rem;">Security Logs</h3>
                    <div style="display: flex; flex-direction: column; gap: 1rem;">
                        <LogEntry time="10:45:12" msg="Unauthorized login attempt from 192.168.1.45" type="warning" />
                        <LogEntry time="09:22:10" msg="SSL Certificate verified and active" type="success" />
                        <LogEntry time="08:15:00" msg="Automatic backup completed successfully" type="success" />
                        <LogEntry time="04:00:22" msg="Brute force protection triggered for IP 10.0.0.8" type="error" />
                    </div>
                </div>

                <div class="glass-panel" style="background: white; border: none; padding: 2.5rem;">
                    <h3 style="margin-bottom: 2rem;">Technical Settings</h3>
                    <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                        <SettingItem label="Maintenance Mode" status="Offline" />
                        <SettingItem label="Debug Logging" status="Enabled" />
                        <SettingItem label="AI Eligibility Engine" status="Online" />
                        <SettingItem label="Blockchain Verification" status="Syncing (98%)" />
                    </div>
                    <button style="margin-top: 2rem; background: var(--primary-red); border-radius: 10px; width: 100%;">Flush System Cache</button>
                </div>
            </div>
        </main>
    </div>

    <?php 
        function LogEntry($time, $msg, $type) {
            $color = "#166534"; if($type == "warning") $color = "#92400e"; if($type == "error") $color = "#b91c1c";
            echo '<div style="font-family: monospace; font-size: 0.8rem; border-bottom: 1px solid #f8fafc; padding-bottom: 0.5rem;">
                    <span style="color: #94a3b8;">[' . $time . ']</span> <span style="color: ' . $color . '; font-weight: 700;">' . strtoupper($type) . ':</span> ' . $msg . '
                  </div>';
        }
        function SettingItem($label, $status) {
            echo '<div style="display: flex; justify-content: space-between; align-items: center; padding: 1rem; background: #f8fafc; border-radius: 10px;">
                    <span style="font-weight: 600; font-size: 0.9rem;">' . $label . '</span>
                    <span style="font-size: 0.8rem; font-weight: 800; color: var(--primary-blue);">' . $status . '</span>
                  </div>';
        }
    ?>
    <script src="js/app.js"></script>
</body>
</html>
