<?php
/* Add this on all pages on top. */
set_include_path($_SERVER['DOCUMENT_ROOT'].'/'.PATH_SEPARATOR.$_SERVER['DOCUMENT_ROOT'].'/library/classes/');

/*** Standard includes */
require_once 'config/database.php';
require_once 'config/smarty.php';

/*** Check for login */
require_once 'includes/auth.php';

/* objects. */
require_once 'class/supplier.php';

$supplierObject 	= new class_supplier();

if (isset($_GET['code']) && trim($_GET['code']) != '') {
	
	$code = trim($_GET['code']);
	
	$supplierData = $supplierObject->getByCode($code);

	if($supplierData) {
		$smarty->assign('supplierData', $supplierData);
	} else {
		header('Location: /dashboard/supplier/');
		exit;		
	}
}

/* Check posted data. */
if(count($_POST) > 0) {

	$errorArray		= array();
	$data 				= array();
	$formValid		= true;
	
	if(isset($_POST['supplier_name']) && trim($_POST['supplier_name']) == '') {
		$errorArray['supplier_name'] = 'Supplier name is required';
		$formValid = false;		
	}
	
	if(isset($_POST['supplier_number']) && trim($_POST['supplier_number']) == '') {
		$errorArray['supplier_number'] = 'Supplier number is required';
		$formValid = false;		
	}
	
	if(isset($_POST['supplier_email']) && trim($_POST['supplier_email']) != '') {
		if($supplierObject->validateEmail(trim($_POST['supplier_email'])) == '') {
			$errorArray['supplier_email'] = 'Needs to be a valid email address';
			$formValid = false;	
		}
	} else {
		$errorArray['supplier_email'] = 'Please add an email address for the enquiry form';
		$formValid = false;		
	}

	if(count($errorArray) == 0 && $formValid == true) {
		
		$data 	= array();	
		$data['supplier_name']		= trim($_POST['supplier_name']);		
		$data['supplier_email']		= trim($_POST['supplier_email']);		
		$data['supplier_number']	= trim($_POST['supplier_number']);		
		
		if(!isset($supplierData)) {									
			$success = $supplierObject->insert($data);				
		} else {
			$where		= $supplierObject->getAdapter()->quoteInto('supplier_code = ?', $supplierData['supplier_code']);
			$supplierObject->update($data, $where);		
			$success 	= $supplierData['supplier_code'];			
		}
		
		if(count($errorArray) == 0) {
			header('Location: /dashboard/supplier/');	
			exit;		
		}
	}
	$smarty->assign('supplierData', $_POST);	
	/* if we are here there are errors. */
	$smarty->assign('errorArray', $errorArray);	
}

$smarty->display('dashboard/supplier/details.tpl');

?>