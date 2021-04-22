<?php
/* Add this on all pages on top. */
set_include_path($_SERVER['DOCUMENT_ROOT'].'/'.PATH_SEPARATOR.$_SERVER['DOCUMENT_ROOT'].'/library/classes/');

/*** Standard includes */
require_once 'config/database.php';
require_once 'config/smarty.php';
/*** Check for login */
require_once 'includes/auth.php';

/* objects. */
require_once 'class/brand.php';

$brandObject	= new class_brand();

if (isset($_GET['code']) && trim($_GET['code']) != '') {
	
	$code = trim($_GET['code']);
	
	$brandData = $brandObject->getByCode($code);

	if($brandData) {
		$smarty->assign('brandData', $brandData);
	} else {
		header('Location: /dashboard/brand/');
		exit;		
	}
}

/* Check posted data. */
if(count($_POST) > 0) {
	$errorArray = array();
	$data       = array();
	
	if(!isset($_POST['brand_name'])) {
		$errorArray['brand_name'] = 'Brand name is required';
	} else if(trim($_POST['brand_name']) == '') {
		$errorArray['brand_name'] = 'Brand name is required';
	} else {
		$itemcode = isset($brandData) ? $brandData['brand_code'] : null;

		$urlData = $brandObject->getByURL($brandObject->toUrl($_POST['brand_name']), $itemcode);
		
		if($urlData) {
			$errorArray['participant_email'] = 'Email has already been used';	
		}	    
	}
	
	if(!isset($_POST['brand_delivery'])) {
		$errorArray['brand_delivery'] = 'Delivery time is required';
	} else if((int)trim($_POST['brand_delivery']) == 0) {
		$errorArray['brand_delivery'] = 'Delivery time is required';
	}
	
	if(!isset($_POST['brand_description'])) {
		$errorArray['brand_description'] = 'Description is required';
	} else if(trim($_POST['brand_description']) == '') {
		$errorArray['brand_description'] = 'Description is required';
	} else if(strlen(trim($_POST['brand_description'])) == 0 || strlen(trim($_POST['brand_description'])) > 255) {
	    $errorArray['brand_description'] = 'Description needs to have less than 255 characters and not empty';   
	}

	if(!isset($_POST['brand_email'])) {
		$errorArray['brand_email'] = 'Email address is required';
	} else if(trim($_POST['brand_email']) == '') {
		$errorArray['brand_email'] = 'Email address is required';
	} else if($brandObject->validateEmail(trim($_POST['brand_email'])) == '') {
	    $errorArray['brand_email'] = 'Needs to be a valid email address';
	}

	if(!isset($_POST['brand_number'])) {
		$errorArray['brand_number'] = 'Cellphone number is required';
	} else if(trim($_POST['brand_number']) == '') {
		$errorArray['brand_number'] = 'Cellphone number is required';
	} else if($brandObject->validateNumber(trim($_POST['brand_number'])) == '') {
	    $errorArray['brand_number'] = 'Needs to be a cellphone number';
	}
	
	if(isset($_POST['brand_social_twitter']) && trim($_POST['brand_social_twitter']) != '') {
		if($brandObject->validateTwitter(trim($_POST['brand_social_twitter'])) == '') {
			$errorArray['brand_social_twitter'] = 'Your twitter handle does not exist on Twitter, please try again';
		}
	}

	if(isset($_POST['brand_social_instagram']) && trim($_POST['brand_social_instagram']) != '') {
		if($brandObject->validateInstagram(trim($_POST['brand_social_instagram'])) == '') {
			$errorArray['brand_social_instagram'] = 'Your instagram handle is invalid, please add a correct one, only have letters and both period ( . ) and underscores ( _ ) in it';
		}
	}

	if(count($errorArray) == 0) {

		$data 	                            = array();		
		$data['brand_name']					= trim($_POST['brand_name']);		
		$data['brand_delivery']				= trim($_POST['brand_delivery']);		
		$data['brand_url']					= $brandObject->toUrl($data['brand_name']);
		$data['brand_email']				= trim($_POST['brand_email']);		
		$data['brand_number']				= trim($_POST['brand_number']);		
		$data['brand_description']			= trim($_POST['brand_description']);		
		$data['brand_website']				= trim($_POST['brand_website']);		
		$data['brand_social_facebook']		= trim($_POST['brand_social_facebook']);		
		$data['brand_social_twitter']		= trim($_POST['brand_social_twitter']);		
		$data['brand_social_instagram']		= trim($_POST['brand_social_instagram']);		
		$data['brand_social_pinterest']		= trim($_POST['brand_social_pinterest']);	

		if(!isset($brandData)) {
			$success = $brandObject->insert($data);				
		} else {
			$where		= $brandObject->getAdapter()->quoteInto('brand_code = ?', $brandData['brand_code']);
			$brandObject->update($data, $where);		
			$success 	= $brandData['brand_code'];			
		}

		if(count($errorArray) == 0) {
			header('Location: /dashboard/brand/media.php?code='.$success);	
			exit;		
		}
	}
	if(!isset($brandData)) $smarty->assign('brandData', $_POST);	
	/* if we are here there are errors. */
	$smarty->assign('errorArray', $errorArray);	
}

$smarty->display('dashboard/brand/details.tpl');

?>