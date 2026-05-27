-- NIBS Bursary Management System - Production Schema
CREATE DATABASE IF NOT EXISTS bursary_system;
USE bursary_system;

-- 2. Users Table (Students + Admins)
CREATE TABLE IF NOT EXISTS users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    fullname VARCHAR(150),
    email VARCHAR(150) UNIQUE,
    phone VARCHAR(20),
    password VARCHAR(255),
    role ENUM('student','admin','tech','reviewer') DEFAULT 'student',
    national_id VARCHAR(20),
    institution VARCHAR(150),
    course VARCHAR(150),
    year_of_study INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 4. Bursary Applications
CREATE TABLE IF NOT EXISTS applications (
    application_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    family_income DECIMAL(10,2),
    guardian_name VARCHAR(150),
    guardian_phone VARCHAR(20),
    reason TEXT,
    status ENUM('pending','under_review','approved','rejected') DEFAULT 'pending',
    score INT DEFAULT 0,
    submitted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id)
);

-- 5. Application Documents
CREATE TABLE IF NOT EXISTS documents (
    doc_id INT AUTO_INCREMENT PRIMARY KEY,
    application_id INT,
    document_type VARCHAR(100),
    file_path VARCHAR(255),
    uploaded_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (application_id) REFERENCES applications(application_id)
);

-- 6. Sponsors Table
CREATE TABLE IF NOT EXISTS sponsors (
    sponsor_id INT AUTO_INCREMENT PRIMARY KEY,
    sponsor_name VARCHAR(150),
    logo VARCHAR(255),
    website VARCHAR(200),
    description TEXT,
    contribution_amount DECIMAL(12,2),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 8. Program History
CREATE TABLE IF NOT EXISTS program_history (
    history_id INT AUTO_INCREMENT PRIMARY KEY,
    year INT,
    title VARCHAR(200),
    description TEXT,
    image VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 12. Gamification System
CREATE TABLE IF NOT EXISTS user_points (
    point_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    points INT,
    reason VARCHAR(200),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id)
);

-- 14. Notifications
CREATE TABLE IF NOT EXISTS notifications (
    notification_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    message TEXT,
    status ENUM('unread','read') DEFAULT 'unread',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id)
);

-- 16. Contact Messages
CREATE TABLE IF NOT EXISTS contact_messages (
    message_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150),
    email VARCHAR(150),
    subject VARCHAR(200),
    message TEXT,
    status ENUM('new','replied','archived') DEFAULT 'new',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 19. Audit Trail
CREATE TABLE IF NOT EXISTS audit_trail (
    audit_id INT AUTO_INCREMENT PRIMARY KEY,
    table_name VARCHAR(100),
    record_id INT,
    action ENUM('INSERT','UPDATE','DELETE'),
    changed_by INT,
    change_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
