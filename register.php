<?php
// получение данных из $_POST
$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];

//проверка данных
foreach ($_POST as $input) {
    if (empty($input)) {
        include 'errors.php';
        exit;
    }
}

//подготовка и выполнение запроса к БД проверка человека
$pdo = new PDO('mysql:host=localhost; dbname=maneger', 'root', 'mysql');
$sql = 'SELECT id FROM user WHERE email=:email';
$statement = $pdo->prepare($sql);
$statement->execute([':email' => $email]);
$user = $statement->fetchColumn();
if ($user) {
    $erorMessage = 'Пользователь с таким email уже существует';
    include 'errors.php';
    exit;
}


// добовление в БД
$sql = 'INSERT INTO users(username, email, password) VALUE (:username, :email, :password)';
$statement = $pdo->prepare($sql);
//password hash
$_POST['password'] = md5($_POST['password']);
$result = $statement->execute($_POST);
if (!$result) {
    $erorMessage = 'Ошиька Регистрации';
    include 'errors.php';
    exit;
}

//переадресация на страницу
header('location: /untitled/github/task-maneger/login-form.php'); exit;