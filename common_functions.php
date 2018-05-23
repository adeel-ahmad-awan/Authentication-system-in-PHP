<?php

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
        exit('Unable to connect <br>');
    }
    return $db_connection;
}

/**
* function to execute a Query
*@param boolean $db_connection
*@param string $sql_query
*/
function executeQuery($db_connection, $sql_query)
{
    if (mysqli_query($db_connection, $sql_query)) {
        echo "New record created successfully";
    } else {
        echo 'Error in query execution: ' . mysqli_error($db_connection) .' <br>';
    }
    return mysqli_insert_id($db_connection);
}
