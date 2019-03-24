<?php
//пропускаем только авторизованного пользователя
session_start();
if(!isset($_SESSION['user_id'])) {
    header('Location: /login-form.php');
    exit;
}

//получаем данные из $_POST и $_FILES
$title = $_POST['title'];
$description = $_POST['description'];
$img = $_FILES['img'];
$id = $_GET['id'];

//
$update = [
    ":title"	=>	$title,
    ":description"	=>	$description,
    ":img"	=>	$img['name'],
    ":id"	=>	$id
];

//удаляем картинку если существует
if(file_exists('assets/img/' . $task['img'])) {
    unlink('assets/img/' . $task['img']);
}
//загрузка картинки в дерикторию с папкой
move_uploaded_file($img['tmp_name'], 'assets/img/' . $img['name']);

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
//подготовка запроса в БД
$pdo = new PDO('mysql:host=localhost;dbname=maneger', 'root', 'mysql');
$sql = 'SELECT * FROM task WHERE id=:id';
$statement = $pdo->prepare($sql);
$statement->execute([':id'	=>	$id]);
$task = $statement->fetch(PDO::FETCH_ASSOC);


//подготовка обновления запроса к БД
$sql = "UPDATE task SET title=:title, description=:description, img=:img WHERE id=:id";
$statement = $pdo->prepare($sql);
$update = $statement->execute($update);



//переадресация на страницу
header('location: /untitled/github/task-maneger/index.php'); exit;