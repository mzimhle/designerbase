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
require_once 'class/catalog.php';
require_once 'class/media.php';
require_once 'class/File.php';

$catalogObject		= new class_catalog();
$mediaObject		= new class_media();
$fileObject			= new File(array('png', 'jpg', 'jpeg'));
$transparentObject	= new File(array('png'));

if (isset($_GET['code']) && trim($_GET['code']) != '') {
	
	$code = trim($_GET['code']);
	
	$catalogData = $catalogObject->getByCode($code);

	if($catalogData) {
		$smarty->assign('catalogData', $catalogData);

		$mediaData = $mediaObject->getByItem('CATALOG', $catalogData['catalog_code'], array('IMAGE', 'TRANSPARENT'));

		if($mediaData) {
			$smarty->assign('mediaData', $mediaData);
		}
	} else {
		header('Location: /catalog/');
		exit;	
	}
	
} else {
	header('Location: /catalog/');
	exit;	
}

/* Check posted data. */
if(isset($_GET['delete_code'])) {

	$errorArray				= array();
	$errorArray['error']	= '';
	$errorArray['result']	= 0;	
	$formValid				= true;
	$success					= NULL;
	$catalogcode					= trim($_GET['delete_code']);

	if($errorArray['error']  == '' && $errorArray['result']  == 0 ) {
		$data	= array();
		$data['media_deleted'] = 1;

		$where		= array();
		$where[]	= $mediaObject->getAdapter()->quoteInto('media_code = ?', $catalogcode);

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
	$catalogcode			= trim($_GET['status_code']);

	$mediaItem = $mediaObject->getByCode($catalogcode);

	if($catalogData) {
		$mediaObject->updatePrimaryByItem('CATALOG', $catalogData['catalog_code'], $catalogcode, array($mediaItem['media_category']));	
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
	} else {
		if(isset($_FILES['mediafiles']['name']) && count($_FILES['mediafiles']['name']) > 0) {
			for($i = 0; $i < count($_FILES['mediafiles']['name']); $i++) {
				if((int)$_FILES['mediafiles']['size'][$i] != 0 && trim($_FILES['mediafiles']['name'][$i]) != '') {
					/* Check if its the right file. */
					$ext = $fileObject->file_extention($_FILES['mediafiles']['name'][$i]); 

					if($ext != '') {
						if(trim($_POST['media_category']) == 'IMAGE') {
							$checkExt = $fileObject->getValidateExtention('mediafiles', $ext, $i);
						} else if(trim($_POST['media_category']) == 'TRANSPARENT') {
							$checkExt = $transparentObject->getValidateExtention('mediafiles', $ext, $i);
						}

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
	}
	if(count($errorArray) == 0 && $formValid == true) {
		if(isset($_FILES['mediafiles']) && count($_FILES['mediafiles']['name']) > 0) {
			for($i = 0; $i < count($_FILES['mediafiles']['name']); $i++) {				
				$data 								= array();
				$data['media_code']			= $mediaObject->createCode();		
				$data['media_item_code']	= $catalogData['catalog_code'];
				$data['media_item_type']	= 'CATALOG';
				$data['media_category']		= trim($_POST['media_category']);

				$ext		= strtolower($fileObject->file_extention($_FILES['mediafiles']['name'][$i]));					
				$filename	= $data['media_code'].'.'.$ext;		
				$directory	= $zfsession->config['path'].'/media/catalog/'.$catalogData['catalog_code'].'/'.$data['media_code'];
				$file		= $directory.'/'.$filename;	

				if(!is_dir($directory)) mkdir($directory, 0777, true); 
				
				if(trim($_POST['media_category']) == 'IMAGE') {
					/* Create files for this catalog type. */ 
					foreach($fileObject->image as $catalog) {
						/* Change file name. */
						$newfilename = str_replace($filename, $catalog['code'].$filename, $file);
						/* Resize media. */
						$fileObject->resize_crop_image($catalog['width'], $catalog['height'], $_FILES['mediafiles']['tmp_name'][$i], $newfilename);
					}
				} else if(trim($_POST['media_category']) == 'TRANSPARENT') {
					$newfilename = str_replace($filename, 'transparent_'.$filename, $file);
					file_put_contents($newfilename,file_get_contents($_FILES['mediafiles']['tmp_name'][$i]));
				}

				$data['media_path']	= '/media/catalog/'.$catalogData['catalog_code'].'/'.$data['media_code'].'/';
				$data['media_ext']		= '.'.$ext ;
				/* Check for other medias. */
				$primary = $mediaObject->getPrimaryByItem('CATALOG', $catalogData['catalog_code'], array($data['media_category']));		
				
				if($primary) {
					$data['media_primary']	= 0;
				} else {
					$data['media_primary']	= 1;
				}
		
				$success	= $mediaObject->insert($data);	
			}
		}
		header('Location: /catalog/media.php?code='.$catalogData['catalog_code']);
		exit;
	}
	
	/* if we are here there are errors. */
	$smarty->assign('errorArray', $errorArray);
}

/* Display the template */	
$smarty->display('catalog/media.tpl');
$mediaObject = $errorArray = $data = $catalogData = $primary = $ext = $newfilename = $uploadObject = $catalog = $i = $filename = $file = $directory = $fileObject = $formValid = $checkExt = null;
unset($mediaObject, $errorArray, $data, $catalogData, $primary, $ext, $newfilename, $uploadObject, $catalog, $i, $filename, $file, $directory, $fileObject, $formValid, $checkExt);
?>