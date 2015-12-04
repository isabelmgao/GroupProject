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

if (isset($_POST['first_name']) && isset($_POST['last_name']) &&
    isset($_POST['department'])){


    if ( strlen($_POST['first_name'])<1 || strlen($_POST['last_name'])<1 ||
       strlen($_POST['department'])<1) {
         $_SESSION['error'] = "All fields are required";
          header("Location: add.php");
          return;
    }

    // Do all that image upload.php
    $target_dir = "member_img/";
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

    // Check if image file is a actual image or fake image
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check === false) {
        $_SESSION['error']= "File is not an image.";
        header("Location: add.php");
        return;
    }

    //Check file extension
    // if($imageFileType != '.jpg' || $imageFileType != '.jpeg' ||
    //    $imageFileType != '.png'){
    //      $_SESSION['error']="Image file not recognized. Please upload a jpeg, jpg, or png file";
    //     //  header("Location: add.php");
    //    }

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

    //text fields
    $stmt = $pdo->prepare('INSERT INTO Profile
        (user_id, first_name, last_name, department, filename) VALUES ( :uid, :fn, :ln, :depar, :file )');
    $stmt->execute(array(
        ':uid' => $_SESSION['user_id'],
        ':fn' => $_POST['first_name'],
        ':ln' => $_POST['last_name'],
        ':depar' => $_POST['department'],
        ':file' => $target_file));

    $_SESSION['success']="Record added";
    header("Location: add.php");
    return;
  }
 ?>

<!DOCTYPE html>
<html>
<head>
<title><?php echo($_SESSION['name'])?>'s Profile Add</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../static/img/iconthumb.jpg">
    <link rel="stylesheet" href="bootstrap-3.3.5-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/database.css">
</head>
<body style="font-family: sans-serif;">
<?php
  if ( isset($_SESSION['error']) ) {
    echo('<p class="success">'.htmlentities($_SESSION['error'])."</p>\n");
    unset($_SESSION['error']);
  }
  if ( isset($_SESSION['success']) ) {
    echo('<p class="error">'.htmlentities($_SESSION['success'])."</p>\n");
    unset($_SESSION['success']);
  }
?>
<h1 class="add">Add a member</h1>
<form class="add" method="post" enctype="multipart/form-data">
<p>First Name:
<input type="text" name="first_name" size="60"/></p>
<p>Last Name:
<input type="text" name="last_name" size="60"/></p>
<p>Department:
<input type="text" name="department" size="60"/></p>
<!-- Upload photo -->
<div class="picUpload">
<p> Upload a profile picture (if available):</p>
<input type="file" name="fileToUpload" id="fileToUpload"/>
</div>
<p>
<input type="submit" value="Add">
<input type="submit" name="cancel" value="Cancel">
</p>

</form>
</body>
</html>
