<?php

/* Add this on all pages on top. */
set_include_path($_SERVER['DOCUMENT_ROOT'].'/'.PATH_SEPARATOR.$_SERVER['DOCUMENT_ROOT'].'/library/classes/');

/*** Standard includes */
require_once 'config/database.php';
require_once 'config/smarty.php';

require_once 'includes/auth.php';
/* objects. */
require_once 'class/item.php';

$itemObject		= new class_item();

if (isset($_GET['code']) && trim($_GET['code']) != '') {
	
	$code = trim($_GET['code']);
	
	$itemData = $itemObject->getByCode($code);

	if($itemData) {
		$smarty->assign('itemData', $itemData);
		
		$sectionData = $itemObject->getByParentType($itemData['item_code'], 'SECTION');

		if($sectionData) $smarty->assign('sectionData', $sectionData);
		
	} else {
		header('Location: /dashboard/category/');
		exit;	
	}
} else {
	header('Location: /dashboard/category/');
	exit;	
}

/* Check posted data. */
if(isset($_GET['delete_code'])) {

	$errorArray				= array();
	$errorArray['error']	= '';
	$errorArray['result']	= 0;	
	$formValid				= true;
	$success					= NULL;
	$itemcode					= trim($_GET['delete_code']);

	if($errorArray['error']  == '' && $errorArray['result']  == 0 ) {

		$data							= array();
		$data['item_deleted'] 	= 1;

		$where		= array();
		$where[]	= $itemObject->getAdapter()->quoteInto('item_code = ?', $itemcode);
		$where[]	= $itemObject->getAdapter()->quoteInto('item_type = ?', 'SECTION');
		$where[]	= $itemObject->getAdapter()->quoteInto('item_parent = ?', $itemData['item_code']);		

		$success	= $itemObject->update($data, $where);	

		if($success) {		
			$errorArray['error']	= '';
			$errorArray['result']	= 1;			
		} else {
			$errorArray['error']	= 'Could not delete, please try again.';
			$errorArray['result']	= 0;				
		}
	}

	echo json_encode($errorArray);
	exit;
}
/* Check posted data. */
if(count($_POST) > 0) {

	$errorArray	= array();

	if(isset($_POST['item_name']) && trim($_POST['item_name']) == '') {
		$errorArray['item_name'] = 'Section name is required';
	}

	if(isset($_POST['item_cipher']) && trim($_POST['item_cipher']) == '') {
		$errorArray['item_cipher'] = 'Section code is required';
	}

	if(count($errorArray) == 0) {

		$data					= array();
		$data['item_name']		= trim($_POST['item_name']);
		$data['item_parent']	= $itemData['item_code'];
		$data['item_url']		= $itemObject->toUrl($data['item_name']);
		$data['item_type']		= 'SECTION';
		$data['item_cipher']	= strtoupper(trim($_POST['item_cipher']));

		$success = $itemObject->insert($data);

		if(count($errorArray) == 0) {
			header('Location: /dashboard/category/section.php?code='.$itemData['item_code']);	
			exit;		
		}
	}
	/* if we are here there are errors. */
	$smarty->assign('errorArray', $errorArray);	
}

/* Display the template */	
$smarty->display('dashboard/category/section.tpl');
?>