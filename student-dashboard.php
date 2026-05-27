<?php 
    $pageTitle = "Dashboard - NIBS Bursary Portal";
    if (session_status() === PHP_SESSION_NONE) session_start();
    if (!isset($_SESSION['user_id'])) { header('Location: login.php', true, 302); exit; }
    $fullName = htmlspecialchars($_SESSION['full_name'] ?? 'Student');
    $initials = strtoupper(substr($fullName, 0, 1) . (strpos($fullName, ' ') !== false ? substr($fullName, strpos($fullName, ' ') + 1, 1) : ''));
    $indexNum = htmlspecialchars($_SESSION['index_number'] ?? 'STUD-001');
?>
<!DOCTYPE html>
<html lang="en">
<?php include 'includes/head.php'; ?>
<body style="background: var(--off-white); display: flex;">

    <?php include 'includes/sidebar.php'; ?>

    <div style="flex: 1; min-width: 0;">
        <div style="background: var(--white); padding: 1rem 2.5rem; display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid var(--border); position: sticky; top: 0; z-index: 100;">
            <div style="display: flex; align-items: center; gap: 1.5rem;">
                <h2 style="margin: 0; font-size: 1.2rem; color: var(--primary);">Welcome, <span style="color: var(--accent);"><?= $fullName ?></span></h2>
                <div style="background: var(--off-white); padding: 0.3rem 0.8rem; border-radius: 20px; display: flex; align-items: center; gap: 0.4rem;">
                    <i class="fa-solid fa-shield-halved" style="color: var(--success-green); font-size: 0.8rem;"></i>
                    <span style="font-size: 0.7rem; font-weight: 700; color: var(--success-green); text-transform: uppercase;">Trust Score: 85%</span>
                </div>
            </div>
            <div style="display: flex; align-items: center; gap: 1.5rem;">
                <div style="background: linear-gradient(90deg, var(--accent-dark), var(--accent)); color: var(--primary-dark); padding: 0.3rem 0.8rem; border-radius: 6px; font-size: 0.7rem; font-weight: 800; display: flex; align-items: center; gap: 0.4rem;">
                    <i class="fa-solid fa-award"></i> BRONZE TIER
                </div>
                <div style="display: flex; align-items: center; gap: 1rem; padding-left: 1.5rem; border-left: 1px solid var(--border);">
                    <div style="text-align: right;">
                        <p style="font-weight: 700; margin: 0; font-size: 0.85rem; color: var(--text-dark);"><?= $fullName ?></p>
                        <p style="font-size: 0.7rem; color: var(--text-muted); margin: 0;"><?= $indexNum ?></p>
                    </div>
                    <div style="width: 40px; height: 40px; background: var(--primary); border-radius: 10px; display: flex; align-items: center; justify-content: center; color: var(--white); font-weight: 800; font-size: 0.9rem;"><?= $initials ?></div>
                </div>
            </div>
        </div>

        <main style="padding: 2rem 2.5rem;">
            <div style="background: linear-gradient(135deg, var(--primary), var(--primary-dark)); border-radius: var(--radius-md); padding: 2rem 2.5rem; display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; color: var(--white);">
                <div style="flex: 1;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.8rem;">
                        <h4 style="margin: 0; color: var(--white); font-size: 1rem;">Next Reward: <span style="color: var(--accent);">Silver Scholarship Tier</span></h4>
                        <span style="font-size: 0.75rem; font-weight: 700; color: var(--accent);">XP: 1,200 / 2,000</span>
                    </div>
                    <div style="width: 100%; height: 10px; background: rgba(255,255,255,0.1); border-radius: 10px; overflow: hidden;">
                        <div style="width: 60%; height: 100%; background: var(--accent); border-radius: 10px;"></div>
                    </div>
                    <p style="font-size: 0.75rem; color: rgba(255,255,255,0.5); margin-top: 0.8rem;">Upload <u style="color:var(--accent);cursor:pointer;">KCSE Certificate</u> and <u style="color:var(--accent);cursor:pointer;">ID Copy</u> to unlock 20% more funding eligibility!</p>
                </div>
                <div style="padding-left: 3rem; text-align: center;">
                    <div style="width: 70px; height: 70px; border: 3px solid rgba(255,255,255,0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: rgba(255,255,255,0.4); font-size: 1.3rem;">
                        <i class="fa-solid fa-lock"></i>
                    </div>
                    <p style="font-size: 0.6rem; font-weight: 700; color: rgba(255,255,255,0.3); margin-top: 0.4rem; text-transform: uppercase;">Silver Locked</p>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 2rem;">
                <div style="background: var(--white); border: 1px solid var(--border); border-radius: var(--radius-md); padding: 2rem; box-shadow: var(--shadow-sm);">
                    <h3 style="margin-bottom: 1.5rem; font-size: 1.1rem;">Recent Notifications</h3>
                    <div style="border-left: 2px solid var(--border); padding-left: 1.5rem; margin-left: 0.8rem;">
                        <div style="position: relative; margin-bottom: 2rem;">
                            <div style="position: absolute; left: -1.85rem; top: 0; width: 10px; height: 10px; background: var(--accent); border-radius: 50%; box-shadow: 0 0 0 4px rgba(16,185,129,0.15);"></div>
                            <h4 style="margin: 0; font-size: 0.95rem;">Application for Jan-Apr 2024 Session Successfully Received</h4>
                            <p style="font-size: 0.8rem; color: var(--text-muted); margin: 0.2rem 0;">March 15, 2024 at 10:45 AM</p>
                            <p style="font-size: 0.85rem; color: var(--text-dark); margin-top: 0.5rem;">Your application (ID: NIBS-2024-B83) has been logged and is awaiting document verification.</p>
                        </div>
                        <div style="position: relative;">
                            <div style="position: absolute; left: -1.85rem; top: 0; width: 10px; height: 10px; background: var(--text-light); border-radius: 50%;"></div>
                            <h4 style="margin: 0; font-size: 0.95rem; color: var(--text-muted);">Bursary Portal Account Created</h4>
                            <p style="font-size: 0.8rem; color: var(--text-muted); margin: 0.2rem 0;">March 10, 2024 at 02:20 PM</p>
                        </div>
                    </div>
                </div>

                <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                    <div style="background: linear-gradient(135deg, var(--primary), var(--primary-light)); border-radius: var(--radius-md); padding: 1.5rem; color: var(--white); position: relative; overflow: hidden;">
                        <div style="position: absolute; right: -10px; bottom: -10px; font-size: 6rem; opacity: 0.06;"><i class="fa-solid fa-graduation-cap"></i></div>
                        <h4 style="color: var(--white); margin-bottom: 0.8rem; font-size: 1rem;">Bursary Tip</h4>
                        <p style="font-size: 0.85rem; opacity: 0.8; line-height: 1.6; margin-bottom: 1.2rem;">Applying for "Technical Courses" bursaries has a 15% higher success rate this semester.</p>
                        <button style="background: var(--accent); color: var(--primary-dark); border-radius: var(--radius-sm); border: none; padding: 0.8rem; width: 100%; font-weight: 700; cursor: pointer; transition: var(--transition);">View Course Eligibility</button>
                    </div>
                    
                    <div style="background: var(--white); border: 1px solid var(--border); border-radius: var(--radius-md); padding: 1.5rem;">
                        <h4 style="margin-bottom: 1rem; font-size: 1rem;">Advisory</h4>
                        <div style="padding: 0.8rem 1rem; background: #fff0f0; border-radius: var(--radius-sm); border-left: 3px solid var(--accent);">
                            <p style="font-size: 0.85rem; color: var(--text-dark); line-height: 1.5;"><strong>Notice:</strong> All applications must be submitted by the 25th of this month to be considered for this allocation cycle.</p>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script src="js/app.js"></script>
</body>
</html>
