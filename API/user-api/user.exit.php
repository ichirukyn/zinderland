<?php
/**
 * API W&S
 * Выход из учётной записи пользователя
 * Получаем входные данные: логин, пароль,
 * затем сверяем с данными из бд и выходим, удаляя user_access
 * 24:04:2020 | ©ASu
 */
$get_user_id = trim(urldecode(addslashes(htmlspecialchars($_GET['user_id']))));
$get_user_access = trim(urldecode(addslashes(htmlspecialchars($_GET['user_access']))));
$response_status = 'no';
if (!empty($get_user_id) && !empty($get_user_access)) {
    $response_error = null;
    $check_user_status = mysqli_query($db_connect, ("SELECT * FROM `users` WHERE user_id = '$get_user_id'"));
    $check_user_status_array = mysqli_fetch_array($check_user_status);
    if (mysqli_num_rows($check_user_status) > 0 && !empty($check_user_status_array['user_access'])) {
        http_response_code(200);
        $bd_query = mysqli_query($db_connect, ("UPDATE `users` SET user_access = 'null' WHERE user_id = '$get_user_id'"));
        $response_status = 'ok';
    } else {
        http_response_code(500);
        $response_status = 'no';
        $response_error = '302';
    }
} else {
    $response_error = '101';
}
if ($response_error == null) {
    $JSON_response = ['status' => $response_status];
} else {
    $JSON_response = ['status' => $response_status, 'error' => $response_error];
}
echo json_encode($JSON_response);
