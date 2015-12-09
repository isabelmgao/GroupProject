<?php
require_once "pdo.php";
session_start();

if ( ! isset($_SESSION['name']) ) {
    die("ACCESS DENIED");
}

if(isset($_POST['cancel'])){
  header( 'Location: members.php' ) ;
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
<?php
  include 'header.php';
 ?>
  <h1>Deleteing Profile</h1>
  <form method="post" action="delete.php">
<?php
  echo'<label class="delete">Are you sure you want to delete:<br>';
  echo('<p class="delete-name">'.htmlentities($row['first_name']).' &nbsp'.htmlentities($row['last_name']).'</p>');
  // echo'</label> <label class="delete">Last name: &nbsp';
  // echo(htmlentities($row['last_name']));
  echo'</label>';
?>
  <input type="hidden" name="profile_id" value=<?=$row['profile_id']?>
  />
  <input type="submit" name="delete" value="Delete">
  <input type="submit" name="cancel" value="Cancel">
</form>
<?php
  include 'footer.php'
 ?>
</body>
</html>
