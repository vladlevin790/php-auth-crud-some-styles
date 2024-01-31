<?php

use src\classes\GetUserInfo;
use src\classes\Registration;

require_once("src/classes/GetUserInfo.php");
require_once ("./src/classes/Registration.php");
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}


$userInf = new GetUserInfo();
$userInfo = $userInf->getUserInfo();

if(!empty($userInfo)){
    header("Location: index.php");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $login = $_POST['login'];
    $password = $_POST['password'];
    $birth_day = $_POST['birth_day'];
    $register = new Registration($name, $login, $password, $birth_day);

    if ($register->registerUser()) {
        echo "Пользователь успешно зарегистрирован!";
    } else {
        echo "Ошибка при регистрации пользователя!";
    }
    header("Location: index.php");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Регистрация</title>
    <link href="./src/styles/styles.css" rel="stylesheet">
</head>
<body>
    <h2>Регистрация</h2>
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <label for="name">Имя:</label>
           <input type="text" id="name" name="name">
           <label for="login">Логин:</label>
           <input type="text" id="login" name="login">
           <label for="password">Пароль:</label>
           <input type="password" id="password" name="password">
           <label for="birth_day">Дата рождения:</label>
           <input type="date" id="birth_day" name="birth_day">
           <button type="submit" value="Зарегистрироваться" class="btn-register">Регистрация</button>
    </form>
    <a href="autorization.php">Выйти</a>
</body>
</html>

