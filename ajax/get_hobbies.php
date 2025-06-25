<?php
require_once '../config.php';

header('Content-Type: application/json');

if (!isLoggedIn()) {
    echo json_encode([]);
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM hobbies WHERE user_id = ? ORDER BY hobby");
$stmt->execute([$_SESSION['user_id']]);
$hobbies = $stmt->fetchAll();

echo json_encode($hobbies);
?>
