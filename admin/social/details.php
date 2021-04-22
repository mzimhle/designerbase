<?php
/* Add this on all pages on top. */
set_include_path($_SERVER['DOCUMENT_ROOT'].'/'.PATH_SEPARATOR.$_SERVER['DOCUMENT_ROOT'].'/library/classes/');

/* Standard includes */
require_once 'config/database.php';
require_once 'config/smarty.php';
/* Check for login */
require_once 'includes/auth.php';
/* objects. */
require_once 'class/social.php';
require_once 'class/media.php';
require_once 'class/File.php';

$socialObject	= new class_social();
$mediaObject	= new class_media(); 
$fileObject		= new File(array('png', 'jpg', 'jpeg'));

if (isset($_GET['code']) && trim($_GET['code']) != '') {
	
	$code = trim($_GET['code']);
	
	$socialData = $socialObject->getByCode($code);

	if($socialData) {
		$smarty->assign('socialData', $socialData);
	} else {
		header('Location: /social/');
		exit;
	}
}

if(isset($_REQUEST['create_bit'])) {

	$url = $socialObject->createBit(trim($_REQUEST['create_bit']));
	echo $url;
	die();
}

/* Check posted data. */
if(count($_POST) > 0) {

	$errorArray	= array();
	$data		= array();
	$formValid	= true;
	$success	= NULL;

	if(!isset($_POST['social_message'])) {
		$errorArray['social_message'] = 'Message is required';
	} else if((strlen(trim($_POST['social_message'])) == 0) || (strlen(trim($_POST['social_message'])) > 140)){
		$errorArray['social_message'] = 'Message needs to be less than 140 characters.';
	}

	if(!isset($_POST['social_date'])) {
		$errorArray['social_date'] = 'Please add a date to send this';
	} else if(trim($_POST['social_date']) == '') {
		$errorArray['social_date'] = 'Please add a date to send this';
	}

	if((int)$_FILES['mediafile']['size'] != 0 && trim($_FILES['mediafile']['name']) != '') {
		/* Check if its the right file. */
		$ext = $fileObject->file_extention($_FILES['mediafile']['name']); 
		
		if($ext != '') {

			$checkExt = $fileObject->getValidateExtention('mediafile', $ext);

			if(!$checkExt) {
				$errorArray['mediafile'] = 'Invalid file type something funny with the file format';					
			}
		} else {
			$errorArray['mediafile'] = 'Invalid file type';							
		}

	} else {			
		switch((int)$_FILES['mediafile']['error']) {
			case 1 : $errorArray['mediafile'] = 'The uploaded file exceeds the maximum upload file size, should be less than 1M'; break;
			case 2 : $errorArray['mediafile'] = 'File size exceeds the maximum file size'; break;
			case 3 : $errorArray['mediafile'] = 'File was only partically uploaded, please try again'; break;
			// case 4 : $errorArray['mediafile'] = 'No file was uploaded'; break;
			case 6 : $errorArray['mediafile'] = 'Missing a temporary folder'; break;
			case 7 : $errorArray['mediafile'] = 'Faild to write file to disk'; break;
		}
	}
	
	if(count($errorArray) == 0) {

		$data 	= array();				
		$data['social_message']	= trim($_POST['social_message']);		
		$data['social_date']	= trim($_POST['social_date']);	

		if(isset($socialData)) {
			$where		= $socialObject->getAdapter()->quoteInto('social_code = ?', $socialData['social_code']);
			$success	= $socialObject->update($data, $where);
			$success	= $socialData['social_code'];
		} else {
			$success = $socialObject->insert($data);
		}

		/* Add file if there are any. */
		if((int)$_FILES['mediafile']['size'] != 0 && trim($_FILES['mediafile']['name']) != '') {

			$data						= array();
			$data['media_code']			= $mediaObject->createCode();		
			$data['media_item_code']	= $success;
			$data['media_item_type']	= 'SOCIAL';			

			$ext		= strtolower($fileObject->file_extention($_FILES['mediafile']['name']));					
			$filename	= $data['media_code'].'.'.$ext;
			$directory	= $zfsession->config['path'].'/media/social/'.$data['media_code'];
			$file		= $directory.'/'.$filename;

			if(!is_dir($directory)) mkdir($directory, 0777, true);			
			/* Check if the file has been uploaded. */
			if(file_put_contents($file,file_get_contents($_FILES['mediafile']['tmp_name']))) {
				/* Check for other medias. */
				$primary = $mediaObject->getPrimaryByItem('SOCIAL', $success);		

				if($primary) {
					$data['media_primary']	= 0;
				} else {
					$data['media_primary']	= 1;
				}

				$data['media_path']	= '/media/social/'.$data['media_code'].'/';
				$data['media_ext']	= '.'.$ext ;

				$successfull = $mediaObject->insert($data);

				if($successfull) {
					$mediaObject->updatePrimaryByItem('SOCIAL', $success, $successfull);
				}
			} else {
				$errorArray['mediafile'] = 'We could not upload file, please try again';
			}
		}
		if(count($errorArray) == 0) {
			header('Location: /social/');	
			exit;
		}
	}
	/* if we are here there are errors. */
	$smarty->assign('errorArray', $errorArray);

}

$smarty->display('social/details.tpl');

?>