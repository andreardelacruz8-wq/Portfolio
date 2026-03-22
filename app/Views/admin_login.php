<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AndengDC · login</title>
    <!-- soft & cozy purple palette -->
    <link rel="stylesheet" href="/assets/css/login.css">
    <style>
        /* Force labels to show with proper capitalization */
        .input-label span:last-child {
            text-transform: capitalize !important;
            font-size: 1rem !important;
        }
        
        /* Unified login styling */
        .unified-login-header {
            text-align: center;
            margin-bottom: 2rem;
        }
        
        .unified-login-header h2 {
            color: #ffffff;
            font-size: 1.5rem;
            font-weight: 300;
            margin-bottom: 0.5rem;
        }
        
        .unified-login-header p {
            color: #e4d0ff;
            font-size: 0.95rem;
        }
        
        .register-link {
            text-align: center;
            margin-top: 1.5rem;
            color: #e4d0ff;
        }
        
        .register-link a {
            color: #ffffff;
            text-decoration: underline;
            cursor: pointer;
            font-weight: 500;
        }
        
        .register-link a:hover {
            color: #b397d6;
        }
        
        /* Small note for users */
        .login-note {
            text-align: center;
            margin-top: 0.8rem;
            font-size: 0.85rem;
            color: #b397d6;
        }
    </style>
