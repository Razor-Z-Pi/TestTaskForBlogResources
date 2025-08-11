-- Создание БД
CREATE DATABASE IF NOT EXISTS testtaskdbblog;

-- Создание таблицы постов
CREATE TABLE IF NOT EXISTS posts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(80) NOT NULL,
    body TEXT NOT NULL,
    userId INT NOT NULL
)

-- Создание таблицы комментариев
CREATE TABLE IF NOT EXISTS comments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    email VARCHAR(50) NOT NULL,
    body TEXT NOT NULL,
    postId INT NOT NULL,
    FOREIGN KEY (postId) REFERENCES posts(id) ON DELETE CASCADE
)