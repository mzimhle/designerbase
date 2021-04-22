<?php

//custom account item class as account table abstraction
class class_comment extends Zend_Db_Table_Abstract
{
   //declare table variables
    protected $_name 			= 'comment';
	protected $_primary 		= 'comment_code';
	
	/**
	 * Insert the database record
	 * example: $table->insert($data);
	 * @param array $data
     * @return boolean
	 */ 
	public function insert(array $data) {
        // add a timestamp
        $data['comment_added']		= date('Y-m-d H:i:s');
        $data['comment_code']		= $this->createCode();
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
        $data['comment_updated'] = date('Y-m-d H:i:s');
        return parent::update($data, $where);
    }
	/**
	 * get job by job comment Id
 	 * @param string job id
     * @return object
	 */
	public function getByCode($code) {
		$select = $this->_db->select()	
					->from(array('comment' => 'comment'))
					->joinLeft(array('rate' => 'rate'), "rate.rate_item_type = 'COMMENT' and rate.rate_item_code = comment.comment_code and rate_deleted = 0", array('rate_number', 'rate_percent' => '(rate.rate_number/10)*100'))
					->where('comment_deleted = 0 and comment_active = 1')
					->where('comment_code = ?', $code)
					->limit(1);
       
		$result = $this->_db->fetchRow($select);
        return ($result == false) ? false : $result = $result;
	}	

	public function getByType($type, $code) {
		$select = $this->_db->select()
					->from(array('comment' => 'comment'))
					->joinLeft(array('rate' => 'rate'), "rate.rate_item_type = 'COMMENT' and rate.rate_item_code = comment.comment_code and rate_deleted = 0", array('rate_number', 'rate_percent' => '(rate.rate_number/10)*100'))
					->where('comment.comment_item_code = ?', $code)
					->where('comment.comment_item_type = ?', $type)
					->where('comment_deleted = 0 and comment_active = 1')
					->order('comment_added desc');					

		$result = $this->_db->fetchAll($select);
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
			->from(array('comment' => 'comment'))	
			->where('comment_code = ?', $code)
			->limit(1);

	   $result = $this->_db->fetchRow($select);	
        return ($result == false) ? false : $result = $result;					   
	}
	/**
	 * get domain by domain Account Id
 	 * @param string domain id
     * @return object
	 */
	function createCode() {
		/* New code. */
		$code = "";
		$codeAlphabet = "1234567890";

		$count = strlen($codeAlphabet) - 1;
		
		for($i=0;$i<5;$i++){
			$code .= $codeAlphabet[rand(0,$count)];
		}
		/* First check if it exists or not. */
		$commentCheck = $this->getCode($code);
		
		if($commentCheck) {
			/* It exists. check again. */
			$this->createCode();
		} else {
			return $code;
		}
	}
}
?>