<?php
require 'connectionLogin.php';
if (isset($_POST['SubmitButton'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    if (!empty($_POST['username']) && !empty($_POST['password'])) {
        // Check if the username already exists
        $existingUser = LoginLogout::getUserByUsername($username);
        if ($existingUser) {
            // If the username already exists, display an alert using JavaScript
            echo '<script>alert("Username already exists");</script>';
        } else {
            // If the username doesn't exist, insert it into the database
            $insert = LoginLogout::inserting($username, $password);
            echo '<script>alert("User Registered Successfully..");</script>';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!--=============== REMIXICONS ===============-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/3.5.0/remixicon.css" crossorigin="" />

    <!--=============== CSS ===============-->
    <link rel="stylesheet" href="assets/css/styles.css" />

    <title>Register - BudayaKita</title>
</head>

<body>
    <div class="login">
        <img src="assets/img/login.jpg" alt="image" class="login__bg" />
        <div class="Logo1">
            <form action="" method="post" class="login__form">
                <h1 class="login__title">Sign Up</h1>

                <div class="login__inputs">
    <div class="login__box">
        <input type="text" name="username" placeholder="username" required class="login__input" /> <!-- Add name="username" -->
        <i class="ri-mail-fill"></i>
    </div>

    <div class="login__box">
        <input type="password" name="password" placeholder="password" required class="login__input" /> <!-- Add name="password" -->
        <i class="ri-lock-2-fill"></i>
    </div>
</div>
                <button type="submit" name="SubmitButton" class="login__button">Sign Up</button>
                <div class="login__register">Have an account? <a href="Login.php">Login</a></div>
            </form>
        </div>
    </div>
</body>

</html>