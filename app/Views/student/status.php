<?php
declare(strict_types=1);
$pageTitle = 'My Applications — NIBS Bursary';
$bodyClass = 'page-student-status';
ob_start();
?>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<style>
:root {
    --navy: #1A237E;
    --navy-light: #283593;
    --navy-dark: #0D1442;
    --gold: #FFD54F;
    --gold-light: #FFE082;
    --gold-dark: #FFC107;
    --white: #FAFAFA;
    --bg-card: #FFFFFF;
    --text-primary: #1A237E;
    --text-secondary: #546E7A;
    --text-muted: #90A4AE;
    --border: #E8EAF6;
    --success: #43A047;
    --error: #E53935;
    --shadow-sm: 0 2px 8px rgba(26,35,126,0.08);
    --shadow-md: 0 4px 20px rgba(26,35,126,0.12);
    --shadow-lg: 0 8px 40px rgba(26,35,126,0.16);
    --radius: 12px;
    --radius-lg: 20px;
    --transition: 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.page-student-status {
    margin: 0;
    padding: 0;
    font-family: 'Poppins', sans-serif;
    background: linear-gradient(135deg, #E8EAF6 0%, #FAFAFA 50%, #FFF8E1 100%);
    min-height: 100vh;
}
html[data-theme="dark"] .page-student-status {
    background: linear-gradient(135deg, #0D1442 0%, #1a1a2e 50%, #16213e 100%);
}

/* ─── Sticky Nav ─── */
.status-nav {
    position: sticky;
    top: 0;
    z-index: 1000;
    background: rgba(255,255,255,0.92);
    backdrop-filter: blur(16px);
    -webkit-backdrop-filter: blur(16px);
    border-bottom: 1px solid var(--border);
    padding: 0 1.5rem;
    height: 64px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    box-shadow: var(--shadow-sm);
}
.status-nav-brand {
    display: flex;
    align-items: center;
    gap: 0.6rem;
    text-decoration: none;
    font-weight: 700;
    font-size: 1rem;
    color: var(--navy);
}
.status-nav-brand svg { flex-shrink: 0; }
.status-nav-links {
    display: flex;
    align-items: center;
    gap: 0.25rem;
}
.status-nav-link {
    display: flex;
    align-items: center;
    gap: 0.4rem;
    padding: 0.5rem 1rem;
    border-radius: 8px;
    text-decoration: none;
    color: var(--text-secondary);
    font-size: 0.82rem;
    font-weight: 500;
    transition: all var(--transition);
}
.status-nav-link:hover,
.status-nav-link.active {
    background: var(--navy);
    color: #fff;
}
.status-nav-link i { font-size: 0.9rem; }

/* ─── Container ─── */
.status-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 2rem 1.5rem 4rem;
}

/* ─── Header ─── */
.status-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 1rem;
    margin-bottom: 1.5rem;
}
.status-header-title {
    font-size: 1.2rem;
    font-weight: 700;
    color: var(--navy);
    display: flex;
    align-items: center;
    gap: 0.5rem;
    margin: 0;
}
.status-header-title i { color: var(--gold-dark); }

/* ─── Card ─── */
.status-card {
    background: var(--bg-card);
    border-radius: var(--radius-lg);
    box-shadow: var(--shadow-md);
    transition: box-shadow var(--transition);
}
.status-card:hover { box-shadow: var(--shadow-lg); }

/* ─── Alert ─── */
.status-alert {
    margin-bottom: 1.5rem;
    padding: 0.85rem 1.25rem;
    display: flex;
    align-items: center;
    gap: 0.75rem;
    background: var(--bg-card);
    border-radius: var(--radius);
    box-shadow: var(--shadow-sm);
    font-size: 0.85rem;
    color: var(--text-secondary);
    border-left: 4px solid var(--success);
}
.status-alert i { color: var(--success); font-size: 1.1rem; }

/* ─── Filter Bar ─── */
.status-filter-bar {
    display: flex;
    gap: 0.75rem;
    flex-wrap: wrap;
    margin-bottom: 1.5rem;
}
.status-search-wrap {
    position: relative;
    flex: 1;
    min-width: 200px;
}
.status-search-wrap i {
    position: absolute;
    left: 1rem;
    top: 50%;
    transform: translateY(-50%);
    color: var(--text-muted);
    font-size: 0.9rem;
    pointer-events: none;
}
.status-search-input {
    width: 100%;
    padding: 0.7rem 1rem 0.7rem 2.5rem;
    border: 1.5px solid var(--border);
    border-radius: var(--radius);
    color: var(--text-primary);
    font-size: 0.85rem;
    font-family: 'Poppins', sans-serif;
    background: var(--bg-card);
    transition: all var(--transition);
    outline: none;
    box-sizing: border-box;
}
.status-search-input:focus {
    border-color: var(--navy);
    box-shadow: 0 0 0 3px rgba(26,35,126,0.1);
}
.status-search-input::placeholder { color: var(--text-muted); }
.status-filter-select {
    padding: 0.7rem 2rem 0.7rem 1rem;
    border: 1.5px solid var(--border);
    border-radius: var(--radius);
    color: var(--text-primary);
    font-size: 0.85rem;
    font-family: 'Poppins', sans-serif;
    background: var(--bg-card);
    cursor: pointer;
    transition: all var(--transition);
    outline: none;
    -webkit-appearance: none;
    appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%2390A4AE' d='M6 8L1 3h10z'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 0.85rem center;
    min-width: 140px;
}
.status-filter-select:focus {
    border-color: var(--navy);
    box-shadow: 0 0 0 3px rgba(26,35,126,0.1);
}
.status-filter-select option { background: var(--bg-card); color: var(--text-primary); }

/* ─── Table ─── */
.status-table-wrap {
    overflow-x: auto;
    border-radius: var(--radius);
    border: 1px solid var(--border);
}
.status-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 0.82rem;
}
.status-table th {
    text-align: left;
    padding: 0.75rem 1rem;
    color: #fff;
    font-weight: 600;
    font-size: 0.72rem;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    background: linear-gradient(135deg, var(--navy), var(--navy-light));
}
.status-table td {
    padding: 0.7rem 1rem;
    border-bottom: 1px solid var(--border);
    color: var(--text-secondary);
}
.status-table tbody tr:nth-child(even) td {
    background: #FFFDF5;
}
.status-table tbody tr:hover td {
    background: #F0F0FF;
}
.status-table tr:last-child td { border-bottom: none; }
.status-table strong { color: var(--text-primary); }

