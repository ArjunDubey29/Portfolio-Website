<?php
require_once '../config.php';

header('Content-Type: application/json');

if (!isLoggedIn()) {
    echo json_encode([]);
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM certifications WHERE user_id = ? ORDER BY issue_date DESC");
$stmt->execute([$_SESSION['user_id']]);
$certifications = $stmt->fetchAll();

echo json_encode($certifications);
?>
