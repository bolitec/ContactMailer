<?php 
// Load the DB configuration file
// Connects to the Database 
//  Local config allows for dynamic definition of file paths and single point for private paths
//include "Config.php";

// Connects to member table of contact_mailer Database 
//  Include the db connection script from non public_html location
include PRIVATE_DB."dbConfig.php";


// Display the top portion of the page that will display the emails that were sent content
$MsgTitle = "Email Send Results (Admin)";
$MsgType1 = "jclm-email-qry-01.php Msg";
//$MsgType2 = " ";
//$Msg1 = "Please see below that list of emails that were sent,";
//$Msg2 = "successfully or unsucessfully your email communication, Thank you.";
include $mailer_files.'displayResultHdr.html';

//define the receiver of the email
$emailGrp = $_POST['EmailGroup'];
$emailAll = $_POST['SendAll'];

// Check for Send All email checkbox
if ($emailAll == "Yes")
{
	$emailArray = mysqli_query($link, "SELECT email_1, email_2 FROM ".$tbl_name3." ") 
	              or die('-emailSend.php- '.mysql_error($link).' emailSend.php Error on Select of Emails table.');
}
else
{
	$emailArray = mysqli_query($link, "SELECT email_1, email_2 FROM ".$tbl_name3." where grp_name = '$emailGrp'") 
	              or die('-emailSend.php- '.mysql_error($link).' emailSend.php Error on Select of Emails table.');
}
while($emailRow = mysqli_fetch_array( $emailArray )) 
{ 
	// Loop and display each item detail for given email group
	$to = $emailRow['email_1'];

    if ($emailRow['email_2'] != "" )
	{
		$to .= ",".$emailRow['email_2'] ;
		//send the email using Pear Mail_Mime functions
		//$mail_sent = @mail( $to, $subject, $message, $headers );
		$mail->send($to, $hdrs, $body);
 
		//if the message is sent successfully print "Mail sent". Otherwise print "Mail failed" 
    include $mailer_files.'displayResultDtl.html';
	} 
	else
	{
		//send the email using Pear Mail_Mime functions
		//$mail_sent = @mail( $to, $subject, $message, $headers ); 
		$mail->send($to, $hdrs, $body);

		//if the message is sent successfully print "Mail sent". Otherwise print "Mail failed" 
    include $mailer_files.'displayResultDtl.html';
    }
}
include $mailer_files.'displayResultFtr.html';
exit();
?> 
