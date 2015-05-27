<?php    # Script 1.0 - Help.php
/*
 * This is the help main page.
 * It selects which item from the Table of Contents is selected from Help.html
 * It is devided into Help-hdr.html Help-body.html and Help-ftr.html
 * 
 */

//  Validate what page to show:
if (isset($_GET['helpPage'])){
	$p = $_GET['helpPage'];
} elseif (isset($_POST['helpPage'])){
	$p = $_POST['toc'];
} else {
	$p = NULL;
}

//  Include Help-hdr.html
include('../html/Help-hdr.html');

//  Determine what page to display
//  If Null display default Help Page
if ($p != NULL){
	switch ($p){
		case 'RP1':
			$msg = "The index.html on the ContactMailer home folder defaults to the Logon Page";
			$msg2 = "Note: From the Logon Page a new member can Register or an existing member can reset their password";
			$page = '../images/LogonPage.PNG';
			//  Include Help-body.html
			include('../html/Help-body.html');
			$msg = "To register as a member fill out the fields on the form.";
			$page = '../images/RegisterPage.PNG';
			break;
		
		case 'RP2':
			$msg = "To register as a member fill out all of the required fields on the form.";
			$page = '../images/RegisterPage(Required).PNG';
			$msg2 = "Required fields are identified by an * on the form.";
			break;
		
		case 'RP3':
			$msg = "Your attempt to register has encountered a password mismatch.";
			$page = '../images/Register(PassMismatch).PNG';
			break;
		
		case 'RP4':
			$msg = "The email you attempted to register is already in use.";
			$page = '../images/RegisterPage(EmailinUse).PNG';
			$msg2 = "Click on the reset password link to reset it.";
			break;
					
		case 'LP1':
			$msg = "To Logon to this application enter your email and password and click on the Logon button";
			$page = '../images/LogonPage.PNG';
			//  Include Help-body.html
			include('../html/Help-body.html');
			$msg = "The Logon button will highlight green for easy identification, on hover.";
			$page = '../images/LogonPage(2).PNG';
			$msg2 = "Done";
			break;

		case 'LP2':
			$msg = "The app does not recognize your credentials.  Did you already register as a member?";
			$page = '../images/LogonPage(UNKCredentials).PNG';
			break;
	}
} else {
<<<<<<< HEAD
	$msg = "Welcome to the Help pages for Contact Mailer Web App.  On the test systems all members are Admin once they create a membership and re-establish Logon";
=======
	$msg = "Welcome to the Help pages for Contact Mailer Web App.  Contact the webmaster to set administrative rights for users.<a href='mailto:webmaster@bolitech.com'>webmaster</a> ";
>>>>>>> branch 'master2' of https://github.com/bolitech/ContactMailer.git
	$page = '../images/AdminPage(Welcome).PNG';
}


//  Include Help-body.html
include('../html/Help-body.html');

//  Include Help-ftr.html
include('../html/Help-ftr.html');

?> 
