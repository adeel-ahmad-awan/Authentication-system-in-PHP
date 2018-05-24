<?php

require 'credentials.php';
require 'common_functions.php';

//Creating database connection
$db_connection = createDataBaseConnection(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
// selecting database for query execution
mysqli_select_db($db_connection, DB_NAME);
// execution of query
executeQuery($db_connection, 'CREATE DATABASE IF NOT EXISTS ' . DB_NAME);
// selecting database for query execution
mysqli_select_db($db_connection, DB_NAME);

// sql to create table
$query = 'CREATE TABLE IF NOT EXISTS users (
  id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  email VARCHAR(50) NOT NULL UNIQUE,
  password VARCHAR(30) NOT NULL,
  access_level ENUM( \'administrator\', \'normal\') DEFAULT \'normal\',
  activation_status ENUM( \'activated\', \'not_activated\') DEFAULT \'not_activated\',
  user_hash VARCHAR(32) NOT NULL )';

executeQuery($db_connection, $query);

mysqli_close($db_connection);
