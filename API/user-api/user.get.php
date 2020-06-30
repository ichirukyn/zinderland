<?php
/**
* API W&S
* Получение пользователей
* Принимаемые данные: user_id(необязательно), параметры запроса: order, limit, и т.д.(необязательно).
* 26:05:2020 | ©ASu
*/
$get_limit = trim(urldecode(addslashes(htmlspecialchars($_GET['limit']))));
$get_order = trim(urldecode(addslashes(htmlspecialchars($_GET['order']))));
$get_user_id = trim(urldecode(addslashes(htmlspecialchars($_GET['user_id']))));
if (empty($get_order)) $get_order = 'user_id';
if (empty($get_limit)) $get_limit = '10000';
if (empty($get_user_id)) {
  $get_user_id = 'user_id > 0';
} else {
  $get_user_id = "user_id = $get_user_id";
}
$bd_query = mysqli_query($db_connect, ("SELECT * FROM `users` WHERE $get_user_id ORDER BY $get_order ASC LIMIT 0, $get_limit"));
if (mysqli_num_rows($bd_query) > 0) {
  http_response_code(200);
  $response = [];
  for ($i = 0; $i < mysqli_num_rows($bd_query); $i++) {
    $bd_query_array = mysqli_fetch_array($bd_query);
    $reg_time = $bd_query_array['user_reg_date'];
    $reg_time = date('d.m.Y', (int)$reg_time);
    $user_id = $bd_query_array['user_id'];
    $user_login = $bd_query_array['user_login'];
    $user_nickname = $bd_query_array['user_nickname'];
    $user_email = $bd_query_array['user_email'];
    $user_avatar = $bd_query_array['user_avatar'];
    $user_post = $bd_query_array['user_post'];
    $user_del_status = $bd_query_array['user_del_status'];
    $r_array = [
      'user_id' => $user_id,
      'user_login' => $user_login,
      'user_nickname' => $user_nickname,
      'user_email' => $user_email,
      'user_avatar' => $user_avatar,
      'user_post' => $user_post,
      'user_reg_date' => $reg_time,
      'user_del_status' => $user_del_status
    ];
    array_push($response, $r_array);
  }
  $response_status = "ok";
  $response_error = null;
} else {
  http_response_code(500);
  $response_status = 'no';
  $response_error = "101";
}
if ($response_error == null) {
  $JSON_response = ['status' => $response_status, 'response' => $response];
} else {
  $JSON_response = ['status' => $response_status, 'error' => $response_error];
}
echo json_encode($JSON_response);
