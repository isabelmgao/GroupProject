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

    $smtp = Mail::factory('smtp', array(
            'host' => 'ssl://smtp.gmail.com',
            'port' => '465',
            'auth' => true,
            'username' => 'isabelmgao@gmail.com',
            'password' => 'running88'
        ));

    $mail = $smtp->send($to, $headers, $body);

    // if (mail ($to, $subject, $body, $headers)) {
        $_SESSION['success'] = "Thanks for contacting us!";
        header("Location: form3.php");
        return;
    // }
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
<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/demo.css"/>
    <link rel="stylesheet" href="css/style_3.css"/>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <link rel="stylesheet" href="css/contact_style.css"/>
    <link rel="stylesheet" type="text/css" href="css/custom_1.css" />
    <link rel="stylesheet" href="css/style_3.css"/>
    <!-- <script src="js/modernizr.custom.63321.js"></script> -->
	<meta charset="UTF-8">
	<title>Contact Us</title>
	<!-- <script type="text/javascript">
	 function checkEmail(){
	 	if (em.value != em2.value){
			alert("The emails must match!");
			return false;
		}
	}
</script> -->
</head>
<body>
    <header>
        <nav class="navbar-wrapper navbar-default">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ek-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
    <!--                 <a class="navbar-brand" href="index.html">Banner goes here</a>
     -->            </div>


                <div class="collapse navbar-collapse navbar-ek-collapse">


                    <nav class="codrops-demos">
                        <a href="event.html">Event</a>
                        <a href="people.html">People</a>
                        <a href="aboutUs.html">About Us</a>
                        <a class="current-demo" href="contact.html">Contact</a>
                    </nav>
                </div>
            </div>
      </nav>
    </header>
<form method = "POST">
        <div class="container" "col-lg-12">
            <div id="content-form">
    <fieldset>
    	<legend><h2>Contact Us</h2>
  <?php
      if ( isset($_SESSION['error']) ) {
        echo('<p style="color: red;">'.htmlentities($_SESSION['error'])."</p>\n");
        unset($_SESSION['error']);
      }
      if ( isset($_SESSION['success']) ) {
        echo('<p style="color: green;">'.htmlentities($_SESSION['success'])."</p>\n");
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

<footer id="short">

    <div>
      <ul class="unstyled">
          <li><i class="fa fa-envelope-o"></i><a href="mailto:peiyaoh@umich.edu">Email</a></li>
          <li><i class="fa fa-youtube"></i><a href="https://www.youtube.com/channel/UCMFH7ohOScERNqXeLFpRZnw">YouTube</a></li>
          <li><i class="fa fa-twitter"></i><a href="https://twitter.com/um_isc">Twitter</a></li>
          <li><i class="fa fa-google-plus"></i><a href="https://plus.google.com/u/0/b/102784032297384468349/102784032297384468349/posts">Google+</a></li>
      </ul>

    </div>

    <div class="footer-note">
      <p>Design &amp; Code by Isabel, Sunny &amp; Xiaojie © 2015 | Lastest Update: 12/05/2015</p>

      <p>&copy; Copyright by MISC</p>
    </div>


  </footer>

  <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
  <script src="https://code.jquery.com/jquery.js"></script>
  <!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="js/bootstrap.min.js"></script>

</body>
</html>
