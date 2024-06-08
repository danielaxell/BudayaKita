<?php
require 'C:\xampp\htdocs\BudayaKita\pages\Login BudayaKita\connectionLogin.php';
session_start();
if (isset($_SESSION['id'])){
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
    <title>Pakaian Adat</title>
</head>
<body>
    <?php include('navbar.php'); ?>

    <div class="image-header" style="background-image: url(img/pakaianadat.jpg)">
        <div class="tirai"></div>
        <div class="carousel-caption d-none d-md-block mb-5">
            <h1>PAKAIAN ADAT</h1>
        </div>
    </div>

    <br><br><br><br>

    <!-- Mulai Konten -->
    <h1 class="text-center">Pakaian Adat di Indonesia</h1>
    <br />
    <style>
        .card {
            height: 360px;
            width: 330px;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        .card img {
            width: 330px;
            height: 320px;
            object-fit: cover;
            margin: auto;
        }
        .modal-image {
            max-width: 100%;
            max-height: 400px;
            border: 2px solid #ddd; /* Bingkai pada gambar */
            padding: 5px; /* Spasi antara gambar dan bingkai */
            border-radius: 10px; /* Sudut bingkai melengkung */
            background-color: #fff; /* Warna latar belakang bingkai */
        }
        .modal-description {
            font-size: 0.875rem; /* Ukuran font kecil */
            white-space: pre-line; /* Preserve line breaks */
        }
    </style>
    <div class="container">
        <div class="row justify-content-center" id="pakaianContainer">
            <?php
            // Mengambil data dari tabel pakaianadat
            $sql = "SELECT Pakaian, PakaianIMG, DesPakaianAdat FROM pakaianadat";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $namaPakaian = $row["Pakaian"];
                    $deskripsiPakaian = $row["DesPakaianAdat"];
                    $imgData = base64_encode($row["PakaianIMG"]);
                    echo "<div class=\"col-lg-4 col-md-4 col-sm-6 mb-4\">";
                    echo "  <div class=\"card h-custom\" data-toggle=\"modal\" data-target=\"#imageModal\" data-name=\"$namaPakaian\" data-img=\"$imgData\" data-description=\"" . htmlspecialchars($deskripsiPakaian) . "\">";
                    echo "    <img src=\"data:image/jpeg;base64,$imgData\" class=\"card-img-top img-kuliner\" style=\"object-fit: cover;\">";
                    echo "    <div class=\"card-body\">";
                    echo "      <h5 class=\"card-title\">${namaPakaian}</h5>";
                    echo "    </div>";
                    echo "  </div>";
                    echo "</div>";
                }
            } else {
                echo "0 results";
            }
            $conn->close();
            ?>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="imageModalLabel">Detail Pakaian Adat</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    <img id="modalImage" src="" class="img-fluid modal-image" alt="Gambar Pakaian Adat">
                    <p id="modalDescription" class="mt-3 modal-description"></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

    <script>
        $(document).ready(function(){
            $('.dropdown-toggle').dropdown();
        });

        $('#imageModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var name = button.data('name');
            var img = button.data('img');
            var description = button.data('description');

            var modal = $(this);
            modal.find('.modal-title').text(name);
            modal.find('#modalImage').attr('src', 'data:image/jpeg;base64,' + img);
            modal.find('#modalDescription').html(description.replace(/\n/g, '<br>'));
        });
    </script>

    <?php include('footer.php'); ?>
</body>
</html>
