<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once 'C:\xampp\htdocs\BudayaKita\pages\Login BudayaKita\connectionLogin.php';

// Mengambil data event dari database
$query = "SELECT * FROM events";
$result = mysqli_query($conn, $query);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_SESSION['id'])) {
        $event_id = $_POST['event_id'];
        $user_id = $_SESSION['id'];

        if (isset($_POST['comment'])) {
            $comment = $_POST['comment'];
            $query = "INSERT INTO event_comments (event_id, user_id, comment) VALUES ($event_id, $user_id, '$comment')";
            mysqli_query($conn, $query);
        }

        if (isset($_POST['like']) || isset($_POST['dislike'])) {
            $type = isset($_POST['like']) ? 'like' : 'dislike';
            $existingReaction = LoginLogout::hasLikedOrDisliked($event_id, $user_id);

            if ($existingReaction) {
                if ($existingReaction['type'] == $type) {
                    // If the user clicks the same button (like/dislike), remove their reaction
                    $query = "DELETE FROM event_likes WHERE event_id = $event_id AND user_id = $user_id";
                } else {
                    // If the user changes their reaction (like <-> dislike), update it
                    $query = "UPDATE event_likes SET type = '$type' WHERE event_id = $event_id AND user_id = $user_id";
                }
            } else {
                // If the user has no previous reaction, insert a new one
                $query = "INSERT INTO event_likes (event_id, user_id, type) VALUES ($event_id, $user_id, '$type')";
            }
            mysqli_query($conn, $query);
        }

        if (isset($_POST['new_post_caption']) && isset($_POST['new_post_description']) && isset($_FILES['new_post_photo'])) {
            $caption = $_POST['new_post_caption'];
            $description = $_POST['new_post_description'];
            $photo = addslashes(file_get_contents($_FILES['new_post_photo']['tmp_name']));
            $query = "INSERT INTO events (caption, deskripsi, eventIMG) VALUES ('$caption', '$description', '$photo')";
            mysqli_query($conn, $query);
        }
    } else {
        echo "<script>alert('You must be logged in to like, dislike, or comment.');</script>";
    }
}
?>
 <style>
        .modal {
            height: 100vh !important;
        }

        .modal-dialog {
            max-width: 80% !important; /* Increase the width of the modal */
        }

        .modal-body p {
            font-size: 14px !important; /* Decrease the font size */
        }

        .show-option {
            font-size: 12px;
        }

        .floating-button {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 50%;
            width: 60px;
            height: 60px;
            font-size: 24px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
            z-index: 1000;
        }

        .floating-button:hover {
            background-color: #0056b3;
        }

        .card-img-top {
            width: 100%;
            height: 300px;
            object-fit: cover;
        }

        .card-text {
            font-weight: bold;
        }
    </style>

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
    <title>Event</title>

    <style>
        .modal {
            height: 100vh !important;
        }

        .show-option {
            font-size: 12px;
        }

        .floating-button {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 50%;
            width: 60px;
            height: 60px;
            font-size: 24px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
            z-index: 1000;
        }

        .floating-button:hover {
            background-color: #0056b3;
        }

        .card-img-top {
            width: 100%;
            height: 300px;
            object-fit: cover;
        }

        .card-text {
            font-weight: bold;
        }
    </style>
</head>
<body>
<script>
        function checkLogin(action) {
            <?php if (!isset($_SESSION['id'])): ?>
            alert('You must be logged in to ' + action + '.');
            return false;
            <?php else: ?>
            return true;
            <?php endif; ?>
        }
</script>
<?php include('navbar.php'); ?>

<div class="image-header" style="background-image: url(img/festival.jpg)">
    <div class="tirai"></div>
    <div class="carousel-caption d-none d-md-block mb-5">
        <h1>EVENT</h1>
    </div>
</div>

