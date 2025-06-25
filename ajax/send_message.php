<?php
require_once '../config.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit;
}

$sender_name = sanitizeInput($_POST['sender_name'] ?? '');
$sender_email = sanitizeInput($_POST['sender_email'] ?? '');
$message = sanitizeInput($_POST['message'] ?? '');
$receiver_user_id = (int)($_POST['receiver_user_id'] ?? 0);

// Validation
if (empty($sender_name) || empty($sender_email) || empty($message) || !$receiver_user_id) {
    echo json_encode(['success' => false, 'message' => 'All fields are required']);
    exit;
}

if (!filter_var($sender_email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['success' => false, 'message' => 'Invalid email format']);
    exit;
}

// Check if receiver exists
$stmt = $pdo->prepare("SELECT id FROM users WHERE id = ?");
$stmt->execute([$receiver_user_id]);
if (!$stmt->fetch()) {
    echo json_encode(['success' => false, 'message' => 'Invalid recipient']);
    exit;
}

// Insert message
try {
    $stmt = $pdo->prepare("INSERT INTO messages (sender_name, sender_email, message, receiver_user_id) VALUES (?, ?, ?, ?)");
    $stmt->execute([$sender_name, $sender_email, $message, $receiver_user_id]);
    
    echo json_encode(['success' => true, 'message' => 'Message sent successfully']);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Failed to send message. Please try again.']);
}
?>
