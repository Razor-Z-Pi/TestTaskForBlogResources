<?php
require_once "../DB/connect.php";

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header('Content-Type: application/json');

$searchTerm = isset($_GET['q']) ? trim($_GET['q']) : '';

if (strlen($searchTerm) < 3) {
    echo json_encode(['error' => 'Введите минимум 3 символа']);
    exit;
}

try {
    $pdo = ConnectDB();
    
    // Запрос для поиска
    $req = $pdo -> prepare("
        SELECT p.title, c.body AS commentBody 
        FROM comments c
        JOIN posts p ON c.postId = p.id
        WHERE c.body LIKE :search
    ");
    
    // Поиск (с учетом регистра)
    $req -> execute([':search' => "%$searchTerm%"]);
    $results = $req -> fetchAll(PDO::FETCH_ASSOC);
    
    echo json_encode($results);
    
} catch (PDOException $ex) {
    echo json_encode(['error' => 'Ошибка базы данных: ' . $ex -> getMessage()]);
}

?>