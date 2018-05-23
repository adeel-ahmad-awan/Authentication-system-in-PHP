<?php

require 'credentials.php';

$db_connection = mysqli_connect(db_host, db_user, db_password);

if (! $db_connection) {
    echo 'Connected failure' . '<br>';
}

mysqli_select_db($db_connection, db_name);

$email_address = $_GET[email];
$user_hash =  $_GET[hash];

$sql = "select * from my_users where my_users.email='$email_address'";

$result = mysqli_query($db_connection, $sql) or die("MySQL error: " . mysqli_error($db_connection) . "<hr>\nQuery: $sql");;
$row = mysqli_fetch_array($result);

if ($row['email'] == $email_address && $row['user_hash'] == $user_hash) {
  //activate the user account
  $sql = "UPDATE my_users SET activation_status = 'activated' WHERE my_users.email='$email_address'";
  $result = mysqli_query($db_connection, $sql) or die("MySQL error: " . mysqli_error($db_connection) . "<hr>\nQuery: $sql");;
  if (!($result == false)) {
    echo "user account activated";
  }
}
mysqli_close($db_connection);

header('Location: login/loginView.html');
die();
