<?php
/**
 * Created by PhpStorm.
 * User: ErnesT
 * Date: 2019-03-20
 * Time: 22:34
 */

// получение данных из $_POST
$title = $_POST['title'];
$description = $_POST['description'];
$img = $_POST['img'];


//проверка данных
foreach ($_POST as $input) {
    if (empty($input)) {
        include 'errors.php';
        exit;
    }
}

$upload_img = './assets/img'; // Папка, куда будут загружаться файлы
$upload_img = $_FILES['img']['name']; // В переменную $filename заносим имя файла

//$filetypes = array('.jpg','.gif','.bmp','.png'); // Типы файлов
//$max_filesize = 524288; // Максимальный размер файла в байтах (в данном случае он равен 0.5 Мб)

if (move_uploaded_file($_FILES['img']['tmp_name'], $upload_img)) {
    // Подтверждает
    echo "The file ". basename( $_FILES['uploadedfile']['name']). "Картинка была добавлена в каталог.";
} else {
    //Ошибка
    echo "Проблема с загрузкой файла.";
}



//подготовка и выполнение запроса к БД
$pdo = new PDO('mysql:host=localhost; dbname=maneger', 'root', 'mysql');
$statement = $pdo->prepare($sql);

$task = $statement->fetchColumn();
if ($task) {
    $erorMessage = 'Такая задача уже существует';
    include 'errors.php';
    exit;
}



// Добовление в БД
$sql = 'INSERT INTO task(title, description) VALUE (:title, :description)';
$statement = $pdo->prepare($sql);
$result = $statement->execute($_POST);
if (!$result) {
    $erorMessage = 'Ошибка Добовления';
    include 'errors.php';
    exit;
}

//переадресация на страницу
header('location: /untitled/github/task-maneger/index.php'); exit;