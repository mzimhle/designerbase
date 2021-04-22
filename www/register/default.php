<?php
/* Add this on all pages on top. */
set_include_path($_SERVER['DOCUMENT_ROOT'].'/'.PATH_SEPARATOR.$_SERVER['DOCUMENT_ROOT'].'/library/classes/');
/*** Standard includes */
require_once 'config/database.php';
require_once 'config/smarty.php';
require_once 'includes/auth.php';
if(isset($zfsession->identity) && trim($zfsession->identity) != '') {
    header('Location: /');
    exit;
} 
/* Class files. */
require_once 'class/participant.php';
/* Objects. */
$participantObject	= new class_participant();
/* Check posted data. */
if(count($_POST) > 0) {

	$errorArray	= array();
	$data		= array();
	
	if(isset($_POST['participant_name']) && trim($_POST['participant_name']) == '') {
		$errorArray[] = 'Please add a name';	
	}

	if(isset($_POST['participant_number']) && trim($_POST['participant_number']) == '') {
		$errorArray[] = 'Please add a number';	
	}

	if(isset($_POST['participant_email']) && trim($_POST['participant_email']) == '') {
		$errorArray[] = 'Please add an email';	
	} else if($participantObject->validateEmail(trim($_POST['participant_email'])) == '') {
		$errorArray[] = 'Please add a valid email address';	
	} else {
		$emailData = $participantObject->getByEmail(trim($_POST['participant_email']));
		
		if($emailData) {
			$errorArray[] = 'Email has already been used';	
		}
	}

	if(count($errorArray) == 0) {

		$data						= array();			
		$data['participant_name']	= trim($_POST['participant_name']);					
		$data['participant_email']	= trim($_POST['participant_email']);
		$data['participant_number']	= trim($_POST['participant_number']);

		$success = $participantObject->insert($data);				

		if($success) {
			$smarty->assign('success', $success);	
		} else {
			$errorArray[] = 'You may have not been added.';	
			$errorArray[] = 'Email was not sent.';	
			$errorArray[] = 'Template was not created for registration.';
		}
	}
	/* if we are here there are errors. */
	$smarty->assign('errors', implode('<br />', $errorArray));	
}
/* Display the template */	
$smarty->display('register/default.tpl');
?>