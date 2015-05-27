<?php

//define the receiver of the email
$to = $email;

//define the subject of the email
$subject = 'Registration Confirmation'; 

//create a boundary string. It must be unique 
//so we use the MD5 algorithm to generate a random hash
$random_hash = md5(date('r', time())); 

//define the headers we want passed. Note that they are separated with \r\n
$headers = "From: ".$regemailaddr."\r\nReply-To: $email ";

//add boundary string and mime type specification
$headers .= "\r\nContent-Type: multipart/alternative; boundary=\"PHP-alt-".$random_hash."\""; 

//define the body of the message.
ob_start(); //Turn on output buffering
?>
--PHP-alt-<?php echo $random_hash; ?>  
Content-Type: text/plain; charset="iso-8859-1" 
Content-Transfer-Encoding: 7bit

Welcome to the <?php echo ($regemailtitle) ?>!
You have successfully registered under:
	Email:<?php echo ($email) ?>
	
You have received this email because you or the Caritas Lay Fraternities has provided your email information to a website administered by bolitech.com.
The information provided resides in a secure server hosted by bolitech.com.  This information will only be used 
for the purpose of distributing, to you the above holder of the email provided, any information or communication relevant
to the website using these services.  If you have received this email in error or if you have not registered the above email
address for these services, please reply to this email so that your email can be removed from our database.  If you have
registered your email with a website hosted by bolitech.com and wish to unsubscribe from these services, please logon to 
the website providing this service and unsubscribe the email under "MyProfile" section.  Bolitech.com and the service rendered
make no claim of ownership to the information you have provided and stored on our servers.  You are the sole owner of such data 
and can request removal of this data from our database if you find the acquisition of such data to infringe on your privacy 
or rights to such privacy.  Bolitech.com makes every effort to secure such data under current standards of internet security.  
Bolitech.com through receipt of this email relinquishes any liability resulting from illegal or unauthorized access to your data 
stored on our leased servers.

--PHP-alt-<?php echo $random_hash; ?>  
Content-Type: text/html; charset="iso-8859-1" 
Content-Transfer-Encoding: 7bit

<h2>Welcome to the <?php echo ($regemailtitle) ?>! </h2>
<p>You have successfully registered under:<b>
	Email:  <?php echo ($email) ?>. </b></p> 
	
<font size=1><p>
You have received this email because you or the Caritas Lay Fraternities has provided your email information to a website administered by bolitech.com.
The information provided resides in a secure server hosted by bolitech.com.  This information will only be used 
for the purpose of distributing, to you the above holder of the email provided, any information or communication relevant
to the website using these services.  If you have received this email in error or if you have not registered the above email
address for these services, please reply to this email so that your email can be removed from our database.  If you have
registered your email with a website hosted by bolitech.com and wish to unsubscribe from these services, please logon to 
the website providing this service and unsubscribe the email under "MyProfile" section.  Bolitech.com and the service rendered
make no claim of ownership to the information you have provided and stored on our servers.  You are the sole owner of such data 
and can request removal of this data from our database if you find the acquisition of such data to infringe on your privacy 
or rights to such privacy.  Bolitech.com makes every effort to secure such data under current standards of internet security.  
Bolitech.com through receipt of this email relinquishes any liability resulting from illegal or unauthorized access to your data 
stored on our leased servers. </p>	

--PHP-alt-<?php echo $random_hash; ?>--
<?
//copy current buffer contents into $message variable and delete current output buffer
$message = ob_get_clean();
//send the email
$mail_sent = mail( $to, $subject, $message, $headers );
//if the message is sent successfully print "Mail sent". Otherwise print "Mail failed" 
// echo ($mail_sent);
// echo $mail_sent ? "Mail sent" : "Mail failed";
?>