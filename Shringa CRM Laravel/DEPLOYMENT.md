# Shringa CRM - Vercel Deployment Guide

## 🚀 One-Click Deploy to Vercel

[![Deploy with Vercel](https://vercel.com/button)](https://vercel.com/new/clone?repository-url=https%3A%2F%2Fgithub.com%2FEarneyGit%2Fshringacrm)

## 📋 Required Environment Variables for Vercel

**COPY AND PASTE THESE INTO VERCEL DASHBOARD:**

```
APP_NAME=Shringa CRM
APP_ENV=production
APP_KEY=base64:VQuaswEMbnGKGEQWFieSlr8N9TkPpAy22GNeAijIgOg=
APP_DEBUG=false
APP_URL=https://shringacrm.vercel.app
APP_TIMEZONE=UTC

SESSION_DRIVER=file
CACHE_STORE=file
QUEUE_CONNECTION=sync

LOG_CHANNEL=stack
LOG_LEVEL=error

MAIL_MAILER=log
MAIL_FROM_ADDRESS=noreply@shringacrm.vercel.app
MAIL_FROM_NAME=Shringa CRM
```

## 🗄️ Database Configuration (Optional)

For full functionality, add a MySQL database:

```
DB_CONNECTION=mysql
DB_HOST=your-database-host
DB_PORT=3306
DB_DATABASE=shringa_crm
DB_USERNAME=your-username
DB_PASSWORD=your-password
```

**Recommended Database Services:**
- [PlanetScale](https://planetscale.com) - Free MySQL database
- [Railway](https://railway.app) - Simple database hosting
- [Supabase](https://supabase.com) - PostgreSQL alternative

## 🔧 Step-by-Step Deployment

### 1. Deploy to Vercel
- Go to [Vercel Dashboard](https://vercel.com/dashboard)
- Click "New Project"
- Import from GitHub: `EarneyGit/shringacrm`
- Click "Deploy"

### 2. Set Environment Variables
- Go to Project Settings → Environment Variables
- Add all variables from the list above
- Click "Save"

### 3. Redeploy
- Go to Deployments tab
- Click "Redeploy" on the latest deployment

### 4. Access Your CRM
- Your CRM will be available at: `https://your-project-name.vercel.app`

## 🔐 Default Login Credentials

**Admin Access:**
- **Email:** `admin@shringa.com`
- **Password:** `password123`

**Alternative Admin:**
- **Email:** `admin@shringacrm.com`
- **Password:** `password`

## ✅ Features Included

- ✅ Complete CRM with red color scheme (#880808)
- ✅ **Client Management** - Add, edit, view clients
- ✅ **Lead Tracking** - Manage leads and follow-ups
- ✅ **Project Management** - Track project progress
- ✅ **Quotations & Invoices** - Generate quotes and invoices
- ✅ **Task Management** - Assign and track tasks
- ✅ **Document Management** - Upload and organize files
- ✅ **Communication Logs** - Track all client communications
- ✅ **Daily Reports** - Generate daily activity reports
- ✅ **Site Visit Management** - Schedule and track site visits
- ✅ **Role-based Access Control** - Different user permissions
- ✅ **Email Notifications** - Automated email alerts
- ✅ **Activity Logging** - Track all user actions
- ✅ **Responsive Design** - Works on all devices

## 🎨 Custom Branding

The CRM features a custom red color scheme (#880808) that's been applied consistently across:
- Navigation and menus
- Buttons and links
- Charts and graphs
- Status indicators
- Form elements

## 🔧 Troubleshooting

### Common Issues:

1. **500 Error:** Check that APP_KEY is set correctly
2. **Database Errors:** Verify database connection settings
3. **Assets Not Loading:** Ensure build files are properly deployed
4. **Login Issues:** Use the default credentials provided above

### Debug Steps:
1. Check Vercel Function logs in the dashboard
2. Verify all environment variables are set
3. Ensure the database is accessible (if using one)
4. Try redeploying the project

## 📞 Support

For deployment issues or customization requests:
- Repository: [GitHub - EarneyGit/shringacrm](https://github.com/EarneyGit/shringacrm)
- Issues: Create an issue on GitHub

## 📊 Tech Stack

- **Backend:** Laravel 11 (PHP 8.2)
- **Frontend:** Blade Templates + Tailwind CSS
- **Database:** MySQL (optional for demo)
- **Hosting:** Vercel
- **Authentication:** Laravel Breeze
- **File Storage:** Local/Cloud storage ready

---

**Ready to deploy? Click the Deploy button above or follow the manual steps!** 