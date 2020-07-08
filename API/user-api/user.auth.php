<?php
$get_user_login = trim(urldecode(addslashes(htmlspecialchars($_GET['user_login']))));
$get_user_pass = trim(urldecode(addslashes(htmlspecialchars($_GET['user_pass']))));
$db_pass = md5($get_user_pass);
$response_status = 'no';
$response = null;
if (!empty($get_user_pass) && !empty($get_user_login)) {
    $check_user_login = mysqli_query($db_connect, ("SELECT * FROM `users` WHERE user_login = '$get_user_login' AND user_pass = '$db_pass'"));
    $check_user_login_array = mysqli_fetch_array($check_user_login);
    if (mysqli_num_rows($check_user_login) > 0) {
        http_response_code(200);
        $chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        function gen_user_access($char_list, $strength = 30) {
            $char_length = strlen($char_list);
            $access = '';
            for ($i = 0; $i < $strength; $i++) {
                $generate_access = $char_list[mt_rand(0, $char_length - 1) ];
                $access.= $generate_access;
            }
            return $access;
        }
        $user_access_token = gen_user_access($chars, 30);
        $check_user_token = mysqli_query($db_connect, ("SELECT * FROM `users` WHERE user_token = '$user_access_token'"));
        if (mysqli_num_rows($check_user_token) > 0) {
            $user_access_token = gen_user_access($chars, 30);
        }
        $bd_query = mysqli_query($db_connect, ("UPDATE `users` SET user_token = '$user_access_token' WHERE user_id = '$check_user_login_array[user_id]'"));
        $response_status = 'ok';
        $response = ['user_id' => $check_user_login_array['user_id'], 'user_token' => $user_access_token];
    } else {
        $response_status = 'no';
        $response_error = '200';
    }
} else {
    $response_error = '101';
}
if (!isset($response_error)) {
    $JSON_response = ['status' => $response_status, 'response' => $response];
} else {
    $JSON_response = ['status' => $response_status, 'error' => $response_error];
}
echo json_encode($JSON_response);
