# NIBS Bursary Management System

Automated bursary application and disbursement management platform for **NIBS Technical College** (Nairobi, Kenya).

## Features

- Student registration & login with secure CSRF-protected forms
- Online bursary application with multi-step wizard
- Application review queue with scoring (committee scoring system)
- Fund management & budget tracking
- Disbursement processing with M-Pesa/Bank transfer support
- Admin dashboard with analytics & reporting (PDF/CSV export)
- Announcement & notification system
- Audit logging for compliance
- Role-based access (Student, Admin, Officer, Committee, Accountant)
- SQLite fallback when MySQL unavailable
- Dual codebase: legacy PHP files alongside modern MVC OOP system

## Requirements

- PHP 8.0+
- MySQL 5.7+ (or SQLite for local dev)
- Apache mod_rewrite / nginx
- Composer (for autoloading)

## Installation

### Quick Start (Built-in PHP Server)

```bash
# 1. Clone the repository
git clone https://github.com/YOUR_USERNAME/nibs-bursary.git
cd nibs-bursary

# 2. Install dependencies
composer install

# 3. Set up the database
# Option A: MySQL — import database/schema.sql
# Option B: SQLite (auto-fallback) — no setup needed

# 4. Start the development server
composer serve
```

Visit http://localhost:8000 — the site will use SQLite automatically if MySQL is unavailable.

### Apache / Production Setup

1. Point your document root to the project root (not `public/`)
2. Ensure `mod_rewrite` is enabled — `.htaccess` handles routing
3. Import `database/schema.sql` into your MySQL database
4. Copy `.env.example` to `.env` and configure database credentials
5. Run `composer install --no-dev`

## Architecture

```
├── app/               # MVC application (Controllers, Models, Views, Middleware)
│   ├── Controllers/
│   ├── Helpers/
│   ├── Middleware/
│   ├── Models/
│   └── Views/
├── backend/           # Legacy backend handlers (auth, DB, API)
├── config/            # Application & database configuration
├── css/               # Legacy stylesheets
├── database/          # SQL schema & seed data
├── includes/          # Shared partials (navbar, sidebar, footer, head)
├── js/                # Legacy JavaScript
├── public/            # MVC front controller & assets
│   ├── assets/        # Compiled CSS, JS, images
│   └── index.php      # Router entry point
├── routes/            # Route definitions
├── .htaccess          # URL rewriting
├── server.php         # Built-in PHP server router
└── index.php          # Legacy homepage
```

## Default Login

Default admin credentials are created via the setup script (run `backend/setup.php` after installation).

## License

MIT
