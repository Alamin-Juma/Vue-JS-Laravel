# ⚡ Quick Start Guide - NXM Frontend Project

## 🚀 Get Running in 5 Minutes!

### Prerequisites Check
```bash
node --version  # Should be >= 20.19.0
php --version   # Should be >= 8.2
mysql --version # Should be >= 8.0
```

---

## 📦 OPTION 1: Quick Setup (No Docker)

### Step 1: Database Setup
```sql
-- Create database
CREATE DATABASE nxm_assessment_2023;

-- Or import the SQL dump
mysql -u root -p nxm_assessment_2023 < database_schema.sql
```

### Step 2: Backend Setup (Terminal 1)
```bash
cd api-laravel
composer install
cp .env.example .env
# Edit .env with your database credentials
php artisan key:generate
php artisan migrate
php artisan serve
# Backend running at http://localhost:8000
```

### Step 3: Frontend Setup (Terminal 2)
```bash
cd ui
npm install
# .env is already configured
npm run dev
# Frontend running at http://localhost:5173
```

### Step 4: Test It!
1. Open browser: `http://localhost:5173`
2. Click "Connect with Ben"
3. Fill the form and submit
4. Check database for new record!

---

## 🐳 OPTION 2: Docker Setup

```bash
cd api-laravel
docker-compose up -d
docker-compose exec app php artisan migrate

# In another terminal
cd ../ui
npm install
npm run dev
```

---

## ✅ Verification Checklist

### Backend is Working:
- [ ] `http://localhost:8000/api` returns Laravel welcome
- [ ] Database `nxm_assessment_2023` exists
- [ ] Table `form_submissions` exists
- [ ] `.env` file configured

### Frontend is Working:
- [ ] `http://localhost:5173` shows landing page
- [ ] "Connect with Ben" button exists
- [ ] Clicking button opens modal
- [ ] No console errors in DevTools

### Integration is Working:
- [ ] Fill form and submit
- [ ] See success message
- [ ] Check database: `SELECT * FROM form_submissions;`
- [ ] Record appears!

---

## 🔧 Troubleshooting

### Backend Issues

**Port 8000 already in use:**
```bash
php artisan serve --port=8080
# Update frontend .env: VITE_API_URL=http://localhost:8080/api
```

**Database connection failed:**
```bash
# Check .env file
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nxm_assessment_2023
DB_USERNAME=root
DB_PASSWORD=your_password
```

**Migration error:**
```bash
php artisan migrate:fresh
```

### Frontend Issues

**CORS errors:**
- Check `api-laravel/config/cors.php` has `'allowed_origins' => ['*']`
- Restart Laravel server

**API not connecting:**
- Check `ui/.env` has correct API URL
- Restart Vite dev server: `npm run dev`

**Port 5173 in use:**
```bash
# In ui/vite.config.ts, change port:
server: {
  port: 3000
}
```

---

## 🎯 Test the Form

### Valid Submission:
```
First Name: John
Last Name: Doe
Phone: +1234567890
Email: john.doe@example.com
☑ I'm not a robot

Result: Success message, modal closes, data in DB
```

### Invalid Submissions to Test:

**Missing fields:**
- Leave fields empty → See validation errors

**Invalid email:**
- Enter "notanemail" → See "Please enter a valid email"

**Invalid phone:**
- Enter "abc123xyz" → See "Please enter a valid phone number"

**Unchecked box:**
- Don't check "I'm not a robot" → See "You must agree to continue"

---

## 📊 Check Database

```sql
-- View all submissions
SELECT * FROM form_submissions ORDER BY created_at DESC;

-- Count submissions
SELECT COUNT(*) FROM form_submissions;

-- View recent submissions
SELECT first_name, last_name, email, created_at 
FROM form_submissions 
ORDER BY created_at DESC 
LIMIT 10;
```

---

## 🎥 Recording the Video?

### Pre-Recording Checklist:
```bash
# Clear database for clean demo
cd api-laravel
php artisan migrate:fresh

# Clear browser cache
# Ctrl+Shift+Delete (Chrome/Edge)
# Ctrl+Shift+Del (Firefox)

# Close unnecessary tabs
# Have Figma design ready
# Test form once to verify working
```

