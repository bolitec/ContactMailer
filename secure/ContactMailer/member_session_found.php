<?php
	$sessionEmail = $_SESSION['Email']; 
	$sessionIp = $_SESSION['ip']; 
	$sessionPass = $_SESSION['Password']; 
	$sessionName = $_SESSION['LogonName'];

	$check = mysqli_query($link,"SELECT * FROM ".$tbl_name." WHERE vchEmail = '$sessionEmail'")or die('-Member.php- '.mysql_error().''); 
	while($info = mysqli_fetch_array($check )) 
	{ 
		//if the DB session has the wrong password, they are taken to the logon page 
		if ($sessionIp != $info['chIP'])
		{
		//echo('-Member.php-  Incorrect IP match, please try again, $sessionIp: '.$sessionIp.' chIP: '.$info['chIP'].'');
			$redirect = "Logout.php";
			$MsgType = "Member.php Warning:";
			$Msg1 = "IP session mismatch with stored session, click Logon button below.";
			$Msg2= 'IP mismatch, $sessionIp: '.$sessionIp.' chIP: '.$info['chIP'].'';
			$button = "Logon";
			include $html_files.'logonMsg.html';
			unset($_POST['logout']);
			exit();
		}
		//otherwise they are shown the admin or main application area/page and the DB session is stored and committed.
		else 
		{ 
			// session_write_close();
			// echo ('-Member.php- Session found: '.$_SESSION['Email'].' PASS: '.$_SESSION['Password'].'');
			// echo ('logonName: '.$_SESSION['LogonName']."\n"); 
			If (isset($_SESSION['LogonName'])){
				$MsgType2 = " Welcome ".$sessionName.";";
			} else {
				If (isset($_SESSION['Email'])){
				$MsgType2 = " Welcome ".$sessionEmail.";";
				}
			}
		    if (isset($_SESSION['Admin']))
	    	{
 				// For admin logon we display admin member menu
				$MsgTitle = "Member Administrator Page";
				$redirect = $url_secure_php."Member.php";
				$MsgType1 = "????.php>>member_session_found.php";
				// $MsgType2 = "Welcome back, ".$logonName.";";
				$Msg1 = "Welcome to the ".TITLE;
				$Msg2= "You are a registered (admin) member of the ".TITLE;
				include $html_files.'admin.html';
			  }
				else
			  {
				$MsgTitle = TITLE;
				$Msg1 = "To modify your profile information or be removed from our mailing list";
				$Msg2= "please select MyProfile below.";
				include $html_files.'member.html';
		  	}
			exit();
		} 
	} 
?>