/* ─── Empty State ─── */
.status-empty {
    text-align: center;
    padding: 3rem 1.5rem;
}
.status-empty-icon { font-size: 2.5rem; margin-bottom: 1rem; color: var(--text-muted); opacity: 0.4; }
.status-empty h3 { font-size: 1.05rem; color: var(--text-primary); margin-bottom: 0.375rem; }
.status-empty p { font-size: 0.82rem; color: var(--text-muted); max-width: 320px; margin: 0 auto 1.25rem; }

/* ─── Legend ─── */
.status-legend {
    display: flex;
    flex-wrap: wrap;
    gap: 1rem;
    margin-top: 1rem;
    padding: 0.85rem 1.25rem;
    background: #F5F6FA;
    border-radius: var(--radius);
    align-items: center;
}
.status-legend-label {
    font-size: 0.72rem;
    color: var(--text-muted);
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-right: 0.25rem;
}
.status-legend-item {
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    font-size: 0.78rem;
    color: var(--text-secondary);
}
.status-legend-dot {
    width: 8px; height: 8px;
    border-radius: 50%;
}
.status-legend-dot-pending { background: #d97706; }
.status-legend-dot-approved { background: #059669; }
.status-legend-dot-rejected { background: #dc2626; }
.status-legend-dot-disbursed { background: var(--navy); }

/* ─── Status Badges ─── */
.status-badge {
    display: inline-flex;
    align-items: center;
    padding: 0.25rem 0.65rem;
    border-radius: 999px;
    font-size: 0.72rem;
    font-weight: 600;
}
.status-pending { background: #FFF8E1; color: #F57F17; }
.status-approved { background: #E8F5E9; color: var(--success); }
.status-rejected { background: #FFEBEE; color: var(--error); }
.status-disbursed { background: #E8EAF6; color: var(--navy); }
.status-withdrawn { background: #F3E5F5; color: #7B1FA2; }
[data-theme="dark"] .status-withdrawn { background: rgba(123,31,162,0.15); color: #CE93D8; }

/* ─── Buttons ─── */
.status-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    padding: 0.7rem 1.5rem;
    border: none;
    border-radius: var(--radius);
    font-family: 'Poppins', sans-serif;
    font-size: 0.82rem;
    font-weight: 600;
    cursor: pointer;
    transition: all var(--transition);
    text-decoration: none;
    box-shadow: var(--shadow-sm);
}
.status-btn-primary {
    background: linear-gradient(135deg, var(--navy), var(--navy-light));
    color: #fff;
}
.status-btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 24px rgba(26,35,126,0.3);
}
.status-btn-gold {
    background: linear-gradient(135deg, var(--gold), var(--gold-dark));
    color: var(--navy-dark);
}
.status-btn-gold:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 24px rgba(255,213,79,0.4);
}

/* ─── Animations ─── */
@keyframes fadeUp {
    from { opacity: 0; transform: translateY(14px); }
    to { opacity: 1; transform: translateY(0); }
}
.anim-1 { animation: fadeUp 0.4s 0.05s both; }
.anim-2 { animation: fadeUp 0.4s 0.15s both; }
.anim-3 { animation: fadeUp 0.4s 0.25s both; }
.anim-4 { animation: fadeUp 0.4s 0.35s both; }
.anim-5 { animation: fadeUp 0.4s 0.45s both; }

/* ─── Mobile ─── */
@media (max-width: 768px) {
    .status-container { padding: 1rem 1rem 5rem; }
    .status-filter-bar { flex-direction: column; }
    .status-search-wrap { min-width: auto; }
    .status-filter-select { min-width: auto; }
    .status-legend { gap: 0.5rem; }
    .status-nav-links .status-nav-link span { display: none; }
    .status-nav-link { padding: 0.5rem 0.65rem; }
    .status-nav-link i { font-size: 1.1rem; }
}
</style>

<!-- ─── Sticky Nav ─── -->
<nav class="status-nav anim-1">
    <a href="/student/dashboard" class="status-nav-brand">
        <svg width="30" height="30" viewBox="0 0 34 34" fill="none">
            <rect width="34" height="34" rx="8" fill="url(#snav)"/>
            <defs><linearGradient id="snav" x1="0" y1="0" x2="34" y2="34"><stop stop-color="#1A237E"/><stop offset="1" stop-color="#283593"/></linearGradient></defs>
            <text x="17" y="23" text-anchor="middle" font-size="18" font-weight="bold" fill="#FFD54F" font-family="Poppins">N</text>
        </svg>
        NIBS Bursary
    </a>
    <div class="status-nav-links">
        <a href="/student/dashboard" class="status-nav-link"><i class="fa-solid fa-house"></i><span>Dashboard</span></a>
        <a href="/student/apply" class="status-nav-link"><i class="fa-solid fa-file-pen"></i><span>Apply</span></a>
        <a href="/student/status" class="status-nav-link active"><i class="fa-solid fa-list-check"></i><span>Status</span></a>
        <a href="/student/dashboard" class="status-nav-link" style="position:relative;"><i class="fa-solid fa-bell"></i><span>Alerts</span><?php if (!empty($unreadCount) && $unreadCount > 0): ?><span style="position:absolute;top:2px;right:2px;background:var(--error);color:#fff;font-size:0.6rem;font-weight:700;min-width:16px;height:16px;border-radius:8px;display:flex;align-items:center;justify-content:center;padding:0 4px;"><?= $unreadCount > 9 ? '9+' : $unreadCount ?></span><?php endif; ?></a>
        <button class="theme-toggle status-nav-link" id="theme-toggle-status" aria-label="Toggle dark mode" title="Toggle dark mode" style="border:none;cursor:pointer;font-size:0.82rem;display:inline-flex;align-items:center;gap:0.35rem;padding:0.5rem 0.85rem;border-radius:8px;color:var(--text-secondary);transition:all var(--transition);font-weight:500;font-family:inherit;"><i class="fa-solid fa-moon" id="theme-icon-status"></i><span>Theme</span></button>
        <a href="/logout" class="status-nav-link" style="color:var(--error);"><i class="fa-solid fa-right-from-bracket"></i><span>Logout</span></a>
    </div>
</nav>

<div class="status-container">

    <div class="status-header anim-2">
        <h2 class="status-header-title"><i class="fa-solid fa-list"></i> My Applications</h2>
        <a href="/student/apply" class="status-btn status-btn-primary">New Application</a>
    </div>

    <?php if (isset($_GET['success'])): ?>
    <div class="status-alert anim-3">
        <i class="fa-solid fa-check-circle"></i> Application submitted successfully!
    </div>
    <?php endif; ?>
    <?php if (isset($_GET['withdrawn'])): ?>
    <div class="status-alert anim-3" style="background:#F3E5F5;border-left-color:#7B1FA2;">
        <i class="fa-solid fa-minus-circle"></i> Application withdrawn successfully.
    </div>
    <?php endif; ?>
    <?php if (isset($_GET['error'])): ?>
    <div class="status-alert anim-3" style="background:#FFEBEE;border-left-color:var(--error);">
        <i class="fa-solid fa-exclamation-circle"></i> Could not withdraw. Only pending applications can be withdrawn.
    </div>
    <?php endif; ?>

    <!-- Search/Filter Bar -->
    <div class="status-filter-bar anim-3">
        <div class="status-search-wrap">
            <i class="fa-solid fa-search"></i>
            <input type="text" class="status-search-input" placeholder="Search applications..." id="statusSearch" oninput="filterTable()">
        </div>
        <select class="status-filter-select" id="statusFilter" onchange="filterTable()">
            <option value="">All Statuses</option>
            <option value="pending">Pending</option>
            <option value="approved">Approved</option>
            <option value="rejected">Rejected</option>
            <option value="disbursed">Disbursed</option>
            <option value="withdrawn">Withdrawn</option>
        </select>
        <select class="status-filter-select" id="yearFilter" onchange="filterTable()">
            <option value="">All Years</option>
            <?php
            $years = [];
            if (!empty($applications)) {
                foreach ($applications as $app) {
                    $y = htmlspecialchars($app['academic_year']);
                    if (!in_array($y, $years)) $years[] = $y;
                }
            }
            foreach ($years as $y): ?>
            <option value="<?= $y ?>"><?= $y ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="status-card anim-4">
        <?php if (empty($applications)): ?>
        <div class="status-empty">
            <div class="status-empty-icon"><i class="fa-solid fa-inbox"></i></div>
            <h3>No Applications Yet</h3>
            <p>You haven't submitted any applications. Start your bursary journey today.</p>
            <a href="/student/apply" class="status-btn status-btn-gold">Apply Now</a>
        </div>
        <?php else: ?>
        <div class="status-table-wrap">
            <table class="status-table" id="applicationsTable">
                <thead>
                    <tr>
                        <th>Academic Year</th>
                        <th>Amount Requested</th>
                        <th>Amount Approved</th>
                        <th>Status</th>
                        <th>Submitted</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($applications as $app): ?>
                    <tr>
                        <td data-year="<?= htmlspecialchars($app['academic_year']) ?>"><?= htmlspecialchars($app['academic_year']) ?></td>
                        <td><strong>KES <?= number_format((float)$app['amount_requested'], 2) ?></strong></td>
                        <td>KES <?= number_format((float)$app['amount_approved'], 2) ?></td>
                        <td><span class="status-badge status-<?= $app['status'] ?>"><?= ucfirst($app['status']) ?></span></td>
                        <td><?= date('d M Y', strtotime($app['created_at'])) ?></td>
                        <td>
                            <?php if ($app['status'] === 'pending'): ?>
                            <form method="POST" action="/student/withdraw" style="display:inline;" onsubmit="return confirm('Withdraw this application? This cannot be undone.')">
                                <?= \App\Middleware\CsrfMiddleware::field() ?>
                                <input type="hidden" name="application_id" value="<?= $app['id'] ?>">
                                <button type="submit" class="status-btn status-btn-danger" style="padding:0.3rem 0.65rem;font-size:0.72rem;background:#FFEBEE;color:#C62828;border:none;border-radius:6px;cursor:pointer;font-family:inherit;font-weight:500;">Withdraw</button>
                            </form>
                            <?php else: ?>
                            <span style="color:var(--text-muted);font-size:0.72rem;">—</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- Status Legend -->
        <div class="status-legend">
            <span class="status-legend-label">Legend</span>
            <span class="status-legend-item"><span class="status-legend-dot status-legend-dot-pending"></span> Pending</span>
            <span class="status-legend-item"><span class="status-legend-dot status-legend-dot-approved"></span> Approved</span>
            <span class="status-legend-item"><span class="status-legend-dot status-legend-dot-rejected"></span> Rejected</span>
            <span class="status-legend-item"><span class="status-legend-dot status-legend-dot-disbursed"></span> Disbursed</span>
            <span class="status-legend-item"><span class="status-legend-dot" style="background:#7B1FA2;"></span> Withdrawn</span>
        </div>
        <?php endif; ?>
    </div>
</div>

<script>
function filterTable() {
    var search = document.getElementById('statusSearch').value.toLowerCase();
    var statusFilter = document.getElementById('statusFilter').value.toLowerCase();
    var yearFilter = document.getElementById('yearFilter').value;
    var rows = document.querySelectorAll('#applicationsTable tbody tr');
    rows.forEach(function(row) {
        var text = row.textContent.toLowerCase();
        var year = row.cells[0]?.getAttribute('data-year') || '';
        var statusEl = row.querySelector('.status-badge');
        var statusText = statusEl ? statusEl.textContent.toLowerCase().trim() : '';
        var matchSearch = !search || text.indexOf(search) > -1;
        var matchStatus = !statusFilter || statusText === statusFilter;
        var matchYear = !yearFilter || year === yearFilter;
        row.style.display = (matchSearch && matchStatus && matchYear) ? '' : 'none';
    });
}
</script>
<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/base.php';
