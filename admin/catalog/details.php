<?php
/* Add this on all pages on top. */
set_include_path($_SERVER['DOCUMENT_ROOT'].'/'.PATH_SEPARATOR.$_SERVER['DOCUMENT_ROOT'].'/library/classes/');

/*** Standard includes */
require_once 'config/database.php';
require_once 'config/smarty.php';
/*** Check for login */
require_once 'includes/auth.php';
/* objects. */
require_once 'class/catalog.php';
require_once 'class/item.php';

$catalogObject	= new class_catalog();
$itemObject		= new class_item();

if (isset($_GET['code']) && trim($_GET['code']) != '') {
	
	$code = trim($_GET['code']);
	
	$catalogData = $catalogObject->getByCode($code);

	if($catalogData) {
		$smarty->assign('catalogData', $catalogData);
	} else {
		header('Location: /catalog/');
		exit;		
	}
}

if(isset($_REQUEST['parent_category'])) {

	$item	= trim($_REQUEST['parent_category']);
	$html	= '';

	if($item != '' ){

		$itemData = $itemObject->getByParentType($item, 'SECTION');

		if($itemData) {
			
			$html	= "<option value=''> --- Select section --- </option>";
			
			for($i = 0; $i < count($itemData); $i++) {				
				$selected = isset($catalogData) && $itemData[$i]['item_code'] == $catalogData['item_code'] ? 'SELECTED' : '';
				$html .= "<option value='".$itemData[$i]['item_code']."' $selected> ".$itemData[$i]['item_name']." </option>";				
			}
		} else {
			$html	= "<option value=''> --- There are no sections for selected category --- </option>";
		}
	} else {
		$html	= "<option value=''> --- There are no sections for selected category --- </option>";
	}
	echo $html;
	exit;
}

/* Check posted data. */
if(count($_POST) > 0) {
	$errorArray	= array();
	$data		= array();
	$formValid	= true;
	$success	= NULL;
	
	if(isset($_POST['catalog_name']) && trim($_POST['catalog_name']) == '') {
		$errorArray['catalog_name'] = 'Please add a name';
		$formValid = false;		
	}

	if(isset($_POST['item_code']) && trim($_POST['item_code']) == '') {
		$errorArray['item_code'] = 'Please add a category';
		$formValid = false;		
	}
	
	if(isset($_POST['catalog_text']) && trim($_POST['catalog_text']) == '') {
		$errorArray['catalog_text'] = 'Please add a description';
		$formValid = false;		
	}

	if(count($errorArray) == 0 && $formValid == true) {

		$data					= array();		
		$data['catalog_name']	= trim($_POST['catalog_name']);		
		$data['catalog_url']	= $catalogObject->toUrl($data['catalog_name']);		
		$data['item_code']		= trim($_POST['item_code']);
		$data['catalog_text']	= trim($_POST['catalog_text']);

		if(!isset($catalogData)) {
			$success = $catalogObject->insert($data);				
		} else {
			$where		= $catalogObject->getAdapter()->quoteInto('catalog_code = ?', $catalogData['catalog_code']);
			$catalogObject->update($data, $where);		
			$success 	= $catalogData['catalog_code'];			
		}

		if(count($errorArray) == 0) {
			header('Location: /catalog/feature.php?code='.$success);	
			exit;		
		}	
	}
	/* if we are here there are errors. */
	$smarty->assign('errorArray', $errorArray);	
}

$categoryData = $itemObject->typePairs('CATEGORY');
if($categoryData) $smarty->assign('categoryData', $categoryData);

$smarty->display('catalog/details.tpl');

?>