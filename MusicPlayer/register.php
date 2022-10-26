<?php 
session_start(); 
include "db_conn.php";

if(!isset($_POST['username'], ($_POST['password']), ($_POST['confirm-password']))) {
	header("Location: register_page.php?error=Fields are empty");
    exit();
}

if(empty($_POST['username'] || empty($_POST['password']) || empty($_POST['confirm-password']))) {
	header("Location: register_page.php?error=values are empty");
    exit();
}

if ($stmt = $conn->prepare('SELECT id, password FROM users WHERE user_name = ?')) {
    $stmt ->bind_param('s', $_POST['username']);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
	    header("Location: register_page.php?error=Username exists, please choose another!");
        exit();
    } else {
        if ($_POST['password'] === $_POST['confirm-password']) {
            if ($stmt = $conn->prepare('INSERT INTO users (user_name, password) VALUES (?, ?)')) {
                // $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
                $password = $_POST['password'];
                $stmt->bind_param('ss', $_POST['username'], $password);
                $stmt->execute();
                header("Location: login_page.php");
                exit();
            } else {
                echo 'Error occurred';
            }
        } else {
            header("Location: register_page.php?error=Password does not match!");
            exit();
        }
    } 
    
}