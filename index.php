<?php require_once 'config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portfolio Hub - Showcase Your Skills</title>
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

    <main>
        <section class="hero">
            <div class="container">
                <h1>Welcome to Portfolio Hub</h1>
                <p>Create, manage, and showcase your professional portfolio with ease</p>
                <?php if (!isLoggedIn()): ?>
                    <div style="margin-top: 2rem;">
                        <a href="register.php" class="btn">Get Started</a>
                        <a href="login.php" class="btn btn-secondary">Login</a>
                    </div>
                <?php else: ?>
                    <div style="margin-top: 2rem;">
                        <a href="dashboard.php" class="btn">Go to Dashboard</a>
                        <a href="all_portfolios.php" class="btn btn-secondary">Browse Portfolios</a>
                    </div>
                <?php endif; ?>
            </div>
        </section>

        <section class="container">
            <div class="dashboard-grid">
                <div class="card">
                    <h3>Create Your Portfolio</h3>
                    <p>Build a professional portfolio that showcases your skills, projects, and achievements. Stand out from the crowd with our elegant design.</p>
                </div>
                
                <div class="card">
                    <h3>Manage Your Profile</h3>
                    <p>Keep your information up-to-date with our easy-to-use dashboard. Add education, projects, skills, and more with just a few clicks.</p>
                </div>
                
                <div class="card">
                    <h3>Connect with Others</h3>
                    <p>Browse other portfolios, discover talented individuals, and connect with professionals in your field.</p>
                </div>
            </div>
        </section>
    </main>

    <script src="script.js"></script>
</body>
</html>
