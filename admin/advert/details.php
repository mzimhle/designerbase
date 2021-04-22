<?php
/* Add this on all pages on top. */
set_include_path($_SERVER['DOCUMENT_ROOT'].'/'.PATH_SEPARATOR.$_SERVER['DOCUMENT_ROOT'].'/library/classes/');

/*** Standard includes */
require_once 'config/database.php';
require_once 'config/smarty.php';
/*** Check for login */
require_once 'includes/auth.php';
/* objects. */
require_once 'class/advert.php';
require_once 'class/media.php';
require_once 'class/File.php';
require_once 'class/catalog.php';
require_once 'class/link.php';

$advertObject	= new class_advert();
$mediaObject	= new class_media();
$fileObject		= new File(array('png', 'jpg', 'jpeg'));
$catalogObject	= new class_catalog();
$linkObject	    = new class_link();

if (isset($_GET['code']) && trim($_GET['code']) != '') {
	
	$code = trim($_GET['code']);
	
	$advertData = $advertObject->getByCode($code);

	if($advertData) {
		$smarty->assign('advertData', $advertData);
        /* Advert images. */
		$mediaData = $mediaObject->getByItem('ADVERT', $code);
		if($mediaData) $smarty->assign('mediaData', $mediaData);
        /* Advert products. */
		$linkData = $linkObject->getByParent('ADVERT', $code, 'CATALOG');
		if($linkData) $smarty->assign('linkData', $linkData);  
	} else {
		header('Location: /advert/');
		exit;		
	}
}
/* Check posted data. */
if(isset($_GET['status_code'])) {

	$errorArray				= array();
	$errorArray['error']	= '';
	$errorArray['result']	= 0;
	$advertcode			= trim($_GET['status_code']);

	$mediaItem = $mediaObject->getByCode($advertcode);

	if($mediaItem) {
		$mediaObject->updatePrimaryByItem('ADVERT', $advertData['advert_code'], $advertcode, array('IMAGE'));	
	} else {
		$errorArray['error']	= 'Did not update';
		$errorArray['result']	= 1;		
	}

	$errorArray['error']	= '';
	$errorArray['result']	= 1;				

	echo json_encode($errorArray);
	exit;
}
/* Check posted data. */
if(isset($_GET['deletefeature'])) {

	$errorArray				= array();
	$errorArray['error']	= '';
	$errorArray['result']	= 0;	
	$formValid				= true;
	$success				= NULL;
	$featurecode				= trim($_GET['featurecode']);

	if($errorArray['error']  == '' && $errorArray['result']  == 0 ) {
		$data					= array();
		$data['link_deleted']	= 1;

		$where		= array();
		$where[]	= $linkObject->getAdapter()->quoteInto('link_code = ?', $featurecode);
		$success	= $linkObject->update($data, $where);	

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
if(isset($_GET['delete_code'])) {

	$errorArray				= array();
	$errorArray['error']	= '';
	$errorArray['result']	= 0;	
	$formValid				= true;
	$success				= NULL;
	$advertcode				= trim($_GET['delete_code']);

	if($errorArray['error']  == '' && $errorArray['result']  == 0 ) {
		$data					= array();
		$data['media_deleted']	= 1;

		$where		= array();
		$where[]	= $mediaObject->getAdapter()->quoteInto('media_code = ?', $advertcode);
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
if(count($_POST) > 0 && !isset($_FILES['mediafiles']) && !isset($_POST['image_link']) && !isset($_POST['catalog_link'])) {
	$errorArray	= array();
	$data		= array();
	
	if(isset($_POST['advert_type']) && trim($_POST['advert_type']) == '') {
		$errorArray['advert_type'] = 'Please add a type';	
	} else {
		if(isset($_POST['advert_page']) && trim($_POST['advert_page']) == '') {
			$errorArray['advert_page'] = 'Please add a page';	
		} else if(isset($_POST['advert_position']) && trim($_POST['advert_position']) == '') {
			$errorArray['advert_position'] = 'Please add the position';
		} else {
			if(isset($_POST['advert_date_start']) && trim($_POST['advert_date_start']) != '') {
				if(!$advertObject->validateDate(trim($_POST['advert_date_start']))) {
					$errorArray['advert_date_start'] = 'Please add a start date';	
				}
			}
			if(isset($_POST['advert_date_end']) && trim($_POST['advert_date_end']) != '') {
				if(!$advertObject->validateDate(trim($_POST['advert_date_end']))) {
					$errorArray['advert_date_end'] = 'Please add an end date';	
				}
			}
			if(count($errorArray) == 0) {
				
				$checkCode = isset($advertData) ? $advertData['advert_code'] : null;
				$checkDate = $advertObject->dateRange(trim($_POST['advert_type']), trim($_POST['advert_position']), trim($_POST['advert_page']), trim($_POST['advert_date_start']), trim($_POST['advert_date_end']), $checkCode);

				if($checkDate) {
					$errorArray['advert_date_start'] = 'Date has already been assigned to another advert';	
				}
			}
		}
	}

	if(count($errorArray) == 0) {

		$data						= array();		
		$data['advert_position']	= trim($_POST['advert_position']);		
		$data['advert_text']		= trim($_POST['advert_text']);	
		$data['advert_type']		= trim($_POST['advert_type']);	
		$data['advert_url']			= trim($_POST['advert_url']);
		$data['advert_page']		= trim($_POST['advert_page']);
		$data['advert_date_start']	= trim($_POST['advert_date_start']);
		$data['advert_date_end']	= trim($_POST['advert_date_end']);

		if(!isset($advertData)) {
			$success	= $advertObject->insert($data);				
		} else {
			$where		= $advertObject->getAdapter()->quoteInto('advert_code = ?', $advertData['advert_code']);
			$advertObject->update($data, $where);		
			$success 	= $advertData['advert_code'];			
		}
		
		header('Location: /advert/details.php?code='.$success);
		exit;
	}
}

/* Check posted data. */
if(count($_POST) > 0 && isset($_POST['catalog_link'])) {
	$errorArray	= array();
	$data		= array();

	if(isset($_POST['catalog_code']) && trim($_POST['catalog_code']) == '') {
		$errorArray['catalog_code'] = 'Please add a catalog code';
	} else {
        $catalogData = $catalogObject->getByCode(strtoupper(trim($_POST['catalog_code'])), false);
        
        if(!$catalogData) {
           $errorArray['catalog_code'] = 'Code added does not exist.';
        } else {
            $linkData = $linkObject->checkExists('ADVERT', $advertData['advert_code'], 'CATALOG', strtoupper(trim($_POST['catalog_code'])));
            
            if($linkData) {
                $errorArray['catalog_code'] = 'Code has already been linked to this advert.';
            }
        }
	}

	if(count($errorArray) == 0) {

		$data						= array();		
		$data['link_parent_type']	= 'ADVERT';		
		$data['link_parent_code']   = $advertData['advert_code'];	
		$data['link_child_type']    = 'CATALOG';	
		$data['link_child_code']    = strtoupper(trim($_POST['catalog_code']));

		$success	= $linkObject->insert($data);				

		header('Location: /advert/details.php?code='.$advertData['advert_code']);
		exit;
	}
}

if(isset($advertData) && isset($_FILES['mediafiles']) && trim($_FILES['mediafiles']['name']) != '' && isset($_POST['image_link'])) {
	/* Upload images. */
	if(isset($_FILES['mediafiles']['name']) && trim($_FILES['mediafiles']['name']) != '') {
		if((int)$_FILES['mediafiles']['size'] != 0 && trim($_FILES['mediafiles']['name']) != '') {
			/* Check if its the right file. */
			$ext = $fileObject->file_extention($_FILES['mediafiles']['name']); 

			if($ext != '') {
				$checkExt = $fileObject->getValidateExtention('mediafiles', $ext);
				if(!$checkExt) {
					$errorArray['mediafiles'] = 'Invalid file type something funny with the file format';
					$formValid = false;						
				}
			} else {
				$errorArray['mediafiles'] = 'Invalid file type';
				$formValid = false;									
			}
		} else {
			switch((int)$_FILES['mediafiles']['error']) {
				case 1 : $errorArray['mediafiles'] = 'The uploaded file exceeds the maximum upload file size, should be less than 1M'; $formValid = false; break;
				case 2 : $errorArray['mediafiles'] = 'File size exceeds the maximum file size'; $formValid = false; break;
				case 3 : $errorArray['mediafiles'] = 'File was only partically uploaded, please try again'; $formValid = false; break;
				case 4 : $errorArray['mediafiles'] = 'No file was uploaded'; $formValid = false; break;
				case 6 : $errorArray['mediafiles'] = 'Missing a temporary folder'; $formValid = false; break;
				case 7 : $errorArray['mediafiles'] = 'Faild to write file to disk'; $formValid = false; break;
			}
		}
		/* Upload images */
		if(!isset($errorArray['mediafiles'])) {
			if(isset($_FILES['mediafiles']) && (int)$_FILES['mediafiles']['size'] > 0) {
				$data						= array();
				$data['media_code']			= $mediaObject->createCode();
				$data['media_item_code']	= $advertData['advert_code'];
				$data['media_item_type']	= 'ADVERT';
				$data['media_text']			= trim($_POST['media_text']);
				$data['media_url']			= trim($_POST['media_url']);

				$ext		= strtolower($fileObject->file_extention($_FILES['mediafiles']['name']));
				$filename	= $data['media_code'].'.'.$ext;		
				$directory	= $zfsession->config['path'].'/media/advert/'.$advertData['advert_code'].'/';
				$file		= $directory.$filename;	

				if(!is_dir($directory)) mkdir($directory, 0777, true); 

				if(file_put_contents($file,file_get_contents($_FILES['mediafiles']['tmp_name']))) {
					$data['media_path']	= '/media/advert/'.$advertData['advert_code'].'/';
					$data['media_ext']	= '.'.$ext ;
					/* Check for other medias. */
					$primary = $mediaObject->getPrimaryByItem('ADVERT', $advertData['advert_code']);
					if($primary) {
						$data['media_primary']	= 0;
					} else {
						$data['media_primary']	= 1;
					}
					
					if($mediaObject->insert($data)) {
						header('Location: /advert/details.php?code='.$advertData['advert_code']);
						exit;							
					} else {
						$errorArray['mediafiles'] = 'Faild to write file to disk'; 
						$formValid = false; break;							
					}
				}
			}
		}
	}
}

/* if we are here there are errors. */
if(isset($errorArray)) $smarty->assign('errorArray', $errorArray);	
	
$smarty->display('advert/details.tpl');

?>