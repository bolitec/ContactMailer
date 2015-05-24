<?php

	//This makes sure they did not leave any fields blank
	if (!$_POST['email'] | !$_POST['pass'] | !$_POST['pass2']) 
	{
		//die('You did not complete all of the required fields');
		$MsgTitle = "Register";
		$redirect = "Register.php";
		$MsgType = "Register.php Warning:";
		$Msg1 = "You did not complete all of the required fields(*).";
		$Msg2= "Click on the Back button to return to Register.";
		$button = "Back";
		include $html_files.'logonMsg.html';
		unset($_POST['register']);
		exit();
	}
	
	// checks if the email is in use
	if (!get_magic_quotes_gpc())
	{
		$_POST['email'] = addslashes($_POST['email']);
	}

	// email and password sent from form 
	$myemail=$_POST['email']; 
	$mypassword=$_POST['pass']; 

	//$usercheck = $_POST['email'];
	$check = mysqli_query($link,"SELECT vchEmail FROM ".$tbl_name." WHERE vchEmail = '$myemail'") 
		or die(mysqli_error());
	$check2 = mysqli_affected_rows($link);

	//if the name exists it gives an error
	if ($check2 != 0)
	{
		//die('Sorry, the email '.$_POST['email'].' is already in use.');
		$MsgTitle = "Register";
		$redirect = "Logon.php";
		$MsgType = "Register.php Error:";
		$Msg1 = "I am sorry, the Email: ".$myemail.",";
		$Msg2= "is already in use click on the Logon button below.";
		$button = "Logon";
		include $html_files.'logonMsg.html';
		unset($_POST['register']);
		exit();
	}

	// this makes sure both passwords entered match
	if ($_POST['pass'] != $_POST['pass2'])
	{
		//die('Your passwords did not match. ');
		$MsgTitle = "Register";
		$redirect = "Register.php";
		$MsgType = "Register.php Error:";
		$Msg1 = "I am sorry, the passwords for: ".$myemail.",";
		$Msg2= "did not match, Please try again.";
		$button = "Register";
		include $html_files.'logonMsg.html';
		unset($_POST['register']);
		exit();
	}

	if (!get_magic_quotes_gpc()) 
	{
		$_POST['pass'] = addslashes($_POST['pass']);
		$_POST['email'] = addslashes($_POST['email']);
	}

	// here we encrypt the password and add slashes if needed
	$_POST['pass'] = md5($_POST['pass']);

	// email and password sent from form 
	$myemail=$_POST['email']; 
	$mypassword=$_POST['pass']; 

    // Validate email and and if successful continue otherwise show error 
	include $php_files.'ValidateEmail.php';
	$email = $myemail;
	if (validate_email($email))
	{	
		// echo "Email is valid!";
		include $php_files.'RegEmail.php';
	}
	else
	{
		//  echo "Email is invalid!";
		//die('Your email address is no good. ');
		$MsgTitle = "Register";
		$redirect = "Register.php";
		$MsgType = "Register.php Error:";
		$Msg1 = "I am sorry, the email address ".$myemail." is not valid.";
		$Msg2= "Please provide a valid email address, thank you.";
		$button = "Register";
		include $html_files.'logonMsg.html';
		unset($_POST['register']);
		exit();
	}

	// To protect MySQL injection (more detail about MySQL injection)
	$myemail = stripslashes($myemail);
	$mypassword = stripslashes($mypassword);
	$myemail = mysqli_real_escape_string($link, $myemail);
	$mypassword = mysqli_real_escape_string($link, $mypassword);
	$ip=$_SERVER['REMOTE_ADDR'];

	// now we insert it into the database
	$today = DATE(c);
	$insert = "INSERT INTO ".$tbl_name." (vchEmail, vchPassword, chIP, dtRegistered)
		VALUES ('$myemail', '$mypassword', '$ip', '$today')" ;

	$add_member = mysqli_query($link,$insert)
	               or die("MySQL Err: ".mysql_errno($link)."; ".mysqli_error($link));
	
	// set session email and password to go right into Member page.
	// From Register.php we always destroy existing session to stay clean
	// Password is already hashed don't re hash it
	$_SESSION['Email'] = $myemail; 
	$_SESSION['ip'] = $ip;
	$_SESSION['Password'] = $mypassword;
	//session_write_close();

	// <h1>Registered</h1>
	// <p>-Register.php- Thank you, you have registered - you may now <a href=Logon.php>logon</a>.</p>
	$MsgTitle = "Successfully Registered";
	$redirect = "Member.php";
	$MsgType = "Register.php Message:";
	$Msg1 = "Thank you! You have successfully registered email: ".$myemail.",";
	$Msg2= "Click on the Member button to enter the Members Area.";
	$button = "Member";
	include $html_files.'logonMsg.html';
	unset($_POST['register']);
	exit();
?>	