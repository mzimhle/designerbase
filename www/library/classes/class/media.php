<?php

//custom account item class as account table abstraction
class class_media extends Zend_Db_Table_Abstract
{
   //declare table variables
    protected $_name 			= 'media';
	protected $_primary 		= 'media_code';
	
	/**
	 * Insert the database record
	 * example: $table->insert($data);
	 * @param array $data
     * @return boolean
	 */ 
	public function insert(array $data) {
        // add a timestamp
        $data['media_added'] = date('Y-m-d H:i:s');        
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
        $data['media_updated'] = date('Y-m-d H:i:s');
        return parent::update($data, $where);
    }
	
	/**
	 * get job by job media Id
 	 * @param string job id
     * @return object
	 */
	public function getByCode($code) {
		$select = $this->_db->select()	
					->from(array('media' => 'media'))
					->where('media_deleted = 0')
					->where('media_code = ?', $code)
					->limit(1);
       
	   $result = $this->_db->fetchRow($select);
        return ($result == false) ? false : $result = $result;

	}	

	public function getByItem($type, $item, $category = array('IMAGE')) {
		$select = $this->_db->select()	
					->from(array('media' => 'media'))	
					->where('media.media_item_type = ?', $type)
					->where('media.media_item_code = ?', $item)
					->where('media.media_category in(?)', $category)
					->where('media_deleted = 0')
					->order('media_added DESC');					

		$result = $this->_db->fetchAll($select);
		return ($result == false) ? false : $result = $result;
	}
	
	public function getPrimaryByItem($type, $item, $category = array('IMAGE')) {
		$select = $this->_db->select()	
					->from(array('media' => 'media'))	
					->where('media.media_item_type = ?', $type)
					->where('media.media_item_code = ?', $item)
					->where('media.media_category in(?)', $category)
					->where('media_deleted = 0')
					->where('media_primary = 1')
					->order('media_added desc')
					->limit(1);
       
	   $result = $this->_db->fetchRow($select);
        return ($result == false) ? false : $result = $result;	
	}
	
	public function updatePrimaryByItem($type, $item, $code, $category = 'IMAGE') {

		$itemData = $this->getPrimaryByItem($type, $item, $category);

		if($itemData) {
			$data 							= array();

			$where 						= null;
			$data['media_primary'] 	= 0;

			$where		= $this->getAdapter()->quoteInto('media_code = ?', $itemData['media_code']);
			$success	= $this->update($data, $where);				
		}

		$data 							= array();
		$data['media_primary']	= 1;

		$where		= array();
		$where[]	= $this->getAdapter()->quoteInto('media_item_type = ?', $type);
		$where[]	= $this->getAdapter()->quoteInto('media_item_code = ?', $item);
		$where[]	= $this->getAdapter()->quoteInto('media_code = ?', $code);
		$success	= $this->update($data, $where);

		return $success;
	}

	/**
	 * get domain by domain Account Id
 	 * @param string domain id
     * @return object
	 */
	public function getCode($code)
	{
		$select = $this->_db->select()	
			->from(array('media' => 'media'))	
			->where('media_code = ?', $code)
			->limit(1);

	   $result = $this->_db->fetchRow($select);	
        return ($result == false) ? false : $result = $result;					   
	}
	
	function createCode() {
		/* New code. */
		$code = "";
		$codeAlphabet = "123456789";

		$count = strlen($codeAlphabet) - 1;
		
		for($i=0;$i<10;$i++){
			$code .= $codeAlphabet[rand(0,$count)];
		}
		
		$code = md5($code.time());
		
		/* First check if it exists or not. */
		$itemCheck = $this->getCode($code);
		
		if($itemCheck) {
			/* It exists. check again. */
			$this->createCode();
		} else {
			return $code;
		}
	}		
}
?>