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

$name = sanitizeInput($_POST['name'] ?? '');
$issuing_organization = sanitizeInput($_POST['issuing_organization'] ?? '');
$issue_date = $_POST['issue_date'] ?? null;

// Validation
if (empty($name)) {
    echo json_encode(['success' => false, 'message' => 'Certification name is required']);
    exit;
}

// Insert certification
try {
    $stmt = $pdo->prepare("INSERT INTO certifications (user_id, name, issuing_organization, issue_date) VALUES (?, ?, ?, ?)");
    $stmt->execute([$_SESSION['user_id'], $name, $issuing_organization, $issue_date]);
    
    echo json_encode(['success' => true, 'message' => 'Certification added successfully']);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Failed to add certification. Please try again.']);
}
?>
