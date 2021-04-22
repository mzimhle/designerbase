<?php
/* Add this on all pages on top. */
set_include_path($_SERVER['DOCUMENT_ROOT'].'/'.PATH_SEPARATOR.$_SERVER['DOCUMENT_ROOT'].'/library/classes/');

/*** Standard includes */
require_once 'config/database.php';
require_once 'config/smarty.php';
/*** Check for login */
require_once 'includes/auth.php';

/* objects. */
require_once 'class/item.php';
require_once 'class/File.php';

$itemObject 	= new class_item();

if (isset($_GET['code']) && trim($_GET['code']) != '') {
	
	$code = trim($_GET['code']);
	
	$itemData = $itemObject->getByCode($code);

	if($itemData) {
		$smarty->assign('itemData', $itemData);
	} else {
		header('Location: /dashboard/category/');
		exit;		
	}
}


/* Check posted data. */
if(count($_POST) > 0) {

	$errorArray		= array();
	$data 				= array();
	$formValid		= true;
	$success			= NULL;
	
	if(isset($_POST['item_name']) && trim($_POST['item_name']) == '') {
		$errorArray['item_name'] = 'Category name is required';
		$formValid = false;		
	}

	if(count($errorArray) == 0 && $formValid == true) {
		
		$data 	= array();		
		$data['item_name']	= trim($_POST['item_name']);		
		$data['item_url']		= $itemObject->toUrl($data['item_name']);
		$data['item_type']		= 'CATEGORY';	
		
		if(!isset($itemData)) {
			$success = $itemObject->insert($data);				
		} else {
			$where		= $itemObject->getAdapter()->quoteInto('item_code = ?', $itemData['item_code']);
			$itemObject->update($data, $where);		
			$success 	= $itemData['item_code'];			
		}

		if(count($errorArray) == 0) {
			header('Location: /dashboard/category/media.php?code='.$success);	
			exit;		
		}	
			
	}
	if(!isset($itemData)) $smarty->assign('itemData', $_POST);	
	/* if we are here there are errors. */
	$smarty->assign('errorArray', $errorArray);	
}

$smarty->display('dashboard/category/details.tpl');

?>