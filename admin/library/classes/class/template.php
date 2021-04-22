<?php

//custom account item class as account table abstraction
class class_template extends Zend_Db_Table_Abstract
{
   //declare table variables
    protected	$_name	= 'template';
	protected 	$_primary = 'template_code';
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
 	 * @param string job id getTemplate('MESSAGE', 'ENQUIRY', 'EMAIL')
     * @return object
	 */
	public function getTemplate($code, $type, $category) {
		$select = $this->_db->select()	
			->from(array('template' => 'template'))
			->where('template_code = ?', $code)
			->where('template_type = ?', $type)
			->where('template_category = ?', $category)
			->where('template_deleted = 0')
			->limit(1);

		$result = $this->_db->fetchRow($select);
        return ($result == false) ? false : $result = $result;
	}
	/**
	 * get job by job template Id
 	 * @param string job id
     * @return object
	 */
	public function getByCode($code) {
		$select = $this->_db->select()	
			->from(array('template' => 'template'))
			->where('template_code = ?', $code)
			->where('template_deleted = 0')
			->limit(1);
       
		$result = $this->_db->fetchRow($select);
        return ($result == false) ? false : $result = $result;
	}		
	
	/**
	 * get job by job template Id
 	 * @param string job id
     * @return object
	 */
	public function getByType($type = '') {
		
		if($type != '') {
			$select = $this->_db->select()	
				->from(array('template' => 'template'))
				->where('template_type = ?', $type)
				->where('template_deleted = 0');
		} else {
			$select = $this->_db->select()	
				->from(array('template' => 'template'))
				->where('template_deleted = 0');
		}
		$result = $this->_db->fetchAll($select);
        return ($result == false) ? false : $result = $result;
	}

	public function checkCode($check, $code = null) {
		if($code == null) {
			$select = $this->_db->select()	
				->from(array('template' => 'template'))
				->where('template_code = ?', $check)
				->where('template_deleted = 0');
		} else {
			$select = $this->_db->select()	
				->from(array('template' => 'template'))
				->where('template_code = ?', $check)
				->where('template_code != ?', $code)
				->where('template_deleted = 0');
		}
		$result = $this->_db->fetchRow($select);
        return ($result == false) ? false : $result = $result;		
	}
	public function getAll() {
		$select = $this->_db->select()	
			->from(array('template' => 'template'))					
			->where('template_deleted = 0');					
						
		$result = $this->_db->fetchAll($select);
		return ($result == false) ? false : $result = $result;	
	}
}
?>