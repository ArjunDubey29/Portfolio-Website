<?php
require_once '../config.php';

header('Content-Type: application/json');

if (!isLoggedIn()) {
    echo json_encode([]);
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM education WHERE user_id = ? ORDER BY year DESC");
$stmt->execute([$_SESSION['user_id']]);
$education = $stmt->fetchAll();

echo json_encode($education);
?>
