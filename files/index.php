<?php

$connection = new PDO ('mysql:host=localhost; dbname=academy; charset=utf8', 'root', '');

if (isset($_COOKIE['message'])) {
    echo $_COOKIE['message'];
}

$input_name = 'file';

    if (isset($_FILES[$input_name])) {

        $files = array();
    $diff = count($_FILES[$input_name]) - count($_FILES[$input_name], COUNT_RECURSIVE);
    if ($diff == 0) {
        $files = array($_FILES[$input_name]);
    } else {
        foreach($_FILES[$input_name] as $k => $l) {
            foreach($l as $i => $v) {
                $files[$i][$k] = $v;
                if  ($i > 2) {
                    setcookie('message', 'Максимальное количество загружаемых файлов 3!',time() + 20);
                    header ("Location: index.php");
                    die();
                }
            }
        }
    }

foreach ($files as $file) {
    $error = $success = '';

    // Проверим на ошибки загрузки.
    if (!empty($file['error']) || empty($file['tmp_name'])) {
        switch ($file['error']) {
            case 1:
            case 2:
                $error = 'Превышен размер загружаемого файла.';
                break;
            case 3:
                $error = 'Файл был получен только частично.';
                break;
            case 4:
                $error = 'Файл не был загружен.';
                break;
            case 6:
                $error = 'Файл не загружен - отсутствует временная директория.';
                break;
            case 7:
                $error = 'Не удалось записать файл на диск.';
                break;
            case 8:
                $error = 'PHP-расширение остановило загрузку файла.';
                break;
            case 9:
                $error = 'Файл не был загружен - директория не существует.';
                break;
            case 10:
                $error = 'Превышен максимально допустимый размер файла.';
                break;
            case 11:
                $error = 'Данный тип файла запрещен.';
                break;
            case 12:
                $error = 'Ошибка при копировании файла.';
                break;
            default:
                $error = 'Файл не был загружен - неизвестная ошибка.';
                break;
        }
    } elseif ($file['tmp_name'] == 'none' || !is_uploaded_file($file['tmp_name'])) {
        $error = 'Не удалось загрузить файл.';
    } else {

        $name = $file['name'];
        $fileSize = $file['size'];
        $fileError = $file['error'];
        $fileTmpName = $file['tmp_name'];

        $fileExtension = strtolower(end(explode('.', $name)));
        $name2 = strtolower(explode('.', $name)[2]);

        if ($name2 == $fileExtension) {
            $name1 = explode('.', $name)[0];
            $name2 = explode('.', $name)[1];
            $name = $name1.'.'.$name2;
        } else {
            $name = explode('.', $name)[0];
        }


        $name = preg_replace('/[0-9_-]/', '', $name);
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'JPG'];
    }


    if (in_array($fileExtension, $allowedExtensions)) {
        if ($fileSize < 5000000) {
            if ($fileError === 0) {
                $connection->query("INSERT INTO `images` (`imgname`, `extension`) VALUES ('$name', '$fileExtension');");
                $lastID = $connection->query("SELECT MAX(id) FROM `images`");
                $lastID = $lastID->fetchAll();
                $lastID = $lastID[0][0];
                $fileNameNew = $lastID . $name . '.' . $fileExtension;
                $fileDestination = 'uploads/' . $fileNameNew;
                move_uploaded_file($fileTmpName, $fileDestination);
            }
        }
    }
}

                   echo 'Успешно загружено '. ($i+1) . ' изображения';


}



    $data = $connection->query('SELECT * FROM `images`');
    echo "<div style='display: flex; align-items: flex-end; flex-wrap: wrap;'>";


    foreach ($data as $img) {

        $delete = "delete" . $img['id'];
        $image = "uploads/" . $img['id'] . $img['imgname'] . '.' . $img['extension'];

        if (isset($_POST[$delete])) {
            $imageID = $img['id'];
            $connection->query("DELETE FROM `images` WHERE id='$imageID'");
            if (file_exists($image)) {
                unlink($image);
            }
        }


        if (file_exists($image)) {
            echo "<div>";
            echo "<img width='150' height='200' style='margin-right: 5px;' src='$image'>";
            echo "<form method='post'><button name='delete" . $img['id'] . "' style='display: block; margin: auto'>Удалить</button></form></div>";
        }
    }


echo "</div>";
?>

<style>
    body {
        margin: 50px 100px;
        font-size: 25px;
    }
    input, button {
        outline: none;
        font-size: 25px;
    }
</style>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>Document</title>
</head>
<body>
<form method="post" enctype="multipart/form-data">
    <input type="file" name="file[]" multiple required><br>
    <button name="submit">Отправить</button>
</form>




</body>
</html>