<?php

/* Add this on all pages on top. */
set_include_path($_SERVER['DOCUMENT_ROOT'].'/'.PATH_SEPARATOR.$_SERVER['DOCUMENT_ROOT'].'/library/classes/');

/**
 * Standard includes
 */
require_once 'config/database.php';
require_once 'config/smarty.php';

require_once 'includes/auth.php';

/* objects. */
require_once 'class/item.php';
require_once 'class/media.php';
require_once 'class/File.php';

$itemObject		= new class_item();
$mediaObject 	= new class_media();
$fileObject 		= new File(array('png', 'jpg', 'jpeg'));

if (isset($_GET['code']) && trim($_GET['code']) != '') {
	
	$code = trim($_GET['code']);
	
	$itemData = $itemObject->getByCode($code);

	if($itemData) {
		$smarty->assign('itemData', $itemData);
		
		$mediaData = $mediaObject->getByItem('CATEGORY', $itemData['item_code'], array('IMAGE', 'BANNER'));

		if($mediaData) {
			$smarty->assign('mediaData', $mediaData);
		}	
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
		$data	= array();
		$data['media_deleted'] = 1;

		$where		= array();
		$where[]	= $mediaObject->getAdapter()->quoteInto('media_code = ?', $itemcode);
		$where[]	= $mediaObject->getAdapter()->quoteInto('media_item_code = ?', $itemData['item_code']);
		$where[]	= $mediaObject->getAdapter()->quoteInto('media_item_type = ?', $itemData['item_type']);

		$success	= $mediaObject->update($data, $where);	

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
if(isset($_GET['status_code'])) {

	$errorArray				= array();
	$errorArray['error']	= '';
	$errorArray['result']	= 0;
	$data 						= array();
	$formValid				= true;
	$success					= NULL;
	$itemcode					= trim($_GET['status_code']);

	$mediaItem = $mediaObject->getByCode($itemcode);

	if($itemData) {
		$mediaObject->updatePrimaryByItem('CATEGORY', $itemData['item_code'], $itemcode, array($mediaItem['media_category']));	
	} else {
		$errorArray['error']	= 'Did not ';
		$errorArray['result']	= 1;		
	}

	$errorArray['error']	= '';
	$errorArray['result']	= 1;				

	echo json_encode($errorArray);
	exit;
}

/* Check posted data. */
if(count($_FILES) > 0) {

	$errorArray	= array();
	$data 			= array();
	$formValid	= true;
	$success		= NULL;

	if(!isset($_POST['media_category'])) {
		$errorArray['media_category'] = 'Please select an image category';
		$formValid = false;		
	} else if(trim($_POST['media_category']) == '') {
		$errorArray['media_category'] = 'Please select an image category';
		$formValid = false;	
	}

	if(isset($_FILES['mediafiles']['name']) && count($_FILES['mediafiles']['name']) > 0) {
		for($i = 0; $i < count($_FILES['mediafiles']['name']); $i++) {
			if((int)$_FILES['mediafiles']['size'][$i] != 0 && trim($_FILES['mediafiles']['name'][$i]) != '') {
				/* Check if its the right file. */
				$ext = $fileObject->file_extention($_FILES['mediafiles']['name'][$i]); 

				if($ext != '') {
					$checkExt = $fileObject->getValidateExtention('mediafiles', $ext, $i);

					if(!$checkExt) {
						$errorArray['mediafiles'] = 'Invalid file type something funny with the file format';
						$formValid = false;						
					}
				} else {
					$errorArray['mediafiles'] = 'Invalid file type';
					$formValid = false;									
				}
			} else {			
				switch((int)$_FILES['mediafiles']['error'][$i]) {
					case 1 : $errorArray['mediafiles'] = 'The uploaded file exceeds the maximum upload file size, should be less than 1M'; $formValid = false; break;
					case 2 : $errorArray['mediafiles'] = 'File size exceeds the maximum file size'; $formValid = false; break;
					case 3 : $errorArray['mediafiles'] = 'File was only partically uploaded, please try again'; $formValid = false; break;
					case 4 : $errorArray['mediafiles'] = 'No file was uploaded'; $formValid = false; break;
					case 6 : $errorArray['mediafiles'] = 'Missing a temporary folder'; $formValid = false; break;
					case 7 : $errorArray['mediafiles'] = 'Faild to write file to disk'; $formValid = false; break;
				}
			}
		}
	}

	if(count($errorArray) == 0 && $formValid == true) {
		if(isset($_FILES['mediafiles']) && count($_FILES['mediafiles']['name']) > 0) {
			for($i = 0; $i < count($_FILES['mediafiles']['name']); $i++) {				
				$data 								= array();
				$data['media_code']			= $mediaObject->createCode();		
				$data['media_item_code']	= $itemData['item_code'];
				$data['media_item_type']	= 'CATEGORY';
				$data['media_category']			= trim($_POST['media_category']);

				$ext 			= strtolower($fileObject->file_extention($_FILES['mediafiles']['name'][$i]));					
				$filename	= $data['media_code'].'.'.$ext;		
				$directory	= $zfsession->config['path'].'/media/item/'.$itemData['item_code'].'/'.$data['media_code'];
				$file			= $directory.'/'.$filename;	
	
				if(!is_dir($directory)) mkdir($directory, 0777, true); 

				/* Create files for this item type. */ 
				foreach($fileObject->image as $item) {
					/* Change file name. */
					$newfilename = str_replace($filename, $item['code'].$filename, $file);
					/* Resize media. */
					$fileObject->resize_crop_image($item['width'], $item['height'], $_FILES['mediafiles']['tmp_name'][$i], $newfilename);
				}

				$data['media_path']	= '/media/item/'.$itemData['item_code'].'/'.$data['media_code'].'/';
				$data['media_ext']		= '.'.$ext ;
				/* Check for other medias. */
				$primary = $mediaObject->getPrimaryByItem('CATEGORY', $itemData['item_code'], array($data['media_category']));		
				
				if($primary) {
					$data['media_primary']	= 0;
				} else {
					$data['media_primary']	= 1;
				}
		
				$success	= $mediaObject->insert($data);	
			}
		}
		header('Location: /dashboard/category/media.php?code='.$itemData['item_code']);
		exit;
	}
	
	/* if we are here there are errors. */
	$smarty->assign('errorArray', $errorArray);
}

/* Display the template */	
$smarty->display('dashboard/category/media.tpl');
$mediaObject = $errorArray = $data = $itemData = $primary = $ext = $newfilename = $uploadObject = $item = $i = $filename = $file = $directory = $fileObject = $formValid = $checkExt = null;
unset($mediaObject, $errorArray, $data, $itemData, $primary, $ext, $newfilename, $uploadObject, $item, $i, $filename, $file, $directory, $fileObject, $formValid, $checkExt);
?>