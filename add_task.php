<?php
session_start();
if(!isset($_SESSION['user_id'])) {
    header('Location: /login-form.php');
    exit;
}
//получение данных из $_POST и $_FILES
$title = $_POST['title'];
$description = $_POST['description'];
$img = $_FILES['img'];
//проверка данных
foreach($_POST as $input) {
    if(empty($input)) {
        include 'errors.php';
        exit;
    }
}
//картинка не загружена
if($image['error'] === 4) {
    $errorMessage = 'Загрузите картинку';
    include 'errors.php';
    exit;
}
//загрузка картинки в папку uploads
move_uploaded_file($img['tmp_name'], 'assets/img/' . $img['name']);
//подготовка и выполнение запроса к БД
$pdo = new PDO('mysql:host=localhost; dbname=maneger', 'root', 'mysql');
$sql = "INSERT INTO task (title, description, img, user_id) VALUES (:title, :description, :img, :user_id)";
$statement = $pdo->prepare($sql);
$r = $statement->execute([
    ":title"	=>	$title,
    ":description"	=>	$description,
    ":img"	=>	$img['name'],
    ":user_id"	=>	$_SESSION['user_id']
]);
header('Location: /untitled/github/task-maneger/index.php');