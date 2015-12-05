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
?>
<!DOCTYPE html>
<html>
<head>

<title>MISC Member Registry</title>
</head>
<body style="font-family: sans-serif;">
<h1>Edit Members</h1>
<?php
if(!isset($_SESSION['name'])){
echo('<p><a href="login.php">Login</a></p>');
}else {
  echo('<p><a href="login.php">Logout</a></p>');
}
?>
<table border="1">
<tr><th>Name</th><th>Headline</th>
<?php
  if(isset($_SESSION['name'])){
    echo("<th>Action</th>");
  }
  echo("</tr>");

  // echo('<table border="1">'."\n");
$stmt = $pdo->query("SELECT * FROM Profile");
while ( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
    echo "<tr><td>";
    echo(htmlentities($row['first_name']));
    echo("&nbsp");
    echo(htmlentities($row['last_name']));
    echo("</td><td>");
    echo(htmlentities($row['membership']));
  if(isset($_SESSION['name'])){
    echo("</td><td>");
    echo('<a href="edit.php?profile_id='.$row['profile_id'].'">Edit</a> / ');
    echo('<a href="delete.php?profile_id='.$row['profile_id'].'">Delete</a>');
  }
    echo("</td></tr>\n");

}

?>
  </table>
<?php
  if(isset($_SESSION['name'])){
    echo('<a href="add.php">Add New</a>');
    }
?>
  </body>
</html>
