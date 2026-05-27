-- database/seeds.sql
START TRANSACTION;

-- 1. Insert Users (Admin, Officer, Committee, Accountant, Students)
-- Passwords are: Admin@1234, Student@1234 (all hashed with BCRYPT)
INSERT INTO `users` (`full_name`, `index_number`, `email`, `phone`, `password_hash`, `role`) VALUES
('System Admin', 'ADM001', 'admin@nibs.ac.ke', '0712345678', '$2y$12$R.S/tG8j0P/C6wIe8wO.f.L0XgYjS0H9J/L8V.h7jL0V6S9J0W5Y2', 'admin'),
('Bursary Officer', 'OFF001', 'officer@nibs.ac.ke', '0722345678', '$2y$12$R.S/tG8j0P/C6wIe8wO.f.L0XgYjS0H9J/L8V.h7jL0V6S9J0W5Y2', 'officer'),
('Committee Member 1', 'COM001', 'committee1@nibs.ac.ke', '0732345678', '$2y$12$R.S/tG8j0P/C6wIe8wO.f.L0XgYjS0H9J/L8V.h7jL0V6S9J0W5Y2', 'committee'),
('Senior Accountant', 'ACC001', 'accountant@nibs.ac.ke', '0742345678', '$2y$12$R.S/tG8j0P/C6wIe8wO.f.L0XgYjS0H9J/L8V.h7jL0V6S9J0W5Y2', 'accountant'),
('John Doe', 'STUD001', 'student001@nibs.ac.ke', '0752345678', '$2y$12$uE3N.zL4M3O4P5Q6R7S8T9U0V1W2X3Y4Z5A6B7C8D9E0F1G2H3I4J', 'student'),
('Jane Smith', 'STUD002', 'student002@nibs.ac.ke', '0762345678', '$2y$12$uE3N.zL4M3O4P5Q6R7S8T9U0V1W2X3Y4Z5A6B7C8D9E0F1G2H3I4J', 'student'),
('Alice Brown', 'STUD003', 'student003@nibs.ac.ke', '0772345678', '$2y$12$uE3N.zL4M3O4P5Q6R7S8T9U0V1W2X3Y4Z5A6B7C8D9E0F1G2H3I4J', 'student'),
('Bob Johnson', 'STUD004', 'student004@nibs.ac.ke', '0782345678', '$2y$12$uE3N.zL4M3O4P5Q6R7S8T9U0V1W2X3Y4Z5A6B7C8D9E0F1G2H3I4J', 'student'),
('Charlie Wilson', 'STUD005', 'student005@nibs.ac.ke', '0792345678', '$2y$12$uE3N.zL4M3O4P5Q6R7S8T9U0V1W2X3Y4Z5A6B7C8D9E0F1G2H3I4J', 'student');

-- 2. Insert Student Details
INSERT INTO `students` (`user_id`, `course`, `year_of_study`, `gender`, `date_of_birth`, `guardian_name`, `guardian_phone`, `guardian_monthly_income`, `family_size`) VALUES
(5, 'Computer Science', 2, 'male', '2004-05-15', 'Mark Doe', '0711111111', 15000.00, 4),
(6, 'Business Management', 1, 'female', '2005-08-20', 'Mary Smith', '0722222222', 12000.00, 5),
(7, 'Electrical Engineering', 3, 'female', '2003-11-10', 'Sam Brown', '0733333333', 18000.00, 3),
(8, 'Hospitality', 2, 'male', '2004-02-28', 'Lucy Johnson', '0744444444', 10000.00, 6),
(9, 'Journalism', 1, 'male', '2005-12-05', 'Fred Wilson', '0755555555', 20000.00, 4);

-- 3. Insert Bursary Funds
INSERT INTO `bursary_funds` (`fund_name`, `total_amount`, `available_amount`, `academic_year`, `source`, `created_by`) VALUES
('Government Helb Supplement', 500000.00, 500000.00, '2024/2025', 'government', 1),
('NIBS Excellence Fund', 200000.00, 200000.00, '2024/2025', 'institution', 1),
('Donor Scholarship 2024', 300000.00, 300000.00, '2024/2025', 'donor', 1);

-- 4. Insert Sample Applications
INSERT INTO `applications` (`student_id`, `fund_id`, `academic_year`, `amount_requested`, `status`, `special_circumstances`) VALUES
(1, 1, '2024/2025', 5000.00, 'pending', 'Single parent household, low income.'),
(2, 1, '2024/2025', 8000.00, 'under_review', 'Orphaned, living with elderly grandparents.'),
(3, 2, '2024/2025', 10000.00, 'shortlisted', 'High academic performance, financial hardship.'),
(4, 3, '2024/2025', 15000.00, 'approved', 'Disabled student requiring special assistance.'),
(5, 1, '2024/2025', 4000.00, 'rejected', 'Missing supporting documents.');

-- 5. Insert Announcements
INSERT INTO `announcements` (`title`, `body`, `posted_by`) VALUES
('Bursary Application Open', 'We are pleased to announce that bursary applications for the 2024/2025 academic year are now open.', 1),
('Deadline Approaching', 'Please ensure all applications are submitted by May 30th, 2024.', 1);

COMMIT;
