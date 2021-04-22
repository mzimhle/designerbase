<?php

//custom account item class as account table abstraction
class class_feature extends Zend_Db_Table_Abstract
{
   //declare table variables
    protected $_name 			= 'feature';
	protected $_primary 		= 'feature_code';
	
	/**
	 * Insert the database record
	 * example: $table->insert($data);
	 * @param array $data
     * @return boolean
	 */ 
	public function insert(array $data) {
        // add a timestamp
        $data['feature_added']		= date('Y-m-d H:i:s');
        $data['feature_code']		= $this->createCode();
		
		return parent::insert($data);
		
    }
	
	/**
	 * Update the database record
	 * example: $table->update($data, $where);
	 * @param query string $where
	 * @param array $data
     * @return boolean
	 */
    public function update(array $data, $where)
    {
        // add a timestamp
        $data['feature_updated'] = date('Y-m-d H:i:s');
        
        return parent::update($data, $where);
    }
	
	/**
	 * get job by job feature Id
 	 * @param string job id
     * @return object
	 */
	public function getByCode($code) {
		$select = $this->_db->select()	
					->from(array('feature' => 'feature'))
					->where('feature_deleted = 0')
					->where('feature_code = ?', $code)
					->limit(1);
       
		$result = $this->_db->fetchRow($select);
        return ($result == false) ? false : $result = $result;
	}

	public function getPrimary($catalog, $itemtype) {
		$select = $this->_db->select()	
				->from(array('feature' => 'feature'))	
				->joinInner(array('item' => 'item'), "item.item_code = feature.item_code")
				->where('item_deleted = 0 and feature_deleted = 0 and feature_primary = 1')
				->where('feature.catalog_code = ?', $catalog)
				->where('item.item_type = ?', $itemtype)
				->limit(1);

		$result = $this->_db->fetchRow($select);
        return ($result == false) ? false : $result = $result;	
	}
	
	public function updatePrimary($catalog, $itemtype, $feature) {

		$itemData = $this->getPrimary($catalog, $itemtype);

		if($itemData) {
			$data						= array();
			$where						= null;
			$data['feature_primary']	= 0;

			$where		= $this->getAdapter()->quoteInto('feature_code = ?', $itemData['feature_code']);
			$success	= $this->update($data, $where);				
		}

		$data						= array();
		$data['feature_primary']	= 1;

		$where		= array();
		$where[]	= $this->getAdapter()->quoteInto('catalog_code = ?', $catalog);
		$where[]	= $this->getAdapter()->quoteInto('feature_code = ?', $feature);
		$success	= $this->update($data, $where);

		return $success;
	}
	
	public function exists($catalog, $item) {
		$select = $this->_db->select()	
					->from(array('feature' => 'feature'))
					->where('feature_deleted = 0')
					->where('catalog_code = ?', $catalog)
					->where('item_code = ?', $item)
					->limit(1);

		$result = $this->_db->fetchRow($select);
        return ($result == false) ? false : $result = $result;
	}
	
	public function getByType($type = '') {
		
		if($type == '') {
			$select = $this->_db->select()
				->from(array('feature' => 'feature'), array('feature_code', 'feature_text'))
				->joinInner(array('catalog' => 'catalog'), "catalog.catalog_code = feature.catalog_code", array('catalog_name', 'catalog_text'))
				->joinInner(array('item' => 'item'), "item.item_code = feature.item_code", array('item_name', 'item_type', 'item_cipher', 'item_variable', 'item_value'))
				->where('feature_deleted = 0 and catalog_deleted = 0 and item_deleted = 0');			
		} else {
			$select = $this->_db->select()
				->from(array('feature' => 'feature'), array('feature_code', 'feature_text'))
				->joinInner(array('catalog' => 'catalog'), "catalog.catalog_code = feature.catalog_code", array('catalog_name', 'catalog_text'))
				->joinInner(array('item' => 'item'), "item.item_code = feature.item_code", array('item_name', 'item_type', 'item_cipher', 'item_variable', 'item_value'))
				->where('item.item_type = ?', $type)
				->where('feature_deleted = 0 and catalog_deleted = 0 and item_deleted = 0');			
		}
		$result = $this->_db->fetchAll($select);
        return ($result == false) ? false : $result = $result;	
	}
	
