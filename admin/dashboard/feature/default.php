<?php

/* Add this on all pages on top. */
set_include_path($_SERVER['DOCUMENT_ROOT'].'/'.PATH_SEPARATOR.$_SERVER['DOCUMENT_ROOT'].'/library/classes/');

/*** Standard includes */
require_once 'config/database.php';
require_once 'config/smarty.php';

require_once 'includes/auth.php';
/* objects. */
require_once 'class/item.php';
require_once 'class/media.php';
require_once 'class/File.php';

$itemObject		= new class_item();
$mediaObject    = new class_media();
$fileObject     = new File(array('png', 'jpg', 'jpeg'));

/* Setup Pagination. */
if(isset($_GET['action']) && trim($_GET['action']) == 'tablesearch') {
	
	$start 	= isset($_REQUEST['iDisplayStart']) ? $_REQUEST['iDisplayStart'] : 0;
	$length	= isset($_REQUEST['iDisplayLength']) ? $_REQUEST['iDisplayLength'] : 20;
	
	$filters['filter_parent'] = 'FEATURE';
	if(isset($_REQUEST['filter_text']) && trim($_REQUEST['filter_text']) != '') $filters['filter_text'] = trim($_REQUEST['filter_text']);
	if(isset($_REQUEST['filter_type']) && trim($_REQUEST['filter_type']) != '') $filters['filter_type'] = trim($_REQUEST['filter_type']);
	if(isset($_REQUEST['filter_variable']) && trim($_REQUEST['filter_variable']) != '') $filters['filter_variable'] = trim($_REQUEST['filter_variable']);
	if(isset($_REQUEST['item_cipher']) && trim($_REQUEST['item_cipher']) != '') $filters['item_cipher'] = trim($_REQUEST['item_cipher']);

	$itemData	= $itemObject->getSearch($start, $length, $filters);
	$items		= array();

	if($itemData) {
		for($i = 0; $i < count($itemData['records']); $i++) {

			$item = $itemData['records'][$i];

			if($item['item_type'] == 'COLOUR') {
				$items[$i] = array(
					$item['item_type'],
					$item['item_name'],
					$item['item_value'],
					'<img src="'.(isset($item['media_code']) && $item['media_code'] != '' ? $zfsession->config['site'].$item['media_path'].'/tny_'.$item['media_code'].$item['media_ext'] : '/no-image.png').'" width="50px" />',
					"<button value='Delete' onclick=\"deleteModal('".$item['item_code']."', '', 'default'); return false;\">Delete</button>");
			} else if($item['item_type'] == 'SIZE') {
				$items[$i] = array(
					$item['item_type'],
					$item['item_cipher'],
					$item['item_variable'],
					$item['item_value'],
					"<button value='Delete' onclick=\"deleteModal('".$item['item_code']."', '', 'default'); return false;\">Delete</button>");
			} else if($item['item_type'] == 'GENDER') {
				$items[$i] = array(
					$item['item_type'],
					$item['item_name'],
					$item['item_value'],
					"<button value='Delete' onclick=\"deleteModal('".$item['item_code']."', '', 'default'); return false;\">Delete</button>");
			} else if($item['item_type'] == 'MATERIAL') {
				$items[$i] = array(
					$item['item_type'],
					$item['item_name'],
					"<button value='Delete' onclick=\"deleteModal('".$item['item_code']."', '', 'default'); return false;\">Delete</button>");
			} else {
				$items[$i] = array(
					$item['item_type'],
					$item['item_name'],
					$item['item_cipher'],
					$item['item_variable'],
					$item['item_value'],
					"<button value='Delete' onclick=\"deleteModal('".$item['item_code']."', '', 'default'); return false;\">Delete</button>");
			}
		}
	}

	if($itemData) {
		$response['sEcho']					= $_REQUEST['sEcho'];
		$response['iTotalRecords']			= $itemData['displayrecords'];		
		$response['iTotalDisplayRecords']	= $itemData['count'];
		$response['aaData']					= $items;
	} else {
		$response['result'] 	= false;
		$response['message']	= 'There are no items to show.';			
	}

    echo json_encode($response);
    die();	
}

