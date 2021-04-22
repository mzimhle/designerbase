<?php
/* Add this on all pages on top. */
set_include_path($_SERVER['DOCUMENT_ROOT'].'/'.PATH_SEPARATOR.$_SERVER['DOCUMENT_ROOT'].'/library/classes/');
/* Configuration files. */
require_once 'config/database.php';
require_once 'config/smarty.php';
/* Auth for the entire website. */
require_once 'includes/auth.php';
/* objects. */
require_once 'class/catalog.php';
require_once 'class/media.php';
require_once 'class/feature.php';
require_once 'class/item.php';
require_once 'class/comment.php';
require_once 'class/rate.php';
require_once 'class/advert.php';
/* Object */
$catalogObject 	= new class_catalog();
$mediaObject	= new class_media();
$featureObject	= new class_feature();
$commentObject	= new class_comment();
$rateObject		= new class_rate();
$advertObject	= new class_advert();
/* Get the code of the catalog item. */
if (isset($_GET['code']) && trim($_GET['code']) != '') {
	/* Code of the item. */
	$code = strtoupper(trim($_GET['code']));
	/* Get item from the catalog. */
	$catalogData = $catalogObject->getByCode($code);
	/* Check if it exists. */
	if($catalogData) {
		$smarty->assign('catalogData', $catalogData);
		/* Get the images. */
		$mediaData = $mediaObject->getByItem('CATALOG', $catalogData['catalog_code']);
		/* Check if images work. */
		if($mediaData) $smarty->assign('mediaData', $mediaData);
		/* Get the features. */
		$featureData = $featureObject->getByCatalog($catalogData['catalog_code']);
		/* Check if images work. */
		if($featureData) {
			$featureColour		= array();
			$featureSize		= array();
			$featureGender		= array();
			$featureMaterial	= array();

			for($i = 0; $i < count($featureData); $i++) {
				$item = $featureData[$i];
				
				if($item['item_type'] == 'COLOUR') {
					$featureColour[] = $item;
				} else if($item['item_type'] == 'MATERIAL') {
					$featureMaterial[] = $item['item_name'].' ( '.$item['feature_text'].' ) ';
				} else if($item['item_type'] == 'GENDER') {
					$featureGender[] = $item;
				} else if($item['item_type'] == 'SIZE') {
					$featureSize[] = $item;
				}
			}

			if(count($featureColour) > 0) 	$smarty->assign('featureColour', $featureColour);
			if(count($featureGender) > 0)	$smarty->assign('featureGender', $featureGender);
			if(count($featureSize) > 0)		$smarty->assign('featureSize', $featureSize);
			if(count($featureMaterial) > 0)	$smarty->assign('featureMaterial', $featureMaterial);
		}
		/* Get the comments. */
		$commentsData = $commentObject->getByType('CATALOG', $catalogData['catalog_code']);
		if($commentsData) $smarty->assign('commentsData', $commentsData);
	} else {
		header('Location: /');
		exit;		
	}
} else {
	header('Location: /');
	exit;		
}

if(count($_POST) > 0) {

	/* Error. */
	$error	= array();	
	/* Check if rate number exists. */
	if(isset($_POST['rate_number']) && (int)trim($_POST['rate_number']) == 0) {
		$error[] = 'Please add a rate';	
	}
	/* Check if the message has been added */
	if(isset($_POST['comment_message']) && trim($_POST['comment_message']) == '') {
		$error[] = 'Please add a message';	
	}
	/* validate. */
	if(count($error) == 0) {
		/* Insert the message */
		$data						= array();			
		$data['comment_item_type']	= 'CATALOG';					
		$data['comment_item_code']	= $catalogData['catalog_code'];
		$data['comment_message']	= trim($_POST['comment_message']);

		$success = $commentObject->insert($data);

		if($success) {
			/* Add the rate. */
			$data					= array();			
			$data['rate_item_type']	= 'COMMENT';					
			$data['rate_item_code']	= $success;
			$data['rate_number']	= trim($_POST['rate_number']);

			$success = $rateObject->insert($data);

			if($success) {
				$smarty->assign('commentsuccess', $success);
			} else {
				$error[] = 'We could not add the comment';	
			}
		} else {
			$error[] = 'We could not add the comment';	
		}
	}
	/* if we are here there are errors. */
	$smarty->assign('commentError', implode('<br />', $error));	
}
/* Get the categories. */ 
$similarData = $catalogObject->getSimilar($catalogData['item_code'], array($catalogData['catalog_code']));
if($similarData) $smarty->assign('similarData', $similarData);
/* Adverts. */
/* Get the banner adverts if there are any. */
$advertBanner = $advertObject->dateRange('RECTHORIZONTAL', 'SIDEBAR', 'CATALOG');
if($advertBanner) $smarty->assign('advertBanner', $advertBanner);

/* Display the template */	
$smarty->display('catalog/details.tpl');
?>