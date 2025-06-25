<?php 
require_once 'config.php';
requireLogin();

// Get user data
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Portfolio Hub</title>
    <link rel="stylesheet" href="styles.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <header>
        <nav class="container">
            <a href="index.php" class="logo">Portfolio Hub</a>
            <ul class="nav-links">
                <li><a href="index.php">Home</a></li>
                <li><a href="all_portfolios.php">Browse Portfolios</a></li>
                <li><a href="portfolio.php?uid=<?php echo $_SESSION['user_id']; ?>">My Portfolio</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>

    <main class="container" id="dashboard">
        <h1>Welcome, <?php echo htmlspecialchars($user['name']); ?>!</h1>
        
        <div class="message"></div>
        <div class="loading">
            <div class="spinner"></div>
        </div>

        <!-- Profile Section -->
        <div class="card">
            <div class="section-header">
                <h3>Profile Information</h3>
            </div>
            
            <form id="profileForm">
                <div class="dashboard-grid">
                    <div class="form-group">
                        <label for="profile_name">Full Name</label>
                        <input type="text" id="profile_name" name="name" class="form-control" value="<?php echo htmlspecialchars($user['name']); ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="profile_email">Email</label>
                        <input type="email" id="profile_email" name="email" class="form-control" value="<?php echo htmlspecialchars($user['email']); ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="profile_phone">Phone</label>
                        <input type="tel" id="profile_phone" name="phone" class="form-control" value="<?php echo htmlspecialchars($user['phone']); ?>">
                    </div>
                    
                    <div class="form-group">
                        <label for="profile_linkedin">LinkedIn</label>
                        <input type="url" id="profile_linkedin" name="linkedin" class="form-control" value="<?php echo htmlspecialchars($user['linkedin']); ?>">
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="profile_address">Address</label>
                    <textarea id="profile_address" name="address" class="form-control" rows="3"><?php echo htmlspecialchars($user['address']); ?></textarea>
                </div>
                
                <button type="submit" class="btn">Update Profile</button>
            </form>
        </div>

        <!-- Education Section -->
        <div class="card">
            <div class="section-header">
                <h3>Education</h3>
                <button class="btn modal-trigger" data-modal="addEducationModal">Add Education</button>
            </div>
            <div id="educationList"></div>
        </div>

        <!-- Projects Section -->
        <div class="card">
            <div class="section-header">
                <h3>Projects</h3>
                <button class="btn modal-trigger" data-modal="addProjectModal">Add Project</button>
            </div>
            <div id="projectsList"></div>
        </div>

        <!-- Skills Section -->
        <div class="card">
            <div class="section-header">
                <h3>Skills</h3>
            </div>
            <form id="addSkillForm" style="margin-bottom: 1rem;">
                <div style="display: flex; gap: 1rem;">
                    <input type="text" id="skill_name" name="skill_name" class="form-control" placeholder="Enter a skill" required>
                    <button type="submit" class="btn">Add Skill</button>
                </div>
            </form>
            <div id="skillsList"></div>
        </div>

        <!-- Certifications Section -->
        <div class="card">
            <div class="section-header">
                <h3>Certifications</h3>
                <button class="btn modal-trigger" data-modal="addCertificationModal">Add Certification</button>
            </div>
            <div id="certificationsList"></div>
        </div>

        <!-- Languages Section -->
        <div class="card">
            <div class="section-header">
                <h3>Languages Known</h3>
            </div>
            <form id="addLanguageForm" style="margin-bottom: 1rem;">
                <div style="display: flex; gap: 1rem;">
                    <input type="text" id="language_name" name="language" class="form-control" placeholder="Enter a language" required>
                    <button type="submit" class="btn">Add Language</button>
                </div>
            </form>
            <div id="languagesList"></div>
        </div>

        <!-- Hobbies Section -->
        <div class="card">
            <div class="section-header">
                <h3>Hobbies</h3>
            </div>
            <form id="addHobbyForm" style="margin-bottom: 1rem;">
                <div style="display: flex; gap: 1rem;">
                    <input type="text" id="hobby_name" name="hobby" class="form-control" placeholder="Enter a hobby" required>
                    <button type="submit" class="btn">Add Hobby</button>
                </div>
            </form>
            <div id="hobbiesList"></div>
        </div>
    </main>

    <!-- Modals -->
    <!-- Add Education Modal -->
    <div id="addEducationModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h3>Add Education</h3>
            <form id="addEducationForm">
                <div class="form-group">
                    <label for="education_level">Level</label>
                    <select id="education_level" name="level" class="form-control" required>
                        <option value="">Select Level</option>
                        <option value="Matriculation">Matriculation</option>
                        <option value="Intermediate">Intermediate</option>
                        <option value="Bachelors">Bachelors</option>
                        <option value="Masters">Masters</option>
                        <option value="PhD">PhD</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="education_institute">Institute</label>
                    <input type="text" id="education_institute" name="institute" class="form-control" required>
                </div>
                
                <div class="form-group">
                    <label for="education_board">Board/University</label>
                    <input type="text" id="education_board" name="board" class="form-control">
                </div>
                
                <div class="form-group">
                    <label for="education_year">Year</label>
                    <input type="number" id="education_year" name="year" class="form-control" min="1950" max="2030" required>
                </div>
                
                <div class="form-group">
                    <label for="education_score">Score/Grade</label>
                    <input type="text" id="education_score" name="score" class="form-control" placeholder="e.g., 3.8 GPA, 85%">
                </div>
                
                <button type="submit" class="btn">Add Education</button>
            </form>
        </div>
    </div>

    <!-- Add Project Modal -->
    <div id="addProjectModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h3>Add Project</h3>
            <form id="addProjectForm">
                <div class="form-group">
                    <label for="project_title">Project Title</label>
                    <input type="text" id="project_title" name="title" class="form-control" required>
                </div>
                
                <div class="form-group">
                    <label for="project_language">Languages Used</label>
                    <input type="text" id="project_language" name="language_used" class="form-control" placeholder="e.g., Python, JavaScript">
                </div>
                
                <div class="form-group">
                    <label for="project_libraries">Libraries/Frameworks</label>
                    <input type="text" id="project_libraries" name="libraries_used" class="form-control" placeholder="e.g., React, Django, TensorFlow">
                </div>
                
                <div class="form-group">
                    <label for="project_model">Model Used</label>
                    <input type="text" id="project_model" name="model_used" class="form-control" placeholder="e.g., CNN, LSTM, Random Forest">
                </div>
                
                <div class="form-group">
                    <label for="project_description">Description</label>
                    <textarea id="project_description" name="description" class="form-control" rows="4"></textarea>
                </div>
                
                <div class="form-group">
                    <label for="project_date">Project Date</label>
                    <input type="date" id="project_date" name="project_date" class="form-control">
                </div>
                
                <button type="submit" class="btn">Add Project</button>
            </form>
        </div>
    </div>

    <!-- Add Certification Modal -->
    <div id="addCertificationModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h3>Add Certification</h3>
            <form id="addCertificationForm">
                <div class="form-group">
                    <label for="cert_name">Certification Name</label>
                    <input type="text" id="cert_name" name="name" class="form-control" required>
                </div>
                
                <div class="form-group">
                    <label for="cert_organization">Issuing Organization</label>
                    <input type="text" id="cert_organization" name="issuing_organization" class="form-control">
                </div>
                
                <div class="form-group">
                    <label for="cert_date">Issue Date</label>
                    <input type="date" id="cert_date" name="issue_date" class="form-control">
                </div>
                
                <button type="submit" class="btn">Add Certification</button>
            </form>
        </div>
    </div>

    <script src="script.js"></script>
    <script>
        // Additional dashboard-specific JavaScript
        $(document).ready(function() {
            // Add Language Form
            $('#addLanguageForm').on('submit', function(e) {
                e.preventDefault();
                
                const language = $('#language_name').val();
                
                $.ajax({
                    url: 'ajax/add_language.php',
                    type: 'POST',
                    data: { language: language },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            showMessage('Language added successfully!', 'success');
                            loadLanguages();
                            $('#language_name').val('');
                        } else {
                            showMessage(response.message, 'error');
                        }
                    }
                });
            });

            // Add Hobby Form
            $('#addHobbyForm').on('submit', function(e) {
                e.preventDefault();
                
                const hobby = $('#hobby_name').val();
                
                $.ajax({
                    url: 'ajax/add_hobby.php',
                    type: 'POST',
                    data: { hobby: hobby },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            showMessage('Hobby added successfully!', 'success');
                            loadHobbies();
                            $('#hobby_name').val('');
                        } else {
                            showMessage(response.message, 'error');
                        }
                    }
                });
            });

            // Add Certification Form
            $('#addCertificationForm').on('submit', function(e) {
                e.preventDefault();
                
                const formData = $(this).serialize();
                
                $.ajax({
                    url: 'ajax/add_certification.php',
                    type: 'POST',
                    data: formData,
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            showMessage('Certification added successfully!', 'success');
                            $('#addCertificationModal').hide();
                            loadCertifications();
                            $('#addCertificationForm')[0].reset();
                        } else {
                            showMessage(response.message, 'error');
                        }
                    }
                });
            });
        });
    </script>
</body>
</html>
