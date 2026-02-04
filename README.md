# Find Tutors - Professional Tuition Management Platform

[![Laravel](https://img.shields.io/badge/Laravel-10.x-red.svg)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.1+-blue.svg)](https://php.net)
[![License](https://img.shields.io/badge/license-MIT-green.svg)](LICENSE)

A comprehensive Laravel 10 application for managing tuition services in Bangladesh. Connects tutors with guardians, manages commission-based partnerships, and provides complete admin oversight.

## 🌟 Features

### Multi-User System
- **Tutors**: Create profiles, apply to posts, manage tuitions
- **Guardians**: Post tuition needs, review applications, hire tutors
- **Partners**: Create commission-based posts, track earnings
- **Admins**: Approve profiles, verify tuitions, manage commissions

### Core Functionality
- ✅ Profile creation with step-by-step wizard
- ✅ Admin approval workflow for all user types
- ✅ Tuition post creation and browsing
- ✅ Application and hiring system
- ✅ Dual confirmation (tutor + guardian) before admin verification
- ✅ Commission tracking with 10% platform fee
- ✅ Payout request and processing system
- ✅ Email notifications (verification, approvals, status updates)
- ✅ Review and rating system
- ✅ Referral system with tracking

### Bangladesh-Specific
- 🇧🇩 8 divisions with areas
- 🇧🇩 Bengali Taka (৳) currency
- 🇧🇩 Local payment methods (bKash, Nagad, Rocket)
- 🇧🇩 Asia/Dhaka timezone
- 🇧🇩 Local curriculum support (Bangla, English, Arabic Medium)

## 📋 Requirements

- PHP 8.1 or higher
- Composer
- MySQL 5.7+
- Node.js & NPM (for assets)
- Laravel 10.x

## 🚀 Quick Start (Local Development)

### 1. Clone & Install
```bash
git clone YOUR_REPO_URL
cd Web-Application
composer install
cp .env.example .env
php artisan key:generate
```

### 2. Database Setup
```bash
# Create database 'findtutors' in MySQL
php artisan migrate
php artisan db:seed
```

### 3. Storage Link
```bash
php artisan storage:link
```

### 4. Configure Email
Edit `.env`:
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-gmail-app-password
MAIL_ENCRYPTION=tls
```

### 5. Run Development Server
```bash
php artisan serve
```

Visit: http://localhost:8000

## 🌐 Deployment

See [DEPLOYMENT.md](DEPLOYMENT.md) for complete Railway deployment guide.

### Quick Deploy to Railway

1. Push to GitHub:
```bash
git init
git add .
git commit -m "Initial commit"
git push -u origin main
```

2. Deploy on Railway:
   - Go to https://railway.app
   - New Project → Deploy from GitHub
   - Add MySQL database
   - Configure environment variables
   - Deploy automatically!

## 👥 Default Accounts (After Seeding)

### Super Admin
- Email: admin@findtutors.com
- Password: password

### Test Users
- Tutor: tutor@example.com / password
- Guardian: guardian@example.com / password
- Partner: partner@example.com / password

## 💰 Commission System Flow

1. Partner creates post with commission (private field)
2. Tutors apply to post
3. Guardian reviews and accepts application
4. Tutor confirms tuition start
5. Guardian confirms tuition start
6. Admin verifies both confirmations
7. Admin approves commission
8. Partner requests payout (min ৳1,000)
9. Admin processes payout (10% platform fee deducted)

## 📁 Project Structure

```
Web-Application/
├── app/
│   ├── Http/Controllers/     # 23 controllers
│   ├── Models/               # 16 models
│   └── Helpers/              # Helper functions
├── database/
│   ├── migrations/           # 16 tables
│   └── seeders/              # Data seeders
├── resources/views/          # 127+ Blade templates
├── routes/web.php            # ~100 routes
├── config/findtutors.php     # App config
├── Procfile                  # Railway deployment
├── railway.json              # Railway config
└── DEPLOYMENT.md             # Deployment guide
```

## 🔐 Security Features

- Email verification required
- Admin approval for profiles
- Dual confirmation (tutor + guardian)
- Commission visibility (partners & admins only)
- CSRF protection
- Password hashing with bcrypt

## 📧 Email Notifications

- Account verification
- Profile approval/rejection
- Application status updates
- Tuition confirmations
- Commission approvals
- Payout status

## 🛠️ Key Configuration

In `config/findtutors.php`:
- Platform fee: 10%
- Minimum payout: ৳1,000
- Post expiry: 30 days
- Max file sizes configured

## 🐛 Troubleshooting

### Database Connection
```bash
php artisan config:clear
php artisan cache:clear
```

### Storage Issues
```bash
chmod -R 755 storage bootstrap/cache
php artisan storage:link
```

### Email Not Sending
- Enable Gmail 2FA
- Generate App Password
- Update MAIL_PASSWORD

## 📚 Documentation

- [DEPLOYMENT.md](DEPLOYMENT.md) - Full deployment guide
- [DEVELOPMENT-SUMMARY.md](DEVELOPMENT-SUMMARY.md) - Development details
- [PROGRESS.md](PROGRESS.md) - Progress tracking

## 📄 License

MIT License

## 👨‍💻 Developer

**TuitionMedia Team**
- Version: 1.0.0
- Laravel: 10.x
- PHP: 8.1+

---

**Built with ❤️ for Bangladesh's Education Sector**


### User Types
1. **Super Admin** (type=1) - Full system control
2. **Admin** (type=2) - Profile approvals, user management  
3. **Tutor** (type=3) - Teachers offering tuition
4. **Guardian** (type=4) - Parents/students seeking tutors
5. **Tuition Partner** (type=5) - Agents who post on behalf of guardians and earn commission

## Installation Steps

### Prerequisites
Make sure you have installed:
- PHP 8.1 or higher
- Composer
- Node.js & NPM
- MySQL
- Git

### Step 1: Install Dependencies

```bash
# Install PHP dependencies
composer install

# Install Node dependencies  
npm install
```

### Step 2: Environment Configuration

```bash
# Copy environment file
copy .env.example .env

# Generate application key
php artisan key:generate
```

### Step 3: Configure Database

Edit `.env` file and set your database credentials:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=findtutors
DB_USERNAME=root
DB_PASSWORD=your_password
```

### Step 4: Configure Email (Gmail SMTP)

Edit `.env` file:

```
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="noreply@findtutors.com"
MAIL_FROM_NAME="Find Tutors"
```

**Note:** Use Gmail App Password, not your regular password.
Generate one at: https://myaccount.google.com/apppasswords

### Step 5: Run Migrations & Seeders

```bash
# Run migrations
php artisan migrate

# Run seeders (creates default admin, areas, subjects, etc.)
php artisan db:seed
```

### Step 6: Create Storage Link

```bash
php artisan storage:link
```

### Step 7: Build Assets

```bash
# Development
npm run dev

# Production
npm run build
```

### Step 8: Start Development Server

```bash
php artisan serve
```

Visit: http://localhost:8000

## Default Admin Credentials

After running seeders, you can login as Super Admin:

- **Email:** admin@findtutors.com
- **Password:** Admin@123

## Project Structure

```
findtutors/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Auth/
│   │   │   ├── Admin/
│   │   │   ├── Tutor/
│   │   │   ├── Guardian/
│   │   │   └── Partner/
│   │   └── Middleware/
│   ├── Models/
│   ├── Helpers/
│   │   └── helpers.php
│   └── Services/
├── config/
│   └── findtutors.php (Custom configuration)
├── database/
│   ├── migrations/
│   └── seeders/
├── resources/
│   └── views/
│       ├── auth/
│       ├── admin/
│       ├── tutor/
│       ├── guardian/
│       └── partner/
└── routes/
    └── web.php
```

## Key Features

### 1. User Registration & Approval System
- Users select type during registration (Tutor/Guardian/Partner)
- Email verification required
- Admin approval required for all profiles
- Profile completion forms based on user type

### 2. Tuition Flow
```
Guardian/Partner Posts → Tutors Apply → Guardian/Partner Accepts → Both Confirm → Tuition Active
```

### 3. Commission System (Partners Only)
- Partners earn commission on successful tuitions
- Platform fee (10%) deducted at payout
- Minimum payout: ৳1000
- Commission visible only to Partner & Admin

### 4. No Messaging/Connection System
- Simple direct application flow
- Contact info shared only after acceptance

## Development Commands

```bash
# Clear cache
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Create migration
php artisan make:migration create_table_name

# Create model
php artisan make:model ModelName -m

# Create controller
php artisan make:controller ControllerName

# Create seeder
php artisan make:seeder SeederName

# Run specific seeder
php artisan db:seed --class=SeederName
```

## Next Steps

Follow the phase-by-phase implementation:
1. ✅ Phase 1: Project Initialization (COMPLETE)
2. Phase 2: Database & Models
3. Phase 3: Authentication System
4. Phase 4: Tutor Module
5. Phase 5: Guardian Module
6. Phase 6: Partner Module
7. Phase 7: Admin Module

## Support

For questions or issues, refer to the detailed prompts provided in the project documentation.
