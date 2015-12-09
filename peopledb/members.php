<?php
require_once "pdo.php";
session_start();

if ( ! isset($_SESSION['name']) ) {
    die("ACCESS DENIED");
}

?>
<!DOCTYPE html>
<html>
<head>
<title>MISC Member Registry</title>
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
</head>
<body style="font-family: sans-serif;">
<h1>Edit Members</h1>
<?php
if(!isset($_SESSION['name'])){
echo('<p><a href="login.php">Login</a></p>');
}else {
  echo '<div class=text-center>';
  echo('<a class="btn btn-default btn-md btn-semi-transparent" href="login.php">Logout</a></p>');
  echo('<a class="btn btn-default btn-md btn-semi-transparent" href="add.php">Add member</a></p></div>');
}
?>
<div class="container-fluid">
    <div class="col-sm-12 col-md-12 col-lg-12">
      <table class="table table-bordered" border="1">
        <thead>
          <tr>
            <th>Name</th>
            <th>Membership Status</th>
            <th>Department</th>
<?php
  if(isset($_SESSION['name'])){
      echo("<th>Action</th>");
  }
    echo("</tr></thead>");

  // echo('<table border="1">'."\n");
$stmt = $pdo->query("SELECT * FROM Profile");
while ( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
    echo "<tr><td>";
    echo(htmlentities($row['first_name']));
    echo("&nbsp");
    echo(htmlentities($row['last_name']));
    echo("</td><td>");
    echo(htmlentities($row['membership']));
    echo("</td><td>");
    echo(htmlentities($row['department']));
  if(isset($_SESSION['name'])){
    echo("</td><td>");
    echo('<a href="edit.php?profile_id='.$row['profile_id'].'">Edit</a> / ');
    echo('<a href="delete.php?profile_id='.$row['profile_id'].'">Delete</a>');
  }
    echo("</td></tr>\n");

}

?>
      </table>
    </div>
  </div>
</div>
<?php
include 'footer.php';
?>
  if(isset($_SESSION['name'])){
    echo('<a href="add.php">Add New</a>');
    }
?>
  </body>
</html>
