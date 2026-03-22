<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AndreaDC · Portfolio</title>
    <!-- soft & cozy purple palette, light & dark -->
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>
    <!-- header / navigation (soft light purple) -->
    <header class="site-header">
        <div class="container nav-container">
            <div class="logo">
                <span class="logo-code">{&nbsp;}</span>
                <span class="logo-name">Andrea R. dela Cruz</span>
            </div>
            <nav>
                <ul class="nav-links">
                    <li><a href="#about" class="nav-link">About</a></li>
                    <li><a href="#projects" class="nav-link">Projects</a></li>
                    <li><a href="#skills" class="nav-link">Skills</a></li>
                    <li><a href="#special" class="nav-link">Special</a></li>
                    <li><a href="#contact" class="nav-link">Contact</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main>
        <!-- ABOUT SECTION (soft intro) -->
        <section id="about" class="section about-section">
            <div class="container">
                <div class="about-grid">
                    <div class="about-text">
                        <h1 class="heading">Hi, i'm <span class="accent-dark">Andeng</span> <span class="accent-soft">✦</span></h1>
                        <p class="subhead">Computer Science Graduate · Builder of Soft Things with Hard Logic</p>
                        <p class="description">
                            I love crafting elegant, cozy digital experiences — from full‑stack web apps to quiet algorithmic visualizations. 
                            For me, code is a warm blanket of structured thought. Currently seeking a role where i can solve real problems 
                            with curiosity and care.
                        </p>
                        <div class="about-cta">
                            <a href="#projects" class="btn btn-primary">See my work</a>
                            <a href="#contact" class="btn btn-outline">Say hello!</a>
                        </div>
                    </div>
                    <div class="about-avatar">
                        <!-- abstract cozy avatar (purple tones) -->
                        <div class="avatar-placeholder">
                            <span>🧶</span>
                            <span>✧</span>
                            <span>☕</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- PROJECTS SECTION (heart of portfolio) -->
        <section id="projects" class="section projects-section">
            <div class="container">
                <h2 class="section-title"><span class="title-deco">✦</span> Featured Projects <span class="title-deco">✦</span></h2>
                
                <div class="projects-grid">
                    <!-- project 1: fullstack task app -->
                    <article class="project-card">
                        <div class="card-media" style="background-color: #cbc3e3;"></div>
                        <div class="card-content">
                            <h3>KUMPAS</h3>
                            <p class="project-tags">Python · OpenCV · YOLO · HTML/CSS/JS</p>
                            <p class="project-description">Sign language translator using computer vision. Real-time hand gesture recognition with YOLO-powered detection. helps bridge communication gaps.</p>
                            <div class="project-challenge">
                                <span class="challenge-badge">Challenge</span>
                                <span>Real-time inference latency on edge devices — optimised YOLO model with TensorRT for 40ms detection.</span>
                            </div>
                            <div class="card-links">
                                <a href="#" class="link-icon">📁 code</a>
                                <a href="#" class="link-icon">🚀 demo</a>
                            </div>
                        </div>
                    </article>

                    <!-- project 2: pathfinding visualizer (algorithmic) -->
                    <article class="project-card">
                        <div class="card-media" style="background-color: #b39bc8;"></div>
                        <div class="card-content">
                            <h3>EYA'S CROCHET</h3>
                            <p class="project-tags">HTML · CSS · JavaScript · React</p>
                            <p class="project-description">Personal crochet portfolio showcasing handmade projects with cozy, pastel aesthetics. each stitch tells a story.</p>
                            <div class="project-challenge">
                                <span class="challenge-badge">Challenge</span>
                                <span>Dynamic image loading with lazy rendering — implemented intersection observer for smooth scroll performance.</span>
                            </div>
                            <div class="card-links">
                                <a href="#" class="link-icon">📁 code</a>
                                <a href="#" class="link-icon">🚀 demo</a>
                            </div>
                        </div>
                    </article>

                    <!-- project 3: api + dashboard (data) -->
                    <article class="project-card">
                        <div class="card-media" style="background-color: #9f8ab9;"></div>
                        <div class="card-content">
                            <h3>5S SCORESHEET</h3>
                            <p class="project-tags">HTML · CSS · JavaScript · Excel-like Calculations</p>
                            <p class="project-description">Interactive 5S workplace audit form with automatic scoring, photo upload integration, and dynamic table generation for lean manufacturing compliance.</p>
                            <div class="project-challenge">
                                <span class="challenge-badge">Challenge</span>
                                <span>Complex nested calculations across multiple tables — built a custom JavaScript engine for real-time auto-scoring and validation.</span>
                            </div>
                            <div class="card-links">
                                <a href="#" class="link-icon">📁 code</a>
                                <a href="#" class="link-icon">🚀 demo</a>
                            </div>
                        </div>
                    </article>
                </div>
                <p class="more-note">... plus smaller goodies on github 🌱</p>
            </div>
        </section>

        <!-- NEW SPECIAL SKILLS & CERTIFICATIONS SECTION (interactive) -->
        <section id="special" class="section special-section">
            <div class="container">
                <h2 class="section-title"><span class="title-deco">🏆</span> Special Skills & Certifications <span class="title-deco">🏆</span></h2>
                
                <div class="special-grid">
                    <!-- Certification Card 1: CSC Certificate (interactive flip card) -->
                    <div class="flip-card" id="cscCard">
                        <div class="flip-inner">
                            <div class="flip-front">
                                <div class="cert-badge">📜</div>
                                <h3>CSC Certificate</h3>
                                <p class="cert-issuer">Career Service Professional Examination</p>
                                <div class="flip-hint">Hover to see details →</div>
                            </div>
                            <div class="flip-back">
                                <h3>📋 Certificate Details</h3>
                                <p><strong>Rating:</strong>90.06%</p>
                                <p><strong>Date Released:</strong> May 02, 2025</p>
                                <p><strong>Examinee No:</strong>311964</p>
                                <a href="#" class="btn btn-small" id="showCertModal">View Credential 🏅</a>
                            </div>
                        </div>
                    </div>

                    <!-- Special Skill Card 2: Interactive Click-to-Reveal -->
                    <div class="special-skill-card" id="specialSkill1">
                        <div class="skill-front">
                            <span class="skill-emoji">🧠</span>
                            <h3>AI & Machine Learning</h3>
                            <p>Special Interest · 2 projects</p>
                            <button class="btn-small skill-reveal-btn" data-target="skill1-detail">Learn more +</button>
                        </div>
                        <div class="skill-detail hidden" id="skill1-detail">
                            <h4>AI/ML experience</h4>
                            <ul>
                                <li>📸 Open CV</li>
                                <li>📊 Computer Vision (object detection)</li>
                                <li>👀 You Only Look Once</li>
                            </ul>
                            <button class="btn-small close-detail">Close</button>
                        </div>
                    </div>

                    <!-- Special Skill Card 3: Interactive Click-to-Reveal -->
                    <div class="special-skill-card" id="specialSkill2">
                        <div class="skill-front">
                            <span class="skill-emoji">🔐</span>
                            <h3>Cybersecurity</h3>
                            <p>Certification</p>
                            <button class="btn-small skill-reveal-btn" data-target="skill2-detail">Learn more +</button>
                        </div>
                        <div class="skill-detail hidden" id="skill2-detail">
                            <h4>Security credentials</h4>
                            <ul>
                                <li>🔒 Participated in the Cybersecurity Awareness Seminar entitled "Oplan Paskong Sigurado: Ligtas ang Iyong Online Christmas."</li>
                                <li>
                                    <a href="/assets/images/ANDREA R. DELA CRUZ.pdf" target="_blank">📄 View Certificate</a>
                                </li>
                            </ul>
                            <button class="btn-small close-detail">Close</button>
                        </div>
                    </div>
                </div>

                <!-- Modal for CSC certificate (popup) -->
                <div id="certModal" class="modal">
                    <div class="modal-content">
                        <span class="close-modal">&times;</span>
                        <h3>🎓 CSC Certificate</h3>
                        <div class="modal-body">
                            <p><strong>Credential:</strong> Career Service Professional Examination</p>
                            <p><strong>Full Credential:</strong> Certificate of Eligibility</p>
                            <div class="cert-preview">
                                <div class="cert-placeholder">
                                    <embed src="/assets/images/csc.pdf" type="application/pdf" width="100%" height="300px" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- NEW HOBBIES & PERSONALITY SECTION (cozy corner) -->
        <section id="hobbies" class="section hobbies-section">
            <div class="container">
                <h2 class="section-title"><span class="title-deco">☕</span> Cozy Corner <span class="title-deco">☕</span></h2>
                <p class="hobbies-subtitle">Things that bring me joy outside the terminal</p>
                
                <div class="hobbies-grid">
                    <!-- Hobby Card 1: Reading -->
                    <div class="hobby-card" id="hobby1">
                        <div class="hobby-icon">🧶</div>
                        <h3>Yarnholic</h3>
                        <div class="hobby-details hidden">
                            <p>Yarn enthusiast</p>
                            <p class="hobby-fav">favourites: Crochet and Knitting</p>
                        </div>
                        <button class="hobby-toggle">✨</button>
                    </div>

                    <!-- Hobby Card 2: Gaming -->
                    <div class="hobby-card" id="hobby2">
                        <div class="hobby-icon">🎮</div>
                        <h3>Gamer</h3>
                        <div class="hobby-details hidden">
                            <p>Minecraft, Sims4, Counter Strike</p>
                            <p class="hobby-fav">Currently Playing: Sims4</p>
                        </div>
                        <button class="hobby-toggle">✨</button>
                    </div>


                    <!-- Hobby Card 4: Music -->
                    <div class="hobby-card" id="hobby3">
                        <div class="hobby-icon">📚</div>
                        <h3>Bibliophile</h3>
                        <div class="hobby-details hidden">
                            <p>fanfics & sci-fi enthusiast</p>
                            <p class="hobby-fav">favourites: Passerine, Flowers from 1970</p>
                        </div>
                        <button class="hobby-toggle">✨</button>
                    </div>

                    <!-- Hobby Card 5: Nature -->
                    <div class="hobby-card" id="hobby4">
                        <div class="hobby-icon">🌿</div>
                        <h3>PlanTita</h3>
                        <div class="hobby-details hidden">
                            <p>Tomato Lover · Flower enthusiant</p>
                            <p class="hobby-fav">They keep me grounded 🌱</p>
                        </div>
                        <button class="hobby-toggle">✨</button>
                    </div>

                    <!-- Personality Card: Myers-Briggs -->
                    <div class="hobby-card personality-card" id="personality">
                        <div class="hobby-icon">🧠</div>
                        <h3>INFJ</h3>
                        <div class="hobby-details hidden">
                            <p>Advocate · Creative · Idealistic</p>
                            <p class="hobby-fav">"The weird sister" of the office</p>
                        </div>
                        <button class="hobby-toggle">✨</button>
                    </div>
                </div>

                <!-- Fun fact marquee -->
                <div class="fun-fact-container">
                    <div class="fun-fact">
                        <span class="fact-label">🌟 random fact:</span>
                        <span class="fact-text" id="rotatingFact">I can solve a rubik's cube in under 1 minutes</span>
                    </div>
                    <button class="fact-btn" id="newFactBtn">new fact ↻</button>
                </div>
            </div>
        </section>

        <!-- SKILLS SECTION (quick reference) -->
        <section id="skills" class="section skills-section">
            <div class="container">
                <h2 class="section-title"><span class="title-deco">☁️</span> Toolbox <span class="title-deco">☁️</span></h2>
                <div class="skills-container">
                    <div class="skill-category">
                        <h4>Languages</h4>
                        <ul class="skill-items">
                            <li>Python</li><li>Java</li><li>JavaScript</li><li>C++</li><li>SQL</li>
                        </ul>
                    </div>
                    <div class="skill-category">
                        <h4>Frameworks & Libs</h4>
                        <ul class="skill-items">
                            <li>React</li><li>CodeIgniter</li><li>OpenCV</li>
                        </ul>
                    </div>
                    <div class="skill-category">
                        <h4>Databases & Tools</h4>
                        <ul class="skill-items">
                            <li>MySQL</li><li>Apache Cassandra</li><li>VSCode</li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        <!-- CONTACT SECTION & FOOTER (soft signoff) -->
        <section id="contact" class="section contact-section">
            <div class="container">
                <h2 class="section-title"><span class="title-deco">✧</span> Let's Connect <span class="title-deco">✧</span></h2>
                <div class="contact-flex">
                    <div class="contact-text">
                        <p>I’m currently open to junior developer roles. feel free to reach out — i’d love to chat about code, cozy games, or your favourite tea.</p>
                        <div class="contact-links">
                            <a href="https://mail.google.com/mail/?view=cm&fs=1&to=andreardelacruz@gmail.com&su=Project%20Inquiry&body=Hi%20Andrea%2C%20I%20saw%20your%20portfolio..." target="_blank" class="contact-item">
                                📧 andreardelacruz@gmail.com
                            </a>
                            <a href="https://github.com/andreardelacruz8-wq" target="_blank" class="contact-item">💻 github.com/andreardelacruz8-wq</a>
                            <a href="https://www.facebook.com/share/18AK1dxm5y/" target="_blank" class="contact-item">ⓕ Andrea Dela Cruz</a>
                        </div>
                    </div>
                    <div class="contact-form">
                        <form id="cozyForm">
                            <input type="text" placeholder="Your name" id="nameInput" class="form-input">
                            <input type="email" placeholder="Your email" id="emailInput" class="form-input">
                            <textarea rows="2" placeholder="Soft message..." id="msgInput" class="form-input"></textarea>
                            <button type="submit" class="btn btn-primary form-btn">Send warmth ✦</button>
                            <p id="formFeedback" class="form-feedback"></p>
                        </form>
                    </div>
                </div>
                <footer class="site-footer">
                    <p>© 2025 · designed with ☕ and purple haze · all rights cozy</p>
                </footer>
            </div>
        </section>
    </main>

    <!-- separate javascript file (cozy interactions) -->
    <script src="/assets/js/script.js"></script>
</body>
</html>