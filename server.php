<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Server</title>
</head>
<body>
    <a href="index.php">Вернуться в галерею</a>
</body>
</html>
<?php

include_once "engine.php";
include_once "config.php";

// Проверяем если была отправлена через запрос $_POST переменная 'send' которую мы берем на кнопке загрузить в индексном файле
  if (isset($_POST['send'])) {
    // Проверяем если пришел код ошибки
    if ($_FILES['userfile']['error']) {
      // В переменную $message присваиваем сообщение об ошибке
      $message = 'Ошибка загрузки файла!';
    // Проверяем размер файла, если он больше 1 000 000 байт, в переменную $message сохраняем сообщение
    } elseif ($_FILES['userfile']['size'] > 1000000) {
    //в переменную $message сохраняем сообщение
      $message = 'Файл слишком большой';
        // Проверяем тип отправленного файла
    } elseif (
        $_FILES['userfile']['type'] == 'image/jpeg'||
        $_FILES['userfile']['type'] == 'image/png' ||
        $_FILES['userfile']['type'] == 'image/gif'
      ) {
        // Проверяем если удается копировать временный файл в папку images, при этом применяется функция транслитерации, если файл был назван по русски
          if (copy($_FILES['userfile']['tmp_name'], PHOTO.translit($_FILES['userfile']['name']))) {
            // В переменную $path сохраняем путь к уменьшенному файлу img/imya_fayla_na_PC_pol'zovatelya
            $name = translit($_FILES['userfile']['name']);
            $path = PHOTO_SMALL.$name;
            $bigImgPath = PHOTO.$name;
            $size = $_FILES['userfile']['size'];
            // В переменную $type сохраняем только тип изображения, без image, то есть например $_FILES['userfile']['type'] = image/jpeg с помощью  explode('/', $_FILES['userfile']['type'])[1] мы убираем image и остается только тип изображения
            $type = explode('/', $_FILES['userfile']['type'])[1];
            // Применяем функцию изменения изображения
            changeImage(150, 150, $_FILES['userfile']['tmp_name'], $path, $type);
            include_once "db_connect.php";
            
            $link = db_connect();
            $query = "INSERT INTO photo_gallery (name, src, big_img_src, size, views) VALUES ('$name', '$path', '$bigImgPath', '$size', '0')";
            $result = mysqli_query($link, $query);
            $message = 'Фотография успешно загружена';
          } else {$message = 'Ошибка загрузки файла!';}
      } else {
        $message = 'Не правильный тип файла!';
    }
    header ('Location: index.php');
  }

?>