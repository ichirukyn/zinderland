<?php
/**
 * API W&S
 * Подтверждение восстановления пароля учётной записи и добавление нового пароля
 * 12:06:2020 | ©ASu
 */
$get_user_restore_code = trim(urldecode(addslashes(htmlspecialchars($_GET['user_restore_code']))));
$response_status = 'no';
if (!empty($get_user_restore_code)) {
    $query = mysqli_query($db_connect, ("SELECT * FROM `users` WHERE user_pass = '$get_user_restore_code'"));
    $query_row = mysqli_fetch_array($query);
    if (mysqli_num_rows($query) > 0) {
        if ($query_row['user_restore_status'] !== '0') {
            http_response_code(200);
            $response_status = 'ok';
            $response = ['user_id' => $query_row['user_id'], 'user_restore_code' => $get_user_restore_code];
            $bd_query = mysqli_query($db_connect, ("UPDATE `users` SET user_restore_status = '1' WHERE user_pass = '$get_user_restore_code'"));
        } else {
            http_response_code(500);
            $response_status = 'no';
            $response_error = '304';
        }
    } else {
        http_response_code(500);
        $response_status = 'no';
        $response_error = '401';
    }
} else {
    $response_status = 'no';
    $response_error = '101';
}
if ($response_error == null) {
    $JSON_response = ['status' => $response_status, 'response' => $response];
} else {
    $JSON_response = ['status' => $response_status, 'error' => $response_error];
}
echo json_encode($JSON_response);
