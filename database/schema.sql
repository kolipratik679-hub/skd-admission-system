-- =============================================================
-- SKD Admission System — Database Schema
-- Engine: MySQL 8.0+  |  Charset: utf8mb4_unicode_ci
-- Run this file ONCE in phpMyAdmin or via MySQL CLI.
-- =============================================================

-- Create and select the database
CREATE DATABASE IF NOT EXISTS `skd_admission`
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE `skd_admission`;

-- =============================================================
-- 1. BRANCHES TABLE
--    Stores both super_admin and branch login accounts.
--    role: 'super_admin' | 'branch'
-- =============================================================
CREATE TABLE IF NOT EXISTS `branches` (
    `id`            INT AUTO_INCREMENT PRIMARY KEY,
    `name`          VARCHAR(100)    NOT NULL COMMENT 'Short branch name',
    `brand_name`    VARCHAR(150)    NOT NULL COMMENT 'Full institute/brand name',
    `logo`          VARCHAR(255)    NOT NULL DEFAULT 'assets/images/skd-logo.png',
    `phone`         VARCHAR(20)     NOT NULL,
    `whatsapp`      VARCHAR(20)     DEFAULT NULL,
    `email`         VARCHAR(100)    NOT NULL,
    `address`       TEXT            NOT NULL,
    `primary_color` VARCHAR(10)     NOT NULL DEFAULT '#2563eb',
    `username`      VARCHAR(50)     NOT NULL UNIQUE,
    `password`      VARCHAR(255)    NOT NULL,
    `role`          ENUM('super_admin', 'branch') NOT NULL DEFAULT 'branch',
    `status`        ENUM('Active', 'Inactive')    NOT NULL DEFAULT 'Active',
    `created_at`    TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at`    TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX `idx_username` (`username`),
    INDEX `idx_role`     (`role`),
    INDEX `idx_status`   (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================================
-- 2. STUDENTS TABLE
--    student_id is the PRIMARY KEY in SKD2026-0001 format.
--    branch_id isolates data per branch (data isolation key).
-- =============================================================
CREATE TABLE IF NOT EXISTS `students` (
    `student_id`       VARCHAR(30)  NOT NULL PRIMARY KEY COMMENT 'e.g. SKD2026-0001',
    `full_name`        VARCHAR(100) NOT NULL,
    `gender`           ENUM('Male', 'Female', 'Other') NOT NULL,
    `dob`              DATE         NOT NULL,
    `father_name`      VARCHAR(100) NOT NULL,
    `mother_name`      VARCHAR(100) NOT NULL DEFAULT '',
    `mobile`           VARCHAR(20)  NOT NULL COMMENT 'Used for student login (passwordless)',
    `email`            VARCHAR(100) DEFAULT NULL,
    `branch_id`        INT          NOT NULL,
    `course`           VARCHAR(100) NOT NULL,
    `duration`         VARCHAR(50)  NOT NULL DEFAULT '6 Months',
    `total_fees`       DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    `admission_date`   DATE         NOT NULL,
    `photo`            VARCHAR(255) DEFAULT NULL,
    `aadhaar_doc`      VARCHAR(255) DEFAULT NULL,
    `marksheet_doc`    VARCHAR(255) DEFAULT NULL,
    `signature`        VARCHAR(255) DEFAULT NULL,
    `extra_doc`        VARCHAR(255) DEFAULT NULL,
    `address`          TEXT         DEFAULT NULL,
    `status`           ENUM('Active', 'Completed', 'Dropped') NOT NULL DEFAULT 'Active',
    `created_at`       TIMESTAMP    DEFAULT CURRENT_TIMESTAMP,
    `updated_at`       TIMESTAMP    DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT `fk_students_branch`
        FOREIGN KEY (`branch_id`) REFERENCES `branches`(`id`) ON DELETE RESTRICT,
    INDEX `idx_mobile`    (`mobile`),
    INDEX `idx_branch_id` (`branch_id`),
    INDEX `idx_status`    (`status`),
    INDEX `idx_course`    (`course`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================================
-- 3. FEES TABLE
--    Each row is one fee payment receipt.
--    Branch isolation: enforce via students JOIN.
-- =============================================================
CREATE TABLE IF NOT EXISTS `fees` (
    `id`          INT AUTO_INCREMENT PRIMARY KEY,
    `student_id`  VARCHAR(30)  NOT NULL,
    `receipt_no`  VARCHAR(50)  NOT NULL UNIQUE,
    `amount`      DECIMAL(10,2) NOT NULL,
    `discount`    DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    `paid_date`   DATE         NOT NULL,
    `mode`        ENUM('Cash', 'UPI', 'Bank Transfer', 'Cheque') NOT NULL DEFAULT 'UPI',
    `note`        VARCHAR(255) DEFAULT NULL,
    `status`      ENUM('Success', 'Pending', 'Failed') NOT NULL DEFAULT 'Success',
    `created_at`  TIMESTAMP    DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT `fk_fees_student`
        FOREIGN KEY (`student_id`) REFERENCES `students`(`student_id`) ON DELETE RESTRICT,
    INDEX `idx_student_id` (`student_id`),
    INDEX `idx_paid_date`  (`paid_date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================================
-- 4. CERTIFICATES TABLE
--    Manual upload-based system. No auto-generation.
-- =============================================================
CREATE TABLE IF NOT EXISTS `certificates` (
    `id`               INT AUTO_INCREMENT PRIMARY KEY,
    `student_id`       VARCHAR(30)  NOT NULL,
    `certificate_name` VARCHAR(255) NOT NULL,
    `file_path`        VARCHAR(255) NOT NULL,
    `file_type`        ENUM('pdf', 'png', 'jpg', 'webp') NOT NULL,
    `file_size`        VARCHAR(20)  NOT NULL,
    `issue_date`       DATE         NOT NULL,
    `uploaded_by`      VARCHAR(100) NOT NULL,
    `created_at`       TIMESTAMP    DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT `fk_certificates_student`
        FOREIGN KEY (`student_id`) REFERENCES `students`(`student_id`) ON DELETE RESTRICT,
    INDEX `idx_student_id` (`student_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================================
-- 5. DOCUMENTS TABLE
--    Tracks all student document uploads (Aadhaar, Marksheet, etc.)
-- =============================================================
CREATE TABLE IF NOT EXISTS `documents` (
    `id`          INT AUTO_INCREMENT PRIMARY KEY,
    `student_id`  VARCHAR(30)  NOT NULL,
    `doc_type`    ENUM('photo', 'aadhaar', 'marksheet', 'signature', 'extra') NOT NULL,
    `file_path`   VARCHAR(255) NOT NULL,
    `file_size`   VARCHAR(20)  NOT NULL,
    `uploaded_at` TIMESTAMP    DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT `fk_documents_student`
        FOREIGN KEY (`student_id`) REFERENCES `students`(`student_id`) ON DELETE RESTRICT,
    INDEX `idx_student_id` (`student_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================================
-- 6. WHATSAPP LOGS TABLE
--    Tracks all outbound automated WhatsApp notifications.
-- =============================================================
CREATE TABLE IF NOT EXISTS `whatsapp_logs` (
    `id`         INT AUTO_INCREMENT PRIMARY KEY,
    `branch_id`  INT          NOT NULL,
    `student_id` VARCHAR(30)  DEFAULT NULL COMMENT 'NULL = broadcast or generic message',
    `recipient`  VARCHAR(20)  NOT NULL,
    `message`    TEXT         NOT NULL,
    `status`     ENUM('Sent', 'Failed', 'Pending') NOT NULL DEFAULT 'Pending',
    `sent_at`    TIMESTAMP    DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT `fk_logs_branch`
        FOREIGN KEY (`branch_id`) REFERENCES `branches`(`id`) ON DELETE RESTRICT,
    INDEX `idx_branch_id` (`branch_id`),
    INDEX `idx_status`    (`status`),
    INDEX `idx_sent_at`   (`sent_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- End of schema.sql
