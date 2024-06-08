<?php
require 'C:\xampp\htdocs\BudayaKita\pages\Login BudayaKita\connectionLogin.php';
session_start();
if (isset($_SESSION['id'])) {
    $session = $_SESSION['id'];
    $fethUsername = LoginLogout::userName($session);
    var_dump($fethUsername);
}

// Pastikan parameter GET 'namaProv' tersedia
if (!isset($_GET['namaProv']) || empty($_GET['namaProv'])) {
    die('Parameter "namaProv" tidak ditemukan.');
}

$provinsi = $_GET['namaProv'];

// Query to fetch provinsi details
$provinsiDetails = $conn->query("SELECT * FROM provinsi WHERE namaProv = '$provinsi'")->fetch_assoc();

if (!$provinsiDetails) {
    die('Detail provinsi tidak ditemukan.');
}

// Function to fetch data from a specific table
function fetchData($conn, $table, $provinsi, $column, $imageColumn, $deskripsiColumn)
{
    return $conn->query("SELECT $column, $imageColumn, $deskripsiColumn FROM $table WHERE namaProv = '$provinsi'")->fetch_assoc();
}

// Fetch data from each related table
$rumahAdat = fetchData($conn, 'rumahadat', $provinsi, 'Rumah', 'RumahIMG', 'DesRumahAdat');
$tarianAdat = fetchData($conn, 'tarianadat', $provinsi, 'Tarian', 'TarianIMG', 'DesTarianAdat');
$pakaianAdat = fetchData($conn, 'pakaianadat', $provinsi, 'Pakaian', 'PakaianIMG', 'DesPakaianAdat');
$alatMusikAdat = fetchData($conn, 'alatmusik', $provinsi, 'Atribut', 'AtributIMG', 'DesAlatMusik');
$senjataAdat = fetchData($conn, 'senjataadat', $provinsi, 'Senjata', 'SenjataIMG', 'DesSenjataAdat');
$wisata = fetchData($conn, 'destinasi', $provinsi, 'NamaDestinasi', 'DestinasiIMG', 'DesDestinasi');
$kuliner = fetchData($conn, 'kulineradat', $provinsi, 'Kuliner', 'KulinerIMG', 'DesKulinerAdat');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link rel="stylesheet" type="text/css" href="../assets/css/bootstrap.css" />
    <link rel="stylesheet" type="text/css" href="../assets/css/style.css" />
    <link href="../assets/img/logobudaya.png" rel="shortcut icon" />
    <title><?php echo $provinsiDetails['namaProv']; ?></title>
</head>

