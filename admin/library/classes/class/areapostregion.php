<?php


//custom account item class as account table abstraction
class class_areapostregion extends Zend_Db_Table_Abstract
{
   //declare table variables
    protected $_name	= 'areapostregion';
	protected $_primary	= 'areapostregion_code';

	/**
	 * Insert the database record
	 * example: $table->insert($data);
	 * @param array $data
     * @return boolean
	 */ 

	public function insert(array $data) {
        // add a timestamp
        $data['areapostregion_added']	= date('Y-m-d H:i:s');
        $data['areapostregion_code']		= $this->createCode();
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
        $data['areapostregion_updated'] = date('Y-m-d H:i:s');
        return parent::update($data, $where);
    }
	
	/**
	 * get domain by domain supplier Id
 	 * @param string domain id
     * @return object
	 */
	public function getByCode($code) {
		$select = $this->_db->select()	
			->from(array('areapostregion' => 'areapostregion'))
			->where('areapostregion_code = ?', $code)
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
			->from(array('areapostregion' => 'areapostregion'));

	    $result = $this->_db->fetchAll($select);	
        return ($result == false) ? false : $result = $result;					   
	}
	
	public function provincePairs() {
		$select = $this->select()
		   ->from(array('areapostregion' => 'areapostregion'), array('areapostregion.areapostregion_id', "concat(areapostregion.demarcation_name, '(', count(areapostregion_id), ')') as demarcation_name"))
		   ->where("areapostregion_id is not null and areapostregion_id != ''")
		   ->group(array('areapostregion.areapostregion_id', 'demarcation_name'))
		   ->order('areapostregion.areapostregion_id asc');

		$result = $this->_db->fetchPairs($select);
		return ($result == false) ? false : $result = $result;
	}
	
	public function pairs() {
		$select = $this->select()
		   ->from(array('areapostregion' => 'areapostregion'), array('areapostregion.areapostregion_code', 'areapostregion.areapostregion_name'))
		   ->order('areapostregion.areapostregion_added asc');

		$result = $this->_db->fetchPairs($select);
		return ($result == false) ? false : $result = $result;
	}	
}
?>