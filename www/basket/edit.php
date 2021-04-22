<?php
/* Add this on all pages on top. */
set_include_path($_SERVER['DOCUMENT_ROOT'].'/'.PATH_SEPARATOR.$_SERVER['DOCUMENT_ROOT'].'/library/classes/');

/*** Standard includes */
require_once 'config/database.php';
require_once 'config/smarty.php';
/* Get global sessions. */
require_once 'includes/auth.php';

require_once 'class/participant.php';

$participantObject = new class_participant();

/* POST */
if(count($_POST) > 0) {
	/* The output */
	$output		= array();
	/* Validation. */
	for($i = 0; $i < count($zfsession->basket); $i++) {
		/* Get into each item of the basket. */
		$catalog = $zfsession->basket[$i];
		/* Validate the quantity. */
		if(!isset($_POST['quantity_'.$catalog['catalog_code']])) {
			$output[] = 'Please add a quantity.';
		} else if((int)trim($_POST['quantity_'.$catalog['catalog_code']]) == 0) {
			$output[] = 'Quantity is required on the '.$catalog['catalog_name'].' item';
		} else {
			/* We have a quantity. */
			$zfsession->basket[$i]['basket_quantity']   = (int)trim($_POST['quantity_'.$catalog['catalog_code']]);
			$zfsession->basket[$i]['basket_text']       = trim($_POST['text_'.$catalog['catalog_code']]);
		}
	}
    /* Check participant's details. */
    if(!isset($zfsession->participant)) {
        /* Register participant and check for their details. */
    	if(!isset($_POST['participant_name'])) {
    		$errorArray[] = 'Please add a name';	
    	} else if(trim($_POST['participant_name']) == '') {
    	   $errorArray[] = 'Please add a name'; 
    	}
    
    	if(!isset($_POST['participant_number'])) {
    		$errorArray[] = 'Please add a number';	
    	} else if($participantObject->validateNumber(trim($_POST['participant_number'])) == '') {
    	    	$errorArray[] = 'Please add a valid South African cellphone number';	
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
    }
    	
	if(!isset($_POST['participant_address'])) {
		$errorArray[] = 'Please add an address';	
	} else if(trim($_POST['participant_address']) == '') {
		$errorArray[] = 'Please add an address';	
	}
	
	if(!isset($_POST['areapost_code'])) {
		$errorArray[] = 'Please add a city, town or surburb';	
	} else if(trim($_POST['areapost_code']) == '') {
		$errorArray[] = 'Please add a city, town or surburb';		
	}
	
	if(count($errorArray) == '') {
	    /* check if registration is needed. */
	    if(!isset($zfsession->participant)) {
	        /* Add new participant. */
    		$data						= array();			
    		$data['participant_name']	= trim($_POST['participant_name']);					
    		$data['participant_email']	= trim($_POST['participant_email']);
    		$data['participant_number']	= trim($_POST['participant_number']);

    		$data['areapost_code']	        = trim($_POST['areapost_code']);
            $data['participant_address']    = trim($_POST['participant_address']);

    		$zfsession->identity = $participantObject->insert($data);

	    } else {
	        /* Update new details. */
    		$data['areapost_code']	        = trim($_POST['areapost_code']);
            $data['participant_address']    = trim($_POST['participant_address']);
    		/* Add the where for the data. */
    		$where		= $participantObject->getAdapter()->quoteInto('participant_code = ?', $zfsession->identity);
    		$success	= $participantObject->update($data, $where);
    		$success    = $zfsession->identity;
	    }
	    $zfsession->participant = $participantObject->getByCode($success);
	}
	/* Check if all is well. */
	if(count($output) == 0) {
		header('Location: /basket/edit');
		exit;
	} else {
		/* if we are here there are errors. */
		$smarty->assign('output', implode('<br />', $output));		
	}
}

/* Display the template */	
$smarty->display('basket/edit.tpl');
?>