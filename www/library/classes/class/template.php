<?php

//custom account item class as account table abstraction
class class_template extends Zend_Db_Table_Abstract
{
   //declare table variables
    protected	$_name		= 'template';
	public		$_primary	= null;
	
	/**
	 * Insert the database record
	 * example: $table->insert($data);
	 * @param array $data
     * @return boolean
	 */ 

	 public function insert(array $data)
    {
        // add a timestamp
        $data['template_added']	= date('Y-m-d H:i:s');
        $data['template_code']	= isset($data['template_code']) ? $data['template_code'] : $this->createCode();
		
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
        $data['template_updated'] = date('Y-m-d H:i:s');
        
        return parent::update($data, $where);
    }
	
	/**
	 * get job by job template Id
 	 * @param string job id
     * @return object
	 */
	public function getByCode($code)
	{
		$select = $this->_db->select()
				->from(array('template' => 'template'))
				->where('template_deleted = 0')
				->where('template_code = ?', $code)
				->limit(1);
       
	   $result = $this->_db->fetchRow($select);
        return ($result == false) ? false : $result = $result;

	}
	/**
	 * get job by job template Id
 	 * @param string job id
     * @return object
	 */
	public function getTemplate($code, $type, $category = 'EMAIL') {
		if($category == 'EMAIL') {
			$select = $this->_db->select()	
					->from(array('template' => 'template'))
					->where("template_deleted = 0 and template_category = 'EMAIL' and template_subject != '' and template_file != ''")
					->where('template_code = ?', $code)
					->where('template_type = ?', $type)
					->limit(1);

		} else if($category == 'SMS'){
			$select = $this->_db->select()	
					->from(array('template' => 'template'))
					->where("template_deleted = 0 and template_category = 'SMS' and template_message != ''")
					->where('template_code = ?', $code)
					->where('template_type = ?', $type)
					->limit(1);
		} else {
			return false;
		}
		$result = $this->_db->fetchRow($select);
		return ($result == false) ? false : $result = $result;
	}
	/**
	 * get job by job template Id
 	 * @param string job id
     * @return object
	 */
	public function getAll()
	{
		$select = $this->_db->select()	
					->from(array('template' => 'template'))
					->where('template_deleted = 0');
		$result = $this->_db->fetchAll($select);
        return ($result == false) ? false : $result = $result;
	}	
	
	/**
	 * get job by job template Id
 	 * @param string job id
     * @return object
	 */
	public function getByType($type, $code = null)
	{
		if($code == '') {
			$select = $this->_db->select()	
						->from(array('template' => 'template'))
						->where('template_deleted = 0 and template_type = ?', $type);
		} else {
			$select = $this->_db->select()	
						->from(array('template' => 'template'))
						->where('template_deleted = 0 and template_type = ?', $type)
						->where('template_code != ?', $code);
		}

		$result = $this->_db->fetchRow($select);
        return ($result == false) ? false : $result = $result;
	}	
	
	public function pairs()
	{
		$select = $this->_db->select()
					->from(array('template' => 'template'), array('template_code', 'template_name'))
					->where('template_deleted = 0')
					->order('template_name');
						
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
						->from(array('template' => 'template'))	
					   ->where('template_code = ?', $code)
					   ->limit(1);

	   $result = $this->_db->fetchRow($select);	
        return ($result == false) ? false : $result = $result;
	}
	
	function createCode() {
		/* New code. */
		$code = "";
		
		$Alphabet 	= "ABCEGHKMNOPQRSUXZ";
		$Number 	= '1234567890';
		
		/* First two Alphabets. */
		$count = strlen($Alphabet) - 1;
		
		for($i=0;$i<2;$i++){
			$code .= $Alphabet[rand(0,$count)];
		}
		
		/* Next six numbers */
		$count = strlen($Number) - 1;
		
		for($i=0;$i<1;$i++){
			$code .= $Number[rand(0,$count)];
		}
		
		/* Last alphabet. */
		$count = strlen($Alphabet) - 1;
		
		for($i=0;$i<2;$i++){
			$code .= $Alphabet[rand(0,$count)];
		}
		
		/* Next six numbers */
		$count = strlen($Number) - 1;
		
		for($i=0;$i<3;$i++){
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
}
?>