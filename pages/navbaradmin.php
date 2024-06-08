<?php
session_start();
require_once 'C:\xampp\htdocs\BudayaKita\pages\Login BudayaKita\connectionLogin.php';

// Periksa apakah pengguna sudah login
if (isset($_SESSION['id'])) {
    $session = $_SESSION['id'];

    // Ambil informasi pengguna dari database berdasarkan ID sesi
    $userData = LoginLogout::userData($session);
    // Pastikan data pengguna ditemukan
    if ($userData) {
        $username = $userData['username'];
        $userPict = $userData['userPict'];
    } else {
        // Redirect pengguna ke halaman login jika data pengguna tidak ditemukan
        header("Location: login.php");
        exit();
    }
}

// Function untuk menghapus data dari tabel

function deleteData($conn, $table, $identifier = null, $type = 'id') {
    if ($identifier !== null) {
        if ($type === 'id') {
            $query = $conn->prepare("DELETE FROM $table WHERE id = :identifier");
        } elseif ($type === 'namaProv') {
            $query = $conn->prepare("DELETE FROM $table WHERE namaProv = :identifier");
        }
        $query->bindParam(':identifier', $identifier);
        return $query->execute();
    }
    return false;
}


if (isset($_POST['delete']) && isset($_POST['table'])) {
    try {
        $conn = LoginLogout::connect();
        $tableName = $_POST['table'];
        $identifier = isset($_POST['namaProv']) ? $_POST['namaProv'] : (isset($_POST['id']) ? $_POST['id'] : null);
        $type = isset($_POST['namaProv']) ? 'namaProv' : 'id';

        // Special handling for 'events' table to delete associated comments and likes
        if ($tableName == 'events' && $identifier !== null) {
            // First, delete likes associated with the event
            $deleteLikesQuery = $conn->prepare("DELETE FROM event_likes WHERE event_id = :event_id");
            $deleteLikesQuery->bindParam(':event_id', $identifier);
            $deleteLikesQuery->execute();

            // Then, delete comments associated with the event
            $deleteCommentsQuery = $conn->prepare("DELETE FROM event_comments WHERE event_id = :event_id");
            $deleteCommentsQuery->bindParam(':event_id', $identifier);
            $deleteCommentsQuery->execute();

            // Finally, delete the event itself
            if (deleteData($conn, $tableName, $identifier, $type)) {
                echo "<script>alert('Record deleted successfully.');</script>";
            } else {
                echo "<script>alert('Error deleting record.');</script>";
            }
        } else {
            // Handle deletion for other tables
            if (deleteData($conn, $tableName, $identifier, $type)) {
                echo "<script>alert('Record deleted successfully.');</script>";
            } else {
                echo "<script>alert('Error deleting record.');</script>";
            }
        }
    } catch (Exception $e) {
        echo "<script>alert('Exception: " . $e->getMessage() . "');</script>";
    }
}



    // Finally, delete the event itself
    


// Function untuk mengambil data menggunakan PDO
function fetchData($conn, $table, $imageColumn) {
    $query = $conn->prepare("SELECT * FROM $table");
    $query->execute();
    return $query->fetchAll(PDO::FETCH_ASSOC);
}

// Function untuk menyimpan atau memperbarui data
function saveOrUpdateData($conn, $table, $data, $isUpdate = false) {
    if ($isUpdate) {
        // Generate SQL untuk update
        $setClause = [];
        foreach ($data as $column => $value) {
            $setClause[] = "$column = :$column";
        }
        $queryStr = "UPDATE $table SET " . implode(', ', $setClause) . " WHERE id = :id";
    } else {
        // Generate SQL untuk insert
        $columns = array_keys($data);
        $placeholders = array_map(function($col) { return ":$col"; }, $columns);
        $queryStr = "INSERT INTO $table (" . implode(', ', $columns) . ") VALUES (" . implode(', ', $placeholders) . ")";
    }

    $query = $conn->prepare($queryStr);
    foreach ($data as $column => &$value) {
        $query->bindParam(":$column", $value);
    }

    return $query->execute();
}

// Menyimpan atau memperbarui data dari form
if (isset($_POST['action']) && isset($_POST['table'])) {
    try {
        $conn = LoginLogout::connect();
        $table = $_POST['table'];
        $data = $_POST;
        unset($data['action']);
        unset($data['table']);

        $isUpdate = ($_POST['action'] == 'edit');
        if ($isUpdate) {
            $data['id'] = $_POST['id'];
        }

        if (saveOrUpdateData($conn, $table, $data, $isUpdate)) {
            echo "<script>alert('Record saved successfully.');</script>";
        } else {
            echo "<script>alert('Error saving record.');</script>";
        }
    } catch (Exception $e) {
        echo "<script>alert('Exception: " . $e->getMessage() . "');</script>";
    }
}

