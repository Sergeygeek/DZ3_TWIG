<?php

include_once "db_connect.php";
include_once "engine.php";

$link = db_connect();
$image = getImg($link, $_GET['id']);
updateViews($link, $_GET['id']);
$views = getView($link, $_GET['id']);

// подгружаем и активируем авто-загрузчик Twig-а
require_once 'Twig/Autoloader.php';
Twig_Autoloader::register();

try {
  // указываем где хранятся шаблоны
  $loader = new Twig_Loader_Filesystem('templates');
  
  // инициализируем Twig
  $twig = new Twig_Environment($loader);
  
  // подгружаем шаблон
  $template = $twig->loadTemplate('image.tmpl');
  
  // передаём в шаблон переменные и значения
  
  // выводим сформированное содержание
  echo $template->render(array(
    'image' => $image,
    'views' => $views
  ));
  
} catch (Exception $e) {
  die ('ERROR: ' . $e->getMessage());
}
?>