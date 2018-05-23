<?php

require '../credentials.php';
require '../common_functions.php';

//Creating database connection
$db_connection = createDataBaseConnection(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
if (! $db_connection) {
    echo 'Connected failure' . PHP_EOL;
    die();
}
mysqli_select_db($db_connection, DB_NAME);
$email_address = $_POST[email];
$password = $_POST[password];
validateEmailAndPassword($email_address, $password, $db_connection);
mysqli_close($db_connection);

/**
* function to validates users email and password
* @param string $email_address
* @param string $password
*/
function validateEmailAndPassword($email_address, $password, $db_connection)
{
    $sql = "select * from users where users.email='$email_address' and users.password='$password' and users.activation_status='activated'";
    $result = mysqli_query($db_connection, $sql) or die("MySQL error: " . mysqli_error($db_connection) . "<hr>\nQuery: $sql");
    $row = mysqli_fetch_array($result);
    if (!($row == false)) {

        if ($row['access_level'] == 'normal') {
            displayNormalUserData($row);
        } else {
            displayNormalUserData($row);
            $sql = "select * from users where users.email!='$email_address'";
            $result = mysqli_query($db_connection, $sql) or die("MySQL error: " . mysqli_error($db_connection) . "<hr>\nQuery: $sql");
            displayAdminUserData($result);
        }
      } else {
        header('Location: login_view.html');
      }
}

/**
* function to display data of user with access_level 'Normal'
* @param array $row
*/
function displayNormalUserData($row)
{
    echo '<h1>welcome</h1><h2>' . $row['email'] .'</h2>';
}

/**
* function to display data of user with access_level 'Administrator'
* @param object $result
*/
function displayAdminUserData($result)
{
    echo '<table><tr><th>ID</th><th>Email</th><th>Access Level</th><th>Activation Status</th></tr>';
    while ($row = $result->fetch_assoc()) {
        echo '<tr>';
        echo '<td>' .$row["id"] .'</td>';
        echo '<td>' .$row["email"] .'</td>';
        echo '<td>' .$row["access_level"] .'</td>';
        echo '<td>' .$row["activation_status"] .'</td>';
        echo '</tr>';
    }
    echo '</table>';
}
