<?php

/* Add this on all pages on top. */
set_include_path($_SERVER['DOCUMENT_ROOT'].'/'.PATH_SEPARATOR.$_SERVER['DOCUMENT_ROOT'].'/library/classes/');

/*** Standard includes */
require_once 'config/database.php';
require_once 'config/smarty.php';

/**
 * Check for login
 */
require_once 'includes/auth.php'; 
require_once 'class/social.php';
 
$socialObject = new class_social();
 
 if(isset($_GET['delete_code'])) {
	
	$errorArray				= array();
	$errorArray['error']	= '';
	$errorArray['result']	= 0;	
	$formValid				= true;
	$success				= NULL;
	$code					= trim($_GET['delete_code']);
		
	if($errorArray['error']  == '' && $errorArray['result']  == 0 ) {
		$data	= array();
		$data['social_deleted'] = 1;
		
		$where 	= array();
		$where[] 	= $socialObject->getAdapter()->quoteInto('social_code = ?', $code);
		$success	= $socialObject->update($data, $where);	
		
		if(is_numeric($success) && $success > 0) {
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

	$start 		= isset($_REQUEST['iDisplayStart']) ? $_REQUEST['iDisplayStart'] : 0;
	$length 	= isset($_REQUEST['iDisplayLength']) ? $_REQUEST['iDisplayLength'] : 20;
	$socials 	= array();

	$socialData = $socialObject->getSearch($start, $length);
 
	if($socialData) {
		for($i = 0; $i < count($socialData['records']); $i++) {
			$item = $socialData['records'][$i];  
			$socials[$i] = array(
				(trim($item['media_code']) != '' ? '<img src="'.$zfsession->config['site'].$item['media_path'].$item['media_code'].$item['media_ext'].'" width="90px" />' : '<img src="/images/no-image.jpg" width="90px" />'),
				'<span class="'.(trim($item['social_active']) == '' ? '' : ((int)$item['social_active'] == 1 ? 'success' : 'error')).'"><a href="'.((int)$item['social_active'] == 1 ? '#' : '/social/details.php?code='.$item['social_code']).'">'.$item['social_message'].'</a></span>',
				trim($item['social_date']),
				(trim($item['social_active']) == '' ? 'Not sent' : substr(trim($item['social_sent_output']),0,150)),
				((int)$item['social_active'] == 1 ? 'Already sent' : '<button value="Delete" onclick="deleteModal(\''.$item['social_code'].'\', \'\', \'default\'); return false;">Delete</button>'));
		}
	}

	if($socialData) {
		$response['sEcho'] = $_REQUEST['sEcho'];
		$response['iTotalRecords'] = $socialData['displayrecords'];		
		$response['iTotalDisplayRecords'] = $socialData['count'];
		$response['aaData']	= $socials;
	} else {
		$response['result'] 	= false;
		$response['message']	= 'There are no items to show.';			
	}

	echo json_encode($response);
	die();

}

$smarty->display('social/default.tpl');
?>