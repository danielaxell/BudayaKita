<?php
include "connection.php";

if(isset($_POST["submit"])) {
    // Ambil nilai nama senjata dari inputan form
    $namaSenjata = $_POST['Namasenjata'];

    // Ambil informasi gambar yang diunggah
    $namaFile = $_FILES['SenjataIMG']['name'];
    $lokasiSementara = $_FILES['SenjataIMG']['tmp_name'];

    // Membaca data gambar
    $gambar = addslashes(file_get_contents($lokasiSementara));

    // Memeriksa pilihan yang dipilih oleh pengguna
    $option = $_POST['option'];
    if ($option == "senjataadat") {
        // Jika pilihan adalah senjataadat, simpan data gambar ke tabel senjataadat
        $sql = "INSERT INTO senjataadat (Senjata, SenjataImg) VALUES ('$namaSenjata', '$gambar')";
    } elseif ($option == "rumahadat") {
        // Jika pilihan adalah tarianadat, simpan data gambar ke tabel tarianadat
        $sql = "INSERT INTO rumahadat (Rumah, RumahImg) VALUES ('$namaSenjata', '$gambar')";
    } elseif ($option == "kulinerkhas") {
        // Jika pilihan adalah tarianadat, simpan data gambar ke tabel tarianadat
        $sql = "INSERT INTO kulineradat (Kuliner, KulinerIMG) VALUES ('$namaSenjata', '$gambar')";
    } elseif ($option == "contentevents") {
        // Jika pilihan adalah tarianadat, simpan data gambar ke tabel tarianadat
        $sql = "INSERT INTO events (caption, photo) VALUES ('$namaSenjata', '$gambar')";}
        elseif ($option == "alatmusik") {
            // Jika pilihan adalah tarianadat, simpan data gambar ke tabel tarianadat
            $sql = "INSERT INTO alatmusik (Atribut, AtributIMG) VALUES ('$namaSenjata', '$gambar')";
        }
    if ($conn->query($sql) === TRUE) {
        // Tampilkan notifikasi gambar berhasil diunggah menggunakan alert JavaScript
        echo "<script>alert('Gambar berhasil diunggah.');</script>";
        // Redirect kembali ke admin.php setelah alert ditampilkan
        echo "<script>window.location.replace('admin.php');</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>
