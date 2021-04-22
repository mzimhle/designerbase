<?php

/* Add this on all pages on top. */
set_include_path($_SERVER['DOCUMENT_ROOT'].'/'.PATH_SEPARATOR.$_SERVER['DOCUMENT_ROOT'].'/library/classes/');

/*** Standard includes */
require_once 'config/database.php';
require_once 'config/smarty.php';

require_once 'includes/auth.php';
/* objects. */
require_once 'class/catalog.php';
require_once 'class/item.php';
require_once 'class/feature.php';
require_once 'class/price.php';

$featureObject	= new class_feature();
$itemObject		= new class_item();
$catalogObject	= new class_catalog();
$priceObject	= new class_price();

if (isset($_GET['code']) && trim($_GET['code']) != '') {
 
	$code = trim($_GET['code']);

	$catalogData = $catalogObject->getByCode($code);

	if($catalogData) {
		$smarty->assign('catalogData', $catalogData);
	} else {
		header('Location: /catalog/');
		exit;	
	}
} else {
	header('Location: /catalog/');
	exit;	
}
/* Check posted data. */
if(isset($_GET['update_primary_size'])) {

	$errorArray				= array();
	$errorArray['error']	= '';
	$errorArray['result']	= 0;	
	$itemcode				= trim($_GET['update_primary_size']);
	/* Check if there is already a primary. */
	$success = $featureObject->updatePrimary($catalogData['catalog_code'], 'SIZE', $itemcode);
	/* Check if successful. */
	if($success) {
		$errorArray['error']	= '';
		$errorArray['result']	= 1;			
	} else {
		$errorArray['error']	= 'The feature was not updated';
		$errorArray['result']	= 0;				
	}

	echo json_encode($errorArray);
	exit;
}

