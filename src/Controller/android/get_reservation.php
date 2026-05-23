<?php
header('Content-Type: application/json');
session_start();

$clientId = $_SESSION['id'] ?? $_GET['client_id'] ?? '';

if (!$clientId) {
    echo json_encode(['error' => 'Client manquant']);
    exit;
}

$pdo = new PDO(
    "mysql:host=" . $_ENV['DB_HOST'] . ";dbname=" . $_ENV['DB_NAME'] . ";charset=utf8mb4",
    $_ENV['DB_USER'],
    $_ENV['DB_PASS'],
    [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
);

$sql = "SELECT r.*, m.titre, m.salle
        FROM reservation r
        JOIN movie m ON r.movie_id = m.id
        WHERE r.client_id = :client_id
        ORDER BY r.id DESC
        LIMIT 1";

$stmt = $pdo->prepare($sql);
$stmt->execute([':client_id' => $clientId]);

$reservation = $stmt->fetch(PDO::FETCH_ASSOC);

echo json_encode($reservation);
?>