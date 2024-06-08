<?php
require 'C:\xampp\htdocs\BudayaKita\pages\Login BudayaKita\connectionLogin.php';
session_start();
if (isset($_SESSION['id'])) {
  $session = $_SESSION['id']; // Perbaiki typo pada baris ini (kurung siku, bukan kurung biasa)
  $fethUsername = LoginLogout::userName($session);
  var_dump($fethUsername);
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
    <title>BudayaKita</title>
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
  <!-- Navbar start-->
  <?php include('navbar.php'); ?>
</nav><br> <br> <br>   

  <div class="container">
    <div class="row justify-content-center">
      <div class="col-xl-6 text-center">
        <br>
        <h1 class="">Admin Pages</h1>
      </div>
    </div>

    <h2>List of Users</h2>
    <div class="table-responsive">
      <table class="table" style="border: 1px solid #dee2e6;">
        <thead>
          <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Password</th>
            <th>Level</th>
          </tr>
        </thead>
        <tbody>
          <?php
          // Panggil fungsi listofuser untuk mendapatkan daftar pengguna
          $users = LoginLogout::listofuser();
          foreach ($users as $user) {
            echo "<tr>";
            echo "<td style='border: 1px solid #dee2e6;'>" . $user['id'] . "</td>";
            echo "<td style='border: 1px solid #dee2e6;'>" . $user['username'] . "</td>";
            echo "<td style='border: 1px solid #dee2e6;'>" . $user['password'] . "</td>";
            echo "<td style='border: 1px solid #dee2e6;'>" . $user['level'] . "</td>";
            echo "</tr>";
          }
          ?>
        </tbody>
      </table>
    </div>

<!-- Inserting content senjata adat -->
<h2>Insert Data to Pages</h2>
        <form action="upload.php" method="post" enctype="multipart/form-data">
            <div>
                <label for="option">Pilih Kategori :</label>
                <select name="option" id="option">
                    <option value="senjataadat">Senjata Adat</option>
                    <option value="rumahadat">Rumah Adat</option>
                    <option value="kulinerkhas">Kuliner Khas</option>
                    <option value="alatmusik">alat musik</option>
                    <option value="contentevents">Content Event</option>
                    
                </select>
            </div>
            <div>
                <label for="namasenjata">Nama Atribut :</label>
                <input type="text" id="Namasenjata" name="Namasenjata" placeholder="Masukkan Nama Atribut">
            </div>
            <div>
                <label for="senjataIMG">Gambar:</label>
                <input type="file" name="SenjataIMG" id="senjataIMG">
            </div>
            <input type="submit" value="Unggah Gambar" name="submit">
        </form>
<br> <br> <br>
</div>

<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
<?php include('footer.php'); ?>
</body>

</html>