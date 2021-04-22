<?php


//custom account item class as account table abstraction
class class_checkoutstage extends Zend_Db_Table_Abstract
{
   //declare table variables
    protected $_name	= 'checkoutstage';
	protected $_primary	= 'checkoutstage_code';
	
	function init()	{
		global $zfsession;
	}

	/**
	 * Insert the database record
	 * example: $table->insert($data);
	 * @param array $data
     * @return boolean
	 */ 

	public function insert(array $data) {
        // add a timestamp
        $data['checkoutstage_added']	= date('Y-m-d H:i:s');
        $data['checkoutstage_code']		= $this->createCode();
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
        $data['checkoutstage_updated'] = date('Y-m-d H:i:s');
        return parent::update($data, $where);
    }
	
	/**
	 * get domain by domain supplier Id
 	 * @param string domain id
     * @return object
	 */
	public function getByCode($code)
	{
		$select = $this->_db->select()	
			->from(array('checkoutstage' => 'checkoutstage'))	
			->where('checkoutstage.checkoutstage_deleted = 0')
			->where('checkoutstage_code = ?', $code)
			->limit(1);

		$result = $this->_db->fetchRow($select);	
        return ($result == false) ? false : $result = $result;					   
	}
	/**
	 * get domain by domain supplier Id
 	 * @param string domain id
     * @return object
	 */
	public function getAll() {
		$select = $this->_db->select()	
			->from(array('checkoutstage' => 'checkoutstage'))	
			->where('checkoutstage.checkoutstage_deleted = 0');

	    $result = $this->_db->fetchAll($select);	
        return ($result == false) ? false : $result = $result;					   
	}
	
	public function pairs() {
		$select = $this->select()
		   ->from(array('checkoutstage' => 'checkoutstage'), array('checkoutstage.checkoutstage_code', "concat(checkoutstage_code, ' - ', checkoutstage.checkoutstage_name) as checkoutstage_name"))
		   ->where('checkoutstage.checkoutstage_deleted = 0')
		   ->order('checkoutstage.checkoutstage_code asc');

		$result = $this->_db->fetchPairs($select);
		return ($result == false) ? false : $result = $result;
	}	
	
	/**
	 * get domain by domain supplier Id
 	 * @param string domain id
     * @return object
	 */
	public function getCode($code) {
		$select = $this->_db->select()	
			->from(array('checkoutstage' => 'checkoutstage'))
			->where('checkoutstage_code = ?', $code)
			->limit(1);

		$result = $this->_db->fetchRow($select);	
        return ($result == false) ? false : $result = $result;					   
	}
}
?>