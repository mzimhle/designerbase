<?php
/* Add this on all pages on top. */
set_include_path($_SERVER['DOCUMENT_ROOT'].'/'.PATH_SEPARATOR.$_SERVER['DOCUMENT_ROOT'].'/library/classes/');

/**
 * Standard includes
 */
require_once 'config/database.php';
require_once 'config/smarty.php';

/** Check for login */
require_once 'includes/auth.php';

require_once 'class/catalog.php';

$catalogObject				= new class_catalog(); 

 if(isset($_GET['delete_code'])) {
	
	$errorArray				= array();
	$errorArray['error']	= '';
	$errorArray['result']	= 0;	
	$formValid				= true;
	$code					= trim($_GET['delete_code']);
		
	if($errorArray['error']  == '' && $errorArray['result']  == 0 ) {
	
		$data						= array();
		$data['catalog_deleted']	= 1;
		
		$where		= $catalogObject->getAdapter()->quoteInto('catalog_code = ?', $code);
		$success	= $catalogObject->update($data, $where);	

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

/* Setup Pagination. */
if(isset($_GET['action']) && trim($_GET['action']) == 'tablesearch') {
	
	$start 	= isset($_REQUEST['iDisplayStart']) ? $_REQUEST['iDisplayStart'] : 0;
	$length	= isset($_REQUEST['iDisplayLength']) ? $_REQUEST['iDisplayLength'] : 20;
	
	$filters = isset($_REQUEST['filter_text']) && trim($_REQUEST['filter_text']) != '' ? array('filter_text' => trim($_REQUEST['filter_text'])) : array();

	$catalogData	= $catalogObject->getSearch($start, $length, $filters);
	$catalogs		= array();

	if($catalogData) {
		for($i = 0; $i < count($catalogData['records']); $i++) {
			$item = $catalogData['records'][$i];
			$catalogs[$i] = array(
				($item['media_code'] == '' ? "<img src='/images/avatar.jpg' width='60' />" : "<img src='".$zfsession->config['site'].$item['media_path']."/big_".$item['media_code'].$item['media_ext']."'  width='60' />"),
				'<a href="/catalog/details.php?code='.$item['catalog_code'].'">'.$item['catalog_name'].'</a>',
				'R '.number_format($item['price_amount']),
				$item['item_name'],
				"<button value='Delete' onclick=\"deleteModal('".$item['catalog_code']."', '', 'default'); return false;\">Delete</button>");
		}
	}

	if($catalogData) {
		$response['sEcho']					= $_REQUEST['sEcho'];
		$response['iTotalRecords']			= $catalogData['displayrecords'];		
		$response['iTotalDisplayRecords']	= $catalogData['count'];
		$response['aaData']					= $catalogs;
	} else {
		$response['result'] 	= false;
		$response['message']	= 'There are no items to show.';			
	}

    echo json_encode($response);
    die();	
}

$smarty->display('catalog/default.tpl');

?>