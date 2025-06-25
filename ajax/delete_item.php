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

$type = sanitizeInput($_POST['type'] ?? '');
$id = (int)($_POST['id'] ?? 0);

if (empty($type) || !$id) {
    echo json_encode(['success' => false, 'message' => 'Invalid parameters']);
    exit;
}

// Define valid types and their corresponding tables
$valid_types = [
    'education' => 'education',
    'project' => 'projects',
    'skill' => 'skills',
    'certification' => 'certifications',
    'language' => 'languages_known',
    'hobby' => 'hobbies'
];

if (!isset($valid_types[$type])) {
    echo json_encode(['success' => false, 'message' => 'Invalid type']);
    exit;
}

$table = $valid_types[$type];

try {
    $stmt = $pdo->prepare("DELETE FROM $table WHERE id = ? AND user_id = ?");
    $stmt->execute([$id, $_SESSION['user_id']]);
    
    if ($stmt->rowCount() > 0) {
        echo json_encode(['success' => true, 'message' => 'Item deleted successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Item not found or access denied']);
    }
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Failed to delete item. Please try again.']);
}
?>
