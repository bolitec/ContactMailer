<?php
		// $tbl_name3 = Emails and $tbl_name2 = profile  join and match on email_key and vchEmail
		$Emails = mysqli_query($link, "SELECT * FROM ".$tbl_name2." P left join ".$tbl_name3." E on P.vchEmail = E.email_1  
								WHERE '$emailKey' = P.vchEmail") 
								or die('-ProfileAdmin.php (select on left join of Profile and Email table failed)- '.mysql_error($link).'');
		//Gives error if user doesn't exist
		$Emails_Count = mysqli_affected_rows($link);
		if ($Emails_Count == 0)
		{
	  // You have arrived here from the search screen and could have either a profile or an email key
	  // if you entered here you have an Email search key.
		  if(!mysqli_query($link, "insert into ".$tbl_name2." values
				(0,'$emailKey','','','','','','','','','','',0,'',0,'','','','','','','')")) 
	  	{
        $msg1 = "The following error and error# were returned";
		  	if (mysqli_errno($link) == 1062)
			  {
//  		  echo mysql_errno().": duplicate key error returned from MySQL";
 				  $msg2 = mysqli_errno($link).": duplicate key error returned from MySQL";
		  	}
		  	else
		  	{
//	  		echo mysql_errno().": error returned from MySQL";
		  		$msg2 = mysqli_errno($link).": ".mysqli_error($link);
		  	}
 		  $MsgType = "We had a problem adding this profile! ".$sessionName;
	    include $html_files.'profileAdmin.html';
	    show_profile_admin($changedEmail,$changedEmail2,$admin,$first,$last,
		               $addr1,$addr2,$addr3,$city,$state,$zip,$country,$phone,$citystphone,
		               $group,$modate);
		    exit;
 			}
			$msg1 = "This Admin screen allows updates to Member Profiles; please update required information,";

  		$Profile = mysqli_query($link, "SELECT * FROM ".$tbl_name2." P left join ".$tbl_name3." E on P.vchEmail = E.email_1
								WHERE '$emailKey' = vchEmail ") 
								or die('-$secured.profile_admin_insert.php (sql select on profile table failed)- '.mysqli_error($link).'');
	  	while($ProfileCol = mysqli_fetch_array( $Profile )) 
		  { 
  			// Loop and display each item detail for given member logon
    		$changedEmail 	= $ProfileCol['vchEmail'];
	      $admin          = $ProfileCol['chAdmin'];
	//  		$changedPass    = $ProfileCol['vchPassword'];
				$addr1 		      = $ProfileCol['vchAddress1'];
				$addr2 		      = $ProfileCol['vchAddress2'];
				$addr3 		      = $ProfileCol['vchAddress3'];
				$city 		      = $ProfileCol['vchCity'];
				$state 		      = $ProfileCol['vchState'];
				$phone 		      = $ProfileCol['vchPhone'];
				$country 	      = $ProfileCol['vchCountry'];
				$citystphone    = $ProfileCol['tiHide_email'];
				$zip            = $ProfileCol['vchZip'];
 	//  		$regdate        = $ProfileCol['dtRegistered'];
   		  $first          = $ProfileCol['vchFirstName'];
  	 		$last 		      = $ProfileCol['vchLastName'];
  			$group          = $ProfileCol['vchGroup'];
  		  $modate         = $ProfileCol['tsRegModified'];
  			$changedEmail2  = $ProfileCol['vchEmail_2'];
  			if (empty($changedEmail))
  			{
  				$changedEmail = $ProfileCol['email_1'];
  			}
  			if (empty($first))
  			{
  				$first = $ProfileCol['first_name'];
  			}
  			if (empty($last))
  			{
  				$last = $ProfileCol['last_name'];
  			}
  			if (empty($group))
  			{
  				$group = $ProfileCol['grp_name'];
  			}
        if ($first != " " or $last != " " or $group != " ")
        {
          $msg2 = "Data was available from an existing profile, when done click the UPDATE button.";	
        } 
        else 
        {
      		$msg2 = "and click the UPDATE button.";
      	}
	     }
 		}
		else
		{
			while($ProfileCol = mysqli_fetch_array( $Emails )) 
			{ 
				// Loop and display each item detail for given session user
    		$changedEmail 	= $ProfileCol['vchEmail'];
	      $admin          = $ProfileCol['chAdmin'];
	//  		$changedPass    = $ProfileCol['vchPassword'];
				$addr1 		      = $ProfileCol['vchAddress1'];
				$addr2 		      = $ProfileCol['vchAddress2'];
				$addr3 		      = $ProfileCol['vchAddress3'];
				$city 		      = $ProfileCol['vchCity'];
				$state 		      = $ProfileCol['vchState'];
				$phone 		      = $ProfileCol['vchPhone'];
				$country 	      = $ProfileCol['vchCountry'];
				$citystphone    = $ProfileCol['tiHide_email'];
				$zip            = $ProfileCol['vchZip'];
 	//  		$regdate        = $ProfileCol['dtRegistered'];
  		  $first          = $ProfileCol['vchFirstName'];
	 	  	$last 		      = $ProfileCol['vchLastName'];
			  $group          = $ProfileCol['vchGroup'];
			  $modate         = $ProfileCol['tsRegModified'];
		  	$changedEmail2  = $ProfileCol['vchEmail_2'];
  			if (empty($changedEmail))
  			{
  				$changedEmail = $ProfileCol['email_1'];
  			}
  			if (empty($first))
  			{
  				$first = $ProfileCol['first_name'];
  			}
  			if (empty($last))
  			{
  				$last = $ProfileCol['last_name'];
  			}
  			if (empty($group))
  			{
  				$group = $ProfileCol['grp_name'];
  			}
				
			}
			$msg1 = "To change information on a Member Profile, make your changes and click the update button";
		}
		$MsgTitle = "Profile Update Page (Admin)";
//		if (empty($first) | empty($last))
//		{
//			$MsgType = "Welcome back! ".$changedEmail." ";
//		}
//		else
//		{
			$MsgType = "Welcome back! ".$sessionName;
//		}
		include $html_files.'profileAdmin.html';
		show_profile_admin($changedEmail,$changedEmail2,$admin,$first,$last,
		             $addr1,$addr2,$addr3,$city,$state,$zip,$country,$phone,$citystphone,
		             $group,$modate);
?>