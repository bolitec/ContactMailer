<?php
//Check whether the form has been submitted
if (array_key_exists('check_submit', $_POST)) 
{
	// Mail_Mime PEAR functions used in emailer scripts
	include 'Mail.php';
	include 'Mail/mime.php';
	$crlf = "\r\n";
    
	//Converts the new line characters (\n) in the text area into HTML line breaks (the <br /> tag)
	$_POST['Comments'] = nl2br($_POST['Comments']); 

	// strip the slash from all form fields
	$_POST['Comments'] = STRIPSLASHES($_POST['Comments']); 
	$_POST['Name'] = STRIPSLASHES($_POST['Name']); 
	$_POST['Subject'] = STRIPSLASHES($_POST['Subject']); 

	// comments from form to variable
	$comments = $_POST['Comments'];
	
	// Load sender's variable from form. 
	$sender = $_POST['Name'];
	
	//Load the subject of the email from form
	$subject = $_POST['Subject'];

	// Load the senders email from the form 
	$sEmail = $_POST['Semail'];

	//  Build the headers , body and send email.
	$hdrs = array( 'From' => $sEmail, 'Subject' => $subject);

 	// Load the body, attachment and headers before sending email
	$mime = new Mail_mime($crlf);

	// Load txt and html body content
	$text = $comments;
	$text = $text.strip_tags($html_file);
	$mime->setTXTBody($text);
	$html = "<html><body><p>".$comments."</p></body></html>";
	$mime->setHTMLBody($html);
	// $mime->setHTMLBody($html);
	//$mime->addAttachment($file,'text/plain');
               
	//do not try to call these lines in reverse order
	$body = $mime->get();
	$hdrs = $mime->headers($hdrs);

	$mail =& Mail::factory('mail','-f '.$sEmail);
 	
 	// Run select query to send mass mail to all or some members in the JCLM Emails table.
	include $secured_php.'jclm-email-qry-01.php';
} 
else
{
	echo "You can't see this page without submitting the form.";
}
?>
