<?php
session_start();
if ($_SESSION['login'] || $_SESSION['password']) {
    header("Location: content.php");
    die();
}

if ($_POST['first']) {
    setcookie('first', $_POST['first'], time() + 20);
    setcookie('second', $_POST['second'], time() + 40);
    header('Location: index.php');
}
?>

<form action="" method="post">
    <input type="text" name="first" required>
    <input type="text" name="second" required>
    <button>Отправить</button>
</form>

<?
echo $_COOKIE['first'] . ' ' . $_COOKIE['second'] . "<br>";
var_dump($_COOKIE);
?>