<?php
include_once 'config.php';
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: *');
header('Access-Control-Allow-Methods: *');
header('Access-Control-Allow-Credentials: true');
header('Content-type: text/JSON');
define('TOKEN', 'f954e1a19bbab6b554ac82e19b95116a');
$request_URI = $_SERVER['REQUEST_URI'];
$request_URI = str_replace('/', '', $request_URI);
$request_URI_array = explode('?', $request_URI);
$request_API_method = $request_URI_array[0];
switch ($request_API_method) {

  // UserAPI \\

  // API для получения списка пользователя
  case 'user.get':
  include_once 'API/user-api/user.get.php';
  break;

  // API для создания пользователя
  case 'user.register':
  include_once 'API/user-api/user.register.php';
  break;

  // API для входа
  case 'user.auth':
  include_once 'API/user-api/user.auth.php';
  break;

  // API для выхода
  case 'user.exit':
  include_once 'API/user-api/user.exit.php';
  break;

  // API для обновления данных
  case 'user.update':
  include_once 'API/user-api/user.update.php';
  break;

  // API для удаления пользователя
  case 'user.delete':
  include_once 'API/user-api/user.delete.php';
  break;

  // API для добавления аватара
  case 'avatar.add':
  include_once 'API/user-api/avatar-api/avatar.add.php';
  break;

  default:
  http_response_code(500);
  $JSON_response = ['status' => 'no', 'error' => '100'];
  echo json_encode($JSON_response);
  break;
}
