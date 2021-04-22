<?php
/* Add this on all pages on top. */
set_include_path($_SERVER['DOCUMENT_ROOT'].'/'.PATH_SEPARATOR.$_SERVER['DOCUMENT_ROOT'].'/library/classes/');

error_reporting(E_ALL);
/*** Standard includes */
require_once 'config/database.php';
require_once 'includes/auth.php';
/* Get the session variable to make it global. */
global $zfsession;
// Clear the identity from the session
$page = explode('/',$_SERVER['REQUEST_URI']);

if(isset($page[3])) {
	/* Delete an item in the box. */
	$code = trim($page[3]);
	/* Go through the list of items in basket. */
	for($i = 0; $i < count($zfsession->basket); $i++) {
		$item = $zfsession->basket[$i];
		
		if($item['catalog_code'] == $code) {
			unset($zfsession->basket[$i]);
			break;
		}
	}
	$zfsession->basket = array_values($zfsession->basket);
} else {
	/* Delete everything. */
	$zfsession->basket = array();
}
//redirect to login page
header("Location: " . $_SERVER["HTTP_REFERER"]);
exit;
?>