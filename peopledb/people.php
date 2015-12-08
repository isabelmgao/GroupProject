<?php
require_once "pdo.php";
session_start();

if ( ! isset($_SESSION['name']) ) {
    die("ACCESS DENIED");
}
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
<?php
              echo'<h3 class="panel-title"><a href="people.php?id=faculty">Faculty</a></h3>';
              echo'<h3 class="panel-title"><a href="people.php?id=students">Students</a></h3>';
              echo'<h3 class="panel-title"><a href="people.php?id=alumni">Staff</a></h3>';
?>
            </div>
          </div>
        </div>

        <!-- vvvvvvvvvvvvvv-FACE OF THE ORG-vvvvvvvvvvvvvv -->
    <div class="col-sm-9">
        <div class="row">

<?php
    $stmt = $pdo->query("SELECT first_name, last_name, department, website, filename, membership
                    FROM Profile");
    // $stmt->execute(array(":member" => $_GET['id']));
    while ( $row = $stmt->fetch(PDO::FETCH_ASSOC) )
    {
        echo '<div class="col-sm-3">
                <img class="img-rounded" src="'.$row['filename'].'"/>
                <p class="caption">';
        echo '<a href='.htmlentities($row['website']).'" target="_blank">'.$row['first_name'].' '.htmlentities($row['last_name']).'</a>';
        echo ', '.htmlentities($row['department']);
        echo '</p> </div>';
    }
?>
      </div>
  </div>
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
