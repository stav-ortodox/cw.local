<?php
session_start();
if ($_SESSION['login'] || $_SESSION['password']) {
    header("Location: content.php");
    die();
}

$connection = new PDO('mysql:host=localhost; dbname=academy; charset=utf8', 'root', '');
$login = $connection->query('SELECT * FROM `login`');

if ($_POST['login']) {
    foreach ($login as $log) {
        if ($_POST['login'] == $log['login'] && $_POST['password'] == $log['password']) {
            $_SESSION['login'] = $_POST['login'];
            $_SESSION['password'] = $_POST['password'];
            setcookie('color', $_POST['color'], time() + 3400);
            header("Location: content.php");
        }
    }

    echo "Неверный пароль или логин";
}

?>

<style>
    body {
        margin: 200px 300px;
    }
    input, p, select, option, label {
        font-size: 30px;
        margin: 10px;
    }
</style>

<form method="post">
    <p>Авторизируйтесь</p>
    <input type="text" name="login" required placeholder="Логин"> <br>
    <input type="password" name="password" required placeholder="Пароль"> <br>
    <label for="color">Выберите цвет фона</label><br>
    <select name="color" id="">
        <option value="blue" style="color: blue;">Синий</option>
        <option value="red" style="color: red;">Красный</option>
        <option value="lime" style="color: lime;">Лайм</option>
    </select><br>
    <input type="submit">
</form>

