<?php
require_once "Mail.php";
session_start();

if(isset($_POST['name']) && isset($_POST['email']) && isset($_POST['message'])){
  if(strlen($_POST['message']) >1){
    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];
    $from = 'MISC contact form';
    $headers = "From: $from \r\n";
    $to = 'imgao@umich.edu';
    $subject = 'Contact from MISC';
    $body = "From: $name\n E-Mail: $email\n Message:\n $message";

    function IsInjected($str)
    {
        $injections = array('(\n+)',
               '(\r+)',
               '(\t+)',
               '(%0A+)',
               '(%0D+)',
               '(%08+)',
               '(%09+)'
               );

        $inject = join('|', $injections);
        $inject = "/$inject/i";

        if(preg_match($inject,$str))
        {
          return true;
        }
        else
        {
          return false;
        }
    }

    if(IsInjected($email))
    {
        echo "Bad email value!";
        exit;
    }

    // $smtp = Mail::factory('smtp', array(
    //         'host' => 'ssl://smtp.gmail.com',
    //         'port' => '465',
    //         'auth' => true,
    //         'username' => 'isabelmgao@gmail.com',
    //         'password' => 'running8'
    //     ));
    //
    // $mail = $smtp->send($to, $headers, $body);

    if (mail ($to, $subject, $body, $headers)) {
        $_SESSION['success'] = "Thanks for contacting us!";
        header("Location: form3.php");
        return;
    }
  }

    else {
      $_SESSION['error'] = "You forgot to leave a message";
      header("Location: form3.php");
      return;
    }

    }

?>


<!DOCTYPE html>
<html lang="en">
<?php
include 'header.php';
 ?>
<form method = "POST">
        <div class="container" "col-lg-12">
            <div id="content-form">
    <fieldset>
    	<legend><h2>Contact Us</h2>
  <?php
  if ( isset($_SESSION['error']) ) {
      echo('<p class="flash-error">'.htmlentities($_SESSION['error'])."</p>\n");
      unset($_SESSION['error']);
    }
  if ( isset($_SESSION['success']) ) {
      echo('<img class="flash-success" src="img/checkbox.jpg"><p class="flash-success">'.htmlentities($_SESSION['success'])."</p>\n");
      unset($_SESSION['success']);
  }
  ?>
  </legend>
    	<label>Name<i class="fa fa-user"></i></label><input type = "name" name = "name" value = "" required/>
    	<label>Email<i class="fa fa-envelope"></i><input type = "email" name = "email" id = "em" required/></label>
    	<!-- <label>Confirm Email:<input type = "email" name = "confirm" id = "em2" required/></label> -->
    	<label class="message">Message<i class="fa fa-comment"></i>
            <br><textarea name="message" rows="5" cols="50"></textarea></label>
    	<input name="submit" type = "submit" value ="Send"/>
    </fieldset>

    </div>
    </div>
    </div>


</form>

<?php
include 'footer.php';
 ?>
</body>
</html>
