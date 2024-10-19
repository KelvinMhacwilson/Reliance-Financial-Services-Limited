<?php
    //Database connection
    define ('HOST','localhost');
    define('USERNAME', 'root');
    define("PASSWORD", "");
    define('DB_NAME','hrms');

    $conn = new mysqli(HOST, USERNAME, PASSWORD, DB_NAME);
    if ($conn->connect_error) 
    {
        die("Connection failed");
    }
    else
    {
        // echo "Connection successful";
    }
?>