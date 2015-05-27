<?php
		// Load values from ProfileAdmin form for updates to profile table
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
 		$admin = $_POST['admin'];
  	$changedEmail = $_POST['email'];
		$changedEmail2 = $_POST['email2'];
		$zip = $_POST['zip'];
    $modate = $_POST['modate'];
		$today = DATE(c);
		
		// First thing to check is any blank required fields and provide edit.	
		if (empty($_POST['email']))
		{
			$MsgTitle = "Profile Update Page (Admin)";
			$MsgType = "Hello '$sessionName',";
			$msg1 = "Required fields cannot be blank,";
			$msg2= "Please provide data for any field showing * next to it. Thank You.";
			include $html_files.'profileAdmin.html';
			show_profile_admin($changedEmail,$changedEmail2,$admin
			                   ,$first,$last,$addr1,$addr2,$addr3,$city,$state,$zip,$country
			                   ,$phone,$citystphone,$group,$modate);
			exit();
		}
			// No email or password change so do a straight forward update.
			mysqli_query($link,"update ".$tbl_name2." set vchEmail = '$changedEmail',
			    vchFirstName = '$first', vchLastName = '$last', chAdmin = '$admin',
					vchAddress1 = '$addr1', vchAddress2 = '$addr2', vchAddress3 = '$addr3',
					vchCity = '$city', vchState = '$state', tsRegModified = '$today',
					vchPhone = '$phone', vchCountry = '$country', tiHide_email = '$citystphone',
					vchGroup = '$group', vchEmail_2 = '$changedEmail2',	vchZip = '$zip'
					WHERE '$changedEmail' = vchEmail ") 
					or die('--profile_admin_update.php (Update Profile Admin)-'.mysqli_error($link).'');

 		  if ($citystphone == 3)
 		  {
 		    // echo nl2br("hide_email: ".$citystphone."\r\n");
 		    // Delete existing Emails row that belongs to this member and profile and has unsubscribed=3.
  		  mysqli_query($link,"delete from ".$tbl_name3." WHERE '$changedEmail' = email_1 ")
  		  or die('--profile_admin_update.php  (Delete of Emails table failed)-'.mysqli_error($link).'');
 		  }
 		  else
 		  {
 		    // echo nl2br("hide_email: ".$citystphone."\r\n");
   		  // Update existing Emails row that belongs to this member and profile.
	  	  mysqli_query($link,"update ".$tbl_name3." set first_name = '$first', last_name = '$last',
		          grp_name = '$group', email_1 = '$changedEmail', email_2 = '$changedEmail2'  					
		  				WHERE '$changedEmail' = email_1 ")
 				or die('--profile_admin_update.php  (update Emails table failed)-'.mysqli_error($link).'');
   			// Check and see if we are trying to re-insert the email record.
   			// echo nl2br("rows: ".mysqli_affected_rows($link)."\r\n");
    		if (mysqli_affected_rows($link) == 0 and $citystphone == 0)
        {
    	  	  // check one more time for an update that returned 0 affected_rows because nothing changed
    	  	  mysqli_query($link,"select email_1 from ".$tbl_name3." where '$changedEmail' = email_1 ")
    	  	  or die ("MySQL Error: ".mysqli_errno($link)."; ".mysqli_error($link)."; profile_admin_update.php; failed count on Emails table");
    	  	  if (mysqli_affected_rows($link) == 0)
    	  	  {
        	  	  mysqli_query($link,"insert into ".$tbl_name3." values (0,'$group','$first','$last',
   	    	          '$changedEmail','$changedEmail2')")
 				        or die('MySql Error: '.mysqli_errno($link).' from --profile_admin_update.php (insert of Emails table failed)-'.mysqli_error($link).'');
 				    }
				}
		   }
  			// For admin logon we display admin member menu
  			$MsgTitle = "Administrator Page";
  			$redirect = $url_secure_php."SearchMember.php";
   			$MsgType1 = "profile_admin_update.php";
		  	$MsgType2 = "Thank you, ".$sessionName.";";
	  		$Msg1 = "Contact information for '$changedEmail' was updated successfully!!!";
  			$Msg2= "To View/Update another Profile click on Search, to exit Logout."; 
  			include $html_files.'admin.html';
	  		exit();
?>