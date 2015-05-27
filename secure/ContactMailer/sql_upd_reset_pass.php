<?php
	//This makes sure they did not leave any fields blank
	if (!$_POST['email'] | !$_POST['pass'] | !$_POST['pass2'])
	{
		//die('You did not complete all of the required fields');
		$MsgTitle = "Reset Password";
		$redirect = $url_secure_php."Logon.php";
		$MsgType = "Warning:";
		$Msg1 = "You did not complete all of the required fields(*).";
		$Msg2= "Email and password fields are required!";
		$button = "Back";
		include $html_files.'reset-pass.html';
		unset($_POST['passcode']);
		exit();
	}

	// checks if the email is in use
	if (!get_magic_quotes_gpc())
	{
		$_POST['email'] = addslashes($_POST['email']);
	}

	// email and password sent from form
	$myemail=$_POST['email'];
	$oldpass=$_POST['oldpass'];
	
	//$usercheck = $_POST['email'];
	$check = mysqli_query($link,"SELECT vchEmail FROM ".$tbl_name." 
									WHERE vchEmail='$myemail' 
									and vchPassword='$oldpass'")
	or die(mysqli_error());
	// mysqli_num_rows returns for select; mysqli_affected_rows returns for updates/inserts 
	$check2 = mysqli_num_rows($check);

	//if the name exists go on, if new email entered force to register
	//echo('Check Qry: '.$oldpass.' check2:'.$check2.'');
	if ($check2 == 0) {
	$MsgTitle = "Reset Password";
	$redirect = "Logon.php";
	$MsgType = "Error:";
	$Msg1 = "I am sorry, the Email: ".$myemail." and/or hash has expired,"; //check2=".$check2." Passcode:".$oldpass;
	$Msg2= "has been changed or differs.  Use the Register button if you want to create a new account or Back to Logon.";
	$button = "Back";
	include $html_files.'reset-pass.html';
	unset($_POST['passcode']);
	exit();
	}

	// this makes sure both passwords entered match
	if ($_POST['pass'] != $_POST['pass2']){
		//die('Your passwords did not match. ');
		$MsgTitle = "Reset Password";
		$redirect = "Logon.php";
		$MsgType = "Error:";
		$Msg1 = "I am sorry, the passwords for: ".$myemail.",";
		$Msg2= "did not match, Please try again.";
		$button = "Back";
		include $html_files.'reset-pass.html';
		unset($_POST['passcode']);
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
		// include $php_files.'RegEmail.php';
	}
	else
	{
		//  echo "Email is invalid!";
		//die('Your email address is no good. ');
		$MsgTitle = "Reset Password";
		$redirect = $url_secure_php."Logon.php";
		$MsgType = "Error:";
		$Msg1 = "I am sorry, the email address ".$myemail." is not valid.";
		$Msg2= "Please provide a valid email address, thank you.";
		$button = "Back";
		include $html_files.'reset-pass.html';
		unset($_POST['passcode']);
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
	$update = "update ".$tbl_name." 
				set vchPassword='$mypassword'
				, chIP='$ip'
					where vchEmail='$myemail'" ;

	$upd_member = mysqli_query($link,$update)
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
	$MsgTitle = "Successfully Reset Password";
	$redirect = "Logon.php";
	$MsgType = "Message:";
	$Msg1 = "Thank you! You have successfully reset password for email: ".$myemail.",";
	$Msg2= "Click on the Logon button to initiate session.";
	$button = "Logon";
	include $html_files.'logonMsg.html';
	unset($_POST['passcode']);
	exit();