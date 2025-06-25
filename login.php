<?php 
require_once 'config.php';

// Redirect if already logged in
if (isLoggedIn()) {
    header('Location: dashboard.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Portfolio Hub</title>
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
                <li><a href="register.php">Register</a></li>
            </ul>
        </nav>
    </header>

    <main class="container">
        <div class="form-container">
            <div class="card">
                <h2 style="text-align: center; color: #d4af37; margin-bottom: 2rem;">Welcome Back</h2>
                
                <div class="message"></div>
                <div class="loading">
                    <div class="spinner"></div>
                    <p>Logging you in...</p>
                </div>

                <form id="loginForm">
                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="email" id="email" name="email" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" class="form-control" required>
                    </div>

                    <button type="submit" class="btn" style="width: 100%;">Login</button>
                </form>

                <p style="text-align: center; margin-top: 1rem;">
                    Don't have an account? <a href="register.php" style="color: #d4af37;">Register here</a>
                </p>
            </div>
        </div>
    </main>

    <script src="script.js"></script>
</body>
</html>
