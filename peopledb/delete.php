<?php
require_once "pdo.php";
session_start();

if ( ! isset($_SESSION['name']) ) {
    die("ACCESS DENIED");
}

if(isset($_POST['cancel'])){
  header( 'Location: index.php' ) ;
  return;
}

if ( isset($_POST['delete'])) {
    $sql = "DELETE FROM Profile WHERE profile_id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(':id' => $_POST['profile_id']));
    $_SESSION['success'] = 'Record deleted';
    header( 'Location: members.php' ) ;
    return;
}
//if profile_id is not valid, display error message
$stmt = $pdo->prepare("SELECT first_name, last_name, profile_id FROM Profile where profile_id = :xyz");
$stmt->execute(array(":xyz" => $_GET['profile_id']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if ( $row === false ) {
    $_SESSION['error'] = 'Bad value for profile_id';
    header( 'Location: members.php' ) ;
    return;
}

?>

<!DOCTYPE html>
<html>
<head>
<title>MISC Membmer Delete</title>
</head>
<body style="font-family: sans-serif;">
<h1>Deleteing Profile</h1>
<form method="post" action="delete.php">
<?php
echo("<p>First name: &nbsp");
echo(htmlentities($row['first_name']));
echo("</p>");
echo("<p>Last name: &nbsp");
echo(htmlentities($row['last_name']));
echo("</p>");
?>
<input type="hidden" name="profile_id" value=<?=$row['profile_id']?>
/>
<input type="submit" name="delete" value="Delete">
<input type="submit" name="cancel" value="Cancel">
</p>
</form>
</body>
</html>
