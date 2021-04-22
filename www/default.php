<?php
/* Add this on all pages on top. */
set_include_path($_SERVER['DOCUMENT_ROOT'].'/'.PATH_SEPARATOR.$_SERVER['DOCUMENT_ROOT'].'/library/classes/');

/*** Standard includes*/
require_once 'config/database.php';
require_once 'config/smarty.php';
/* Auth for the entire website. */
require_once 'includes/auth.php';
/* Classes. */
require_once 'class/advert.php';
require_once 'class/item.php';
/* Objects. */
$advertObject		= new class_advert();
$categoryObject		= new class_item();
/* Get the banner adverts if there are any. */
$advertBanner = $advertObject->dateRange('BANNER', 'TOP', 'HOME');
if($advertBanner) $smarty->assign('advertBanner', $advertBanner);
/* Get the advert in the body of the home page. */
$advertHorizontal = $advertObject->dateRange('RECTHORIZONTAL', 'PAGE', 'HOME');
if($advertHorizontal) $smarty->assign('advertHorizontal', $advertHorizontal);
/* Get the advert in the body of the home page. */
$advertVertical = $advertObject->dateRange('RECTVERTICAL', 'SIDEBAR', 'HOME');
if($advertVertical) $smarty->assign('advertVertical', $advertVertical);
/* Get the featured products */
$featuredProduct = $advertObject->dateRange('PRODUCT', 'FEATURED', 'HOME');
if($featuredProduct) $smarty->assign('featuredProduct', $featuredProduct);
/* Get the categories. */ 
$categoryData = $categoryObject->getByType('CATEGORY');
if($categoryData) $smarty->assign('categoryData', $categoryData);
/* Display the template */
$smarty->display('default.tpl');
$advertObject = $categoryObject = $catalogObject = $advertBanner = $advertHorizontal = $advertVertical = $categoryData = $featuredProduct = $errorArray = $participantObject = null;
unset($advertObject, $categoryObject, $catalogObject, $advertBanner, $advertHorizontal, $advertVertical, $categoryData, $featuredProduct, $errorArray, $participantObject);
?>