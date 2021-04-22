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

require_once 'class/comment.php';

$commentObject	= new class_comment(); 

if(isset($_GET['updateComment'])) {
	
	$errorArray				= array();
	$errorArray['error']	= '';
	$errorArray['result']	= 1;	
	$formValid				= true;
	$code					= trim($_GET['updateComment']);
	$status					= (int)trim($_GET['vetstatus']);

	$commentData = $commentObject->getByCode($code);

	if($commentData) {
		$data					= array();
		$data['comment_active']	= $status;

		$where		= $commentObject->getAdapter()->quoteInto('comment_code = ?', $code);
		$success	= $commentObject->update($data, $where);
	} else {
		$errorArray['error']	= 'Please select a comment';
		$errorArray['result']	= 0;
	}

	echo json_encode($errorArray);
	exit;
}

if(isset($_GET['getComment'])) {
	
	$errorArray				= array();
	$errorArray['error']	= '';
	$errorArray['result']	= 1;	
	$errorArray['data']		= array();	
	$formValid				= true;
	$code					= trim($_GET['getComment']);

	$commentData = $commentObject->getByCode($code);

	if($commentData) {	
		$errorArray['data']		= $commentData;	
	} else {
		$errorArray['error']	= 'Please select a comment';
		$errorArray['result']	= 0;
	}

	echo json_encode($errorArray);
	exit;
}

/* Setup Pagination. */
if(isset($_GET['action']) && trim($_GET['action']) == 'tablesearch') {
	
	$start 	= isset($_REQUEST['iDisplayStart']) ? $_REQUEST['iDisplayStart'] : 0;
	$length	= isset($_REQUEST['iDisplayLength']) ? $_REQUEST['iDisplayLength'] : 20;
	
	$filters = isset($_REQUEST['filter_text']) && trim($_REQUEST['filter_text']) != '' ? array('filter_text' => trim($_REQUEST['filter_text'])) : array();

	$commentData	= $commentObject->getSearch($start, $length, $filters);
	$comments		= array();

	if($commentData) {
		for($i = 0; $i < count($commentData['records']); $i++) {
			$item = $commentData['records'][$i];
			if($item['comment_active'] == 1) {
				$status = 'class="success"';
			} else if($item['comment_active'] == 0) {
				$status = 'class="error"';
			} else {
				$status = '';
			}
			$comments[$i] = array(
				"<a href='/catalog/details.php?code=".$item['catalog_code']."' target='blank'>".($item['media_code'] == '' ? "<img src='/images/avatar.jpg' width='60' />" : "<img src='".$zfsession->config['site'].$item['media_path']."/tny_".$item['media_code'].$item['media_ext']."'  width='60' />").'</a>',
				$item['catalog_name'],
				$item['rate_percent'].'%',
				"<span $status>".$item['comment_message'].'</span>',
				"<button value='Vet' class='btn btn-danger' onclick=\"commentVetModal('".$item['comment_code']."'); return false;\">Vet</button>");
		}
	}

	if($commentData) {
		$response['sEcho']					= $_REQUEST['sEcho'];
		$response['iTotalRecords']			= $commentData['displayrecords'];		
		$response['iTotalDisplayRecords']	= $commentData['count'];
		$response['aaData']					= $comments;
	} else {
		$response['result'] 	= false;
		$response['message']	= 'There are no items to show.';			
	}

    echo json_encode($response);
    die();	
}

$smarty->display('comment/default.tpl');

?>