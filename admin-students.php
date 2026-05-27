<?php 
    header('Location: /admin/users', true, 301);
    exit;
    $pageTitle = "Student Registry - NIBS Admin";
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
            <h2 style="margin: 0; font-size: 1.4rem; color: var(--text-dark);">Student Registry Management</h2>
            <div style="display: flex; align-items: center; gap: 1rem;">
                <button style="width: auto; background: var(--primary-blue); color: white; padding: 0.8rem 2rem; font-size: 0.9rem; border-radius: 10px;"><i class="fa-solid fa-plus"></i> Add Student</button>
            </div>
        </div>

        <main style="padding: 3rem;">
            <div class="glass-panel" style="background: white; border: none; padding: 0; overflow: hidden; box-shadow: 0 4px 25px rgba(0,0,0,0.02);">
                <div style="padding: 2rem 3rem; border-bottom: 1px solid #edf2f7; display: flex; justify-content: space-between; align-items: center;">
                    <div style="display: flex; gap: 2rem;">
                        <h3 style="margin: 0;">Active Students List</h3>
                        <div style="display: flex; gap: 1rem; align-items: center; color: var(--text-muted); font-size: 0.85rem;">
                            <span>Total: <strong>1,240</strong></span>
                            <span>Suspended: <strong>12</strong></span>
                        </div>
                    </div>
                    <div style="display: flex; gap: 1rem;">
                        <input type="text" placeholder="Search by name, ID or Email..." style="width: 350px; padding: 0.6rem 1.2rem; border-radius: 8px; font-size: 0.85rem;">
                        <button class="btn-secondary" style="width: auto; padding: 0.6rem 1.5rem; font-size: 0.85rem; border-radius: 8px; margin: 0;">Export CSV</button>
                    </div>
                </div>

                <div style="overflow-x: auto;">
                    <table style="width: 100%; min-width: 1000px;">
                        <thead>
                            <tr>
                                <th>Student Detail</th>
                                <th>ID Number</th>
                                <th>Department</th>
                                <th>Account Status</th>
                                <th>Apps</th>
                                <th style="text-align: right;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <StudentRow name="Alice Kamau" email="alice@nibs.ac.ke" reg="NIBS/22/019" dep="ICT" status="Active" apps="02" />
                            <StudentRow name="George Maina" email="george@nibs.ac.ke" reg="NIBS/23/452" dep="Business" status="Active" apps="01" />
                            <StudentRow name="Sarah Wanjiku" email="sarah@nibs.ac.ke" reg="NIBS/22/088" dep="Hospitality" status="Suspended" apps="00" />
                            <StudentRow name="David Ouma" email="david@nibs.ac.ke" reg="NIBS/21/992" dep="Engineering" status="Active" apps="03" />
                        </tbody>
                    </table>
                </div>
                
                <div style="padding: 1.5rem 3rem; background: #fcfcfc; border-top: 1px solid #edf2f7; display: flex; justify-content: space-between; align-items: center;">
                    <p style="font-size: 0.85rem; color: var(--text-muted); margin: 0;">Showing 1-10 of 1,240 students</p>
                    <div style="display: flex; gap: 0.5rem;">
                        <button class="btn-secondary" style="width: auto; padding: 0.5rem 1.2rem; font-size: 0.75rem; border-radius: 6px; margin: 0;">Previous</button>
                        <button class="btn-secondary" style="width: auto; padding: 0.5rem 1.2rem; font-size: 0.75rem; border-radius: 6px; margin: 0;">Next</button>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <?php 
        function StudentRow($props) {
            $statusColor = $props['status'] == "Active" ? "#38a169" : "#e53e3e";
            $statusBg = $props['status'] == "Active" ? "#f0fff4" : "#fff5f5";
            
            echo '<tr>
                    <td style="display: flex; align-items: center; gap: 1rem; padding: 1.5rem 3rem;">
                        <div style="width: 40px; height: 40px; background: #f0f7ff; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-weight: 800; color: var(--primary-blue);">' . substr($props['name'], 0, 1) . '</div>
                        <div>
                            <p style="font-weight: 700; margin: 0; font-size: 0.9rem;">' . $props['name'] . '</p>
                            <p style="font-size: 0.75rem; color: var(--text-muted); margin: 0;">' . $props['email'] . '</p>
                        </div>
                    </td>
                    <td style="color: var(--text-muted); font-size: 0.9rem;">' . $props['reg'] . '</td>
                    <td style="font-weight: 600; font-size: 0.9rem;">' . $props['dep'] . '</td>
                    <td><span style="font-size: 0.7rem; font-weight: 800; text-transform: uppercase; padding: 0.4rem 0.8rem; background: ' . $statusBg . '; color: ' . $statusColor . '; border-radius: 6px;">' . $props['status'] . '</span></td>
                    <td style="font-weight: 700;">' . $props['apps'] . '</td>
                    <td style="text-align: right;">
                        <div style="display:flex; justify-content: flex-end; gap: 0.5rem;">
                            <button class="btn-secondary" style="width: auto; padding: 0.5rem; font-size:0.8rem; margin:0;"><i class="fa-solid fa-eye"></i></button>
                            <button class="btn-secondary" style="width: auto; padding: 0.5rem; font-size:0.8rem; margin:0;"><i class="fa-solid fa-pen-to-square"></i></button>
                            <button class="btn-secondary" style="width: auto; padding: 0.5rem; font-size:0.8rem; margin:0; color: #e53e3e;"><i class="fa-solid fa-ban"></i></button>
                        </div>
                    </td>
                  </tr>';
        }
    ?>
    <script src="js/app.js"></script>
</body>
</html>