/* Check posted data. */
if(isset($_GET['delete_code'])) {

	$errorArray				= array();
	$errorArray['error']	= '';
	$errorArray['result']	= 0;	
	$formValid				= true;
	$success                = NULL;
	$itemcode               = trim($_GET['delete_code']);

	if($errorArray['error']  == '' && $errorArray['result']  == 0 ) {

		$data					= array();
		$data['item_deleted']	= 1;

		$where		= array();
		$where[]	= $itemObject->getAdapter()->quoteInto('item_code = ?', $itemcode);
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

	if(isset($_POST['item_type']) && trim($_POST['item_type']) == '') {
		$errorArray['item_type'] = 'Type is required';
	} else {
		$type = trim($_POST['item_type']);
		/* Check variables chosen. */
		if($type == 'COLOUR') {
			if(!isset($_POST['item_name'])) {
				$errorArray['item_name'] = 'Name is required';
			} else if(trim($_POST['item_name']) == '') {
				$errorArray['item_name'] = 'Name is required';
			}
			if(!isset($_POST['item_value'])) {
				$errorArray['item_value'] = 'Name is required';
			} else if(trim($_POST['item_value']) == '') {
				$errorArray['item_value'] = 'Name is required';
			}

    		/* Check validity of the files. */
    		if((int)$_FILES['mediafile']['size'] != 0 && trim($_FILES['mediafile']['name']) != '') {
    			/* Check if its the right file. */
    			$ext = $fileObject->file_extention($_FILES['mediafile']['name']); 
    
    			if($ext != '') {
    				$checkExt = $fileObject->getValidateExtention('mediafile', $ext);
    
    				if(!$checkExt) {
    					$errorArray['mediafile'] = 'Invalid file type something funny with the file format';
    					$formValid = false;
    				}
    			} else {
    				$errorArray['mediafile'] = 'Invalid file type';
    				$formValid = false;									
    			}
    		} else {			
    			switch((int)$_FILES['mediafile']['error']) {
    				case 1 : $errorArray['mediafile'] = 'The uploaded file exceeds the maximum upload file size, should be less than 1M'; $formValid = false; break;
    				case 2 : $errorArray['mediafile'] = 'File size exceeds the maximum file size'; $formValid = false; break;
    				case 3 : $errorArray['mediafile'] = 'File was only partically uploaded, please try again'; $formValid = false; break;
    				case 4 : $errorArray['mediafile'] = 'No file was uploaded'; $formValid = false; break;
    				case 6 : $errorArray['mediafile'] = 'Missing a temporary folder'; $formValid = false; break;
    				case 7 : $errorArray['mediafile'] = 'Faild to write file to disk'; $formValid = false; break;
    			}
    		}
            		
		} else if($type == 'SIZE') {
			if(!isset($_POST['item_cipher'])) {
				$errorArray['item_cipher'] = 'Cipher is required';
			} else if(trim($_POST['item_cipher']) == '') {
				$errorArray['item_cipher'] = 'Cipher is required';
			}
			if(!isset($_POST['item_variable'])) {
				$errorArray['item_variable'] = 'Variable is required';
			} else if(trim($_POST['item_variable']) == '') {
				$errorArray['item_variable'] = 'Variable is required';
			}
			if(!isset($_POST['item_value'])) {
				$errorArray['item_value'] = 'Value is required';
			} else if(trim($_POST['item_value']) == '') {
				$errorArray['item_value'] = 'Value is required';
			}
		} else if($type == 'GENDER') {
			if(!isset($_POST['item_name'])) {
				$errorArray['item_name'] = 'Name is required';
			} else if(trim($_POST['item_name']) == '') {
				$errorArray['item_name'] = 'Name is required';
			}
			if(!isset($_POST['item_value'])) {
				$errorArray['item_value'] = 'Value is required';
			} else if(trim($_POST['item_value']) == '') {
				$errorArray['item_value'] = 'Value is required';
			}
		} else if($type == 'MATERIAL') {
			if(!isset($_POST['item_name'])) {
				$errorArray['item_name'] = 'Name is required';
			} else if(trim($_POST['item_name']) == '') {
				$errorArray['item_name'] = 'Name is required';
			}
		} else {
			$errorArray['item_type'] = 'Please add details';
		}
	}

	if(count($errorArray) == 0) {

		$data					= array();		
		$data['item_name']		= trim($_POST['item_name']);
		$data['item_parent']	= 'FEATURE';
		$data['item_url']		= $itemObject->toUrl($data['item_name']);
		$data['item_cipher']	= trim($_POST['item_cipher']);		
		$data['item_type']		= trim($_POST['item_type']);
		$data['item_variable']	= trim($_POST['item_variable']);
		$data['item_value']		= trim($_POST['item_value']);

		$success = $itemObject->insert($data);				

		if(count($errorArray) == 0) {
    		if(isset($_FILES['mediafile']) && trim($_FILES['mediafile']['name']) != '') {
				$data                       = array();
				$data['media_code']			= $mediaObject->createCode();		
				$data['media_item_code']	= $success;
				$data['media_item_type']    = 'FEATURE';

				$ext        = strtolower($fileObject->file_extention($_FILES['mediafile']['name']));					
				$filename	= $data['media_code'].'.'.$ext;		
				$directory	= $zfsession->config['path'].'/media/dashboard/colour/'.$success.'/'.$data['media_code'];
				$file       = $directory.'/'.$filename;	
	
				if(!is_dir($directory)) mkdir($directory, 0777, true);
				/* Create files for this brand type. */ 
				foreach($fileObject->colour as $item) {
                    /* Change file name. */
                    $newfilename = str_replace($filename, $item['code'].$filename, $file);
                    /* Resize media. */
                    $fileObject->resize_crop_image($item['width'], $item['height'], $_FILES['mediafile']['tmp_name'], $newfilename);
				}

				$data['media_path']	= '/media/dashboard/colour/'.$success.'/'.$data['media_code'].'/';
				$data['media_ext']  = '.'.$ext ;
				/* Check for other medias. */
				$primary = $mediaObject->getPrimaryByItem('FEATURE', $success);		
				if($primary) {
					$data['media_primary']	= 0;
				} else {
					$data['media_primary']	= 1;
				}

				$success	= $mediaObject->insert($data);	
    		}
			header('Location: /dashboard/feature/');	
			exit;		
		}
	}
	/* if we are here there are errors. */
	$smarty->assign('errorArray', $errorArray);	
}

$itemData = $itemObject->getByParent('FEATURE');
if($itemData) $smarty->assign('itemData', $itemData);

$selectCipher = $itemObject->selectCipher('SECTION');
if($selectCipher) $smarty->assign('selectCipher', $selectCipher);

/* Display the template */	
$smarty->display('dashboard/feature/default.tpl');
?>