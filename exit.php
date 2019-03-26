<?php
// выход из профиля
session_start();
session_unset(); // очищаем сессию
header('Location: /untitled/github/task-maneger/login-form.php');
exit;
