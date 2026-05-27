-- database/schema.sql
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

-- 1. Users table
CREATE TABLE IF NOT EXISTS `users` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `full_name` VARCHAR(255) NOT NULL,
  `index_number` VARCHAR(50) UNIQUE NOT NULL,
  `email` VARCHAR(255) UNIQUE NOT NULL,
  `phone` VARCHAR(20) NOT NULL,
  `password_hash` VARCHAR(255) NOT NULL,
  `role` ENUM('student', 'admin', 'officer', 'committee', 'accountant') NOT NULL DEFAULT 'student',
  `is_active` TINYINT(1) DEFAULT 1,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 2. Students table
CREATE TABLE IF NOT EXISTS `students` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT NOT NULL,
  `course` VARCHAR(255) NOT NULL,
  `year_of_study` INT NOT NULL,
  `gender` ENUM('male', 'female', 'other') NOT NULL,
  `date_of_birth` DATE NOT NULL,
  `guardian_name` VARCHAR(255) NOT NULL,
  `guardian_phone` VARCHAR(20) NOT NULL,
  `guardian_occupation` VARCHAR(255),
  `guardian_monthly_income` DECIMAL(15, 2) NOT NULL,
  `family_size` INT NOT NULL,
  `photo_path` VARCHAR(255),
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 3. Bursary Funds table
CREATE TABLE IF NOT EXISTS `bursary_funds` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `fund_name` VARCHAR(255) NOT NULL,
  `total_amount` DECIMAL(15, 2) NOT NULL,
  `available_amount` DECIMAL(15, 2) NOT NULL,
  `academic_year` VARCHAR(20) NOT NULL,
  `source` ENUM('government', 'donor', 'institution') NOT NULL,
  `created_by` INT NOT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`created_by`) REFERENCES `users`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 4. Applications table
CREATE TABLE IF NOT EXISTS `applications` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `student_id` INT NOT NULL,
  `fund_id` INT NOT NULL,
  `academic_year` VARCHAR(20) NOT NULL,
  `application_date` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `status` ENUM('pending', 'under_review', 'shortlisted', 'approved', 'rejected', 'disbursed') DEFAULT 'pending',
  `amount_requested` DECIMAL(15, 2) NOT NULL,
  `amount_approved` DECIMAL(15, 2) DEFAULT 0.00,
  `special_circumstances` TEXT,
  `supporting_doc_path` VARCHAR(255),
  `reviewed_by` INT,
  `review_date` TIMESTAMP NULL,
  `rejection_reason` TEXT,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (`student_id`) REFERENCES `students`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`fund_id`) REFERENCES `bursary_funds`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 5. Committee Scores table
CREATE TABLE IF NOT EXISTS `committee_scores` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `application_id` INT NOT NULL,
  `member_id` INT NOT NULL,
  `need_score` INT CHECK (`need_score` BETWEEN 1 AND 10),
  `academic_score` INT CHECK (`academic_score` BETWEEN 1 AND 10),
  `circumstance_score` INT CHECK (`circumstance_score` BETWEEN 1 AND 10),
  `total_score` INT GENERATED ALWAYS AS (`need_score` + `academic_score` + `circumstance_score`) STORED,
  `recommendation` TEXT,
  `scored_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`application_id`) REFERENCES `applications`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`member_id`) REFERENCES `users`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 6. Disbursements table
CREATE TABLE IF NOT EXISTS `disbursements` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `application_id` INT NOT NULL,
  `amount` DECIMAL(15, 2) NOT NULL,
  `payment_method` ENUM('cash', 'bank_transfer', 'mpesa') NOT NULL,
  `disbursed_by` INT NOT NULL,
  `disbursed_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `reference_number` VARCHAR(100) UNIQUE NOT NULL,
  `notes` TEXT,
  FOREIGN KEY (`application_id`) REFERENCES `applications`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`disbursed_by`) REFERENCES `users`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 7. Notifications table
CREATE TABLE IF NOT EXISTS `notifications` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT NOT NULL,
  `title` VARCHAR(255) NOT NULL,
  `message` TEXT NOT NULL,
  `is_read` TINYINT(1) DEFAULT 0,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 8. Audit Logs table
CREATE TABLE IF NOT EXISTS `audit_logs` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT,
  `action` VARCHAR(255) NOT NULL,
  `table_affected` VARCHAR(100),
  `record_id` INT,
  `old_value` JSON,
  `new_value` JSON,
  `ip_address` VARCHAR(45),
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 9. Announcements table
CREATE TABLE IF NOT EXISTS `announcements` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `title` VARCHAR(255) NOT NULL,
  `body` TEXT NOT NULL,
  `posted_by` INT NOT NULL,
  `is_active` TINYINT(1) DEFAULT 1,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`posted_by`) REFERENCES `users`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

COMMIT;
