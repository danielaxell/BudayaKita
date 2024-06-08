<?php

require_once 'C:\xampp\htdocs\BudayaKita\pages\Login BudayaKita\connectionLogin.php';
session_start();
$fethUsername = null;
$userLevel = null;

if (isset($_SESSION['id'])) {
    $session = $_SESSION['id'];
    $fethUsername = LoginLogout::userName($session);
    if ($fethUsername) {
        $userLevel = $fethUsername['level'];
    } else {
        // Jika pengguna tidak ditemukan, hapus sesi
        session_unset();
        session_destroy();
    }
}
?>

<nav class="navbar navbar-expand-lg navbar-light fixed-top bg-navbar-black">
    <img src="assets/img/logobudaya.png" height="60px">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
        <ul class="navbar-nav mx-auto">
            <?php if ($userLevel == 1): ?>
                <li class="nav-item">
                    <a class="nav-link scroll-trigger text-white" href="admin.php">Admin Pages</a>
                </li>
            <?php else: // User or not logged in ?>
                <li class="nav-item">
                    <a class="nav-link scroll-trigger text-white" href="index.php">Beranda</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-white" href="#" id="navbarDropdownBudaya" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Budaya
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownBudaya">
                        <a class="dropdown-item" href="lestaribudaya.php">Lestari Budaya</a>
                        <a class="dropdown-item" href="events.php">Event</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-white" href="#" id="navbarDropdownProvinsi" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Provinsi
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownProvinsi">
                        <a class="dropdown-item" href="Provinsi.php">Provinsi</a>
                        <a class="dropdown-item" href="SenjataAdat.php">Senjata Adat</a>
                        <a class="dropdown-item" href="TarianAdat.php">Tarian Adat</a>
                        <a class="dropdown-item" href="AlatMusikAdat.php">Alat Musik Adat</a>
                        <a class="dropdown-item" href="PakaianAdat.php">Pakaian Adat</a>
                        <a class="dropdown-item" href="RumahAdat.php">Rumah Adat</a>
                        <a class="dropdown-item" href="KulinerKhas.php">Kuliner</a>
                        <a class="dropdown-item" href="Destinasi.php">Destinasi</a>
                    </div>
                </li>
            <?php endif; ?>
        </ul>
        <?php if (!$fethUsername): ?>
            <a href="Login BudayaKita/Register.php">
                <button class="btn btn-warning">Daftar</button>
            </a>
        <?php else: ?>
            <div class="nav-item dropdown">
                <a class="btn btn-warning dropdown-toggle" href="#" role="button" id="navbarDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <?php echo $fethUsername['username']; ?>
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="profile.php">Profil</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="Login BudayaKita/logout.php">Logout</a>
                </div>
            </div>
        <?php endif; ?>
    </div>
</nav>
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
