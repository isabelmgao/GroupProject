<?php
require_once "pdo.php";
session_start();

$target_dir = "member_img/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        // echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
}

if($imageFileType != '.jpg' || $imageFileType != '.jpeg' ||
   $imageFileType != '.png'){
     $_SESSION['error']="Image file not recognized. Please upload a jpeg, jpg, or png file"
     header("Location: people.php");
   }
// Check file size
if ($_FILES["fileToUpload"]["size"] > 500000) {
    echo "Sorry, your file is too large. Please return back using the back button";
    $uploadOk = 0;
    return;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";

        $stmt = $pdo->prepare('INSERT INTO Profile
              (filename, user_id) VALUES ( :filename, :user_id)');
          $stmt->execute(array(
          ':filename' => $target_file,
          ':user_id' => $_SESSION['user_id']));
          header("Location: add.php");
          $_SESSION['success']="Image added";
          return;


    } else
        $_SESSION['error']="Sorry, there was an error uploading your file.";
        header("Location: add.php");
    }
}
?>
