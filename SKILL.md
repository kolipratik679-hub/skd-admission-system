# SKD Admission System — AI Development Memory Guide

This guide serves as an **AI Memory System** and strict instruction set for all future AI development sessions and engineers. It outlines structural rules, architecture limitations, UI constraints, and coding standards.

---

## ⚠️ Strict Core Project Rules

1. **Keep the Project Lightweight**: Do not introduce node build layers, bundlers, npm compilers, webpack modules, runtime loaders, or React engines.
2. **Shared-Hosting Compatible Only**: Keep files inside static Core PHP file scopes compatible with default Apache/Litespeed servers.
3. **Core PHP 8.2 & MySQL Only**: Write pure procedural or clean object-oriented Core PHP. Do not import Laravel, Symfony, or Express packages.
4. **No Heavy Frameworks**: Keep the frontend built strictly with native HTML5, pre-compiled Tailwind v4 CSS, and pure modular Vanilla JS.
5. **Preserve the UI Design**: Do not change the aesthetic design system (White card panels, subtle blue borders, soft light-gray backgrounds, and round pills).
6. **Preserve Mobile Responsiveness**: Keep columns responsive (e.g. `grid md:grid-cols-3` or `flex-col sm:flex-row`). Always check mobile sidebar toggling when modifying header structures.
7. **Preserve Print Layouts**: Keep specific CSS media queries for printable sheets (ID cards, certificates, invoices). Do not block custom sizing styles.
8. **Keep Layout Architecture Modular**: Always split template views into header, sidebar, navbar, and footer includes.

---

## 🏛️ Architecture Rules

### 1. 1 Branch = 1 Login Account
- There is **no separate Users database table** or Users page.
- Branch operators act as their respective branch managers and use their specific branch credentials to log in.
- This dramatically simplifies role structure and access rules.

### 2. Strict Role Segregation
- **Super Admin (admin/ directory)**: Full system access across all branch datasets, credentials management, fees audit logs, global settings, and message queues.
- **Branch User (branch/ directory & shared admin/ pages)**: Can register new students, view local admissions, print student ID cards, upload certificates, and configure local branding. Branch users **must never** view other branch profiles, global report logs, or the WhatsApp queue.
- **Student (portal/ directory)**: Strictly restricted to their own ID and mobile number credentials. Can only view their personal records, ledger payments, local branch help contact, and download their certificates.

---

## 🎨 Branding & Style Constraints

- Every single branch is **completely independent** in its branding.
- Dynamic branding variables (`$db_brand_name`, `$db_branch_logo`, `$db_branch_color`, etc.) are pulled automatically based on the active session context.
- **DO NOT** hardcode branding parameters. Always use the central configuration values.
- Primary visual accent properties (like buttons, badges, and progress lines) must bind inline to `$db_branch_color` dynamically.

---

## 📜 Certificate & File Upload Constraints

- **No Canvas-based autogeneration**: Do not create PHP/JS canvas certificate builders. Keep the system strictly based on manual PDF/PNG/JPG certificate uploads.
- **Strict renaming protocols**: Save uploaded files in secure hash paths or clear structures named after the student's unique ID (`SKD2026-0001-photo.jpg`, etc.).
- **Validation**: Enforce extension limits (PDF, JPG, PNG, WEBP) and size caps (Max 2MB for photos/scans, 5MB for certificates/zips).

---

## 💾 Planned Database Schema Design

Future database implementers must build the following table schemas:

