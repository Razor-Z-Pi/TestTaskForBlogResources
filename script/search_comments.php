<?php
require_once "../DB/connect.php";

<<<<<<< HEAD
// Настройка CORS
=======
>>>>>>> 134c5c0584c20220c3266d14a90e9f8509badef4
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header('Content-Type: application/json');

$searchTerm = isset($_GET['q']) ? trim($_GET['q']) : '';

if (strlen($searchTerm) < 3) {
<<<<<<< HEAD
    echo json_encode(['error' => 'Введите минимум 3 символа!!!']);
=======
    echo json_encode(['error' => 'Введите минимум 3 символа']);
>>>>>>> 134c5c0584c20220c3266d14a90e9f8509badef4
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