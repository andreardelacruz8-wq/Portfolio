<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AndengDC · Register</title>
    <style>
        body {
            background: linear-gradient(135deg, #2e1a47 0%, #4a3068 50%, #6b4f8f 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Roboto, system-ui, -apple-system, sans-serif;
            margin: 0;
            padding: 1rem;
        }
        
        .register-container {
            max-width: 500px;
            width: 100%;
            margin: 0 auto;
            padding: 2.5rem;
            background: rgba(255, 255, 255, 0.98);
            border-radius: 40px;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.3);
            backdrop-filter: blur(10px);
            border: 2px solid rgba(255, 255, 255, 0.2);
        }
        
        .register-header {
            text-align: center;
            margin-bottom: 2rem;
        }
        
        .logo-code {
            display: inline-block;
            background: #5d3f7e;
            color: #ffffff !important;
            padding: 1rem 2rem;
            border-radius: 60px;
            font-size: 2.5rem;
            font-weight: 300;
            box-shadow: 0 10px 25px rgba(93, 63, 126, 0.4);
            margin-bottom: 1rem;
        }
        
        .register-header h1 {
            color: #2e1a47;
            font-size: 2.2rem;
            font-weight: 300;
            margin: 0.5rem 0 0.2rem;
        }
        
        .register-header p {
            color: #5d3f7e;
            font-size: 1.1rem;
            margin: 0;
        }
        
        .form-group {
            margin-bottom: 1.5rem;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            color: #2e1a47;
            font-weight: 500;
            font-size: 0.95rem;
            letter-spacing: 0.3px;
        }
        
        .form-input {
            width: 100%;
            padding: 0.9rem 1.5rem;
            border: 2px solid #e4d0ff;
            border-radius: 50px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: #ffffff;
            color: #2e1a47 !important;
            box-sizing: border-box;
        }
        
        .form-input::placeholder {
            color: #9b84b5;
            opacity: 0.8;
            font-weight: 300;
        }
        
        .form-input:hover {
            border-color: #b397d6;
            background: #ffffff;
        }
        
        .form-input:focus {
            border-color: #5d3f7e;
            outline: none;
            box-shadow: 0 0 0 4px rgba(93, 63, 126, 0.15);
            background: #ffffff;
        }
        
        .btn-register {
            width: 100%;
            background: #5d3f7e;
            color: white !important;
            border: none;
            padding: 1rem 2rem;
            border-radius: 50px;
            font-size: 1.1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 500;
            letter-spacing: 0.5px;
            margin-top: 1rem;
            box-shadow: 0 8px 20px rgba(93, 63, 126, 0.3);
            position: relative;
            overflow: hidden;
        }
        
        .btn-register:hover {
            background: #3e2a57;
            transform: translateY(-3px);
            box-shadow: 0 15px 30px rgba(93, 63, 126, 0.4);
        }
        
        .btn-register:active {
            transform: translateY(-1px);
        }
        
        .btn-register:disabled {
            background: #b397d6;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }
        
        .login-link {
            text-align: center;
            margin-top: 2rem;
            padding-top: 1rem;
            border-top: 2px dashed #e4d0ff;
        }
        
        .login-link p {
            color: #5d3f7e;
            font-size: 0.95rem;
        }
        
        .login-link a {
            color: #2e1a47;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            padding: 0.3rem 0.8rem;
            border-radius: 30px;
        }
        
        .login-link a:hover {
            background: #f0e4ff;
            text-decoration: none;
            color: #5d3f7e;
        }
        
        .error-message {
            color: #f44336;
            font-size: 0.85rem;
            margin-top: 0.3rem;
            padding-left: 1rem;
            font-weight: 500;
        }
        
        .success-message {
            color: #4CAF50;
            text-align: center;
            margin-top: 1.5rem;
            font-weight: 500;
            font-size: 1rem;
            padding: 0.8rem;
            background: rgba(76, 175, 80, 0.1);
            border-radius: 50px;
        }
        
        /* Animation for logo */
        .logo-code {
            animation: float 3s ease-in-out infinite;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-5px); }
        }
        
        /* Responsive design */
        @media (max-width: 600px) {
            .register-container {
                padding: 1.8rem;
            }
            
            .register-header h1 {
                font-size: 1.8rem;
            }
            
            .logo-code {
                font-size: 2rem;
                padding: 0.8rem 1.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="register-container">
        <div class="register-header">
            <div class="logo-code">{&nbsp;}</div>
            <h1>Join the Cozy Club</h1>
            <p>Create your viewer account</p>
        </div>
        
        <form id="registerForm">
            <div class="form-group">
                <label>✨ Username *</label>
                <input type="text" name="username" id="username" class="form-input" placeholder="cozy_viewer" required autocomplete="off">
                <div id="usernameError" class="error-message"></div>
            </div>
            
            <div class="form-group">
                <label>📧 Email *</label>
                <input type="email" name="email" id="email" class="form-input" placeholder="cozy@example.com" required autocomplete="off">
                <div id="emailError" class="error-message"></div>
            </div>
            
            <div class="form-group">
                <label>👤 Full Name (optional)</label>
                <input type="text" name="full_name" id="fullName" class="form-input" placeholder="Andrea Dela Cruz" autocomplete="off">
            </div>
            
            <div class="form-group">
                <label>🔐 Password * (min 6 characters)</label>
                <input type="password" name="password" id="password" class="form-input" placeholder="••••••••" required>
                <div id="passwordError" class="error-message"></div>
            </div>
            
            <div class="form-group">
                <label>🔐 Confirm Password *</label>
                <input type="password" name="confirm_password" id="confirmPassword" class="form-input" placeholder="••••••••" required>
                <div id="confirmError" class="error-message"></div>
            </div>
            
            <button type="submit" class="btn-register" id="registerBtn">
                <span class="btn-text">Create Account ✦</span>
                <span class="btn-loading" style="display: none;">⏳</span>
            </button>
            
            <div id="registerFeedback" class="success-message"></div>
        </form>
        
        <div class="login-link">
            <p>🌸 Already have an account? <a href="/admin/login">Login here</a></p>
        </div>
    </div>
    
    <script>
    document.getElementById('registerForm').addEventListener('submit', async function(e) {
        e.preventDefault();
        
        // Clear previous errors
        document.querySelectorAll('.error-message').forEach(el => el.textContent = '');
        document.getElementById('registerFeedback').textContent = '';
        
        // Get form data
        const formData = new FormData(this);
        
        // Disable button and show loading
        const btn = document.getElementById('registerBtn');
        const btnText = btn.querySelector('.btn-text');
        const btnLoading = btn.querySelector('.btn-loading');
        
        btn.disabled = true;
        btnText.style.display = 'none';
        btnLoading.style.display = 'inline';
        
        try {
            // Send to server
            const response = await fetch('/viewer/attemptRegister', {
                method: 'POST',
                body: formData
            });
            
            const data = await response.json();
            
            if (data.status === 'success') {
                document.getElementById('registerFeedback').textContent = '✅ ' + data.message;
                document.getElementById('registerFeedback').style.color = '#4CAF50';
                
                // Clear form
                this.reset();
                
                // Redirect to login after 2 seconds
                setTimeout(() => {
                    window.location.href = '/admin/login?registered=true';
                }, 2000);
            } else {
                // Show errors
                if (data.errors) {
                    for (let field in data.errors) {
                        const errorEl = document.getElementById(field + 'Error');
                        if (errorEl) {
                            errorEl.textContent = '⚠️ ' + data.errors[field];
                        }
                    }
                } else if (data.message) {
                    document.getElementById('registerFeedback').textContent = '❌ ' + data.message;
                    document.getElementById('registerFeedback').style.color = '#f44336';
                }
                
                btn.disabled = false;
                btnText.style.display = 'inline';
                btnLoading.style.display = 'none';
            }
        } catch (error) {
            console.error('Error:', error);
            document.getElementById('registerFeedback').textContent = '❌ Connection error. Please try again.';
            document.getElementById('registerFeedback').style.color = '#f44336';
            
            btn.disabled = false;
            btnText.style.display = 'inline';
            btnLoading.style.display = 'none';
        }
    });
    </script>
</body>
</html>