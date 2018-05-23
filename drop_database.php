<?php
require 'credentials.php';
require 'common_functions.php';

// $db_connection = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD);
//Creating database connection
$db_connection = createDataBaseConnection(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
if (! $db_connection) {
    echo 'Connected failure' . PHP_EOL;
} else {
    echo 'Connected successfully' . PHP_EOL;
}
// selecting database for query execution
mysqli_select_db($db_connection, DB_NAME);
// execution of quries
executeQuery($db_connection, 'DROP TABLE users');
executeQuery($db_connection, 'DROP DATABASE ' . DB_NAME);
//colsing database conncetion
mysqli_close($db_connection);
