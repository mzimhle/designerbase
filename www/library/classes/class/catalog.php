<?php

require_once "Zend/Paginator.php";
//custom account item class as account table abstraction
class class_catalog extends Zend_Db_Table_Abstract
{
   //declare table variables
    protected $_name		= 'catalog';
	protected $_primary		= 'catalog_code';
	protected $_account		= null;
	protected $_brand		= null;
	
	function init()	{
		global $zfsession;
	}
	/**
	 * get job by job catalog Id
 	 * @param string job id
     * @return object
	 */
	public function getByCode($code) {

		$comments = $this->_db->select()
			->from(array('comment' => 'comment'), array('comment_item_code as catalog_code', 'comment_count' => new Zend_Db_Expr('COUNT(IFNULL(comment.comment_code, 0))')))
			->joinLeft(array('rate' => 'rate'), "rate.rate_item_code = comment.comment_code and rate.rate_item_type = 'COMMENT'", array('rate_percent' => '(ifnull((rate.rate_number), 0)/10)*100'))
			->where("comment_deleted = 0 and comment_active = 1 and comment_item_type = 'CATALOG' and comment_item_code = ?", $code)
			->group('comment.comment_item_code');

		$select = $this->_db->select()
			->from(array('catalog' => 'catalog'))
			->joinLeft(array('item' => 'item'), "item.item_code = catalog.item_code")
			->joinLeft(array('itemparent' => 'item'), "itemparent.item_code = item.item_parent", array('item_code as item_parent_code', 'item_name as item_parent_name', 'item_url as item_parent_url'))
			->joinLeft(array('media' => 'media'), "media.media_category = 'IMAGE' and catalog.catalog_code = media.media_item_code and media.media_item_type = 'CATALOG' and media.media_primary = 1", array('media_code', 'media_path', 'media_ext'))
			->joinLeft(array('brand' => 'brand'), 'brand.brand_code = catalog.brand_code')
			->joinLeft(array('brandmedia' => 'media'), "brandmedia.media_category = 'IMAGE' and brand.brand_code = brandmedia.media_item_code and brandmedia.media_item_type = 'BRAND' and brandmedia.media_primary = 1", array('media_code as brand_media_code', 'media_path as brand_media_path', 'media_ext as brand_media_ext'))			
			->joinLeft(array('feature' => 'feature'), "feature.catalog_code = catalog.catalog_code and feature_deleted = 0 and feature_primary = 1", array())
			->joinLeft(array('price' => 'price'), "price.price_item_code = feature.feature_code and price_item_type = 'FEATURE' and price_deleted = 0 and price_active = 1", array('price_code', 'price_amount', 'price_original', 'price_discount'))
			->joinLeft(array('comment' => $comments), 'comment.catalog_code = catalog.catalog_code', array('round(ifnull(comment_count, 0)) as comment_count', 'round(ifnull(rate_percent, 0)) as rate_percent'))
			->where('catalog.catalog_code = ?', $code)
			->where("(media.media_code is not null or media.media_code != '') and (price.price_code is not null or price.price_code != '')")
			->limit(1);

		$result = $this->_db->fetchRow($select);
        return ($result == false) ? false : $result = $result;
	}
	/**
	 * get job by job catalog Id
 	 * @param string job id
     * @return object
	 */
	public function getFeatured($limit = 4) {

		$comments = $this->_db->select()
			->from(array('comment' => 'comment'), array('comment_item_code as catalog_code', 'comment_count' => new Zend_Db_Expr('COUNT(IFNULL(comment.comment_code, 0))')))
			->joinLeft(array('rate' => 'rate'), "rate.rate_item_code = comment.comment_code and rate.rate_item_type = 'COMMENT'", array('rate_percent' => '(ifnull((rate.rate_number), 0)/10)*100'))
			->where("comment_deleted = 0 and comment_active = 1 and comment_item_type = 'CATALOG'")
			->group('comment.comment_item_code');

		$select = $this->_db->select()
			->from(array('catalog' => 'catalog'))
			->joinLeft(array('item' => 'item'), "item.item_code = catalog.item_code")
			->joinLeft(array('itemparent' => 'item'), "itemparent.item_code = item.item_parent", array('item_code as item_parent_code', 'item_name as item_parent_name', 'item_url as item_parent_url'))
			->joinLeft(array('media' => 'media'), "media.media_category = 'IMAGE' and catalog.catalog_code = media.media_item_code and media.media_item_type = 'CATALOG' and media.media_primary = 1", array('media_code', 'media_path', 'media_ext'))
			->joinLeft(array('brand' => 'brand'), 'brand.brand_code = catalog.brand_code', array('brand_name', 'brand_url'))
			->joinLeft(array('feature' => 'feature'), "feature.catalog_code = catalog.catalog_code and feature_deleted = 0 and feature_primary = 1", array())
			->joinLeft(array('price' => 'price'), "price.price_item_code = feature.feature_code and price_item_type = 'FEATURE' and price_deleted = 0 and price_active = 1", array('price_code', 'price_amount', 'price_original', 'price_discount'))
			->joinLeft(array('comment' => $comments), 'comment.catalog_code = catalog.catalog_code', array('round(ifnull(comment_count, 0)) as comment_count', 'round(ifnull(rate_percent, 0)) as rate_percent'))
			->where("(media.media_code is not null or media.media_code != '') and (price.price_code is not null or price.price_code != '')")
			->limit($limit)
			->order('rand()');

		$result = $this->_db->fetchAll($select);
        return ($result == false) ? false : $result = $result;
	}
	/**
	 * get job by job catalog Id
 	 * @param string job id
     * @return object
	 */
	public function getSimilar($item, $exclude = array('no-existent'), $limit = 4) {

		$comments = $this->_db->select()
			->from(array('comment' => 'comment'), array('comment_item_code as catalog_code', 'comment_count' => new Zend_Db_Expr('COUNT(IFNULL(comment.comment_code, 0))')))
			->joinLeft(array('rate' => 'rate'), "rate.rate_item_code = comment.comment_code and rate.rate_item_type = 'COMMENT'", array('rate_percent' => '(ifnull((rate.rate_number), 0)/10)*100'))
			->where("comment_deleted = 0 and comment_active = 1 and comment_item_type = 'CATALOG'")
			->group('comment.comment_item_code');
					
		$select = $this->_db->select()
			->from(array('catalog' => 'catalog'))
			->joinLeft(array('item' => 'item'), "item.item_code = catalog.item_code")
			->joinLeft(array('itemparent' => 'item'), "itemparent.item_code = item.item_parent", array('item_code as item_parent_code', 'item_name as item_parent_name', 'item_url as item_parent_url'))
			->joinLeft(array('media' => 'media'), "media.media_category = 'IMAGE' and catalog.catalog_code = media.media_item_code and media.media_item_type = 'CATALOG' and media.media_primary = 1", array('media_code', 'media_path', 'media_ext'))
			->joinLeft(array('brand' => 'brand'), 'brand.brand_code = catalog.brand_code', array('brand_name', 'brand_url'))
			->joinLeft(array('feature' => 'feature'), "feature.catalog_code = catalog.catalog_code and feature_deleted = 0 and feature_primary = 1", array())
			->joinLeft(array('price' => 'price'), "price.price_item_code = feature.feature_code and price_item_type = 'FEATURE' and price_deleted = 0 and price_active = 1", array('price_code', 'price_amount', 'price_original', 'price_discount'))
			->joinLeft(array('comment' => $comments), 'comment.catalog_code = catalog.catalog_code', array('round(ifnull(comment_count, 0)) as comment_count', 'round(ifnull(rate_percent, 0)) as rate_percent'))	
			->where('catalog.item_code = ?', $item)
			->where("catalog.catalog_code not in(?)", $exclude)
			->where("(media.media_code is not null or media.media_code != '') and (price.price_code is not null or price.price_code != '')")
			->limit($limit)
			->order('rand()');

		$result = $this->_db->fetchAll($select);
        return ($result == false) ? false : $result = $result;
	}
	public function paginate($filter = array(), $page = 1, $perPage = 10, $listedPages = 10, $scrollingStyle = 'Sliding') {

		$where	= 'catalog_deleted = 0';

		if(count($filter) > 0) {
			for($i = 0; $i < count($filter); $i++) {
				if(isset($filter[$i]['filter_category']) && trim($filter[$i]['filter_category']) != '') {
					$filter[$i]['filter_category'] = $this->sanitize($filter[$i]['filter_category']);
					$where .= " and itemparent.item_code = '".$filter[$i]['filter_category']."' and itemparent.item_type = 'CATEGORY'";	
				} else if(isset($filter[$i]['filter_section']) && count($filter[$i]['filter_section']) != 0) {
					$where .= ' and (';
					for($f = 0; $f < count($filter[$i]['filter_section']); $f++) {
						$section = $this->sanitize($filter[$i]['filter_section'][$f]);
						$where .= "find_in_set(catalog.item_code, '".$section."')";
						if(($f+1) != count($filter[$i]['filter_section'])) {
							$where .= ' or ';
						}						
					}
					$where .= ') ';
				} else if(isset($filter[$i]['filter_colour']) && count($filter[$i]['filter_colour']) != 0) {
					$where .= ' and (';
					for($c = 0; $c < count($filter[$i]['filter_colour']); $c++) {
						$colour = $this->sanitize($filter[$i]['filter_colour'][$c]);
						$where .= "find_in_set('".$colour."', featuregroup.feature_code)";
						if(($c+1) != count($filter[$i]['filter_colour'])) {
							$where .= ' or ';
						}							
					}
					$where .= ') ';
				} else if(isset($filter[$i]['filter_gender']) && trim($filter[$i]['filter_gender']) != '') {
					$gender = $this->sanitize($filter[$i]['filter_gender']);
					$where .= " and find_in_set('".$gender."', feature.feature_code)";
				} else if(isset($filter[$i]['filter_brand']) && trim($filter[$i]['filter_brand']) != '') {
					$brand = $this->sanitize($filter[$i]['filter_brand']);
					$where .= " and catalog.brand_code = '$brand'";						
				} else if(isset($filter[$i]['filter_search']) && trim($filter[$i]['filter_search']) != '') {
					$array = explode(" ",trim($filter[$i]['filter_search']));					
					if(count($array) > 0) {
						$where .= " and (";
						for($z = 0; $z < count($array); $z++) {
							$text = $array[$z];
							$this->sanitize($text);
							$where .= "lower(concat_ws(catalog.catalog_name, catalog.catalog_text, featuregroup.feature_text, featuregroup.feature_name, item.item_name, brand.brand_name)) like lower('%$text%')";
							if(($z+1) != count($array)) {
								$where .= ' or ';
							}
						}
					}
					$where .= ")";
				}
			}
		}

		$feature = $this->_db->select()
			->from(array('feature' => 'feature'), array('catalog_code', "group_concat(feature_text separator ', ') as feature_text"))
			->joinLeft(array('item' => 'item'), "item.item_code = feature.item_code and item.item_parent = 'FEATURE'", array("group_concat(concat(item_name, if(item_type in('SIZE'), item_value, '')) separator ',') as feature_name, group_concat(item.item_code separator ', ') as feature_code"))
			->where("feature_deleted = 0 and feature_active = 1 and item_deleted = 0 and item_active = 1")
			->group('feature.catalog_code');

		$comments = $this->_db->select()
			->from(array('comment' => 'comment'), array('comment_item_code as catalog_code', 'comment_count' => new Zend_Db_Expr('COUNT(IFNULL(comment.comment_code, 0))')))
			->joinLeft(array('rate' => 'rate'), "rate.rate_item_code = comment.comment_code and rate.rate_item_type = 'COMMENT'", array('rate_percent' => '(ifnull((rate.rate_number), 0)/10)*100'))
			->where("comment_deleted = 0 and comment_active = 1 and comment_item_type = 'CATALOG'")
			->group('comment.comment_item_code');

		$select = $this->_db->select()
			->from(array('catalog' => 'catalog'))
			->joinLeft(array('item' => 'item'), "item.item_code = catalog.item_code", array('item_code', 'item_name', 'item_url'))
			->joinLeft(array('itemparent' => 'item'), "itemparent.item_code = item.item_parent", array('item_code as item_parent_code', 'item_name as item_parent_name', 'item_url as item_parent_url'))
			->joinLeft(array('media' => 'media'), "media.media_category = 'IMAGE' and catalog.catalog_code = media.media_item_code and media.media_item_type = 'CATALOG' and media.media_primary = 1", array('media_code', 'media_path', 'media_ext'))
			->joinLeft(array('brand' => 'brand'), 'brand.brand_code = catalog.brand_code', array('brand_name', 'brand_url'))
			->joinLeft(array('feature' => 'feature'), "feature.catalog_code = catalog.catalog_code and feature_deleted = 0 and feature_primary = 1", array())
			->joinLeft(array('price' => 'price'), "price.price_item_code = feature.feature_code and price_item_type = 'FEATURE' and price_deleted = 0 and price_active = 1", array('price_code', 'price_amount', 'price_original', 'price_discount'))
			->joinLeft(array('comment' => $comments), 'comment.catalog_code = catalog.catalog_code', array('round(ifnull(comment_count, 0)) as comment_count', 'round(ifnull(rate_percent, 0)) as rate_percent'))		
			->joinInner(array('featuregroup' => $feature), 'featuregroup.catalog_code = catalog.catalog_code')
			->where("(media.media_code is not null or media.media_code != '') and (price.price_code is not null or price.price_code != '')")
			->where($where);

		$paginator = Zend_Paginator::factory($select);
		$paginator->setCurrentPageNumber($page);
		$paginator->setItemCountPerPage($perPage);
		$paginator->setPageRange($listedPages);
		$paginator->setDefaultScrollingStyle($scrollingStyle);

		return $paginator;
	}

	/**
	 * get domain by domain Account Id
 	 * @param string domain id
     * @return object
	 */
	public function getCode($code) {
		$select = $this->_db->select()	
				->from(array('catalog' => 'catalog'))	
				->where('catalog_code = ?', $code)
				->limit(1);

		$result = $this->_db->fetchRow($select);	
		return ($result == false) ? false : $result = $result;					   
	}

    function sanitize($string) {
        return preg_replace("/[^a-zA-Z0-9_]+/", "", $string);
    }

    function sanitizeArray(&$array) {
		for($i = 0; $i < count($array); $i++) {
			$array[$i] = preg_replace("/[^a-zA-Z0-9_]+/", "", $array[$i]);
		}
    }
}
?>