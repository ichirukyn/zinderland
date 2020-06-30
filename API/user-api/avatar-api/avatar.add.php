<?php
/**
 * API W&S
 * Добавление аватара пользователя
 * 23:05:2020 | ©ASu
 */

$get_user_id = trim(urldecode(addslashes(htmlspecialchars($_POST['user_id']))));
$get_user_access = trim(urldecode(addslashes(htmlspecialchars($_POST['user_access']))));
$get_user_avatar = $_FILES['user_avatar'];
$response_status = 'no';
if (!empty($get_user_id) && !empty($get_user_access) && !empty($get_user_avatar)) {
    $check_user = mysqli_query($db_connect, ("SELECT * FROM `users` WHERE user_id = '$get_user_id' AND user_access = '$get_user_access'"));
    $check_user_array = mysqli_fetch_array($check_user);
    if (mysqli_num_rows($check_user) > 0 && $check_user_array['user_del_status'] !== '1') {
        if (isset($_FILES['user_avatar'])) {
            $avatar_name = "avatar_" . $get_user_id . "." . basename($_FILES['user_avatar']['type']);
            $error_flag = $_FILES['user_avatar']['error'];

            if ($error_flag === 0) {
                $upload_dir = getcwd() . "/upload/users/avatars/full/" . $avatar_name;
                if ($_FILES['user_avatar']['tmp_name']) {
                    $allowed = array('jpg', 'jpeg', 'png');
                    $ext = pathinfo($_FILES['user_avatar']['name'], PATHINFO_EXTENSION);
                    if (!in_array($ext, $allowed)) {
                        $errors[] = "Incorrect format";
                    } else if (!move_uploaded_file($_FILES['user_avatar']['tmp_name'], $upload_dir)) {
                        $errors[] = "error";
                    }
                } else {
                    $errors[] = "error";
                }
            }
        } else if ($_FILES['user_avatar']['size'] == 0) $errors[] = "No image selected";

        http_response_code(200);
        $add_avatar = mysqli_query($db_connect, ("UPDATE `users` SET user_avatar = '$avatar_name' WHERE user_id = '$get_user_id'"));
        $response_status = 'ok';
        $response = ['avatar_name' => $avatar_name];
    } else {
        http_response_code(500);
        $response_status = 'no';
        $response_error = '302';
    }
} else {
    $response_error = '101';
}
if ($response_error == null) {
    $JSON_response = ['status' => $response_status, 'response' => $response];
} else {
    $JSON_response = ['status' => $response_status, 'error' => $response_error];
}
echo json_encode($JSON_response);
