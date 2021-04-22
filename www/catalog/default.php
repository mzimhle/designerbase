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
/* Object */
$catalogObject 	= new class_catalog();
$advertObject	= new class_advert();
$itemObject		= new class_item();
$featureObject	= new class_feature();
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

if(isset($_REQUEST['sub_category_filter'])) {

	$category	= trim($_REQUEST['sub_category_filter']);

	$subCategoryData = $itemObject->getByParentType($category, 'SECTION');

	if($subCategoryData) {
		for($i = 0; $i < count($subCategoryData); $i++) {
			if(isset($parameter['filter_section'])) {
				if(in_array($subCategoryData[$i]['item_code'], $parameter['filter_section'])) {
					$subCategoryData[$i]['selected'] = 1;
					$filtering['filter_section'][] = $subCategoryData[$i]['item_name'];
				} else {
					$subCategoryData[$i]['selected'] = 0;
				}
			}
		}
		echo json_encode($subCategoryData);
	} else {
		echo json_encode(array());
	}
	exit;
}

$filters	= array();

if(isset($_REQUEST['filter_search']) && trim($_REQUEST['filter_search']) != '') $filters[] = array('filter_search' => trim($_REQUEST['filter_search']));
if(isset($_REQUEST['filter_category']) && trim($_REQUEST['filter_category']) != '') $filters[] = array('filter_category' => trim($_REQUEST['filter_category']));
if(isset($_REQUEST['filter_section']) && count($_REQUEST['filter_section']) != 0) $filters[] = array('filter_section' => $_REQUEST['filter_section']);
if(isset($_REQUEST['filter_gender']) && trim($_REQUEST['filter_gender']) != '') $filters[] = array('filter_gender' => $_REQUEST['filter_gender']);
if(isset($_REQUEST['filter_colour']) && count($_REQUEST['filter_colour']) != 0) $filters[] = array('filter_colour' => $_REQUEST['filter_colour']);

/* Get selected catagory. */
if(isset($_REQUEST['filter_category']) && trim($_REQUEST['filter_category']) != '') {
	$catagoryData = $itemObject->getByCode(trim($_REQUEST['filter_category']));
	if($catagoryData) $smarty->assign('catagoryData', $catagoryData);
}
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

/* Get features. */
$featureData = $itemObject->getByParentType('FEATURE');

if($featureData) {
		
	$featureColour		= array();
	$featureGender		= array();
	$featureSize		= array();
	$featureMaterial	= array();
	
	for($i = 0; $i < count($featureData); $i++) {
		
		$feature = $featureData[$i];
		
		if($feature['item_type'] == 'COLOUR') {
			$featureColour[] = $feature;
			if(isset($_REQUEST['filter_colour']) && in_array($feature['item_code'], $_REQUEST['filter_colour'])) {
				$filtering['filter_colour'][] = $feature['item_name'];
			}
		} else if($feature['item_type'] == 'GENDER') {
			$featureGender[] = $feature;
			if(isset($_REQUEST['filter_gender']) && $feature['item_code'] == $_REQUEST['filter_gender']) {
				$filtering['filter_gender'] = $feature['item_name'];
			}
		} else if($feature['item_type'] == 'SIZE') {
			$featureSize[] = $feature;
			if(isset($_REQUEST['filter_size']) && in_array($feature['item_code'], $_REQUEST['filter_size'])) {
				$filtering['filter_size'][] = $feature['item_name'];
			}
		} else if($feature['item_type'] == 'MATERIAL') {
			$featureMaterial[] = $feature;
			if(isset($_REQUEST['filter_material']) && in_array($feature['item_code'], $_REQUEST['filter_material'])) {
				$filtering['filter_material'][] = $feature['item_name'];
			}
		}
	}
	
	if(count($featureColour) > 0) 	$smarty->assign('featureColour', $featureColour);
	if(count($featureGender) > 0)	$smarty->assign('featureGender', $featureGender);
	if(count($featureSize) > 0)		$smarty->assign('featureSize', $featureSize);
	if(count($featureMaterial) > 0)	$smarty->assign('featureMaterial', $featureMaterial);
}
/* Get the categories. */ 
$categoryData = $itemObject->getByType('CATEGORY');
if($categoryData) $smarty->assign('categoryData', $categoryData);
/* Get the advert in the body of the home page. */
$advertVertical = $advertObject->dateRange('RECTVERTICAL', 'SIDEBAR', 'HOME');
if($advertVertical) $smarty->assign('advertVertical', $advertVertical);
/* Get the sections and add them to the section filter. */
if(isset($parameter['filter_section'])) {
	for($i = 0; $i < count($parameter['filter_section']); $i++) {
		$section = $itemObject->getByCode($parameter['filter_section'][$i]);
		if($section){
			$filtering['filter_section'][] = $section['item_name'];
		}
	}
}
/* Get the category that is currently being searched for. */
if(isset($parameter['filter_category'])) { 
	for($i = 0; $i < count($categoryData); $i++) {
		$category = $categoryData[$i];
		if($category['item_code'] == $parameter['filter_category']) {
			$filtering['filter_category'] = $category['item_name'];
			break;
		}
	}
}
/* Search filter text, get it and add it to the filtering variable. */
if(isset($parameter['filter_search'])) $filtering['filter_search'] = $parameter['filter_search'];
/* Assign filtering if there is anything filtered. */
if(count($filtering) > 0) $smarty->assign('filtering', $filtering);
/* Display the template */	
$smarty->display('catalog/default.tpl');
?>