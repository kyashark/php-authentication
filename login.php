<?php 
include 'config.php';

session_start();

if($_SERVER['REQUEST_METHOD'] === "POST"){

    // Collect and Savitize input
    $username = htmlspecialchars(trim($_POST['username']));
    $password =trim($_POST['password']);

    // Initialize an array to hold errors
    $errors = [];

    // Validate username
    if(empty($username)){
        $errors[] = "Username is required.";
    }

    if(empty($password)){
        $errors[] = "Password is required.";
    }

    if(!empty($errors)){
        $error_message = implode("<br>",$errors);
    }

    else{
        $sql = "SELECT * FROM users WHERE username ='$username'";
        $result = $connection -> query($sql);

        if($result -> num_rows > 0){
            $user = $result->fetch_assoc();

            if($password === $user['password']){
                $_SESSION['username'] = $user['username'];
                echo "<script>alert('Login successful!');</script>";
                echo "<script>window.location.href = 'home.php';</script>";
            }
            else{
                // Incorrect password
                $error_message = "Invalid username or password.";
            }   
    }
    else {
        // Username not found
        $error_message = "Invalid username or password.";
    }
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

            <p class="error-text">
                <?php if (!empty($error_message)) echo $error_message; ?>
            </p>

            <button type="submit">Login</button>
        </form>
        <h5>You didn't have an Account ? <a href="register.php">Register<a></h5>
    </div>
</body>
</html>