<body>
    <?php include ('navbar.php'); ?>
    <div class="container mt-5">
        <div class="row">
            <div class="col-lg-12">
                <div class="card mx-auto d-flex flex-column align-items-center justify-content-center p-4" style="width: 1100px; height: auto; border-radius: 10px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); margin-top: 100px;">
                    <img src="data:image/jpeg;base64,<?php echo base64_encode($provinsiDetails['ProvIMG']); ?>" class="card-img-top" alt="Logo Provinsi <?php echo htmlspecialchars($provinsiDetails['Provinsi']); ?>" style="width: 150px; height: 150px; border: 2px solid #000; padding: 5px;">
                    <h5 class="card-title" style="font-size: 30px; text-align: center; font-weight: bold;"><?php echo htmlspecialchars($provinsiDetails['Provinsi']); ?></h5>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered text-center" style="width: 800px;">
                                <tbody>
                                    <tr>
                                        <td style="font-weight: bold;"><strong>Ibukota</strong></td>
                                        <td style="font-weight: bold;"><?php echo $provinsiDetails['Ibukota']; ?></td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight: bold;"><strong>Bahasa</strong></td>
                                        <td style="font-weight: bold;"><?php echo $provinsiDetails['Bahasa']; ?></td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight: bold;"><strong>Suku</strong></td>
                                        <td style="font-weight: bold;"><?php echo $provinsiDetails['Suku']; ?></td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight: bold;"><strong>Rumah Adat</strong></td>
                                        <td style="font-weight: bold;">
                                            <?php if ($rumahAdat !== null): ?>
                                                <img src="data:image/jpeg;base64,<?php echo base64_encode($rumahAdat['RumahIMG']); ?>"
                                                    alt="<?php echo $rumahAdat['Rumah']; ?>" style="width: 400px; border: 2px solid #000;"
                                                    data-toggle="modal" data-target="#rumahAdatModal">
                                                <br>
                                                <h7 style="font-weight: bold;"><?php echo $rumahAdat['Rumah']; ?></h7>
                                                <!-- Modal -->
                                                <div class="modal fade" id="rumahAdatModal" tabindex="-1" aria-labelledby="rumahAdatModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="rumahAdatModalLabel">Deskripsi <?php echo $rumahAdat['Rumah']; ?></h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
    <img src="data:image/jpeg;base64,<?php echo base64_encode($rumahAdat['RumahIMG']); ?>" alt="<?php echo $rumahAdat['Rumah']; ?>" style="width: 400px; border: 2px solid #000;">
    <br><br>
    <p style="font-size: 14px; font-weight: normal;"><?php echo $rumahAdat['DesRumahAdat']; ?></p>


                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php else: ?>
                                                Data tidak ditemukan
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight: bold;"><strong>Tarian Adat</strong></td>
                                        <td style="font-weight: bold;">
                                            <?php if ($tarianAdat !== null): ?>
                                                <img src="data:image/jpeg;base64,<?php echo base64_encode($tarianAdat['TarianIMG']); ?>"
                                                    alt="<?php echo $tarianAdat['Tarian']; ?>" style="width: 400px; border: 2px solid #000;"
                                                    data-toggle="modal" data-target="#tarianAdatModal">
                                                <br>
                                                <h7 style="font-weight: bold;"><?php echo $tarianAdat['Tarian']; ?></h7>
                                                <!-- Modal -->
                                                <div class="modal fade" id="tarianAdatModal" tabindex="-1" aria-labelledby="tarianAdatModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="tarianAdatModalLabel">Deskripsi <?php echo $tarianAdat['Tarian']; ?></h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
    <img src="data:image/jpeg;base64,<?php echo base64_encode($tarianAdat['TarianIMG']); ?>" alt="<?php echo $tarianAdat['Tarian']; ?>" style="width: 400px; border: 2px solid #000;">
    <br><br>
    <p style="font-size: 14px; font-weight: normal;"><?php echo $tarianAdat['DesTarianAdat']; ?></p>
</div>

                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php else: ?>
                                                Data tidak ditemukan
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight: bold;"><strong>Pakaian Adat</strong></td>
                                        <td style="font-weight: bold;">
                                            <?php if ($pakaianAdat !== null): ?>
                                                <img src="data:image/jpeg;base64,<?php echo base64_encode($pakaianAdat['PakaianIMG']); ?>"
                                                    alt="<?php echo $pakaianAdat['Pakaian']; ?>" style="width: 400px; border: 2px solid #000;"
                                                    data-toggle="modal" data-target="#pakaianAdatModal">
                                                <br>
                                                <h7 style="font-weight: bold;"><?php echo $pakaianAdat['Pakaian']; ?></h7>
                                                <!-- Modal -->
                                                <div class="modal fade" id="pakaianAdatModal" tabindex="-1" aria-labelledby="pakaianAdatModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="pakaianAdatModalLabel">Deskripsi <?php echo $pakaianAdat['Pakaian']; ?></h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
    <img src="data:image/jpeg;base64,<?php echo base64_encode($pakaianAdat['PakaianIMG']); ?>" alt="<?php echo $pakaianAdat['Pakaian']; ?>" style="width: 400px; border: 2px solid #000;">
    <br><br>
    <p style="font-size: 14px; font-weight: normal;"><?php echo $pakaianAdat['DesPakaianAdat']; ?></p>
</div>

                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php else: ?>
                                                Data tidak ditemukan
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight: bold;"><strong>Alat Musik Adat</strong></td>
                                        <td style="font-weight: bold;">
                                            <?php if ($alatMusikAdat !== null): ?>
                                                <img src="data:image/jpeg;base64,<?php echo base64_encode($alatMusikAdat['AtributIMG']); ?>"
                                                    alt="<?php echo $alatMusikAdat['Atribut']; ?>" style="width: 400px; border: 2px solid #000;"
                                                    data-toggle="modal" data-target="#alatMusikAdatModal">
                                                <br>
                                                <h7 style="font-weight: bold;"><?php echo $alatMusikAdat['Atribut']; ?></h7>
                                                <!-- Modal -->
                                                <div class="modal fade" id="alatMusikAdatModal" tabindex="-1" aria-labelledby="alatMusikAdatModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="alatMusikAdatModalLabel">Deskripsi <?php echo $alatMusikAdat['Atribut']; ?></h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
    <img src="data:image/jpeg;base64,<?php echo base64_encode($alatMusikAdat['AtributIMG']); ?>" alt="<?php echo $alatMusikAdat['Atribut']; ?>" style="width: 400px; border: 2px solid #000;">
    <br><br>
    <p style="font-size: 14px; font-weight: normal;"><?php echo $alatMusikAdat['DesAlatMusik']; ?></p>
