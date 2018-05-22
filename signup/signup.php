<?php
$db_host = 'localhost:3306';
$db_user = 'root';
$db_password = 'coeus123';
$db_name = 'MYUSERS';
$db_connection = null;

// Create connection
$db_connection = createDataBaseConnection($db_host, $db_user, $db_password, $db_name);

if (!(alreadyExists($db_connection, $db_name) > 0)) {
    // insert record in database table
    insertUserToDataBase($db_connection, $db_host, $db_user, $db_password, $db_name);
    sendMail();
}

//close database conncetion
mysqli_close($db_connection);

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
    echo 'Connected successfully <br>';
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
}

/**
* function to insert user email and password to database
*@param string $db_host
*@param string $db_user
*@param string $db_password
*@param string $db_name
*@return boolean $db_connection
*/
function insertUserToDataBase($db_connection, $db_host, $db_user, $db_password, $db_name)
{
    mysqli_select_db($db_connection, $db_name);

    $email_address = $_POST[email];
    $password = $_POST[password];
    $sql = "INSERT INTO my_users (email, password) VALUES ('$email_address', '$password')";
    echo 'sql query = ' . $sql;

    executeQuery($db_connection, $sql);
    return $db_connection;
}

/**
* function to check if there is already a user with provided email
*@param string $email
*@return integer
*/
function alreadyExists($db_connection, $db_name)
{
    mysqli_select_db($db_connection, $db_name);
    $email_address = $_POST[email];
    $sql = "select count(*) from my_users where email = '$email_address'";
    $result = mysqli_query($db_connection, $sql);
    $row = mysqli_fetch_array($result, MYSQLI_NUM);
    return $row[0];
}

function sendMail()
{
  $to = $_POST[email];
  $subject = "sign up successfull";

  $message = "<b>congradulation you have successfully signup</b>";
  $message .= "<p>click the following link to activate your account</p>";
  $message .= '<a href="https://www.w3schools.com/html/">activate account</a>';

  $header .= "MIME-Version: 1.0\r\n";
  $header .= "Content-type: text/html\r\n";

  $retval = mail ($to,$subject,$message,$header);

  if( $retval == true ) {
     echo "Message sent successfully...";
  }else {
     echo "Message could not be sent...";
  }
}
