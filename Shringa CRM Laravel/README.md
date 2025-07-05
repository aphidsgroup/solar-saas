# 🏢 Shringa CRM - Complete Customer Relationship Management System

<p align="center">
  <img src="public/images/shringa-logo.png" width="200" alt="Shringa CRM Logo">
</p>

<p align="center">
  <a href="https://shringacrm.vercel.app" target="_blank">
    <img src="https://vercel.com/button" alt="Deploy with Vercel">
  </a>
</p>

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-11.x-red.svg" alt="Laravel Version">
  <img src="https://img.shields.io/badge/PHP-8.2+-blue.svg" alt="PHP Version">
  <img src="https://img.shields.io/badge/Tailwind-3.x-cyan.svg" alt="Tailwind CSS">
  <img src="https://img.shields.io/badge/License-MIT-green.svg" alt="License">
</p>

## 🚀 Quick Deploy

Deploy your own instance of Shringa CRM in minutes:

[![Deploy with Vercel](https://vercel.com/button)](https://vercel.com/new/clone?repository-url=https%3A%2F%2Fgithub.com%2FEarneyGit%2Fshringacrm)

## 📋 About Shringa CRM

Shringa CRM is a comprehensive Customer Relationship Management system built with Laravel 11 and featuring a modern, responsive design with a custom red color scheme (#880808). It's designed for interior design businesses, contractors, and service-based companies.

## ✨ Features

### 🏢 **Client Management**
- Complete client profiles with contact information
- Client status tracking (Active, Inactive, Prospect)
- Financial overview and project history
- Communication history tracking

### 🎯 **Lead Management**
- Lead capture and tracking
- Source attribution (Website, Referral, Social Media, etc.)
- Follow-up scheduling and reminders
- Lead conversion tracking

### 📊 **Project Management**
- Project lifecycle management
- Status tracking (Planning, In Progress, Completed, On Hold)
- Budget and timeline management
- Team assignment and collaboration

### 💰 **Quotations & Invoicing**
- Professional quotation generation
- Itemized billing with tax calculations
- Invoice tracking and payment status
- Automated payment reminders

### 📋 **Task Management**
- Task assignment and tracking
- Priority levels and due dates
- Team collaboration features
- Progress monitoring

### 📄 **Document Management**
- File upload and organization
- Document categorization
- Version control
- Secure file storage

### 📞 **Communication Logs**
- All client interactions in one place
- Email, phone, and meeting logs
- Communication history timeline
- Follow-up scheduling

### 📈 **Daily Reports**
- Activity summaries
- Performance metrics
- Team productivity tracking
- Automated report generation

### 🏗️ **Site Visit Management**
- Visit scheduling and tracking
- Location management
- Visit reports and photos
- Follow-up actions

### 👥 **User Management**
- Role-based access control
- Team member management
- Permission settings
- Activity logging

## 🎨 Design Features

- **Custom Red Theme (#880808)** - Professional and consistent branding
- **Responsive Design** - Works perfectly on desktop, tablet, and mobile
- **Modern UI/UX** - Clean, intuitive interface built with Tailwind CSS
- **Dark Mode Ready** - Prepared for dark mode implementation
- **Accessibility** - WCAG compliant design elements

## 🔧 Tech Stack

- **Backend:** Laravel 11 (PHP 8.2+)
- **Frontend:** Blade Templates + Tailwind CSS 3.x
- **Database:** MySQL (with SQLite fallback)
- **Authentication:** Laravel Breeze
- **File Storage:** Local/Cloud storage ready
- **Email:** SMTP/Log drivers
- **Cache:** File/Database/Redis support
- **Queue:** Database/Redis/Sync drivers

## 📦 Installation

### Local Development

1. **Clone the repository:**
```bash
git clone https://github.com/EarneyGit/shringacrm.git
cd shringacrm
```

2. **Install dependencies:**
```bash
composer install
npm install
```

3. **Environment setup:**
```bash
cp .env.example .env
php artisan key:generate
```

4. **Database setup:**
```bash
php artisan migrate
php artisan db:seed
```

5. **Build assets:**
```bash
npm run build
```

6. **Start the server:**
```bash
php artisan serve
```

### Vercel Deployment

1. **Deploy to Vercel:**
   - Click the "Deploy with Vercel" button above
   - Connect your GitHub account
   - Configure environment variables (see DEPLOYMENT.md)

2. **Environment Variables:**
   - Copy variables from `DEPLOYMENT.md`
   - Set `APP_KEY=base64:VQuaswEMbnGKGEQWFieSlr8N9TkPpAy22GNeAijIgOg=`
   - Configure database connection (optional)

## 🔐 Default Login Credentials

**Admin Access:**
- **Email:** `admin@shringa.com`
- **Password:** `password123`

**Alternative Admin:**
- **Email:** `admin@shringacrm.com`
- **Password:** `password`

## 📚 Documentation

- [Deployment Guide](DEPLOYMENT.md) - Comprehensive deployment instructions
- [User Guide](docs/user-guide.md) - End-user documentation
- [Developer Guide](docs/developer.md) - Development and customization

## 🤝 Contributing

We welcome contributions! Please see our [Contributing Guide](CONTRIBUTING.md) for details.

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Add tests if applicable
5. Submit a pull request

## 📄 License

This project is open-sourced software licensed under the [MIT license](LICENSE).

## 🆘 Support

- **Documentation:** Check our comprehensive docs
- **Issues:** [GitHub Issues](https://github.com/EarneyGit/shringacrm/issues)
- **Discussions:** [GitHub Discussions](https://github.com/EarneyGit/shringacrm/discussions)
- **Email:** support@earney.in

## 🏆 Credits

Built with ❤️ by [Earney](https://earney.in)

- **Framework:** [Laravel](https://laravel.com)
- **UI Framework:** [Tailwind CSS](https://tailwindcss.com)
- **Icons:** [Heroicons](https://heroicons.com)
- **Hosting:** [Vercel](https://vercel.com)

---

<p align="center">
  <strong>Ready to manage your business relationships better?</strong><br>
  <a href="https://shringacrm.vercel.app">Try Shringa CRM Today!</a>
</p>
