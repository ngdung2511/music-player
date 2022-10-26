<?php
    include 'db_conn.php';
    $songId=$_GET['id'];

    $sql="DELETE FROM audios WHERE id=$songId";
    $result=mysqli_query($conn, $sql);

    if($result){
        header("location: player.php");
    } else {
        echo "error";
    }

?>