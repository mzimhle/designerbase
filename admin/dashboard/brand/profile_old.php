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

$brandObject	= new class_brand();
$mediaObject	= new class_media();
$fileObject		= new File(array('png', 'jpg', 'jpeg'));

if (isset($_GET['code']) && trim($_GET['code']) != '') {
	
	$code = trim($_GET['code']);
	
	$brandData = $brandObject->getByCode($code);

	if($brandData) {
		$smarty->assign('brandData', $brandData);
		
		$mediaData = $mediaObject->getByItem('PROFILE', $brandData['brand_code'], array('PHOTO'));

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
if(count($_POST) > 0) {
	$errorArray		= array();
	$data 				= array();
	$formValid		= true;
	$success			= NULL;
	$areaByName	= NULL;
	
	if(isset($_POST['brand_text']) && trim($_POST['brand_text']) == '') {
		$errorArray['brand_text'] = 'Location is required';
		$formValid = false;		
	}

	if(count($errorArray) == 0 && $formValid == true) {

		$data 	= array();
		$data['brand_text']	= trim($_POST['brand_text']);	

		$where	= $brandObject->getAdapter()->quoteInto('brand_code = ?', $brandData['brand_code']);
		$brandObject->update($data, $where);
		$success = $brandData['brand_code'];

		if(count($errorArray) == 0) {
			header('Location: /dashboard/brand/profile.php?code='.$success);
			exit;
		}
	}

	/* if we are here there are errors. */
	$smarty->assign('errorArray', $errorArray);	
}

/* Check posted data. */
if(count($_FILES) > 0 && count($_POST) == 0) {

	$errorArray	= array();
	$data		= array();
	$formValid	= true;
	$success	= NULL;

	if(isset($_FILES['mediafiles']['name']) && count($_FILES['mediafiles']['name']) > 0) {
		for($i = 0; $i < count($_FILES['mediafiles']['name']); $i++) {
			/* Check validity of the CV. */
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

	if(trim($errorArray['mediafiles']) == '' && $formValid == true) {
		
		if(isset($_FILES['mediafiles']) && count($_FILES['mediafiles']['name']) > 0) {
			for($i = 0; $i < count($_FILES['mediafiles']['name']); $i++) {				
				$data						= array();
				$data['media_code']			= $mediaObject->createCode();		
				$data['media_item_code']	= $brandData['brand_code'];
				$data['media_item_type']	= 'PROFILE';
				$data['media_category']		= 'PHOTO';

				$ext		= strtolower($fileObject->file_extention($_FILES['mediafiles']['name'][$i]));					
				$filename	= $data['media_code'].'.'.$ext;		
				$directory	= $zfsession->config['path'].'/media/brand/'.$brandData['brand_code'].'/'.$data['media_code'];
				$file			= $directory.'/'.$filename;	
	
				if(!is_dir($directory)) mkdir($directory, 0777, true);
				
				$newfilename = str_replace($filename, 'profile_'.$filename, $file);
				
				if(file_put_contents($newfilename,file_get_contents($_FILES['mediafiles']['tmp_name'][$i]))) {
					$data['media_path']	= '/media/brand/'.$brandData['brand_code'].'/'.$data['media_code'].'/';
					$data['media_ext']		= '.'.$ext ;
			
					/* Check for other medias. */
					$primary = $mediaObject->getPrimaryByItem('PROFILE', $brandData['brand_code']);		
					
					if($primary) {
						$data['media_primary']	= 0;
					} else {
						$data['media_primary']	= 1;
					}

					$success	= $mediaObject->insert($data);
				} else {
					$errorArray['mediafiles'] = 'Invalid file type something funny with the file format';
					$formValid = false;
				}
			}
		}
		header('Location: /dashboard/brand/profile.php?code='.$brandData['brand_code']);
		exit;
	}
	/* if we are here there are errors. */
	$smarty->assign('errorArray', $errorArray);
}

/* Display the template  */	
$smarty->display('dashboard/brand/profile.tpl');
?>