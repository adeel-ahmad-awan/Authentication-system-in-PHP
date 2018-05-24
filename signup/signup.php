<?php

require '../credentials.php';
require '../common_functions.php';

$email_address = $_POST[email];
$password = $_POST[password];
//Creating database connection
$db_connection = createDataBaseConnection(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
// insert if there is not a user with given email address in database

// insert record in database table
if (insertUserToDataBase($db_connection, DB_HOST, DB_USER, DB_PASSWORD, DB_NAME, $email_address, $password)) {
    // get user id of last inserted user
    $user_id = mysqli_insert_id($db_connection);
    // send activation link via email
    sendMail(activateLink($user_id, generateHashOfEmailAddress($email_address)), $email_address);
    //close database conncetion
    mysqli_close($db_connection);
    // redirect to login page
    header('Location: ../login/login_view.html');
    die();

} else {
  //close database conncetion
  mysqli_close($db_connection);
  // redirect back to signup page
  header('Location: ../signup/sighup.html');
  die();
}

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
    $query = "INSERT INTO users (email, password, user_hash) VALUES ('$email_address', '$password', '$user_hash')";
    return executeQuery($db_connection, $query);
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
    $retval = mail($to, $subject, $message, $header);
    if ($retval == true) {
        echo "Message sent successfully...";
    } else {
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
