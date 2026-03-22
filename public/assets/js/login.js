// login.js - authentication for cozy portfolio

document.addEventListener('DOMContentLoaded', function() {
    // ===== CONFIGURATION =====
    const DEMO_USERNAME = 'andrea_dc';
    const DEMO_PASSWORD = 'cozy2025';
    const PORTFOLIO_URL = '/'; // your main portfolio page

    // ===== DOM ELEMENTS =====
    const loginForm = document.getElementById('loginForm');
    const usernameInput = document.getElementById('username');
    const passwordInput = document.getElementById('password');
    const loginBtn = document.getElementById('loginBtn');
    const loginFeedback = document.getElementById('loginFeedback');
    const togglePassword = document.getElementById('togglePassword');
    const autoFillBtn = document.getElementById('autoFillBtn');
    const copyBtns = document.querySelectorAll('.copy-btn');
    const forgotBtn = document.getElementById('forgotBtn');
    const signupBtn = document.getElementById('signupBtn');
    const guestBtn = document.getElementById('guestBtn');
    const rememberCheck = document.getElementById('remember');

    // Modals
    const signupModal = document.getElementById('signupModal');
    const forgotModal = document.getElementById('forgotModal');
    const guestModal = document.getElementById('guestModal');
    const modalCloses = document.querySelectorAll('.modal-close');
    const confirmGuest = document.getElementById('confirmGuest');

    // Signup form elements
    const signupForm = document.getElementById('signupForm');
    const signupFeedback = document.getElementById('signupFeedback');
    const forgotForm = document.getElementById('forgotForm');
    const forgotFeedback = document.getElementById('forgotFeedback');

    // ===== INITIALIZATION =====
    
    // Check if user is already logged in
    checkSavedLogin();

    // ===== EVENT LISTENERS =====

    // Login form submission - UNIFIED VERSION
    if (loginForm) {
        loginForm.addEventListener('submit', handleLogin);
    }

    // Toggle password visibility
    if (togglePassword) {
        togglePassword.addEventListener('click', togglePasswordVisibility);
    }

    // Auto-fill demo credentials
    if (autoFillBtn) {
        autoFillBtn.addEventListener('click', autoFillDemo);
    }

    // Copy credentials
    copyBtns.forEach(btn => {
        btn.addEventListener('click', handleCopy);
    });

    // Open modals
    if (signupBtn) {
        signupBtn.addEventListener('click', () => openModal(signupModal));
    }

    if (forgotBtn) {
        forgotBtn.addEventListener('click', () => openModal(forgotModal));
    }

    if (guestBtn) {
        guestBtn.addEventListener('click', () => openModal(guestModal));
    }

    // Close modals
    modalCloses.forEach(close => {
        close.addEventListener('click', closeAllModals);
    });

    // Click outside modal to close
    window.addEventListener('click', (e) => {
        if (e.target.classList.contains('modal')) {
            closeAllModals();
        }
    });

    // Guest confirm
    if (confirmGuest) {
        confirmGuest.addEventListener('click', handleGuestLogin);
    }

    // Signup form submission
    if (signupForm) {
        signupForm.addEventListener('submit', handleSignup);
    }

    // Forgot password form submission
    if (forgotForm) {
        forgotForm.addEventListener('submit', handleForgot);
    }

    // Toggle for signup modal password
    const toggleSignup = document.querySelector('.toggle-signup');
    if (toggleSignup) {
        toggleSignup.addEventListener('click', () => {
            const signupPassword = document.getElementById('signupPassword');
            togglePasswordField(signupPassword, toggleSignup);
        });
    }

    // ===== FUNCTIONS =====

    // UNIFIED LOGIN HANDLER - works for both admin and viewers
    function handleLogin(e) {
        e.preventDefault();
    
        const username = usernameInput.value.trim();
        const password = passwordInput.value;
        const remember = rememberCheck ? rememberCheck.checked : false;
    
        if (!username || !password) {
            showFeedback('☁️ Please enter both username/email and password', 'error');
            return;
        }
    
        setLoadingState(true);
    
        // Send to unified login endpoint
        fetch('/admin/attemptLogin', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `username=${encodeURIComponent(username)}&password=${encodeURIComponent(password)}&remember=${remember}`
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                showFeedback(data.message, 'success');
                setTimeout(() => {
                    window.location.href = data.redirect;
                }, 1500);
            } else {
                showFeedback(data.message, 'error');
                setLoadingState(false);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showFeedback('Connection error', 'error');
            setLoadingState(false);
        });
    }

    function handleSuccessfulLogin(username) {
        // Save login state
        if (rememberCheck && rememberCheck.checked) {
            localStorage.setItem('cozyUser', username);
            localStorage.setItem('cozyLoggedIn', 'true');
            localStorage.setItem('cozyLoginTime', Date.now());
        } else {
            sessionStorage.setItem('cozyUser', username);
            sessionStorage.setItem('cozyLoggedIn', 'true');
        }
        
        // Show success message
        showFeedback(`✨ welcome back, ${username}! redirecting...`, 'success');
        
        // Add success animation
        loginForm.classList.add('success-pulse');
        
        // Redirect to portfolio
        setTimeout(() => {
            window.location.href = PORTFOLIO_URL;
        }, 1500);
    }

    function handleGuestLogin() {
        fetch('/admin/guestLogin', {
            method: 'POST'
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                closeAllModals();
                showFeedback(data.message, 'success');
                setTimeout(() => {
                    window.location.href = data.redirect;
                }, 1500);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showFeedback('Connection error', 'error');
        });
    }

    function autoFillDemo() {
        usernameInput.value = DEMO_USERNAME;
        passwordInput.value = DEMO_PASSWORD;
        
        usernameInput.style.background = 'rgba(179, 151, 214, 0.2)';
        passwordInput.style.background = 'rgba(179, 151, 214, 0.2)';
        
        setTimeout(() => {
            usernameInput.style.background = '';
            passwordInput.style.background = '';
        }, 500);
        
        showFeedback('✨ demo credentials filled! click login to continue', 'success');
        
        if (rememberCheck) {
            rememberCheck.checked = true;
        }
    }

    function handleCopy(e) {
        const textToCopy = e.target.getAttribute('data-copy');
        
        navigator.clipboard.writeText(textToCopy).then(() => {
            const originalText = e.target.textContent;
            e.target.textContent = '✓';
            e.target.classList.add('copied');
            
            setTimeout(() => {
                e.target.textContent = originalText;
                e.target.classList.remove('copied');
            }, 1500);
            
            showFeedback('✨ copied to clipboard!', 'success');
        }).catch(err => {
            console.error('Copy failed:', err);
            showFeedback('❌ failed to copy', 'error');
        });
    }

    function togglePasswordVisibility() {
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);
        
        const icon = togglePassword.querySelector('.toggle-icon');
        if (icon) {
            icon.textContent = type === 'password' ? '👁️' : '👁️‍🗨️';
        }
    }

    function togglePasswordField(input, button) {
        const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
        input.setAttribute('type', type);
        button.textContent = type === 'password' ? '👁️' : '👁️‍🗨️';
    }

    function handleSignup(e) {
        e.preventDefault();
        
        const username = document.getElementById('signupUsername').value.trim();
        const email = document.getElementById('signupEmail').value.trim();
        const password = document.getElementById('signupPassword').value;
        const confirm = document.getElementById('signupConfirm').value;
        
        if (!username || !email || !password || !confirm) {
            showModalFeedback(signupFeedback, '📝 please fill all fields', 'error');
            return;
        }
        
        if (password !== confirm) {
            showModalFeedback(signupFeedback, '🔐 passwords do not match', 'error');
            return;
        }
        
        if (password.length < 6) {
            showModalFeedback(signupFeedback, '🔐 password must be at least 6 characters', 'error');
            return;
        }
        
        // Send to server
        fetch('/viewer/attemptRegister', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `username=${encodeURIComponent(username)}&email=${encodeURIComponent(email)}&password=${encodeURIComponent(password)}&confirm_password=${encodeURIComponent(confirm)}`
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                showModalFeedback(signupFeedback, data.message, 'success');
                setTimeout(() => {
                    closeAllModals();
                    usernameInput.value = username;
                    showFeedback('✨ account created! you can now login', 'success');
                }, 2000);
            } else {
                let errorMsg = 'Registration failed';
                if (data.messages) {
                    errorMsg = Object.values(data.messages).join(', ');
                } else if (data.message) {
                    errorMsg = data.message;
                }
                showModalFeedback(signupFeedback, errorMsg, 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showModalFeedback(signupFeedback, 'Connection error', 'error');
        });
    }

    function handleForgot(e) {
        e.preventDefault();
        
        const email = document.getElementById('forgotEmail').value.trim();
        
        if (!email) {
            showModalFeedback(forgotFeedback, '📧 please enter your email', 'error');
            return;
        }
        
        if (!email.includes('@') || !email.includes('.')) {
            showModalFeedback(forgotFeedback, '❓ please enter a valid email', 'error');
            return;
        }
        
        showModalFeedback(forgotFeedback, '✉️ reset link sent! (demo only)', 'success');
        
        setTimeout(() => {
            closeAllModals();
        }, 2000);
    }

    function checkSavedLogin() {
        const loggedIn = localStorage.getItem('cozyLoggedIn') || sessionStorage.getItem('cozyLoggedIn');
        const username = localStorage.getItem('cozyUser') || sessionStorage.getItem('cozyUser');
        
        if (loggedIn === 'true' && username) {
            const loginTime = localStorage.getItem('cozyLoginTime');
            if (loginTime) {
                const hoursSinceLogin = (Date.now() - parseInt(loginTime)) / (1000 * 60 * 60);
                if (hoursSinceLogin < 24) {
                    window.location.href = PORTFOLIO_URL;
                } else {
                    localStorage.removeItem('cozyLoggedIn');
                    localStorage.removeItem('cozyUser');
                    localStorage.removeItem('cozyLoginTime');
                }
            } else {
                window.location.href = PORTFOLIO_URL;
            }
        }
    }

    function setLoadingState(isLoading) {
        if (!loginBtn) return;
        
        const btnText = loginBtn.querySelector('.btn-text');
        const btnIcon = loginBtn.querySelector('.btn-icon');
        const btnLoading = loginBtn.querySelector('.btn-loading');
        
        if (isLoading) {
            loginBtn.disabled = true;
            if (btnText) btnText.textContent = 'Logging in...';
            if (btnIcon) btnIcon.classList.add('hidden');
            if (btnLoading) btnLoading.classList.remove('hidden');
        } else {
            loginBtn.disabled = false;
            if (btnText) btnText.textContent = 'Enter the cozy space';
            if (btnIcon) btnIcon.classList.remove('hidden');
            if (btnLoading) btnLoading.classList.add('hidden');
        }
    }

    function showFeedback(message, type) {
        if (loginFeedback) {
            loginFeedback.textContent = message;
            loginFeedback.className = 'login-feedback ' + type;
            
            if (type === 'success') {
                setTimeout(() => {
                    loginFeedback.textContent = '';
                    loginFeedback.className = 'login-feedback';
                }, 3000);
            }
        }
    }

    function showModalFeedback(element, message, type) {
        if (element) {
            element.textContent = message;
            element.className = 'form-feedback ' + type;
        }
    }

    function openModal(modal) {
        closeAllModals();
        if (modal) {
            modal.classList.add('show');
        }
    }

    function closeAllModals() {
        document.querySelectorAll('.modal').forEach(modal => {
            modal.classList.remove('show');
        });
    }

    // Add CSS animations dynamically
    const style = document.createElement('style');
    style.textContent = `
        .shake {
            animation: shake 0.5s ease-in-out;
        }
        
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
            20%, 40%, 60%, 80% { transform: translateX(5px); }
        }
        
        .success-pulse {
            animation: successPulse 0.5s ease;
        }
        
        @keyframes successPulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.02); background: rgba(179, 151, 214, 0.1); }
            100% { transform: scale(1); }
        }
    `;
    document.head.appendChild(style);

    // Focus on username input on page load
    if (usernameInput) {
        usernameInput.focus();
    }

    console.log('🌸 login page ready - unified login active!');
});