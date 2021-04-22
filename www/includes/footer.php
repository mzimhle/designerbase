<?php
/* Add this on all pages on top. */
set_include_path($_SERVER['DOCUMENT_ROOT'].'/'.PATH_SEPARATOR.$_SERVER['DOCUMENT_ROOT'].'/library/classes/');

global $smarty;
/*** Standard includes */
require_once 'config/database.php';
/* Classes files. */
require_once 'class/item.php';
/* Auth for the entire website. */
require_once 'includes/auth.php';

/* AJAX */
if(isset($_REQUEST['modal_basket_price_select'])) {
	/* Classes file */
	require_once 'class/feature.php';
	/* Objects */
	$featureObject	= new class_feature();
	/* Validation. */
	if(!isset($_REQUEST['pricecode'])) {
    	/* HTML */
    	$html = '<option value=""> No price - select price first </option>';    	
	} else if(trim($_REQUEST['pricecode']) == '') {
    	/* HTML */
    	$html = '<option value=""> No price - select price first </option>';    	
	} else if(!isset($_REQUEST['catalog_code'])) {
    	/* HTML */
    	$html = '<option value=""> No price - select item </option>';
	} else if(trim($_REQUEST['catalog_code']) == '') {
		$html = '<option value=""> No price - select item </option>';
	} else {
		$featureData = $featureObject->getByCatalog(trim($_REQUEST['catalog_code']), 'SIZE');
		/* Check if exists first. */
		if(!$featureData) {
			$html = '<option value=""> No price - No price added for item </option>';
		} else {
            $html = '';
		    foreach($featureData as $feature) {
		        $text = 'R '.number_format($feature['price_amount']);
                $text .= ($feature['feature_size'] != '' ? ' - Size: '.$feature['feature_size'] : '');
                $text .= ($feature['feature_size_bust'] != '' ? ' - Bust: '.$feature['feature_size_bust'] : '');
                $text .= ($feature['feature_size_waist'] != '' ? ' - Waist: '.$feature['feature_size_waist'] : '');
                $text .= ($feature['feature_size_bust'] != '' ? ' - Hips: '.$feature['feature_size_hips'] : '');
                
                $html .= '<option value="'.$feature['price_code'].'" '.(trim($_REQUEST['pricecode']) == $feature['price_code'] ? 'selected' : '').'> '.$text.' </option>';
		    }
		}
	}	
	/* Output. */
	echo $html;
	exit;
}
if(isset($_REQUEST['modal_basket_ajax'])) {
	/* Classes file */
	require_once 'class/catalog.php';
	require_once 'class/price.php';
	/* Objects */
	$catalogObject	= new class_catalog();
	$priceObject	= new class_price();
	/* The output */
	$output		= array('result' => 1, 'message' => '');
	/* Validation. */
	if(!isset($_REQUEST['basket_code'])) {
		$output = array('result' => 0, 'message' => 'Please select an item to add first');
	} else if(trim($_REQUEST['basket_code']) == '') {
		$output = array('result' => 0, 'message' => 'Please select an item to add first');
	} else {
		$catalogData = $catalogObject->getByCode(trim($_REQUEST['basket_code']));
		/* Check if exists first. */
		if(!$catalogData) {
			$output = array('result' => 0, 'message' => 'Please select an item to add first');
		}
	}
	if(!isset($_REQUEST['price_code'])) {
		$output = array('result' => 0, 'message' => 'Please add a price');
	} else if(trim($_REQUEST['price_code']) == '') {
		$output = array('result' => 0, 'message' => 'Please add a price');
	} else {
		$priceData = $priceObject->getByCode(trim($_REQUEST['price_code']));
		
		if(!$priceData) {
			$output = array('result' => 0, 'message' => 'Please add a price');
		}
	}
	
	if(!isset($_REQUEST['basket_quantity'])) {
		$output = array('result' => 0, 'message' => 'Please add a quantity');
	} else if((int)trim($_REQUEST['basket_quantity']) == 0) {
		$output = array('result' => 0, 'message' => 'Please add a quantity');
	}

	if(!isset($_REQUEST['basket_text'])) {
		$output = array('result' => 0, 'message' => 'This is not a proper submit');
	}
	
	if($output['result'] == 1 && isset($catalogData) && isset($priceData)) {
		/* Check if this does not already exists. */
		if(isset($zfsession->basket)) {
			/* Assume the item is not in the basket currently. */
			$exists = false;
			/* Check if item already exists in the basket. */
			for($i = 0; $i < count($zfsession->basket); $i++) {
				if($zfsession->basket[$i]['catalog_code'] == trim($_REQUEST['basket_code'])) {
					$exists = true;
					break;
				}
			}
			/* If does not exists, add it to the basket. */
			if(!$exists) {
				/* Build details to add to basket. */
				$catalogData['media_path']		= $catalogData['media_path'].'tmb_'.$catalogData['media_code'].$catalogData['media_ext'];
				$catalogData['basket_quantity']	= (int)trim($_REQUEST['basket_quantity']);
				$catalogData['basket_text']		= trim($_REQUEST['basket_text']);
				/* Add to the basket array. */
				$zfsession->basket[]		= array_merge($catalogData, $priceData);
			}
		}
	}
	/* Output. */
	echo json_encode($output);
	exit;
}

/* Instance */
$categoryObject = new class_item();
/* Get the categories. */ 
$categoryData = $categoryObject->getByType('CATEGORY');
if($categoryData) $smarty->assign('categoryData', $categoryData);
/* Display the template */	
$smarty->display('includes/footer.tpl');
$categoryObject = $categoryData = $catalogData = null;
unset($categoryObject, $categoryData, $catalogData);
?>