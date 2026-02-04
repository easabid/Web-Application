# Pre-Deployment Checklist

## ✅ Files Created for Deployment

### Configuration Files
- [x] `Procfile` - Railway/Heroku deployment config
- [x] `railway.json` - Railway build & deploy settings
- [x] `nixpacks.toml` - Build configuration
- [x] `.gitignore` - Git ignore rules
- [x] `public/.htaccess` - Apache URL rewriting
- [x] `public/index.php` - Application entry point
- [x] `.env.production` - Production environment template
- [x] `DEPLOYMENT.md` - Complete deployment guide
- [x] `README.md` - Updated project documentation

### Composer Updates
- [x] Added post-install storage link script
- [x] Added production cache scripts

## 🔑 Before Pushing to GitHub

### 1. Generate APP_KEY
Run this locally (if PHP is installed):
```bash
php artisan key:generate --show
```

Or use online generator:
- Go to: https://generate-random.org/laravel-key-generator
- Copy the generated key (starts with `base64:`)
- Save it for Railway deployment

### 2. Create GitHub Repository
```bash
# On GitHub.com, create new repository named: find-tutors-platform
# Then run locally:
git init
git add .
git commit -m "Initial commit - Find Tutors Platform v1.0"
git branch -M main
git remote add origin https://github.com/YOUR_USERNAME/find-tutors-platform.git
git push -u origin main
```

### 3. Setup Gmail App Password
1. Go to https://myaccount.google.com/security
2. Enable 2-Step Verification
3. Search "App passwords"
4. Generate password for "Mail"
5. Save the 16-character password for deployment

## 🚀 Railway Deployment Steps

### 1. Sign Up & Connect GitHub
- Go to https://railway.app
- Sign in with GitHub
- Authorize Railway to access repositories

### 2. Create New Project
- Click "New Project"
- Select "Deploy from GitHub repo"
- Choose: `find-tutors-platform`
- Railway auto-detects Laravel

### 3. Add MySQL Database
- Click "New" in your project
- Select "Database" → "MySQL"
- Railway creates database automatically
- Connection variables auto-populated

### 4. Configure Environment Variables

Click your service → "Variables" → Add these:

**Critical Variables:**
```env
APP_NAME=Find Tutors
APP_ENV=production
APP_KEY=base64:YOUR_GENERATED_KEY_FROM_STEP_1
APP_DEBUG=false
APP_URL=https://your-service-name.up.railway.app
```

**Database (Railway Auto-fills):**
```env
DB_CONNECTION=mysql
DB_HOST=${{MYSQL.MYSQLHOST}}
DB_PORT=${{MYSQL.MYSQLPORT}}
DB_DATABASE=${{MYSQL.MYSQLDATABASE}}
DB_USERNAME=${{MYSQL.MYSQLUSER}}
DB_PASSWORD=${{MYSQL.MYSQLPASSWORD}}
```

