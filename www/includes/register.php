<?php
/* Add this on all pages on top. */
set_include_path($_SERVER['DOCUMENT_ROOT'].'/'.PATH_SEPARATOR.$_SERVER['DOCUMENT_ROOT'].'/library/classes/');

require_once 'config/database.php';
/* Auth for the entire website. */
require_once 'includes/auth.php';

global $smarty;

/* Check posted data. */
if(count($_POST) > 0 && isset($_POST['register_form'])) {

	require_once 'class/participant.php';

	$participantObject	= new class_participant();
	$errorArray			= array();
	$data				= array();

	if(isset($_POST['participant_name']) && trim($_POST['participant_name']) == '') {
		$errorArray[] = 'Please add a name';	
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
		$data							= array();			
		$data['participant_name']		= trim($_POST['participant_name']);					
		$data['participant_email']		= trim($_POST['participant_email']);

		$success = $participantObject->insert($data);
		
		if($success) {
			$smarty->assign('success', $success);
		} else {
			$errorArray[] = 'We could not add your profile or ';	
			$errorArray[] = 'Email could not be sent out or ';	
			$errorArray[] = 'No template has been added.';	
		}
	}

	$showerrors = implode('<br />', $errorArray);
	/* if we are here there are errors. */
	$smarty->assign('errorArray', $showerrors);
	/* Clear */
	$participantObject = $errorArray = $data = $emailData = $showerrors = $success = null;
	unset($participantObject, $errorArray, $data, $emailData, $showerrors, $success);
}
/* Display the template */	
$smarty->display('includes/register.tpl');
?>