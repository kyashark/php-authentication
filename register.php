<?php

include 'config.php';

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Store user in database
    $sql = "INSERT INTO users (username,email,password) VALUES ('$username','$email','$password')";

    // Execute the query
    $result = $connection -> query($sql);

    // Check for errors
    if($result === TRUE){
        echo 'Registration successful';
        header("Location:login.php");
    }
    else{
        echo "Error: " . $sql . "<br>" . $connection->error;
    } 
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Register Form</title>
</head>
<body>
    <div class="login-container">
        <h3>Register Form</h3>
        <form method="POST">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" required>

            <label for="email">Email</label>
            <input type="email" id="email" name="email" required>

            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>

            <button type="submit">Register</button>
        </form>
        <h5>You already have an account ? <a href="login.php">Login<a></h5>
    </div>
</body>
</html>