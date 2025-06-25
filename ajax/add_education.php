<?php
require_once '../config.php';

header('Content-Type: application/json');

if (!isLoggedIn()) {
    echo json_encode(['success' => false, 'message' => 'Not authenticated']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit;
}

$level = sanitizeInput($_POST['level'] ?? '');
$institute = sanitizeInput($_POST['institute'] ?? '');
$board = sanitizeInput($_POST['board'] ?? '');
$year = (int)($_POST['year'] ?? 0);
$score = sanitizeInput($_POST['score'] ?? '');

// Validation
if (empty($level) || empty($institute) || !$year) {
    echo json_encode(['success' => false, 'message' => 'Level, institute, and year are required']);
    exit;
}

$valid_levels = ['Matriculation', 'Intermediate', 'Bachelors', 'Masters', 'PhD'];
if (!in_array($level, $valid_levels)) {
    echo json_encode(['success' => false, 'message' => 'Invalid education level']);
    exit;
}

// Insert education
try {
    $stmt = $pdo->prepare("INSERT INTO education (user_id, level, institute, board, year, score) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([$_SESSION['user_id'], $level, $institute, $board, $year, $score]);
    
    echo json_encode(['success' => true, 'message' => 'Education added successfully']);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Failed to add education. Please try again.']);
}
?>
