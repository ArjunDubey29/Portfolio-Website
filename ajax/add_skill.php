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

$skill_name = sanitizeInput($_POST['skill_name'] ?? '');

// Validation
if (empty($skill_name)) {
    echo json_encode(['success' => false, 'message' => 'Skill name is required']);
    exit;
}

// Check if skill already exists for this user
$stmt = $pdo->prepare("SELECT id FROM skills WHERE user_id = ? AND skill_name = ?");
$stmt->execute([$_SESSION['user_id'], $skill_name]);
if ($stmt->fetch()) {
    echo json_encode(['success' => false, 'message' => 'Skill already exists']);
    exit;
}

// Insert skill
try {
    $stmt = $pdo->prepare("INSERT INTO skills (user_id, skill_name) VALUES (?, ?)");
    $stmt->execute([$_SESSION['user_id'], $skill_name]);
    
    echo json_encode(['success' => true, 'message' => 'Skill added successfully']);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Failed to add skill. Please try again.']);
}
?>
