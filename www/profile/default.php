<?php
/* Add this on all pages on top. */
set_include_path($_SERVER['DOCUMENT_ROOT'].'/'.PATH_SEPARATOR.$_SERVER['DOCUMENT_ROOT'].'/library/classes/');

require_once 'config/database.php';
require_once 'config/smarty.php';
/* Auth for the entire website. */
require_once 'includes/auth.php';
/* objects. */
require_once 'class/catalog.php';
require_once 'class/advert.php';
require_once 'class/item.php';
require_once 'class/feature.php';
require_once 'class/brand.php';
/* Object */
$catalogObject 	= new class_catalog();
$advertObject	= new class_advert();
$itemObject		= new class_item();
$featureObject	= new class_feature();
$brandObject	= new class_brand();
/* Get the designer. */
$url = trim($_REQUEST['code']);

if($url == '') {
    header('Location: /404');
    exit;
} else {
    $brandData = $brandObject->getByUrl($url);
    
    if(!$brandData) {
        header('Location: /404');
        exit;
    } else {
        $smarty->assign('brandData', $brandData);
    }
}

/* Get the query from the url */
$querystring	= parse_str($_SERVER['QUERY_STRING'], $parameter);
$filtering		= array();

if($parameter) {
	/* Remove page parameter as we already have it. */
	unset($parameter['page']);
	/* Assign url strings and array. */
	$smarty->assign('querystring', http_build_query($parameter));
	$smarty->assign('parameter', $parameter);
}

$filters	= array();
$filters[]  = array('filter_brand' => $brandData['brand_code']);
/* Pagination parameters. */
$page			= isset($_GET['page']) 		? $_GET['page']		: 1;
$perPage		= isset($_GET['perPage'])	? $_GET['perPage']	: 20;
/* Get paginated items. */
$catalogData	= $catalogObject->paginate($filters, $page, $perPage);
$catalogItems	= $catalogData->getCurrentItems();

if($catalogItems) {
	/* Get features. */
	for($i = 0; $i < count($catalogItems); $i++) {
		$featureData = $featureObject->getByCatalog($catalogItems[$i]['catalog_code']);
		$catalogItems[$i]['features'] = $featureData != false ? $featureData : array();
	}
	/* Paginator. */
	$paginator	= $catalogData->setView()->getPages();
	$smarty->assign('paginator', $paginator);
	$smarty->assign('catalogItems', $catalogItems);
}

/* Display the template */	
$smarty->display('profile/default.tpl');
?>