```sql
-- 1. Branches Table
CREATE TABLE branches (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    brand_name VARCHAR(150) NOT NULL,
    logo_path VARCHAR(255) DEFAULT 'assets/images/skd-logo.png',
    contact VARCHAR(50) NOT NULL,
    whatsapp VARCHAR(50) DEFAULT NULL,
    email VARCHAR(100) NOT NULL,
    address TEXT NOT NULL,
    color VARCHAR(10) DEFAULT '#2563eb',
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    status ENUM('Active', 'Inactive') DEFAULT 'Active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 2. Students Table
CREATE TABLE students (
    student_id VARCHAR(30) PRIMARY KEY, -- format: SKD2026-0001
    name VARCHAR(100) NOT NULL,
    gender ENUM('Male', 'Female', 'Other') NOT NULL,
    dob DATE NOT NULL,
    father VARCHAR(100) NOT NULL,
    mother VARCHAR(100) NOT NULL,
    mobile VARCHAR(20) NOT NULL,
    email VARCHAR(100) DEFAULT NULL,
    branch_id INT NOT NULL,
    course VARCHAR(100) NOT NULL,
    duration VARCHAR(50) DEFAULT '6 Months',
    admission_date DATE NOT NULL,
    photo_path VARCHAR(255) DEFAULT NULL,
    aadhaar_path VARCHAR(255) DEFAULT NULL,
    marksheet_path VARCHAR(255) DEFAULT NULL,
    signature_path VARCHAR(255) DEFAULT NULL,
    extra_docs_path VARCHAR(255) DEFAULT NULL,
    status ENUM('Active', 'Completed', 'Dropped') DEFAULT 'Active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (branch_id) REFERENCES branches(id)
);

-- 3. Fees Table
CREATE TABLE fees (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id VARCHAR(30) NOT NULL,
    receipt_no VARCHAR(50) NOT NULL UNIQUE,
    amount DECIMAL(10, 2) NOT NULL,
    discount DECIMAL(10, 2) DEFAULT 0.00,
    paid_date DATE NOT NULL,
    mode VARCHAR(50) DEFAULT 'UPI',
    status ENUM('Success', 'Pending', 'Failed') DEFAULT 'Success',
    FOREIGN KEY (student_id) REFERENCES students(student_id)
);

-- 4. Certificates Table
CREATE TABLE certificates (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id VARCHAR(30) NOT NULL,
    certificate_name VARCHAR(255) NOT NULL,
    issue_date DATE NOT NULL,
    file_size VARCHAR(20) NOT NULL,
    uploaded_by VARCHAR(100) NOT NULL,
    file_type ENUM('pdf', 'png', 'jpg', 'webp') NOT NULL,
    FOREIGN KEY (student_id) REFERENCES students(student_id)
);

-- 5. WhatsApp Logs Table
CREATE TABLE whatsapp_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    branch_id INT NOT NULL,
    recipient VARCHAR(20) NOT NULL,
    message TEXT NOT NULL,
    status ENUM('Sent', 'Failed', 'Pending') DEFAULT 'Sent',
    sent_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (branch_id) REFERENCES branches(id)
);
```

---

## 💻 Coding Style Guidelines

1. **Prism of Relative Paths**: Subfolder pages must detect directory depth and load base files dynamically using `$base_path` variable declarations.
2. **Clean Backend-Ready Forms**: Every input field must have an explicit `name="..."` matching the MySQL column structure. Forms must submit to clean action controllers (like `action="students.php"`).
3. **Vanilla Dynamic JS Utilities**: Shared logic (tabs, sidebar opening, dialog prompts, filters) must be written cleanly inside `assets/js/app.js`. Avoid using messy inline `<script>` tags on individual pages.
4. **Backend-Ready Placeholders**: Replace hardcoded values using clean inline echo structures:
   - `<?= $target_student['name'] ?>`
   - `<?= $db_branch_name ?>`
   - `<?= $fee_badge_color ?>`

---

## 🔧 Local Development & DB Credentials

- **Testing URL**: `http://localhost/skd-admission/`
- **phpMyAdmin Credentials** (For local Apache/XAMPP DB development):
  - **Username**: `root`
  - **Password**: `hello brother`

---

## 🚀 Guidelines for Future AI Development Sessions

> [!IMPORTANT]
> When executing subsequent backend integrations or modifications:
> 1. Always inspect `includes/dummy-data.php` first before building database loaders.
> 2. Keep CSS file sizes tiny and clean; avoid modifying `assets/css/styles.css` unless updating Compiled Tailwind layouts.
> 3. Enforce the **1 Branch = 1 Login Account** architecture.
> 4. Ensure no visual redesign breaks the current pristine white/blue aesthetic of the SKD Admission System.
