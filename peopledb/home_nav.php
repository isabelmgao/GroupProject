<?php
require_once "pdo.php";
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<?php
include 'header.php';
?>

<body>

  <div class="loader"></div>

<div class="container-fluid text-center height-intro">
  <div class="row height-intro">
    <section id="left" class="col-xs-12 col-sm-12 col-md-6 col-lg-6 customclass height-intro">
      <a class="btn btn-default btn-lg btn-semi-transparent" href="add.php">Add a Member</a>
    </section>

    <section id="right" class="col-xs-12 col-sm-12 col-md-6 col-lg-6 customclass height-intro">
      <a class="btn btn-default btn-lg btn-semi-transparent" href="members.php">View Members</a>
    </section>
  </div>
</div>

  <?php
  include 'footer.php';
  ?>
</body>
<html>
