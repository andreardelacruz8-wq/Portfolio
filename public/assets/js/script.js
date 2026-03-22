// script.js – soft interactions for cozy cs portfolio

document.addEventListener('DOMContentLoaded', function() {
    // smooth reveal for project cards (simple fade on scroll)
    const cards = document.querySelectorAll('.project-card');
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = 1;
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, { threshold: 0.1, rootMargin: '20px' });

    cards.forEach(card => {
        card.style.opacity = 0;
        card.style.transform = 'translateY(12px)';
        card.style.transition = 'opacity 0.6s ease, transform 0.5s ease';
        observer.observe(card);
    });

    // ===== UPDATED FORM HANDLING WITH DATABASE SAVE =====
    const form = document.getElementById('cozyForm');
    const feedback = document.getElementById('formFeedback');
    const nameInput = document.getElementById('nameInput');
    const emailInput = document.getElementById('emailInput');
    const msgInput = document.getElementById('msgInput');

    if (form) {
        form.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            // Simple validation
            if (nameInput.value.trim() === '' || emailInput.value.trim() === '' || msgInput.value.trim() === '') {
                feedback.innerText = '☁️ Please fill all fields — I\'d love to hear from you.';
                feedback.style.color = '#9b6fbb';
                return;
            }
            
            // Show sending message
            feedback.innerText = '⏳ Sending your warmth...';
            feedback.style.color = '#5d3f7e';
            
            // Prepare data to send
            const formData = new FormData();
            formData.append('name', nameInput.value);
            formData.append('email', emailInput.value);
            formData.append('message', msgInput.value);
            
            try {
                // Send to CodeIgniter backend
                const response = await fetch('/contact/send', {
                    method: 'POST',
                    body: formData
                });
                
                const data = await response.json();
                
                if (data.status === 'success') {
                    feedback.innerText = '✨ ' + data.message;
                    feedback.style.color = '#3d295b';
                    // Clear form
                    nameInput.value = '';
                    emailInput.value = '';
                    msgInput.value = '';
                } else {
                    feedback.innerText = '☁️ ' + data.message;
                    feedback.style.color = '#9b6fbb';
                }
            } catch (error) {
                console.error('Error:', error);
                feedback.innerText = '☁️ Something went wrong. Please try again.';
                feedback.style.color = '#9b6fbb';
            }
        });
    }

    // ===== NEW INTERACTIVE FEATURES FOR SPECIAL SKILLS =====
    
    // 1. Click-to-reveal for skill cards
    const revealBtns = document.querySelectorAll('.skill-reveal-btn');
    const closeBtns = document.querySelectorAll('.close-detail');
    
    revealBtns.forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.stopPropagation();
            const targetId = this.getAttribute('data-target');
            const detailDiv = document.getElementById(targetId);
            const frontDiv = this.closest('.skill-front');
            
            // hide front, show detail
            if (frontDiv) frontDiv.style.display = 'none';
            if (detailDiv) {
                detailDiv.classList.remove('hidden');
                detailDiv.style.display = 'block';
            }
        });
    });
    
    closeBtns.forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.stopPropagation();
            const detailDiv = this.closest('.skill-detail');
            const card = this.closest('.special-skill-card');
            const frontDiv = card ? card.querySelector('.skill-front') : null;
            
            if (detailDiv) {
                detailDiv.classList.add('hidden');
                detailDiv.style.display = 'none';
            }
            if (frontDiv) frontDiv.style.display = 'flex';
        });
    });

    // 2. Modal for CSC certificate (from flip card)
    const modal = document.getElementById('certModal');
    const showModalBtn = document.getElementById('showCertModal');
    const closeModal = document.querySelector('.close-modal');
    const cscCard = document.getElementById('cscCard');
    
    // Open modal when clicking the "view credential" button inside flip card back
    if (showModalBtn) {
        showModalBtn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation(); // prevent flip card from toggling
            modal.classList.add('show');
        });
    }
    
    // Close modal with X
    if (closeModal) {
        closeModal.addEventListener('click', function() {
            modal.classList.remove('show');
        });
    }
    
    // Close modal when clicking outside content
    window.addEventListener('click', function(e) {
        if (e.target === modal) {
            modal.classList.remove('show');
        }
    });

    // 3. Extra: flip card accessibility (optional: allow click to flip on mobile)
    // For touch devices where hover is limited, we can add a click toggle
    if (window.matchMedia("(hover: none)").matches) {
        const flipCards = document.querySelectorAll('.flip-card');
        flipCards.forEach(card => {
            card.addEventListener('click', function() {
                this.classList.toggle('flipped');
                const inner = this.querySelector('.flip-inner');
                if (this.classList.contains('flipped')) {
                    inner.style.transform = 'rotateY(180deg)';
                } else {
                    inner.style.transform = 'rotateY(0deg)';
                }
            });
        });
    }

    // ===== HOBBIES SECTION INTERACTIONS =====
    
    // Toggle hobby details with sparkle effect
    const hobbyCards = document.querySelectorAll('.hobby-card');
    
    hobbyCards.forEach(card => {
        const toggleBtn = card.querySelector('.hobby-toggle');
        const details = card.querySelector('.hobby-details');
        
        if (toggleBtn && details) {
            // Initially hide details
            details.classList.add('hidden');
            
            toggleBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                
                // Add sparkle effect
                card.style.transform = 'scale(1.02)';
                setTimeout(() => {
                    card.style.transform = '';
                }, 200);
                
                // Toggle details with animation
                if (details.classList.contains('hidden')) {
                    details.classList.remove('hidden');
                    toggleBtn.textContent = '✕';
                    toggleBtn.style.background = '#5d3f7e';
                    toggleBtn.style.color = '#ffffff';
                } else {
                    details.classList.add('hidden');
                    toggleBtn.textContent = '✨';
                    toggleBtn.style.background = '';
                    toggleBtn.style.color = '';
                }
            });
        }
    });

    // Random facts array
    const facts = [
        'I can solve more that 7 types of rubik\'s cubes',
        'I can solve a rubik\'s cube in under 1 minutes',
        'I once coded an entire project while there\'s a storm',
        'My favorite animal is sheep',
        'I feel like I am talking to a real person when coding a python program',
        'My first phyton project is a block game',
        'I name my dogs after my favorite youtubers',
        'I\'ve visited 9 provinces in the Philippines and counting',
        'I can crochet 5 balls of yarn in one day',
        'I love matcha (not to be performative)',
        'I learned CSS before HTML (chaotic energy)',
        'I have a dog named "Pepa dog"',
        'I built this portfolio in my bed'
    ];
    
    const factText = document.getElementById('rotatingFact');
    const factBtn = document.getElementById('newFactBtn');
    
    if (factBtn && factText) {
        factBtn.addEventListener('click', function() {
            // Fade out
            factText.style.opacity = '0';
            factText.style.transform = 'translateX(-10px)';
            
            setTimeout(() => {
                // Get random fact
                const randomIndex = Math.floor(Math.random() * facts.length);
                factText.textContent = facts[randomIndex];
                
                // Fade in
                factText.style.opacity = '1';
                factText.style.transform = 'translateX(0)';
            }, 200);
            
            // Button animation
            factBtn.style.transform = 'rotate(360deg)';
            setTimeout(() => {
                factBtn.style.transform = '';
            }, 500);
        });
    }

    // console charm
    console.log('🌸 cozy.cs portfolio — everything is soft and purple!');
});

function logout() {
    if (confirm('Log out?')) {
        window.location.href = '/admin/logout';
    }
}