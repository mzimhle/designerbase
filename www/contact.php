<?php
/* Add this on all pages on top. */
set_include_path($_SERVER['DOCUMENT_ROOT'].'/'.PATH_SEPARATOR.$_SERVER['DOCUMENT_ROOT'].'/library/classes/');

/*** Standard includes */
require_once 'config/database.php';
require_once 'config/smarty.php';
/* objects. */
require_once 'class/enquiry.php';

$enquiryObject	= new class_enquiry();

/* Check posted data. */
if(count($_POST) > 0) {

	$errorArray	= array();
	$data		= array();

	if(isset($_POST['enquiry_name']) && trim($_POST['enquiry_name']) == '') {
		$errorArray[] = 'Please add a name';	
	}

	if(isset($_POST['enquiry_message']) && trim($_POST['enquiry_message']) == '') {
		$errorArray[] = 'Please add a message';
	}
	
	if(isset($_POST['enquiry_email']) && trim($_POST['enquiry_email']) == '') {
		$errorArray[] = 'Please add an email';	
	} else if($enquiryObject->validateEmail(trim($_POST['enquiry_email'])) == '') {
		$errorArray[] = 'Please add a valid email address';
	}

	if(count($errorArray) == 0) {

		$data						= array();			
		$data['enquiry_name']		= trim($_POST['enquiry_name']);					
		$data['enquiry_message']	= trim($_POST['enquiry_message']);
		$data['enquiry_email']		= trim($_POST['enquiry_email']);	

		$success = $enquiryObject->insert($data);				
		/* Check if its successfully added. */
		if($success) {
			/* Get the enquiry's details. */
			$enquiryData = $enquiryObject->getByCode($success);			
			/* Check if it exists. */
			if($enquiryData) {
				/* Send an email. */
				$templateData = $enquiryObject->_template->getTemplate('ENQUIRY', 'CONTACT', 'EMAIL');
				/* Check if email template exists. */
				if($templateData) {
					/* Details to add on the email */
					$recepient							= array();
					$recepient['recipient_name']		= $enquiryData['enquiry_name'];
					$recepient['recipient_email']		= $enquiryData['enquiry_email'];
					$recepient['recipient_cellphone']	= $enquiryData['enquiry_number'];
					$recepient['recipient_reference']	= $enquiryData['enquiry_code'];
					$recepient['recipient_type']		= 'ENQUIRY';
					$recepient['recipient_code']		= $enquiryData['enquiry_code'];
					/* Email to send to people. */
					$emails[] = array('name' => $enquiryData['enquiry_name'], 'email' => $enquiryData['enquiry_email']);
					$emails[] = array('name' => 'DesignerBase', 'email' => 'info@designerbase.co.za');
					/* Send the email. */
					$success = $enquiryObject->_comm->sendEmail($recepient, $templateData, $emails);
					/* Check if email is sent. */
					if($success) {
						/* Check if email is sent. */
						$errorArray[] = 'Enquiry was saved but no confirmation was sent to you';
					}
				} else {
					/* There was no template for this. */
					$errorArray[] = 'Enquiry was saved but no confirmation was sent to you';
				}
			} else {
				/* There is no enquiry details. */
				$errorArray[] = 'Enquiry was not properly added, please contact us on info@designerbase.co.za or retry.';
			}
		} else {
			/* enquiry was not successfully added. */
			$errorArray[] = 'Enquiry was not properly added, please contact us on info@designerbase.co.za or retry.';
		}
		/* Check if all is well. */
		if(count($errorArray) == 0) {
			$smarty->assign('success', $success);	
		}
	}

	$errors = implode('<br />', $errorArray);
	/* if we are here there are errors. */
	$smarty->assign('errorArray', $errors);	
}
/* Display the template */	
$smarty->display('contact.tpl');
?>