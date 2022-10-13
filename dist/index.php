<?php
spl_autoload_register(function ($class_name) {
  $src_path = explode('\\', $class_name);
  $final_class_name = array_pop($src_path);
  $path = join('/', $src_path);
  $class_root = __DIR__ . '/' . $path . '/' . $final_class_name . '.php';
  include $class_root;
});

// По умолчанию
$controller_name = '';
$action_name = 'get';

// Страницы
$json_routes = file_get_contents(__DIR__ . '/data/routes.json');
$routes = json_decode($json_routes, true);

foreach ($routes as $row) {
  if ($_SERVER['REQUEST_URI'] == $row['route']) {
    $controller_name = $row['class'];
    $action_name = $row['action'];
  }
}

if (!preg_match("/^[\w]+$/", $controller_name)) {
  die ('incorrect controller name');
}

$controller_class = '\system\controllers\\' . $controller_name;

// Создать экземпляр и вывести представление
$controller = new $controller_class();
echo $controller->call($action_name);
