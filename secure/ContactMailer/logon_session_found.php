<?php
// When no session is found check to see if the logon form is posted
	//if there is an active session, it logs you in and directs you to the members page
 	$email = $_SESSION['Email']; 
	$ip = $_SESSION['ip'];
	$check = mysqli_query($link,"SELECT M.*, U.vchFirstName, U.vchLastName FROM ".$tbl_name." as M 
							left join ".$tbl_name2." as U on M.vchEmail = U.vchEmail 
							WHERE M.vchEmail = '$email'")
		or die("Logon.php mysql error -1- ".mysqli_error());

	while($info = mysqli_fetch_array( $check )) 
	{
		$logonName = $info['vchFirstName']." ".$info['vchLastName'];
		if ($ip != $info['chIP']) 
		{
			$MsgTitle = "LOGON";
			$redirect = "Logon.php";
			$MsgType = "Logon.php Warning:";
			$Msg1 = "Your session IP does not match database.";
			$Msg2= "Click Back button to return to Logon";
			$button = "Back";
			include $html_files.'logonMsg.html';
			unset($_POST['logon']);
			exit();
		}
		else
		{
	    if (isset($_SESSION['Admin']))
    	{
 				// For admin logon we display admin member menu
				$MsgTitle = "Administrator Page";
				$redirect = $url_secure_php."Member.php";
				$MsgType1 = "Logon.php>>logon_session_notfound.php";
				$MsgType2 = "Welcome back, ".$logonName.";";
				$Msg1 = "Welcome to the ".TITLE;
				$Msg2= "You are a registered (admin) member of the ".TITLE."!";
				include $html_files.'admin.html';
		  }
			else
		  {			
		  	// echo ('-Logon.php- prior Session found: '.$_SESSION['PlayaLosEmail'].' PASS: '.$_SESSION['PlayaLosPassword'].'');
				$MsgTitle = "Jesus Caritas Lay Fraternity of North America";
				$redirect = "MyProfile.php";
				$MsgType = "Welcome back, ".$logonName.";";
				$Msg1 = "Welcome to the ".TITLE;
				$Msg2= "You are a registered member of the ".TITLE."!";
				// include $php_files.'Member.php';
				include $html_files.'member.html';
		  }
// 			session_write_close();
			exit();
		}
	}
?>