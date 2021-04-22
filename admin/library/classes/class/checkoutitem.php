<?php

//custom account item class as account table abstraction
class class_checkoutitem extends Zend_Db_Table_Abstract
{
   //declare table variables
    protected $_name	= 'checkoutitem';
	protected $_primary	= 'checkoutitem_code';
	/**
	 * get domain by domain Account Id
 	 * @param string domain id
     * @return object
	 */
	public function getByCheckout($code) {
		$select = $this->_db->select()	
			->from(array('checkoutitem' => 'checkoutitem'), array('checkoutitem_code', 'checkoutitem_quantity', 'checkoutitem_amount', 'checkoutitem_note', 'checkoutitem_delivery', '(checkoutitem_amount*checkoutitem_quantity) as checkoutitem_amount_total'))	
			->joinInner(array('checkout' => 'checkout'), 'checkoutitem.checkout_code = checkout.checkout_code', array('checkout_code', 'checkout_added', 'checkout_address', 'checkout_amount_delivery', 'checkout_email', 'checkout_status_code', 'checkout_status_text'))
			->joinInner(array('price' => 'price'), 'price.price_code = checkoutitem.price_code', array('price_code', 'price_amount', 'price_original', 'price_discount'))
			->joinInner(array('feature' => 'feature'), "price.price_item_code = feature.feature_code and price_item_type = 'FEATURE'")
			->joinInner(array('catalog' => 'catalog'), 'catalog.catalog_code = feature.catalog_code', array('catalog_name', 'catalog_text'))
			->joinInner(array('item' => 'item'), "item.item_code = catalog.item_code", array('item_name'))
			->joinInner(array('brand' => 'brand'), 'brand.brand_code = catalog.brand_code', array('brand_name', 'brand_email', 'brand_delivery', 'brand_number', 'DATE_ADD(checkout_added,INTERVAL brand_delivery WEEK) as brand_delivery_date'))
			->joinInner(array('itemparent' => 'item'), "itemparent.item_code = item.item_parent", array('item_code as item_parent_code', 'item_name as item_parent_name'))		
			->joinInner(array('media' => 'media'), "media.media_category = 'IMAGE' and catalog.catalog_code = media.media_item_code and media.media_item_type = 'CATALOG' and media.media_primary = 1", array('media_code', 'media_path', 'media_ext'))
			->joinInner(array('participant' => 'participant'), 'participant.participant_code = checkout.participant_code', array('participant_name', 'participant_number', 'participant_email'))
			->joinInner(array('areapost' => 'areapost'), 'areapost.areapost_code = checkout.areapost_code', array('areapost_name'))
			->joinInner(array('areapostregion' => 'areapostregion'), 'areapostregion.areapostregion_code = areapost.areapostregion_code', array('areapostregion_id', 'demarcation_name'))
			->joinInner(array('link' => 'link'), "link.link_parent_type = 'CHECKOUTITEM' and link_parent_code = checkoutitem_code and link_child_type = 'CHECKOUTSTAGE' and link_active = 1 and link_deleted = 0", array('link_text'))
			->joinInner(array('checkoutstage' => 'checkoutstage'), "checkoutstage.checkoutstage_code = link_child_code and checkoutstage_active = 1 and checkoutstage_deleted = 0", array('checkoutstage_name', 'checkoutstage_color', 'checkoutstage_code'))					
			->where('checkoutitem.checkout_code = ?', $code);

		$result = $this->_db->fetchAll($select);
		return ($result == false) ? false : $result = $result;					   
	}
	/**
	 * get domain by domain Account Id
 	 * @param string domain id
     * @return object
	 */
	public function getByCode($code) {
		$select = $this->_db->select()	
			->from(array('checkoutitem' => 'checkoutitem'), array('checkoutitem_code', 'checkoutitem_quantity', 'checkoutitem_amount', 'checkoutitem_note', 'checkoutitem_delivery', '(checkoutitem_amount*checkoutitem_quantity) as checkoutitem_amount_total'))	
			->joinInner(array('checkout' => 'checkout'), 'checkoutitem.checkout_code = checkout.checkout_code', array('checkout_code', 'checkout_added', 'checkout_address', 'checkout_amount_delivery', 'checkout_email', 'checkout_status_code', 'checkout_status_text'))
			->joinInner(array('price' => 'price'), 'price.price_code = checkoutitem.price_code', array('price_code', 'price_amount', 'price_original', 'price_discount'))
			->joinInner(array('feature' => 'feature'), "price.price_item_code = feature.feature_code and price_item_type = 'FEATURE'")
			->joinInner(array('catalog' => 'catalog'), 'catalog.catalog_code = feature.catalog_code', array('catalog_name', 'catalog_text'))
			->joinInner(array('item' => 'item'), "item.item_code = catalog.item_code", array('item_name'))
			->joinInner(array('brand' => 'brand'), 'brand.brand_code = catalog.brand_code', array('brand_name', 'brand_email', 'brand_delivery', 'brand_number', 'DATE_ADD(checkout_added,INTERVAL brand_delivery WEEK) as brand_delivery_date'))
			->joinInner(array('itemparent' => 'item'), "itemparent.item_code = item.item_parent", array('item_code as item_parent_code', 'item_name as item_parent_name'))		
			->joinInner(array('media' => 'media'), "media.media_category = 'IMAGE' and catalog.catalog_code = media.media_item_code and media.media_item_type = 'CATALOG' and media.media_primary = 1", array('media_code', 'media_path', 'media_ext'))
			->joinInner(array('participant' => 'participant'), 'participant.participant_code = checkout.participant_code', array('participant_name', 'participant_number', 'participant_email'))
			->joinInner(array('areapost' => 'areapost'), 'areapost.areapost_code = checkout.areapost_code', array('areapost_name'))
			->joinInner(array('areapostregion' => 'areapostregion'), 'areapostregion.areapostregion_code = areapost.areapostregion_code', array('areapostregion_id', 'demarcation_name'))
			->joinInner(array('link' => 'link'), "link.link_parent_type = 'CHECKOUTITEM' and link_parent_code = checkoutitem_code and link_child_type = 'CHECKOUTSTAGE' and link_active = 1 and link_deleted = 0", array('link_text'))
			->joinInner(array('checkoutstage' => 'checkoutstage'), "checkoutstage.checkoutstage_code = link_child_code and checkoutstage_active = 1 and checkoutstage_deleted = 0", array('checkoutstage_name', 'checkoutstage_color', 'checkoutstage_code'))			
            ->where('checkoutitem.checkoutitem_code = ?', $code)
            ->limit(1);

	   $result = $this->_db->fetchRow($select);	
       return ($result == false) ? false : $result = $result;					   
	}
	/**
	 * get job by job checkouttype Id
 	 * @param string job id
     * @return object
	 */
	public function paginate($start, $length, $filter = array()) {

		$where 	= 'checkoutitem.checkoutitem_deleted = 0';
		$csv 	= 0;

		if(count($filter) > 0) {	
			for($i = 0; $i < count($filter); $i++) {
				if(isset($filter[$i]['filter_search']) && trim($filter[$i]['filter_search']) != '') {
					$array = explode(" ",trim($filter[$i]['filter_search']));					
					if(count($array) > 0) {
						$where .= " and (";
						for($s = 0; $s < count($array); $s++) {
							$text = $array[$s];
							$this->sanitize($text);
							$where .= "lower(concat_ws(catalog_name, catalog_text, checkout.checkout_code, checkout_email, participant_number)) like lower('%$text%')";
							if(($s+1) != count($array)) {
								$where .= ' or ';
							}
						}
					}
					$where .= ")";
				} else if(isset($filter[$i]['filter_areapostregion']) && trim($filter[$i]['filter_areapostregion']) != '') {
					$areapostregion = trim($filter[$i]['filter_areapostregion']);
					$this->sanitize($areapostregion);
					$where .= " and areapostregion.areapostregion_id = '$areapostregion'";	
				} else if(isset($filter[$i]['filter_brand']) && trim($filter[$i]['filter_brand']) != '') {
					$brand = trim($filter[$i]['filter_brand']);
					$this->sanitize($brand);
					$where .= " and brand.brand_code = '$brand'";			
				} else if(isset($filter[$i]['filter_status']) && trim($filter[$i]['filter_status']) != '') {
					$status = trim($filter[$i]['filter_status']);
					$this->sanitize($status);
					$where .= " and checkout.checkout_status_code = '$status'";		
				} else if(isset($filter[$i]['filter_stage']) && trim($filter[$i]['filter_stage']) != '') {
					$stage = trim($filter[$i]['filter_stage']);
					$this->sanitize($status);
					$where .= " and checkoutstage.checkoutstage_code = '$stage'";						
				} else if(isset($filter[$i]['filter_csv']) && (int)trim($filter[$i]['filter_csv']) == 1) {
					$csv = 1;
				}
			}
		}

		$select = $this->_db->select()	
			->from(array('checkoutitem' => 'checkoutitem'), array('checkoutitem_code', 'checkoutitem_quantity', 'checkoutitem_amount', 'checkoutitem_note', 'checkoutitem_delivery', '(checkoutitem_amount*checkoutitem_quantity) as checkoutitem_amount_total'))	
			->joinInner(array('checkout' => 'checkout'), 'checkoutitem.checkout_code = checkout.checkout_code', array('checkout_code', 'checkout_added', 'checkout_address', 'checkout_amount_delivery', 'checkout_email', 'checkout_status_code', 'checkout_status_text'))
			->joinInner(array('price' => 'price'), 'price.price_code = checkoutitem.price_code', array('price_code', 'price_amount', 'price_original', 'price_discount'))
			->joinInner(array('feature' => 'feature'), "price.price_item_code = feature.feature_code and price_item_type = 'FEATURE'")
			->joinInner(array('catalog' => 'catalog'), 'catalog.catalog_code = feature.catalog_code', array('catalog_name', 'catalog_text'))
			->joinInner(array('item' => 'item'), "item.item_code = catalog.item_code", array('item_name'))
			->joinInner(array('brand' => 'brand'), 'brand.brand_code = catalog.brand_code', array('brand_name', 'brand_email', 'brand_delivery', 'brand_number', 'DATE_ADD(checkout_added,INTERVAL brand_delivery WEEK) as brand_delivery_date'))
			->joinInner(array('itemparent' => 'item'), "itemparent.item_code = item.item_parent", array('item_code as item_parent_code', 'item_name as item_parent_name'))		
			->joinInner(array('media' => 'media'), "media.media_category = 'IMAGE' and catalog.catalog_code = media.media_item_code and media.media_item_type = 'CATALOG' and media.media_primary = 1", array('media_code', 'media_path', 'media_ext'))
			->joinInner(array('participant' => 'participant'), 'participant.participant_code = checkout.participant_code', array('participant_name', 'participant_number', 'participant_email'))
			->joinInner(array('areapost' => 'areapost'), 'areapost.areapost_code = checkout.areapost_code', array('areapost_name'))
			->joinInner(array('areapostregion' => 'areapostregion'), 'areapostregion.areapostregion_code = areapost.areapostregion_code', array('areapostregion_id', 'demarcation_name'))
			->joinInner(array('link' => 'link'), "link.link_parent_type = 'CHECKOUTITEM' and link_parent_code = checkoutitem_code and link_child_type = 'CHECKOUTSTAGE' and link_active = 1 and link_deleted = 0", array('link_text'))
			->joinInner(array('checkoutstage' => 'checkoutstage'), "checkoutstage.checkoutstage_code = link_child_code and checkoutstage_active = 1 and checkoutstage_deleted = 0", array('checkoutstage_name', 'checkoutstage_color', 'checkoutstage_code'))			
			->where($where)
			->order('checkout_added desc');

		if($csv) {
			$result = $this->_db->fetchAll($select);
			return ($result == false) ? false : $result = $result;	
		} else {
			$result_count = $this->_db->fetchRow("select count(*) as query_count from ($select) as query");
			$result = $this->_db->fetchAll($select . " limit $start, $length");
			return ($result === false) ? false : $result = array('count'=>$result_count['query_count'],'displayrecords'=>count($result),'records'=>$result);	
		}
	}
    function sanitize(&$string) { $string = preg_replace("/[^a-zA-Z0-9_]+/", "", $string);}
	
    function sanitizeArray(&$array) 
    {        
		for($i = 0; $i < count($array); $i++) {
			$array[$i] = preg_replace("/[^a-zA-Z0-9_]+/", "", $array[$i]);
		}
    }	
}
?>