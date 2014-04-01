<?php
		// Load values from myProfile form for updates to user table
		$first = $_POST['first'];
		$last = $_POST['last'];
		$addr1 = $_POST['addr1'];
		$addr2 = $_POST['addr2'];
		$addr3 = $_POST['addr3'];
		$city = $_POST['city'];
		$state = $_POST['state'];
		$phone = $_POST['phone'];
		$country = $_POST['country'];
		$citystphone = $_POST['citystphone'];
		$group = $_POST['group'];
		$regdate = $_POST['regdate'];
 		$changedPass = $_POST['pass'];
  	$changedEmail = $_POST['email'];
		$changedEmail2 = $_POST['email2'];
		$zip = $_POST['zip'];
    $modate = $_POST['modate'];
		$today = DATE(c);
		
		// First thing to check is any blank required fields and provide edit.	
		if (empty($_POST['pass']) or empty($_POST['email']) or empty($first) or empty($last))
		{
			$MsgTitle = "MyProfile Update Page";
			$MsgType = "Hello '$logonName',";
			$msg1 = "Required fields cannot be blank,";
			$msg2= "Please provide data for any field showing * next to it. Thank You.";
			include $html_files.'myprofile.html';
			show_profile($changedEmail,$changedEmail2,$changedPass,$first,$last,$addr1,$addr2,$addr3,$city,$state,$zip,$country,$phone,$citystphone,$group,$regdate,$modate);
			exit();
		}
		// Check if user has changed email or password
		if ($sessionEmail != $changedEmail or $sessionPass != $changedPass)
		{
 		  $changedPass = stripslashes($changedPass);
		  $changedPass = md5($changedPass);
	
      // tbl_name2 = Profile table.
			mysqli_query($link,"update ".$tbl_name2." set vchEmail = '$changedEmail', vchFirstName = '$first', vchLastName = '$last',
					vchAddress1 = '$addr1', vchAddress2 = '$addr2', vchAddress3 = '$addr3',	vchCity = '$city', vchState = '$state', 
					vchPhone = '$phone', vchGroup = '$group', tsRegModified = '$today', vchCountry = '$country', tiHide_email = '$citystphone',
					vchEmail_2 = '$changedEmail2',	vchZip = '$zip'
					WHERE '$sessionEmail' = vchEmail ") 
					or die('-myprofile_session_found_update.php (Update User Table)-'.mysqli_error().'');

			// Delete old member and Email rows then add new ones in that order.
			// tbl_name = member table.
		  mysqli_query($link, "delete from ".$tbl_name." WHERE '$sessionEmail' = vchEmail ") 
			               or die('--myprofile_session_found_update.php (Delete Member with old member table failed)-'.mysqli_error().'');

		  // tbl_name3 = Emails table.
		  mysqli_query($link, "delete from ".$tbl_name3." WHERE '$sessionEmail' = email_1 ") 
			               or die('--myprofile_session_found_update.php (Delete Member with old email table failed)-'.mysqli_error().'');

			// Insert new member and Emails rows.
			$ip = $_SESSION['ip'];
			mysqli_query($link, "insert into ".$tbl_name." 
			         VALUES ('$changedEmail', '$changedPass', '$ip', '$regdate')") 
			         or die('--myprofile_session_found_update.php (Insert Member Table with new Email failed)-'.mysqli_error().'');

			if ($citystphone != 3)
 		  {
       mysqli_query($link, "insert into ".$tbl_name3." 
			         VALUES (0,'$group', '$first', '$last', '$changedEmail', '$changedEmail2' )") 
			         or die('-myprofile_session_found_update.php (Insert Email Table with new Email failed)-'.mysqli_error().'');
			}

			// Store new session variables 
			$_SESSION['Password'] = $changedPass;
			$_SESSION['Email'] = $changedEmail;
		}
		else
		{
			// No email or password change so do a straight forward update.
			mysqli_query($link,"update ".$tbl_name2." set vchEmail = '$changedEmail',
			    vchFirstName = '$first', vchLastName = '$last',
					vchAddress1 = '$addr1', vchAddress2 = '$addr2', vchAddress3 = '$addr3',
					vchCity = '$city', vchState = '$state', tsRegModified = '$today',
					vchPhone = '$phone', vchCountry = '$country', tiHide_email = '$citystphone',
					vchGroup = '$group', vchEmail_2 = '$changedEmail2',	vchZip = '$zip'
					WHERE '$changedEmail' = vchEmail ") 
					or die('--myprofile_session_found_update.php (Update Profile Table)-'.mysqli_error().'');

 		  if ($citystphone == 3)
 		  {
 		    // echo ("hide_email(3): ".$citystphone);
 		    // Update existing Emails row that belongs to this member and profile.
  		  mysqli_query($link,"delete from ".$tbl_name3." WHERE '$changedEmail' = email_1 ")
		  	or die('--myprofile_session_found_update.php (Delete of Emails table failed)-'.mysql_error().'');
		  }
 		  else
 		  {
 		    // echo ("hide_email(<>3): ".$citystphone);
 		    // Update existing Emails row that belongs to this member and profile.
	  	  mysqli_query($link,"update ".$tbl_name3." set first_name = '$first', last_name = '$last',
		          grp_name = '$group', email_1 = '$changedEmail', email_2 = '$changedEmail2'  					
		  				WHERE '$changedEmail' = email_1 ")
		  	or die('--myprofile_session_found_update.php (update Emails table failed)-'.mysql_error().'');
   			// Check and see if we are trying to re-insert the email record.
    	  if (mysqli_affected_rows($link) == 0 and $citystphone == 0)
        {
   	  	  // check one more time for an update that returned 0 affected_rows because nothing changed
    	  	  mysqli_query($link,"select email_1 from ".$tbl_name3." where '$changedEmail' = email_1 ")
    	  	  or die ("MySQL Error: ".mysqli_errno($link)."; ".mysqli_error($link)."; myprofile_session_found_update.php; failed count on Emails table");
    	  	  if (mysqli_affected_rows($link) == 0)
    	  	  {
    	  	     mysqli_query($link,"insert into ".$tbl_name3." values (0,'$group','$first','$last',
  		                             '$changedEmail','$changedEmail2')")
			         or die('MySql Error: '.mysqli_errno($link).' from --profile_admin_update.php (insert of Emails table failed)-'.mysqli_error($link).'');
			      }
  		  }
		  }
		}

	  $logonName = $first." ".$last;
	  $_SESSION['LogonName'] = $logonName;
	  session_write_close();

	  if (isset($_SESSION['Admin']))
    {
 			// For admin logon we display admin member menu
			$MsgTitle = "Administrator Page";
			$redirect = $url_secure_php."Member(admin).php";
			$MsgType1 = "????.php>>myprofiler_session_found.php";
			$MsgType2 = "Thank you, ".$logonName.";";
			$Msg1 = "Your contact information was updated successfully";
			$Msg2= "To View/Update your Profile click on MyProfile, to exit Logout.";
			include $html_files.'admin.html';
		 }
		else
		 {
			$MsgTitle = "MyProfile Page";
			// $redirect = "Logon.php";
			$MsgType2 = "Thank you, ".$logonName." ";
			$Msg1 = "Your contact information was updated successfully";
			$Msg2= "To View/Update your Profile click on MyProfile, to exit Logout.";
			include $html_files.'member.html';
		 }
			exit();
?>