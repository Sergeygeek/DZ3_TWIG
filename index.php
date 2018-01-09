<?php

require_once "db_connect.php";
require_once "engine.php";
$link = db_connect();
$images = getSortedImg($link);
// подгружаем и активируем авто-загрузчик Twig-а
require_once 'Twig/Autoloader.php';
Twig_Autoloader::register();

try {
  // указываем где хранятся шаблоны
  $loader = new Twig_Loader_Filesystem('templates');
  
  // инициализируем Twig
  $twig = new Twig_Environment($loader);
  
  // подгружаем шаблон
  $template = $twig->loadTemplate('gallery.tmpl');
  
  // передаём в шаблон переменные и значения
  
  // выводим сформированное содержание
  echo $template->render(array(
    'images' => $images,
  ));
  
} catch (Exception $e) {
  die ('ERROR: ' . $e->getMessage());
}
?>