<?php
require_once "pdo.php";
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<?php
include 'header.php';

if ( isset($_SESSION['error']) ) {
    echo('<p class="flash-error">'.htmlentities($_SESSION['error'])."</p>\n");
    unset($_SESSION['error']);
  }
if ( isset($_SESSION['success']) ) {
    echo('<img class="flash-success" src="img/checkbox.jpg"><p class="flash-success">'.htmlentities($_SESSION['success'])."</p>\n");
    unset($_SESSION['success']);
}
?>

<body>

<div class="container text-center">
  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
      <a class=" home-nav btn btn-default btn-lg btn-semi-transparent" href="add.php">Add a Member</a>
      <a class=" home-nav btn btn-default btn-lg btn-semi-transparent" href="members.php">View Members</a>
    </section>
  </div>

  <?php
  include 'footer.php';
  ?>
</body>
<html>
