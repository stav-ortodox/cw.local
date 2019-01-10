<?php
session_start();
if (!$_SESSION['login'] || !$_SESSION['password']) {
    header("Location: login.php");
    die();
}

if ($_POST['unlogin']) {
    session_destroy();
    header("Location: login.php");
}

if ($_COOKIE['color']) {
    $background = $_COOKIE['color'];
    echo "<body style='background-color: $background; font-size: 40px'>";
}


?>

<body style="font-size: 40px">
<p>Страница для авторизированных пользователей</p>

<?="Привет, " . $_SESSION['login'] . "<br>";?>

<img src="https://bipbap.ru/wp-content/uploads/2017/05/VOLKI-krasivye-i-ochen-umnye-zhivotnye.jpg" alt="" width="600" style="display: block">

<form action="" method="post" style="margin: 40px; font-size: 40px;">
    <input type="submit" style="font-size: 30px;" name="unlogin" value="На страницу авторизации">
</form>
</body>
