<?php 
session_start(); 
include "db_conn.php";
$uploaddirMusic = 'assets/music/';
$uploaddirThumb = 'assets/img/';
$uploadfileMusic = $uploaddirMusic . basename($_FILES['audioFile']['name']);
$uploadfileImg = $uploaddirThumb . basename($_FILES['audioThumb']['name']);
$uploadFileDataMusic = $_FILES['audioFile']['tmp_name'];
$uploadFileDataThumb = $_FILES['audioThumb']['tmp_name'];
$errorMusic = $_FILES['audioFile']['error'];
$errorThumb = $_FILES['audioThumb']['error'];
$userID = $_SESSION['id'];
if($userID == null) {
  header("Location: login_page.php?error=Please login before proceeding");
}
$songName = $_POST['my_audio'];
$author = $_POST['author'];   
if ($errorMusic == 0 && $uploadfileMusic != null) { 
    $audio_ex = pathinfo($uploadfileMusic, PATHINFO_EXTENSION);
    $audio_ex_lc = strtolower($audio_ex);

    $image_ex = pathinfo($uploadfileImg, PATHINFO_EXTENSION);
    $image_ex_lc = strtolower($image_ex);

    $allowed_exs_music = array("3gp", 'mp3', 'm4a', 'wav');
    $allowed_exs_image = array("jpg", 'png', 'jpeg');
    $msg = "";
    if (!in_array($audio_ex_lc, $allowed_exs_music)){
        $msg = "Invalid audio format!";
    }
    if (!in_array($image_ex_lc, $allowed_exs_image)){
        $msg = "Invalid image format!";
    }
    if ($msg == "") {
        if (!move_uploaded_file($uploadFileDataMusic, $uploadfileMusic)) {
            $msg = "Failed to save audio file!";
        }
        if($msg == ""){
            if(!move_uploaded_file($uploadFileDataThumb, $uploadfileImg)){
                $msg = "Failed to save thumbnail!";
            }
        }
        if($msg == ""){
            $sql = "INSERT INTO audios(user_id, name, author_name, file_path, thumb) VALUES($userID, '$songName', '$author', '$uploadfileMusic', '$uploadfileImg')";
            $result = mysqli_query($conn, $sql);
            header("Location: player.php");	
        }
        else 
            header("Location: upload_page.php?error=$msg");
    }else { 
        header("Location: upload_page.php?error=$msg");
    }		
} 
else 
    header("Location: upload_page.php?error=Please choose files");	