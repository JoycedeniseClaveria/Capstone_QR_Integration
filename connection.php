<?php
    $servername = "localhost";
    $username = "u357122867_secaspi2025";
    $password = "Secaspi@2025";
    $dbname = "u357122867_capstonedb";

    $conn = new mysqli($servername, $username, $password, $dbname);


    if ($conn->connect_error) 
    {
      die("Connection failed: " . $conn->connect_error);
    }
?>