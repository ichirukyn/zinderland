<?php
/**
 * API W&S
 * Смены пароля
 * 12:06:2020 | ©ASu
 */
$get_user_restore_code = trim(urldecode(addslashes(htmlspecialchars($_GET['user_restore_code']))));
$get_user_pass = trim(urldecode(addslashes(htmlspecialchars($_GET['user_pass']))));
$bd_pass = md5($get_user_pass);
$response_status = 'no';
if (!empty($get_user_restore_code)) {
    $query = mysqli_query($db_connect, ("SELECT * FROM `users` WHERE user_pass = '$get_user_restore_code'"));
    $query_row = mysqli_fetch_array($query);
    if (mysqli_num_rows($query) > 0) {
        if ($query_row['user_restore_status'] !== '0') {
            http_response_code(200);
            $response_status = 'ok';
            $user_restore_pass_date = time();
            $query_confirmation = mysqli_query($db_connect, ("UPDATE `users` SET user_pass = '$bd_pass', user_last_pass_changed = '$user_restore_pass_date', user_restore_status = '0' WHERE user_id = '$query_row[user_id]'"));
            mail(
                "{$get_user_email}",
                "Пароль успешно сброшен! | Write and Share | Пиши и Делись",
                "Здравствуйте, {$query_row['user_login']}! \n Ваш пароль успешно изменён.",
                "From: su.aoke.ae@gmail.com \r\n"
            );
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
    $JSON_response = ['status' => $response_status];
} else {
    $JSON_response = ['status' => $response_status, 'error' => $response_error];
}
echo json_encode($JSON_response);
