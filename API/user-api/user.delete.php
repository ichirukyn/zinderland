<?php
/**
 * API W&S
 * Удаление учётной записи
 * 23:05:2020 | ©ASu
 */
$get_user_id = trim(urldecode(addslashes(htmlspecialchars($_GET['user_id']))));
$get_user_access = trim(urldecode(addslashes(htmlspecialchars($_GET['user_access']))));
$response_status = 'no';
if (!empty($get_user_id) && !empty($get_user_access)) {
    $response_error = null;
    // user_status = 1- значит, пользователь удалён
    $check_user = mysqli_query($db_connect, ("SELECT * FROM `users` WHERE user_id = '$get_user_id' AND user_access = '$get_user_access'"));
    $check_user_array = mysqli_fetch_array($check_user);
    if (mysqli_num_rows($check_user) > 0 && $check_user_array['user_del_status'] !== '1') {
        http_response_code(200);
        $delete_user = mysqli_query($db_connect, ("UPDATE `users` SET user_del_status = '1', user_access = '' WHERE user_id = '$get_user_id'"));
        $response_status = 'ok';
    } elseif (mysqli_num_rows($check_user) == 0) {
        http_response_code(500);
        $response_status = 'no';
        $response_error = '404';
    } else {
        http_response_code(500);
        $response_status = 'no';
        $response_error = '301';
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
