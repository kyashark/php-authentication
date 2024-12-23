<?php

include 'config.php';

if($_SERVER['REQUEST_METHOD'] === 'POST'){

    // Collect and Savitize input
    $username =htmlspecialchars(trim($_POST['username'])) ;
    $email =htmlspecialchars(trim($_POST['email'])) ;
    $password =trim($_POST['password']);

    // Initialize an array to hold errors
    $errors = [];

    // Validate username
    if(empty($username)) {
        $errors[] = "Username is required";
    }elseif(strlen($username) < 3){
        $errors[] = "Username must be at least 3 characters.";
    }

    // Validate Email;
    if(empty($email)){
        $errors[] = "Email is required";
    }
    elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $errors[] = "Invalid email address.";
    }
    else{
        // Check if email already exists using a prepared statement
        $stmt = $connection->prepare("SELECT * FROM users WHERE email= ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt_result = $stmt->get_result();
        if($stmt_result->num_rows > 0){
            $errors[]="This email is already use.";
        }
        $stmt->close();
    }

    // Validate password
    if(empty($password)){
        $errors[] = "Password is required.";
    }
    elseif(strlen($password)<6){
        $errors[] = "Password must be at least 6 characters long.";
    }
    elseif(!preg_match("/[A-Z]/",$password)){
        $errors[] = "Password must contain at least one uppercase letter.";
    }
    elseif (!preg_match("/[0-9]/", $password)) {
        $errors[] = "Password must contain at least one number.";
    }

    // Check for error
    if(!empty($errors)){
            $error_message = implode("<br>",$errors);
    }
    else{

        // hash the password
        $hashed_password = password_hash($password,PASSWORD_DEFAULT);

        // Set is_admin to 0 for normal users by default (for admin, set it to 1 manually)
        $is_admin = 1 ;

        $stmt = $connection->prepare("INSERT INTO users (username,email,password,is_admin) VALUES (?,?,?,?)");
        $stmt->bind_param("sssi",$username,$email,$hashed_password,$is_admin);
        $result = $stmt->execute();
    
        // Check for errors
        if($result === TRUE){
            echo "<script>alert('Registration successful');</script>";
            echo "<script>window.location.href = 'login.php';</script>";
        }
        else{
            $error_message = "Error: " . $sql . "<br>" . $connection->error;
        } 
        $stmt->close();
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

            <span class='error-text'>
                <?php if (!empty($error_message)) echo $error_message; ?>
            </span>

            <button type="submit">Register</button>
        </form>
        <h5>You already have an account ? <a href="login.php">Login<a></h5>
    </div>
</body>
</html>