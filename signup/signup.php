<?php

require '../credentials.php';
require '../common_functions.php';

$email_address = $_POST[email];
$password = $_POST[password];
//Creating database connection
$db_connection = createDataBaseConnection(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
// insert if there is not a user with given email address in database
if (!(alreadyExists($db_connection, DB_NAME, $email_address) > 0)) {
    // insert record in database table
    $user_id = insertUserToDataBase($db_connection, DB_HOST, DB_USER, DB_PASSWORD, DB_NAME, $email_address, $password);
    // send activation link via email
    sendMail(activateLink($user_id, generateHashOfEmailAddress($email_address)), $email_address);
}
//close database conncetion
mysqli_close($db_connection);
// redirect to login page
header('Location: ../login/login_view.html');
die();

/**
* function to insert user email and password to database
*@param string $db_host
*@param string $db_user
*@param string $db_password
*@param string $db_name
*@return integer $user_id
*/
function insertUserToDataBase($db_connection, $db_host, $db_user, $db_password, $db_name, $email_address, $password)
{
    mysqli_select_db($db_connection, $db_name);
    $user_hash = generateHashOfEmailAddress($email_address);
    $sql = "INSERT INTO users (email, password, user_hash) VALUES ('$email_address', '$password', '$user_hash')";
    return executeQuery($db_connection, $sql);
}

/**
* function to check if there is already a user with provided email
*@param string $email
*@return integer
*/
function alreadyExists($db_connection, $db_name, $email_address)
{
    mysqli_select_db($db_connection, $db_name);
    $sql = "select count(*) from users where email = '$email_address'";
    $result = mysqli_query($db_connection, $sql);
    $row = mysqli_fetch_array($result, MYSQLI_NUM);
    return $row[0];
}

/**
* function to varification mail to user with provided email
* @param string $activation_link
*/
function sendMail($activation_link, $email_address)
{
  $to = $email_address;
  $subject = 'sign up successfull';
  $message = '<b>congratulations you have successfully signup</b>';
  $message .= '<p>click the following link to activate your account</p>';
  $message .= '<a href=' .$activation_link .'>activate account</a>';
  $retval = mail ($to,$subject,$message,$header);
  if( $retval == true ) {
     echo "Message sent successfully...";
  }else {
     echo "Message could not be sent...";
  }
}

/**
* function to generate Hash Of Email Address
*@param string $email_address
*@return string
*/
function generateHashOfEmailAddress($email_address)
{
  return md5($email_address);
}

/**
* function to generate activation link
*@param string $email_address
*@param string $user_hash
*@return string $url_link
*/
function activateLink($user_id, $user_hash)
{
  $url_link = 'http://localhost/authentication-system/activate_account.php?user_id=' .$user_id .'&hash=' .$user_hash;
  return $url_link;
}
