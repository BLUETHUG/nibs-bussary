const API_AUTH = 'backend/auth.php';
const API_URL = 'backend/api.php';

// Helper: Show toast notification
function showToast(message, type = 'success') {
    const container = document.getElementById('toast-container');
    if (!container) return;

    const toast = document.createElement('div');
    toast.className = `toast ${type}`;
    toast.textContent = message;

    container.appendChild(toast);

    setTimeout(() => {
        toast.style.animation = 'fadeOut 0.3s forwards ease-in';
        setTimeout(() => toast.remove(), 300);
    }, 3000);
}

// NIBS Portal - Interactive Enhancements
document.addEventListener('DOMContentLoaded', () => {
    // Smooth Scroll for all links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            document.querySelector(this.getAttribute('href')).scrollIntoView({
                behavior: 'smooth'
            });
        });
    });

    // Button Micro-interactions
    document.querySelectorAll('button').forEach(btn => {
        btn.addEventListener('mousedown', () => {
            btn.style.transform = 'scale(0.96)';
        });
        btn.addEventListener('mouseup', () => {
            btn.style.transform = 'scale(1)';
        });
    });

    console.log("NIBS Portal: Smooth transitions active.");
});
// Navigation Events on Login/Register page
if (document.getElementById('go-to-register') && document.getElementById('go-to-login')) {
    document.getElementById('go-to-register').addEventListener('click', () => {
        document.getElementById('login-section').classList.add('hidden');
        document.getElementById('register-section').classList.remove('hidden');
    });

    document.getElementById('go-to-login').addEventListener('click', () => {
        document.getElementById('register-section').classList.add('hidden');
        document.getElementById('login-section').classList.remove('hidden');
    });

    // Toggle forms via header links
    document.getElementById('nav-login').addEventListener('click', (e) => {
        e.preventDefault();
        document.getElementById('register-section').classList.add('hidden');
        document.getElementById('login-section').classList.remove('hidden');
    });

    document.getElementById('nav-register').addEventListener('click', (e) => {
        e.preventDefault();
        document.getElementById('login-section').classList.add('hidden');
        document.getElementById('register-section').classList.remove('hidden');
    });
}

// --- API Calls ---

let csrfToken = null;

async function apiCall(url, method, data = null) {
    try {
        const options = {
            method: method,
            headers: { 'Content-Type': 'application/json' }
        };
        if (data) {
            if (!csrfToken) {
                const res = await fetch(`${API_AUTH}?action=csrf`);
                const json = await res.json();
                csrfToken = json.token;
            }
            data._csrf_token = csrfToken;
            options.body = JSON.stringify(data);
        }
        const response = await fetch(url, options);
        const text = await response.text();
        try {
            return JSON.parse(text);
        } catch (e) {
            console.error("Non-JSON Response from server:", text);
            return { error: 'Server returned an invalid response.' };
        }

    } catch (error) {
        showToast('Network error, could not connect to server.', 'error');
        return null;
    }
}

// Read CSRF token from hidden input (pre-populated server-side)
(async function initCsrf() {
    const csrfInput = document.getElementById('login-csrf');
    if (csrfInput && csrfInput.value) {
        csrfToken = csrfInput.value;
    } else {
        try {
            const res = await fetch(`${API_AUTH}?action=csrf`);
            const json = await res.json();
            csrfToken = json.token;
            if (csrfInput) csrfInput.value = csrfToken;
        } catch (e) {
            console.warn('Could not fetch CSRF token');
        }
    }
})();

// Registration
if (document.getElementById('register-form')) {
    document.getElementById('register-form').addEventListener('submit', async (e) => {
        e.preventDefault();
        const name = document.getElementById('reg-name').value;
        const email = document.getElementById('reg-email').value;
        const password = document.getElementById('reg-password').value;

        const res = await apiCall(`${API_AUTH}?action=register`, 'POST', { name, email, password });
        if (res && res.success) {
            showToast('Registration successful! Please login.');
            document.getElementById('go-to-login').click();
            document.getElementById('register-form').reset();
        } else if (res && res.error) {
            showToast(res.error, 'error');
        }
    });
}

// Login
if (document.getElementById('login-form')) {
    document.getElementById('login-form').addEventListener('submit', async (e) => {
        e.preventDefault();
        const email = document.getElementById('login-email').value;
        const password = document.getElementById('login-password').value;

        const res = await apiCall(`${API_AUTH}?action=login`, 'POST', { email, password });
        if (res && res.success) {
            showToast('Login successful!');
            setTimeout(() => {
                if (res.role === 'admin') {
                    window.location.href = '/admin/dashboard';
                } else {
                    window.location.href = '/student/dashboard';
                }
            }, 500);
        } else if (res && res.error) {
            showToast(res.error, 'error');
        }
    });
}

// Logout functionality
if (document.getElementById('nav-logout')) {
    document.getElementById('nav-logout').addEventListener('click', (e) => {
        e.preventDefault();
        window.location.href = `${API_AUTH}?action=logout`;
    });
}

