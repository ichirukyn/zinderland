<?php
/**
 * API W&S
 * Восстановление пароля от учётной записи
 * 04:06:2020 | ©ASu
 */

$get_user_data = trim(urldecode(addslashes(htmlspecialchars($_GET['user_data']))));

if (stristr($get_user_data, '@')) {
    $check_user_data = 'user_email';
} else {
    $check_user_data = 'user_login';
}

$check_user = mysqli_query($db_connect, ("SELECT * FROM `users` WHERE $check_user_data = '$get_user_data'"));
$check_user_array = mysqli_fetch_array($check_user);
$restore_code = $check_user_array['user_pass'];
if (mysqli_num_rows($check_user) > 0) {
    http_response_code(200);
    $response_status = 'ok';
    mail(
        "{$check_user_array['user_email']}",
        "Сброс пароля | Write and Share | Пиши и Делись",
        "Здравствуйте, {$check_user_array['user_login']}! \n С вашего аккаунта поступил запрос на сброс пароля. Для того, чтобы сделать это, перейдите по ссылке ниже. Если вы не совершали подобных действий — НЕ переходите по ссылке. \n Сброс пароля: http://w-s/user.conf_restore_pass?user_restore_code={$restore_code}",
        "From: su.aoke.ae@gmail.com \r\n"
    );
} else {
    http_response_code(500);
    $response_status = 'no';
    $response_error = '401';
}

if ($response_error == null) {
    $JSON_response = ['status' => $response_status];
} else {
    $JSON_response = ['status' => $response_status, 'error' => $response_error];
}
echo json_encode($JSON_response);
