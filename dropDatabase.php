<?php
require 'credentials.php';

// create database connection
$db_connection = mysqli_connect(db_host, db_user, db_password);
if (! $db_connection) {
    echo 'Connected failure' . PHP_EOL;
} else {
    echo 'Connected successfully' . PHP_EOL;
}
// selecting database for query execution
mysqli_select_db($db_connection, db_name);
// execution of quries
executeQuery($db_connection, 'DROP TABLE my_users');
executeQuery($db_connection, 'DROP DATABASE ' . db_name);
//colsing database conncetion
mysqli_close($db_connection);

/**
* function to execute a Query
*@param boolean $db_connection
*@param string $sql_query
*/
function executeQuery($db_connection, $sql_query)
{
    if (mysqli_query($db_connection, $sql_query)) {
        echo 'query execution successfully' . PHP_EOL;
    } else {
        echo 'Error in query execution: ' . mysqli_error($db_connection) . PHP_EOL;
    }
}
