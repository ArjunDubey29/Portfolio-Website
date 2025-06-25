<?php
require_once '../config.php';

header('Content-Type: application/json');

if (!isLoggedIn()) {
    echo json_encode([]);
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM skills WHERE user_id = ? ORDER BY skill_name");
$stmt->execute([$_SESSION['user_id']]);
$skills = $stmt->fetchAll();

echo json_encode($skills);
?>
