# Find Tutors - Deployment Guide

## Prerequisites
- GitHub account
- Railway.app account (or other hosting)
- Gmail account for email notifications

## Railway Deployment Steps

### 1. Push to GitHub
```bash
git init
git add .
git commit -m "Initial commit - Find Tutors Platform"
git branch -M main
git remote add origin YOUR_GITHUB_REPO_URL
git push -u origin main
```

### 2. Deploy on Railway
1. Go to https://railway.app
2. Sign in with GitHub
3. Click "New Project"
4. Select "Deploy from GitHub repo"
5. Choose your repository
6. Railway will automatically detect Laravel

### 3. Add MySQL Database
1. Click "New" → "Database" → "MySQL"
2. Railway will create database and set variables automatically

### 4. Configure Environment Variables
In Railway dashboard, go to your service → Variables, and add:

```env
APP_NAME="Find Tutors"
APP_ENV=production
APP_KEY=base64:YOUR_GENERATED_KEY_HERE
APP_DEBUG=false
APP_URL=https://your-app.railway.app

# Database (Railway auto-fills these)
DB_CONNECTION=mysql
DB_HOST=${{MYSQL.MYSQLHOST}}
DB_PORT=${{MYSQL.MYSQLPORT}}
DB_DATABASE=${{MYSQL.MYSQLDATABASE}}
DB_USERNAME=${{MYSQL.MYSQLUSER}}
DB_PASSWORD=${{MYSQL.MYSQLPASSWORD}}

# Session & Cache
SESSION_DRIVER=database
CACHE_DRIVER=database
QUEUE_CONNECTION=database

# Email Configuration (Gmail)
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-gmail-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@findtutors.com
MAIL_FROM_NAME="Find Tutors"

# Application Settings
TIMEZONE=Asia/Dhaka
PLATFORM_FEE_PERCENTAGE=10
MINIMUM_PAYOUT_AMOUNT=1000
TUITION_POST_EXPIRY_DAYS=30

# File Upload Settings
MAX_PROFILE_PHOTO_SIZE=2048
MAX_DOCUMENT_SIZE=5120
```

### 5. Generate APP_KEY
Run locally before deployment:
```bash
php artisan key:generate --show
```
Copy the output and paste in Railway's APP_KEY variable.

### 6. Gmail App Password Setup
1. Go to Google Account → Security
2. Enable 2-Step Verification
3. Go to App Passwords
4. Generate password for "Mail"
5. Use this password in MAIL_PASSWORD

### 7. Deploy!
- Railway will automatically build and deploy
- Check deployment logs
- Visit your app URL

## Post-Deployment

### First Time Setup
1. Visit your app URL
2. Register as Super Admin (first user)
3. Log in and complete profile
4. Test email verification
5. Create test data

### Testing Checklist
- [ ] User registration works
- [ ] Email verification arrives
- [ ] Login/logout works
- [ ] Profile creation works
- [ ] Dashboard loads
- [ ] File uploads work
- [ ] Database connections work
- [ ] Tutor can apply to posts
- [ ] Guardian can create posts
- [ ] Partner commission tracking
- [ ] Admin approval workflows
- [ ] Payout requests work

## Custom Domain (Optional)
1. In Railway, go to Settings → Domains
2. Click "Add Domain"
3. Follow DNS configuration instructions
4. Update APP_URL in environment variables

## Troubleshooting

### Issue: 500 Error
- Check Railway logs
- Ensure APP_KEY is set
- Verify database connection
- Check file permissions

### Issue: Emails not sending
- Verify Gmail app password
- Check MAIL_* variables
- Ensure 2FA enabled on Gmail
- Check spam folder

### Issue: File uploads fail
- Run `php artisan storage:link`
- Check storage permissions
- Verify MAX_UPLOAD_SIZE

### Issue: Database not found
- Ensure MySQL service is running
- Check DB_* variables match MySQL service
- Run migrations manually

## Manual Commands (if needed)

Access Railway shell and run:
```bash
php artisan migrate --force
php artisan db:seed --force
php artisan storage:link
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
```

## Migration to Production Hosting

When ready to move to your domain:

1. Export database from Railway
2. Set up production server (cPanel/VPS)
3. Upload files via Git or FTP
4. Import database
5. Update .env with production credentials
6. Run migrations
7. Test thoroughly
8. Update DNS to point to new server

## Support
For issues, check:
- Railway logs
- Laravel logs (storage/logs)
- Browser console for JS errors
- Network tab for failed requests

## Security Notes
- Never commit .env file
- Use strong APP_KEY
- Enable HTTPS in production
- Regular database backups
- Keep Laravel updated
- Monitor error logs
