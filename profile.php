<?php 
    $pageTitle = "My Profile - NIBS Bursary";
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
            <h2 style="margin: 0; font-size: 1.4rem; color: var(--primary);">My Student Profile</h2>
            <button style="width: auto; background: var(--accent); color: var(--primary-dark); padding: 0.8rem 2rem; font-size: 0.9rem; border-radius: var(--radius-sm); border: none; cursor: pointer; font-weight: 700;">Save Changes</button>
        </div>

        <main style="padding: 3rem;">
            <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 3rem; align-items: start;">
                
                <!-- Profile Side -->
                <div style="display: flex; flex-direction: column; gap: 2rem;">
                    <div style="background: var(--white); border: none; padding: 3rem; text-align: center; border-radius: var(--radius-md); box-shadow: var(--shadow-md);">
                        <div style="position: relative; width: 150px; height: 150px; margin: 0 auto 2rem;">
                            <div style="width: 100%; height: 100%; background: var(--accent); color: var(--primary-dark); border-radius: 40px; display: flex; align-items: center; justify-content: center; font-size: 4rem; font-weight: 800; border: 4px solid var(--white); box-shadow: 0 10px 30px rgba(0,0,0,0.05);">JD</div>
                            <div style="position: absolute; bottom: 0; right: 0; width: 45px; height: 45px; background: var(--primary); color: var(--white); border-radius: 15px; display: flex; align-items: center; justify-content: center; cursor: pointer; border: 4px solid var(--white);"><i class="fa-solid fa-camera"></i></div>
                        </div>
                        <h3 style="margin: 0; font-size: 1.5rem; color: var(--primary);">John Doe</h3>
                        <p style="color: var(--text-muted); font-size: 0.9rem; margin-top: 0.5rem;">Diploma in Information Technology</p>
                        <hr style="margin: 2rem 0; border: none; border-top: 1px solid var(--border);">
                        <div style="display: flex; justify-content: space-around;">
                            <div style="text-align: center;"><p style="font-weight: 800; margin: 0; color: var(--accent);">2024</p><p style="font-size: 0.7rem; color: var(--text-muted); text-transform: uppercase;">Joined</p></div>
                            <div style="text-align: center;"><p style="font-weight: 800; margin: 0; color: var(--accent);">Year 1</p><p style="font-size: 0.7rem; color: var(--text-muted); text-transform: uppercase;">Current</p></div>
                            <div style="text-align: center;"><p style="font-weight: 800; margin: 0; color: var(--accent);">3.8</p><p style="font-size: 0.7rem; color: var(--text-muted); text-transform: uppercase;">GPA</p></div>
                        </div>
                    </div>

                    <div style="background: var(--white); border: none; padding: 2rem; border-radius: var(--radius-md); box-shadow: var(--shadow-md);">
                        <h4 style="margin-bottom: 1.5rem; color: var(--primary);">Account Security</h4>
                        <button style="width: 100%; text-align: left; padding: 1rem; font-size: 0.9rem; margin: 0 0 1rem; border-radius: var(--radius-sm); border: 1px solid var(--border); background: var(--white); color: var(--text-dark); cursor: pointer; display: flex; justify-content: space-between; align-items: center;">Change Password <i class="fa-solid fa-chevron-right" style="color: var(--text-light);"></i></button>
                        <button style="width: 100%; text-align: left; padding: 1rem; font-size: 0.9rem; margin: 0; border-radius: var(--radius-sm); border: 1px solid var(--border); background: var(--white); color: var(--text-dark); cursor: pointer; display: flex; justify-content: space-between; align-items: center;">Two-Factor Auth <span style="font-size: 0.7rem; background: #fef3c7; color: #92400e; padding: 0.2rem 0.6rem; border-radius: 4px;">Disabled</span></button>
                    </div>
                </div>

                <!-- Fields Side -->
                <div style="background: var(--white); border: none; padding: 4rem; border-radius: var(--radius-md); box-shadow: var(--shadow-md);">
                    <h3 style="margin-bottom: 3rem; color: var(--primary);">Personal Details</h3>
                    <form style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem;">
                        <div class="form-group"><label>Full Legal Name</label><input type="text" value="John Doe" readonly style="background: var(--off-white); border: 1px solid var(--border); border-radius: var(--radius-sm); padding: 0.8rem 1rem; font-size: 0.9rem; width: 100%; box-sizing: border-box;"></div>
                        <div class="form-group"><label>Email Address</label><input type="email" value="john.doe@nibs.ac.ke" style="border: 1px solid var(--border); border-radius: var(--radius-sm); padding: 0.8rem 1rem; font-size: 0.9rem; width: 100%; box-sizing: border-box;"></div>
                        <div class="form-group"><label>Phone Number</label><input type="tel" value="+254 712 345 678" style="border: 1px solid var(--border); border-radius: var(--radius-sm); padding: 0.8rem 1rem; font-size: 0.9rem; width: 100%; box-sizing: border-box;"></div>
                        <div class="form-group"><label>Admission Number</label><input type="text" value="NIBS/2024/0001" readonly style="background: var(--off-white); border: 1px solid var(--border); border-radius: var(--radius-sm); padding: 0.8rem 1rem; font-size: 0.9rem; width: 100%; box-sizing: border-box;"></div>
                        <div class="form-group"><label>Course Title</label><input type="text" value="Diploma in Information Technology" readonly style="background: var(--off-white); border: 1px solid var(--border); border-radius: var(--radius-sm); padding: 0.8rem 1rem; font-size: 0.9rem; width: 100%; box-sizing: border-box;"></div>
                        <div class="form-group"><label>Campus Location</label><select style="border: 1px solid var(--border); border-radius: var(--radius-sm); padding: 0.8rem 1rem; font-size: 0.9rem; width: 100%; box-sizing: border-box; background: var(--white);"><option>Ruiru (Main)</option><option>Thika</option><option>Nairobi</option></select></div>
                        <div class="form-group" style="grid-column: span 2;"><label>Student Bio</label><textarea rows="4" style="border: 1px solid var(--border); border-radius: var(--radius-sm); padding: 0.8rem 1rem; font-size: 0.9rem; width: 100%; box-sizing: border-box; font-family: inherit;">A dedicated second-year IT student with a passion for software development and cybersecurity. Actively involved in the NIBS coding club.</textarea></div>
                    </form>

                    <h3 style="margin: 4rem 0 3rem; color: var(--primary);">Emergency Contact</h3>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem;">
                        <div class="form-group"><label>Contact Name</label><input type="text" value="Mary Doe" style="border: 1px solid var(--border); border-radius: var(--radius-sm); padding: 0.8rem 1rem; font-size: 0.9rem; width: 100%; box-sizing: border-box;"></div>
                        <div class="form-group"><label>Relationship</label><input type="text" value="Mother" style="border: 1px solid var(--border); border-radius: var(--radius-sm); padding: 0.8rem 1rem; font-size: 0.9rem; width: 100%; box-sizing: border-box;"></div>
                        <div class="form-group" style="grid-column: span 2;"><label>Contact Phone</label><input type="tel" value="+254 700 111 222" style="border: 1px solid var(--border); border-radius: var(--radius-sm); padding: 0.8rem 1rem; font-size: 0.9rem; width: 100%; box-sizing: border-box;"></div>
                    </div>
                </div>

            </div>
        </main>
    </div>

    <script src="js/app.js"></script>
</body>
</html>
