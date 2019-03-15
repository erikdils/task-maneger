<?php
// получение данных из $_POST
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
$pdo = new PDO('mysql:host=localhost;dbname=maneger', 'root', 'mysql');
$sql = 'SELECT id FROM user WHERE email=:email AND password=:password';
$statement = $pdo->prepare($sql);
$statement->execute([':email' => $email, ':password' => md5($password)]);
$user = $statement->fetch(PDO::FETCH_ASSOC);

//не нашли пользователя
if ($user) {
    $erorMessage = 'Не верный логин или пароль';
    include 'errors.php';
    exit;
}

// записываем данные в сессию
session_start();
$_SESSION['user_id'] = $user['id'];
$_SESSION['email'] = $user['email'];

//переадресация

header('Location: /untitled/github/task-maneger/index.php');
exit;
