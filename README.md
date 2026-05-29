# S.K.D Admission System

A lightweight, modern, and scalable **Core PHP + MySQL** admission management system designed for institutes and coaching centers, optimized specifically for shared hosting environments.

---

## 🚀 Tech Stack

- **Frontend**: Core PHP Templates, HTML5, Tailwind CSS v4 (compiled, lightweight), Vanilla JavaScript (pure DOM manipulation).
- **Backend**: Core PHP 8.2
- **Database**: MySQL 8.0+
- **Hosting Compatibility**: Shared hosting (Apache / Litespeed, cPanel) friendly.

---

## 🎯 Project Goals

- **Lightweight Architecture**: No heavy Node.js or React runtimes. Pages load instantly with minimal server memory footprint.
- **Fast Performance**: Static PHP template layout architecture with pre-compiled CSS files.
- **Mobile Responsiveness**: Beautiful, clean, responsive dashboards using Tailwind grids and flexible flexboxes.
- **Branch-Based System**: Supports multi-branch institutes, allowing each branch to manage its own admissions and financials separately.
- **Dynamic Branding**: Flexible layout configuration. Logos, color schemes, and printable styles update dynamically based on the active branch profile.
- **Student Self-Service Portal**: Direct portal for student profile checking, receipt downloading, and certificate printing.
- **WhatsApp Automation Ready**: Logs database tracking ready to be wired to official/third-party WhatsApp API gateways.
- **Upload-Based Certificate System**: Secure manual certificate storage and delivery instead of brittle auto-generated PDF templates.
- **Dynamic ID Cards**: Automatically generated high-resolution double-sided ID cards customized to the individual branch theme and colors.

---

## 👥 Role Structure & Access Control

The system supports **three distinct roles** separated by directories and route restrictions:

1. **Super Admin (Head Office)**
   - **Access**: Global settings, Branch Creation, Login Accounts Management, Students Directory, Fees Audit, Global Reports, WhatsApp Logs, Global Settings.
   - **Dashboard**: Aggregated analytics across all branches.
2. **Branch User**
   - **Access**: Restricted dashboard, New Admission form, Student directory (limited to their branch only), Fee Collection, Certificate Uploads, ID Card Generation, local Branch Settings.
   - **Restriction**: Cannot access other branches' data, global reports, or WhatsApp system logs.
3. **Student**
   - **Access**: Student Portal containing Student Profile summary, Fee ledger, printed ID card view, and issued Certificates download center.

---

## 🔑 Login Structure

1. **`login.php` (Staff & Super Admin)**
   - **Credentials**: Username + Password.
   - **Routing**: Resolves session and redirects to `admin/dashboard.php` or `branch/dashboard.php`.
2. **`student-login.php` (Students)**
   - **Credentials**: **Student ID** + **Registered Mobile Number** (passwordless secure validation).
   - **Routing**: Validates match and redirects to `portal/profile.php`.

---

## 📂 Project Directory Structure

