<?php
/* Add this on all pages on top. */
set_include_path($_SERVER['DOCUMENT_ROOT'].'/'.PATH_SEPARATOR.$_SERVER['DOCUMENT_ROOT'].'/library/classes/');

/*** Standard includes */
require_once 'config/database.php';
require_once 'config/smarty.php';
/*** Check for login */
require_once 'includes/auth.php';
/* objects. */
require_once 'class/participant.php';

$participantObject	= new class_participant();

if (isset($_GET['code']) && trim($_GET['code']) != '') {
	
	$code = trim($_GET['code']);
	
	$participantData = $participantObject->getByCode($code);
	
	if($participantData) {
		$smarty->assign('participantData', $participantData);
	} else {
		header('Location: /participant/');
		exit;		
	}
}

/* Check posted data. */
if(count($_POST) > 0) {

	$errorArray	= array();
	$data		= array();
	
	if(isset($_POST['participant_name']) && trim($_POST['participant_name']) == '') {
		$errorArray['participant_name'] = 'Please add a name';	
	}

	if(isset($_POST['areapost_code']) && trim($_POST['areapost_code']) == '') {
		$errorArray['areapost_code'] = 'Please add an area location';	
	}
	
	if(isset($_POST['participant_address']) && trim($_POST['participant_address']) == '') {
		$errorArray['participant_address'] = 'Please add an address';	
	}
	
	if(isset($_POST['participant_password']) && trim($_POST['participant_password']) == '') {
		$errorArray['participant_password'] = 'Please add a password';	
	}

	if(isset($_POST['participant_email']) && trim($_POST['participant_email']) != '') {
        if($participantObject->validateEmail(trim($_POST['participant_email'])) == '') {
    		$errorArray['participant_email'] = 'Please add a valid email address';	
    	} else {
    		$itemcode = isset($participantData) ? $participantData['participant_code'] : null;
    
    		$emailData = $participantObject->getByEmail(trim($_POST['participant_email']), $itemcode);
    		
    		if($emailData) {
    			$errorArray['participant_email'] = 'Email has already been used';	
    		}
    	}
	}

    if(isset($_POST['participant_email'])) {
        if(trim($_POST['participant_email']) == '') {
            if(isset($_POST['participant_number'])) {
                if(trim($_POST['participant_number']) == '') {
                    $errorArray['participant_email'] = 'Please add a cellphone number or an email address';
                }
            }
        }
    }

	if(count($errorArray) == 0) {

		$data							= array();			
		$data['participant_name']		= trim($_POST['participant_name']);					
		$data['participant_email']		= trim($_POST['participant_email']);
		$data['participant_number']		= trim($_POST['participant_number']);
		$data['participant_password']	= trim($_POST['participant_password']);		
		$data['areapost_code']	        = trim($_POST['areapost_code']);		
		$data['participant_address']	= trim($_POST['participant_address']);		
		
		if(!isset($participantData)) {
			$success = $participantObject->insert($data);				
		} else {
		    $data['participant_code']	= trim($participantData['participant_code']);	
			$where	= $participantObject->getAdapter()->quoteInto('participant_code = ?', $participantData['participant_code']);
			$participantObject->update($data, $where);		
			$success 	= $participantData['participant_code'];			
		}

		if(count($errorArray) == 0) {
			header('Location: /participant/');	
			exit;		
		}
	}
	/* if we are here there are errors. */
	$smarty->assign('errorArray', $errorArray);	
}

$smarty->display('participant/details.tpl');

?>