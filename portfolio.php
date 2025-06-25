<?php 
require_once 'config.php';

// Get user ID from URL
$user_id = isset($_GET['uid']) ? (int)$_GET['uid'] : 0;

if (!$user_id) {
    header('Location: all_portfolios.php');
    exit;
}

// Get user data
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch();

if (!$user) {
    header('Location: all_portfolios.php');
    exit;
}

// Get user's education
$stmt = $pdo->prepare("SELECT * FROM education WHERE user_id = ? ORDER BY year DESC");
$stmt->execute([$user_id]);
$education = $stmt->fetchAll();

// Get user's projects
$stmt = $pdo->prepare("SELECT * FROM projects WHERE user_id = ? ORDER BY project_date DESC");
$stmt->execute([$user_id]);
$projects = $stmt->fetchAll();

// Get user's skills
$stmt = $pdo->prepare("SELECT * FROM skills WHERE user_id = ?");
$stmt->execute([$user_id]);
$skills = $stmt->fetchAll();

// Get user's certifications
$stmt = $pdo->prepare("SELECT * FROM certifications WHERE user_id = ? ORDER BY issue_date DESC");
$stmt->execute([$user_id]);
$certifications = $stmt->fetchAll();

// Get user's languages
$stmt = $pdo->prepare("SELECT * FROM languages_known WHERE user_id = ?");
$stmt->execute([$user_id]);
$languages = $stmt->fetchAll();

