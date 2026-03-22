<?php
// At the very top of your file
$isViewer = session()->get('isViewerLoggedIn') ? true : false;
$isAdmin = session()->get('isAdminLoggedIn') ? true : false;

// Fetch certifications from database - using your actual column names
$certifications = [];
try {
    $db = \Config\Database::connect();
    $builder = $db->table('certifications');
    // Order by date_released DESC (newest first)
    $certifications = $builder->orderBy('date_released DESC')->get()->getResultArray();
} catch (Exception $e) {
    log_message('error', 'Error fetching certifications: ' . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AndreaDC · portfolio</title>
    <link rel="stylesheet" href="/assets/css/style.css">
    
    <style>
        /* Hamburger Menu Styles */
        .hamburger-menu {
            display: block;
            background: none;
            border: none;
            cursor: pointer;
            padding: 0.5rem;
            margin-right: 1rem;
            z-index: 1001;
            position: relative;
        }
        
        .hamburger-icon {
            width: 30px;
            height: 24px;
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        
        .hamburger-icon span {
            display: block;
            width: 100%;
            height: 3px;
            background-color: #5d3f7e;
            border-radius: 3px;
            transition: all 0.3s ease;
        }
        
        .hamburger-menu.active .hamburger-icon span:nth-child(1) {
            transform: rotate(45deg) translate(8px, 8px);
        }
        
        .hamburger-menu.active .hamburger-icon span:nth-child(2) {
            opacity: 0;
        }
        
        .hamburger-menu.active .hamburger-icon span:nth-child(3) {
            transform: rotate(-45deg) translate(8px, -8px);
        }
        
        /* Sidebar Navigation */
        .sidebar-nav {
            position: fixed;
            top: 0;
            left: -300px;
            width: 280px;
            height: 100vh;
            background: linear-gradient(145deg, #ffffff 0%, #f8f0ff 100%);
            box-shadow: 2px 0 20px rgba(93, 63, 126, 0.2);
            z-index: 1000;
            transition: left 0.3s ease;
            padding: 2rem 1.5rem;
            overflow-y: auto;
        }
        
        .sidebar-nav.open {
            left: 0;
        }
        
        .sidebar-nav .sidebar-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid #e4d0ff;
        }
        
        .sidebar-nav .sidebar-logo {
            font-size: 1.5rem;
            font-weight: 600;
            color: #2e1a47;
        }
        
        .sidebar-nav .sidebar-close {
            background: none;
            border: none;
            font-size: 1.8rem;
            cursor: pointer;
            color: #5d3f7e;
            transition: color 0.3s;
        }
        
        .sidebar-nav .sidebar-close:hover {
            color: #f44336;
        }
        
        .sidebar-nav ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        
        .sidebar-nav ul li {
            margin-bottom: 0.5rem;
        }
        
        .sidebar-nav ul li a {
            display: block;
            padding: 0.8rem 1rem;
            color: #2e1a47;
            text-decoration: none;
            font-size: 1.1rem;
            font-weight: 500;
            border-radius: 12px;
            transition: all 0.3s;
        }
        
        .sidebar-nav ul li a:hover {
            background: #e4d0ff;
            color: #5d3f7e;
            transform: translateX(5px);
        }
        
        .sidebar-nav .logout-btn-sidebar {
            margin-top: 2rem;
            padding-top: 1rem;
            border-top: 2px solid #e4d0ff;
        }
        
        .sidebar-nav .logout-btn-sidebar button {
            width: 100%;
            background: none;
            border: 2px solid #5d3f7e;
            color: #5d3f7e;
            padding: 0.8rem;
            border-radius: 30px;
            cursor: pointer;
            font-size: 1rem;
            font-weight: 500;
            transition: all 0.3s;
        }
        
        .sidebar-nav .logout-btn-sidebar button:hover {
            background: #5d3f7e;
            color: white;
        }
        
        /* Overlay when sidebar is open */
        .sidebar-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(46, 26, 71, 0.5);
            z-index: 999;
            display: none;
            backdrop-filter: blur(2px);
        }
        
        .sidebar-overlay.active {
            display: block;
        }
        
        /* Header with hamburger and logout button */
        .nav-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .header-logout {
            margin-left: auto;
        }
        
        .logout-btn-header {
            background: none;
            border: 2px solid #5d3f7e;
            color: #5d3f7e;
            padding: 0.5rem 1.2rem;
            border-radius: 30px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 0.95rem;
            font-weight: 500;
        }
        
        .logout-btn-header:hover {
            background: #5d3f7e;
            color: white;
        }
        
        /* Hide the top navigation links completely - only hamburger menu */
        .nav-links {
            display: none !important;
        }
        
        /* PDF Modal Styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 10000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.8);
            backdrop-filter: blur(5px);
        }
        
        .modal-content {
            background: white;
            margin: 5% auto;
            padding: 20px;
            border-radius: 20px;
            width: 90%;
            max-width: 1000px;
            height: 80vh;
            position: relative;
            box-shadow: 0 10px 40px rgba(93,63,126,0.5);
            border: 2px solid #5d3f7e;
        }
        
        .close-modal {
            position: absolute;
            right: 20px;
            top: 10px;
            font-size: 35px;
            cursor: pointer;
            color: #5d3f7e;
            z-index: 10;
            transition: all 0.3s;
        }
        
        .close-modal:hover {
            color: #f44336;
        }
        
        #pdfViewer {
            width: 100%;
            height: 100%;
            background: white;
            border: none;
        }
        
        #pdfViewer embed {
            width: 100%;
            height: 100%;
            border: none;
            display: block;
        }
        
        /* Animation */
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        
        @keyframes slideIn {
            from { transform: translateY(-30px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }
        
        .modal {
            animation: fadeIn 0.3s ease;
        }
        
        .modal-content {
            animation: slideIn 0.3s ease;
        }
        
        /* Certifications Grid */
        .certifications-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 2.5rem;
            margin-top: 2rem;
        }
        
        .flip-card {
            background: transparent;
            perspective: 1000px;
            height: 350px;
            width: 100%;
            cursor: pointer;
        }
        
        .flip-inner {
            position: relative;
            width: 100%;
            height: 100%;
            text-align: center;
            transition: transform 0.6s;
            transform-style: preserve-3d;
            box-shadow: 0 15px 35px rgba(93, 63, 126, 0.2);
            border-radius: 32px;
        }
        
        .flip-front, .flip-back {
            position: absolute;
            width: 100%;
            height: 100%;
            backface-visibility: hidden;
            border-radius: 32px;
            padding: 2rem;
            display: flex;
            flex-direction: column;
            border: 1px solid rgba(93, 63, 126, 0.15);
        }
        
        .flip-front {
            background: linear-gradient(145deg, #ffffff 0%, #f8f0ff 100%);
        }
        
        .flip-back {
            background: linear-gradient(145deg, #f8f0ff 0%, #ffffff 100%);
            transform: rotateY(180deg);
        }
        
        .cert-badge {
            font-size: 4rem;
            margin-bottom: 1.2rem;
            text-align: center;
            line-height: 1;
        }
        
        .flip-card h3 {
            color: #2e1a47;
            margin-bottom: 0.8rem;
            font-size: 1.6rem;
            font-weight: 600;
            line-height: 1.3;
        }
        
        .cert-issuer {
            color: #5d3f7e;
            font-size: 1.1rem;
            margin-bottom: 1.5rem;
            font-style: italic;
            opacity: 0.9;
        }
        
        .flip-hint {
            color: #9b7bb5;
            font-size: 0.95rem;
            margin-top: auto;
            text-align: right;
            font-style: italic;
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 0.5rem;
        }
        
        .view-cert-btn {
            background: #5d3f7e;
            color: white;
            border: none;
            padding: 0.8rem 1.5rem;
            border-radius: 40px;
            cursor: pointer;
            font-size: 1rem;
            font-weight: 500;
            transition: all 0.3s ease;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }
        
        .view-cert-btn:hover {
            background: #4a3267;
            transform: translateY(-2px);
        }
        
        .no-pdf {
            color: #999;
            font-style: italic;
            text-align: center;
            margin: 1rem 0;
        }
    </style>
</head>
<body>
    <!-- header / navigation -->
    <header class="site-header">
        <div class="container nav-container">
            <div class="logo" style="display: flex; align-items: center;">
                <button class="hamburger-menu" id="hamburgerBtn">
                    <div class="hamburger-icon">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                </button>
                <div>
                    <span class="logo-code">{&nbsp;}</span>
                    <span class="logo-name">Andrea R. dela Cruz</span>
                </div>
            </div>
            
            <!-- Logout Button on the Right -->
            <div class="header-logout">
                <button onclick="logout()" class="logout-btn-header">Logout</button>
            </div>
            
            <nav>
                <ul class="nav-links">
                    <li><a href="#about" class="sidebar-link">About</a></li>
                    <li><a href="#education" class="sidebar-link">Education</a></li>
                    <li><a href="#experience" class="sidebar-link">Experience</a></li>
                    <li><a href="#soft-skills" class="sidebar-link">Soft Skills</a></li>
                    <li><a href="#special-skills" class="sidebar-link">Special Skills</a></li>
                    <li><a href="#projects" class="sidebar-link">Projects</a></li>
                    <li><a href="#certifications" class="sidebar-link">Certifications</a></li>
                    <li><a href="#skills" class="sidebar-link">Skills</a></li>
                    <li><a href="#contact" class="sidebar-link">Contact</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <!-- Sidebar Navigation -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>
    <nav class="sidebar-nav" id="sidebarNav">
        <div class="sidebar-header">
            <span class="sidebar-logo">{&nbsp;}</span>
            <button class="sidebar-close" id="sidebarClose">&times;</button>
        </div>
        <ul>
            <li><a href="#about" class="sidebar-link">About</a></li>
            <li><a href="#education" class="sidebar-link">Education</a></li>
            <li><a href="#experience" class="sidebar-link">Experience</a></li>
            <li><a href="#projects" class="sidebar-link">Projects</a></li>
            <li><a href="#skills" class="sidebar-link">Skills</a></li>
            <li><a href="#soft-skills" class="sidebar-link">Soft Skills</a></li>
            <li><a href="#certifications" class="sidebar-link">Certifications</a></li>
            <li><a href="#special-skills" class="sidebar-link">Special Skills</a></li>
            <li><a href="#contact" class="sidebar-link">Contact</a></li>
        </ul>
    </nav>

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
                        <!-- circular profile image -->
                        <div class="avatar-image">
                            <img src="/assets/images/chura.jpg" alt="Andrea's avatar" class="profile-img">
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- EDUCATION SECTION -->
        <section id="education" class="section education-section">
            <div class="container">
                <h2 class="section-title"><span class="title-deco">🎓</span> Education <span class="title-deco">🎓</span></h2>
                
                <div class="education-grid">
                    <?php if (isset($education) && !empty($education)): ?>
                        <?php foreach ($education as $edu): ?>
                        <div class="education-card" data-id="<?= $edu['id'] ?>">
                            <div class="education-content">
                                <h3><?= htmlspecialchars($edu['degree']) ?></h3>
                                <h4 class="edu-school"><?= htmlspecialchars($edu['school']) ?> · <?= htmlspecialchars($edu['location'] ?? '') ?></h4>
                                <p class="education-date">
                                    <?= !empty($edu['start_date']) ? htmlspecialchars($edu['start_date']) : '' ?> - 
                                    <?= !empty($edu['end_date']) ? htmlspecialchars($edu['end_date']) : 'Present' ?>
                                    <?php if (!empty($edu['gpa'])): ?>
                                        | <span class="edu-gpa">GPA: <?= htmlspecialchars($edu['gpa']) ?></span>
                                    <?php endif; ?>
                                </p>
                                <?php if (!empty($edu['description'])): ?>
                                    <p class="education-description edu-description"><?= htmlspecialchars($edu['description']) ?></p>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>No education entries found.</p>
                    <?php endif; ?>
                </div>
            </div>
        </section>

        <!-- WORK EXPERIENCE SECTION -->
        <section id="experience" class="section experience-section">
            <div class="container">
                <h2 class="section-title"><span class="title-deco">💼</span> Work Experience <span class="title-deco">💼</span></h2>
                
                <div class="experience-grid">
                    <?php if (isset($work_experience) && !empty($work_experience)): ?>
                        <?php foreach ($work_experience as $work): ?>
                        <div class="experience-card" data-id="<?= $work['id'] ?>">
                            <div class="experience-content">
                                <h3><?= htmlspecialchars($work['position']) ?></h3>
                                <h4 class="exp-company"><?= htmlspecialchars($work['company']) ?> · <?= htmlspecialchars($work['location'] ?? '') ?></h4>
                                <p class="experience-date">
                                    <?= !empty($work['start_date']) ? htmlspecialchars($work['start_date']) : '' ?> - 
                                    <?= !empty($work['end_date']) ? htmlspecialchars($work['end_date']) : 'Present' ?>
                                </p>
                                <p class="experience-description exp-description"><?= htmlspecialchars($work['description']) ?></p>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>No work experience entries found.</p>
                    <?php endif; ?>
                </div>
            </div>
        </section>

        <!-- PROJECTS SECTION -->
        <section id="projects" class="section projects-section">
            <div class="container">
                <h2 class="section-title"><span class="title-deco">✦</span> Featured Projects <span class="title-deco">✦</span></h2>
                
                <div class="projects-grid">
                    <?php if (isset($projects) && !empty($projects)): ?>
                        <?php foreach ($projects as $project): ?>
                        <article class="project-card" data-id="<?= $project['id'] ?>">
                            <div class="card-media" style="background-color: <?= $project['color'] ?? '#cbc3e3' ?>;"></div>
                            <div class="card-content">
                                <h3><?= htmlspecialchars($project['title']) ?></h3>
                                <p class="project-tags"><?= htmlspecialchars($project['tags']) ?></p>
                                <p class="project-description"><?= htmlspecialchars($project['description']) ?></p>
                                <?php if (!empty($project['challenge'])): ?>
                                <div class="project-challenge">
                                    <span class="challenge-badge">Challenge</span>
                                    <span><?= htmlspecialchars($project['challenge']) ?></span>
                                </div>
                                <?php endif; ?>
                                <div class="card-links">
                                    <a href="<?= $project['code_link'] ?? '#' ?>" class="link-icon">📁 code</a>
                                    <a href="<?= $project['demo_link'] ?? '#' ?>" class="link-icon">🚀 demo</a>
                                </div>
                            </div>
                        </article>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>No projects found.</p>
                    <?php endif; ?>
                </div>
                <p class="more-note">... plus smaller goodies on github 🌱</p>
            </div>
        </section>

        <!-- SOFT SKILLS SECTION -->
        <section id="soft-skills" class="section soft-skills-section">
            <div class="container">
                <h2 class="section-title"><span class="title-deco">🤝</span> Soft Skills <span class="title-deco">🤝</span></h2>
                
                <div class="soft-skills-grid">
                    <?php if (isset($soft_skills) && !empty($soft_skills)): ?>
                        <?php foreach ($soft_skills as $skill): ?>
                        <div class="soft-skill-card" data-id="<?= $skill['id'] ?>">
                            <div class="soft-skill-icon softskill-icon"><?= html_entity_decode($skill['icon'] ?? '🤝') ?></div>
                            <h3><?= htmlspecialchars($skill['title']) ?></h3>
                            <?php if (!empty($skill['description'])): ?>
                                <p><?= htmlspecialchars($skill['description']) ?></p>
                            <?php endif; ?>
                        </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>No soft skills found.</p>
                    <?php endif; ?>
                </div>
            </div>
        </section>

        <!-- CERTIFICATIONS SECTION -->
        <section id="certifications" class="section certifications-section">
            <div class="container">
                <h2 class="section-title"><span class="title-deco">🏆</span> Certifications <span class="title-deco">🏆</span></h2>
                
                <div class="certifications-grid">
                    <?php if (!empty($certifications)): ?>
                        <?php foreach ($certifications as $cert): ?>
                        <div class="flip-card" data-cert-id="<?= $cert['id'] ?>">
                            <div class="flip-inner" onmouseover="this.style.transform='rotateY(180deg)'" 
                               onmouseout="this.style.transform='rotateY(0deg)'">
                                
                                <!-- Front of card -->
                                <div class="flip-front">
                                    <div class="cert-badge">📜</div>
                                    <h3><?= htmlspecialchars($cert['title'] ?? 'Untitled') ?></h3>
                                    <p class="cert-issuer"><?= htmlspecialchars($cert['issuer'] ?? 'Unknown') ?></p>
                                    <div class="flip-hint">
                                        <span>Hover to see details</span>
                                        <span style="font-size: 1.2rem;">→</span>
                                    </div>
                                </div>
                                
                                <!-- Back of card -->
                                <div class="flip-back">
                                    <h3>📋 Certificate Details</h3>
                                    
                                    <div style="display: flex; flex-direction: column; gap: 1rem; flex: 1;">
                                        <?php if (!empty($cert['rating'])): ?>
                                        <p style="margin: 0; color: #444; font-size: 1.1rem;">
                                            <strong style="color: #5d3f7e; min-width: 120px; display: inline-block;">Rating:</strong> 
                                            <?= htmlspecialchars($cert['rating']) ?>
                                        </p>
                                        <?php endif; ?>
                                        
                                        <?php if (!empty($cert['date_released'])): ?>
                                        <p style="margin: 0; color: #444; font-size: 1.1rem;">
                                            <strong style="color: #5d3f7e; min-width: 120px; display: inline-block;">Date Released:</strong> 
                                            <?= htmlspecialchars($cert['date_released']) ?>
                                        </p>
                                        <?php endif; ?>
                                        
                                        <?php if (!empty($cert['examinee_no'])): ?>
                                        <p style="margin: 0; color: #444; font-size: 1.1rem;">
                                            <strong style="color: #5d3f7e; min-width: 120px; display: inline-block;">Additional Details:</strong> 
                                            <?= htmlspecialchars($cert['examinee_no']) ?>
                                        </p>
                                        <?php endif; ?>
                                    </div>
                                    
                                    <div style="margin-top: 1.5rem;">
                                        <?php if (!empty($cert['pdf_path'])): ?>
                                        <button class="view-cert-btn" onclick="viewPDF('<?= $cert['pdf_path'] ?>', '<?= htmlspecialchars($cert['title']) ?>')">
                                            <span>📄</span> View Credential
                                        </button>
                                        <?php else: ?>
                                        <p class="no-pdf">PDF not available</p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <!-- Default CSC Certificate as fallback -->
                        <div class="flip-card" id="cscCard">
                            <div class="flip-inner" onmouseover="this.style.transform='rotateY(180deg)'" 
                               onmouseout="this.style.transform='rotateY(0deg)'">
                                <div class="flip-front">
                                    <div class="cert-badge">📜</div>
                                    <h3>CSC Certificate</h3>
                                    <p class="cert-issuer">Career Service Professional Examination</p>
                                    <div class="flip-hint">
                                        <span>Hover to see details</span>
                                        <span style="font-size: 1.2rem;">→</span>
                                    </div>
                                </div>
                                <div class="flip-back">
                                    <h3>📋 Certificate Details</h3>
                                    <p><strong>Rating:</strong> 90.06%</p>
                                    <p><strong>Date Released:</strong> May 02, 2025</p>
                                    <p><strong>Examinee No:</strong> 311964</p>
                                    <button class="view-cert-btn" id="showCertModal">View Credential 🏅</button>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </section>

        <!-- SPECIAL SKILLS SECTION -->
        <section id="special-skills" class="section special-skills-section">
            <div class="container">
                <h2 class="section-title"><span class="title-deco">✨</span> Special Skills <span class="title-deco">✨</span></h2>
                
                <div class="special-grid">
                    <?php if (isset($special_skills) && !empty($special_skills)): ?>
                        <?php foreach ($special_skills as $skill): ?>
                        <div class="special-skill-card" data-id="<?= $skill['id'] ?>">
                            <div class="skill-front">
                                <span class="skill-emoji"><?= html_entity_decode($skill['icon']) ?></span>
                                <h3><?= htmlspecialchars($skill['title']) ?></h3>
                                <p><?= htmlspecialchars($skill['description']) ?></p>
                                <button class="btn-small skill-reveal-btn" data-target="skill<?= $skill['id'] ?>-detail">Learn more +</button>
                            </div>
                            <div class="skill-detail hidden" id="skill<?= $skill['id'] ?>-detail">
                                <h4>Details</h4>
                                <ul>
                                    <?php 
                                    $details = explode("\n", $skill['details'] ?? '');
                                    foreach ($details as $detail): 
                                        if (trim($detail)):
                                    ?>
                                    <li><?= htmlspecialchars(trim($detail)) ?></li>
                                    <?php 
                                        endif;
                                    endforeach; 
                                    ?>
                                </ul>
                                <button class="btn-small close-detail">Close</button>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>No special skills found.</p>
                    <?php endif; ?>
                </div>
            </div>
        </section>

        <!-- HOBBIES & PERSONALITY SECTION -->
        <section id="hobbies" class="section hobbies-section">
            <div class="container">
                <h2 class="section-title"><span class="title-deco">☕</span> Cozy Corner <span class="title-deco">☕</span></h2>
                <p class="hobbies-subtitle">Things that bring me joy outside the terminal</p>
                
                <div class="hobbies-grid">
                    <?php if (isset($hobbies) && !empty($hobbies)): ?>
                        <?php foreach ($hobbies as $hobby): ?>
                        <div class="hobby-card" data-id="<?= $hobby['id'] ?>">
                            <div class="hobby-icon"><?= html_entity_decode($hobby['icon']) ?></div>
                            <h3><?= htmlspecialchars($hobby['title']) ?></h3>
                            <div class="hobby-details hidden">
                                <p><?= htmlspecialchars($hobby['description']) ?></p>
                                <p class="hobby-fav"><?= htmlspecialchars($hobby['favorite'] ?? '') ?></p>
                            </div>
                            <button class="hobby-toggle">✨</button>
                        </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>No hobbies found.</p>
                    <?php endif; ?>
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

        <!-- SKILLS SECTION -->
        <section id="skills" class="section skills-section">
            <div class="container">
                <h2 class="section-title"><span class="title-deco">☁️</span> Toolbox <span class="title-deco">☁️</span></h2>
                <div class="skills-container">
                    <?php if (isset($skill_categories) && !empty($skill_categories)): ?>
                        <?php foreach ($skill_categories as $category): ?>
                        <div class="skill-category" data-id="<?= $category['id'] ?>">
                            <h4><?= htmlspecialchars($category['name']) ?></h4>
                            <ul class="skill-items">
                                <?php 
                                $skills = explode('||', $category['skills'] ?? '');
                                $skillIds = explode('||', $category['skill_ids'] ?? '');
                                
                                foreach ($skills as $index => $skill): 
                                    if (trim($skill)):
                                        $skillId = $skillIds[$index] ?? '';
                                ?>
                                <li data-id="<?= $skillId ?>"><?= htmlspecialchars(trim($skill)) ?></li>
                                <?php 
                                    endif;
                                endforeach; 
                                ?>
                            </ul>
                        </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>No skills found.</p>
                    <?php endif; ?>
                </div>
            </div>
        </section>

        <!-- CONTACT SECTION & FOOTER -->
        <section id="contact" class="section contact-section">
            <div class="container">
                <h2 class="section-title"><span class="title-deco">✧</span> Let's Connect <span class="title-deco">✧</span></h2>
                <div class="contact-flex">
                    <div class="contact-text">
                        <p>I'm currently open to junior developer roles. feel free to reach out — i'd love to chat about code, cozy games, or your favourite tea.</p>
                        <div class="contact-links">
                            <a href="https://mail.google.com/mail/?view=cm&fs=1&to=andreardelacruz@gmail.com&su=Project%20Inquiry&body=Hi%20Andrea%2C%20I%20saw%20your%20portfolio..." target="_blank" class="contact-item">
                                📧 andreardelacruz@gmail.com
                            </a>
                            <a href="https://github.com/andreardelacruz8-wq" target="_blank" class="contact-item">💻 github.com/andreardelacruz8-wq</a>
                            <a href="https://www.facebook.com/share/18AK1dxm5y/" target="_blank" class="contact-item">ⓕ Andrea Dela Cruz</a>
                        </div>
                    </div>
                    <div class="contact-form">
                        <form id="cozyForm" action="/contact/send" method="POST">
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

    <!-- PDF Modal -->
    <div id="certModal" class="modal">
        <div class="modal-content">
            <span class="close-modal" onclick="closePDFModal()">&times;</span>
            <h3 id="modalCertTitle" style="
                color: #2e1a47;
                font-size: 1.5rem;
                margin-bottom: 15px;
                padding-right: 40px;
            ">Certificate</h3>
            
            <div class="modal-body" style="
                height: calc(100% - 80px);
                width: 100%;
                background: #f0f0f0;
                border-radius: 10px;
                overflow: hidden;
            ">
                <div id="pdfViewer">
                    <!-- PDF will be embedded here -->
                </div>
            </div>
        </div>
    </div>

    <script src="/assets/js/script.js"></script>
    
    <!-- PDF Viewer and Hamburger Menu Script -->
    <script>
    // PDF Viewer Function
    function viewPDF(pdfPath, title) {
        const modal = document.getElementById('certModal');
        const modalTitle = document.getElementById('modalCertTitle');
        const pdfViewer = document.getElementById('pdfViewer');
        
        modalTitle.textContent = title || 'Certificate';
        
        if (pdfPath && pdfPath.match(/\.pdf$/i)) {
            pdfViewer.innerHTML = `<embed src="${pdfPath}?t=${new Date().getTime()}#toolbar=0&navpanes=0&scrollbar=0" 
                                          type="application/pdf" 
                                          width="100%" 
                                          height="100%" 
                                          style="border: none; display: block;" />`;
        } else {
            pdfViewer.innerHTML = '<p style="text-align: center; color: #999; margin-top: 100px;">PDF not available</p>';
        }
        
        modal.style.display = 'block';
        document.body.style.overflow = 'hidden';
    }
    
    // Close PDF Modal Function
    function closePDFModal() {
        const modal = document.getElementById('certModal');
        const pdfViewer = document.getElementById('pdfViewer');
        
        if (modal) {
            modal.style.display = 'none';
            pdfViewer.innerHTML = '';
            document.body.style.overflow = 'auto';
        }
    }
    
    // Close with Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            const modal = document.getElementById('certModal');
            if (modal && modal.style.display === 'block') {
                closePDFModal();
            }
        }
    });
    
    // Close when clicking outside
    window.addEventListener('click', function(e) {
        const modal = document.getElementById('certModal');
        if (e.target === modal) {
            closePDFModal();
        }
    });
    
    // Handle default CSC certificate modal
    const showCertModal = document.getElementById('showCertModal');
    if (showCertModal) {
        showCertModal.addEventListener('click', function(e) {
            e.preventDefault();
            viewPDF('/assets/images/csc.pdf', 'CSC Certificate');
        });
    }
    
    // Hamburger Menu Functionality
    document.addEventListener('DOMContentLoaded', function() {
        const hamburgerBtn = document.getElementById('hamburgerBtn');
        const sidebar = document.getElementById('sidebarNav');
        const overlay = document.getElementById('sidebarOverlay');
        const sidebarClose = document.getElementById('sidebarClose');
        
        function openSidebar() {
            sidebar.classList.add('open');
            overlay.classList.add('active');
            hamburgerBtn.classList.add('active');
            document.body.style.overflow = 'hidden';
        }
        
        function closeSidebar() {
            sidebar.classList.remove('open');
            overlay.classList.remove('active');
            hamburgerBtn.classList.remove('active');
            document.body.style.overflow = '';
        }
        
        if (hamburgerBtn) {
            hamburgerBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                if (sidebar.classList.contains('open')) {
                    closeSidebar();
                } else {
                    openSidebar();
                }
            });
        }
        
        if (sidebarClose) {
            sidebarClose.addEventListener('click', closeSidebar);
        }
        
        if (overlay) {
            overlay.addEventListener('click', closeSidebar);
        }
        
        // Close sidebar when clicking a link
        document.querySelectorAll('.sidebar-link').forEach(link => {
            link.addEventListener('click', function(e) {
                const targetId = this.getAttribute('href');
                const targetElement = document.querySelector(targetId);
                if (targetElement) {
                    e.preventDefault();
                    closeSidebar();
                    setTimeout(() => {
                        targetElement.scrollIntoView({ behavior: 'smooth' });
                    }, 300);
                } else {
                    closeSidebar();
                }
            });
        });
    });
    
    // Logout function
    function logout() {
        if (confirm('Log out?')) {
            <?php if (isset($isAdmin) && $isAdmin): ?>
            window.location.href = '/admin/logout';
            <?php elseif (isset($isViewer) && $isViewer): ?>
            window.location.href = '/viewer/logout';
            <?php else: ?>
            window.location.href = '/admin/login';
            <?php endif; ?>
        }
    }
    </script>
</body>
</html>