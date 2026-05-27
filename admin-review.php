<?php 
    header('Location: /admin/review', true, 301);
    exit;
    $pageTitle = "Review Application - NIBS Admin";
?>
<!DOCTYPE html>
<html lang="en">
<?php include 'includes/head.php'; ?>
<body style="background: #f8fafc; display: flex;">
    
    <?php 
        if (!isset($_SESSION['role'])) $_SESSION['role'] = 'admin'; 
        include 'includes/sidebar.php'; 
    ?>

    <div style="flex: 1; min-width: 0; display: flex; flex-direction: column; height: 100vh; overflow: hidden;">
    
    <!-- Top bar -->
    <div style="background: white; padding: 1rem 3rem; display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #edf2f7; z-index: 100;">
        <div style="display: flex; align-items: center; gap: 1.5rem;">
            <a href="admin-dashboard.php" style="color: var(--text-dark);"><i class="fa-solid fa-arrow-left"></i></a>
            <h2 style="margin: 0; font-size: 1.2rem; color: var(--text-dark);">Review Application: <span style="color: var(--primary-blue);">NIBS-2024-B83</span></h2>
        </div>
        <div style="display: flex; align-items: center; gap: 1rem;">
            <span class="badge badge-pending">Under Review</span>
            <div style="width: 40px; height: 40px; background: #edf2f7; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 0.8rem;">JD</div>
        </div>
    </div>

    <!-- Split Screen Content -->
    <div style="flex: 1; display: flex; overflow: hidden;">
        
        <!-- Left: Student Data (Scrollable) -->
        <div style="flex: 1; overflow-y: auto; padding: 3rem; border-right: 1px solid #edf2f7; background: white;">
            
            <section style="margin-bottom: 4rem;">
                <h3 style="font-size: 1.5rem; margin-bottom: 2rem; border-bottom: 2px solid var(--neutral-gray); padding-bottom: 1rem;">Student Information</h3>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem;">
                    <div><p style="font-size: 0.75rem; color: var(--text-muted); text-transform: uppercase; font-weight: 700; margin-bottom: 0.3rem;">Full Name</p><p style="font-weight: 600;">John Doe</p></div>
                    <div><p style="font-size: 0.75rem; color: var(--text-muted); text-transform: uppercase; font-weight: 700; margin-bottom: 0.3rem;">Reg Number</p><p style="font-weight: 600;">NIBS/2024/0001</p></div>
                    <div><p style="font-size: 0.75rem; color: var(--text-muted); text-transform: uppercase; font-weight: 700; margin-bottom: 0.3rem;">Course</p><p style="font-weight: 600;">Diploma in ICT</p></div>
                    <div><p style="font-size: 0.75rem; color: var(--text-muted); text-transform: uppercase; font-weight: 700; margin-bottom: 0.3rem;">GPA</p><p style="font-weight: 600;">3.85 / 4.0</p></div>
                </div>
            </section>

            <section style="margin-bottom: 4rem;">
                <h3 style="font-size: 1.5rem; margin-bottom: 2rem; border-bottom: 2px solid var(--neutral-gray); padding-bottom: 1rem;">Financial Background</h3>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; margin-bottom: 2rem;">
                    <div><p style="font-size: 0.75rem; color: var(--text-muted); text-transform: uppercase; font-weight: 700; margin-bottom: 0.3rem;">Parent Income</p><p style="font-weight: 600;">KES 24,500 / month</p></div>
                    <div><p style="font-size: 0.75rem; color: var(--text-muted); text-transform: uppercase; font-weight: 700; margin-bottom: 0.3rem;">Fee Balance</p><p style="font-weight: 600; color: var(--primary-red);">KES 48,200</p></div>
                </div>
                <p style="font-size: 0.75rem; color: var(--text-muted); text-transform: uppercase; font-weight: 700; margin-bottom: 0.3rem;">Hardship Statement</p>
                <p style="font-size: 0.95rem; line-height: 1.8; color: #4a5568; background: #f8fafc; padding: 1.5rem; border-radius: 12px;">"My father is the sole breadwinner for our family of six. Due to the recent economic downturn, his small business has struggle, making it difficult to cover my full tuition. I am dedicated to completing my ICT diploma and this bursary would be life-changing."</p>
            </section>

            <section>
                <h3 style="font-size: 1.5rem; margin-bottom: 2rem; border-bottom: 2px solid var(--neutral-gray); padding-bottom: 1rem;">Social Factors</h3>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem;">
                    <div><p style="font-size: 0.75rem; color: var(--text-muted); text-transform: uppercase; font-weight: 700; margin-bottom: 0.3rem;">Orphan Status</p><p style="font-weight: 600;">No</p></div>
                    <div><p style="font-size: 0.75rem; color: var(--text-muted); text-transform: uppercase; font-weight: 700; margin-bottom: 0.3rem;">Disability</p><p style="font-weight: 600;">No</p></div>
                </div>
            </section>
        </div>

        <!-- Right: Documents & AI (Scrollable) -->
        <div style="flex: 0.8; overflow-y: auto; padding: 3rem; background: #f8fafc;">
            
            <div class="glass-panel" style="background: var(--primary-blue); border: none; color: white; padding: 2.5rem; margin-bottom: 3rem;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                    <h3 style="color: white; margin: 0;">AI Eligibility Score</h3>
                    <div style="font-size: 2.5rem; font-weight: 800; color: white;">82%</div>
                </div>
                <div style="width: 100%; height: 8px; background: rgba(255,255,255,0.1); border-radius: 10px; overflow: hidden; margin-bottom: 1.5rem;">
                    <div style="width: 82%; height: 100%; background: white; border-radius: 10px;"></div>
                </div>
                <p style="font-size: 0.85rem; opacity: 0.8; line-height: 1.6;">AI Recommendation: <strong>HIGH PRIORITY</strong>. Financial need is high, and academic performance is consistent with college standards.</p>
            </div>

            <h3 style="margin-bottom: 2rem;">Uploaded Documents</h3>
            <div style="display: flex; flex-direction: column; gap: 1rem;">
                <DocItem title="National ID Copy" status="Verified" />
                <DocItem title="Latest Fee Statement" status="Pending Review" />
                <DocItem title="KCSE Certificate" status="Verified" />
                <DocItem title="Police Clearance" status="Missing" />
            </div>

            <div style="margin-top: 4rem;">
                <h3 style="margin-bottom: 1.5rem;">Reviewer Notes</h3>
                <textarea rows="4" style="width: 100%; border-radius: 12px; border: 1px solid #edf2f7; padding: 1rem;" placeholder="Add private notes for the committee..."></textarea>
            </div>

        </div>
    </div>

    <!-- Bottom Actions -->
    <div style="background: white; padding: 1.5rem 3rem; border-top: 1px solid #edf2f7; display: flex; justify-content: flex-end; gap: 1.5rem;">
        <button class="btn-secondary" style="width: auto; padding: 1rem 2.5rem; margin: 0;">Request Documents</button>
        <button style="width: auto; padding: 1rem 2.5rem; background: var(--primary-red); color: white; margin: 0;">Reject Application</button>
        <button style="width: auto; padding: 1rem 2.5rem; background: #38a169; color: white; margin: 0;">Approve (KES 45,000)</button>
    </div>

    <?php 
        function DocItem($props) {
            $color = "#718096";
            if($props['status'] == "Verified") $color = "#38a169";
            if($props['status'] == "Missing") $color = "#e53e3e";
            
            echo '<div style="background: white; padding: 1.2rem; border-radius: 12px; display: flex; justify-content: space-between; align-items: center; border: 1px solid #edf2f7;">
                    <div style="display: flex; align-items: center; gap: 1rem;">
                        <i class="fa-solid fa-file-pdf" style="color: var(--primary-blue); font-size: 1.2rem;"></i>
                        <span style="font-weight: 600; font-size: 0.9rem;">' . $props['title'] . '</span>
                    </div>
                    <span style="font-size: 0.75rem; font-weight: 700; color: ' . $color . '; text-transform: uppercase;">' . $props['status'] . '</span>
                  </div>';
        }
    ?>
    <script src="js/app.js"></script>
</body>
</html>
