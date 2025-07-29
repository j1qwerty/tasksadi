@extends('layouts.app')

@section('title', 'Register - Task Manager')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6 col-lg-4">
        <div class="card">
            <div class="card-header text-center">
                <h4><i class="fas fa-user-plus me-2"></i>Register</h4>
                <p class="text-muted mb-0">Create your Firebase account</p>
            </div>
            <div class="card-body">
                <form id="register-form">
                    <div class="mb-3">
                        <label for="register-name" class="form-label">Full Name</label>
                        <input type="text" class="form-control" id="register-name" required>
                    </div>
                    <div class="mb-3">
                        <label for="register-email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="register-email" required>
                    </div>
                    <div class="mb-3">
                        <label for="register-password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="register-password" required>
                    </div>
                    <div class="mb-3">
                        <label for="confirm-password" class="form-label">Confirm Password</label>
                        <input type="password" class="form-control" id="confirm-password" required>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-user-plus me-2"></i>Register
                        </button>
                    </div>
                </form>
                
                <div class="text-center mt-3">
                    <small class="text-muted">
                        Already have an account? 
                        <a href="/login" class="text-decoration-none">Login here</a>
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Loading Spinner -->
<div class="loading-spinner" id="register-loading" style="display: none;">
    <div class="text-center">
        <div class="spinner-border text-success" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
        <p class="mt-2">Creating account...</p>
    </div>
</div>
@endsection

@section('scripts')
<script type="module">
    import { createUserWithEmailAndPassword } from "https://www.gstatic.com/firebasejs/12.0.0/firebase-auth.js";
    
    $(document).ready(function() {
        $('#register-form').on('submit', function(e) {
            e.preventDefault();
            
            const name = $('#register-name').val();
            const email = $('#register-email').val();
            const password = $('#register-password').val();
            const confirmPassword = $('#confirm-password').val();
            
            // Validate password match
            if (password !== confirmPassword) {
                alert('Passwords do not match');
                return;
            }
            
            if (password.length < 6) {
                alert('Password must be at least 6 characters long');
                return;
            }
            
            $('#register-loading').show();
            
            // Create Firebase account
            createUserWithEmailAndPassword(window.firebaseAuth, email, password)
                .then((userCredential) => {
                    const user = userCredential.user;
                    
                    // Send user data to Laravel
                    $.ajax({
                        url: '/api/auth/firebase-register',
                        method: 'POST',
                        data: {
                            firebase_uid: user.uid,
                            email: user.email,
                            name: name
                        },
                        success: function(response) {
                            if (response.success) {
                                alert('Account created successfully!');
                                window.location.href = response.redirect;
                            }
                        },
                        error: function(xhr) {
                            const response = xhr.responseJSON;
                            alert('Registration failed: ' + (response.message || 'Unknown error'));
                            $('#register-loading').hide();
                        }
                    });
                })
                .catch((error) => {
                    alert('Firebase registration failed: ' + error.message);
                    $('#register-loading').hide();
                });
        });
    });
</script>
@endsection
