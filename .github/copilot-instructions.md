<!-- Use this file to provide workspace-specific custom instructions to Copilot. For more details, visit https://code.visualstudio.com/docs/copilot/copilot-customization#_use-a-githubcopilotinstructionsmd-file -->

# Laravel Task Manager Project Instructions

This is a Laravel-based task management application with Firebase Authentication integration.

## Project Structure
- **Backend**: Laravel 12.x with MySQL database
- **Frontend**: Blade templates with jQuery and Bootstrap 5
- **Authentication**: Firebase Auth Web SDK integrated with Laravel sessions
- **API**: RESTful APIs for task and user management

## Key Features
- Firebase email/password authentication
- Role-based access control (admin/user)
- Task CRUD operations with assignment
- Real-time UI updates with jQuery
- Responsive design with Bootstrap

## Development Guidelines
- Keep JavaScript inline in Blade templates for simplicity
- Use Bootstrap classes for styling
- Follow Laravel naming conventions
- Implement proper CSRF protection
- Use Eloquent relationships for data access
- Maintain clean separation between admin and user functionality

## Database Schema
- **users**: id, name, email, password, firebase_uid, role, timestamps
- **tasks**: id, title, description, status, assigned_to, timestamps

## Authentication Flow
1. User logs in via Firebase
2. Firebase user data sent to Laravel
3. Laravel creates/updates user record
4. Session-based authentication for subsequent requests
