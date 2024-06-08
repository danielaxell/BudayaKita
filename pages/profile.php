<?php
require 'C:\xampp\htdocs\BudayaKita\pages\Login BudayaKita\connectionLogin.php';
session_start();
// Periksa apakah pengguna sudah login
if (isset($_SESSION['id'])) {
    $session = $_SESSION['id']; 

    // Ambil informasi pengguna dari database berdasarkan ID sesi
    $userData = LoginLogout::userData($session);
       // Pastikan data pengguna ditemukan
    if ($userData) {
        $username = $userData['username'];
        // Anda mungkin tidak ingin menampilkan password secara langsung
        // $password = $userData['password'];
        $userPict = $userData['userPict'];
    } else {
        // Redirect pengguna ke halaman login jika data pengguna tidak ditemukan
        header("Location: login.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.css">
    
    <!-- Link to the file hosted on your server, -->
    <link rel="stylesheet" href="assets/css/splide.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/style.css">

    <!-- link untuk bikin animasinya -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <!--font-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;1,100&display=swap" rel="stylesheet">
    <title>BudayaKita</title>
    <title>User Profile</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
        }

        .profile-picture {
            text-align: center;
            margin-bottom: 20px;
        }

        .profile-picture img {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            border: 5px solid #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .profile-info {
            text-align: center; /* Menengahkan teks */
        }

        .profile-info div {
            margin-bottom: 10px;
        }

        label {
            font-weight: bold;
            font-size: 20px; /* Memperbesar ukuran teks */
        }
    </style>
</head>

<body>
    <!-- Navbar start-->
    <?php include('navbar.php'); ?>
</nav><br> <br> <br>   

<div class="container">
    <div class="profile-picture">
        <?php if ($userPict): ?>
            <img src="data:image/jpeg;base64,<?php echo base64_encode($userPict); ?>" alt="Profile Picture">
        <?php else: ?>
            <span>No Profile Picture</span>
        <?php endif; ?>
    </div>
    <div class="profile-info">
        <div>
            <label>Username:</label>
            <span><?php echo $username; ?></span>
        </div>
        <div>
            <label>Password:</label>
            <!-- Tidak menampilkan password untuk alasan keamanan -->
            <span>*********</span>
        </div>
        <!-- Tambahkan button Edit Profile di bawah -->
        <button onclick="window.location.href='image.php'" class="btn btn-primary">Edit Profile</button>
    </div>
</div>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

<?php include('footer.php'); ?>
</body>
</html>
