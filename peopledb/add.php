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
if(isset($_POST['cancel'])){
  header( 'Location: index.php' ) ;
  return;
}
if (isset($_POST['first_name']) && isset($_POST['last_name']) &&
    isset($_POST['email']) && isset($_POST['headline']) &&
    isset($_POST['summary'])){
if ( strlen($_POST['first_name'])<1 || strlen($_POST['last_name'])<1 || strlen($_POST['email'])<1
    || strlen($_POST['headline'])<1 || strlen($_POST['summary'])<1) {
      $_SESSION['error'] = "All fields are required";
      header("Location: add.php");
      return;
    }
  $stmt = $pdo->prepare('INSERT INTO Profile
        (user_id, first_name, last_name, email, headline, summary) VALUES ( :uid, :fn, :ln, :email, :hl, :sum)');
    $stmt->execute(array(
        ':uid' => $_SESSION['user_id'],
        ':fn' => $_POST['first_name'],
        ':ln' => $_POST['last_name'],
        ':email' => $_POST['email'],
        ':hl' => $_POST['headline'],
        ':sum' => $_POST['summary'])
    );
    $_SESSION['success']="Record added";
    header("Location: index.php");
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
<p>Email:
<input type="text" name="email" size="30"/></p>
<p>Headline:<br/>
<input type="text" name="website" size="80"/></p>
<p>Summary:<br/>
<textarea name="summary" rows="8" cols="80">
</textarea>
<p>
<input type="submit" value="Add">
<input type="submit" name="cancel" value="Cancel">
</p>
</form>
</body>
</html>
