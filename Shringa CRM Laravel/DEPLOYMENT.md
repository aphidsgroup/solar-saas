# Shringa CRM - Vercel Deployment Guide

## Quick Deploy to Vercel

1. **Fork or Clone this repository**
2. **Connect to Vercel**
3. **Set Environment Variables**
4. **Deploy**

## Environment Variables for Vercel

Set these in your Vercel dashboard:

```
APP_NAME=Shringa CRM
APP_ENV=production
APP_KEY=base64:GENERATE_YOUR_KEY_HERE
APP_DEBUG=false
APP_URL=https://your-domain.vercel.app

DB_CONNECTION=mysql
DB_HOST=your-database-host
DB_PORT=3306
DB_DATABASE=shringa_crm
DB_USERNAME=your-username
DB_PASSWORD=your-password

SESSION_DRIVER=database
CACHE_STORE=database
QUEUE_CONNECTION=database

MAIL_MAILER=smtp
MAIL_HOST=your-smtp-host
MAIL_PORT=587
MAIL_USERNAME=your-email
MAIL_PASSWORD=your-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@yourdomain.com
MAIL_FROM_NAME=Shringa CRM
```

## Database Setup

1. Create a MySQL database
2. Run migrations: `php artisan migrate`
3. Seed database: `php artisan db:seed`

## Features

- ✅ Complete CRM with red color scheme (#880808)
- ✅ Client Management
- ✅ Lead Tracking
- ✅ Project Management
- ✅ Quotations & Invoices
- ✅ Task Management
- ✅ Document Management
- ✅ Communication Logs
- ✅ Daily Reports
- ✅ Site Visit Management
- ✅ Role-based Access Control
- ✅ Email Notifications
- ✅ Activity Logging

## Default Login Credentials

**Admin:**
- Email: admin@shringa.com
- Password: password123

**Alternative Admin:**
- Email: admin@shringacrm.com
- Password: password

## Support

For deployment issues, contact the development team. 