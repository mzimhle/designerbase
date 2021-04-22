<?php
/* Add this on all pages on top. */
set_include_path($_SERVER['DOCUMENT_ROOT'].'/'.PATH_SEPARATOR.$_SERVER['DOCUMENT_ROOT'].'/library/classes/');

/**
 * Standard includes
 */
require_once 'config/database.php';
require_once 'config/smarty.php';
require_once 'Zend/Session.php';

$zfsession = new Zend_Session_Namespace('BASE_SITE');

require_once 'class/participant.php';
require_once 'class/advert.php';

$participantObject	= new class_participant();
$advertObject		= new class_advert();

if(count($_POST) > 0) {
	
	$username	= (isset($_POST['username'])) ? $_POST['username'] : null;
	$password	= (isset($_POST['password'])) ? $_POST['password'] : null;
	
	$participantData	= $participantObject->login($username, $password);
	$message			= '';

	if($participantData) {
		// Identity exists; store in session
		$zfsession->identity	= $participantData['participant_code'];
		$zfsession->participant	= $participantData;

		header("Location: /");
		exit;
		
	} else {
		$message = 'Incorrect password and/or username, please try again.';
	}

	$smarty->assign('loginmessage', $message);
}

/* Get the advert in the body of the home page. */
$advertVertical = $advertObject->dateRange('RECTVERTICAL', 'SIDEBAR', 'LOGIN');
if($advertVertical) $smarty->assign('advertVertical', $advertVertical);

/* Display the template */	
$smarty->display('login.tpl');
?>