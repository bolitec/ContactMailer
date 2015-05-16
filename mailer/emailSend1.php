<?php
//Load the file from a specific location for now.  Later this will be a dynamic select
// $myFile = "/home/lbolivar/caritas/JC-NA-10-Boston.doc";
// Check to make sure we have a file 
if ( !$_FILES['pdf_file']['name'] )
{ 
	//trigger_error( 'Sorry, you have to choose a PDF file to upload', E_USER_ERROR ); 
	include $mailer_files.'displayResultHdr.html';
	$mailer_error = 'emailSend1.php - Sorry, you have to choose a PDF file to upload';
	include $mailer_files.'displayErrorDtl.html';
	include $mailer_files.'displayResultFtr.html';
	exit();
} 
if ( false === strpos($_FILES['pdf_file']['type'], 'pdf') ) 
{ 
 	//trigger_error( 'Sorry, you can only attach PDF files', E_USER_ERROR ); 
	include $mailer_files.'displayResultHdr.html';
	$mailer_error = 'emailSend1.php - Sorry, you can only attach PDF files';
	include $mailer_files.'displayErrorDtl.html';
	include $mailer_files.'displayResultFtr.html';
	exit();
} 
if ( !($pdf_file = file_get_contents($_FILES['pdf_file']['tmp_name'])) ) 
{ 
 	//trigger_error( 'Error getting file contents', E_USER_ERROR ); 
	include $mailer_files.'displayResultHdr.html';
	$mailer_error = 'emailSend1.php - Error getting PDF file contents';
	include $mailer_files.'displayErrorDtl.html';
	include $mailer_files.'displayResultFtr.html';
	exit();
}

//Check whether the form has been submitted
if (array_key_exists('check_submit', $_POST)) {
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
	
	// $subject = 'ExportFile'; 
	$sender = $_POST['Name'];
	
	//Load the subject of the email form
	// $subject = 'ExportFile'; 
	$subject = $_POST['Subject'];

	//define the headers we want passed. Note that they are separated with \r\n 
	$sEmail = $_POST['Semail'];
	
	//  Build the headers , body and send email.
	$hdrs = array( 'From' => $sEmail, 'Subject' => $subject);

	// Load the body, attachment and headers before sending email
	$mime = new Mail_mime($crlf);

	// Load text body content
	$text = $comments;
	$mime->setTXTBody($text);

	// Load html body content
	$html = "<html><body><p>".$comments."</p></body></html>";
	$mime->setHTMLBody($html);


	//Prepare parameters for Attachment function
	$file_name = $_FILES['pdf_file']['name'];
	$content_type = "Application/pdf";
	$mime->addAttachment($pdf_file, $content_type, $file_name, 0);
               
	//do not try to call these lines in reverse order
	$body = $mime->get();
	$hdrs = $mime->headers($hdrs);

	$mail =& Mail::factory('mail','-f '.$sEmail);
 
	// Run select query to send mass mail to all or some members in the JCLM Emails table.
	include $secured_php.'jclm-email-qry-01.php';
} 
else
{
	//echo "You can't see this page without submitting the form.";
	include $mailer_files.'displayResultHdr.html';
	$mailer_error = 'emailSend1.php - You can\'t see this page without submitting the form.';
	include $mailer_files.'displayErrorDtl.html';
	include $mailer_files.'displayResultFtr.html';
	//exit();
}
?>
