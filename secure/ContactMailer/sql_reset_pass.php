<?php

if ($passcode != null){
	
	// Connects to member table of contact_mailer Database
	//  Include the db connection script from non public_html location
	include PRIVATE_DB."dbConfig.php";
	
	// When no session is found check to see if the logon form is posted
	if (isset($_POST['passcode']))
	{
		include $secured_php.'sql_upd_reset_pass.php';
	}
	else
	{
		// pass your oldpass to hidden field in html
		$oldpass = $passcode;
		//  When passcode post is not set just show the reset-pass.html page
		$MsgTitle = "Reset Password";
		$redirect = "ResetPassEmail.php";
		$MsgType = "Instruction:";
		$Msg1 = "To reset your password type new password and confirm before clicking on reset button";
		//	$Msg2= 'Email reset, Email: '.$email;
		$button = "Reset";
		include $html_files.'reset-pass.html';
		exit();
		
	}
		
} else {
  $check = mysqli_query($link,"SELECT * FROM ".$tbl_name." WHERE vchEmail = '$email'")
    or die('-sql_reset_pass.php- '.mysql_error().'');
  while($reset = mysqli_fetch_array($check ))
  {
			
	//if the DB session has the wrong password, they are taken to the logon page
	if ($email != $reset['vchEmail'])
	{
		//echo('-Member.php-  Incorrect IP match, please try again, $sessionIp: '.$sessionIp.' chIP: '.$reset['chIP'].'');
		$redirect = "Logout.php";
		$MsgType = "Member.php Warning:";
		$Msg1 = "Email session mismatch with stored session, click Logon button below.";
		$Msg2= 'Email mismatch, chIP: '.$reset['chIP'].'';
		$button = "Logon";
		include $html_files.'logonMsg.html';
		unset($_POST['logout']);
		exit();
	}
	//otherwise they are shown the admin or main application area/page and the DB session is stored and committed.
	else
	{
		// build get url to include in email for passcode reset.
		$reset_url = $url_secure_php.'ResetPassEmail.php?email='.$email.'&passcode='.$reset['vchPassword'];
	}
  }
}