### During Recording:
1. Show landing page
2. Compare with Figma side-by-side
3. Test responsive (DevTools mobile view)
4. Demonstrate form validation
5. Submit valid form
6. Show database record
7. Show clean console (F12)
8. Test in Firefox/Edge

---

## 📝 API Testing (Optional)

### Using cURL:
```bash
# Test registration endpoint
curl -X POST http://localhost:8000/api/register \
  -H "Content-Type: application/json" \
  -d '{
    "firstName": "Jane",
    "lastName": "Smith",
    "phone": "+1987654321",
    "email": "jane.smith@example.com",
    "agreeToTerms": true
  }'

# Expected response:
# {"success":true,"message":"Thank you for registering!","data":{...}}
```

### Using Postman/Thunder Client:
```
POST http://localhost:8000/api/register
Content-Type: application/json

Body:
{
  "firstName": "Jane",
  "lastName": "Smith",
  "phone": "+1987654321",
  "email": "jane.smith@example.com",
  "agreeToTerms": true
}
```

---

## 🔍 Common Issues & Solutions

| Issue | Solution |
|-------|----------|
| White screen on frontend | Check console for errors, verify API URL in .env |
| Form doesn't submit | Check Laravel server is running, check network tab |
| CORS error | Restart Laravel server, check cors.php config |
| Database error | Verify credentials in .env, run migrations |
| Modal doesn't open | Check console, verify FormModal component imported |
| Validation not working | Hard refresh (Ctrl+F5), check RegistrationForm.vue |

---

## 🎨 Quick Visual Check

### What You Should See:

**Homepage:**
- ✅ "COLLAGEN IS THE FOUNTAIN OF YOUTH" in large blue text
- ✅ "Connect with Ben" button with avatar
- ✅ Three influencer cards
- ✅ Footer with links

**Modal (Click "Connect with Ben"):**
- ✅ White popup centered
- ✅ Image of person with phone on left
- ✅ "REGISTER TO learn more" title
- ✅ X button in top-right corner
- ✅ Form with 5 fields
- ✅ Blue "Register Now" button

**After Submit:**
- ✅ Green success message
- ✅ Modal closes after 2 seconds
- ✅ No console errors

---

## 📱 Test Responsive

```bash
# In Chrome DevTools
1. Press F12
2. Click Toggle Device Toolbar (Ctrl+Shift+M)
3. Select:
   - iPhone 12 Pro (390px)
   - iPad Air (820px)
   - Desktop (1920px)
4. Test form on each size
```

---

## 💾 Before Recording Video

```bash
# 1. Fresh database
cd api-laravel
php artisan migrate:fresh

# 2. Restart servers
# Terminal 1: php artisan serve
# Terminal 2: cd ../ui && npm run dev

# 3. Test one submission
# Open http://localhost:5173
# Click "Connect with Ben"
# Fill form
# Submit successfully

# 4. Ready to record! 🎥
```

---

## 📦 Create Submission ZIP

```bash
# In project root
# Ensure to exclude:
# - node_modules/
# - vendor/
# - .env (include .env.example)
# - .git/
# - dist/ or build/

# The ZIP should include:
# - ui/ folder
# - api-laravel/ folder
# - database_schema.sql
# - README.md
# - FRONTEND_VIDEO_SCRIPT.md
# - DEPLOYMENT_CHECKLIST.md
# - SUBMISSION_SUMMARY.md
# - .gitignore
```

---

## 🎊 You're Ready!

Everything is set up and working. Now you can:
1. ✅ Test all features
2. 📹 Record your video
3. 📤 Submit your work

**Good luck! 🚀**

---

## 📞 Need Help?

Check these files:
- `README.md` - Full documentation
- `SUBMISSION_SUMMARY.md` - Complete overview
- `FRONTEND_VIDEO_SCRIPT.md` - Recording guide
- `DEPLOYMENT_CHECKLIST.md` - Deployment steps

---

**Last Updated:** December 21, 2025
