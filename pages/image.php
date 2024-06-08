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

// Mengunggah gambar baru
if(isset($_POST["submit"])) {
    // Ambil nilai nama senjata dari inputan form
    $namaSenjata = $_POST['username'];
    $password = $_POST['password'];
    // Ambil ID atribut yang ingin diupdate
    $idAtribut = $_POST['idAtribut'];

    // Ambil informasi gambar yang diunggah
    $namaFile = $_FILES['userPict']['name'];
    $lokasiSementara = $_FILES['userPict']['tmp_name'];

    // Membaca data gambar
    $gambar = addslashes(file_get_contents($lokasiSementara));

        $sql = "UPDATE loginn SET username = '$namaSenjata', password = '$password' , userPict = '$gambar' WHERE id = $session";
    
    if ($conn->query($sql) === TRUE) {
        // Tampilkan notifikasi gambar berhasil diunggah menggunakan alert JavaScript
        echo "<script>alert('Data berhasil diperbarui.');</script>";
        // Redirect kembali ke admin.php setelah alert ditampilkan
        echo "<script>window.location.replace('admin.php');</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
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
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        h2 {
            font-size: 24px;
            margin-bottom: 20px;
            text-align: center;
        }

        form {
            text-align: center;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        select,
        input[type="text"],
        input[type="file"],
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        input[type="file"] {
            cursor: pointer;
        }

        input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
<nav class="navbar navbar-expand-lg navbar-light fixed-top bg-navbar-black">
    <img src="assets/img/logobudaya.png" height="60px"> 
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="index.php" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
        <ul class="navbar-nav mx-auto">
            <li class="nav-item">
                <a class="nav-link scroll-trigger text-white" href="index.php">Beranda</a>
            </li> 
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle text-white" href="#" id="navbarDropdownBudaya" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Budaya
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdownBudaya">
                    <a class="dropdown-item" href="SeniTari.php">Museum</a>
                    <a class="dropdown-item" href="#">Event</a>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle text-white" href="#" id="navbarDropdownProvinsi" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Provinsi
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdownProvinsi">
                    <a class="dropdown-item" href="Provinsi.php">Provinsi</a>
                    <a class="dropdown-item" href="SenjataAdat.php">Senjata Adat</a>
                    <a class="dropdown-item" href="TarianAdat.php">Tarian Adat</a>
                    <a class="dropdown-item" href="AlatMusikAdat.php">Alat Musik Adat</a>
                    <a class="dropdown-item" href="PakaianAdat.php">Pakaian Adat</a>
                    <a class="dropdown-item" href="RumahAdat.php">Rumah Adat</a>
                    <a class="dropdown-item" href="KulinerKhas.php">Kuliner</a>
                    <a class="dropdown-item" href="Destinasi.php">Destinasi</a>
                </div>
            </li>
        </ul>
        <?php if (!isset($userData)): ?>
            <a href="Login BudayaKita/Register.php">
                <button class="btn btn-warning">Daftar</button>
            </a> 
        <?php else: ?>
            <div class="nav-item dropdown">
                <a class="btn btn-warning dropdown-toggle" href="#" role="button" id="navbarDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <?php 
                    if (isset($userData)) {
                        echo $userData['username'];
                    }
                    ?>
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="Login BudayaKita\profile.php">Profil</a> <!-- Ganti tautan dengan halaman profil -->
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="Login BudayaKita\Login.php">Logout</a> <!-- Ganti tautan dengan proses logout -->
                </div>
            </div>
        <?php endif; ?>
    </div>
</nav> <br> <br> <br> <br> <br> 

<div class="container">
<h2>Update Data</h2>
        <form action="#" method="post" enctype="multipart/form-data">
            <div>
                <label for="username">Nama Atribut :</label>
                <input type="text" id="username" name="username" value="<?php echo $username; ?>">
            </div>
            <div>
                <label for="password">Password :</label>
                <input type="text" id="password" name="password" placeholder="Masukkan Password Baru">
            </div>
            <div>
                <label for="userPict">Gambar:</label>
                <input type="file" name="userPict" id="userPict">
            </div>
            <input type="submit" value="Unggah Gambar" name="submit">
        </form>
                </div>
    </body>
    </html>
