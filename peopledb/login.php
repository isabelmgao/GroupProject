<?php
require_once "pdo.php";
session_start();
unset($_SESSION['name']);
unset($_SESSION['user_id']);
$salt = 'XyZzy12*_';
$error = false;

if ( isset($_POST['email']) && isset($_POST['pass'])) {
    if ( strlen($_POST['email']) < 1 || strlen($_POST['pass']) < 1) {
    $_SESSION['error'] = "Email and password are required";
    header("Location: index.php");
    exit();
  }else{
    $check = hash('md5', $salt.$_POST['pass']);
    $stmt = $pdo->prepare('SELECT user_id, name FROM users
    WHERE email = :em AND password = :pw');
    $stmt->execute(array( ':em' => $_POST['email'], ':pw' => $check));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
      if ( $row !== false ) {
        $_SESSION['name'] = $row['name'];
        $_SESSION['user_id'] = $row['user_id'];
        header("Location: add.php");
        exit();
      }else{
      $_SESSION['error'] = "Incorrect Password";
      header("Location: index.php");
      exit();
    }
  }
}


if ( isset($_SESSION['error']) ) {
  echo('<p style="color: red;">'.htmlentities($_SESSION['error'])."</p>\n");
  unset($_SESSION['error']);
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Login Page</title>
</head>
<!--
Password: name of program + acronym (all lowercase)
Name: Administrator // Sunny // Xiaojie //Isabel // Pei-Yao
Email: misc@gmail.com // syschoi@umich.edu // liuxj@umich.edu // imgao@umich.edu //peiyaoh@umich.edu
-->
<body style="font-family: sans-serif;">
<h1>Please Log In</h1>
<form method="POST" action="index.php">
<label for="email">Email</label>
<input type="text" name="email" id="email"><br/>
<label for="id_1723">Password</label>
<input type="text" name="pass" id="id_1723"><br/>
<input type="submit" value="Log In">
</form>
</body>