</head>
<body>
    <!-- cozy background orbs -->
    <div class="bg-orb orbs"></div>
    <div class="bg-orb orbs2"></div>
    
    <div class="login-wrapper">
        <div class="login-container">
            <!-- header with cozy branding -->
            <div class="login-header">
                <div class="logo-animation">
                    <span class="logo-code">{&nbsp;}</span>
                </div>
                <h1 class="login-greeting">Welcome back <span class="wave">👋</span></h1>
                <p class="login-subhead">Enter the cozy corner of Andrea's portfolio</p>
            </div>

            <!-- main login form -->
            <div class="login-box">
                <!-- Unified Login (No Tabs) -->
                <div class="unified-login-header">
                    <h2>Sign In</h2>
                    <p>Use your admin or viewer account</p>
                </div>
                
                <!-- Hidden field to indicate user type - will be determined by backend -->
                <input type="hidden" id="userType" name="userType" value="auto">
                
                <form id="loginForm" class="login-form">
                    <!-- username/email field -->
                    <div class="input-group">
                        <label for="username" class="input-label">
                            <span class="label-icon">👤</span>
                            <span id="usernameLabel">Username</span>
                        </label>
                        <div class="input-wrapper">
                            <input type="text" 
                                   id="username" 
                                   name="username" 
                                   class="form-input" 
                                   placeholder="andrea"
                                   autocomplete="off"
                                   required>
                            <span class="input-focus-border"></span>
                        </div>
                    </div>

                    <!-- password field -->
                    <div class="input-group">
                        <label for="password" class="input-label">
                            <span class="label-icon">🔐</span>
                            <span>Password</span>
                        </label>
                        <div class="input-wrapper password-wrapper">
                            <input type="password" 
                                   id="password" 
                                   name="password" 
                                   class="form-input" 
                                   placeholder="••••••••"
                                   required>
                            <button type="button" id="togglePassword" class="password-toggle" aria-label="Toggle password visibility">
                                <span class="toggle-icon">👁️</span>
                            </button>
                            <span class="input-focus-border"></span>
                        </div>
                    </div>

                    <!-- remember me & forgot password -->
                    <div class="login-options">
                        <label class="checkbox-label">
                            <input type="checkbox" id="remember" class="checkbox-input">
                            <span class="checkbox-custom"></span>
                            <span class="checkbox-text">Remember me</span>
                        </label>
                        <button type="button" id="forgotBtn" class="forgot-link">Forgot password?</button>
                    </div>

                    <!-- login button -->
                    <button type="submit" id="loginBtn" class="btn-login">
                        <span class="btn-text">Enter the cozy space</span>
                        <span class="btn-icon">✦</span>
                        <span class="btn-loading hidden">⏳</span>
                    </button>

                    <!-- feedback message -->
                    <div id="loginFeedback" class="login-feedback"></div>
                </form>

                <!-- register link for new viewers -->
                <div class="register-link" id="registerLink">
                    <p>👤 New here? <a href="/viewer/register">Create an account</a></p>
                </div>

                <!-- guest note -->
                <div class="login-footer">
                    <p class="guest-note">🌸 Just browsing? <button type="button" id="guestBtn" class="guest-link">Continue as guest</button></p>
                </div>
            </div>

            <!-- cozy decoration -->
            <div class="cozy-decoration">
                <span class="deco-emoji">🧶</span>
                <span class="deco-emoji">☕</span>
                <span class="deco-emoji">✧</span>
                <span class="deco-emoji">🌸</span>
            </div>
        </div>
    </div>

    <!-- forgot password modal -->
    <div id="forgotModal" class="modal">
        <div class="modal-content">
            <button class="modal-close">&times;</button>
            <div class="modal-header">
                <span class="modal-icon">🔑</span>
                <h2 class="modal-title">Reset password</h2>
                <p class="modal-subtitle">Enter your email to receive reset link</p>
            </div>
            <form id="forgotForm" class="modal-form">
                <div class="input-group">
                    <label for="forgotEmail" class="input-label">Email address</label>
                    <input type="email" id="forgotEmail" class="form-input" placeholder="cozy@example.com">
                </div>
                <button type="submit" class="btn-login modal-btn">Send reset link ✉️</button>
                <div id="forgotFeedback" class="form-feedback"></div>
            </form>
        </div>
    </div>

    <!-- guest modal -->
    <div id="guestModal" class="modal">
        <div class="modal-content guest-content">
            <button class="modal-close">&times;</button>
            <div class="modal-header">
                <span class="modal-icon">👋</span>
                <h2 class="modal-title">Continue as guest?</h2>
                <p class="modal-subtitle">you'll have limited access to the portfolio</p>
            </div>
            <div class="guest-options">
                <p class="guest-features">✨ view public projects<br>✨ see skills & certifications<br>✨ contact form</p>
                <div class="guest-buttons">
                    <button id="confirmGuest" class="btn-login guest-confirm">continue as guest</button>
                    <button class="btn-login guest-cancel modal-close">go back</button>
                </div>
            </div>
        </div>
    </div>

    <script src="/assets/js/login.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Toggle password visibility
            const togglePassword = document.getElementById('togglePassword');
            const passwordInput = document.getElementById('password');
            
            if (togglePassword) {
                togglePassword.addEventListener('click', function() {
                    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                    passwordInput.setAttribute('type', type);
                    this.querySelector('.toggle-icon').textContent = type === 'password' ? '👁️' : '👁️‍🗨️';
                });
            }
            
            // Guest button opens guest modal
            const guestBtn = document.getElementById('guestBtn');
            const guestModal = document.getElementById('guestModal');
            
            if (guestBtn && guestModal) {
                guestBtn.addEventListener('click', function() {
                    guestModal.classList.add('show');
                });
            }
            
            // Forgot password button
            const forgotBtn = document.getElementById('forgotBtn');
            const forgotModal = document.getElementById('forgotModal');
            
            if (forgotBtn && forgotModal) {
                forgotBtn.addEventListener('click', function() {
                    forgotModal.classList.add('show');
                });
            }
            
            // Close modals
            document.querySelectorAll('.modal-close').forEach(btn => {
                btn.addEventListener('click', function() {
                    this.closest('.modal').classList.remove('show');
                });
            });
            
            // Confirm guest
            const confirmGuest = document.getElementById('confirmGuest');
            if (confirmGuest) {
                confirmGuest.addEventListener('click', function() {
                    window.location.href = '/guest';
                });
            }
        });
    </script>
</body>
</html>