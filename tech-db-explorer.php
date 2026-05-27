<?php 
    if (session_status() === PHP_SESSION_NONE) session_start();
    if (!isset($_SESSION['user_id']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'tech') {
        header('Location: login.php', true, 302); exit;
    }
    $pageTitle = "Database Explorer - NIBS Console";
?>
<!DOCTYPE html>
<html lang="en">
<?php include 'includes/head.php'; ?>
<body style="background: var(--bg-light); display: flex;">
    
    <?php include 'includes/sidebar.php'; ?>

    <div style="flex: 1; min-width: 0;">
        <!-- Top bar -->
        <div style="background: white; padding: 1.2rem 3rem; display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid var(--border-color); position: sticky; top: 0; z-index: 100;">
            <h2 style="margin: 0; font-size: 1.4rem; color: var(--text-dark);"><i class="fa-solid fa-database" style="color: var(--primary-blue); margin-right: 0.5rem;"></i> Database Management Console</h2>
            <div style="display: flex; gap: 1rem;">
                <button class="btn-secondary" style="width: auto; padding: 0.6rem 1.2rem; margin: 0; font-size: 0.8rem;"><i class="fa-solid fa-download"></i> Backup DB</button>
                <button style="width: auto; padding: 0.6rem 1.2rem; background: var(--primary-red); color: white; border-radius: 8px; font-size: 0.8rem;"><i class="fa-solid fa-triangle-exclamation"></i> SQL Console</button>
            </div>
        </div>

        <main style="padding: 3rem;">
            <!-- Database Overview -->
            <div style="display: grid; grid-template-columns: 250px 1fr; gap: 2rem;">
                <!-- Table List -->
                <div class="glass-panel" style="background: white; border: none; padding: 1.5rem;">
                    <h4 style="margin-bottom: 1.5rem; font-size: 0.75rem; color: var(--text-muted); text-transform: uppercase;">Tables</h4>
                    <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                        <TableLink name="users" count="1,240" active="true" />
                        <TableLink name="applications" count="2,543" />
                        <TableLink name="documents" count="8,120" />
                        <TableLink name="funds" count="12" />
                        <TableLink name="audit_logs" count="45,000" />
                        <TableLink name="sessions" count="342" />
                    </div>
                </div>

                <!-- Table Content -->
                <div class="glass-panel" style="background: white; border: none; padding: 0; overflow: hidden;">
                    <div style="padding: 1.5rem 2rem; border-bottom: 1px solid var(--border-color); display: flex; justify-content: space-between; align-items: center; background: #fafafa;">
                        <h4 style="margin: 0;">Table: <span style="color: var(--primary-blue);">users</span></h4>
                        <div style="display: flex; gap: 1rem;">
                            <input type="text" placeholder="Filter rows..." style="padding: 0.4rem 1rem; border-radius: 6px; font-size: 0.8rem; width: 250px;">
                            <button class="btn-secondary" style="width: auto; padding: 0.4rem 1rem; margin: 0; font-size: 0.75rem;">Run Query</button>
                        </div>
                    </div>
                    <div style="overflow-x: auto;">
                        <table style="width: 100%; border-collapse: collapse;">
                            <thead style="background: #f8fafc;">
                                <tr>
                                    <th style="padding: 1rem; text-align: left; font-size: 0.7rem; color: var(--text-muted);">ID</th>
                                    <th style="padding: 1rem; text-align: left; font-size: 0.7rem; color: var(--text-muted);">EMAIL</th>
                                    <th style="padding: 1rem; text-align: left; font-size: 0.7rem; color: var(--text-muted);">ROLE</th>
                                    <th style="padding: 1rem; text-align: left; font-size: 0.7rem; color: var(--text-muted);">CREATED_AT</th>
                                    <th style="padding: 1rem; text-align: right; font-size: 0.7rem; color: var(--text-muted);">ACTIONS</th>
                                </tr>
                            </thead>
                            <tbody>
                                <DBRow id="1" email="admin@nibs.ac.ke" role="admin" date="2024-01-10" />
                                <DBRow id="2" email="tech@nibs.ac.ke" role="tech" date="2024-01-11" />
                                <DBRow id="3" email="alice@nibs.ac.ke" role="student" date="2024-02-01" />
                                <DBRow id="4" email="bob@nibs.ac.ke" role="student" date="2024-02-05" />
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <?php 
        function TableLink($props) {
            $activeStyle = isset($props['active']) ? 'background: var(--bg-light-blue); color: var(--primary-blue); border-left: 3px solid var(--primary-blue);' : 'color: var(--text-dark);';
            echo '<div style="padding: 0.8rem 1.2rem; border-radius: 8px; font-size: 0.85rem; font-weight: 600; cursor: pointer; display: flex; justify-content: space-between; ' . $activeStyle . '">
                    <span>' . $props['name'] . '</span>
                    <span style="font-size: 0.7rem; opacity: 0.6;">' . $props['count'] . '</span>
                  </div>';
        }
        function DBRow($props) {
            echo '<tr style="border-bottom: 1px solid var(--border-color);">
                    <td style="padding: 1rem; font-family: monospace; font-size: 0.8rem;">' . $props['id'] . '</td>
                    <td style="padding: 1rem; font-size: 0.85rem; font-weight: 600;">' . $props['email'] . '</td>
                    <td style="padding: 1rem;"><span style="font-size: 0.7rem; background: #e2e8f0; padding: 0.2rem 0.6rem; border-radius: 4px; font-weight: 700;">' . strtoupper($props['role']) . '</span></td>
                    <td style="padding: 1rem; font-size: 0.8rem; color: var(--text-muted);">' . $props['date'] . '</td>
                    <td style="padding: 1rem; text-align: right;">
                        <button style="width: auto; padding: 0.3rem 0.6rem; margin: 0; font-size: 0.7rem; background: var(--border-color);">EDIT</button>
                    </td>
                  </tr>';
        }
    ?>
    <script src="js/app.js"></script>
</body>
</html>
