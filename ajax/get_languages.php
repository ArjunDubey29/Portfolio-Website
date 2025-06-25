<?php
require_once '../config.php';

header('Content-Type: application/json');

if (!isLoggedIn()) {
    echo json_encode([]);
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM languages_known WHERE user_id = ? ORDER BY language");
$stmt->execute([$_SESSION['user_id']]);
$languages = $stmt->fetchAll();

echo json_encode($languages);
?>
