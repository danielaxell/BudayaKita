<?php
session_start();
include "connection.php";

$isUserLoggedIn = isset($_SESSION['user']);
$username = null;

if ($isUserLoggedIn) {
    $username = $_SESSION['user']['username'];
}

// Periksa apakah parameter 'table' ada di URL
if (!isset($_GET['table'])) {
    header('Location: navbaradmin.php');
    exit();
}

$table = $_GET['table'];

if (isset($_POST["submit"])) {
    // Ambil nilai dari inputan form
    $namaAtribut = $_POST['namaAtribut'];
    $namaProv = $_POST['namaProv'];

    // Ambil informasi gambar yang diunggah
    $namaFile = $_FILES['gambar']['name'];
    $lokasiSementara = $_FILES['gambar']['tmp_name'];

    // Membaca data gambar
    $gambar = addslashes(file_get_contents($lokasiSementara));

    // Tentukan kolom tabel berdasarkan tabel yang dipilih
    switch ($table) {
        case "senjataadat":
            $sql = "INSERT INTO senjataadat (Senjata, SenjataImg, namaProv) VALUES (?, ?, ?)";
            break;
        case "rumahadat":
            $sql = "INSERT INTO rumahadat (Rumah, RumahImg, namaProv) VALUES (?, ?, ?)";
            break;
        case "kulineradat":
            $sql = "INSERT INTO kulineradat (Kuliner, KulinerIMG, namaProv) VALUES (?, ?, ?)";
            break;
        case "events":
            $sql = "INSERT INTO events (caption, photo, namaProv) VALUES (?, ?, ?)";
            break;
        case "alatmusik":
            $sql = "INSERT INTO alatmusik (Atribut, AtributIMG, namaProv) VALUES (?, ?, ?)";
            break;
        default:
            echo "Invalid table name!";
            exit();
    }

    // Siapkan pernyataan SQL
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $namaAtribut, $gambar, $namaProv);

    if ($stmt->execute()) {
        echo "<script>alert('Data berhasil ditambahkan.');</script>";
        echo "<script>window.location.replace('navbaradmin.php');</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.css">
    <link rel="stylesheet" href="assets/css/splide.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;1,100&display=swap" rel="stylesheet">
    <title>BudayaKita - Add Data</title>
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
<?php include('navbar.php'); ?>

    <div class="container mt-5">
        <h2>Tambah Data</h2>
        <form action="" method="post" enctype="multipart/form-data">
            <div>
                <label for="namaAtribut">Nama Atribut:</label>
                <input type="text" id="namaAtribut" name="namaAtribut" placeholder="Masukkan Nama Atribut">
            </div>
            <div>
                <label for="namaProv">Nama Provinsi:</label>
                <input type="text" id="namaProv" name="namaProv" placeholder="Masukkan Nama Provinsi">
            </div>
            <div>
                <label for="gambar">Gambar:</label>
                <input type="file" name="gambar" id="gambar">
            </div>
            <input type="submit" value="Tambah Data" name="submit">
        </form>
    </div>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <?php include('footer.php'); ?>
</body>
</html>