/* Check posted data. */
if(isset($_GET['delete_code'])) {

	$errorArray				= array();
	$errorArray['error']	= '';
	$errorArray['result']	= 0;	
	$formValid				= true;
	$success				= NULL;
	$itemcode				= trim($_GET['delete_code']);

	if($errorArray['error']  == '' && $errorArray['result']  == 0 ) {

		$data						= array();
		$data['feature_deleted']	= 1;

		$where		= array();
		$where[]	= $featureObject->getAdapter()->quoteInto('feature_code = ?', $itemcode);
		$success	= $featureObject->update($data, $where);	

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

if(isset($_GET['get_features'])) {

	$response				= array();
	$response['records']	= array();
	$response['result']		= 1;

	$itemData = $itemObject->getByParentType('FEATURE', trim($_GET['get_features']));

	if($itemData) {
		$response['records']	= $itemData;
	}

    echo json_encode($response);
    die();	
}

if(isset($_GET['get_price_size'])) {

	$response				= array();
	$response['records']	= array();
	$response['result']		= 1;

	$priceData = $priceObject->getByType('FEATURE', trim($_GET['get_price_size']));

	if($priceData) {
		$response['records']	= $priceData;
	} else {
		$response['result']		= 0;
	}

    echo json_encode($response);
    die();	
}

if(isset($_REQUEST['add_price_size'])) {

	$response				= array();
	$response['message']	= '';
	$response['result']		= 1;

	if(!isset($_REQUEST['price_code'])) {
		$response['message']	= 'Please select a price';
		$response['result']		= 0;
	} else if(trim($_REQUEST['price_code']) == '') {
		$response['message']	= 'Please select a price';
		$response['result']		= 0;
	} else {
		
		if(!isset($_REQUEST['price_original'])) {
			$response['message']	= 'Please select an amount';
			$response['result']		= 0;
		} else if(trim($_REQUEST['price_original']) == '') {
			$response['message']	= 'Please select an amount';
			$response['result']		= 0;		
		} else if(!isset($_REQUEST['price_discount'])) {
			$response['message']	= 'Please select a discount';
			$response['result']		= 0;
		} else if(trim($_REQUEST['price_discount']) == '') {
			$response['message']	= 'Please select a discount';
			$response['result']		= 0;
		} else {

			$priceData = $priceObject->getByCode(trim($_REQUEST['price_code']));

			if($priceData) {
				$data 						= array();
				$data['price_original']		= trim($_REQUEST['price_original']);
				$data['price_discount']		= trim($_REQUEST['price_discount']);
				$data['price_item_type']	= 'FEATURE';
				$data['price_item_code']	= trim($_REQUEST['add_price_size']);
				$success					= $priceObject->insert($data);
			} else {
				$response['message']	= 'Price to be updated does not exist.';
				$response['result']		= 0;				
			}
		}
	}

    echo json_encode($response);
    die();	
}
if(isset($_GET['add_feature'])) {

	$response				= array();
	$response['records']	= array();
	$response['message']	= '';
	$response['result']		= 1;
	
	$items = isset($_REQUEST['items']) && trim($_REQUEST['items']) != '' ? explode(',', trim($_REQUEST['items'])) : array();

	if(count($items) > 0) {
		if(isset($_REQUEST['type']) && trim($_REQUEST['type']) != '') {
			for($i = 0; $i < count($items); $i++) {
				/* Get item. */
				$item = $items[$i];
				/* Add a feature. */
				$data					= array();
				$data['catalog_code']	= $catalogData['catalog_code'];
				$data['item_code']		= $item;
				$data['feature_text']	= isset($_REQUEST[$item]) ? $_REQUEST[$item] : null;

				if(trim($_REQUEST['type']) == 'SIZE') {
					$data['feature_size']		= isset($_REQUEST['size_'.$item]) ? trim($_REQUEST['size_'.$item]) : null;
					$data['feature_size_bust']	= isset($_REQUEST['bust_'.$item]) ? trim($_REQUEST['bust_'.$item]) : null;
					$data['feature_size_waist']	= isset($_REQUEST['waist_'.$item]) ? trim($_REQUEST['waist_'.$item]) : null;
					$data['feature_size_hips']	= isset($_REQUEST['hips_'.$item]) ? trim($_REQUEST['hips_'.$item]) : null;
				}

				$success = $featureObject->insert($data);

				if($success) {
					if(trim($_REQUEST['type']) == 'SIZE') {
						/* Add the price. */
						$data						= array();
						$data['price_original']		= trim($_REQUEST['price_'.$item]);
						$data['price_discount']		= 0;
						$data['price_item_type']	= 'FEATURE';
						$data['price_item_code']	= $success;
						$success					= $priceObject->insert($data);
					}
				}
			}
		} else {
			$response['message']	= 'There are no features left';
			$response['result']		= 0;
		}
	}
    echo json_encode($response);
    die();	
}
/* Setup Pagination. */
if(isset($_GET['action']) && trim($_GET['action']) == 'tablesearch') {

	$start 	= isset($_REQUEST['iDisplayStart']) ? $_REQUEST['iDisplayStart'] : 0;
	$length	= isset($_REQUEST['iDisplayLength']) ? $_REQUEST['iDisplayLength'] : 20;
	$type	= '';

	$filters['filter_catalog'] = $catalogData['catalog_code'];

	if(isset($_REQUEST['filter_type']) && trim($_REQUEST['filter_type']) != '') {
		$filters['filter_type']	= trim($_REQUEST['filter_type']);
		$type = trim($_REQUEST['filter_type']);
	}

	$featureData	= $featureObject->getSearch($start, $length, $filters);
	$features		= array();

	if(isset($featureData['count']) && count($featureData['count']) > 0) {
		for($i = 0; $i < count($featureData['records']); $i++) {
			$item = $featureData['records'][$i];
			if($type == 'COLOUR') {
				$features[$i] = array( 
					$item['item_type'],
					$item['item_name'],
					'<span class="colorbox" style="background: '.$item['item_value'].'"></span>',
					"<button value='Delete' onclick=\"deleteModal('".$item['feature_code']."', '".$catalogData['catalog_code']."', 'feature'); return false;\">Delete</button>");
			} else if($type == 'SIZE') {
				if($catalogData['item_parent_name'] == 'Fashion') {
					$features[$i] = array(
						$item['item_type'],
						$item['item_cipher'],
						$item['item_variable'],
						$item['feature_size'],
						$item['feature_size_bust'],
						$item['feature_size_waist'],
						$item['feature_size_hips'],
						$item['price_amount'],
						($item['item_type'] == 'SIZE' ? "<button value='Update Price' onclick=\"updatePriceModal('".$item['feature_code']."'); return false;\">Update Price</button>" : 'N / A'),						
						((int)$item['feature_primary'] == 0 ? "<button value='Primary' onclick=\"makePrimaryModal('".$item['feature_code']."'); return false;\">Primary</button>" : 'Primary'),					
						"<button value='Delete' onclick=\"deleteModal('".$item['feature_code']."', '".$catalogData['catalog_code']."', 'feature'); return false;\">Delete</button>");
				} else {
					$features[$i] = array(
						$item['item_type'],
						$item['item_cipher'],
						$item['item_variable'],
						$item['item_value'],
						$item['price_amount'],
						($item['item_type'] == 'SIZE' ? "<button value='Update Price' onclick=\"updatePriceModal('".$item['feature_code']."'); return false;\">Update Price</button>" : 'N / A'),						
						"<input type='radio' value='1' name='primary_".$item['feature_code']."' id='primary_".$item['feature_code']."' ".((int)$item['feature_primary'] == 1 ? 'checked' : '')." />",
						"<button value='Delete' onclick=\"deleteModal('".$item['feature_code']."', '".$catalogData['catalog_code']."', 'feature'); return false;\">Delete</button>");
				}
			} else if($type == 'GENDER') {
				$features[$i] = array(
					$item['item_type'],
					$item['item_name'], 
					"<button value='Delete' onclick=\"deleteModal('".$item['feature_code']."', '".$catalogData['catalog_code']."', 'feature'); return false;\">Delete</button>");
			} else if($type == 'MATERIAL') {
				$features[$i] = array(
					$item['item_type'],
					$item['item_name'],
					$item['feature_text'],
					"<button value='Delete' onclick=\"deleteModal('".$item['feature_code']."', '".$catalogData['catalog_code']."', 'feature'); return false;\">Delete</button>");
			} else {
				$features[$i] = array(
					$item['item_type'],
					$item['item_name'],
					$item['item_cipher'],
					$item['item_variable'],
					($item['item_type'] == 'SIZE' ? $item['feature_size'] : $item['item_value']),
					$item['feature_text'],
					$item['price_amount'],
					($item['item_type'] == 'SIZE' ? "<button value='Update Price' onclick=\"updatePriceModal('".$item['feature_code']."'); return false;\">Update Price</button>" : 'N / A'),
					($item['item_type'] == 'SIZE' ? ((int)$item['feature_primary'] == 0 ? "<button value='Primary' onclick=\"makePrimaryModal('".$item['feature_code']."'); return false;\">Primary</button>" : 'Primary') : 'N / A'),
					"<button value='Delete' onclick=\"deleteModal('".$item['feature_code']."', '".$catalogData['catalog_code']."', 'feature'); return false;\">Delete</button>");
			}
		}
	}

	if($featureData) {
		$response['sEcho']					= $_REQUEST['sEcho'];
		$response['iTotalRecords']			= $featureData['displayrecords'];		
		$response['iTotalDisplayRecords']	= $featureData['count'];
		$response['aaData']					= $features;
	} else {
		$response['result'] 	= false;
		$response['message']	= 'There are no items to show.';			
	}

    echo json_encode($response);
    die();	
}

/* Display the template */	
$smarty->display('catalog/feature.tpl');
?>