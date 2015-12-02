<?php
require_once "pdo.php";
session_start();

$stmt = $pdo->prepare("SELECT * FROM Profile where profile_id = :xyz");
$stmt->execute(array(":xyz" => $_GET['id']));  //where is the get method receiving auto_id from? coming from id GET parameter sent from view.php
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if ( $row === false ) {
    $_SESSION['error'] = 'Bad value for profile_id';
    header( 'Location: index.php' ) ;
    return;
  }

$fn = htmlentities($row['first_name']);
$ln = htmlentities($row['last_name']);
$email = htmlentities($row['email']);
$hl = htmlentities($row['headline']);
$sm = htmlentities($row['summary']);
$profile_id = $row['profile_id'];
?>

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>MISC</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../static/img/iconthumb.jpg">
    <link rel="stylesheet" href="bootstrap-3.3.5-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/database.css">
</head>
<body>
  <div class="container">
     <div class="row">
        <div class="col-sm-3">
          <div class="panel panel-default">
            <div class="panel-heading">
              <h2 class="panel-title">Members</h2>
            </div>
            <div class="panel-body">
              <h3 class="panel-title">Faculty</h3>
              <h3 class="panel-title">Students</h3>
              <h3 class="panel-title">Alumni</h3>
            </div>
          </div>
        </div>

        <!-- vvvvvvvvvvvvvv-FACE OF THE ORG-vvvvvvvvvvvvvv -->
<?php
  $stmt = $pdo->query("SELECT first_name, last_name, headline FROM Profile");
  while ( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
    echo('<div class="col-sm-9">
      <div class="row">
        <div class="col-sm-3">
          <img class="img-rounded" src="img/left2.jpg">
          <p class="caption">'); echo(htmlentities($row['first_name'].$row['last_name']'</p>');
      echo(  '</div>');
    }
?>
</body>


<!-- <div class="col-sm-3">
  <img class="img-rounded" src="img/right.jpg">
</div>

<div class="col-sm-3">
  <img class="img-rounded" src="img/right1.jpg">
</div>
</div>
 <div class="row">
<div class="col-sm-3">
  <img class="img-rounded" src="img/left2.jpg">
</div>

<div class="col-sm-3">
  <img class="img-rounded" src="img/right.jpg">
</div>

<div class="col-sm-3">
  <img class="img-rounded" src="img/right1.jpg">
</div> -->
</html>