**Email (Use Your Gmail):**
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-16-char-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@findtutors.com
MAIL_FROM_NAME=Find Tutors
```

**Session & Cache:**
```env
SESSION_DRIVER=database
CACHE_DRIVER=database
QUEUE_CONNECTION=database
```

**App Settings:**
```env
TIMEZONE=Asia/Dhaka
PLATFORM_FEE_PERCENTAGE=10
MINIMUM_PAYOUT_AMOUNT=1000
TUITION_POST_EXPIRY_DAYS=30
MAX_PROFILE_PHOTO_SIZE=2048
MAX_DOCUMENT_SIZE=5120
```

### 5. Deploy!
- Railway automatically builds and deploys
- Check "Deployments" tab for logs
- Wait 3-5 minutes for first deployment
- Visit generated URL

### 6. First Time Setup
Once deployed:
1. Visit your Railway URL
2. Click "Register"
3. First user becomes Super Admin
4. Verify email (check inbox/spam)
5. Complete profile
6. Test all features!

## 📋 Post-Deployment Testing

### Test User Registration
- [ ] Register as Tutor
- [ ] Register as Guardian  
- [ ] Register as Partner
- [ ] Verify email arrives
- [ ] Login works

### Test Tutor Flow
- [ ] Complete profile (4 steps)
- [ ] Profile submitted for approval
- [ ] Browse tuition posts
- [ ] Apply to post
- [ ] View application status

### Test Guardian Flow
- [ ] Complete profile
- [ ] Create tuition post
- [ ] View applications
- [ ] Accept application
- [ ] Confirm tuition
- [ ] Review tutor

### Test Partner Flow
- [ ] Complete profile
- [ ] Create commission post
- [ ] View commission earnings
- [ ] Request payout

### Test Admin Flow
- [ ] Approve profiles
- [ ] Verify tuitions
- [ ] Approve commissions
- [ ] Process payouts

## 🐛 Common Issues & Fixes

### Issue: 500 Error on Railway
**Fix:**
- Check Railway logs (Deployments → Logs)
- Ensure APP_KEY is set correctly
- Verify all environment variables

### Issue: Database Connection Failed
**Fix:**
- Ensure MySQL service is running
- Check DB_* variables match Railway MySQL
- Try redeploying

### Issue: Emails Not Sending
**Fix:**
- Verify Gmail 2FA enabled
- Regenerate App Password
- Check MAIL_* variables
- Look in spam folder

### Issue: File Upload Fails
**Fix:**
- Railway automatically handles storage
- Check MAX_* variables in env
- Verify file permissions in code

### Issue: Routes Not Working
**Fix:**
```bash
# In Railway console:
php artisan route:clear
php artisan config:clear
php artisan cache:clear
```

## 📊 Monitoring

### Railway Dashboard
- View real-time logs
- Monitor resource usage
- Check deployment history
- View metrics

### Application Logs
Access via Railway console:
```bash
php artisan log:clear
tail -f storage/logs/laravel.log
```

## 💾 Database Backup

### Export from Railway
1. Go to MySQL service
2. Click "Data" tab
3. Use provided connection details
4. Export via MySQL client

### Scheduled Backups (Later)
Consider:
- Railway backup plugins
- Automated scripts
- External backup services

## 🔄 Updates & Redeployment

### Push Updates
```bash
git add .
git commit -m "Update: description"
git push origin main
```
Railway auto-redeploys!

### Manual Redeploy
- Go to Deployments
- Click "Deploy Latest"

## 🎯 Next Steps After Testing

### 1. Custom Domain (Optional)
- Railway Settings → Domains
- Add custom domain
- Update DNS records
- Update APP_URL

### 2. Production Migration Plan
Once fully tested:
- Export database
- Download code
- Setup production hosting
- Import database
- Configure environment
- Test thoroughly
- Update DNS

### 3. Premium Hosting Options
For production:
- **Cloudways** (Managed Laravel hosting)
- **DigitalOcean** (VPS with good Laravel docs)
- **AWS Lightsail** (Simple VPS)
- **Namecheap Shared** (Budget option)

## 📞 Support Resources

### Railway Support
- Docs: https://docs.railway.app
- Discord: Railway Community
- Status: https://railway.app/status

### Laravel Resources
- Docs: https://laravel.com/docs/10.x
- Forums: https://laracasts.com/discuss
- Discord: Laravel Community

## ✅ Final Checklist

Before pushing to GitHub:
- [ ] All files created and saved
- [ ] APP_KEY generated and saved
- [ ] Gmail App Password ready
- [ ] GitHub repository created
- [ ] Railway account created
- [ ] Read DEPLOYMENT.md completely

Ready to deploy:
- [ ] Code committed to Git
- [ ] Pushed to GitHub
- [ ] Railway project created
- [ ] MySQL database added
- [ ] Environment variables set
- [ ] First deployment successful
- [ ] URL accessible
- [ ] Registration tested
- [ ] Email delivery working

## 🎉 Success!

Once all checkboxes are complete, your Find Tutors platform is live!

Share your Railway URL and start testing all features thoroughly before migrating to production hosting.

**Estimated Time:** 15-30 minutes for complete deployment
**Cost:** Free (Railway $5 credit monthly)
