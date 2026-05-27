<?php 
    header('Location: /admin/announcements', true, 301);
    exit;
    $pageTitle = "Contact Inquiries - NIBS Admin";
    
    $inquiries = [];
    $db_connected = false;
    $db_error = '';
    try {
        $dbConfig = require __DIR__ . '/config/database.php';
        $dsn = "mysql:host={$dbConfig['host']};dbname={$dbConfig['dbname']};charset={$dbConfig['charset']}";
        $conn = new PDO($dsn, $dbConfig['username'], $dbConfig['password'], $dbConfig['options']);
        $db_connected = true;
        
        $sql = "SELECT * FROM contact_messages ORDER BY created_at DESC";
        $stmt = $conn->query($sql);
        $inquiries = $stmt->fetchAll();
    } catch (\Exception $e) {
        $db_error = $e->getMessage();
    }
?>
<!DOCTYPE html>
<html lang="en">
<?php include 'includes/head.php'; ?>
<body style="background: var(--bg-light); display: flex;">
    
    <?php include 'includes/sidebar.php'; ?>

    <div style="flex: 1; min-width: 0;">
        <!-- Top bar -->
        <div style="background: white; padding: 1.2rem 3rem; display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid var(--border-color); position: sticky; top: 0; z-index: 100;">
            <h2 style="margin: 0; font-size: 1.4rem; color: var(--text-dark);"><i class="fa-solid fa-headset" style="color: var(--primary-red); margin-right: 0.5rem;"></i> Contact Inquiries</h2>
            <div style="display: flex; gap: 1rem;">
                <button class="btn-secondary" style="width: auto; padding: 0.6rem 1.2rem; margin: 0; font-size: 0.8rem;"><i class="fa-solid fa-file-export"></i> Export CSV</button>
            </div>
        </div>

        <main style="padding: 3rem;">
            <?php if (!$db_connected): ?>
                <div style="background: #fff5f5; border-left: 4px solid var(--primary-red); padding: 1.5rem; margin-bottom: 2.5rem; border-radius: 8px; box-shadow: var(--shadow-sm);">
                    <h4 style="color: var(--primary-red); margin-bottom: 0.5rem;"><i class="fa-solid fa-triangle-exclamation"></i> Database Offline</h4>
                    <p style="color: #c53030; font-size: 0.9rem; margin: 0;"><?php echo htmlspecialchars($db_error, ENT_QUOTES, 'UTF-8'); ?></p>
                </div>
            <?php endif; ?>

            <div class="glass-panel" style="background: white; border: none; padding: 0; overflow: hidden; box-shadow: var(--shadow-sm);">
                <div style="padding: 1.5rem 2.5rem; border-bottom: 1px solid var(--border-color); background: #fafafa; display: flex; justify-content: space-between; align-items: center;">
                    <h3 style="margin: 0; font-size: 1.1rem;">Customer Support Queue</h3>
                    <span style="background: var(--primary-red); color: white; font-size: 0.7rem; font-weight: 800; padding: 0.3rem 0.8rem; border-radius: 20px;">
                        <?php echo count(array_filter($inquiries, function($i) { return $i['status'] == 'new'; })); ?> UNREAD
                    </span>
                </div>

                <div style="overflow-x: auto;">
                    <table style="width: 100%; border-collapse: collapse;">
                        <thead style="background: #f8fafc;">
                            <tr>
                                <th style="padding: 1.2rem 2.5rem; text-align: left; font-size: 0.75rem; color: var(--text-muted); text-transform: uppercase; letter-spacing: 1px;">Sender / Subject</th>
                                <th style="padding: 1.2rem; text-align: left; font-size: 0.75rem; color: var(--text-muted); text-transform: uppercase; letter-spacing: 1px;">Status</th>
                                <th style="padding: 1.2rem; text-align: left; font-size: 0.75rem; color: var(--text-muted); text-transform: uppercase; letter-spacing: 1px;">Date</th>
                                <th style="padding: 1.2rem 2.5rem; text-align: right; font-size: 0.75rem; color: var(--text-muted); text-transform: uppercase; letter-spacing: 1px;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($inquiries as $item): ?>
                                <tr style="border-bottom: 1px solid var(--border-color); transition: background 0.3s;" onmouseover="this.style.background='#fcfcfc'" onmouseout="this.style.background='white'">
                                    <td style="padding: 1.5rem 2.5rem;">
                                        <p style="margin: 0; font-weight: 800; color: var(--text-dark);"><?php echo htmlspecialchars($item['name']); ?></p>
                                        <p style="margin: 0.3rem 0 0 0; font-size: 0.85rem; color: var(--primary-blue);"><?php echo htmlspecialchars($item['subject']); ?></p>
                                        <p style="margin: 0.5rem 0 0 0; font-size: 0.8rem; color: var(--text-muted); opacity: 0.7;"><?php echo htmlspecialchars($item['email']); ?></p>
                                    </td>
                                    <td style="padding: 1.2rem;">
                                        <span style="font-size: 0.65rem; font-weight: 800; padding: 0.3rem 0.8rem; border-radius: 6px; background: <?php echo $item['status'] == 'new' ? '#fff5f5' : '#f0fff4'; ?>; color: <?php echo $item['status'] == 'new' ? '#c53030' : '#2f855a'; ?>;">
                                            <?php echo strtoupper($item['status']); ?>
                                        </span>
                                    </td>
                                    <td style="padding: 1.2rem; font-size: 0.85rem; color: var(--text-muted);">
                                        <?php echo date('M d, Y', strtotime($item['created_at'])); ?>
                                    </td>
                                    <td style="padding: 1.2rem 2.5rem; text-align: right;">
                                        <button class="btn-secondary" style="width: auto; padding: 0.5rem 1.2rem; font-size: 0.75rem;">View Inquiry</button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>

    <script src="js/app.js"></script>
</body>
</html>
