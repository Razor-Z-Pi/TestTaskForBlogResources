<?php
require_once "../DB/connect.php";

$pdo = ConnectDB(); 

//Загрузка JSON по URL
function FetchJsonData($url) {
    $response = file_get_contents($url);
    if ($response === false) {
        throw new Exception("Не удалось загрузить данные с $url");
    }
    return json_decode($response, true);
}

try {
    $posts = FetchJsonData('https://jsonplaceholder.typicode.com/posts');
    $comments = FetchJsonData('https://jsonplaceholder.typicode.com/comments');

    $pdo -> beginTransaction();

    // Загружаем посты
    $postReq = $pdo -> prepare("INSERT INTO posts (id, title, body, userId) VALUES (:id, :title, :body, :userId)");
    $postsCount = 0;

     foreach ($posts as $post) {
        $postReq->execute([
            ':id' => $post['id'],
            ':title' => $post['title'],
            ':body' => $post['body'],
            ':userId' => $post['userId']
        ]);
        $postsCount++;
    }

    // Загружаем комментарии
    $commentReq = $pdo -> prepare("INSERT INTO comments (id, name, email, body, postId) VALUES (:id, :name, :email, :body, :postId)");
    $commentsCount = 0;
    
    foreach ($comments as $comment) {
        $commentReq -> execute([
            ':id' => $comment['id'],
            ':name' => $comment['name'],
            ':email' => $comment['email'],
            ':body' => $comment['body'],
            ':postId' => $comment['postId']
        ]);
        $commentsCount++;
    }

    $pdo -> commit();

    echo "Загружено $postsCount записей и $commentsCount комментариев!!!\n";

} catch (Exception $ex) {
    $pdo -> rollBack() or die("Ошибка: " . $e->getMessage());
}

?>