<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Music Player</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" integrity="sha512-HK5fgLBL+xu6dm/Ii3z4xhlSUyZgTT9tuc/hSrtw6uzJOvgRr2a9jyxxT1ely+B+xFAmJKVSTbpM/CuL7qxO8w==" crossorigin="anonymous" />
  <link rel="preconnect" href="https://fonts.gstatic.com" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet" />
  <link rel="icon" href="data:;base64,iVBORw0KGgo=">
  <link rel="stylesheet" href="./style.css" />
</head>

<?php
include "db_conn.php";
session_start();
$userID = $_SESSION['id'];
if ($userID == null) {
  header("Location: login_page.php?error=Please log in first");
} else {
  $sql = "SELECT * FROM audios WHERE user_id=$userID";
  $result = mysqli_query($conn, $sql);
}
?>

<body>

  <div class="player">
    <!-- Dashboard -->
    <div class="dashboard">
      <!-- Header -->
      <header>
        <h4>Now playing:</h4>
        <h2>No Music</h2>
      </header>

      <!-- <div class="btn btn-toggle-music-list">
        <i class="fas fa-list"></i>
      </div> -->
      <form action="logout.php" class="form-logout">
        <button>
          <i class="fa fa-reply"></i>
        </button>
      </form>
      <form action="upload_page.php" class="form-upload">
        <button>
          <i class="fas fa-upload"></i>
        </button>
      </form>

      <!-- CD -->
      <div class="cd">
        <div class="cd-thumb" style="
              background-image: url('');
            "></div>
      </div>

      <!-- Control -->
      <div class="control">
        <div class="btn btn-repeat">
          <i class="fas fa-redo"></i>
        </div>
        <div class="btn btn-prev">
          <i class="fas fa-step-backward"></i>
        </div>
        <div class="btn btn-toggle-play">
          <i class="fas fa-pause icon-pause"></i>
          <i class="fas fa-play icon-play"></i>
        </div>
        <div class="btn btn-next">
          <i class="fas fa-step-forward"></i>
        </div>
        <div class="btn btn-random">
          <i class="fas fa-random"></i>
        </div>
      </div>

      <input id="progress" class="progress" type="range" value="0" step="1" min="0" max="100" />

      <audio id="audio" src=""></audio>
    </div>

    <!-- Playlist -->
    <div class="playlist">

      <div class="song">
        <div class="thumb"></div>
        <div class="body">
          <h3 class="title">Upload Your Music</h3>
          <p class="author"></p>
        </div>
        <div class="option">
          <i class="fas fa-ellipsis-h"></i>
        </div>
      </div>
    </div>

  </div>

  <script src="./main.js"></script>
  <script>
    app.songs = [];
    <?php
    if (!empty($result)) {
      while ($row = mysqli_fetch_array($result)) {
    ?>
        app.songs.push({
          songId: <?= $row['id'] ?>,
          name: '<?= $row['name'] ?>',
          singer: '<?= $row['author_name'] ?>',
          path: './<?= $row['file_path'] ?>',
          image: './<?= $row['thumb'] ?>'
        });
    <?php
      }
    }
    ?>


    app.start();
  </script>
</body>

</html>