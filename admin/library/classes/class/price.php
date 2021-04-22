<?php

//custom account item class as account table abstraction
class class_price extends Zend_Db_Table_Abstract
{
   //declare table variables
    protected $_name		= 'price';
	protected $_primary	= 'price_code';
	
	/**
	 * Insert the database record
	 * example: $table->insert($data);
	 * @param array $data
     * @return boolean
	 */ 

	public function insert(array $data) {
        // add a timestamp
        $data['price_added']		= date('Y-m-d H:i:s');
		$data['price_date_start']	= date('Y-m-d H:i:s');
        $data['price_code']			= $this->createCode();
		$data['price_amount']		= (int)$data['price_discount'] != 0 ? $data['price_original']-(((int)$data['price_discount']/100)*$data['price_original']): $data['price_original'];

		$priceData = $this->getPrice($data['price_item_type'], $data['price_item_code']);

		if($priceData) {
			/* Increase id to the latest one. */
			$data['price_id'] = $priceData['price_id']+1;
			/* Update previous item. */
			$udata						= array();
			$udata['price_date_end']	= date('Y-m-d H:i:s');
			$udata['price_active'] 		= 0;
			/* Update the price */
			$where	= $this->getAdapter()->quoteInto('price_code = ?', $priceData['price_code']);
			$this->update($udata, $where);	
		}

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
		$data['price_updated'] = date('Y-m-d H:i:s');
        
        return parent::update($data, $where);
    }
	
	/**
	 * get domain by domain Account Id
 	 * @param string domain id
     * @return object
	 */
	public function getPrice($type, $code) {

		$select = $this->_db->select()	
			->from(array('price' => 'price'))			
			->where('price.price_item_type = ?', $type)
			->where('price.price_item_code = ?', $code)
			->where("price_deleted = 0 and price_active = 1");

		$result = $this->_db->fetchRow($select);	   
		return ($result == false) ? false : $result = $result;
	}
	
	/**
	 * get domain by domain Account Id
 	 * @param string domain id
     * @return object
	 */
	public function getByType($type, $code) {

		$select = $this->_db->select()	
			->from(array('price' => 'price'))			
			->where('price.price_item_type = ?', $type)
			->where('price.price_item_code = ?', $code)
			->where('price_deleted = 0')
			->order('price.price_id asc');

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
			->from(array('price' => 'price'))
			->where('price_deleted = 0')
			->where('price.price_code = ?', $code)
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
						->from(array('price' => 'price'))	
					   ->where('price_code = ?', $code)
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
		
		for($i=0;$i<2;$i++){
			$code .= $Alphabet[rand(0,$count)];
		}		
		/* Next six numbers */
		$count = strlen($Number) - 1;
		
		for($i=0;$i<4;$i++){
			$code .= $Number[rand(0,$count)];
		}		
		/* Last alphabet. */
		$count = strlen($Alphabet) - 1;
		
		for($i=0;$i<3;$i++){
			$code .= $Alphabet[rand(0,$count)];
		}
		/* Next six numbers */
		$count = strlen($Number) - 1;
		
		for($i=0;$i<2;$i++){
			$code .= $Number[rand(0,$count)];
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
	
	function validateAmount($amount) {
		if(preg_match("/^[0-9]+(?:\.[0-9]{0,2})?$/", $amount)) {
			return $amount;
		} else {
			return null;
		}	
	}

}
?>