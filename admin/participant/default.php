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

require_once 'class/participant.php';

$participantObject	= new class_participant(); 

 if(isset($_GET['delete_code'])) {
	
	$errorArray				= array();
	$errorArray['error']	= '';
	$errorArray['result']	= 0;	
	$formValid				= true;
	$code					= trim($_GET['delete_code']);
		
	if($errorArray['error']  == '' && $errorArray['result']  == 0 ) {

		$data							= array();
		$data['participant_deleted'] 	= 1;
		
		$where		= $participantObject->getAdapter()->quoteInto('participant_code = ?', $code);
		$success	= $participantObject->update($data, $where);	
		
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

	$participantData	= $participantObject->getSearch($start, $length, $filters);
	$participants		= array();

	if($participantData) {
		for($i = 0; $i < count($participantData['records']); $i++) {
			$item = $participantData['records'][$i];
			$participants[$i] = array(
				'<a href="/participant/details.php?code='.$item['participant_code'].'">'.$item['participant_name'].'</a>',
				$item['participant_email'],
				$item['participant_number'],
				$item['areapost_name'],
				$item['participant_address'],
				"<button value='Delete' onclick=\"deleteModal('".$item['participant_code']."', '', 'default'); return false;\">Delete</button>");
		}
	}

	if($participantData) {
		$response['sEcho'] = $_REQUEST['sEcho'];
		$response['iTotalRecords'] = $participantData['displayrecords'];		
		$response['iTotalDisplayRecords'] = $participantData['count'];
		$response['aaData']	= $participants;
	} else {
		$response['result'] 	= false;
		$response['message']	= 'There are no items to show.';			
	}

    echo json_encode($response);
    die();	
}

$smarty->display('participant/default.tpl');

?>