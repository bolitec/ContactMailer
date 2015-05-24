<?php
		// Load values from emailAdmin form for inserts to Emails table
		$first = $_POST['first'];
		$last = $_POST['last'];
		$group = $_POST['group'];
  	$email_1 = $_POST['email'];
		$today = DATE(c);
		
		// First thing to check is any blank required fields and provide edit.	
		if (empty($_POST['email']))
		{
			$MsgTitle = "Emails Insert Page (Admin)";
			$MsgType = "Hello '$sessionName',";
			$Msg1 = "Required fields cannot be blank,";
			$Msg2= "Please provide data for any field showing * next to it. Thank You.";
  		include $mailer_files.'grp-name-qry-01.php';
			include $html_files.'emailAdmin.html';
			show_email_admin('$last','$first','$email','$group');
			exit();
		}
		else
		{
			// Actual SQL insert of table_name3 Emails from EmailAdmin.php.
			if(!mysqli_query($link, "insert into ".$tbl_name3." values (0,'$group','$first','$last','$email_1','')"))
			{
        $Msg1 = "The following error and # were returned from the Emails Insert";
				if (mysqli_errno() == 1062)
				{
//				echo mysql_errno().": duplicate key error returned from MySQL";
  				$Msg2 = mysqli_errno().": duplicate key error returned from MySQL";
  			}
        else
        {  
  				$Msg2 = mysqli_error()."; Error#: ".mysql_errno()." returned from MySQL";
  			}
  			$MsgTitle = "Emails Insert Page";
	  		// $redirect = "Logout.php";
		  	$MsgType2 = "Fatal Error on Emails Insert, ".$logonName." ";
    		include $mailer_files.'grp-name-qry-01.php';
			  include $html_files.'emailAdmin.html';
			show_email_admin('$last','$first','$email','$group');
  			exit();
  		}
			$MsgTitle = "Emails Insert Page";
			// $redirect = "Logout.php";
			$MsgType2 = "Thank you, ".$logonName." ";
			$Msg1 = "Your insert to the Emails table for email: ".$email_1." completed successfully.";
			$Msg2= "Press Admin link to return to Admin menu, to exit Logout.";
  		include $mailer_files.'grp-name-qry-01.php';
			include $html_files.'emailAdmin.html';
			show_email_admin('$last','$first','$email','$group');
			exit();
		 }
?>