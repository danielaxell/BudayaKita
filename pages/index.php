<?php
require 'C:\xampp\htdocs\BudayaKita\pages\Login BudayaKita\connectionLogin.php';
session_start();

if (isset($_SESSION['id'])) {
    $session = $_SESSION['id'];
    $fethUsername = LoginLogout::userName($session);
} else {
    $fethUsername = null;
}
?>

<!doctype html>
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
   
    <link href="assets/img/logobudaya.png" rel="shortcut icon">
    <a href="index.php">
    <title>BudayaKita</title>
  </head>

  <body>
  <!-- Navbar start-->
  <?php include('navbar.php'); ?>
</nav>  
<!-- Navbar End -->

 <!-- LANDING PAGE start-->
 <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel" data-wrap="true">
        <ol class="carousel-indicators">
            <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
        </ol>
        <div class="carousel-inner">
            <div class="carousel-item active" data-interval="5000">
                <a href="AlatMusikAdat.php">
                    <img class="d-block w-100 slideshow img-fluid" src="assets/img/musik.png" alt="musik">
                </a>
                <div class="carousel-caption d-none d-md-block">
                    <h1 class="fw-bold">SENI MUSIK</h1>
                </div>
            </div>
            <div class="carousel-item" data-interval="5000">
                <a href="Tarianadat.php">
                    <img class="d-block w-100 slideshow img-fluid" src="assets/img/tari.png" alt="tari">
                </a>
                <div class="carousel-caption d-none d-md-block">
                    <h1 class="fw-bold">SENI TARI</h1>
                </div>
            </div>
            <div class="carousel-item" data-interval="5000">
                <a href="Pakaianadat.php">
                <img class="d-block w-100 slideshow img-fluid" src="assets/img/rupa.png" alt="rupa">
                <div class="carousel-caption d-none d-md-block">
                    <h1 class="fw-bold">PAKAIAN ADAT</h1>
                </div>
            </div>
        </div>
        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>
    <!-- LANDING PAGE end-->
    <br> <br> <br>

    <!--Budaya Indonesia Start-->
    <div id="Budaya">
        <div class="container">
            <div class="row" data-aos="zoom-in-down" data-aos-delay="100" data-aos-duration="1000">
                <div class="col-xl-6">
                    <img src="assets/img/budaya.png" class="mx-auto d-block img-fluid w-60">
                </div>
                <div class="col-xl-6">
                    <br>
                    <h1 class="text-left fw-bold">Budaya Indonesia</h1>
                    <br>
                    <p class="text-justify">Kondisi budaya di Indonesia sangat kaya dan beragam, ini mencerminkan keanekaragaman etnis, bahasa, agama, dan tradisi yang ada di negara ini. Beberapa aspek penting dalam kondisi budaya Indonesia melibatkan seni, bahasa, agama, dan adat istiadat.</p>
                </div>
            </div>
        </div>
    </div>
    <!--Budaya Indonesia end-->

    <!--Visit Indonesia-->
    <div id="Explore" class="pt-5" data-aos="zoom-in-down" data-aos-delay="100" data-aos-duration="1000"><br><br>
        <div class="explore">
            <h1 class="text-center fw-bold">Jelajah Budaya Indonesia</h1>
            <object data="peta.svg" ></object>
        </div>
    </div>
    <!--Visit End-->
    <br><br>

    <!--Footer-->
    <?php include('footer.php'); ?>
    <!--Footer End-->

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="assets/js/splide.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
    <script>
        new Splide('.splide').mount();
    </script>
    <script>
        $('.carousel').carousel({
            interval: 5000
        });
    </script>
</body>
</html>
