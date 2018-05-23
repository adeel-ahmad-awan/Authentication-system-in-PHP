<?php

require '../credentials.php';

$db_connection = mysqli_connect(db_host, db_user, db_password);
if (! $db_connection) {
    echo 'Connected failure' . PHP_EOL;
    die();
}
mysqli_select_db($db_connection, db_name);
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
    $sql = "select * from my_users where my_users.email='$email_address'";
    $result = mysqli_query($db_connection, $sql) or die("MySQL error: " . mysqli_error($db_connection) . "<hr>\nQuery: $sql");
    $row = mysqli_fetch_array($result);

    if ($row['email'] == $email_address && $row['password'] == $password) {
        if ($row['access_level'] == 'normal') {
            displayNormalUserData($row);
        } else {
            displayNormalUserData($row);
            $sql = "select * from my_users";
            $result = mysqli_query($db_connection, $sql) or die("MySQL error: " . mysqli_error($db_connection) . "<hr>\nQuery: $sql");
            displayAdminUserData($result);
        }
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
    echo '<table><tr><th>ID</th><th>Email</th><th>Access Level</th><th>Activation Status</th><th>user hash</th></tr>';
    while ($row = $result->fetch_assoc()) {
        echo '<tr>';
        echo '<td>' .$row["id"] .'</td>';
        echo '<td>' .$row["email"] .'</td>';
        echo '<td>' .$row["access_level"] .'</td>';
        echo '<td>' .$row["activation_status"] .'</td>';
        echo '<td>' .$row["user_hash"] .'</td>';
        echo '</tr>';
    }
    echo '</table>';
}
