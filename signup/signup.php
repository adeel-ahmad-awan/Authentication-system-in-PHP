<?php
$db_host = 'localhost:3306';
$db_user = 'root';
$db_password = 'coeus123';
$db_name = 'MYUSERS';
$db_connection = null;

sendMail();

// // Create connection
// $db_connection = createDataBaseConnection($db_host, $db_user, $db_password, $db_name);
//
// if (!(alreadyExists($db_connection, $db_name) > 0)) {
//     // insert record in database table
//     insertUserToDataBase($db_connection, $db_host, $db_user, $db_password, $db_name);
//     sendMail();
// }
//
// //close database conncetion
// mysqli_close($db_connection);

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
    require '../PHPMailerAutoload.php';
    $mail = new PHPMailer;

    // $mail->SMTPDebug = 4;                               // Enable verbose debug output

    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = 'adeel.ahmed@coeus-solutions.de';                 // SMTP username
    $mail->Password = 'coeus123';                           // SMTP password
    $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 587;                                    // TCP port to connect to

    $mail->setFrom('adeel.ahmed@coeus-solutions.de', 'registration success');
    $mail->addAddress('adeelahmadawan@gmail.com', 'adeel');     // Add a recipient
    $mail->addReplyTo('adeel.ahmed@coeus-solutions.de', 'Information');

    $mail->isHTML(true);                                  // Set email format to HTML

    $mail->Subject = 'registration success';
    $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    if (!$mail->send()) {
        echo 'Message could not be sent.';
        echo 'Mailer Error: ' . $mail->ErrorInfo;
    } else {
        echo 'Message has been sent';
    }
}
