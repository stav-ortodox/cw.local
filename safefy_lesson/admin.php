<?php
session_start();
if (!$_SESSION['login'] || !$_SESSION['password']) {
    header('Location: login.php');
    die();
}

if ($_POST['unlogin']) {
    session_destroy();
    header('Location: login.php');
}

if (count($_POST) > 0) {
    header('Location: admin.php');
}

$connection = new PDO ('mysql:host=localhost; dbname=forum; charset=utf8', 'root', '');
$data = $connection->query('SELECT * FROM `comments` WHERE moderation="new" ORDER by date DESC');

?>

<style>
    body{
        margin: 20px;
        font-family: Arial, sans seriff;
    }
    * {
        font-size: 30px;
    }
    button {
        margin-top: 20px;
    }
</style>

<h1>Админка</h1>

<form method="post">
    <?foreach ($data as $comment) { ?>
    <select name="<?=$comment['id']?>" id="<?=$comment['id']?>">
        <option value="ok">OK</option>
        <option value="rejected">Отклонить</option>
    </select>
    <label for="<?=$comment['id']?>">
        <?=$comment['username'] . ' оставил комментарий "' . $comment['comment'] . "\"<br>"?>
    </label>
    <? } ?>
    <button>Модерировать</button>
</form>

<hr>
<form action="" method="post">
    <input type="submit" name="unlogin" value="Выйти из админки">
</form>

<?
foreach ($_POST as $num=>$checked) {
    if ($checked == 'ok') {
        $connection->query("UPDATE `comments` SET moderation='ok' WHERE id=$num");
    } else {
        $connection->query("UPDATE `comments` SET moderation='rejected' WHERE id=$num");
    }

}
