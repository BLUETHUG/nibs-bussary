<?php 
    $pageTitle = "Notifications - NIBS Bursary";
    if (session_status() === PHP_SESSION_NONE) session_start();
    if (!isset($_SESSION['user_id'])) { header('Location: login.php', true, 302); exit; }
?>
<!DOCTYPE html>
<html lang="en">
<?php include 'includes/head.php'; ?>
<body style="background: var(--off-white); display: flex;">
    
    <?php include 'includes/sidebar.php'; ?>

    <div style="flex: 1; min-width: 0;">
        <!-- Top bar -->
        <div style="background: var(--white); padding: 1.2rem 3rem; display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid var(--border); position: sticky; top: 0; z-index: 100;">
            <h2 style="margin: 0; font-size: 1.4rem; color: var(--primary);">Notifications Center</h2>
            <button class="btn-secondary" style="width: auto; padding: 0.6rem 1.5rem; font-size: 0.85rem; border-radius: var(--radius-sm); margin: 0; border: 1px solid var(--border); color: var(--text-muted); background: var(--white);">Mark All as Read</button>
        </div>

        <main style="padding: 3rem; max-width: 1000px; margin: 0 auto;">
            
            <div style="display: flex; flex-direction: column; gap: 1rem;">
                
                <!-- Today -->
                <h4 style="color: var(--text-muted); font-size: 0.8rem; text-transform: uppercase; letter-spacing: 2px; margin: 2rem 0 1rem;">Today</h4>
                
                <div style="background: var(--white); border-radius: var(--radius-md); box-shadow: var(--shadow-sm); padding: 2rem; border-left: 4px solid var(--accent); display: flex; gap: 2rem; align-items: flex-start;">
                    <div style="width: 45px; height: 45px; background: rgba(220, 38, 38, 0.12); color: var(--accent); border-radius: 12px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;"><i class="fa-solid fa-file-signature"></i></div>
                    <div style="flex: 1;">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem;">
                            <h4 style="margin: 0; font-size: 1.1rem; color: var(--primary);">Application Submitted Successfully</h4>
                            <span style="font-size: 0.75rem; color: var(--text-muted);">10:45 AM</span>
                        </div>
                        <p style="font-size: 0.9rem; color: var(--text-dark); line-height: 1.6;">Your application for the <strong>Jan-Apr 2024 Bursary Allocation</strong> has been received. You can track its progress in the Dashboard.</p>
                        <div style="margin-top: 1.5rem; display: flex; gap: 1rem;">
                            <button class="btn-secondary" style="width: auto; padding: 0.5rem 1.2rem; font-size: 0.8rem; border-radius: var(--radius-sm); margin: 0; border: 1px solid var(--border);">View Application</button>
                        </div>
                    </div>
                </div>

                <!-- Yesterday -->
                <h4 style="color: var(--text-muted); font-size: 0.8rem; text-transform: uppercase; letter-spacing: 2px; margin: 2rem 0 1rem;">Yesterday</h4>

                <div style="background: var(--white); border-radius: var(--radius-md); box-shadow: var(--shadow-sm); padding: 2rem; border-left: 4px solid #d68a2e; display: flex; gap: 2rem; align-items: flex-start;">
                    <div style="width: 45px; height: 45px; background: rgba(214, 138, 46, 0.12); color: #d68a2e; border-radius: 12px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;"><i class="fa-solid fa-triangle-exclamation"></i></div>
                    <div style="flex: 1;">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem;">
                            <h4 style="margin: 0; font-size: 1.1rem; color: #9c4221;">Incomplete Profile Warning</h4>
                            <span style="font-size: 0.75rem; color: var(--text-muted);">04:20 PM</span>
                        </div>
                        <p style="font-size: 0.9rem; color: var(--text-dark); line-height: 1.6;">Your profile is missing an emergency contact. Please update it to ensure your application can be processed without delays.</p>
                    </div>
                </div>

                <!-- Earlier -->
                <h4 style="color: var(--text-muted); font-size: 0.8rem; text-transform: uppercase; letter-spacing: 2px; margin: 2rem 0 1rem;">Earlier</h4>

                <div style="background: var(--white); border-radius: var(--radius-md); box-shadow: var(--shadow-sm); padding: 2rem; opacity: 0.6; border-left: 4px solid var(--border); display: flex; gap: 2rem; align-items: flex-start;">
                    <div style="width: 45px; height: 45px; background: var(--off-white); color: var(--text-light); border-radius: 12px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;"><i class="fa-solid fa-user-check"></i></div>
                    <div style="flex: 1;">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem;">
                            <h4 style="margin: 0; font-size: 1.1rem; color: var(--text-dark);">Account Verified</h4>
                            <span style="font-size: 0.75rem; color: var(--text-muted);">March 10, 2024</span>
                        </div>
                        <p style="font-size: 0.9rem; color: var(--text-dark); line-height: 1.6;">Your email address (john.doe@nibs.ac.ke) has been successfully verified.</p>
                    </div>
                </div>

            </div>

        </main>
    </div>

    <script src="js/app.js"></script>
</body>
</html>
