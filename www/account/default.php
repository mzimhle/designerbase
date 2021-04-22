<?php
/* Add this on all pages on top. */
set_include_path($_SERVER['DOCUMENT_ROOT'].'/'.PATH_SEPARATOR.$_SERVER['DOCUMENT_ROOT'].'/library/classes/');

/*** Standard includes */
require_once 'config/database.php';
require_once 'config/smarty.php';
/* authorization */
require_once 'includes/auth.php';
/* Check posted data. */
if(count($_POST) > 0) {

	require_once 'class/participant.php';
	require_once 'class/media.php';
	require_once 'class/File.php';

	$participantObject	= new class_participant();
	$mediaObject		= new class_media();
	$fileObject			= new File(array('png', 'jpg', 'jpeg'));
	$errorArray			= array();
	$data				= array();

	if(isset($_POST['participant_name']) && trim($_POST['participant_name']) == '') {
		$errorArray[] = 'Please add a name';	
	}

	if(isset($_POST['participant_password']) && trim($_POST['participant_password']) == '') {
		$errorArray[] = 'Please add a password';	
	} else if(isset($_POST['participant_password_2']) && trim($_POST['participant_password_2']) == '') {
		$errorArray[] = 'Please retype password';
	} else {
		if(trim($_POST['participant_password']) != trim($_POST['participant_password_2'])) {
			$errorArray[] = 'Please make sure that the passwords are similar';	
		}
	}

	if(isset($_FILES['mediafile']['name']) && (int)$_FILES['mediafile']['size'] != 0 && trim($_FILES['mediafile']['name']) != '') {
		/* Check if its the right file. */
		$ext = $fileObject->file_extention($_FILES['mediafile']['name']); 

		if($ext != '') {
			$checkExt = $fileObject->getValidateExtention('mediafile', $ext);

			if(!$checkExt) {
				$errorArray[] = 'Invalid file type something funny with the file format';				
			}
		} else {
			$errorArray[] = 'Invalid file type';							
		}
	} else {
		switch((int)$_FILES['mediafile']['error']) {
			case 1 : $errorArray[] = 'The uploaded file exceeds the maximum upload file size, should be less than 1M'; break;
			case 2 : $errorArray[] = 'File size exceeds the maximum file size'; break;
			case 3 : $errorArray[] = 'File was only partically uploaded, please try again'; break;
			// case 4 : $errorArray[] = 'No file was uploaded'; break;
			case 6 : $errorArray[] = 'Missing a temporary folder'; break;
			case 7 : $errorArray[] = 'Faild to write file to disk'; break;
		}
	}

	if(count($errorArray) == 0) {
		$data							= array();			
		$data['participant_name']		= trim($_POST['participant_name']);
		$data['participant_password']	= trim($_POST['participant_password']);
		$data['participant_number']		= trim($_POST['participant_number']);
		$data['participant_code']		= trim($zfsession->identity);

		$where		= $participantObject->getAdapter()->quoteInto('participant_code = ?', $zfsession->identity);
		$success	= $participantObject->update($data, $where);

		if($success) {
			/* Success!! */
			$smarty->assign('success', $success);
			/* Upload the image. */
			if((int)$_FILES['mediafile']['size'] != 0 && trim($_FILES['mediafile']['name']) != '') {
				$data						= array();
				$data['media_code']			= $mediaObject->createCode();		
				$data['media_item_code']	= $zfsession->identity;
				$data['media_item_type']	= 'PARTICIPANT';
				$data['media_category']		= 'IMAGE';

				$ext		= strtolower($fileObject->file_extention($_FILES['mediafile']['name']));					
				$filename	= $data['media_code'].'.'.$ext;		
				$directory	= $_SERVER['DOCUMENT_ROOT'].'/media/participant/'.$zfsession->identity.'/'.$data['media_code'];
				$file		= $directory.'/'.$filename;
				/* Create the participant's folder */
				if(!is_dir($directory)) mkdir($directory, 0777, true); 
				/* Create files for this participant type. */ 
				foreach($fileObject->image as $participant) {
					/* Change file name. */
					$newfilename = str_replace($filename, $participant['code'].$filename, $file);
					/* Resize media. */
					$fileObject->resize_crop_image($participant['width'], $participant['height'], $_FILES['mediafile']['tmp_name'], $newfilename);
				}

				$data['media_path']	= '/media/participant/'.$zfsession->identity.'/'.$data['media_code'].'/';
				$data['media_ext']		= '.'.$ext ;
				/* Check for other medias. */
				$primary = $mediaObject->getPrimaryByItem('PARTICIPANT', $zfsession->identity, array('IMAGE'));		
				
				if($primary) {
					$data['media_primary']	= 0;
				} else {
					$data['media_primary']	= 1;
				}
				$success	= $mediaObject->insert($data);	
			}
		} else {
			$errorArray[] = 'We did not update your details, please try again';	
		}
	}

	$showerrors = implode('<br />', $errorArray);
	/* if we are here there are errors. */
	$smarty->assign('errorArray', $showerrors);
	/* Clear */
	$participantObject = $errorArray = $data = $emailData = $showerrors = $success = null;
	unset($participantObject, $errorArray, $data, $emailData, $showerrors, $success);
}
/* Display the template */	
$smarty->display('account/default.tpl');
?>