<div class="container mt-5">
    <div class="row">
    <?php while($row = mysqli_fetch_assoc($result)): ?>
    <div class="col-md-12 mb-4">
        <div class="card">
            <div class="card-body">
                <p class="card-text"><?php echo htmlspecialchars($row['caption'], ENT_QUOTES); ?></p>
                <img src="data:image/jpeg;base64,<?php echo base64_encode($row['eventIMG']); ?>" class="card-img-top" alt="Event Photo" data-toggle="modal" data-target="#imgModal<?php echo $row['id']; ?>" data-caption="<?php echo htmlspecialchars($row['caption'], ENT_QUOTES); ?>" data-description="<?php echo htmlspecialchars(nl2br($row['deskripsi']), ENT_QUOTES); ?>">
                <form method="post" action="" onsubmit="return checkLogin('like or dislike');" class="mt-3">
                    <input type="hidden" name="event_id" value="<?php echo $row['id']; ?>">
                    <button type="submit" name="like" class="btn btn-success">Like (<?php echo LoginLogout::getLikes($row['id']); ?>)</button>
                    <button type="submit" name="dislike" class="btn btn-danger">Dislike (<?php echo LoginLogout::getDislikes($row['id']); ?>)</button>
                </form>
                <div class="mt-3">
                    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#commentModal<?php echo $row['id']; ?>">Lihat Komentar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Image -->
    <div class="modal fade" id="imgModal<?php echo $row['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="imgModalLabel<?php echo $row['id']; ?>" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="imgModalLabel<?php echo $row['id']; ?>">Event Photo</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <img src="data:image/jpeg;base64,<?php echo base64_encode($row['eventIMG']); ?>" class="card-img-top" alt="Event Photo">
                        <p><?php echo htmlspecialchars($row['deskripsi'], ENT_QUOTES); ?></p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Comments -->
    <div class="modal fade" id="commentModal<?php echo $row['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="commentModalLabel<?php echo $row['id']; ?>" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="commentModalLabel<?php echo $row['id']; ?>">Comments</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <?php
                        $comments = LoginLogout::getComments($row['id']);
                        while ($commentRow = mysqli_fetch_assoc($comments)): 
                            $userId = $commentRow['user_id'];
                            $usernameQuery = "SELECT username FROM loginn WHERE id = $userId";
                            $usernameResult = mysqli_query($conn, $usernameQuery);
                            $usernameRow = mysqli_fetch_assoc($usernameResult);
                        ?>
                        <p style="font-size: 14px;"><strong><?php echo htmlspecialchars($usernameRow['username'], ENT_QUOTES); ?>:</strong> <?php echo htmlspecialchars($commentRow['comment'], ENT_QUOTES); ?></p>
                        <?php endwhile; ?>
                    </div>
                    <form method="post" action="" class="mt-3" onsubmit="return checkLogin('comment');">
                        <input type="hidden" name="event_id" value="<?php echo $row['id']; ?>">
                        <div class="form-group">
                            <textarea class="form-control" name="comment" rows="3" placeholder="Add a comment"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Post Comment</button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
<?php endwhile; ?>
    </div>
</div>

<!-- Floating Button -->
<button class="floating-button" data-toggle="modal" data-target="#newPostModal">+</button>

<!-- Modal for New Post -->
<div class="modal fade" id="newPostModal" tabindex="-1" role="dialog" aria-labelledby="newPostModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newPostModalLabel">Create New Post</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="" enctype="multipart/form-data" onsubmit="return checkLogin('create a new post');">
                    <div class="form-group">
                        <label for="newPostCaption">Caption</label>
                        <textarea class="form-control" id="newPostCaption" name="new_post_caption" rows="3" placeholder="Enter your caption"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="newPostDescription">Description</label>
                        <textarea class="form-control" id="newPostDescription" name="new_post_description" rows="3" placeholder="Enter the event description"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="newPostPhoto">Photo</label>
                        <input type="file" class="form-control-file" id="newPostPhoto" name="new_post_photo" accept="image/*">
                    </div>
                    <button type="submit" class="btn btn-primary">Post</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
<?php include('footer.php'); ?>

<script>
document.addEventListener("DOMContentLoaded", function() {
    let imgCardButtons = document.querySelectorAll(".card-img-top");

    imgCardButtons.forEach((button) => {
        button.addEventListener("click", function () {
            let modalId = button.getAttribute('data-target');
            let modalImage = document.querySelector(modalId + " .modal-body img");
            let modalCaption = document.querySelector(modalId + " .modal-body p");

            // Set the image source and description in the modal
            modalImage.src = button.src;
            modalCaption.innerHTML = button.getAttribute("data-description");
        });
    });
});
</script>
</body>
</html>
