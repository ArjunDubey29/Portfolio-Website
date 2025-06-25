<?php
require_once '../config.php';

header('Content-Type: application/json');

if (!isLoggedIn()) {
    echo json_encode([]);
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM projects WHERE user_id = ? ORDER BY project_date DESC");
$stmt->execute([$_SESSION['user_id']]);
$projects = $stmt->fetchAll();

echo json_encode($projects);
?>
