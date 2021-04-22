<?php
/* Add this on all pages on top. */
set_include_path($_SERVER['DOCUMENT_ROOT'].'/'.PATH_SEPARATOR.$_SERVER['DOCUMENT_ROOT'].'/library/classes/');

/**
 * Standard includes
 */
require_once 'config/database.php';
require_once 'config/smarty.php';
/*** Check for login */
require_once 'includes/auth.php';

require_once 'class/item.php';

$itemObject	= new class_item();

if(isset($_GET['delete_code'])) {
	
	$errorArray				= array();
	$errorArray['error']	= '';
	$errorArray['result']	= 0;	
	$success					= NULL;
	$code						= trim($_GET['delete_code']);
		
	if($errorArray['error']  == '' && $errorArray['result']  == 0 ) {

		$data							= array();
		$data['item_deleted']		= 1;

		$where		= array();
		$where[] 	= $itemObject->getAdapter()->quoteInto('item_type = ?', 'CATEGORY');
		$where[] 	= $itemObject->getAdapter()->quoteInto('item_code = ?', $code);
		$success	= $itemObject->update($data, $where);	

		if(is_numeric($success) && $success > 0) {
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

$itemData = $itemObject->getByType('CATEGORY');
if($itemData) $smarty->assign('itemData', $itemData);

$smarty->display('dashboard/category/default.tpl');

?>