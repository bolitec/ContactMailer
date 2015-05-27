<?php
//  This script first checks to see if the logon information is contained in a session on the web server.
//  If it is, it tries to log them in. If this is successful they are redirected to the members area.
//  If there is no session, it allows them to logon.
//  If logon form has not been posted, it shows them the logon form.

//  Local config allows for dynamic definition of file paths and single point for private paths
include "Config.php";
$email = null;
$passcode = null;

if (isset ($_GET['email']) || isset($_GET['passcode']) || isset($_POST['passcode'])){
	if (isset ($_GET['email'])){
		$email = $_GET['email'];
	}
	if (isset($_GET['passcode']) ){
		$passcode = $_GET['passcode'];
	}
	if (isset($_POST['passcode'])){
		$passcode = $_POST['passcode'];
		$email = $_POST['email'];
	}
	
	// Connects to member table of contact_mailer Database
	//  Include the db connection script from non public_html location
	include PRIVATE_DB."dbConfig.php";
	
	// Get encrypted password as reset code
	include $secured_php.'sql_reset_pass.php';
	
} else {
	$MsgTitle = "Logon Message Page";
	$redirect = "Logon.php";
	$MsgType1 = "ResetPassEmail.php";
	$MsgType2 = "Message RPE-001";
	$Msg1 = "Invalid attempt to call ResetPassEmail script.";
	$Msg2= "Click the Logon button below to re-establish your session";
	$button = "Logon";
	include $html_files.'logonMsg.html';
	unset($_POST['logon']);
	exit();
}

// includes to use PEAR mime functionality
include 'Mail.php';
include 'Mail/mime.php';
include('Mail/mail.php');     // adds the enhanced send function

//set the text variable
$text = 'Welcome to the '.$regemailtitle.'!
You have requested to reset your password for Email:'.$email.'

Please copy the link provided to your browser in order to perform password reset
 '.$reset_url;

// set the html variable
$html = '<html><body><h2>Welcome to the '.$regemailtitle.'! </h2>
<p>You have requested to reset your password for Email:  '.$email.'. </p>

<p>Please click on the link provided to change your password
		<a href="'.$reset_url.'" > Reset Your Password Here.</a></p>
<p>If you did not request this change, please reply to our webmaster and report the incident.  
We do our best to prevent spam and secure our server and application to prevent unwanted email.</p>
<p>Thank you!</p>
<p>From the Contact Mailer App Team</p>				
</body></html>';

// set file (not currently used)
//$file = '/home/bolitech/example.php';

// set crlf
$crlf = "\r\n";

//define the receiver of the email
$to = $email;

//define the subject of the email
$subject = 'Password Reset Request';

// build headers array
$hdrs = array( 'From' => $regemailaddr,
		'Subject' => $subject,
);


$mime = new Mail_mime($crlf);

$mime->setTXTBody($text);
$mime->setHTMLBody($html);
//$mime->addAttachment($file,'text/plain');
 
//do not try to call these lines in reverse order
$body = $mime->get();
$hdrs = $mime->headers($hdrs);

$mail =& Mail::factory('mail','-f '.$regemailaddr);
$mail->send($to, $hdrs, $body);

$MsgTitle = "LogonMsg Page";
$redirect = "Logon.php";
$MsgType1 = "ResetPassEmail.php";
$MsgType2 = "Message RPE-001";
$Msg1 = "Please check your email inbox for instructions on how to proceed with password reset.";
$Msg2= "If you did not receive an email forward inquiries to ".$regemailaddr."";
$button = "Logon";
include $html_files.'logonMsg.html';
unset($_POST['logon']);
exit();

?>