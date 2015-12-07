<?php
   
	$msg = "Thank you ". $_POST['name'] . " for submitting your information.\n";	//EMail message

	
	foreach($_POST as $name => $value) {
		print "$name : $value<br/>";						//This is going to the screen
		$msg .="$name : $value\n";							//This is going to the email
	}
	
	$to = $_POST["email"];
	$headers = "From: ". $_POST["name"] ."<".$_POST["email"]. ">\r\n";
	
	mail($to, 'Form Data', $msg,$headers);

	echo "Email sent";
?>
