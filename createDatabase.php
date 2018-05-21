<?php
   $dbhost = 'localhost:3306';
   $dbuser = 'root';
   $dbpass = 'coeus123';
   $conn = mysqli_connect($dbhost, $dbuser, $dbpass);

   if (! $conn) {
       echo 'Connected failure' . PHP_EOL;
   }
   echo 'Connected successfully' . PHP_EOL;
   $sql = 'CREATE DATABASE MYUSERS';

   if (mysqli_query($conn, $sql)) {
       echo 'Database created successfully' . PHP_EOL;
   } else {
       echo 'Error creating database: ' . mysqli_error($conn) . PHP_EOL;
   }
   mysqli_close($conn);
