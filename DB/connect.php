<?php
function ConnectDB() {
    $connect = new PDO("mysql:host=localhost;dbname=testtaskdbblog", "root", "") or die("Ошибка подключения БД!!!");
    return $connect;
};
?>