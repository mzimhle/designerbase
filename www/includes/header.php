<?php
/* Add this on all pages on top. */
set_include_path($_SERVER['DOCUMENT_ROOT'].'/'.PATH_SEPARATOR.$_SERVER['DOCUMENT_ROOT'].'/library/classes/');

require_once 'config/database.php';
/* Auth for the entire website. */
require_once 'includes/auth.php';
/* Class files */
require_once 'class/item.php';
/*** Standard includes */
global $smarty;

$categoryObject = new class_item();
/* Get the categories. */ 
$categoryData = $categoryObject->getByType('CATEGORY');
if($categoryData) $smarty->assign('categoryData', $categoryData);

if(isset($_REQUEST['filter_search']) && trim($_REQUEST['filter_search']) != '') $smarty->assign('header_search', trim($_REQUEST['filter_search']));

 /* Display the template */	
$smarty->display('includes/header.tpl');
$categoryObject = $categoryData = null;
unset($categoryObject, $categoryData);
?>