<?php
$db_host = 'localhost:3306';
$db_user = 'root';
$db_password = 'coeus123';
$db_name = 'MYUSERS';
$db_connection = mysqli_connect($db_host, $db_user, $db_password);

if (! $db_connection) {
    echo 'Connected failure' . PHP_EOL;
}
echo 'Connected successfully' . PHP_EOL;

mysqli_select_db($db_connection, $db_name);

$email_address = " .$_POST[email] . '<br>';
$password = " .$_POST[password] . '<br>';
validateEmailAndPassword($_POST[email], $_POST[password], $db_connection);
// validateEmailAndPassword('adeelahmadawan@gmail.com', 'password', $db_connection);

mysqli_close($db_connection);

/**
* function to validates users email and password
*@param string $email_address
*@param string $password
*/
function validateEmailAndPassword($email_address, $password, $db_connection)
{
    $sql = "select * from my_users where my_users.email='$email_address'";
    $result = mysqli_query($db_connection, $sql) or die("MySQL error: " . mysqli_error($db_connection) . "<hr>\nQuery: $sql");
    $row = mysqli_fetch_array($result);

    if ($row['email'] == $email_address && $row['password'] == $password) {
        if ($row['access_level'] == 'normal') {
            echo '<h1>welcome</h1><h2>' . $row['email'] .'</h2>';
        } else {
            echo '<h1>welcome</h1><h2>' . $row['email'] .'</h2>';
            $sql = "select * from my_users";
            $result = mysqli_query($db_connection, $sql) or die("MySQL error: " . mysqli_error($db_connection) . "<hr>\nQuery: $sql");
            // $row = mysqli_fetch_array($result);
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
    }
}