```
skd-admission/
├── admin/                  # Super Admin and Shared Student Management screens
│   ├── dashboard.php       # Global analytics and branch performance metrics
│   ├── branches.php        # Branch directory + Login Account editor (Modal)
│   ├── students.php        # Advanced filterable student directory
│   ├── new-admission.php   # Registration form with 5 mandatory upload zones
│   ├── student-profile.php # Interactive student file, fees, and docs tab view
│   ├── fees.php            # Transaction lists and ledger collection UI
│   ├── certificates.php    # Certificate upload, replace, delete & live preview
│   ├── id-cards.php        # Dynamically branded double-sided printable cards
│   ├── reports.php         # Super Admin printable financial & admission audits
│   ├── settings.php        # Global branding, signage, and terms manager
│   └── whatsapp-logs.php   # Automated message queue audits
├── branch/                 # Branch User restricted screens
│   └── dashboard.php       # Local branch analytics
├── portal/                 # Student Portal self-service screens
│   ├── dashboard.php       # Auto-redirects to profile.php
│   ├── profile.php         # Student profile details & assigned branch contacts
│   ├── fees.php            # Fee paid progress meters and receipt downloads
│   ├── id-card.php         # Double-sided local branch printable ID card
│   └── certificates.php    # Uploaded certificates download cards
├── includes/               # Reusable template components
│   ├── dummy-data.php     # Global simulated database arrays (Mock Data)
│   ├── header.php          # Resolves relative paths, loads styles
│   ├── sidebar.php         # Dynamically renders role-restricted menus
│   ├── navbar.php          # Dynamic top headers, notifications, toasts & loaders
│   └── footer.php          # Loads Lucide icons and unified app.js
├── assets/                 # Pre-compiled static assets
│   ├── css/styles.css      # Pre-compiled Tailwind v4 CSS (89KB)
│   ├── js/app.js           # Shared dynamic vanilla JS utilities
│   └── images/             # favicons & skd-logo.png
├── uploads/                # Secure file storage directories
│   ├── students/           # Registered student profile photos
│   ├── certificates/       # Manually uploaded student certificates
│   ├── documents/          # aadhaar, marksheet, and signature scans
│   └── temp/               # Temporary uploads cache
├── ajax/                   # Placeholders for future asynchronous endpoints
├── api/                    # Placeholders for REST API gateways
└── database/               # SQL schema definitions (.sql files)
```

---

## 📁 Uploads Directory Structure

To keep git tracking clean while preparing the directories for deployment, each directory includes a `.gitkeep` placeholder:
- `uploads/students/`
- `uploads/certificates/`
- `uploads/documents/`
- `uploads/temp/`

### 🏷️ Student ID Format

**Format**: `SKD2026-0001`
- **Prefix**: `SKD` (S.K.D Computer Education)
- **Year**: Current enrollment year (e.g. `2026`)
- **Auto-Increment**: 4-digit zero-padded number.
- **Generation Rule**: `SKD` + `[Year]` + `-` + `LPAD(COUNT(id) + 1, 4, '0')`.

### 💾 File Naming Strategy
Uploaded files must be normalized to prevent collisions and simplify cleanup:
- **Student Profile Photo**: `SKD2026-0001-photo.jpg`
- **Aadhaar Scan**: `SKD2026-0001-aadhaar.pdf`
- **Academic Marksheet**: `SKD2026-0001-marksheet.pdf`
- **Student Signature**: `SKD2026-0001-signature.png`
- **Certificate Document**: `SKD2026-0001-certificate.pdf` (or `.png`/`.jpg`)

---

## 🎨 Dynamic Branding Engine
Branding parameters are fully decoupled from layout logic. Variables like `$db_branch_name`, `$db_branch_logo`, `$db_branch_color`, `$db_branch_contact`, and `$db_branch_address` are loaded globally. When a branch user or student logs in, these parameters update automatically:
- Buttons, progress bars, and header icons map dynamically to the branch's hex `$db_branch_color`.
- Sidebars dynamically reference `$db_branch_logo` and `$db_branch_name`.
- Invoices and printable pages render the correct branch headers, support phones, and terms.

---

## 📜 Certificate & ID Card Systems

### 1. Manual Upload-Based Certificates
No brittle autogenerated HTML-to-Canvas converters. Directors manually upload verified official certificates (PDF, JPG, PNG, WEBP) directly to `uploads/certificates/`. Students instantly download their official documents via their Portal in original quality.

### 2. Dynamically Branded Student ID Cards
Designed as double-sided standard wallet cards. High-resolution layout incorporates the specific branch logo, branch name, student details, signature placeholder, QR Code verification URL, legal terms, and contact info, styled in the branch's primary brand theme color. Prints on standard CR80 layout sizes.

---

## 📱 Responsive & Print Layouts
- **Tailwind Grid & Flexbox**: Clean transition from widescreen desktop view to side-scrolling responsive lists on mobile screens.
- **Mobile Sidebar**: Left sidebar hides cleanly behind an interactive toggle button with a smooth blur backdrop overlay.
- **Dedicated Print Stylesheets**: Print action buttons utilize standard `@media print` directives to hide navigation columns and headers, keeping only the raw ID Card or Certificate frames centered and correctly scaled.

