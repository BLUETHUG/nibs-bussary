<?php 
    $pageTitle = "Apply - NIBS Bursary Portal";
    if (session_status() === PHP_SESSION_NONE) session_start();
    if (!isset($_SESSION['user_id'])) { header('Location: login.php', true, 302); exit; }
    if (empty($_SESSION['_old_csrf_token'])) {
        $_SESSION['_old_csrf_token'] = bin2hex(random_bytes(32));
    }
    $csrfToken = $_SESSION['_old_csrf_token'];
?>
<!DOCTYPE html>
<html lang="en">
<?php include 'includes/head.php'; ?>
<body style="background: var(--off-white); display: flex;">

    <?php include 'includes/sidebar.php'; ?>

    <div style="flex: 1; min-width: 0; display: flex; flex-direction: column;">
        <!-- Top bar -->
        <div style="background: var(--white); padding: 1.2rem 3rem; display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid var(--border); position: sticky; top: 0; z-index: 100;">
            <h2 style="margin: 0; font-size: 1.4rem; color: var(--primary);">Bursary Application Wizard</h2>
            <div style="display: flex; align-items: center; gap: 1rem;">
                <p style="font-size: 0.85rem; color: var(--text-muted); margin: 0;">Step <span id="current-step-num">1</span> of 7</p>
                <div style="width: 150px; height: 8px; background: var(--border); border-radius: 10px; overflow: hidden;">
                    <div id="step-progress-bar" style="width: 14.28%; height: 100%; background: var(--accent); border-radius: 10px; transition: width 0.3s ease;"></div>
                </div>
            </div>
        </div>

        <main style="padding: 3rem; flex: 1; display: flex; align-items: flex-start; justify-content: center;">
            <div style="max-width: 900px; width: 100%; background: var(--white); padding: 3.5rem 4rem; border-radius: var(--radius-md); box-shadow: var(--shadow-md);">

                <form id="multi-step-form" action="backend/process-application.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="_csrf_token" value="<?= htmlspecialchars($csrfToken) ?>">

                    <!-- Step 1: Personal Info -->
                    <div class="form-step active" id="step-1">
                        <div style="margin-bottom: 2.5rem;">
                            <h3 style="font-size: 1.75rem; margin-bottom: 0.5rem; color: var(--primary);">Personal Information</h3>
                            <p style="color: var(--text-muted);">Please provide your official identification details.</p>
                        </div>
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                            <div class="form-group"><label>First Name</label><input type="text" name="first_name" required placeholder="John"></div>
                            <div class="form-group"><label>Last Name</label><input type="text" name="last_name" required placeholder="Doe"></div>
                            <div class="form-group"><label>ID Number</label><input type="text" name="id_number" required placeholder="12345678"></div>
                            <div class="form-group"><label>Date of Birth</label><input type="date" name="dob" required></div>
                            <div class="form-group"><label>Gender</label><select name="gender"><option>Male</option><option>Female</option><option>Other</option></select></div>
                            <div class="form-group"><label>Phone Number</label><input type="tel" name="phone" required placeholder="+254 700 000 000"></div>
                            <div class="form-group" style="grid-column: span 2;"><label>Physical Address</label><textarea name="address" rows="2" placeholder="Street, Building, Apartment"></textarea></div>
                        </div>
                    </div>

                    <!-- Step 2: Academic Info -->
                    <div class="form-step" id="step-2" style="display: none;">
                        <div style="margin-bottom: 2.5rem;">
                            <h3 style="font-size: 1.75rem; margin-bottom: 0.5rem; color: var(--primary);">Academic Details</h3>
                            <p style="color: var(--text-muted);">Enter your current enrollment and performance data.</p>
                        </div>
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                            <div class="form-group"><label>Student ID (Registration Number)</label><input type="text" name="reg_number" required placeholder="NIBS/2024/0001"></div>
                            <div class="form-group"><label>Current Course</label><input type="text" name="course" required placeholder="Diploma in ICT"></div>
                            <div class="form-group"><label>Department</label><select name="department"><option>IT & Computer Science</option><option>Business</option><option>Engineering</option><option>Hospitality</option></select></div>
                            <div class="form-group"><label>Year of Study</label><select name="year"><option>Year 1</option><option>Year 2</option><option>Year 3</option></select></div>
                            <div class="form-group"><label>Current GPA/Average</label><input type="number" step="0.01" name="gpa" required placeholder="3.5"></div>
                            <div class="form-group"><label>Completion Date</label><input type="month" name="grad_date" required></div>
                        </div>
                    </div>

                    <!-- Step 3: Financial Background -->
                    <div class="form-step" id="step-3" style="display: none;">
                        <div style="margin-bottom: 2.5rem;">
                            <h3 style="font-size: 1.75rem; margin-bottom: 0.5rem; color: var(--primary);">Financial Background</h3>
                            <p style="color: var(--text-muted);">This information helps us determine your level of need.</p>
                        </div>
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                            <div class="form-group"><label>Parent/Guardian Occupation</label><input type="text" name="parent_job" placeholder="Self-employed"></div>
                            <div class="form-group"><label>Household Monthly Income (KES)</label><input type="number" name="income" required placeholder="25000"></div>
                            <div class="form-group"><label>Current Fee Balance (KES)</label><input type="number" name="fee_balance" required placeholder="45000"></div>
                            <div class="form-group"><label>Source of Funding</label><select name="funding_source"><option>Self/Parents</option><option>Loan (HELB)</option><option>Sponsorship</option></select></div>
                            <div class="form-group" style="grid-column: span 2;"><label>Financial Hardship Statement</label><textarea name="hardship_statement" rows="4" placeholder="Briefly explain why you need financial support..."></textarea></div>
                        </div>
                    </div>

                    <!-- Step 4: Social & Welfare Info -->
                    <div class="form-step" id="step-4" style="display: none;">
                        <div style="margin-bottom: 2.5rem;">
                            <h3 style="font-size: 1.75rem; margin-bottom: 0.5rem; color: var(--primary);">Social & Welfare</h3>
                            <p style="color: var(--text-muted);">Optional but important context for your application.</p>
                        </div>
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                            <div class="form-group" style="grid-column: span 2;"><label>Orphan Status</label><div style="display: flex; gap: 2rem; margin-top: 0.5rem;"><label style="display: flex; align-items: center; gap: 0.5rem; font-weight: 400; cursor: pointer;"><input type="radio" name="orphan" value="no" checked> No</label><label style="display: flex; align-items: center; gap: 0.5rem; font-weight: 400; cursor: pointer;"><input type="radio" name="orphan" value="yes"> Yes (Single/Total)</label></div></div>
                            <div class="form-group" style="grid-column: span 2;"><label>Disability Status</label><div style="display: flex; gap: 2rem; margin-top: 0.5rem;"><label style="display: flex; align-items: center; gap: 0.5rem; font-weight: 400; cursor: pointer;"><input type="radio" name="disability" value="no" checked> No</label><label style="display: flex; align-items: center; gap: 0.5rem; font-weight: 400; cursor: pointer;"><input type="radio" name="disability" value="yes"> Yes</label></div></div>
                            <div class="form-group" style="grid-column: span 2;"><label>Chronic Illness Information</label><input type="text" name="illness" placeholder="N/A"></div>
                        </div>
                    </div>

                    <!-- Step 5: Document Upload -->
                    <div class="form-step" id="step-5" style="display: none;">
                        <div style="margin-bottom: 2.5rem;">
                            <h3 style="font-size: 1.75rem; margin-bottom: 0.5rem; color: var(--primary);">Document Submission</h3>
                            <p style="color: var(--text-muted);">Upload clear images or PDFs of the following documents.</p>
                        </div>
                        <div style="display: grid; grid-template-columns: 1fr; gap: 1.25rem;">
                            <div class="upload-box">
                                <div><p style="font-weight: 700; margin: 0;">National ID / Birth Certificate</p><p style="font-size: 0.85rem; color: var(--text-muted); margin: 0;">Required (Max 5MB PDF/JPG)</p></div>
                                <input type="file" name="doc_id">
                            </div>
                            <div class="upload-box">
                                <div><p style="font-weight: 700; margin: 0;">Current Fee Statement</p><p style="font-size: 0.85rem; color: var(--text-muted); margin: 0;">Required (Must be recent)</p></div>
                                <input type="file" name="doc_fees">
                            </div>
                            <div class="upload-box">
                                <div><p style="font-weight: 700; margin: 0;">Academic Transcripts</p><p style="font-size: 0.85rem; color: var(--text-muted); margin: 0;">Required (From last semester)</p></div>
                                <input type="file" name="doc_transcripts">
                            </div>
                        </div>
                    </div>

                    <!-- Step 6: Review -->
                    <div class="form-step" id="step-6" style="display: none;">
                        <div style="margin-bottom: 2.5rem;">
                            <h3 style="font-size: 1.75rem; margin-bottom: 0.5rem; color: var(--primary);">Review & Declare</h3>
                            <p style="color: var(--text-muted);">Ensure all information provided is accurate and truthful.</p>
                        </div>
                        <div style="background: var(--off-white); padding: 2rem; border-radius: var(--radius-sm); border-left: 4px solid var(--accent); margin-bottom: 2rem;">
                            <p style="font-size: 0.95rem; line-height: 1.8; color: var(--text-dark);">I hereby declare that the information provided in this bursary application is true and complete to the best of my knowledge. I understand that any false information will lead to immediate disqualification and potential disciplinary action by the NIBS administration.</p>
                        </div>
                        <label style="display: flex; align-items: center; gap: 1rem; font-weight: 600; cursor: pointer; color: var(--text-dark);">
                            <input type="checkbox" required> I agree to the terms and declaration above.
                        </label>
                    </div>

                    <!-- Navigation Buttons -->
                    <div style="display: flex; justify-content: space-between; margin-top: 3rem; padding-top: 2rem; border-top: 1px solid var(--border);">
                        <button type="button" id="prev-btn" class="btn-secondary" style="visibility: hidden;">Previous</button>
                        <button type="button" id="next-btn" class="btn-accent">Continue <i class="fa-solid fa-arrow-right" style="margin-left: 0.5rem;"></i></button>
                        <button type="submit" id="submit-btn" class="btn-accent" style="display: none;">Submit Application</button>
                    </div>

                </form>

            </div>
        </main>
    </div>

    <style>
        .form-group { display: flex; flex-direction: column; gap: 0.4rem; }
        .form-group label { font-weight: 600; font-size: 0.9rem; color: var(--primary); }
        .form-group input,
        .form-group select,
        .form-group textarea {
            padding: 0.75rem 1rem;
            border: 1.5px solid var(--border);
            border-radius: var(--radius-sm);
            font-family: var(--font-sans);
            font-size: 0.95rem;
            color: var(--text-dark);
            background: var(--white);
            transition: var(--transition);
            outline: none;
        }
        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.15);
        }
        .form-group input::placeholder,
        .form-group textarea::placeholder { color: var(--text-light); }
        .form-group textarea { resize: vertical; min-height: 60px; }

        .upload-box {
            padding: 1.5rem;
            border: 2px dashed var(--border);
            border-radius: var(--radius-sm);
            display: flex;
            align-items: center;
            justify-content: space-between;
            transition: var(--transition);
        }
        .upload-box:hover {
            border-color: var(--accent);
            background: rgba(16, 185, 129, 0.03);
        }
        .upload-box input[type="file"] { width: auto; font-size: 0.85rem; }

        .btn-secondary {
            width: auto;
            padding: 0.85rem 2.5rem;
            border: 1.5px solid var(--border);
            border-radius: var(--radius-sm);
            background: var(--white);
            color: var(--text-dark);
            font-weight: 600;
            font-size: 0.95rem;
            font-family: var(--font-sans);
            cursor: pointer;
            transition: var(--transition);
        }
        .btn-secondary:hover {
            border-color: var(--text-muted);
            background: var(--off-white);
        }

        .btn-accent {
            width: auto;
            padding: 0.85rem 2.5rem;
            border: none;
            border-radius: var(--radius-sm);
            background: var(--accent);
            color: var(--primary-dark);
            font-weight: 700;
            font-size: 0.95rem;
            font-family: var(--font-sans);
            cursor: pointer;
            transition: var(--transition);
            letter-spacing: 0.01em;
        }
        .btn-accent:hover {
            background: var(--accent-dark);
            box-shadow: var(--shadow-md);
            transform: translateY(-1px);
        }

        input[type="radio"] { accent-color: var(--accent); }
        input[type="checkbox"] { accent-color: var(--accent); width: 18px; height: 18px; }
        select { cursor: pointer; }
    </style>

    <!-- Multi-step logic -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const steps = document.querySelectorAll('.form-step');
            const prevBtn = document.getElementById('prev-btn');
            const nextBtn = document.getElementById('next-btn');
            const submitBtn = document.getElementById('submit-btn');
            const progress = document.getElementById('step-progress-bar');
            const stepNum = document.getElementById('current-step-num');
            let currentStep = 0;

            const updateSteps = () => {
                steps.forEach((step, index) => {
                    step.style.display = index === currentStep ? 'block' : 'none';
                });
                stepNum.textContent = currentStep + 1;
                progress.style.width = ((currentStep + 1) / steps.length * 100) + '%';
                prevBtn.style.visibility = currentStep === 0 ? 'hidden' : 'visible';
                if (currentStep === steps.length - 1) {
                    nextBtn.style.display = 'none';
                    submitBtn.style.display = 'block';
                } else {
                    nextBtn.style.display = 'block';
                    submitBtn.style.display = 'none';
                }
                window.scrollTo({ top: 0, behavior: 'smooth' });
            };

            nextBtn.addEventListener('click', () => {
                if (currentStep < steps.length - 1) {
                    currentStep++;
                    updateSteps();
                }
            });

            prevBtn.addEventListener('click', () => {
                if (currentStep > 0) {
                    currentStep--;
                    updateSteps();
                }
            });
        });
    </script>

    <!-- Form submit handler (prevents JSON raw response on submit) -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const form = document.getElementById('multi-step-form');
            form.addEventListener('submit', async (e) => {
                e.preventDefault();
                const formData = new FormData(form);
                try {
                    const res = await fetch('backend/process-application.php', {
                        method: 'POST',
                        body: formData
                    });
                    const data = await res.json();
                    if (data.success) {
                        alert('Application submitted successfully!');
                        window.location.href = 'my-applications.php';
                    } else {
                        alert(data.error || 'An unknown error occurred.');
                    }
                } catch (err) {
                    alert('Network error: unable to submit application.');
                }
            });
        });
    </script>
</body>
</html>
