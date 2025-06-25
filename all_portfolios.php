<?php 
require_once 'config.php';

// Get all users with their skills for filtering
$stmt = $pdo->query("
    SELECT u.*, 
           GROUP_CONCAT(DISTINCT s.skill_name) as skills,
           GROUP_CONCAT(DISTINCT e.level) as education_levels
    FROM users u 
    LEFT JOIN skills s ON u.id = s.user_id 
    LEFT JOIN education e ON u.id = e.user_id 
    GROUP BY u.id 
    ORDER BY u.created_at DESC
");
$users = $stmt->fetchAll();

// Get all unique skills for filter dropdown
$stmt = $pdo->query("SELECT DISTINCT skill_name FROM skills ORDER BY skill_name");
$all_skills = $stmt->fetchAll();

// Get all unique education levels for filter dropdown
$stmt = $pdo->query("SELECT DISTINCT level FROM education ORDER BY level");
$all_education_levels = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Browse Portfolios - Portfolio Hub</title>
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

    <main class="container">
        <h1>Browse Portfolios</h1>
        <p>Discover talented professionals and their amazing work</p>

        <!-- Search and Filter -->
        <div class="card">
            <div class="search-filter">
                <input type="text" id="searchInput" class="form-control" placeholder="Search by name...">
                
                <select id="skillFilter" class="form-control">
                    <option value="">Filter by Skill</option>
                    <?php foreach ($all_skills as $skill): ?>
                    <option value="<?php echo htmlspecialchars($skill['skill_name']); ?>">
                        <?php echo htmlspecialchars($skill['skill_name']); ?>
                    </option>
                    <?php endforeach; ?>
                </select>
                
                <select id="educationFilter" class="form-control">
                    <option value="">Filter by Education</option>
                    <?php foreach ($all_education_levels as $level): ?>
                    <option value="<?php echo htmlspecialchars($level['level']); ?>">
                        <?php echo htmlspecialchars($level['level']); ?>
                    </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <!-- Portfolio Grid -->
        <div class="portfolio-grid">
            <?php foreach ($users as $user): ?>
            <div class="portfolio-card" 
                 data-skills="<?php echo htmlspecialchars($user['skills'] ?: ''); ?>"
                 data-education="<?php echo htmlspecialchars($user['education_levels'] ?: ''); ?>">
                
                <h3><?php echo htmlspecialchars($user['name']); ?></h3>
                
                <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
                
                <?php if ($user['linkedin']): ?>
                <p><strong>LinkedIn:</strong> 
                    <a href="<?php echo htmlspecialchars($user['linkedin']); ?>" 
                       target="_blank" style="color: #d4af37;">View Profile</a>
                </p>
                <?php endif; ?>
                
                <?php if ($user['skills']): ?>
                <div style="margin: 1rem 0;">
                    <strong>Skills:</strong>
                    <div style="display: flex; flex-wrap: wrap; gap: 0.25rem; margin-top: 0.5rem;">
                        <?php 
                        $skills_array = explode(',', $user['skills']);
                        foreach (array_slice($skills_array, 0, 3) as $skill): 
                        ?>
                        <span style="background: #d4af37; color: #000; padding: 0.25rem 0.5rem; border-radius: 10px; font-size: 0.8rem;">
                            <?php echo htmlspecialchars(trim($skill)); ?>
                        </span>
                        <?php endforeach; ?>
                        <?php if (count($skills_array) > 3): ?>
                        <span style="color: #d4af37; font-size: 0.8rem;">+<?php echo count($skills_array) - 3; ?> more</span>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endif; ?>
                
                <div style="margin-top: 1rem;">
                    <a href="portfolio.php?uid=<?php echo $user['id']; ?>" class="btn" style="width: 100%; text-align: center;">
                        View Portfolio
                    </a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <?php if (empty($users)): ?>
        <div class="card" style="text-align: center;">
            <h3>No portfolios found</h3>
            <p>Be the first to create a portfolio!</p>
            <?php if (!isLoggedIn()): ?>
            <a href="register.php" class="btn">Get Started</a>
            <?php endif; ?>
        </div>
        <?php endif; ?>
    </main>

    <script src="script.js"></script>
</body>
</html>
