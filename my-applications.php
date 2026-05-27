<?php 
    $pageTitle = "My Applications - NIBS Bursary";
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
            <h2 style="margin: 0; font-size: 1.4rem; color: var(--primary);">My Applications</h2>
            <div style="display: flex; gap: 1rem;">
                <a href="apply.php" style="text-decoration: none;"><button style="width: auto; background: var(--accent); color: var(--primary-dark); padding: 0.8rem 2rem; font-size: 0.9rem; border-radius: var(--radius-sm); border: none; cursor: pointer; font-weight: 700;">New Application</button></a>
            </div>
        </div>

        <main style="padding: 3rem;">
            <div style="background: var(--white); border: none; padding: 0; overflow: hidden; box-shadow: var(--shadow-md); border-radius: var(--radius-md);">
                <div style="padding: 2rem 3rem; border-bottom: 1px solid var(--border); display: flex; justify-content: space-between; align-items: center;">
                    <h3 style="margin: 0; color: var(--primary);">Application History</h3>
                    <div style="display: flex; gap: 1rem;">
                        <input type="text" placeholder="Search ID..." style="width: 250px; padding: 0.6rem 1.2rem; border-radius: var(--radius-sm); font-size: 0.85rem; border: 1px solid var(--border); outline: none;">
                        <button style="width: auto; padding: 0.6rem 1.5rem; font-size: 0.85rem; border-radius: var(--radius-sm); background: var(--primary); color: var(--white); border: none; cursor: pointer;">Filter</button>
                    </div>
                </div>

                <div style="overflow-x: auto;">
                    <table style="width: 100%; min-width: 800px; border-collapse: collapse;">
                        <thead>
                            <tr>
                                <th style="padding: 1rem 1.5rem; text-align: left; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.05em; color: var(--text-muted); border-bottom: 1px solid var(--border);">Application ID</th>
                                <th style="padding: 1rem 1.5rem; text-align: left; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.05em; color: var(--text-muted); border-bottom: 1px solid var(--border);">Academic Period</th>
                                <th style="padding: 1rem 1.5rem; text-align: left; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.05em; color: var(--text-muted); border-bottom: 1px solid var(--border);">Submission Date</th>
                                <th style="padding: 1rem 1.5rem; text-align: left; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.05em; color: var(--text-muted); border-bottom: 1px solid var(--border);">AI Score</th>
                                <th style="padding: 1rem 1.5rem; text-align: left; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.05em; color: var(--text-muted); border-bottom: 1px solid var(--border);">Status</th>
                                <th style="padding: 1rem 1.5rem; text-align: right; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.05em; color: var(--text-muted); border-bottom: 1px solid var(--border);">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="padding: 1.2rem 1.5rem; font-weight: 700; color: var(--primary); border-bottom: 1px solid var(--border);">NIBS-2024-B83</td>
                                <td style="padding: 1.2rem 1.5rem; color: var(--text-dark); border-bottom: 1px solid var(--border);">Jan - Apr 2024</td>
                                <td style="padding: 1.2rem 1.5rem; color: var(--text-dark); border-bottom: 1px solid var(--border);">March 15, 2024</td>
                                <td style="padding: 1.2rem 1.5rem; border-bottom: 1px solid var(--border);"><div style="display: flex; align-items: center; gap: 0.5rem;"><div style="width: 40px; height: 6px; background: var(--border); border-radius: 10px;"><div style="width: 82%; height: 100%; background: var(--success-green); border-radius: 10px;"></div></div> <span style="color: var(--text-dark); font-weight: 600;">82%</span></div></td>
                                <td style="padding: 1.2rem 1.5rem; border-bottom: 1px solid var(--border);"><span style="display: inline-block; padding: 0.25rem 0.8rem; font-size: 0.75rem; font-weight: 600; border-radius: 20px; background: #fef3c7; color: #92400e;">Verification</span></td>
                                <td style="padding: 1.2rem 1.5rem; text-align: right; border-bottom: 1px solid var(--border);"><button style="width: auto; padding: 0.4rem 1rem; font-size: 0.75rem; border-radius: var(--radius-sm); border: 1px solid var(--border); background: var(--white); color: var(--primary); cursor: pointer;">View Details</button></td>
                            </tr>
                            <tr style="opacity: 0.6;">
                                <td style="padding: 1.2rem 1.5rem; font-weight: 700; color: var(--text-dark); border-bottom: 1px solid var(--border);">NIBS-2023-A42</td>
                                <td style="padding: 1.2rem 1.5rem; color: var(--text-dark); border-bottom: 1px solid var(--border);">Sep - Dec 2023</td>
                                <td style="padding: 1.2rem 1.5rem; color: var(--text-dark); border-bottom: 1px solid var(--border);">August 28, 2023</td>
                                <td style="padding: 1.2rem 1.5rem; border-bottom: 1px solid var(--border);"><div style="display: flex; align-items: center; gap: 0.5rem;"><div style="width: 40px; height: 6px; background: var(--border); border-radius: 10px;"><div style="width: 64%; height: 100%; background: var(--accent); border-radius: 10px;"></div></div> <span style="color: var(--text-dark); font-weight: 600;">64%</span></div></td>
                                <td style="padding: 1.2rem 1.5rem; border-bottom: 1px solid var(--border);"><span style="display: inline-block; padding: 0.25rem 0.8rem; font-size: 0.75rem; font-weight: 600; border-radius: 20px; background: #e2e8f0; color: #4a5568;">Disbursed</span></td>
                                <td style="padding: 1.2rem 1.5rem; text-align: right; border-bottom: 1px solid var(--border);"><button style="width: auto; padding: 0.4rem 1rem; font-size: 0.75rem; border-radius: var(--radius-sm); border: 1px solid var(--border); background: var(--white); color: var(--primary); cursor: pointer;">Download Receipt</button></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                
                <div style="padding: 1.5rem 3rem; background: var(--off-white); border-top: 1px solid var(--border); display: flex; justify-content: space-between; align-items: center;">
                    <p style="font-size: 0.85rem; color: var(--text-muted); margin: 0;">Showing 1-2 of 2 applications</p>
                    <div style="display: flex; gap: 0.5rem;">
                        <button style="width: auto; padding: 0.4rem 0.8rem; font-size: 0.7rem; border-radius: var(--radius-sm); border: 1px solid var(--border); background: var(--white); color: var(--text-muted); cursor: pointer;">Previous</button>
                        <button style="width: auto; padding: 0.4rem 0.8rem; font-size: 0.7rem; border-radius: var(--radius-sm); border: 1px solid var(--border); background: var(--white); color: var(--text-muted); cursor: pointer;">Next</button>
                    </div>
                </div>
            </div>

            <div style="margin-top: 3rem; display: grid; grid-template-columns: 1fr 1fr; gap: 2rem;">
                <div style="background: #fff6e0; border: 1px solid var(--accent-light); padding: 2rem; display: flex; gap: 1.5rem; align-items: center; border-radius: var(--radius-md);">
                    <div style="font-size: 2rem; color: var(--accent);"><i class="fa-solid fa-circle-info"></i></div>
                    <div>
                        <h4 style="margin: 0; color: var(--primary);">Understanding the AI Score</h4>
                        <p style="font-size: 0.85rem; color: var(--text-muted); margin-top: 0.3rem;">The score represents your eligibility based on financial need, academic consistency, and social factors. High scores prioritize your review.</p>
                    </div>
                </div>
                <div style="background: #e8edf5; border: 1px solid var(--primary); padding: 2rem; display: flex; gap: 1.5rem; align-items: center; border-radius: var(--radius-md);">
                    <div style="font-size: 2rem; color: var(--primary);"><i class="fa-solid fa-shield-halved"></i></div>
                    <div>
                        <h4 style="margin: 0; color: var(--primary);">Blockchain Verified</h4>
                        <p style="font-size: 0.85rem; color: var(--text-muted); margin-top: 0.3rem;">Every status change is secured with an immutable hash, ensuring complete transparency and preventing unauthorized tampering.</p>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script src="js/app.js"></script>
</body>
</html>
