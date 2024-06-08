<?php
session_start();
include "connection.php";

$isUserLoggedIn = isset($_SESSION['user']);
$username = null;

if ($isUserLoggedIn) {
    $username = $_SESSION['user']['username'];
}

// Periksa apakah parameter 'table' dan 'namaProv' ada di URL
if (!isset($_GET['table']) || !isset($_GET['namaProv'])) {
    header('Location: navbaradmin.php');
    exit();
}

$table = $_GET['table'];
$namaProv = $_GET['namaProv'];

// Ambil data dari database berdasarkan namaProv untuk pengeditan
$sql = "SELECT * FROM $table WHERE namaProv = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $namaProv);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();

if (!$data) {
    echo "Data not found!";
    exit();
}

// Periksa apakah formulir pengeditan telah dikirim
if (isset($_POST["submit"])) {
    // Siapkan pernyataan SQL untuk pembaruan
    $fields = [];
    $values = [];
    $types = '';

    // Loop melalui semua data yang diterima dari formulir, kecuali gambar
    foreach ($data as $column => $value) {
        if ($column != 'namaProv') {
            if (isset($_POST[$column])) {
                $fields[] = "$column = ?";
                $values[] = $_POST[$column];
                $types .= 's'; // Asumsikan semua tipe data adalah string
            }
        }
    }

    // Periksa apakah ada file gambar yang diunggah
    if (!empty($_FILES['gambar']['name'])) {
        $namaFile = $_FILES['gambar']['name'];
        $lokasiSementara = $_FILES['gambar']['tmp_name'];
        $gambar = addslashes(file_get_contents($lokasiSementara));
        $fields[] = "gambar = ?";
        $values[] = $gambar;
        $types .= 's';
    }

    // Tambahkan namaProv baru ke array values dan types
    $namaProvBaru = $_POST['namaProvBaru'];
    $fields[] = "namaProv = ?";
    $values[] = $namaProvBaru;
    $types .= 's';

    $values[] = $namaProv;
    $types .= 's';

    $sql = "UPDATE $table SET " . implode(', ', $fields) . " WHERE namaProv = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param($types, ...$values);

    if ($stmt->execute()) {
        echo "<script>alert('Data berhasil diperbarui.');</script>";
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

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.css">
    <link rel="stylesheet" href="assets/css/splide.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;1,100&display=swap" rel="stylesheet">
    <title>Edit Data</title>
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
        <h2>Edit Data</h2>
        <form action="" method="post" enctype="multipart/form-data">
            <div>
                <label for="namaProvBaru">Nama Provinsi Baru:</label>
                <input type="text" id="namaProvBaru" name="namaProvBaru" value="<?php echo htmlspecialchars($data['namaProv']); ?>">
            </div>
            <?php foreach ($data as $column => $value): ?>
                <?php if ($column != 'namaProv'): ?>
                    <div>
                        <label for="<?php echo $column; ?>"><?php echo ucfirst($column); ?>:</label>
                        <?php if (strpos($column, 'IMG') !== false): ?>
                            <input type="file" name="gambar" id="<?php echo $column; ?>">
                        <?php else: ?>
                            <input type="text" id="<?php echo $column; ?>" name="<?php echo $column; ?>" value="<?php echo htmlspecialchars($value); ?>">
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
            <input type="submit" value="Perbarui Data" name="submit">
        </form>
    </div>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <?php include('footer.php'); ?>
</body>
</html>
