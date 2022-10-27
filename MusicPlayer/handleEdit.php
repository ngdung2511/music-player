<?php
$songId = $_POST['id'];
$songName = $_POST['my_audio'];
$author = $_POST['author'];   
include 'db_conn.php';
$sql = "UPDATE audios SET name = '$songName', author_name = '$author' WHERE id=$songId";
$result = mysqli_query($conn, $sql);

if ($result) {
    header("location: player.php");
}   
