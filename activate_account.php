<?php

require 'credentials.php';
require 'common_functions.php';

//Creating database connection
$db_connection = createDataBaseConnection(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
mysqli_select_db($db_connection, DB_NAME);
$user_id = $_GET[user_id];
$user_hash =  $_GET[hash];

$query = "select * from users where users.id='$user_id' and users.user_hash='$user_hash'";
$result = mysqli_query($db_connection, $query) or die("MySQL error: " . mysqli_error($db_connection) . "<hr>\nQuery: $query");;
$row = mysqli_fetch_array($result);
if (!($row == false)) {
    //activate the user account
    $query = "UPDATE users SET activation_status = 'activated', user_hash = '' WHERE users.id='$user_id'";
    $result = mysqli_query($db_connection, $query) or die("MySQL error: " . mysqli_error($db_connection) . "<hr>\nQuery: $query");
    if (!($result == false)) {
        echo "user account activated";
    }
    mysqli_close($db_connection);
    header('Location: login/login_view.html');
    die();
} else {
    mysqli_close($db_connection);
    header('Location: signup/sighup.html');
    die();
}
