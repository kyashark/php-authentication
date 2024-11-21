<?php
    $server_name = "localhost";
    $username = "root";
    $password = "";
    $database = "auth_db";

    $connection = new mysqli($server_name,$username,$password,$database);

    if ($connection -> connect_error){
        die("Connection Error");
    }
    else{
        // echo 'Successfuly connected';
    }

?>