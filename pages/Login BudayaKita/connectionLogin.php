<?php
$hostname = "localhost";
$username = "root";
$password = "";
$database = "budayakita";
// Buat koneksi
$conn = mysqli_connect($hostname, $username, $password, $database);
// Periksa koneksi
// Memeriksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
class LoginLogout
{
    public static function connect()
    {
        try {
            $conn = new PDO("mysql:host=localhost;dbname=budayakita", "root", "");
            return $conn;
        } catch (PDOException $erro1) {
            echo $erro1->getMessage();
        } catch (Exception $erro2) {
            echo $erro2->getMessage();
        }
    }
    public static function inserting($username, $password)
    {
        $insert = LoginLogout::connect()->prepare("INSERT INTO loginn(username, password, level) VALUES(:u, :p, 2)");
        $insert->bindValue(':u', $username);
        $insert->bindValue(':p', $password);
        $insert->execute();
    }
    public static function getLikes($event_id)
    {
        global $conn;
        $query = "SELECT COUNT(*) AS count FROM event_likes WHERE event_id = $event_id AND type = 'like'";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($result);
        return $row['count'];
    }

    public static function getDislikes($event_id)
    {
        global $conn;
        $query = "SELECT COUNT(*) AS count FROM event_likes WHERE event_id = $event_id AND type = 'dislike'";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($result);
        return $row['count'];
    }

    public static function getComments($event_id)
    {
        global $conn;
        $query = "SELECT * FROM event_comments WHERE event_id = $event_id";
        return mysqli_query($conn, $query);
    }

    public static function hasLikedOrDisliked($event_id, $user_id)
    {
        global $conn;
        $query = "SELECT type FROM event_likes WHERE event_id = $event_id AND user_id = $user_id";
        $result = mysqli_query($conn, $query);
        return mysqli_fetch_assoc($result);
    }
    public static function login($username, $password)
    {
        $login = LoginLogout::connect()->prepare("SELECT id, level FROM loginn WHERE username=:u AND password=:p");
        $login->bindValue(':u', $username);
        $login->bindValue(':p', $password);
        $login->execute();
        if ($login->rowCount() > 0) {
            $fetch = $login->fetch(PDO::FETCH_ASSOC);
            session_start();
            $_SESSION['id'] = $fetch['id'];
            if ($fetch['level'] == 1) {
                header('Location: ../../pages/navbaradmin.php'); // Redirect ke halaman admin.php jika level adalah 1
            } elseif ($fetch['level'] == 2) {
                echo "<script>alert('Welcome To BudayaKita')</script>"; // Menampilkan pop-up notifikasi
                header('Location: ../../pages/index.php'); // Redirect ke halaman index.php jika level adalah 2
            }
        } else {
            $fetch = array();
            echo "<script>alert('Username or password incorrect')</script>"; // Menampilkan pop-up notifikasi
        }
        return $fetch;
    }

    public static function getUserByUsername($username)
    {
        $query = "SELECT * FROM loginn WHERE username = :username";
        $stmt = self::connect()->prepare($query);
        $stmt->bindValue(':username', $username);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function userName($sessionId) {
        // Implementasi fungsi untuk mendapatkan username berdasarkan session ID
        global $conn;
        $query = "SELECT username, level FROM loginn WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $sessionId);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
    // file connectionLogin.php
public static function userData($id)
{
    $session = LoginLogout::connect()->prepare("SELECT username, password, userPict FROM loginn WHERE id=:id");
    $session->bindValue(':id', $id);
    $session->execute();
    $fetch = $session->fetch(PDO::FETCH_ASSOC);
    return $fetch;
}
public static function profileUpdate($session, $newUsername, $newPassword, $newUserPict)
{
    // Ambil informasi gambar yang diunggah
    $namaFile = $_FILES['userPict']['name'];
    $lokasiSementara = $_FILES['userPict']['tmp_name'];

    // Membaca data gambar
    $gambar = addslashes(file_get_contents($lokasiSementara));

    $query = "UPDATE loginn SET username = :username, password = :password, userPict = :userPict WHERE id = :id";
    $statement = LoginLogout::connect()->prepare($query);
    $statement->bindValue(':username', $newUsername);
    $statement->bindValue(':password', $newPassword);
    $statement->bindValue(':userPict', $gambar); // Simpan gambar yang diunggah
    $statement->bindValue(':id', $session);

    // Lakukan update ke database
    $result = $statement->execute();

    return $result;
}

    public static function listofuser()
    {
        $query = "SELECT * FROM loginn";
        $stmt = LoginLogout::connect()->query($query);
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $users;
    }
    // Dalam file connectionLogin.php
    }

?>