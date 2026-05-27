<?php 
    $pageTitle = "Messages - NIBS Bursary Portal";
    if (session_status() === PHP_SESSION_NONE) session_start();
    if (!isset($_SESSION['user_id'])) { header('Location: login.php', true, 302); exit; }
    $user_id = $_SESSION['user_id'];
?>
<!DOCTYPE html>
<html lang="en">
<?php include 'includes/head.php'; ?>
<body style="background: var(--off-white); display: flex;">
    
    <?php include 'includes/sidebar.php'; ?>

    <div style="flex: 1; min-width: 0;">
        <!-- Top bar -->
        <div style="background: var(--white); padding: 1.2rem 3rem; display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid var(--border); position: sticky; top: 0; z-index: 100;">
            <h2 style="margin: 0; font-size: 1.4rem; color: var(--primary);"><i class="fa-solid fa-envelope" style="color: var(--accent); margin-right: 0.5rem;"></i> Message Center</h2>
            <div style="display: flex; gap: 1rem;">
                <button class="btn-secondary" style="width: auto; padding: 0.6rem 1.2rem; margin: 0; font-size: 0.8rem; border-radius: var(--radius-sm); border: 1px solid var(--border); color: var(--text-muted); background: var(--white);"><i class="fa-solid fa-check-double"></i> Mark All as Read</button>
            </div>
        </div>

        <main style="padding: 3rem; max-width: 1000px;">
            <?php if (!$db_connected): ?>
                <div style="background: #fff5f5; border-left: 4px solid #e53e3e; padding: 1.5rem; margin-bottom: 2.5rem; border-radius: var(--radius-sm);">
                    <h4 style="color: #c53030; margin-bottom: 0.5rem;"><i class="fa-solid fa-triangle-exclamation"></i> Inbox Offline</h4>
                    <p style="color: #c53030; font-size: 0.9rem; margin: 0;"><?php echo htmlspecialchars($db_error, ENT_QUOTES, 'UTF-8'); ?></p>
                </div>
            <?php endif; ?>

            <div style="background: var(--white); border-radius: var(--radius-md); box-shadow: var(--shadow-sm); padding: 0; overflow: hidden;">
                <div style="padding: 1.5rem 2.5rem; border-bottom: 1px solid var(--border); background: var(--off-white);">
                    <h3 style="margin: 0; font-size: 1.1rem; color: var(--primary);">Inbox</h3>
                </div>

                <div style="display: flex; flex-direction: column;">
                    <?php if (empty($notifications)): ?>
                        <div style="padding: 5rem; text-align: center; color: var(--text-muted);">
                            <i class="fa-solid fa-inbox" style="font-size: 3rem; opacity: 0.2; margin-bottom: 1rem; display: block; color: var(--accent);"></i>
                            <p>No messages yet. System alerts will appear here.</p>
                        </div>
                    <?php else: ?>
                        <?php foreach ($notifications as $msg): ?>
                            <div style="padding: 2rem 2.5rem; border-bottom: 1px solid var(--border); display: flex; gap: 1.5rem; transition: background 0.3s;" onmouseover="this.style.background='var(--off-white)'" onmouseout="this.style.background='var(--white)'">
                                <div style="width: 4px; border-radius: 2px; background: <?php echo $msg['status'] == 'unread' ? 'var(--primary)' : 'var(--border)'; ?>; flex-shrink: 0;"></div>
                                <div style="flex: 1;">
                                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem;">
                                        <h4 style="margin: 0; font-size: 1rem; font-weight: <?php echo $msg['status'] == 'unread' ? '800' : '600'; ?>; color: var(--primary);"><?php echo $msg['status'] == 'unread' ? 'New Announcement' : 'System Update'; ?></h4>
                                        <span style="font-size: 0.75rem; color: var(--text-muted);"><?php echo date('M d, Y • h:i A', strtotime($msg['created_at'])); ?></span>
                                    </div>
                                    <p style="margin: 0; font-size: 0.95rem; color: var(--text-dark); line-height: 1.6;"><?php echo htmlspecialchars($msg['message']); ?></p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Compose Shortcut -->
            <div style="margin-top: 3rem; text-align: center; padding: 3rem; background: var(--primary); border-radius: var(--radius-md); box-shadow: var(--shadow-md);">
                <h4 style="color: var(--accent); margin-bottom: 1rem; font-size: 1.2rem;">Have a Question?</h4>
                <p style="color: rgba(255,255,255,0.8); font-size: 0.9rem; margin-bottom: 1.5rem;">Our support team is ready to assist you with any inquiries regarding your application.</p>
                <a href="contact-us.php"><button style="width: auto; padding: 1rem 3rem; border: none; border-radius: var(--radius-sm); background: var(--accent); color: var(--primary-dark); font-weight: 700; font-size: 0.95rem; cursor: pointer; transition: background 0.3s;" onmouseover="this.style.background='var(--accent-light)'" onmouseout="this.style.background='var(--accent)'">Contact Support</button></a>
            </div>
        </main>
    </div>

    <script src="js/app.js"></script>
</body>
</html>
