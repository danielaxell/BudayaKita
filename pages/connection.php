<?php

// Detail koneksi database (ganti dengan kredensial Anda)
$hostname = "localhost";
$username = "root";
$password = "";
$database = "budayakita";
// Buat koneksi
$conn = mysqli_connect($hostname, $username, $password, $database);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>