// === Student Dashboard Logic ===
if (document.getElementById('apply-form')) {
    const applySection = document.getElementById('application-form-section');

    document.getElementById('btn-new-application').addEventListener('click', () => {
        applySection.classList.remove('hidden');
    });

    document.getElementById('btn-cancel-apply').addEventListener('click', () => {
        applySection.classList.add('hidden');
        document.getElementById('apply-form').reset();
    });

    // Apply for bursary
    document.getElementById('apply-form').addEventListener('submit', async (e) => {
        e.preventDefault();
        const payload = {
            student_id_number: document.getElementById('app-student-id').value,
            course: document.getElementById('app-course').value,
            amount_requested: document.getElementById('app-amount').value,
            reason: document.getElementById('app-reason').value
        };

        const res = await apiCall(`${API_URL}?action=apply`, 'POST', payload);
        if (res && res.success) {
            showToast(res.success);
            applySection.classList.add('hidden');
            document.getElementById('apply-form').reset();
            loadStudentApplications();
        } else if (res && res.error) {
            showToast(res.error, 'error');
        }
    });

    // Load applications table on student dash
    async function loadStudentApplications() {
        const res = await apiCall(`${API_URL}?action=get_applications`, 'GET');
        if (res && res.applications) {
            const tbody = document.getElementById('applications-tbody');
            tbody.innerHTML = '';

            document.getElementById('total-applications').textContent = res.applications.length;

            let approvedCount = 0;

            res.applications.forEach(app => {
                if (app.status === 'approved') approvedCount++;

                const date = new Date(app.application_date).toLocaleDateString();
                const amount = Number(app.amount_requested).toLocaleString();
                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td>${date}</td>
                    <td style="font-weight: 500;">${app.course}</td>
                    <td>${amount}</td>
                    <td><span class="badge badge-${app.status}">${app.status}</span></td>
                `;
                tbody.appendChild(tr);
            });

            document.getElementById('approved-applications').textContent = approvedCount;

            if (res.applications.length === 0) {
                const tr = document.createElement('tr');
                tr.innerHTML = `<td colspan="4" class="text-center" style="color: #94A3B8;">No applications found. Submit one above!</td>`;
                tbody.appendChild(tr);
            }
        }
    }

    loadStudentApplications();
}

// === Admin Dashboard Logic ===
if (document.getElementById('admin-applications-table')) {

    document.getElementById('refresh-btn').addEventListener('click', loadAdminApplications);

    async function loadAdminApplications() {
        const res = await apiCall(`${API_URL}?action=get_applications`, 'GET');
        if (res && res.applications) {
            const tbody = document.getElementById('admin-applications-tbody');
            tbody.innerHTML = '';

            let pendingCount = 0;
            let approvedCount = 0;
            let rejectedCount = 0;

            res.applications.forEach(app => {
                const date = new Date(app.application_date).toLocaleDateString();
                const amount = Number(app.amount_requested).toLocaleString();

                if (app.status === 'pending') pendingCount++;
                if (app.status === 'approved') approvedCount++;
                if (app.status === 'rejected') rejectedCount++;

                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td>${date}</td>
                    <td style="font-weight: 500;">${app.student_name}</td>
                    <td>${app.student_id_number}</td>
                    <td>${app.course}</td>
                    <td style="max-width: 200px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" title="${app.reason}">${app.reason}</td>
                    <td>${amount}</td>
                    <td><span class="badge badge-${app.status}">${app.status}</span></td>
                    <td>
                        <div class="action-btns">
                            ${app.status === 'pending' ? `
                                <button class="btn-approve" onclick="updateStatus(${app.id}, 'approved')">Approve</button>
                                <button class="btn-reject" onclick="updateStatus(${app.id}, 'rejected')">Reject</button>
                            ` : `<span style="color: #94A3B8; font-size: 0.8rem;">Reviewed</span>`}
                        </div>
                    </td>
                `;
                tbody.appendChild(tr);
            });

            document.getElementById('stat-pending').textContent = pendingCount;
            document.getElementById('stat-approved').textContent = approvedCount;
            document.getElementById('stat-rejected').textContent = rejectedCount;

            if (res.applications.length === 0) {
                const tr = document.createElement('tr');
                tr.innerHTML = `<td colspan="8" class="text-center" style="color: #94A3B8;">No applications submitted yet.</td>`;
                tbody.appendChild(tr);
            }
        }
    }

    // Attach function to global scope so inline onclick works
    window.updateStatus = async function (application_id, status) {
        if (!confirm(`Are you sure you want to mark this application as ${status}?`)) return;

        const res = await apiCall(`${API_URL}?action=update_status`, 'POST', { application_id, status });
        if (res && res.success) {
            showToast(`Application successfully ${status}!`);
            loadAdminApplications();
        } else if (res && res.error) {
            showToast(res.error, 'error');
        }
    }

    loadAdminApplications();
}
