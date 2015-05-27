<?php

// includes to use PEAR mime functionality
include 'Mail.php';
include 'Mail/mime.php';
include('Mail/mail.php');     // adds the enhanced send function 

//set the text variable
$text = 'Welcome to the '.$regemailtitle.'!
You have successfully registered Email:'.$email.'
	
You have received this communication because you have provided your email information to a website administered by bolitech.com.
The information provided resides on a secured server hosted by bolitech.com.  This information will only be used 
for the purpose of distributing, to you the above holder of the email provided, any information or communication relevant
to the website using these services.  If you have received this email in error or if you have not registered the above email
address for these services, please reply to this email so that it can be removed from our database.  If you have
registered your email with a website hosted by bolitech.com and wish to unsubscribe from these services, please logon to 
the website providing this service and unsubscribe the email under "MyProfile" section.  Bolitech.com and the service rendered
make no claim of ownership to the information you have provided and stored on our servers.  You are the sole owner of such data 
and can request removal of this data from our database at any time if you find the acquisition of such data to infringe on your privacy 
or rights to such privacy.  Bolitech.com makes every effort to secure such data under current standards of internet security.  
Bolitech.com through delivery of this communication relinquishes any liability resulting from illegal or unauthorized access to your data 
stored on our leased servers.';

// set the html variable
$html = '<html><body><h2>Welcome to the '.$regemailtitle.'! </h2>
<p>You have successfully registered <b>Email:  '.$email.'. </b></p> 
	
<font size=2><p>
You have received this communication because you have provided your email information to a website administered by bolitech.com.
The information provided resides on a secured server hosted by bolitech.com.  This information will only be used 
for the purpose of distributing, to you the above holder of the email provided, any information or communication relevant
to the website using these services.  If you have received this email in error or if you have not registered the above email
address for these services, please reply to this email so that it can be removed from our database.  If you have
registered your email with a website hosted by bolitech.com and wish to unsubscribe from these services, please logon to 
the website providing this service and unsubscribe the email under "MyProfile" section.  Bolitech.com and the service rendered
make no claim of ownership to the information you have provided and stored on our servers.  You are the sole owner of such data 
and can request removal of this data from our database if you find the acquisition of such data to infringe on your privacy 
or rights to such privacy.  Bolitech.com makes every effort to secure such data under current standards of internet security.  
Bolitech.com through delivery of this communication relinquishes any liability resulting from illegal or unauthorized access to your data 
stored on our leased servers. </p></body></html>';

// set file (not currently used)
//$file = '/home/bolitech/example.php';

// set crlf
$crlf = "\r\n";

//define the receiver of the email
$to = $email;

//define the subject of the email
$subject = 'Registration Confirmation'; 

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
?>