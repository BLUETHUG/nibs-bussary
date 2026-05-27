<?php 
    $pageTitle = "My Documents - NIBS Bursary";
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
            <h2 style="margin: 0; font-size: 1.4rem; color: var(--primary);">Document Management</h2>
            <p style="font-size: 0.85rem; color: var(--text-muted); margin: 0;">Documents Verified: <span style="color: var(--success-green); font-weight: 700;">3/5</span></p>
        </div>

        <main style="padding: 3rem;">
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(350px, 1fr)); gap: 2rem;">
                
                <!-- ID Card -->
                <div style="background: var(--white); border-radius: var(--radius-md); box-shadow: var(--shadow-sm); padding: 2.5rem; display: flex; flex-direction: column; justify-content: space-between;">
                    <div>
                        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 2rem;">
            <div style="width: 50px; height: 50px; background: rgba(220, 38, 38, 0.12); color: var(--accent); border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.4rem;"><i class="fa-solid fa-id-card"></i></div>

            <div style="width: 50px; height: 50px; background: rgba(220, 38, 38, 0.12); color: var(--accent); border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.4rem;"><i class="fa-solid fa-receipt"></i></div>
                            <span style="background: #fff3cd; color: #856404; font-size: 0.75rem; font-weight: 600; padding: 0.3rem 0.8rem; border-radius: 20px;">Reviewing</span>
                        </div>
                        <h4 style="margin-bottom: 0.5rem; font-size: 1.1rem; color: var(--primary);">Current Fee Statement</h4>
                        <p style="font-size: 0.85rem; color: var(--text-muted); min-height: 40px;">Official statement from the finance office showing current balance.</p>
                    </div>
                    <div style="margin-top: 2rem; padding-top: 1.5rem; border-top: 1px solid var(--border); display: flex; justify-content: space-between; align-items: center;">
                        <span style="font-size: 0.75rem; color: var(--text-muted);">Uploaded: 15/03/2024</span>
                        <div style="display: flex; gap: 0.5rem;">
                            <button class="btn-secondary" style="width: auto; padding: 0.5rem; font-size: 0.8rem; border-radius: var(--radius-sm); margin: 0; border: 1px solid var(--border);"><i class="fa-solid fa-eye"></i></button>
                            <button class="btn-secondary" style="width: auto; padding: 0.5rem; font-size: 0.8rem; border-radius: var(--radius-sm); margin: 0; border: 1px solid var(--border);"><i class="fa-solid fa-trash" style="color: #e53e3e;"></i></button>
                        </div>
                    </div>
                </div>

                <!-- Empty state for new upload -->
                <div style="background: rgba(255,255,255,0.6); border-radius: var(--radius-md); border: 2px dashed var(--border); padding: 2.5rem; display: flex; flex-direction: column; align-items: center; justify-content: center; text-align: center; cursor: pointer; transition: all 0.3s;" onmouseover="this.style.borderColor='var(--accent)'; this.style.background='rgba(220,38,38,0.04)';" onmouseout="this.style.borderColor='var(--border)'; this.style.background='rgba(255,255,255,0.6)';">
                    <div style="width: 60px; height: 60px; background: var(--white); color: var(--accent); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-bottom: 1.5rem; font-size: 1.5rem; box-shadow: var(--shadow-sm);"><i class="fa-solid fa-plus"></i></div>
                    <h4 style="color: var(--primary);">Upload New Document</h4>
                    <p style="font-size: 0.8rem; color: var(--text-muted); margin-top: 0.5rem;">PDF, PNG or JPG (Max 10MB)</p>
                </div>

            </div>

            <div style="margin-top: 4rem; background: var(--white); border-radius: var(--radius-md); box-shadow: var(--shadow-sm); padding: 3rem;">
                <h3 style="margin-bottom: 2rem; color: var(--primary);">Upload History & Audit Log</h3>
                <div style="display: flex; flex-direction: column; gap: 1rem;">
                    <div style="display: flex; justify-content: space-between; padding: 1rem; background: var(--off-white); border-radius: var(--radius-sm); font-size: 0.9rem;">
                        <span style="font-weight: 600; color: var(--primary);">fee_statement_mar_2024.pdf</span>
                        <span style="color: var(--text-muted);">Verification Hash: 0x7f2a...8b9c</span>
                        <span style="color: var(--success-green); font-weight: 700;">SECURED</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; padding: 1rem; background: var(--off-white); border-radius: var(--radius-sm); font-size: 0.9rem;">
                        <span style="font-weight: 600; color: var(--primary);">national_id_copy.jpg</span>
                        <span style="color: var(--text-muted);">Verification Hash: 0x3d1e...a4f2</span>
                        <span style="color: var(--success-green); font-weight: 700;">SECURED</span>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script src="js/app.js"></script>
</body>
</html>
