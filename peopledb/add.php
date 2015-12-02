<?php
require_once "pdo.php";
session_start();

if ( ! isset($_SESSION['name']) ) {
    die("ACCESS DENIED");
}
if ( isset($_SESSION['error']) ) {
  echo('<p style="color: red;">'.htmlentities($_SESSION['error'])."</p>\n");
  unset($_SESSION['error']);
}
if ( isset($_SESSION['success']) ) {
  echo('<p style="color: green;">'.htmlentities($_SESSION['success'])."</p>\n");
  unset($_SESSION['success']);
}
if(isset($_POST['cancel'])){
  header( 'Location: index.php' ) ;
  return;
}
if (isset($_POST['first_name']) && isset($_POST['last_name']) &&
    isset($_POST['department'])){
if ( strlen($_POST['first_name'])<1 || strlen($_POST['last_name'])<1 ||
     strlen($_POST['department'])<1) {
      $_SESSION['error'] = "All fields are required";
      header("Location: add.php");
      return;
    }
  $stmt = $pdo->prepare('INSERT INTO Profile
        (user_id, first_name, last_name, department) VALUES ( :uid, :fn, :ln, :depar)');
    $stmt->execute(array(
        ':uid' => $_SESSION['user_id'],
        ':fn' => $_POST['first_name'],
        ':ln' => $_POST['last_name'],
        ':depar' => $_POST['department'])
    );
    $_SESSION['success']="Record added";
    header("Location: add.php");
    return;

}
 ?>

<!DOCTYPE html>
<html>
<head>
<title><?php echo($_SESSION['name'])?>'s Profile Add</title>
</head>
<body style="font-family: sans-serif;">
<h1>Add a member</h1>
<form method="post">
<p>First Name:
<input type="text" name="first_name" size="60"/></p>
<p>Last Name:
<input type="text" name="last_name" size="60"/></p>
<p>Department:<br/>
<input type="text" name="department" size="80"/></p>
<!-- </form> -->
<!-- Upload photo -->
<!-- <form action="upload.php" method="post" enctype="multipart/form-data">
    Select image to upload (if applicable):
    <input type="file" name="fileToUpload" id="fileToUpload">
    <input type="submit" value="Upload Image" name="submit"> -->
<p>
<input type="submit" value="Add">
<input type="submit" name="cancel" value="Cancel">
</p>
</form>
</body>
</html>