	public function getSearch($start, $length, $filters = array()) {

		$where = 'feature_deleted = 0';
		$order = 'item.item_type desc';

		if(isset($filters['filter_catalog']) && trim($filters['filter_catalog']) != '') {
			$text	= $filters['filter_catalog'];
			$where .= " and feature.catalog_code = '$text'";
		}
		if(isset($filters['filter_item']) && trim($filters['filter_item']) != '') {
			$text	= trim($filters['filter_item']);
			$where .= " and item.item_code = '$text'";
		}
		if(isset($filters['filter_type']) && trim($filters['filter_type']) != '') {
			$type	= trim($filters['filter_type']);
			$where .= " and item.item_type = '$type'";
		}

		$select = $this->_db->select()
			->from(array('feature' => 'feature'))
			->joinInner(array('item' => 'item'), "item.item_code = feature.item_code", array('item_name', 'item_type', 'item_cipher', 'item_variable', 'item_value'))
			->joinLeft(array('price' => 'price'), "price.price_item_type = 'FEATURE' and price.price_item_code = feature.feature_code and price_active = 1 and price_deleted = 0", array('price_code', 'price_id', 'price_amount', 'price_discount', 'price_original'))			
			->where('feature_deleted = 0 and item_deleted = 0')
			->where($where)
			->order($order);			

		$result_count = $this->_db->fetchRow("select count(*) as query_count from ($select) as query");
		$result = $this->_db->fetchAll($select . " limit $start, $length");
		return ($result === false) ? false : $result = array('count'=>$result_count['query_count'],'displayrecords'=>count($result),'records'=>$result);	
	}
	
	/**
	 * get domain by domain Account Id
 	 * @param string domain id
     * @return object
	 */
	public function getCode($code)
	{
		$select = $this->_db->select()	
			->from(array('feature' => 'feature'))	
			->where('feature_code = ?', $code)
			->limit(1);

	   $result = $this->_db->fetchRow($select);	
        return ($result == false) ? false : $result = $result;					   
	}
	
	function createCode() {
		/* New code. */
		$code = "";
		$codeAlphabet = "1234567890";

		$count = strlen($codeAlphabet) - 1;
		
		for($i=0;$i<5;$i++){
			$code .= $codeAlphabet[rand(0,$count)];
		}
		/* First check if it exists or not. */
		$featureCheck = $this->getCode($code);
		
		if($featureCheck) {
			/* It exists. check again. */
			$this->createCode();
		} else {
			return $code;
		}
	}

	public function toUrl($title) {
		
		$name = strtolower(trim($title));
		$name = preg_replace('/\W+/', '-', strtolower($name));
		$name = str_replace(' ' , '' , $name);
		$name = str_replace('__' , '' , $name);
		$name = str_replace(' ' , '' , $name);
		$name = str_replace("é", "e", $name);
		$name = str_replace("è", "e", $name);
		$name = str_replace("`", "", $name);
		$name = str_replace("/", "", $name);
		$name = str_replace("\\", "", $name);
		$name = str_replace("'", "", $name);
		$name = str_replace("(", "", $name);
		$name = str_replace(")", "", $name);
		$name = str_replace("-", "", $name);
		$name = str_replace(".", "", $name);
		$name = str_replace("ë", "e", $name);	
		$name = str_replace("â€“", "ae", $name);	
		$name = str_replace("â", "a", $name);	
		$name = str_replace("€", "e", $name);	
		$name = str_replace("“", "", $name);	
		$name = str_replace("#", "", $name);	
		$name = str_replace("$", "", $name);	
		$name = str_replace("@", "", $name);	
		$name = str_replace("!", "", $name);	
		$name = str_replace("&", "", $name);	
		$name = str_replace(';' , '' , $name);		
		$name = str_replace(':' , '' , $name);		
		$name = str_replace('[' , '' , $name);		
		$name = str_replace(']' , '' , $name);		
		$name = str_replace('|' , '' , $name);		
		$name = str_replace('\\' , '' , $name);		
		$name = str_replace('%' , '' , $name);	
		$name = str_replace(';' , '' , $name);		
		$name = str_replace(' ' , '' , $name);
		$name = str_replace('__' , '' , $name);
		$name = str_replace(' ' , '' , $name);
		
		return $name;
	}	
}
?>