<?php
/* Add this on all pages on top. */
set_include_path($_SERVER['DOCUMENT_ROOT'].'/'.PATH_SEPARATOR.$_SERVER['DOCUMENT_ROOT'].'/library/classes/');
/*** Standard includes */
require_once 'config/database.php';
require_once 'config/smarty.php';
/* Get the URL. */
$array = explode('/',$_SERVER['REQUEST_URI']);
/* Make sure its the correct URL. */
if (isset($array[3]) && trim($array[3]) != '') {
	/* Class files. */
	require_once 'class/participant.php';
	/* Objects. */
	$participantObject	= new class_participant();
	/* Get the code. */
	$code = trim($array[3]);
	/* Get the user. */
	$participantData = $participantObject->getByHash($code, 0);
	/* Check if user exists. */
	if($participantData) {
		/* Data to change. */
		$data						= array();
		$data['participant_active']	= 1;
		/* Add the where for the data. */
		$where		= $participantObject->getAdapter()->quoteInto('participant_code = ?', $participantData['participant_code']);
		$success	= $participantObject->update($data, $where);

		if(!$success) {
			header('Location: /');
			exit;
		}
		/* Send an email. */
		$templateData = $participantObject->_template->getTemplate('ACTIVATED', 'PARTICIPANT', 'EMAIL');
		/* Check if email template exists. */
		if($templateData) {
			/* Details to add on the email */
			$recepient							= array();
			$recepient['recipient_name']		= $participantData['participant_name'];
			$recepient['recipient_email']		= $participantData['participant_email'];
			$recepient['recipient_type']		= 'PARTICIPANT';
			$recepient['recipient_code']		= $participantData['participant_code'];
			$recepient['recipient_password']	= $participantData['participant_password'];
			/* Email to send to people. */
			$emails[] = array('name' => $participantData['participant_name'], 'email' => $participantData['participant_email']);
			/* Send the email. */
			$success = $participantObject->_comm->sendEmail($recepient, $templateData, $emails);
			/* Check if email has been sent. */
			if($success) {
				$smarty->assign('loginEmail', 'An email with your password has been successfully sent to your email address of <span class="green"><b>'.$participantData['participant_email'].'</b></span>.');
			} else {
				$smarty->assign('loginEmail', '<span class="red">We could not send you and email with your log in details, please contact us on <b>info@designerbase.co.za.</b></span>');
			}
		}
		$smarty->assign('participantData', $participantData);
	} else {
		header('Location: /');
		exit;
	}
} else {
	header('Location: /');
	exit;
}
/* Display the template */	
$smarty->display('register/activate.tpl');
$array = $participantObject = $participantData = $code = $data = $where;
?>