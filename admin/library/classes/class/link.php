<?php
//custom account link class as account table abstraction
class class_link extends Zend_Db_Table_Abstract {
   //declare table variables
    protected $_name	= 'link';
	protected $_primary	= 'link_code';
	
	/**
	 * Insert the database record
	 * example: $table->insert($data);
	 * @param array $data
     * @return boolean
	 */ 
	 public function insert(array $data) {
        // add a timestamp
        $data['link_added']	= date('Y-m-d H:i:s');        
		$data['link_code']  = $this->createCode();
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
        $data['link_updated'] = date('Y-m-d H:i:s');
        return parent::update($data, $where);
    }
	/**
	 * get job by job link Id
 	 * @param string job id
     * @return object
	 */
	public function getByCode($code) {	
		$select = $this->_db->select()	
    		->from(array('link' => 'link'))
    		->where('link_deleted = 0')
    		->where('link_code = ?', $code)
    		->limit(1);
       
		$result = $this->_db->fetchRow($select);
        return ($result == false) ? false : $result = $result;
	}
	/**
	 * get job by job link Id
 	 * @param string job id
     * @return object
	 */
	public function getByParent($parenttype, $parentcode, $childtype) {	

		if($childtype == 'CATALOG') {
			$select = $this->_db->select()	
				->from(array('link' => 'link'))
				->joinLeft(array('advert' => 'advert'), 'advert.advert_code = link.link_parent_code')
				->joinLeft(array('catalog' => 'catalog'), 'catalog.catalog_code = link.link_child_code')
    			->joinLeft(array('feature' => 'feature'), "feature.catalog_code = catalog.catalog_code and feature_deleted = 0 and feature_primary = 1", array())
    			->joinLeft(array('price' => 'price'), "price.price_item_code = feature.feature_code and price_item_type = 'FEATURE' and price_deleted = 0 and price_active = 1", array('price_code', 'price_amount', 'price_original', 'price_discount'))
    			->joinLeft(array('item' => 'item'), "item.item_code = catalog.item_code", array('item_name'))
    			->joinLeft(array('itemparent' => 'item'), "itemparent.item_code = item.item_parent", array('item_code as item_parent_code', 'item_name as item_parent_name'))
    			->joinLeft(array('media' => 'media'), "media.media_category = 'IMAGE' and catalog.catalog_code = media.media_item_code and media.media_item_type = 'CATALOG' and media.media_primary = 1", array('media_code', 'media_path', 'media_ext'))
    			->joinLeft(array('brand' => 'brand'), 'brand.brand_code = catalog.brand_code', array('brand_name'))
				->where('link.link_deleted = 0 and link.link_parent_type = ?', $parenttype)
				->where('link.link_deleted = 0 and link.link_parent_code = ?', $parentcode)
				->where('link.link_deleted = 0 and link.link_child_type = ?', $childtype)
				->where('advert_deleted = 0');
		} else {
			return false;
		}
		$result = $this->_db->fetchAll($select);
        return ($result == false) ? false : $result = $result;
	}
	
	/**
	 * get job by job link Id
 	 * @param string job id
     * @return object
	 */
	public function getByChild($childtype, $childcode, $parenttype) {	
		
		if($childtype == 'CATALOG' && $parenttype == 'ADVERT') {
			$select = $this->_db->select()
				->from(array('link' => 'link'))
				->joinLeft(array('advert' => 'advert'), 'advert.advert_code = link.link_parent_code')
				->joinLeft(array('catalog' => 'catalog'), 'catalog.catalog_code = link.link_child_code')
				->where('link_deleted = 0 and link_child_code = ?', $childcode)
				->where('advert_deleted = 0 and link_child_type = ?', $childtype)
				->where('catalog_deleted = 0 and link_parent_type = ?', $parenttype);				
		} else {
			return false;
		}

		$result = $this->_db->fetchAll($select);
        return ($result == false) ? false : $result = $result;
	}	
	/**
	 * get job by job link Id
 	 * @param string job id
     * @return object
	 */
	public function getChild($parenttype, $parentcode, $childtype, $childcode) {	
		
		if($childtype == 'CATALOG') {
			$select = $this->_db->select()	
				->from(array('link' => 'link'))
				->joinLeft(array('advert' => 'advert'), 'advert.advert_code = link.link_parent_code')
				->joinLeft(array('catalog' => 'catalog'), 'catalog.catalog_code = link.link_child_code')
				->where('catalog_deleted = 0 and link_parent_type = ?', $parenttype)
				->where('advert_deleted = 0 and link_parent_code = ?', $parentcode)
				->where('link_child_type = ?', $childtype)
				->where('link_deleted = 0 and link_child_code = ?', $childcode);
		} else {
			return false;
		}
		$result = $this->_db->fetchRow($select);
        return ($result == false) ? false : $result = $result;
	}
	/**
	 * get job by job link Id
 	 * @param string job id
     * @return object
	 */
	public function checkExists($parenttype, $parentcode, $childtype, $childcode) {	
		
		$select = $this->_db->select()	
			->from(array('link' => 'link'))
			->where('link_deleted = 0 and link_parent_type = ?', $parenttype)
			->where('link_parent_code = ?', $parentcode)
			->where('link_child_type = ?', $childtype)
			->where('link_child_code = ?', $childcode);

		$result = $this->_db->fetchRow($select);
        return ($result == false) ? false : $result = $result;
	}
	/**
	 * get domain by domain Account Id
 	 * @param string domain id
     * @return object
	 */
	public function getCode($reference) {
		$select = $this->_db->select()	
			->from(array('link' => 'link'))	
			->where('link_code = ?', $reference)
			->limit(1);

	    $result = $this->_db->fetchRow($select);	
        return ($result == false) ? false : $result = $result;					   
	}

	function createCode() {
		/* New code. */
		$code = md5(date('Y-m-d h:i:s').rand(1, 10000000));	
		/* First check if it exists or not. */
		$linkCheck = $this->getCode($code);
		
		if($linkCheck) {
			/* It exists. check again. */
			$this->createCode();
		} else {
			return $code;
		}
	}	
}
?>