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
require_once 'class/brand.php';
require_once 'class/media.php';
require_once 'class/File.php';

$brandObject		= new class_brand();
$mediaObject 	= new class_media();
$fileObject 		= new File(array('png', 'jpg', 'jpeg'));

if (isset($_GET['code']) && trim($_GET['code']) != '') {
	
	$code = trim($_GET['code']);
	
	$brandData = $brandObject->getByCode($code);

	if($brandData) {
		$smarty->assign('brandData', $brandData);
		
		$mediaData = $mediaObject->getByItem('BRAND', $brandData['brand_code'], array('IMAGE'));

		if($mediaData) {
			$smarty->assign('mediaData', $mediaData);
		}	
	} else {
		header('Location: /dashboard/brand/');
		exit;	
	}
	
} else {
	header('Location: /dashboard/brand/');
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
		$where[]	= $mediaObject->getAdapter()->quoteInto('media_item_code = ?', $brandData['brand_code']);
		$where[]	= $mediaObject->getAdapter()->quoteInto('media_item_type = ?', 'BRAND');

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

	$mediaObject->updatePrimaryByItem('BRAND', $brandData['brand_code'], $itemcode);	

	$errorArray['error']	= '';
	$errorArray['result']	= 1;				
	
	echo json_encode($errorArray);
	exit;
}

/* Check posted data. */
if(count($_FILES) > 0) {

	$errorArray	= '';
	$data 			= array();
	$formValid	= true;
	$success		= NULL;

	if(isset($_FILES['mediafiles']['name']) && count($_FILES['mediafiles']['name']) > 0) {
		for($i = 0; $i < count($_FILES['mediafiles']['name']); $i++) {
			/* Check validity of the CV. */
			if((int)$_FILES['mediafiles']['size'][$i] != 0 && trim($_FILES['mediafiles']['name'][$i]) != '') {
				/* Check if its the right file. */
				$ext = $fileObject->file_extention($_FILES['mediafiles']['name'][$i]); 

				if($ext != '') {
					$checkExt = $fileObject->getValidateExtention('mediafiles', $ext, $i);

					if(!$checkExt) {
						$errorArray = 'Invalid file type something funny with the file format';
						$formValid = false;						
					}
				} else {
					$errorArray = 'Invalid file type';
					$formValid = false;									
				}
			} else {			
				switch((int)$_FILES['mediafiles']['error'][$i]) {
					case 1 : $errorArray = 'The uploaded file exceeds the maximum upload file size, should be less than 1M'; $formValid = false; break;
					case 2 : $errorArray = 'File size exceeds the maximum file size'; $formValid = false; break;
					case 3 : $errorArray = 'File was only partically uploaded, please try again'; $formValid = false; break;
					case 4 : $errorArray = 'No file was uploaded'; $formValid = false; break;
					case 6 : $errorArray = 'Missing a temporary folder'; $formValid = false; break;
					case 7 : $errorArray = 'Faild to write file to disk'; $formValid = false; break;
				}
			}
		}
	}

	if(trim($errorArray) == '' && $formValid == true) {
		
		if(isset($_FILES['mediafiles']) && count($_FILES['mediafiles']['name']) > 0) {
			for($i = 0; $i < count($_FILES['mediafiles']['name']); $i++) {				
				$data = array();
				$data['media_code']			= $mediaObject->createCode();		
				$data['media_item_code']	= $brandData['brand_code'];
				$data['media_item_type']			= 'BRAND';

				$ext 			= strtolower($fileObject->file_extention($_FILES['mediafiles']['name'][$i]));					
				$filename	= $data['media_code'].'.'.$ext;		
				$directory	= $zfsession->config['path'].'/media/dashboard/brand/'.$brandData['brand_code'].'/'.$data['media_code'];
				$file			= $directory.'/'.$filename;	
	
				if(!is_dir($directory)) mkdir($directory, 0777, true); 

				/* Create files for this brand type. */ 
				foreach($fileObject->image as $item) {
					/* Change file name. */
					$newfilename = str_replace($filename, $item['code'].$filename, $file);
					/* Resize media. */
					$fileObject->resize_crop_image($item['width'], $item['height'], $_FILES['mediafiles']['tmp_name'][$i], $newfilename);
				}

				$data['media_path']	= '/media/dashboard/brand/'.$brandData['brand_code'].'/'.$data['media_code'].'/';
				$data['media_ext']		= '.'.$ext ;
		
				/* Check for other medias. */
				$primary = $mediaObject->getPrimaryByItem('BRAND', $brandData['brand_code']);		
				
				if($primary) {
					$data['media_primary']	= 0;
				} else {
					$data['media_primary']	= 1;
				}
		
				$success	= $mediaObject->insert($data);	
			}
		}
		header('Location: /dashboard/brand/media.php?code='.$brandData['brand_code']);
		exit;
	}
	
	/* if we are here there are errors. */
	$smarty->assign('errorArray', $errorArray);
}

/* Display the template */	
$smarty->display('dashboard/brand/media.tpl');
$mediaObject = $errorArray = $data = $brandData = $primary = $ext = $newfilename = $uploadObject = $item = $i = $filename = $file = $directory = $fileObject = $formValid = $checkExt = null;
unset($mediaObject, $errorArray, $data, $brandData, $primary, $ext, $newfilename, $uploadObject, $item, $i, $filename, $file, $directory, $fileObject, $formValid, $checkExt);
?>