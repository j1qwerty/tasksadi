<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Task Manager')</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        .loading-spinner {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 9999;
        }
        
        .navbar-brand {
            font-weight: bold;
        }
        
        .card {
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            border: 1px solid rgba(0, 0, 0, 0.125);
        }
        
        .btn {
            border-radius: 0.375rem;
        }
        
        .status-badge {
            font-size: 0.875rem;
        }
        
        .table th {
            border-top: none;
            font-weight: 600;
            color: #495057;
        }
        
        .main-content {
            min-height: calc(100vh - 76px);
            background-color: #f8f9fa;
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="{{ auth()->check() ? (auth()->user()->isAdmin() ? '/admin/dashboard' : '/dashboard') : '/' }}">
                <i class="fas fa-tasks me-2"></i>Task Manager
            </a>
            
            @auth
            <div class="navbar-nav ms-auto">
                <div class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                        <i class="fas fa-user me-1"></i>{{ auth()->user()->name }}
                        @if(auth()->user()->isAdmin())
                            <span class="badge bg-warning ms-1">Admin</span>
                        @endif
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        @if(auth()->user()->isAdmin())
                            <li><a class="dropdown-item" href="/admin/dashboard">
                                <i class="fas fa-crown me-2"></i>Admin Dashboard
                            </a></li>
                            <li><a class="dropdown-item" href="/dashboard">
                                <i class="fas fa-user me-2"></i>User Dashboard
                            </a></li>
                            <li><hr class="dropdown-divider"></li>
                        @endif
                        <li>
                            <a class="dropdown-item" href="#" onclick="logout()">
                                <i class="fas fa-sign-out-alt me-2"></i>Logout
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            @endauth
        </div>
    </nav>

    <!-- Main Content -->
    <main class="main-content">
        <div class="container py-4">
            @yield('content')
        </div>
    </main>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Firebase SDK -->
    <script type="module">
        import { initializeApp } from "https://www.gstatic.com/firebasejs/12.0.0/firebase-app.js";
        import { getAuth } from "https://www.gstatic.com/firebasejs/12.0.0/firebase-auth.js";
        
        const firebaseConfig = {
            apiKey: "{{ env('VITE_FIREBASE_API_KEY') }}",
            authDomain: "{{ env('VITE_FIREBASE_AUTH_DOMAIN') }}",
            projectId: "{{ env('VITE_FIREBASE_PROJECT_ID') }}",
            storageBucket: "{{ env('VITE_FIREBASE_STORAGE_BUCKET') }}",
            messagingSenderId: "{{ env('VITE_FIREBASE_MESSAGING_SENDER_ID') }}",
            appId: "{{ env('VITE_FIREBASE_APP_ID') }}",
            measurementId: "{{ env('VITE_FIREBASE_MEASUREMENT_ID') }}"
        };
        
        const app = initializeApp(firebaseConfig);
        window.firebaseAuth = getAuth(app);
    </script>

    <!-- Common Scripts -->
    <script>
        // CSRF Token Setup
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Logout function
        function logout() {
            if (confirm('Are you sure you want to logout?')) {
                $.post('/logout', function(response) {
                    if (response.success) {
                        // Sign out from Firebase
                        if (window.firebaseAuth) {
                            window.firebaseAuth.signOut();
                        }
                        window.location.href = '/login';
                    }
                });
            }
        }

        // Show loading spinner
        function showLoading(message = 'Loading...') {
            const spinner = `
                <div class="loading-spinner" id="global-spinner">
                    <div class="text-center">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <p class="mt-2">${message}</p>
                    </div>
                </div>
            `;
            $('body').append(spinner);
        }

        // Hide loading spinner
        function hideLoading() {
            $('#global-spinner').remove();
        }
    </script>

    @yield('scripts')
</body>
</html>
