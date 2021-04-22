<?php
/* Add this on all pages on top. */
set_include_path($_SERVER['DOCUMENT_ROOT'].'/'.PATH_SEPARATOR.$_SERVER['DOCUMENT_ROOT'].'/library/classes/');

/*** Standard includes */
require_once 'config/database.php';
require_once 'config/smarty.php';

require_once 'class/participant.php';

$participantObject	= new class_participant();

/* Check posted data. */
if(count($_POST) > 0) {

	$errorArray	= array();

	if(isset($_POST['participant_email']) && trim($_POST['participant_email']) == '') {
		$errorArray[] = 'Please add an email';	
	} else if($participantObject->validateEmail(trim($_POST['participant_email'])) == '') {
		$errorArray[] = 'Please add a valid email address';	
	} else {
		$emailData = $participantObject->getByEmail(trim($_POST['participant_email']));
		
		if(!$emailData) {
			$errorArray[] = 'Email does not exist, please try another one';	
		} else {
			/* Send an email. */
			$smarty->smarty('success', 1);
		}
	}
	$errors = implode('<br />', $errorArray);
	/* if we are here there are errors. */
	$smarty->assign('errorArray', $errors);	
}


/* Display the template */	
$smarty->display('password.tpl');
?>