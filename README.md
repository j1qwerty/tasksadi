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


### Installation

```bash
cd your-project-directory

composer install

mysql -u root -e "CREATE DATABASE IF NOT EXISTS tasks2;"

cp .env.example .env

php artisan migrate:fresh --seed

php artisan key:generate

php artisan serve
```

### Firebase Setup

1. Create a Firebase project at https://console.firebase.google.com
2. Enable Authentication > Email/Password
3. Get your Firebase config from Project Settings
4. Update the Firebase variables in your `.env` file

### Default Test Accounts

After seeding, these accounts are available:

- **Admin**: admin@tasks.com / password123
- **User 1**: john@tasks.com / password123  
- **User 2**: jane@tasks.com / password123

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
