<?php

//custom account item class as account table abstraction
class class_checkoutitem extends Zend_Db_Table_Abstract
{
   //declare table variables
    protected $_name	= 'checkoutitem';
	protected $_primary	= 'checkoutitem_code';
	/**
	 * Insert the database record
	 * example: $table->insert($data);
	 * @param array $data
     * @return boolean
	 */ 

	public function insert(array $data) {
        // add a timestamp
        $data['checkoutitem_added']		= date('Y-m-d H:i:s');
        $data['checkoutitem_code']		= $this->createCode();
		
		return parent::insert($data);	
    }
	
	/**
	 * Update the database record
	 * example: $table->update($data, $where);
	 * @param query string $where
	 * @param array $data
     * @return boolean
	 */
    public function update(array $data, $where) {
        // add a timestamp
         $data['checkoutitem_updated'] = date('Y-m-d H:i:s');
        
        return parent::update($data, $where);
    }
	
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
			->joinInner(array('brand' => 'brand'), 'brand.brand_code = catalog.brand_code', array('brand_name', 'brand_url', 'brand_email', 'brand_delivery', 'brand_number', 'DATE_ADD(checkout_added,INTERVAL brand_delivery WEEK) as brand_delivery_date'))
			->joinInner(array('itemparent' => 'item'), "itemparent.item_code = item.item_parent", array('item_code as item_parent_code', 'item_name as item_parent_name'))		
			->joinInner(array('media' => 'media'), "media.media_category = 'IMAGE' and catalog.catalog_code = media.media_item_code and media.media_item_type = 'CATALOG' and media.media_primary = 1", array('media_code', 'media_path', 'media_ext'))
			->joinInner(array('participant' => 'participant'), 'participant.participant_code = checkout.participant_code', array('participant_name', 'participant_number', 'participant_email'))
			->joinInner(array('areapost' => 'areapost'), 'areapost.areapost_code = checkout.areapost_code', array('areapost_name'))
			->joinInner(array('areapostregion' => 'areapostregion'), 'areapostregion.areapostregion_code = areapost.areapostregion_code', array('areapostregion_id', 'demarcation_name'))
			->joinLeft(array('link' => 'link'), "link.link_parent_type = 'CHECKOUTITEM' and link_parent_code = checkoutitem_code and link_child_type = 'CHECKOUTSTAGE' and link_active = 1 and link_deleted = 0", array('link_text'))
			->joinLeft(array('checkoutstage' => 'checkoutstage'), "checkoutstage.checkoutstage_code = link_child_code and checkoutstage_active = 1 and checkoutstage_deleted = 0", array('checkoutstage_name', 'checkoutstage_color', 'checkoutstage_code'))					
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
			->from(array('checkoutitem' => 'checkoutitem'))
			->joinLeft(array('checkout' => 'checkout'), 'checkout.checkout_code = checkoutitem.checkout_code')
			->where('checkoutitem_deleted = 0 and checkout_deleted = 0')
			->where('checkoutitem.checkoutitem_code = ?', $code)
			->limit(1);

	   $result = $this->_db->fetchRow($select);	
       return ($result == false) ? false : $result = $result;					   
	}
	
	/**
	 * get domain by domain Account Id
 	 * @param string domain id
     * @return object
	 */
	public function getCode($code) {
		$select = $this->_db->select()	
			->from(array('checkoutitem' => 'checkoutitem'))	
		   ->where('checkoutitem_code = ?', $code)
		   ->limit(1);

	   $result = $this->_db->fetchRow($select);	
       return ($result == false) ? false : $result = $result;					   
	}
	
	function createCode() {
		/* New reference. */
		$reference = "";
		$codeAlphabet = '123456789';
		
		$count = strlen($codeAlphabet) - 1;
		
		for($i=0;$i<15;$i++){
			$reference .= $codeAlphabet[rand(0,$count)];
		}
		
		/* First check if it exists or not. */
		$itemCheck = $this->getCode($reference);
		
		if($itemCheck) {
			/* It exists. check again. */
			$this->createCode();
		} else {
			return $reference;
		}
	}

}
?>