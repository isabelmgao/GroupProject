<?php
require_once "pdo.php";
session_start();
 // echo(htmlentities($_SESSION['name']))
 if ( ! isset($_SESSION['name']) ) {
     die("ACCESS DENIED");
 }
 if ( isset($_SESSION['error']) ) {
   echo('<p style="color: red;">'.htmlentities($_SESSION['error'])."</p>\n");
   unset($_SESSION['error']);
 }

if(isset($_POST['cancel'])){
  header( 'Location: index.php' ) ;
  return;
}


if (isset($_POST['first_name']) && isset($_POST['last_name']) &&
    isset($_POST['department']) && isset($_POST['membership']) &&
    isset($_POST['website'])) {

  if ( strlen($_POST['first_name'])<1 || strlen($_POST['last_name'])<1 ||
    strlen($_POST['department'])<1) {
    $_SESSION['error'] = "All fields are required";
    header("Location: edit.php?id=" . $_POST["profile_id"]);
    return;
  }

  if($_POST['membership']===0){
     $_SESSION['error'] = "Invalid member status. Please select from the drop down menu below";
     header("Location: edit.php?profile_id=" . $_REQUEST["profile_id"]);
     return;
  }
    // Data validation
    // Do all that image upload.php
    $target_dir = "member_img/";
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

    if ( ! empty($_FILES["fileToUpload"]["name"])){
    // Check if image file is a actual image or fake image
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check === false) {
        $_SESSION['error']= "File is not an image.";
        header("Location: add.php");
        return;
    }

    // Check file size
    if ($_FILES["fileToUpload"]["size"] > 5000000) {
        $_SESSION['error']="Sorry, your file is too large.";
        header("Location: add.php");
        return;
    }

    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file) === false) {
        $_SESSION['error']="Sorry, there was an error uploading your file.";
        header("Location: add.php");
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
        ':member' => $_POST['membership'],
        ':depar' => $_POST['department'],
        ':file' => $target_file));
    $_SESSION['success'] = 'Record updated';
    header( 'Location: members.php' ) ;
    return;


}
$stmt = $pdo->prepare("SELECT * FROM Profile where profile_id = :xyz");
$stmt->execute(array(":xyz" => $_GET['profile_id']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if ( $row === false ) {
    $_SESSION['error'] = 'Bad value for profile_id';
    header( 'Location: member.php' ) ;
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
<head>
  <title>MISC Member Edit</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../static/img/iconthumb.jpg">
    <link rel="stylesheet" href="bootstrap-3.3.5-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/database.css">
</head>
<body style="font-family: sans-serif;">
<h1>Editing MISC Member </h1>

<form method="post" action="edit.php">
<p>First Name:
<input type="text" name="first_name" size="60" value="<?= $fn ?>"
/></p>
<p>Last Name:
<input type="text" name="last_name" size="60" value="<?= $ln ?>"
/></p>
<p>Department:<br/>
<input type="text" name="department" size="80" value="<?= $depar ?>"
/></p>
<p>Website:
<input type="text" name="website" size="30" value="<?= $website ?>"
/></p>
<p>Current Membership Status:<br/>
<input type="text" name="membership" size="80" value="<?= $member ?>"
/></p>
<p>Change Membership Status:</p>
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
<p>Current Photo:<br/>
<img class="img-rounded" src="<?= $file ?>"
/></p>
<p>Change Photo:<br/>
<input type="file" name="fileToUpload" id="fileToUpload"/>
</p>
<input type="hidden" name="profile_id" value="<?= $profile_id ?>"/>
<input type="submit" value="Save">
<input type="submit" name="cancel" value="Cancel">
</p>
</form>
</body>
