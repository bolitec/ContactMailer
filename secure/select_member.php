<?php
	// Load values from searchForm form for updates to member table
	$first = $_POST['first'];
	$last = $_POST['last'];
	$group = $_POST['group'];
  	$email = $_POST['email'];
  	$approx = $_POST['approx'];
  	$level = $_POST['level'];
    $file = $_POST['file'];
		$today = DATE(c);


// Make sure user accessing this page is a qualified Admin user.
	if (isset($_SESSION['Admin'])){
  		
  		// First thing to check is any blank required fields and provide edit.	
	  	if ((empty($email) and empty($first) and empty($last) and empty($group) and !$approx=="Yes") or
	  	      (empty($approx) and !(empty($level)))){
			$MsgTitle = "Search Member Page (Admin)";
			$MsgType = " ";
			$Msg1 = "At least one search field must have search criteria.";
			$Msg2= "Please select Approximate Search for blank Member Group or partial string searches (%).";
    		
    		// Select distinct groups to fill the drop down list on the send email form
	    	include $mailer_files.'grp-name-qry-01.php';
			include $html_files.'searchMember.html';
			show_profile($email,$first,$last,$group);
			
	  	} else {
	  		// Build search where string dynamically
	  		$where_clause = "where";
	  		$where_clause2 = "where";

        	// This looks at the users selection to search approximate or exact and sets condition in where clause
  			if ($approx=="Yes"){

  				if ($level=="1"){
  				  $eq_like1 = "like '";
  				} else {
  				  $eq_like1 = "like '%";
  				}
  				$eq_like2 = "%'";
  			} else {
  				$eq_like1 = "='";
  				$eq_like2 = "'";
  			}
	  		if (!empty($email)){
				$where_clause = $where_clause." email_1 ".$eq_like1.$email.$eq_like2;
				$where_clause2 = $where_clause2." vchEmail ".$eq_like1.$email.$eq_like2;
  			}
	  		if (!empty($first)){
	  			if ($where_clause=="where"){
					$where_clause = $where_clause." first_name ".$eq_like1.$first.$eq_like2;
					$where_clause2 = $where_clause2." vchFirstName ".$eq_like1.$first.$eq_like2;
	        	} else {
					$where_clause = $where_clause." and first_name ".$eq_like1.$first.$eq_like2;
					$where_clause2 = $where_clause2." and vchFirstName ".$eq_like1.$first.$eq_like2;
	  			}
	  		}
	  		if (!empty($last)){
	  			if ($where_clause=="where"){
					$where_clause = $where_clause." last_name ".$eq_like1.$last.$eq_like2;
					$where_clause2 = $where_clause2." vchLastName ".$eq_like1.$last.$eq_like2;
	  			} else {				
	  				$where_clause = $where_clause. " and last_name ".$eq_like1.$last.$eq_like1;
					$where_clause2 = $where_clause2. " and vchLastName ".$eq_like1.$last.$eq_like1;
				}
			}
			if (!empty($group)){
	  			if ($where_clause=="where"){
					$where_clause = $where_clause." grp_name ".$eq_like1.$group.$eq_like2;
					$where_clause2 = $where_clause2." vchGroup ".$eq_like1.$group.$eq_like2;
	        	} else {
	        		$where_clause = $where_clause." and grp_name ".$eq_like1.$group.$eq_like2;
	        		$where_clause2 = $where_clause2." and vchGroup ".$eq_like1.$group.$eq_like2;
	  		  	}
	  		} else {
				if (empty($group) and $approx=="Yes" and $where_clause=="where"){
					$where_clause = $where_clause." grp_name ='".$group."'";
					$where_clause2 = $where_clause2." vchGroup ='".$group."'";
	  		  	}
	  		}
			$MsgTitle = "Select Member Page (Admin)";
			$redirect = "ProfileAdmin.php";
			$MsgType = " ";
			$Msg1= "Search results for criteria provided below:";
			$Msg2 = $where_clause;
			include $html_files.'selectMemberHdr.html';
			$SearchMember = mysqli_query($link, "SELECT email_1, first_name, last_name, grp_name FROM ".$tbl_name3." ".$where_clause."
    		                               union  distinct
    		                               select vchEmail,'','','' from ".$tbl_name." where '$approx'='Yes'
    		                               union  distinct
    		                               SELECT vchEmail, vchFirstName, vchLastName, vchGroup FROM ".$tbl_name2." ".$where_clause2." order by 3")
								or die('-SearchMember.php (SearchMember select of Emails table failed)- '.mysqli_error().'');
	  	  	$row_nbr = 0;
			while($FoundMember = mysqli_fetch_array( $SearchMember )){ 
				// Loop and display each item detail for given member logon
				$row_nbr        = $row_nbr + 1;
				$emailKey       = $FoundMember['email_1'];
				$email 	        = $FoundMember['email_1'];
				$first          = $FoundMember['first_name'];
				$last 		      = $FoundMember['last_name'];
				$group          = $FoundMember['grp_name'];
				include $html_files.'selectMemberDtl.html';
        	}
			include $html_files.'selectMemberFtr.html';
		}
	} else {
		//if the session does not exist or is not 'Admin', you are taken to the logon screen 
		$MsgTitle = "Select Member Page";
		$redirect = "Logon.php";
		$MsgType1 = "SelectMember.php Warning:";
		$MsgType = "SelectMember.php Warning:";
		$Msg1 = "User sesssion expired or not an 'Admin' user session";
		$Msg2= "Please re-establish credentials with Logon.";
		$button = "Logon";
		include $html_files.'logonMsg.html';
	}
	exit();
?>