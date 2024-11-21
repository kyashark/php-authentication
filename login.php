<?php 
include 'config.php';

session_start();

if($_SERVER['REQUEST_METHOD']=== "POST"){
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username ='$username' AND password = '$password'";
    $result = $connection -> query($sql);

    if($result -> num_rows > 0){
        $user = $result->fetch_assoc();
        $_SESSION['username'] = $user['username'];
        header("Location:home.php");
    }
    else{
        echo "Invalid username or password.";
    }
}
   
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Login Form</title>
</head>
<body>
    <div class="login-container">
        <h3>Login Form</h3>
        <form method="POST">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" required>

            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>

            <button type="submit">Login</button>
        </form>
        <h5>You didn't have an Account ? <a href="register.php">Register<a></h5>
    </div>
</body>
</html>