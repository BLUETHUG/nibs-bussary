<?php 
    $pageTitle = "Login - NIBS Bursary Portal";
    if (session_status() === PHP_SESSION_NONE) session_start();
    if (empty($_SESSION['_old_csrf_token'])) {
        $_SESSION['_old_csrf_token'] = bin2hex(random_bytes(32));
    }
    $csrfToken = $_SESSION['_old_csrf_token'];
    $error = isset($_GET['error']) ? htmlspecialchars($_GET['error']) : '';
?>
<!DOCTYPE html>
<html lang="en">
<?php include 'includes/head.php'; ?>
<body style="background: linear-gradient(135deg, var(--primary-dark), var(--primary)); min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 2rem;">

    <div style="position:fixed;inset:0;overflow:hidden;pointer-events:none;">
        <?php for ($i = 0; $i < 20; $i++): 
            $size = rand(2, 5);
            $left = rand(0, 100);
            $delay = rand(0, 15);
            $dur = rand(12, 25);
        ?>
        <div style="position:absolute;left:<?= $left ?>%;width:<?= $size ?>px;height:<?= $size ?>px;background:var(--accent);border-radius:50%;opacity:0.15;animation:float <?= $dur ?>s linear <?= $delay ?>s infinite;"></div>
        <?php endfor; ?>
    </div>

    <div style="position:relative;z-index:10;width:100%;max-width:440px;">
        <a href="index.php" style="display:block;text-align:center;margin-bottom:2rem;text-decoration:none;">
            <div style="display:inline-flex;align-items:center;gap:0.7rem;">
                <div style="width:42px;height:42px;background:var(--accent);border-radius:10px;display:flex;align-items:center;justify-content:center;font-weight:900;font-size:1.3rem;color:var(--primary-dark);">N</div>
                <span style="font-size:1.6rem;font-weight:800;color:var(--white);">NIBS<span style="color:var(--accent);font-weight:300;margin-left:0.3rem;">Portal</span></span>
            </div>
        </a>

        <div style="background:rgba(255,255,255,0.04);backdrop-filter:blur(30px);border:1px solid rgba(255,255,255,0.08);border-radius:var(--radius-lg);padding:2.5rem;box-shadow:0 30px 80px rgba(0,0,0,0.3);">
            <?php if ($error): ?>
                <div style="background:rgba(16,185,129,0.12);border:1px solid rgba(16,185,129,0.3);border-radius:var(--radius-sm);padding:0.8rem 1rem;margin-bottom:1.5rem;text-align:center;font-size:0.85rem;color:#34d399;"><?= $error ?></div>
            <?php endif; ?>
            <h2 style="color:var(--white);font-size:1.6rem;margin-bottom:0.3rem;text-align:center;">Welcome Back</h2>
            <p style="color:rgba(255,255,255,0.4);text-align:center;margin-bottom:2rem;font-size:0.9rem;">Enter your credentials to access the portal</p>

            <form id="login-form" action="backend/auth.php?action=login" method="POST">
                <input type="hidden" name="_csrf_token" id="login-csrf" value="<?= htmlspecialchars($csrfToken) ?>">
                
                <div style="margin-bottom:1.2rem;">
                    <label style="display:block;font-size:0.75rem;font-weight:600;text-transform:uppercase;letter-spacing:1px;color:rgba(255,255,255,0.5);margin-bottom:0.4rem;">Email Address</label>
                    <input type="email" name="email" id="login-email" required placeholder="name@nibs.ac.ke" style="background:rgba(255,255,255,0.04);border:1px solid rgba(255,255,255,0.1);color:var(--white);padding:0.9rem 1rem;border-radius:var(--radius-sm);font-family:inherit;font-size:0.9rem;width:100%;transition:var(--transition);" onfocus="this.style.borderColor='var(--accent)';this.style.boxShadow='0 0 0 3px rgba(16,185,129,0.15)'" onblur="this.style.borderColor='rgba(255,255,255,0.1)';this.style.boxShadow='none'">
                </div>

                <div style="margin-bottom:1.5rem;">
                    <label style="display:block;font-size:0.75rem;font-weight:600;text-transform:uppercase;letter-spacing:1px;color:rgba(255,255,255,0.5);margin-bottom:0.4rem;">Password</label>
                    <input type="password" name="password" id="login-password" required placeholder="••••••••" style="background:rgba(255,255,255,0.04);border:1px solid rgba(255,255,255,0.1);color:var(--white);padding:0.9rem 1rem;border-radius:var(--radius-sm);font-family:inherit;font-size:0.9rem;width:100%;transition:var(--transition);" onfocus="this.style.borderColor='var(--accent)';this.style.boxShadow='0 0 0 3px rgba(16,185,129,0.15)'" onblur="this.style.borderColor='rgba(255,255,255,0.1)';this.style.boxShadow='none'">
                </div>

                <button type="submit" style="width:100%;padding:1rem;background:var(--accent);color:var(--primary-dark);border:none;border-radius:var(--radius-sm);font-weight:700;font-size:1rem;cursor:pointer;transition:var(--transition);display:flex;align-items:center;justify-content:center;gap:0.5rem;" onmouseover="this.style.background='var(--accent-light)';this.style.transform='translateY(-2px)'" onmouseout="this.style.background='var(--accent)';this.style.transform='translateY(0)'">
                    Sign in to Dashboard <i class="fa-solid fa-arrow-right"></i>
                </button>

                <p style="margin-top:1.5rem;text-align:center;font-size:0.85rem;color:rgba(255,255,255,0.3);">
                    Don't have an account? <a href="/register" style="color:var(--accent);font-weight:600;text-decoration:none;">Create one free</a>
                </p>
            </form>
        </div>
    </div>

    <script src="js/app.js"></script>
</body>
</html>
