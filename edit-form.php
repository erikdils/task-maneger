<?php
session_start();
if(!isset($_SESSION['user_id'])) {
    header('Location: /untitled/github/task-maneger/login-form.php');
    exit;
}

$id = $_GET['id'];

//подготовка и выполнение запроса к БД
$pdo = new PDO("mysql:host=localhost; dbname=maneger", 'root', 'mysql');
$sql = 'SELECT * from task where id=:id';
$statement = $pdo->prepare($sql);
$statement->execute([':id'  =>  $id]);
$task = $statement->fetch(PDO::FETCH_ASSOC);
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">

    <title>Edit Task</title>

    <!-- Bootstrap core CSS -->
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
    
    <style>
      
    </style>
  </head>

  <body>
    <div class="form-wrapper text-center">
      <form class="form-signin" action="edit_update.php?id=<?= $task['id']; ?>" method="post" enctype="multipart/form-data">
        <img class="mb-4" src="assets/img/bootstrap-solid.svg" alt="" width="72" height="72">
        <h1 class="h3 mb-3 font-weight-normal">Добавить запись</h1>
        <label for="inputEmail" class="sr-only">Название</label>
        <input type="text" name="title" id="inputEmail" class="form-control" placeholder="Название" required value="<?= $task['title']; ?>">
        <label for="inputEmail" class="sr-only">Описание</label>
        <textarea name="description" class="form-control" cols="30" rows="10" placeholder="Описание"><?= $task['description']; ?></textarea>
        <input type="file" name="img">
        <img src="assets/img/<?= $task['img']; ?>" alt="" width="300" class="mb-3">
        <button class="btn btn-lg btn-success btn-block" type="submit">Редактировать</button>
        <p class="mt-5 mb-3 text-muted">&copy; 2018-2019</p>
      </form>
    </div>
  </body>
</html>