$conn = LoginLogout::connect();
$rumahAdat = fetchData($conn, 'rumahadat', 'RumahIMG');
$tarianAdat = fetchData($conn, 'tarianadat', 'TarianIMG');
$pakaianAdat = fetchData($conn, 'pakaianadat', 'PakaianIMG');
$alatMusikAdat = fetchData($conn, 'alatmusik', 'AtributIMG');
$senjataAdat = fetchData($conn, 'senjataadat', 'SenjataIMG');
$wisata = fetchData($conn, 'destinasi', 'DestinasiIMG');
$kuliner = fetchData($conn, 'kulineradat', 'KulinerIMG');
$event = fetchData($conn, 'events', 'eventIMG');
$eventcomment = fetchData($conn, 'event_comments', 'eventIMG');
$user = fetchData($conn, 'loginn', 'userPict');

$tableData = [
    'rumahadat' => $rumahAdat,
    'tarianadat' => $tarianAdat,
    'pakaianadat' => $pakaianAdat,
    'alatmusik' => $alatMusikAdat,
    'senjataadat' => $senjataAdat,
    'destinasi' => $wisata,
    'kulineradat' => $kuliner,
    'events' => $event,
    'event_comments' => $eventcomment,
    'user' => $user,
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        body {
            display: flex;
            height: 100vh;
        }
        #sidebar {
            width: 250px;
            background: #343a40;
            color: #fff;
            transition: all 0.3s;
            overflow-y: auto;
        }
        #sidebar .nav-link {
            color: #fff;
        }
        #sidebar .nav-link:hover {
            background: #495057;
        }
        #content {
            flex-grow: 1;
            padding: 20px;
            overflow-y: auto;
        }
        .navbar-top {
            background: #343a40;
            color: #fff;
        }
        .navbar-top .navbar-brand {
            color: #fff;
        }
        .table-container {
            display: none;
        }
        .table-container.active {
            display: block;
        }
        .container-centered {
            max-width: 1000px;
            margin: 0 auto;
        }
        .floating-button {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 1000;
        }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <nav id="sidebar" class="bg-dark">
        <div class="sidebar-header text-center py-4">
            <h4>Admin Panel</h4>
        </div>
        <ul class="nav flex-column">
            <?php foreach ($tableData as $tableName => $rows): ?>
                <li class="nav-item">
                    <a class="nav-link" href="#" onclick="showTable('<?php echo $tableName; ?>')"><i class="fas fa-table"></i> <?php echo ucfirst($tableName); ?></a>
                </li>
            <?php endforeach; ?>
        </ul>
    </nav>

    <!-- Content -->
    <div id="content">
        <!-- Top Navbar -->
        <nav class="navbar navbar-expand-lg navbar-top fixed-top">
            <div class="container-fluid">
                <button type="button" id="sidebarCollapse" class="btn btn-dark">
                    <i class="fas fa-align-left"></i>
                </button>
                <a class="navbar-brand" href="#">Admin Dashboard</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="#" data-toggle="modal" data-target="#profileModal"><i class="fas fa-user"></i> Profile</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="Login Budayakita/logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <div class="container mt-5 pt-4 container-centered">
            <h2>Select a table from the sidebar to manage its data.</h2>

            <?php foreach ($tableData as $tableName => $rows): ?>
                <div id="table-<?php echo $tableName; ?>" class="table-container">
                    <h3><?php echo ucfirst($tableName); ?></h3>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <?php foreach ($rows[0] as $columnName => $value): ?>
                                    <th><?php echo $columnName; ?></th>
                                <?php endforeach; ?>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($rows as $row): ?>
                                <tr>
                                    <?php foreach ($row as $key => $cell): ?>
                                        <?php if (strpos($key, 'IMG') !== false || strpos($key, 'userPict') !== false): ?>
                                            <td><img src="data:image/jpeg;base64,<?php echo base64_encode($cell); ?>" alt="Image" style="width: 50px; height: 50px;"></td>
                                        <?php else: ?>
                                            <td><?php echo htmlspecialchars($cell); ?></td>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                    <td>
                                        <button class="btn btn-primary btn-sm" onclick="openModal('edit', '<?php echo $tableName; ?>', <?php echo htmlspecialchars(json_encode($row)); ?>)">Edit</button>
                                        <form method="POST" style="display:inline;">
                                            <input type="hidden" name="table" value="<?php echo $tableName; ?>">
                                            <?php if (isset($row['id'])): ?>
                                                <input type="hidden" name="id" value="<?php echo htmlspecialchars($row['id']); ?>">
                                            <?php else: ?>
                                                <input type="hidden" name="namaProv" value="<?php echo htmlspecialchars($row['namaProv']); ?>">
                                            <?php endif; ?>
                                            <button type="submit" name="delete" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this record?');">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <button class="btn btn-success btn-sm" onclick="openModal('add', '<?php echo $tableName; ?>')">Add New</button>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Modal untuk Edit/Add Data -->
    <div class="modal fade" id="dataModal" tabindex="-1" aria-labelledby="dataModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="dataModalLabel">Edit Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="dataForm" method="POST" enctype="multipart/form-data">
                        <input type="hidden" id="formAction" name="action" value="">
                        <input type="hidden" id="formTable" name="table" value="">
                        <input type="hidden" id="formId" name="id" value="">
                        <div id="formFields"></div>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal untuk Profil -->
    <div class="modal fade" id="profileModal" tabindex="-1" aria-labelledby="profileModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="profileModalLabel">Profile</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    <img src="data:image/jpeg;base64,<?php echo base64_encode($userPict); ?>" alt="Profile Picture" class="img-fluid rounded-circle mb-3" style="width: 150px; height: 150px;">
                    <h4><?php echo htmlspecialchars($username); ?></h4>
                    <button class="btn btn-primary">Edit Profile</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Floating Button -->
    <div class="floating-button">
        <button class="btn btn-primary btn-lg" onclick="openModal('add', getCurrentTable())">
            <i class="fas fa-plus"></i>
        </button>
    </div>


    <!-- jQuery dan Bootstrap Bundle (termasuk Popper) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        let currentTable = '';

        function showTable(tableName) {
            document.querySelectorAll('.table-container').forEach(function (tableContainer) {
                tableContainer.classList.remove('active');
            });
            document.getElementById('table-' + tableName).classList.add('active');
            currentTable = tableName;
        }

        function getCurrentTable() {
            return currentTable;
        }

        $(document).ready(function () {
            $('#sidebarCollapse').on('click', function () {
                $('#sidebar').toggleClass('active');
            });
        });

        function openModal(action, table, row = null) {
            $('#formAction').val(action);
            $('#formTable').val(table);
            $('#formId').val(row ? row.id : ''); // Set id value for update operation

            $('#formFields').empty();

            let fields = '';
            if (action === 'edit' && row) {
                Object.keys(row).forEach(key => {
                    if (key.includes('IMG')) {
                        fields += `<div class="form-group">
                                    <label for="${key}">${key}</label>
                                    <input type="file" class="form-control" id="${key}" name="${key}">
                                </div>`;
                    } else {
                        fields += `<div class="form-group">
                                    <label for="${key}">${key}</label>
                                    <input type="text" class="form-control" id="${key}" name="${key}" value="${row[key]}">
                                </div>`;
                    }
                });
            } else {
                <?php foreach ($tableData as $tableName => $rows): ?>
                    if (table === '<?php echo $tableName; ?>') {
                        <?php foreach ($rows[0] as $columnName => $value): ?>
                            if ('<?php echo
                                $columnName; ?>'.includes('IMG')) {
                                    fields += `<div class="form-group">
                                        <label for="<?php echo $columnName; ?>"><?php echo $columnName; ?></label>
                                        <input type="file" class="form-control" id="<?php echo $columnName; ?>" name="<?php echo $columnName; ?>">
                                    </div>`;
                                } else {
                                    fields += `<div class="form-group">
                                        <label for="<?php echo $columnName; ?>"><?php echo $columnName; ?></label>
                                        <input type="text" class="form-control" id="<?php echo $columnName; ?>" name="<?php echo $columnName; ?>">
                                    </div>`;
                                }
                            <?php endforeach; ?>
                        }
                    <?php endforeach; ?>
                }
    
                $('#formFields').html(fields);
                $('#dataModal').modal('show');
            }
    
            function scrollToTop() {
                window.scrollTo({ top: 0, behavior: 'smooth' });
            }
        </script>
    </body>
    </html>