<?php
require 'C:\xampp\htdocs\BudayaKita\pages\Login BudayaKita\connectionLogin.php';
session_start();
if (isset($_SESSION['id'])) {
    $session = $_SESSION['id'];
    $fethUsername = LoginLogout::userName($session);
    var_dump($fethUsername);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" type="text/css" href="../assets/css/bootstrap.css" />
    <link rel="stylesheet" type="text/css" href="../assets/css/style.css" />
    <!-- Ganti lokasi ke folder CSS yang sesuai -->

    <!-- Logo di atas -->
    <link href="../assets/img/logobudaya.png" rel="shortcut icon" />
    <title>Provinsi</title>
</head>
<body>
    <?php include('navbar.php'); ?>

    <div class="image-header" style="background-image: url(https://babel.bpk.go.id/wp-content/uploads/2016/11/gambar-peta-indonesia-1.gif)">
        <div class="tirai"></div>
        <div class="carousel-caption d-none d-md-block mb-5">
            <h1>Provinsi Di Indonesia</h1>
        </div>
    </div>

    <br><br><br><br>

    <!-- Mulai Konten -->
    <h1 class="text-center">Provinsi di Indonesia</h1>
    <br />
    <style>
        .card {
            width: 300px;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }
        .card img {
            width: 150px;
            height: 150px;
            object-fit: cover;
            border: 2px solid #000;
            padding: 5px;
            margin-top: 40px; /* Menambahkan jarak antara bagian atas kartu dan gambar */
        }
        .card .card-title {
            text-align: center;
        }
    </style>
    <div class="container">
        <div class="row justify-content-center" id="ProvinsiContainer">
            <?php
            // Mengambil data dari tabel provinsi
            $sql = "SELECT namaProv, ProvIMG FROM provinsi";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $namaProvinsi = $row["namaProv"]; ?>
                    <div class="col-lg-4 col-md-4 col-sm-6 mb-4">
                        <div class="card h-custom" style="height: 100%;">
                            <a href="provinsi_dummy.php?namaProv=<?php echo urlencode($namaProvinsi); ?>" style="display: flex; flex-direction: column; height: 100%;">
                                <div style="flex-grow: 1; display: flex; align-items: center; justify-content: center; overflow: hidden;">
                                    <img src="data:image/jpeg;base64,<?php echo base64_encode($row["ProvIMG"]); ?>" class="card-img-top img-provinsi">
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo htmlspecialchars($namaProvinsi); ?></h5>
                                </div>
                            </a>
                        </div>
                    </div>
                <?php }
            } else {
                echo "0 results";
            }
            $conn->close();
            ?>
        </div>
    </div>

    <br><br>
    <?php include('footer.php'); ?>
</body>
</html>