// Get user's hobbies
$stmt = $pdo->prepare("SELECT * FROM hobbies WHERE user_id = ?");
$stmt->execute([$user_id]);
$hobbies = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($user['name']); ?> - Portfolio</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="portfolio-styles.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
</head>
<body class="portfolio-body">
    <header class="portfolio-header">
        <nav class="container">
            <a href="index.php" class="logo">Portfolio Hub</a>
            <ul class="nav-links">
                <li><a href="index.php">Home</a></li>
                <li><a href="all_portfolios.php">Browse Portfolios</a></li>
                <?php if (isLoggedIn()): ?>
                    <li><a href="dashboard.php">Dashboard</a></li>
                    <li><a href="logout.php">Logout</a></li>
                <?php else: ?>
                    <li><a href="login.php">Login</a></li>
                    <li><a href="register.php">Register</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>

    <!-- Hero Section -->
    <section class="portfolio-hero">
        <div class="hero-background"></div>
        <div class="container">
            <div class="hero-content">
                <div class="hero-avatar">
                    <div class="avatar-circle">
                        <span class="avatar-initial"><?php echo strtoupper(substr($user['name'], 0, 1)); ?></span>
                    </div>
                </div>
                <h1 class="hero-name"><?php echo htmlspecialchars($user['name']); ?></h1>
                <p class="hero-title">Professional Portfolio</p>
                <div class="hero-contact">
                    <a href="mailto:<?php echo htmlspecialchars($user['email']); ?>" class="contact-btn">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                            <polyline points="22,6 12,13 2,6"></polyline>
                        </svg>
                        Get In Touch
                    </a>
                    <?php if ($user['linkedin']): ?>
                    <a href="<?php echo htmlspecialchars($user['linkedin']); ?>" target="_blank" class="linkedin-btn">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                        </svg>
                        LinkedIn
                    </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>

    <main class="portfolio-main">
        <div class="container">
            <!-- Contact Information -->
            <section class="portfolio-section">
                <div class="section-header">
                    <h2 class="section-title">Contact Information</h2>
                    <div class="section-line"></div>
                </div>
                <div class="contact-grid">
                    <div class="contact-item">
                        <div class="contact-icon">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                                <polyline points="22,6 12,13 2,6"></polyline>
                            </svg>
                        </div>
                        <div class="contact-details">
                            <h4>Email</h4>
                            <p><?php echo htmlspecialchars($user['email']); ?></p>
                        </div>
                    </div>
                    
                    <?php if (!empty($user['phone'])): ?>
                    <div class="contact-item">
                        <div class="contact-icon">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                            </svg>
                        </div>
                        <div class="contact-details">
                            <h4>Phone</h4>
                            <p><?php echo htmlspecialchars($user['phone']); ?></p>
                        </div>
                    </div>
                    <?php endif; ?>
                    
                    <?php if (!empty($user['address'])): ?>
                    <div class="contact-item">
                        <div class="contact-icon">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                <circle cx="12" cy="10" r="3"></circle>
                            </svg>
                        </div>
                        <div class="contact-details">
                            <h4>Location</h4>
                            <p><?php echo htmlspecialchars($user['address']); ?></p>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </section>

            <!-- Skills Section -->
            <?php if (!empty($skills)): ?>
            <section class="portfolio-section">
                <div class="section-header">
                    <h2 class="section-title">Skills & Expertise</h2>
                    <div class="section-line"></div>
                </div>
                <div class="skills-container">
                    <?php foreach ($skills as $skill): ?>
                    <div class="skill-badge">
                        <?php echo htmlspecialchars($skill['skill_name']); ?>
                    </div>
                    <?php endforeach; ?>
                </div>
            </section>
            <?php endif; ?>

            <!-- Education Section -->
            <?php if (!empty($education)): ?>
            <section class="portfolio-section">
                <div class="section-header">
                    <h2 class="section-title">Education</h2>
                    <div class="section-line"></div>
                </div>
                <div class="timeline">
                    <?php foreach ($education as $edu): ?>
                    <div class="timeline-item">
                        <div class="timeline-marker"></div>
                        <div class="timeline-content">
                            <div class="timeline-header">
                                <h3><?php echo htmlspecialchars($edu['level']); ?></h3>
                                <span class="timeline-year"><?php echo htmlspecialchars($edu['year']); ?></span>
                            </div>
                            <h4><?php echo htmlspecialchars($edu['institute']); ?></h4>
                            <?php if (!empty($edu['board'])): ?>
                            <p class="timeline-subtitle"><?php echo htmlspecialchars($edu['board']); ?></p>
                            <?php endif; ?>
                            <?php if (!empty($edu['score'])): ?>
                            <div class="timeline-score">Score: <?php echo htmlspecialchars($edu['score']); ?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </section>
            <?php endif; ?>

            <!-- Projects Section -->
            <?php if (!empty($projects)): ?>
            <section class="portfolio-section">
                <div class="section-header">
                    <h2 class="section-title">Featured Projects</h2>
                    <div class="section-line"></div>
                </div>
                <div class="projects-grid">
                    <?php foreach ($projects as $project): ?>
                    <div class="project-card">
                        <div class="project-header">
                            <h3><?php echo htmlspecialchars($project['title']); ?></h3>
                            <?php if (!empty($project['project_date'])): ?>
                            <span class="project-date"><?php echo date('M Y', strtotime($project['project_date'])); ?></span>
                            <?php endif; ?>
                        </div>
                        
                        <?php if (!empty($project['description'])): ?>
                        <p class="project-description"><?php echo htmlspecialchars($project['description']); ?></p>
                        <?php endif; ?>
                        
                        <div class="project-tech">
                            <?php if (!empty($project['language_used'])): ?>
                            <div class="tech-group">
                                <span class="tech-label">Languages:</span>
                                <div class="tech-tags">
                                    <?php 
                                    $languages_used = explode(',', $project['language_used']);
                                    foreach ($languages_used as $lang): 
                                        $lang = trim($lang);
                                        if (!empty($lang)):
                                    ?>
                                    <span class="tech-tag"><?php echo htmlspecialchars($lang); ?></span>
                                    <?php 
                                        endif;
                                    endforeach; 
                                    ?>
                                </div>
                            </div>
                            <?php endif; ?>
                            
                            <?php if (!empty($project['libraries_used'])): ?>
                            <div class="tech-group">
                                <span class="tech-label">Libraries:</span>
                                <div class="tech-tags">
                                    <?php 
                                    $libraries_used = explode(',', $project['libraries_used']);
                                    foreach ($libraries_used as $lib): 
                                        $lib = trim($lib);
                                        if (!empty($lib)):
                                    ?>
                                    <span class="tech-tag"><?php echo htmlspecialchars($lib); ?></span>
                                    <?php 
                                        endif;
                                    endforeach; 
                                    ?>
                                </div>
                            </div>
                            <?php endif; ?>
                            
                            <?php if (!empty($project['model_used'])): ?>
                            <div class="tech-group">
                                <span class="tech-label">Model:</span>
                                <span class="model-badge"><?php echo htmlspecialchars($project['model_used']); ?></span>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </section>
            <?php endif; ?>

            <!-- Certifications Section -->
            <?php if (!empty($certifications)): ?>
            <section class="portfolio-section">
                <div class="section-header">
                    <h2 class="section-title">Certifications</h2>
                    <div class="section-line"></div>
                </div>
                <div class="certifications-grid">
                    <?php foreach ($certifications as $cert): ?>
                    <div class="certification-card">
                        <div class="cert-icon">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"></path>
                            </svg>
                        </div>
                        <div class="cert-content">
                            <h4><?php echo htmlspecialchars($cert['name']); ?></h4>
                            <?php if (!empty($cert['issuing_organization'])): ?>
                            <p class="cert-org"><?php echo htmlspecialchars($cert['issuing_organization']); ?></p>
                            <?php endif; ?>
                            <?php if (!empty($cert['issue_date'])): ?>
                            <span class="cert-date"><?php echo date('M Y', strtotime($cert['issue_date'])); ?></span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </section>
            <?php endif; ?>

            <!-- Languages & Hobbies -->
            <div class="two-column-section">
                <?php if (!empty($languages)): ?>
                <section class="portfolio-section">
                    <div class="section-header">
                        <h2 class="section-title">Languages</h2>
                        <div class="section-line"></div>
                    </div>
                    <div class="languages-container">
                        <?php foreach ($languages as $lang): ?>
                        <div class="language-item">
                            <div class="language-icon">🌐</div>
                            <span><?php echo htmlspecialchars($lang['language']); ?></span>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </section>
                <?php endif; ?>

                <?php if (!empty($hobbies)): ?>
                <section class="portfolio-section">
                    <div class="section-header">
                        <h2 class="section-title">Interests</h2>
                        <div class="section-line"></div>
                    </div>
                    <div class="hobbies-container">
                        <?php foreach ($hobbies as $hobby): ?>
                        <div class="hobby-item">
                            <div class="hobby-icon">✨</div>
                            <span><?php echo htmlspecialchars($hobby['hobby']); ?></span>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </section>
                <?php endif; ?>
            </div>

            <!-- Contact Form Section -->
            <section class="portfolio-section contact-section">
                <div class="section-header">
                    <h2 class="section-title">Let's Connect</h2>
                    <div class="section-line"></div>
                    <p class="section-subtitle">Have a project in mind? Let's discuss how we can work together.</p>
                </div>
                
                <div class="contact-form-container">
                    <div class="message"></div>
                    <div class="loading">
                        <div class="spinner"></div>
                        <p>Sending message...</p>
                    </div>

                    <form id="contactForm" class="elegant-form">
                        <input type="hidden" name="receiver_user_id" value="<?php echo $user_id; ?>">
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="sender_name">Your Name</label>
                                <input type="text" id="sender_name" name="sender_name" class="form-control" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="sender_email">Your Email</label>
                                <input type="email" id="sender_email" name="sender_email" class="form-control" required>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="message">Message</label>
                            <textarea id="message" name="message" class="form-control" rows="6" required placeholder="Tell me about your project or how we can collaborate..."></textarea>
                        </div>
                        
                        <button type="submit" class="submit-btn">
                            <span>Send Message</span>
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <line x1="22" y1="2" x2="11" y2="13"></line>
                                <polygon points="22,2 15,22 11,13 2,9 22,2"></polygon>
                            </svg>
                        </button>
                    </form>
                </div>
            </section>
        </div>
    </main>

    <footer class="portfolio-footer">
        <div class="container">
            <p>&copy; <?php echo date('Y'); ?> <?php echo htmlspecialchars($user['name']); ?>. All rights reserved.</p>
        </div>
    </footer>

    <script src="script.js"></script>
</body>
</html>
