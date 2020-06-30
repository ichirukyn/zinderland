<?php
/**
 * API W&S
 * Подтверждение учётной записи
 * 23:05:2020 | ©ASu
 */
$user_conf_code = trim(urldecode(addslashes(htmlspecialchars($_GET['user_a_code']))));
$response_status = 'no';
$response_error = array(
    'e' => array()
);
if (!empty($user_conf_code)) {
    // user_confirmation = 0 - значит, пользователь не подтверждён
    $query = mysqli_query($db_connect, ("SELECT * FROM `users` WHERE user_conf_code = '$user_conf_code'"));
    $query_row = mysqli_fetch_array($query);
    if (mysqli_num_rows($query) > 0 && $query_row['user_confirmation'] !== '1') {
        http_response_code(200);
        $query_confirmation = mysqli_query($db_connect, ("UPDATE `users` SET user_confirmation = '1', user_conf_code = '' WHERE user_id = '$query_row[user_id]'"));
        $response_status = 'ok';
    } else {
        http_response_code(500);
        $response_status = 'no';
        array_push($response_error,'310');
    }
} else {
    $response_status = 'no';
    array_push($response_error['e'],'101');
}
if (!count($response_error['e'])) {
    $JSON_response = ['status' => $response_status];
} else {
    $JSON_response = ['status' => $response_status, 'error' => $response_error['e']];
}
echo json_encode($JSON_response);
