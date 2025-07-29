@extends('layouts.app')

@section('title', 'Login - Task Manager')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6 col-lg-4">
        <div class="card">
            <div class="card-header text-center">
                <h4><i class="fas fa-sign-in-alt me-2"></i>Login</h4>
                <p class="text-muted mb-0">Sign in with your Firebase account</p>
            </div>
            <div class="card-body">
                <form id="login-form">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" required>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-sign-in-alt me-2"></i>Login
                        </button>
                    </div>
                </form>
                
                <div class="text-center mt-3">
                    <small class="text-muted">
                        Use these test accounts:<br>
                        <strong>Admin:</strong> admin@tasks.com / password123<br>
                        <strong>User:</strong> user1@tasks.com / password123<br>
                        <strong>User:</strong> user2@tasks.com / password123<br>
                        <strong>User:</strong> user3@tasks.com / password123
                    </small>
                </div>
                
                <div class="text-center mt-2">
                    <small class="text-muted">
                        Don't have an account? 
                        <a href="/register" class="text-decoration-none">Register here</a>
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Loading Spinner -->
<div class="loading-spinner" id="login-loading" style="display: none;">
    <div class="text-center">
        <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
        <p class="mt-2">Authenticating...</p>
    </div>
</div>
@endsection

@section('scripts')
<script type="module">
    import { signInWithEmailAndPassword } from "https://www.gstatic.com/firebasejs/12.0.0/firebase-auth.js";
    
    $(document).ready(function() {
        $('#login-form').on('submit', function(e) {
            e.preventDefault();
            
            const email = $('#email').val();
            const password = $('#password').val();
            
            $('#login-loading').show();
            
            // First, try to sign in with Firebase
            signInWithEmailAndPassword(window.firebaseAuth, email, password)
                .then((userCredential) => {
                    const user = userCredential.user;
                    
                    // Send Firebase user data to Laravel
                    $.ajax({
                        url: '/api/auth/firebase-login',
                        method: 'POST',
                        data: {
                            firebase_uid: user.uid,
                            email: user.email,
                            name: user.displayName || user.email.split('@')[0]
                        },
                        success: function(response) {
                            if (response.success) {
                                window.location.href = response.redirect;
                            }
                        },
                        error: function(xhr) {
                            const response = xhr.responseJSON;
                            alert('Laravel authentication failed: ' + (response.message || 'Unknown error'));
                            $('#login-loading').hide();
                        }
                    });
                })
                .catch((error) => {
                    // If Firebase auth fails, try to create account first
                    if (error.code === 'auth/user-not-found') {
                        // For demo purposes, create accounts with default password
                        import("https://www.gstatic.com/firebasejs/12.0.0/firebase-auth.js").then((auth) => {
                            auth.createUserWithEmailAndPassword(window.firebaseAuth, email, password)
                                .then((userCredential) => {
                                    const user = userCredential.user;
                                    
                                    // Send to Laravel
                                    $.ajax({
                                        url: '/api/auth/firebase-login',
                                        method: 'POST',
                                        data: {
                                            firebase_uid: user.uid,
                                            email: user.email,
                                            name: user.displayName || user.email.split('@')[0]
                                        },
                                        success: function(response) {
                                            if (response.success) {
                                                window.location.href = response.redirect;
                                            }
                                        },
                                        error: function(xhr) {
                                            const response = xhr.responseJSON;
                                            alert('Account creation failed: ' + (response.message || 'Unknown error'));
                                            $('#login-loading').hide();
                                        }
                                    });
                                })
                                .catch((createError) => {
                                    alert('Firebase error: ' + createError.message);
                                    $('#login-loading').hide();
                                });
                        });
                    } else {
                        alert('Firebase authentication failed: ' + error.message);
                        $('#login-loading').hide();
                    }
                });
        });
    });
</script>
@endsection
