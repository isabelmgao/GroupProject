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
<?php
  include 'header.php';
?>
<body>
  <div class="container">
     <!-- <div class="row"> -->
        <div class="col-sm-2 panel-height">
          <div class="panel panel-default">
            <div class="panel-heading">
              <h2 class="panel-title">Members</h2>
            </div>
            <div class="panel-body">
<?php
              echo'<h3 class="panel-title"><a href="people.php?id=faculty">Faculty</a></h3>';
              echo'<h3 class="panel-title"><a href="people.php?id=student">Students</a></h3>';
              echo'<h3 class="panel-title"><a href="people.php?id=alum">Staff</a></h3>';
?>
            </div>
          </div>
        </div>

        <!-- vvvvvvvvvvvvvv-FACE OF THE ORG-vvvvvvvvvvvvvv -->
    <div class="col-sm-10">
        <div class="row">

<?php
if(!isset($_GET['id'])){
$stmt = $pdo->query("SELECT first_name, last_name, department, website, filename, membership
                FROM Profile");
while ( $row = $stmt->fetch(PDO::FETCH_ASSOC) ){
    echo '<div class="col-sm-3">
            <img class="img-rounded" src="'.$row['filename'].'"/>
            <p class="caption">';
    echo '<a href="'.htmlentities($row['website']).'" target="_blank">'.$row['first_name'].' '.htmlentities($row['last_name']).'</a>';
    echo ', '.htmlentities($row['department']);
    echo '</p> </div>';
  }
}else{
    $stmt = $pdo->query("SELECT first_name, last_name, department, website, filename, membership
                    FROM Profile WHERE membership = :member");
    $stmt->execute(array(":member" => $_GET['id']));
    while ( $row = $stmt->fetch(PDO::FETCH_ASSOC) )
    {
        echo '<div class="col-sm-3">
                <img class="img-rounded" src="'.$row['filename'].'"/>
                <p class="caption">';
        echo '<a href="'.htmlentities($row['website']).'" target="_blank">'.$row['first_name'].' '.htmlentities($row['last_name']).'</a>';
        echo ', '.htmlentities($row['department']);
        echo '</p> </div>';
    }
  }
?>
      </div>
  </div>
<?php
include 'footer.php'
 ?>
</body>
</html>
