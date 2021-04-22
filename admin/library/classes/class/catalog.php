<?php
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
		$this->_supplier	= $zfsession->supplier;
		$this->_brand		= $zfsession->brand;
	}
	/**
	 * Insert the database record
	 * example: $table->insert($data);
	 * @param array $data
     * @return boolean
	 */ 
	 public function insert(array $data) {
		// add a timestamp
		$data['catalog_added']	= date('Y-m-d H:i:s');
		$data['catalog_code']	= $this->createCode();
		$data['brand_code']		= $this->_brand;
		$data['catalog_url']	= $this->toUrl($data['catalog_name']);
		
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
        $data['catalog_updated'] = date('Y-m-d H:i:s');

        return parent::update($data, $where);
    }

	/**
	 * get job by job catalog Id
 	 * @param string job id
     * @return object
	 */
	public function getByCode($code, $check = true) {
        
        if($check) {
    		$select = $this->_db->select()
    			->from(array('catalog' => 'catalog'))
    			->joinLeft(array('feature' => 'feature'), "feature.catalog_code = catalog.catalog_code and feature_deleted = 0 and feature_primary = 1", array())
    			->joinLeft(array('price' => 'price'), "price.price_item_code = feature.feature_code and price_item_type = 'FEATURE' and price_deleted = 0 and price_active = 1", array('price_code', 'price_amount', 'price_original', 'price_discount'))			
    			->joinLeft(array('item' => 'item'), "item.item_code = catalog.item_code")
    			->joinLeft(array('itemparent' => 'item'), "itemparent.item_code = item.item_parent", array('item_code as item_parent_code', 'item_name as item_parent_name'))		
    			->joinLeft(array('media' => 'media'), "media.media_category = 'IMAGE' and catalog.catalog_code = media.media_item_code and media.media_item_type = 'CATALOG' and media.media_primary = 1", array('media_code', 'media_path', 'media_ext'))
    			->joinLeft(array('brand' => 'brand'), 'brand.brand_code = catalog.brand_code', array('brand_name'))
    			->where('brand.brand_code = ?', $this->_brand)
    			->where('catalog.catalog_code = ?', $code)
    			->limit(1);
        } else {
    		$select = $this->_db->select()
    			->from(array('catalog' => 'catalog'))
    			->joinLeft(array('feature' => 'feature'), "feature.catalog_code = catalog.catalog_code and feature_deleted = 0 and feature_primary = 1", array())
    			->joinLeft(array('price' => 'price'), "price.price_item_code = feature.feature_code and price_item_type = 'FEATURE' and price_deleted = 0 and price_active = 1", array('price_code', 'price_amount', 'price_original', 'price_discount'))			
    			->joinLeft(array('item' => 'item'), "item.item_code = catalog.item_code")
    			->joinLeft(array('itemparent' => 'item'), "itemparent.item_code = item.item_parent", array('item_code as item_parent_code', 'item_name as item_parent_name'))		
    			->joinLeft(array('media' => 'media'), "media.media_category = 'IMAGE' and catalog.catalog_code = media.media_item_code and media.media_item_type = 'CATALOG' and media.media_primary = 1", array('media_code', 'media_path', 'media_ext'))
    			->joinLeft(array('brand' => 'brand'), 'brand.brand_code = catalog.brand_code', array('brand_name'))
    			->where('catalog.catalog_code = ?', $code)
    			->limit(1);
        }
		$result = $this->_db->fetchRow($select);
        return ($result == false) ? false : $result = $result;
	}

	public function getSearch($start, $length, $filters = array()) {

		$where = 'catalog_deleted = 0';
		$order = 'catalog_name desc';

		if(isset($filters['filter_text']) && trim($filters['filter_text']) != '') {
			$search = $filters['filter_text'];
			$where .= " and lower(concat_ws(catalog_name, ' ', item_name)) like lower('%$search%')";
			$order = "LOCATE('$search', concat_ws(catalog_name, item_name))";
		}

		$select = $this->_db->select()
			->from(array('catalog' => 'catalog'))
			->joinLeft(array('feature' => 'feature'), "feature.catalog_code = catalog.catalog_code and feature_deleted = 0 and feature_primary = 1", array())
			->joinLeft(array('price' => 'price'), "price.price_item_code = feature.feature_code and price_item_type = 'FEATURE' and price_deleted = 0 and price_active = 1", array('price_code', 'price_amount', 'price_original', 'price_discount'))
			->joinLeft(array('item' => 'item'), "item.item_code = catalog.item_code", array('item_name'))
			->joinLeft(array('itemparent' => 'item'), "itemparent.item_code = item.item_parent", array('item_code as item_parent_code', 'item_name as item_parent_name'))
			->joinLeft(array('media' => 'media'), "media.media_category = 'IMAGE' and catalog.catalog_code = media.media_item_code and media.media_item_type = 'CATALOG' and media.media_primary = 1", array('media_code', 'media_path', 'media_ext'))
			->joinLeft(array('brand' => 'brand'), 'brand.brand_code = catalog.brand_code', array('brand_name'))
			->where('brand.brand_code = ?', $this->_brand)
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
	public function getCode($code) {
		$select = $this->_db->select()	
				->from(array('catalog' => 'catalog'))	
				->where('catalog_code = ?', $code)
				->limit(1);

	   $result = $this->_db->fetchRow($select);	
        return ($result == false) ? false : $result = $result;					   
	}
	
	function createCode() {
		/* New code. */
		$code = "";
		
		$Alphabet 	= "ABCEGHKLMNOPQRSUXYZ";
		$Number 	= '1234567890';
		
		/* First two Alphabets. */
		$count = strlen($Alphabet) - 1;
		
		for($i=0;$i<3;$i++){
			$code .= $Alphabet[rand(0,$count)];
		}		
		/* Next six numbers */
		$count = strlen($Number) - 1;
		
		for($i=0;$i<4;$i++){
			$code .= $Number[rand(0,$count)];
		}		
		/* Last alphabet. */
		$count = strlen($Alphabet) - 1;
		
		for($i=0;$i<1;$i++){
			$code .= $Alphabet[rand(0,$count)];
		}
		
		/* First check if it exists or not. */
		$itemCheck = $this->getCode($code);
		
		if($itemCheck) {
			/* It exists. check again. */
			$this->createCode();
		} else {
			return $code;
		}
	}

	public function toUrl($title) {
		
		$name = strtolower(trim($title));
		$name = preg_replace('/\W+/', '-', strtolower($name));
		$name = str_replace(' ' , '-' , $name);
		$name = str_replace('__' , '-' , $name);
		$name = str_replace(' ' , '-' , $name);
		$name = str_replace("é", "e", $name);
		$name = str_replace("è", "e", $name);
		$name = str_replace("`", "", $name);
		$name = str_replace("/", "", $name);
		$name = str_replace("\\", "", $name);
		$name = str_replace("'", "", $name);
		$name = str_replace("(", "", $name);
		$name = str_replace(")", "", $name);
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
		$name = str_replace(' ' , '-' , $name);
		$name = str_replace('__' , '-' , $name);
		$name = str_replace(' ' , '-' , $name);
		return $name;
	}	
}
?>