
<?php

    $id = $_GET['id'];

    $sql = 'DELETE FROM task WHERE id=:id';
    $pdo = new PDO('mysql:host=localhost; dbname=maneger', 'root', 'mysql');
    $statement = $pdo->prepare($sql);
    $statement->bindParam("id", $id);
    $statement->execute();

    header('Location: /untitled/github/task-maneger/index.php'); exit;