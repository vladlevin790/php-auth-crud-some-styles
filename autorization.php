<?php

use src\classes\Autorization;
use src\classes\GetUserInfo;

require_once("src/classes/GetUserInfo.php");
require_once "src/classes/Autorization.php";

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$userInf = new GetUserInfo();
$userInfo = $userInf->getUserInfo();

if(!empty($userInfo)){
    header("Location: index.php");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $login = $_POST['login'];
    $password = $_POST['password'];
    $autoriz = new Autorization($login, $password);
    if ($autoriz->loginUser()) {
        header("Location: index.php");
        exit;
    } else {
        echo "Ошибка авторизации!";
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Вход</title>
    <link href="./src/styles/styles.css" rel="stylesheet">
</head>
<body>
    <h2>Вход</h2>
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <input type="text" id="login" name="login" placeholder="Логин:">
        <input type="password" id="password" name="password" placeholder="Пароль:">
        <button type="submit" value="Войти" class="btn-login">Войти</button>
    </form>
    <a href="registration.php">Регистрация</a>
</body>
</html>
