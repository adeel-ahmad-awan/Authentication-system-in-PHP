<?php

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

/**
* function to create DATABASE conncetion
*@param string $db_host
*@param string $db_user
*@param string $db_password
*@return boolean $db_connection
*/
function createDataBaseConnection($db_host, $db_user, $db_password)
{
  $db_connection = mysqli_connect($db_host, $db_user, $db_password);
  if (! $db_connection) {
      exit('Unable to connect');
  }
  echo 'Connected successfully' . PHP_EOL;
  return $db_connection;
}

$db_host = 'localhost:3306';
$db_user = 'root';
$db_password = 'coeus123';
$db_name = 'MYUSERS';
$db_connection = NULL;

$db_connection = createDataBaseConnection($db_host, $db_user, $db_password);
executeQuery($db_connection, 'CREATE DATABASE IF NOT EXISTS ' . $db_name);
mysqli_select_db($db_connection, $db_name);

// sql to create table
$sql = 'CREATE TABLE IF NOT EXISTS my_users (id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, email VARCHAR(50) NOT NULL, password VARCHAR(30) NOT NULL, access_level ENUM( \'administrator\', \'normal\') DEFAULT \'normal\')';
executeQuery($db_connection, $sql);

mysqli_close($db_connection);