</div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php else: ?>
                                                Data tidak ditemukan
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight: bold;"><strong>Senjata Adat</strong></td>
                                        <td style="font-weight: bold;">
                                            <?php if ($senjataAdat !== null): ?>
                                                <img src="data:image/jpeg;base64,<?php echo base64_encode($senjataAdat['SenjataIMG']); ?>"
                                                    alt="<?php echo $senjataAdat['Senjata']; ?>" style="width: 400px; border: 2px solid #000;"
                                                    data-toggle="modal" data-target="#senjataAdatModal">
                                                <br>
                                                <h7 style="font-weight: bold;"><?php echo $senjataAdat['Senjata']; ?></h7>
                                                <!-- Modal -->
                                                <div class="modal fade" id="senjataAdatModal" tabindex="-1" aria-labelledby="senjataAdatModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="senjataAdatModalLabel">Deskripsi <?php echo $senjataAdat['Senjata']; ?></h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
    <img src="data:image/jpeg;base64,<?php echo base64_encode($senjataAdat['SenjataIMG']); ?>" alt="<?php echo $senjataAdat['Senjata']; ?>" style="width: 400px; border: 2px solid #000;">
    <br><br>
    <p style="font-size: 14px; font-weight: normal;"><?php echo $senjataAdat['DesSenjataAdat']; ?></p>
</div>

                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php else: ?>
                                                Data tidak ditemukan
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight: bold;"><strong>Wisata</strong></td>
                                        <td style="font-weight: bold;">
                                            <?php if ($wisata !== null): ?>
                                                <img src="data:image/jpeg;base64,<?php echo base64_encode($wisata['DestinasiIMG']); ?>"
                                                    alt="<?php echo $wisata['NamaDestinasi']; ?>" style="width: 400px; border: 2px solid #000;"
                                                    data-toggle="modal" data-target="#wisataModal">
                                                <br>
                                                <h7 style="font-weight: bold;"><?php echo $wisata['NamaDestinasi']; ?></h7>
                                                <!-- Modal -->
                                                <div class="modal fade" id="wisataModal" tabindex="-1" aria-labelledby="wisataModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="wisataModalLabel">Deskripsi <?php echo $wisata['NamaDestinasi']; ?></h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
    <img src="data:image/jpeg;base64,<?php echo base64_encode($wisata['DestinasiIMG']); ?>" alt="<?php echo $wisata['NamaDestinasi']; ?>" style="width: 400px; border: 2px solid #000;">
    <br><br>
    <p style="font-size: 14px; font-weight: normal;"><?php echo $wisata['DesDestinasi']; ?></p>
</div>

                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php else: ?>
                                                Data tidak ditemukan
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight: bold;"><strong>Kuliner</strong></td>
                                        <td style="font-weight: bold;">
                                            <?php if ($kuliner !== null): ?>
                                                <img src="data:image/jpeg;base64,<?php echo base64_encode($kuliner['KulinerIMG']); ?>"
                                                    alt="<?php echo $kuliner['Kuliner']; ?>" style="width: 400px; border: 2px solid #000;"
                                                    data-toggle="modal" data-target="#kulinerModal">
                                                <br>
                                                <h7 style="font-weight: bold;"><?php echo $kuliner['Kuliner']; ?></h7>
                                                <!-- Modal -->
                                                <div class="modal fade" id="kulinerModal" tabindex="-1" aria-labelledby="kulinerModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="kulinerModalLabel">Deskripsi <?php echo $kuliner['Kuliner']; ?></h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
    <img src="data:image/jpeg;base64,<?php echo base64_encode($kuliner['KulinerIMG']); ?>" alt="<?php echo $kuliner['Kuliner']; ?>" style="width: 400px; border: 2px solid #000;">
    <br><br>
    <p style="font-size: 14px; font-weight: normal;"><?php echo $kuliner['DesKulinerAdat']; ?></p>
</div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php else: ?>
                                                Data tidak ditemukan
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <!-- Tambahkan bagian lainnya di sini -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br><br>
    <?php include ('footer.php'); ?>
</body>
</html>
