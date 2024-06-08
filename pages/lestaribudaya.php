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
  <title>Lestari Budaya Indonesia</title>

  <!-- Tambahkan CSS kustom jika diperlukan -->
  <style>
    .content-section {
      margin: 50px 0;
    }

    .content-section img {
      max-width: 100%;
      height: auto;
    }

    .content-section .content-text {
      padding: 20px;
    }
  </style>
</head>

<body>
  <?php include('navbar.php'); ?>
  <!-- Navbar End -->
  <div class="image-header" style="background-image: url(img/lestaribudaya.jpg)">
        <div class="tirai"></div>
        <div class="carousel-caption d-none d-md-block mb-5">
            <h1>LESTARI BUDAYA</h1>
        </div>
    </div>

  <!-- Lestari Budaya Start -->
  <div id="lestaribudaya" class="content-section">
    <div class="container">
      <!-- Cara 1 -->
      <div class="row" data-aos="zoom-in-down" data-aos-delay="100" data-aos-duration="1000">
        <div class="col-xl-6">
          <img src="img/lestari1.jpg" class="mx-auto d-block img-fluid">
        </div>
        <div class="col-xl-6 content-text">
          <br>
          <h1 class="text-left fw-bold">Cara 1: Mengajarkan Budaya Lokal</h1>
          <br>
          <p class="text-justify">Mengajarkan budaya lokal kepada generasi muda adalah salah satu cara efektif untuk melestarikan budaya Indonesia. Ini bisa dilakukan melalui pendidikan formal di sekolah maupun pendidikan informal di lingkungan keluarga dan masyarakat. Dengan memahami sejarah, nilai-nilai, dan praktik budaya, generasi muda akan lebih menghargai dan melestarikan warisan budaya mereka.</p>
        </div>
      </div>
      <br><br>

      <!-- Cara 2 -->
      <div class="row flex-row-reverse" data-aos="zoom-in-down" data-aos-delay="100" data-aos-duration="1000">
        <div class="col-xl-6">
          <img src="img/lestari2.jpg" class="mx-auto d-block img-fluid">
        </div>
        <div class="col-xl-6 content-text">
          <br>
          <h1 class="text-left fw-bold">Cara 2: Mengadakan Festival Budaya</h1>
          <br>
          <p class="text-justify">Mengadakan festival budaya secara rutin dapat menjadi salah satu cara melestarikan budaya Indonesia. Festival ini bisa mencakup berbagai aspek budaya seperti tari-tarian, musik tradisional, kuliner khas, dan pameran seni. Selain itu, festival budaya juga dapat menarik minat wisatawan dan meningkatkan ekonomi lokal.</p>
        </div>
      </div>
    </div>
  </div>
  <!-- Lestari Budaya End -->

  <!-- Footer -->
  <?php include('footer.php'); ?>
  <!-- Footer End -->

 <!-- Bootstrap JS -->
 <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</body>
</html>
