<?php

$db_host = "localhost";
$db_login = "aoke";
$db_pass = "root";
$db_table = "zeld_zinderland";

$db_connect = mysqli_connect($db_host, $db_login, $db_pass, $db_table) or die('connect error' . mysqli_connect_error($db_connect));
