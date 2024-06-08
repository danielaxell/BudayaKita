<?php
session_start(); // Mulai sesi
require 'connectionLogin.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['SubmitButton'])) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (!empty($username) && !empty($password)) {
        // Proses login
        $user = LoginLogout::login($username, $password);
        
        if ($user && password_verify($password, $user['password'])) {
            // Set session
            $_SESSION['id'] = $user['id'];
            $_SESSION['username'] = $user['username'];

            // Redirect to homepage
            header('Location: index.php');
            exit();
        } else {
            echo '<script>alert("Invalid username or password.");</script>';
        }
    } else {
        echo '<script>alert("Please fill all fields.");</script>';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/3.5.0/remixicon.css" crossorigin="">
    <link rel="stylesheet" href="assets/css/styles.css">
    <title>Login - BudayaKita</title>
</head>
<body>
    <div class="login">
        <img src="assets/img/login.jpg" alt="image" class="login__bg">
        <form action="" method="post" class="login__form">
            <h1 class="login__title">Login</h1>
            <div class="login__inputs">
                <div class="login__box">
                    <input type="text" name="username" placeholder="username" required class="login__input">
                    <i class="ri-mail-fill"></i>
                </div>
                <div class="login__box">
                    <input type="password" name="password" placeholder="password" required class="login__input">
                    <i class="ri-lock-2-fill"></i>
                </div>
            </div>
            <div class="login__check">
                <div class="login__check-box">
                    <input type="checkbox" class="login__check-input" id="user-check">
                    <label for="user-check" class="login__check-label">Remember me</label>
                </div>
                <!-- Adjust the href attribute based on your application's requirements -->
                <a href="#" class="login__forgot">Forgot Password?</a>
            </div>
            <button type="submit" name="SubmitButton" class="login__button">Login</button>
            <div class="login__register">Don't have an account? <a href="Register.php">Register</a></div>
        </form>
    </div>
</body>
</html>
