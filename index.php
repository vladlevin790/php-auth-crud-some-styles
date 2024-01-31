<?php

use src\classes\GetUserInfo;

require_once("src/classes/GetUserInfo.php");

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$userInf = new GetUserInfo();
$userInfo = $userInf ->getUserInfo();

if(empty($userInfo)){
    header("Location: autorization.php");
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Личный кабинет</title>
    <link href="./src/styles/styles.css" rel="stylesheet">
</head>
<body>
    <h2>Личный кабинет</h2>
    <p>Имя: <?php echo $userInfo['name']; ?></p>
    <p>Дата рождения: <?php echo $userInfo['birth_day']; ?></p>
    <a href="quit.php">Выйти</a>
    <a href="main-page.php">Главная страница</a>
</body>
</html>
