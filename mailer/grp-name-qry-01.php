<?
//  Local config allows for dynamic definition of file paths and single point for private paths
include "../php/Config.php";

// Connects to member table of contact_mailer Database 
//  Include the db connection script from non public_html location
include PRIVATE_DB."dbConfig.php";

$groupArray = mysqli_query($link, "SELECT distinct(grp_name) FROM ".$tbl_name3." 
                                   union distinct
                                   SELECT distinct(vchGroup) from ".$tbl_name2."         
                                     order by 1;") 
              or die('grp-name-qry-01.php- '.mysqli_error($link).'grp-name-qry-01.php Error on Select of Emails Union distinct Profile table.');
while($groupRow = mysqli_fetch_array( $groupArray )) 
{ 
	// Loop and display each item detail for given email group
	$grpOptions[] = $groupRow['grp_name'];
	
}

?> 