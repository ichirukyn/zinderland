<?php
/**
 * API W&S
 * Обновление данных пользователя
 * 04:06:2020 | ©ASu
 */
$get_user_id = trim(urldecode(addslashes(htmlspecialchars($_GET['user_id']))));
$get_user_access = trim(urldecode(addslashes(htmlspecialchars($_GET['user_access']))));
$get_user_email = trim(urldecode(addslashes(htmlspecialchars($_GET['user_email']))));
$get_user_nickname = trim(urldecode(addslashes(htmlspecialchars($_GET['user_nickname']))));
$get_user_private = trim(urldecode(addslashes(htmlspecialchars($_GET['user_private']))));
$get_user_status = trim(urldecode(addslashes(htmlspecialchars($_GET['user_status']))));
$get_user_gender = trim(urldecode(addslashes(htmlspecialchars($_GET['user_gender']))));
$response_error = [
    'e' => [],
];

$check_user_auth = mysqli_query($db_connect, ("SELECT * FROM `users` WHERE user_id = '$get_user_id' AND user_access = '$get_user_access'"));
$check_user_auth_array = mysqli_fetch_array($check_user_auth);
if (mysqli_num_rows($check_user_auth) > 0) {
    if (!isset($get_user_email) || empty($get_user_email) || $get_user_email === null) {
        $bd_user_email = mysqli_query($db_connect, ("SELECT * FROM `users` WHERE user_id = '$get_user_id' AND user_access = '$get_user_access'"));
        $bd_user_email_array = mysqli_fetch_array($bd_user_email);
        $get_user_email = $bd_user_email_array['user_email'];
    } else {
        $email_reg_exp = '/^[_a-z0-9-]+(.[_a-z0-9-]+)*@[a-z0-9-]+(.[a-z0-9-]+)*(.[a-z]{2,4})$/';
        if (!preg_match($email_reg_exp, $get_user_email)) {
            array_push($response_error['e'], '202');
        }
        $check_user_email = mysqli_query($db_connect, ("SELECT user_email FROM `users` WHERE user_email = '$get_user_email'"));
        $check_user_email_array = mysqli_fetch_array($check_user_email);
        if ($get_user_email == $check_user_email_array['user_email']) {
            array_push($response_error['e'], '201');
        } else {
            $get_user_conf_code = md5(md5($get_user_login . $get_user_email . rand(0, 10)));
            $bd_query = mysqli_query($db_connect, ("UPDATE `users` SET user_conf_code = '$get_user_conf_code', user_confirmation = '0' WHERE user_id = '$get_user_id' AND user_access = '$get_user_access'"));
            mail(
                "{$get_user_email}",
                "Подтверждение почты | Write and Share | Пиши и Делись",
                "Здравствуйте, {$check_user_auth_array['user_login']}! \n Для подтверждения перейдите по ссылке http://w-s/user.confirm?user_a_code={$get_user_conf_code}",
                "From: su.aoke.ae@gmail.com \r\n"
            );
        }
    }
    if (!isset($get_user_nickname) || empty($get_user_nickname) || $get_user_nickname === null) {
        $check_user_nickname = mysqli_query($db_connect, ("SELECT user_nickname FROM `users` WHERE user_id = '$get_user_id' AND user_access = '$get_user_access'"));
        $check_user_nickname_array = mysqli_fetch_array($check_user_nickname);
        if ($check_user_nickname_array['user_nickname'] == null) {
            $get_user_nickname = 'null';
        } else {
            $get_user_nickname = $check_user_nickname_array['user_nickname'];
        }
    }
    if (!isset($get_user_private) || empty($get_user_private) || $get_user_private === null) {
        $check_user_private = mysqli_query($db_connect, ("SELECT user_private FROM `users` WHERE user_id = '$get_user_id' AND user_access = '$get_user_access'"));
        $check_user_private_array = mysqli_fetch_array($check_user_private);
        $get_user_private = $check_user_private_array['user_private'];
    }
    if (!isset($get_user_status) || empty($get_user_status) || $get_user_status === null) {
        $check_user_status = mysqli_query($db_connect, ("SELECT user_status FROM `users` WHERE user_id = '$get_user_id' AND user_access = '$get_user_access'"));
        $check_user_status_array = mysqli_fetch_array($check_user_status);
        if ($check_user_status_array['user_status'] == null) {
            $get_user_status = 'null';
        } else {
            $get_user_status = $check_user_status_array['user_status'];
        }
    }
    if (!isset($get_user_gender) || empty($get_user_gender) || $get_user_gender === null) {
        $check_user_gender = mysqli_query($db_connect, ("SELECT * FROM `users` WHERE user_id = '$get_user_id' AND user_access = '$get_user_access'"));
        $check_user_gender_array = mysqli_fetch_array($check_user_gender);
        $get_user_gender = $check_user_gender_array['user_gender'];
    }
    if ($get_user_email != null && $get_user_nickname != null && $get_user_private != null && $get_user_status != null && $get_user_gender != null && !count($response_error['e'])) {
        http_response_code(200);
        $response_status = 'ok';
        $bd_query = mysqli_query(
            $db_connect,
            ("UPDATE `users` SET user_email = '$get_user_email', user_private = '$get_user_private', user_nickname = '$get_user_nickname', user_status = '$get_user_status', user_gender = '$get_user_gender' WHERE user_id = '$get_user_id' AND user_access = '$get_user_access'")
        );
    } else {
        http_response_code(500);
        $response_status = 'no';
        array_push($response_error['e'], '101');
    }
} else {
    http_response_code(500);
    $response_status = 'no';
    array_push($response_error['e'], '302');
}
if (!count($response_error['e'])) {
    $JSON_response = ['status' => $response_status];
} else {
    $JSON_response = ['status' => $response_status, 'error' => $response_error['e']];
}
echo json_encode($JSON_response);