---

## 🔒 Security Architecture Plan (Future Phase)
- **Role Guarding**: Core session middleware at the head of every view file (e.g. `check_role('admin')`).
- **Input Sanitization**: All inputs parsed through HTML purification and prepared SQL queries using PDO (`$stmt->execute()`).
- **Secure Upload Validators**: Mime-type whitelisting, size restrictions (Max 2MB/5MB), and renaming protocols using `pathinfo` to prevent execution of PHP files inside the `uploads/` directory.
- **Apache Hardening**: `.htaccess` disables directory indexing (`Options -Indexes`) and blocks raw access to sensitive extension files like `.sql`, `.toml`, `.json`, and `.log`.

---

## 📅 Future Backend Implementation Phasing
1. **Phase 1: Database Setup**: Run MySQL SQL files, provision foreign key indexes.
2. **Phase 2: Session & Auth**: Write `login.php` database validation, hash check via `password_verify()`, populate session cookies.
3. **Phase 3: Student Registration CRUD**: Map `admin/new-admission.php` POST variables to PDO write commands.
4. **Phase 4: Document Storage Logic**: Write secure PHP upload scripts with extension validation.
5. **Phase 5: Fee Ledgers**: Dynamic updates to fee payments and invoice generator hookups.
6. **Phase 6: WhatsApp Gateways**: Connect logs to automatic curl webhook triggers.
7. **Phase 7: System Release**: Launch testing, compile final queries.

---

## 🔧 Local Development & Credentials

- **Localhost URL**: `http://localhost/skd-admission/`
- **phpMyAdmin Credentials** (Local dev environment only):
  - **Username**: `root`
  - **Password**: `hello brother`

---

## 🏢 Simulated Branch Entities (Database Seed Data)

### 1. Branch 1 (Head Office / camp_pune)
- **Institution**: S.K.D Computer Education
- **Address**: Nerul Station Complex, First, F-114, Nerul West, Navi Mumbai, Maharashtra 400706
- **Contact Phone**: `07073139662`
- **WhatsApp Phone**: `07073139662`
- **Email**: `shivkadass.k.d@gmail.com`
- **Default Theme Color**: `#2563eb` (Royal Blue)

### 2. Branch 2 (nca_chopanki)
- **Institution**: NCA COACHING CENTER
- **Address**: MUSTAK MARKET CHOPANKI ALWAR (RAJ.)
- **Contact Phone**: `9876543211`
- **WhatsApp Phone**: `9876543211`
- **Email**: `ncacoaching@gmail.com`
- **Default Theme Color**: `#0891b2` (Teal)

### 3. Branch 3 (a1_bhiwadi)
- **Institution**: A1 Computer Education
- **Address**: CENTER MARKET BHIWADI (RAJ.)
- **Contact Phone**: `9876543212`
- **WhatsApp Phone**: `9876543212`
- **Email**: `a1computer@gmail.com`
- **Default Theme Color**: `#6366f1` (Indigo)

---

## 👨‍🎓 Simulated Student Profiles (Database Seed Data)

| Student ID | Student Name | Mobile | Course | Branch | Fees Total | Balance Due | Status |
| :--- | :--- | :--- | :--- | :--- | :--- | :--- | :--- |
| **SKD2026-0001** | Rahul Sharma | `+91 98765 43210` | DCA | Pune Camp | ₹15,000 | ₹0 | Active |
| **SKD2026-0002** | Priya Nair | `+91 98765 43211` | Tally Prime | Pune Camp | ₹8,000 | ₹4,000 | Active |
| **SKD2026-0003** | Aman Verma | `+91 98765 43212` | Web Design | Mumbai Central | ₹18,000 | ₹0 | Active |
| **SKD2026-0004** | Sneha Patil | `+91 98765 43213` | ADCA | Nashik Road | ₹25,000 | ₹13,500 | Active |
| **SKD2026-0005** | Karan Mehta | `+91 98765 43214` | CCC | Pune Camp | ₹4,500 | ₹0 | Completed |
