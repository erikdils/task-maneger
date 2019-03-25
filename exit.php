<?php
session_start();
session_destroy();
header('Location: /untitled/github/task-maneger/login-form.php');
exit;
