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

$title = sanitizeInput($_POST['title'] ?? '');
$language_used = sanitizeInput($_POST['language_used'] ?? '');
$libraries_used = sanitizeInput($_POST['libraries_used'] ?? '');
$model_used = sanitizeInput($_POST['model_used'] ?? '');
$description = sanitizeInput($_POST['description'] ?? '');
$project_date = $_POST['project_date'] ?? null;

// Validation
if (empty($title)) {
    echo json_encode(['success' => false, 'message' => 'Project title is required']);
    exit;
}

// Insert project
try {
    $stmt = $pdo->prepare("INSERT INTO projects (user_id, title, language_used, libraries_used, model_used, description, project_date) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$_SESSION['user_id'], $title, $language_used, $libraries_used, $model_used, $description, $project_date]);
    
    echo json_encode(['success' => true, 'message' => 'Project added successfully']);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Failed to add project. Please try again.']);
}
?>
