<?php
/* Add this on all pages on top. */
set_include_path($_SERVER['DOCUMENT_ROOT'].'/'.PATH_SEPARATOR.$_SERVER['DOCUMENT_ROOT'].'/library/classes/');

/* standard config include. */
require_once 'config/database.php';
require_once 'config/smarty.php';

global $smarty;
//include the Zend class for Authentification
require_once 'Zend/Session.php';

// Set up the namespace
$zfsession	= new Zend_Session_Namespace('BASE_SITE');

$parse		= parse_ini_file($_SERVER['DOCUMENT_ROOT']."/config/settings.ini", true);

if(isset($parse[$_SERVER['HTTP_HOST']])) {
	$zfsession->config = $parse[$_SERVER['HTTP_HOST']];
} else {
	echo 'No settings file present...';
	exit;
}
/* Check for user log */
if (!isset($zfsession->identity) || is_null($zfsession->identity) || $zfsession->identity == '') {
	/* Check which link they are in and get out if its an account page or something else. */
} else {
	if(!isset($zfsession->participant)) {
		//instantiate the users class
		require_once 'class/participant.php';
		
		$participantObject 	= new class_participant();
		
		//get user details by username
		$participant = $participantObject->getByCode($zfsession->identity);

		/* participant selected supplier. */
		$zfsession->participant	= $participant;
		
		unset($participantObject);
	}
	$smarty->assign('participantData', $zfsession->participant);
}

/* Make sure we not in pages we not allowed. */
$url = explode('/', $_SERVER['REQUEST_URI']);

if(isset($url[1]) && trim($url[1]) == 'account' && (!isset($zfsession->identity) || $zfsession->identity == '')) {
    header('Location: /');
    exit;
}
/* Add the basket session array. */
if(!isset($zfsession->basket)) {
	$zfsession->basket = array();
}
/* Totals and array to hold all codes of items in basket. */
$zfsession->baskettotal	= 0;
$basketlist		        = array();
if(count($zfsession->basket) > 0) {
	/* Get a total for each basket and add to total. */
	for($i = 0; $i < count($zfsession->basket); $i++) {
		$zfsession->basket[$i]['basket_total'] = $zfsession->basket[$i]['price_amount'] * $zfsession->basket[$i]['basket_quantity'];
		$zfsession->baskettotal += $zfsession->basket[$i]['basket_total'];
		$basketlist[] = $zfsession->basket[$i]['catalog_code'];
	}
	/* Add the grand total without delivery. */
	$zfsession->basketgrandtotal = $zfsession->baskettotal;

	if(isset($zfsession->participant['areapostregion_id']) && trim($zfsession->participant['areapostregion_id']) != '') {
	    /* Ge the delivery cost. */
        $zfsession->checkoutdelivery    = $zfsession->config['delivery_'.$zfsession->participant['areapostregion_id']];
        /* Get the grand total added with the delivery cost. */
        $zfsession->basketgrandtotal += $zfsession->checkoutdelivery;
        /* The delivery cost. */
        $smarty->assign('checkoutdelivery', $zfsession->checkoutdelivery);
	}
	    
	/* Assign the basket to smarty. */
	$smarty->assign('basket', $zfsession->basket);	
}

/* Assign config since it exists. */
$smarty->assign('config', $zfsession->config);
$smarty->assign('baskettotal', $zfsession->baskettotal);	
$smarty->assign('basketgrandtotal', $zfsession->basketgrandtotal);
$smarty->assign('basketlist', $basketlist);
global $zfsession;
?>