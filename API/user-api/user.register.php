<?php
$get_user_login = mb_strtolower(trim(urldecode(addslashes(htmlspecialchars($_GET['user_login'])))));
$get_user_pass = trim(urldecode(addslashes(htmlspecialchars($_GET['user_pass']))));
$get_user_check_pass = trim(urldecode(addslashes(htmlspecialchars($_GET['user_check_pass']))));
$get_user_email = trim(urldecode(addslashes(htmlspecialchars($_GET['user_email']))));
$bd_pass = md5($get_user_pass);
$response_status = 'no';
$response = null;
$response_error = array(
    'e' => array()
);
$email_reg_exp = '/^[_a-z0-9-]+(.[_a-z0-9-]+)*@[a-z0-9-]+(.[a-z0-9-]+)*(.[a-z]{2,4})$/';
if (!preg_match($email_reg_exp, $get_user_email)) {
    array_push($response_error['e'],'202');
}
if ($get_user_pass !== $get_user_check_pass) {
    array_push($response_error['e'],'221');
}
$check_user_email = mysqli_query($db_connect, ("SELECT * FROM `users` WHERE user_email = '$get_user_email'"));
$check_user_email_array = mysqli_fetch_array($check_user_email);
if ($get_user_email == $check_user_email_array['user_email']) {
    array_push($response_error['e'],'201');
}
$check_user_login = mysqli_query($db_connect, ("SELECT * FROM `users` WHERE user_login = '$get_user_login'"));
$check_user_login_array = mysqli_fetch_array($check_user_login);
if ($get_user_login == $check_user_login_array['user_login']) {
    array_push($response_error['e'],'210');
}
if (isset($get_user_login) && isset($get_user_pass) && isset($get_user_check_pass) && isset($get_user_email) && !count($response_error['e'])) {
    http_response_code(200);
    $response_status = 'ok';
    $user_reg_date = time();
    // $get_user_conf_code = md5(md5($get_user_login . $get_user_pass . $user_reg_date));
    // $check_conf_code = mysqli_query($db_connect, ("SELECT * FROM `users` WHERE user_conf_code = '$get_user_conf_code'"));
    // if (mysqli_num_rows($check_conf_code) > 0) {
    //     $get_user_conf_code = md5(md5($user_reg_date . $get_user_pass . $get_user_login . $user_reg_date));
    // }
    $query = mysqli_query($db_connect, ("INSERT INTO `users` (user_login, user_pass, user_email, user_reg_date) VALUES ('$get_user_login', '$bd_pass', '$get_user_email', '$user_reg_date')"));
    //mail("{$get_user_email}", "Подтверждение почты | Write and Share | Пиши и Делись", "Здравствуйте, {$get_user_login}! \n Для подтверждения перейдите по ссылке http://w-s/user.confirm?user_a_code={$get_user_conf_code}", "From: su.aoke.ae@gmail.com \r\n");
    $response = ['user_id' => mysqli_insert_id($db_connect) ];
} else {
    http_response_code(500);
    $response_status = 'no';
    array_push($response_error['e'],'101');
}
if (!count($response_error['e'])) {
    $JSON_response = ['status' => $response_status, 'response' => $response];
} else {
    $JSON_response = ['status' => $response_status, 'error' => $response_error['e']];
}
echo json_encode($JSON_response);
