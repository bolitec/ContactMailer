<?php

	// initialize logonName to nulls to check if profile has name later
	$logonName = null;
	// The form is set and contains logon credentials
	// Make sure they filled in email and password required fields
	if(!$_POST['email'] | !$_POST['pass']) 
	{
		// die('You did not fill in a required field.');
		$MsgTitle = "LOGON";
		$redirect = $url_secure_php."Logon.php";
		$MsgType = "Logon.php Warning:";
		$Msg1 = "You did not complete all of the required fields(*).";
		$Msg2= "Click Back button to return to Logon";
		$button = "Back";
		include $html_files.'logonMsg.html';
		unset($_POST['logon']);
		exit();
	}
	// checks it against the database
	if (!get_magic_quotes_gpc()) 
	{
		$_POST['email'] = addslashes($_POST['email']);
		$_POST['pass'] = addslashes($_POST['pass']);
	}
	// Store session to re-display email on register and logon html pages.
	$_SESSION['RegEmail'] = $_POST['email']; 
	$reg_email = $_POST['email'];
	// U=User table; P=Profile table
	$check = mysqli_query($link, "SELECT M.*, P.vchFirstName, P.vchLastName ,P.chAdmin FROM ".$tbl_name." as M 
							left join ".$tbl_name2." as P on M.vchEmail = P.vchEmail
							WHERE M.vchEmail = '$reg_email'")
		or die("Logon.php mysql error -2- ".mysqli_error());

	// Gives error if user doesn't exist
	$check2 = mysqli_affected_rows($link);
	if ($check2 == 0) 
	{
	    $ip = $_SERVER['REMOTE_ADDR'];
	    $_SESSION['ip'] = $ip;
		session_write_close();			

		//die('-Logon.php- That user does not exist in our database. <a href=Register.php>Click Here to Register</a>');
		$MsgTitle = "Logon Result";
		$redirect = $url_secure_php.'Register.php';
		$MsgType1 = "logon_session_notfound.php";
		$MsgType2 = "Logon.php Message:";
		$Msg1 = "The credentials you provided do not exist in our database.";
		$Msg2= "Click button to Register.";
		$button = "Register";
		include $html_files.'logonMsg.html';
		unset($_POST['logon']);
		exit();
	}
	while($info = mysqli_fetch_array( $check )) 
	{
		$_POST['pass'] = stripslashes($_POST['pass']);
		$info['vchPassword'] = stripslashes($info['vchPassword']);
		$_POST['pass'] = md5($_POST['pass']);
		if(!empty($info['vchFirstName']) | !empty($info['vchLastName'])){
			$logonName = $info['vchFirstName']." ".$info['vchLastName'];
		}
		$regDate = $info['dtRegistered'];
		
		// Gives error if the password is wrong
		if ($_POST['pass'] != $info['vchPassword']) {
			//die('pass: '.$_POST['pass'].' vchPass: '.$info['vchPassword'].' -Logon.php- Incorrect password match, please try again.');
			$MsgTitle = "LOGON";
			$redirect = $url_secure_php."Logon.php";
			$MsgType1 = "logon_session_notfound.php";
			$MsgType2 = "Logon.php Warning:";
			$Msg1 = "Password does not match database for email: ".$reg_email.",";
			$Msg2= "please try again by clicking Back. Or request a password Reset email below.</a>";
			$button = "Back";
			$button2 = "<li><a href=".$url_secure_php."ResetPassEmail.php?email=".$reg_email.">Reset</a></li>";
			include $html_files.'logonMsg.html';
			unset($_POST['logon']);
			exit();
		} else { 
			// if logon is ok then we store a database secure session
			// Password is already hashed don't re hash it
			// Check and save logon profile admin level
	    	if ($info['chAdmin'] == "A1"){
				$_SESSION['Admin'] = $info['chAdmin'];
		 	}
		  	// Load other session parameters
		  	// Email session is only stored once the cridentials are verified, then we blank out RegEmail var.
			$_POST['email']       = stripslashes($_POST['email']); 
			$_SESSION['Email']    = $_POST['email']; 
			$_SESSION['RegEmail']    = ""; 
			$ip                   = $_SERVER['REMOTE_ADDR'];
	      	$_SESSION['ip']       = $ip;
			$_SESSION['Password'] = $_POST['pass'];
			$_SESSION['regdate']  = $regDate;
			If ($logonName != null){
				$_SESSION['LogonName'] = $logonName;
			} else {
				$logonName = $_SESSION['Email'];
				$_SESSION['LogonName'] = $_SESSION['Email'];
			}
			session_write_close();
	 		// Update member with new current IP.
			mysqli_query($link,"update ".$tbl_name." set chIP = '$ip'
		  				WHERE '$email' = vchEmail ") 
		  				or die('--logon_session_notfound.php (update member new IP failed)-'.mysqli_error().'');
			
			//then redirect them to the members area 
			//echo ('-Logon.php- Session Email: '.$_SESSION['Email'].' logonName: '.$_SESSION['LogonName']."\n");
			// echo ('');
			//header("Location: Member.php"); 
	    	if (isset($_SESSION['Admin'])) {
 				// For admin logon we display admin member menu
				$MsgTitle = "Administrator Page";
				$redirect = $url_secure_php."Member.php";
				$MsgType1 = "Logon.php>>logon_session_notfound.php";
				$MsgType2 = "Welcome back, ".$logonName.";";
				$Msg1 = "Welcome to the ".TITLE;
				$Msg2= "You are a registered (admin) member of the ".TITLE;
				include $html_files.'admin.html';
			} else {
        		// Regular member menu with MyProfile button
				$MsgTitle = "Members Page";
				$redirect = $url_secure_php."MyProfile.php";
				$MsgType1 = "Logon.php>>logon_session_notfound.php";
				$MsgType2 = "Welcome back, ".$logonName.";";
				$Msg1 = "Welcome to the ".TITLE;
				$Msg2= "You are a registered member of the ".TITLE;
				include $html_files.'member.html';
		  	}
			exit();
		} 
	} 
?>