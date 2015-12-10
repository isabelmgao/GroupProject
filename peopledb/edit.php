<?php
require_once "pdo.php";
session_start();
 // echo(htmlentities($_SESSION['name']))
 if ( ! isset($_SESSION['name']) ) {
     die("ACCESS DENIED");
 }
if(isset($_POST['cancel'])){
  header( 'Location: members.php' ) ;
  return;
}
if (isset($_POST['first_name']) && isset($_POST['last_name']) &&
    isset($_POST['department'])) {
  if ( strlen($_POST['first_name'])<1 || strlen($_POST['last_name'])<1 ||
    strlen($_POST['department'])<1) {
    $_SESSION['error'] = "All fields are required";
    header("Location: edit.php?id=" . $_POST["profile_id"]);
    return;
  }
  if($_POST['membership2']===0){
     $_SESSION['error'] = "Invalid member status. Please select from the drop down menu below";
     header("Location: edit.php?profile_id=" . $_REQUEST["profile_id"]);
     return;
  }
  $stmt = $pdo->prepare("SELECT filename FROM Profile WHERE profile_id = :xyz");
  $stmt->execute(array(":xyz" => $_GET['profile_id']));
  $row = $stmt->fetch(PDO::FETCH_ASSOC);
  $file = htmlentities($row['filename']);
    // Data validation
    // Do all that image upload.php
    $target_dir = "member_img/";
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
    if(empty($_FILES["fileToUpload"]["name"])){
      $target_file = $file;
    }else{
    // Check if image file is a actual image or fake image
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check === false) {
        $_SESSION['error']= "File is not an image.";
        header("Location: edit.php?id=" . $_POST["profile_id"]);
        return;
    }
    // Check file size
    if ($_FILES["fileToUpload"]["size"] > 5000000) {
        $_SESSION['error']="Sorry, your file is too large.";
        header("Location: edit.php?id=" . $_POST["profile_id"]);
        return;
    }
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file) === false) {
        $_SESSION['error']="Sorry, there was an error uploading your file.";
        header("Location: edit.php?id=" . $_POST["profile_id"]);
        return;
    }
  }
    $sql = "UPDATE Profile SET
            last_name = :ln, first_name = :fn, website= :website, membership = :member, department = :depar, filename = :file
            WHERE profile_id = :profile_id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(
        ':profile_id' => $_POST['profile_id'],
        ':fn' => $_POST['first_name'],
        ':ln' => $_POST['last_name'],
        ':website' => $_POST['website'],
        ':member' => $_POST['membership2'],
        ':depar' => $_POST['department'],
        ':file' => $target_file));
    $_SESSION['success'] = 'Record updated';
    header( 'Location: members.php' ) ;
    return;
}
$stmt = $pdo->prepare("SELECT * FROM Profile WHERE profile_id = :xyz");
$stmt->execute(array(":xyz" => $_GET['profile_id']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if ( $row === false ) {
    $_SESSION['error'] = 'Bad value for profile_id';
    header( 'Location: index.php' );
    return;
}
$fn = htmlentities($row['first_name']);
$ln = htmlentities($row['last_name']);
$website = htmlentities($row['website']);
$file = htmlentities($row['filename']);
$depar = htmlentities($row['department']);
$member = htmlentities($row['membership']);
$profile_id = $row['profile_id'];
?>


<!DOCTYPE html>
<html lang="en">
<title>MISC Member Edit</title>
<?php
  include 'header.php';
  if ( isset($_SESSION['error']) ) {
    echo('<p style="color: red;">'.htmlentities($_SESSION['error'])."</p>\n");
    unset($_SESSION['error']);
  }
?>
<body>

<h1>Editing MISC Member </h1>

<form method="post" enctype="multipart/form-data">
  <div class="margin-bottom">
    <label>First Name
      <input class="edit" type="text" name="first_name" size="60" value="<?= $fn ?>" required
      /></label>
    <label>Last Name
      <input class="edit" type="text" name="last_name" size="60" value="<?= $ln ?>" required
      /></label>
  </div>
  <div class="margin-bottom">
    <label>Department<br/>
      <input class="edit" type="text" name="department" size="80" value="<?= $depar ?>" required
      /></label>
    <label>Website
      <input class="edit" type="text" name="website" size="30" value="<?= $website ?>"
      /></label>
  </div>
  <div class="margin-bottom">
    <label>Current Membership Status<br/>
      <input class="edit" type="text" name="membership" size="80" value="<?= $member ?>"
      /></label>
    <label>Change Membership Status</label>
      <select name="membership2">
        <option value="0">Choose...</option>
        <option value="faculty">Faculty</option>
        <option value="0">______________</option>
        <option value="phd">PhD Student</option>
        <option value="masters">Master's Student</option>
        <option value="undergrad">Bachelor's Student</option>
        <option value="0">______________</option>
        <option value="alum">Alumnus</option>
      </select>
  </div>
  <div class="margin-bottom">
    <label id="current-photo">Current Photo<br/>
      <img class="img-rounded" src="<?= $file ?>"
      /></label>
    <label>Change Photo<br/>
      <input type="file" name="fileToUpload" id="fileToUpload"/>
    </label>
  </div>
<input type="hidden" name="profile_id" value="<?= $profile_id ?>"/>
<input type="submit" value="Save">
</p>
</form>

<form method="post">
  <input type="submit" name="cancel" value="Cancel">
</form>
<?php
include 'footer.php';
?>
</body>
