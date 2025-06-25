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
    <title>Register - Portfolio Hub</title>
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
                <li><a href="login.php">Login</a></li>
            </ul>
        </nav>
    </header>

    <main class="container">
        <div class="form-container">
            <div class="card">
                <h2 style="text-align: center; color: #d4af37; margin-bottom: 2rem;">Create Your Account</h2>
                
                <div class="message"></div>
                <div class="loading">
                    <div class="spinner"></div>
                    <p>Creating your account...</p>
                </div>

                <form id="registerForm">
                    <div class="form-group">
                        <label for="name">Full Name *</label>
                        <input type="text" id="name" name="name" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="email">Email Address *</label>
                        <input type="email" id="email" name="email" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="password">Password *</label>
                        <input type="password" id="password" name="password" class="form-control" required minlength="6">
                    </div>

                    <div class="form-group">
                        <label for="confirm_password">Confirm Password *</label>
                        <input type="password" id="confirm_password" name="confirm_password" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="phone">Phone Number</label>
                        <input type="tel" id="phone" name="phone" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="address">Address</label>
                        <textarea id="address" name="address" class="form-control" rows="3"></textarea>
                    </div>

                    <div class="form-group">
                        <label for="linkedin">LinkedIn Profile</label>
                        <input type="url" id="linkedin" name="linkedin" class="form-control" placeholder="https://linkedin.com/in/yourprofile">
                    </div>

                    <button type="submit" class="btn" style="width: 100%;">Create Account</button>
                </form>

                <p style="text-align: center; margin-top: 1rem;">
                    Already have an account? <a href="login.php" style="color: #d4af37;">Login here</a>
                </p>
            </div>
        </div>
    </main>

    <script src="script.js"></script>
</body>
</html>
