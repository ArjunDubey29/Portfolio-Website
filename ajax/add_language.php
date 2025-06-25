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

$language = sanitizeInput($_POST['language'] ?? '');

// Validation
if (empty($language)) {
    echo json_encode(['success' => false, 'message' => 'Language is required']);
    exit;
}

// Check if language already exists for this user
$stmt = $pdo->prepare("SELECT id FROM languages_known WHERE user_id = ? AND language = ?");
$stmt->execute([$_SESSION['user_id'], $language]);
if ($stmt->fetch()) {
    echo json_encode(['success' => false, 'message' => 'Language already exists']);
    exit;
}

// Insert language
try {
    $stmt = $pdo->prepare("INSERT INTO languages_known (user_id, language) VALUES (?, ?)");
    $stmt->execute([$_SESSION['user_id'], $language]);
    
    echo json_encode(['success' => true, 'message' => 'Language added successfully']);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Failed to add language. Please try again.']);
}
?>
