<?php

require_once 'template.php';
require_once '_comm.php';

//custom account item class as account table abstraction
class class_enquiry extends Zend_Db_Table_Abstract
{
   //declare table variables
    protected $_name		= 'enquiry';
	protected $_primary		= 'enquiry_code';
	public $_template		= null; 
	public $_comm			= null; 
	
	function init()	{
		$this->_template	= new class_template();
		$this->_comm		= new class_comm();
	}

	/**
	 * Insert the database record
	 * example: $table->insert($data);
	 * @param array $data
     * @return boolean
	 */
	public function insert(array $data) {
        // add a timestamp
        $data['enquiry_added']		= date('Y-m-d H:i:s');
        $data['enquiry_code']		= $this->createCode();

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
		$data['enquiry_updated'] = date('Y-m-d H:i:s');

        return parent::update($data, $where);
    }

	/**
	 * get domain by domain Account Id
 	 * @param string domain id
     * @return object
	 */
	public function getByCode($code)
	{
		$select = $this->_db->select()	
			->from(array('enquiry' => 'enquiry'))	
			->where('enquiry_code = ?', $code)
			->where('enquiry_deleted = 0')
			->limit(1);

	   $result = $this->_db->fetchRow($select);	
        return ($result == false) ? false : $result = $result;					   
	}
	
	/**
	 * get domain by domain Account Id
 	 * @param string domain id
     * @return object
	 */
	public function getCode($code)
	{
		$select = $this->_db->select()	
			->from(array('enquiry' => 'enquiry'))	
			->where('enquiry_code = ?', $code)
			->limit(1);

	   $result = $this->_db->fetchRow($select);	
        return ($result == false) ? false : $result = $result;					   
	}

	function createCode() {
		/* New code. */
		$code = md5(time());
		
		/* First check if it exists or not. */
		$itemCheck = $this->getCode($code);
		
		if($itemCheck) {
			/* It exists. check again. */
			$this->createCode();
		} else {
			return $code;
		}
	}

	public function validateEmail($string) {
		if(!filter_var($string, FILTER_VALIDATE_EMAIL)) {
			return '';
		} else {
			return trim($string);
		}
	}
}
?>