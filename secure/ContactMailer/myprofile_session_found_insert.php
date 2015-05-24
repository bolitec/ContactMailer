<?php
		$MyProfile = mysqli_query($link,"SELECT * FROM ".$tbl_name2." P join ".$tbl_name." M on P.vchEmail = M.vchEmail 
								WHERE '$sessionEmail' = P.vchEmail ") 
								or die('-MyProfile.php (select on Profile table failed)- '.mysqli_error().'');
		//Gives error if user doesn't exist
		$check3 = mysqli_affected_rows($link);
		if ($check3 == 0)
		{
			if(!mysqli_query($link,"insert into ".$tbl_name2." values
				(0,'$sessionEmail','$first','$last','$addr1','$addr2','$addr3','$city','$state','$phone','','',0,'$country',0,'','','','','','','')")) 
			{
        $msg1 = "The following error and error# were returned";
				if (mysqli_errno() == 1062)
				{
					// echo mysql_errno().": duplicate key error returned from MySQL";
  				$msg2 = mysqli_errno().": duplicate key error returned from MySQL";
				}
				else
				{
					// echo mysql_errno().": error returned from MySQL";
					$msg2 = mysqli_errno().": error returned from MySQL";
				}
   			$MsgType = "We had a problem adding this profile! ".$sessionName;
		    include $html_files.'myprofile.html';
		    show_profile($changedEmail,$changedEmail2,$changedPass,$first,$last,
		             $addr1,$addr2,$addr3,$city,$state,$zip,$country,$phone,$citystphone,
		             $group,$regdate,$modate);
		    exit;
			}
			$msg1 = "If this is your first time in your Profile please update your personal information,";

  		$MyLogon = mysqli_query($link, "SELECT * FROM ".$tbl_name." M left join ".$tbl_name3." E on M.vchEmail = E.email_1  
								WHERE '$sessionEmail' = M.vchEmail ") 
								or die('-MyProfile.php (select Member logon info)- '.mysqli_error().'');
	  	while($LogonUpdates = mysqli_fetch_array( $MyLogon )) 
		  { 
  			// Loop and display each item detail for given member logon
    		$changedEmail 	= $LogonUpdates['vchEmail'];
      	$changedPass    = $LogonUpdates['vchPassword'];
  			$regdate        = $LogonUpdates['dtRegistered'];
   		  $first          = $LogonUpdates['first_name'];
  	 		$last 		      = $LogonUpdates['last_name'];
  			$group          = $LogonUpdates['grp_name'];
  			$changedEmail2  = $LogonUpdates['email_2'];
  			$email_1        = $LogonUpdates['email_1'];
        if ($email_1 != "" )
        {
          $msg2 = "Data was available from an existing Emails record, when done click the UPDATE button: ".$email_1;	
        } 
        else 
        {
         // if the Emails=$table_name3 row did not exist create it now. On error display error.
			   if(!mysqli_query($link,"insert into ".$tbl_name3." values
				   (0,'','','','$changedEmail','')")) 
			   {
            $msg1 = "The following error and error# were returned";
				    if (mysqli_errno() == 1062)
				    {
			   	     // echo mysql_errno().": duplicate key error returned from MySQL";
  	   		     $msg2 = mysqli_errno().": duplicate key error returned from MySQL";
	   			  }
   				  else
		        {
				     	// echo mysql_errno().": error returned from MySQL";
				     	$msg2 = mysqli_errno().": error returned from MySQL";
			   	  }
   		   	  $MsgType = "We had a problem adding this Email! ".$sessionName;
		        include $html_files.'myprofile.html';
		        show_profile($changedEmail,$changedEmail2,$changedPass,$first,$last,
		                $addr1,$addr2,$addr3,$city,$state,$zip,$country,$phone,$citystphone,
		                $group,$regdate,$modate);
		         exit;
          }
      		$msg2 = "and click the UPDATE button.";
      	}
	     }
 		}
		else
		{
			while($Updates = mysqli_fetch_array( $MyProfile )) 
			{ 
				// Loop and display each item detail for given session user
    		$changedEmail 	= $Updates['vchEmail'];
	  		$changedPass    = $Updates['vchPassword'];
				$addr1 		      = $Updates['vchAddress1'];
				$addr2 		      = $Updates['vchAddress2'];
				$addr3 		      = $Updates['vchAddress3'];
				$city 		      = $Updates['vchCity'];
				$state 		      = $Updates['vchState'];
				$phone 		      = $Updates['vchPhone'];
				$country 	      = $Updates['vchCountry'];
				$citystphone    = $Updates['tiHide_email'];
				$zip            = $Updates['vchZip'];
 	  		$regdate        = $Updates['dtRegistered'];
  		  $first          = $Updates['vchFirstName'];
	 	  	$last 		      = $Updates['vchLastName'];
			  $group          = $Updates['vchGroup'];
			  $modate         = $Updates['tsRegModified'];
		  	$changedEmail2  = $Updates['vchEmail_2'];
				
			}
			$msg1 = "To change information in your Profile please update any field below,";
		}
		$MsgTitle = "MyProfile Update Page";
		if (empty($first) | empty($last))
		{
			$MsgType = "Welcome back! ".$changedEmail." ";
		}
		else
		{
			$MsgType = "Welcome back! ".$first." ".$last;
		}
		include $html_files.'myprofile.html';
		show_profile($changedEmail,$changedEmail2,$changedPass,$first,$last,
		             $addr1,$addr2,$addr3,$city,$state,$zip,$country,$phone,$citystphone,
		             $group,$regdate,$modate);
?>