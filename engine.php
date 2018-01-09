<?php

// Функция транслитерации строк
  function translit($string) { 
      $translit = array(
        'а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g', 'д' => 'd', 'е' => 'e', 'ё' => 'yo', 'ж' => 'zh',
        'з' => 'z', 'и' => 'i', 'й' => 'j', 'к' => 'k', 'л' => 'l', 'м' => 'm', 'н' => 'n', 'о' => 'o',
        'п' => 'p', 'р' => 'r', 'с' => 's', 'т' => 't', 'у' => 'u', 'ф' => 'f', 'х' => 'h', 'ц' => 'c',
        'ч' => 'ch', 'ш' => 'sh', 'щ' => 'sch', 'ы' => 'y', 'ъ' => '', 'ь' => '', 'э' => 'eh', 'ю' => 'yu', 'я'=>'ya');

      return str_replace(' ', '_', strtr(mb_strtolower(trim($string)), $translit));
   }

    function changeImage($h, $w, $src, $newsrc, $type) {
        // Функция создания нового полноцветного изображения, заданного размера   
        $newimg = imagecreatetruecolor($h, $w);
           // Оператором switch проверяем тип изображения
        switch ($type) {
          case 'jpeg':
            // создаем новое изображение
            $img = imagecreatefromjpeg($src);
            //Функция, копирует и изменяет размеры изображения без потери четкости. imagesx - получаем ширину, imagesy - получаем высоту
            imagecopyresampled($newimg, $img, 0, 0, 0, 0, $h, $w, imagesx($img), imagesy($img));
            //Создаем файл изображения
            imagejpeg($newimg, $newsrc);
            break;
          case 'png':
            // создаем новое изображение
            $img = imagecreatefrompng($src);
            imagecopyresampled($newimg, $img, 0, 0, 0, 0, $h, $w, imagesx($img), imagesy($img));
            imagepng($newimg, $newsrc);
            break;
          case 'gif':
            // создаем новое изображение
            $img = imagecreatefromgif($src);
            imagecopyresampled($newimg, $img, 0, 0, 0, 0, $h, $w, imagesx($img), imagesy($img));
            imagegif($newimg, $newsrc);
            break;
        }
       }

    function getView($link, $id){
        $link = db_connect();
        $query = sprintf("SELECT views FROM photo_gallery WHERE id = %d", (int)$id);
        $result = mysqli_query($link, $query);
        
        if(!$result)
            die(mysqli_error($link));
        
        $views = mysqli_fetch_assoc($result);
        
        return $views;
        
    }

    function getSortedImg($link){
        $link = db_connect();
        $query = "SELECT * FROM photo_gallery ORDER BY views DESC";
        $result = mysqli_query($link, $query);
        if(!$result)
            die(mysqli_error($link));
        
        // Извлечение из БД
        $n = mysqli_num_rows($result);// Получаем количество рядов
        $images = array();
        
        for ($i = 0; $i < $n; $i++)
        {
            $row = mysqli_fetch_assoc($result);// Получаем ассоциативный массив
            $images[] = $row;
        }
        
        return $images;
    }

    function getImg($link, $imgId){
        
        $link = db_connect();
        $query = sprintf("SELECT big_img_src FROM photo_gallery WHERE id = %d", (int)$imgId);
        $result = mysqli_query($link, $query);
    
        if(!$result)
            die(mysqli_error($link));
        
        $image = mysqli_fetch_assoc($result);
        
        return $image;
           
    }

    function updateViews($link, $id){
        $link = db_connect();
        $query = sprintf("UPDATE photo_gallery SET views=views+1 WHERE id = %d", (int)$id);
        $result = mysqli_query($link, $query);
        
    }
    



?>