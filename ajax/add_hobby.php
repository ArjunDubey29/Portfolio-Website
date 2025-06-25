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

$hobby = sanitizeInput($_POST['hobby'] ?? '');

// Validation
if (empty($hobby)) {
    echo json_encode(['success' => false, 'message' => 'Hobby is required']);
    exit;
}

// Check if hobby already exists for this user
$stmt = $pdo->prepare("SELECT id FROM hobbies WHERE user_id = ? AND hobby = ?");
$stmt->execute([$_SESSION['user_id'], $hobby]);
if ($stmt->fetch()) {
    echo json_encode(['success' => false, 'message' => 'Hobby already exists']);
    exit;
}

// Insert hobby
try {
    $stmt = $pdo->prepare("INSERT INTO hobbies (user_id, hobby) VALUES (?, ?)");
    $stmt->execute([$_SESSION['user_id'], $hobby]);
    
    echo json_encode(['success' => true, 'message' => 'Hobby added successfully']);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Failed to add hobby. Please try again.']);
}
?>
