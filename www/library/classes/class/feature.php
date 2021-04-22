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
					->joinLeft(array('price' => 'price'), "price.price_item_code = feature.feature_code and price_item_type = 'FEATURE' and price_deleted = 0 and price_active = 1", array('price_code', 'price_amount', 'price_original', 'price_discount'))					
					->where('feature_deleted = 0')
					->where('feature_code = ?', $code)
					->limit(1);
       
		$result = $this->_db->fetchRow($select);
        return ($result == false) ? false : $result = $result;
	}

	/**
	 * get job by job feature Id
 	 * @param string job id
     * @return object
	 */
	public function getByCatalog($code, $type = null) {
	    if($type == null) {
    		$select = $this->_db->select()	
    			->from(array('feature' => 'feature'))
    			->joinLeft(array('price' => 'price'), "price.price_item_code = feature.feature_code and price_item_type = 'FEATURE' and price_deleted = 0 and price_active = 1", array('price_code', 'price_amount', 'price_original', 'price_discount'))					
    			->joinInner(array('item' => 'item'), "item.item_code = feature.item_code", array('item_name', 'item_type', 'item_cipher', 'item_variable', 'item_value'))					
    			->where('feature_active = 1 and feature_deleted = 0 and item_deleted = 0 and item_active = 1')
    			->where('catalog_code = ?', $code);
	    } else {
    		$select = $this->_db->select()	
    			->from(array('feature' => 'feature'))
    			->joinLeft(array('price' => 'price'), "price.price_item_code = feature.feature_code and price_item_type = 'FEATURE' and price_deleted = 0 and price_active = 1", array('price_code', 'price_amount', 'price_original', 'price_discount'))					
    			->joinInner(array('item' => 'item'), "item.item_code = feature.item_code", array('item_name', 'item_type', 'item_cipher', 'item_variable', 'item_value'))					
    			->where('feature_active = 1 and feature_deleted = 0 and item_deleted = 0 and item_active = 1')
    			->where('item_type = ?', $type)
    			->where('catalog_code = ?', $code);
	    }
		$result = $this->_db->fetchAll($select);
        return ($result == false) ? false : $result = $result;
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
				->joinLeft(array('price' => 'price'), "price.price_item_code = feature.feature_code and price_item_type = 'FEATURE' and price_deleted = 0 and price_active = 1", array('price_code', 'price_amount', 'price_original', 'price_discount'))				
				->joinInner(array('catalog' => 'catalog'), "catalog.catalog_code = feature.catalog_code", array('catalog_name', 'catalog_text'))
				->joinInner(array('item' => 'item'), "item.item_code = feature.item_code", array('item_name', 'item_type', 'item_cipher', 'item_variable', 'item_value'))
				->where('feature_deleted = 0 and catalog_deleted = 0 and item_deleted = 0');			
		} else {
			$select = $this->_db->select()
				->from(array('feature' => 'feature'), array('feature_code', 'feature_text'))
				->joinLeft(array('price' => 'price'), "price.price_item_code = feature.feature_code and price_item_type = 'FEATURE' and price_deleted = 0 and price_active = 1", array('price_code', 'price_amount', 'price_original', 'price_discount'))				
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
			$where .= " and catalog.catalog_code = '$text'";
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
			->joinInner(array('catalog' => 'catalog'), "catalog.catalog_code = feature.catalog_code", array('catalog_name', 'catalog_text'))
			->joinInner(array('item' => 'item'), "item.item_code = feature.item_code", array('item_name', 'item_type', 'item_cipher', 'item_variable', 'item_value'))
			->where('feature_deleted = 0 and catalog_deleted = 0 and item_deleted = 0')
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