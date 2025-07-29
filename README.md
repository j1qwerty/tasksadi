# Laravel Task Manager with Firebase Authentication

A simple task management application built with Laravel, Firebase Authentication, jQuery, and MySQL.

## Features

- **Firebase Authentication** - Email/password login with automatic user creation
- **Role-based Access** - Admin and User roles with different capabilities
- **Task Management** - Create, view, update, delete, and assign tasks
- **Dynamic UI** - jQuery-powered interface with search and filtering
- **Responsive Design** - Bootstrap-based responsive layout

## User Capabilities

### Admin Users
- View and manage all tasks
- Create, edit, and delete tasks
- Assign tasks to users
- Manage user roles (promote/demote)
- View dashboard statistics

### Regular Users
- View assigned tasks
- Mark tasks as completed
- Search and filter personal tasks
- View personal dashboard statistics

## Setup Instructions

### 1. Prerequisites
- PHP 8.2+
- MySQL 5.7+
- Composer
- Node.js (optional, for asset compilation)

### 2. Installation

```bash
# Clone or download the project
cd your-project-directory

# Install PHP dependencies
composer install

# Create database
mysql -u root -e "CREATE DATABASE IF NOT EXISTS tasks2;"

# Configure environment
cp .env.example .env
# Update .env with your database credentials and Firebase config

# Run migrations and seed data
php artisan migrate:fresh --seed

# Generate application key
php artisan key:generate

# Start the development server
php artisan serve
```

### 3. Firebase Setup

1. Create a Firebase project at https://console.firebase.google.com
2. Enable Authentication > Email/Password
3. Get your Firebase config from Project Settings
4. Update the Firebase variables in your `.env` file

### 4. Default Test Accounts

After seeding, these accounts are available:

- **Admin**: admin@tasks.com / password123
- **User 1**: john@tasks.com / password123  
- **User 2**: jane@tasks.com / password123

## Database Structure

### Users Table
- `id` - Primary key
- `name` - User's full name
- `email` - Email address (unique)
- `password` - Hashed password
- `firebase_uid` - Firebase user ID (nullable)
- `role` - enum('admin', 'user')
- `created_at`, `updated_at` - Timestamps

### Tasks Table
- `id` - Primary key
- `title` - Task title
- `description` - Task description
- `status` - enum('pending', 'in_progress', 'completed')
- `assigned_to` - Foreign key to users table
- `created_at`, `updated_at` - Timestamps

## API Endpoints

### Authentication
- `POST /api/auth/firebase-login` - Login with Firebase

### User APIs
- `GET /api/get-tasks` - Get user's assigned tasks
- `POST /api/tasks/{id}/complete` - Mark task as completed

### Admin APIs
- `GET /api/admin/stats` - Dashboard statistics
- `GET /api/admin/users` - All users
- `GET /api/admin/tasks` - All tasks
- `POST /api/admin/tasks` - Create task
- `PUT /api/admin/tasks/{id}` - Update task
- `DELETE /api/admin/tasks/{id}` - Delete task
- `PUT /api/admin/users/{id}/role` - Update user role

## Technology Stack

- **Backend**: Laravel 12.x, MySQL
- **Frontend**: Blade Templates, jQuery, Bootstrap 5
- **Authentication**: Firebase Auth Web SDK
- **Icons**: Font Awesome 6
- **Styling**: Bootstrap 5 + Custom CSS

## File Structure

```
app/
├── Http/Controllers/
│   ├── AuthController.php
│   ├── DashboardController.php
│   └── AdminController.php
├── Models/
│   ├── User.php
│   └── Task.php
resources/views/
├── layouts/app.blade.php
├── auth/login.blade.php
├── dashboard/
│   ├── user.blade.php
│   └── admin.blade.php
└── partials/
    ├── admin-modals.blade.php
    └── admin-scripts.blade.php
```

## Development Notes

- All JavaScript is inline for simplicity
- CSRF protection enabled for all forms
- Session-based authentication for Laravel
- Firebase UID stored for user matching
- Bootstrap classes used for responsive design
- jQuery used for AJAX calls and DOM manipulation

## License

Open source - Educational/Portfolio project

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
