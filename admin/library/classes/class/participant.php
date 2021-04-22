<?php

//custom account item class as account table abstraction
class class_participant extends Zend_Db_Table_Abstract
{
   //declare table variables
    protected $_name    = 'participant';
	protected $_primary = 'participant_code';
	
	public $_mailbok_subscription   = null;
	public $_mailbok_client         = null;
	
	function init()	{

	    global $zfsession;

    	$this->_mailbok_subscription   = $zfsession->config['mailbok_subscription'];
    	$this->_mailbok_client         = $zfsession->config['mailbok_client'];

	}
	/**
	 * Insert the database record
	 * example: $table->insert($data);
	 * @param array $data
     * @return boolean
	 */
	public function insert(array $data) {
        // add a timestamp
        $data['participant_added']		= date('Y-m-d H:i:s');
        $data['participant_code']		= $this->createCode();
		$data['participant_hashcode']	= md5(date('Y-m-d H:i:s'));
		$data['participant_password']	= $this->createPassword();
		/* Add the participant. */
		$success = parent::insert($data);
		/* Check if its successfully added. */
		if($success) {
			/* Get the participant's details. */
			$participantData = $this->getByCode($success);			
			/* Check if it exists. */
			if($participantData) {
				/* Add to mailbok. */
				$subscriber                         = array();
				$subscriber['subscribe_name']		= $participantData['participant_name'];
				$subscriber['subscribe_email']		= $participantData['participant_email'];
				$subscriber['subscribe_cellphone']	= $participantData['participant_number'];
				$subscriber['subscribe_reference']  = $participantData['participant_code'];
				$subscriber['subscription_code']	= $this->_mailbok_subscription;
				$subscriber['client_code']          = $this->_mailbok_client;				
				$subscriber['action']               = 'add';
				$this->addMailbok($subscriber);
				return $success;
			} else {
				/* There is no participant details. */
				return false;
			}
		} else {
			/* Participant was not successfully added. */
			return false;
		}
    }
    public function addMailbok($subscriber) {
        //API Url
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,'http://www.mailbok.co.za/api/subscriber');
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($subscriber));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
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
		$data['participant_updated'] = date('Y-m-d H:i:s');
        $result = parent::update($data, $where);
        /* Send to mailbok. */
        if(isset($data['participant_code'])) {
			/* Get the participant's details. */
			$participantData = $this->getByCode($data['participant_code']);			
			/* Check if it exists. */
			if($participantData) {
        		$subscriber                         = array();
        		$subscriber['subscribe_name']		= $participantData['participant_name'];
        		$subscriber['subscribe_email']		= $participantData['participant_email'];
        		$subscriber['subscribe_cellphone']	= $participantData['participant_number'];
        		$subscriber['subscribe_reference']  = $participantData['participant_code'];
        		$subscriber['subscribe_status']     = $participantData['participant_active'];
        		$subscriber['subscription_code']	= $this->_mailbok_subscription;
        		$subscriber['client_code']          = $this->_mailbok_client;				
        		$subscriber['action']               = 'add';
        		$this->addMailbok($subscriber);
			}
        }
		return $result;
    }

	public function getSearch($start, $length, $filters = array()) {

		$where = 'participant_deleted = 0';
		$order = 'participant_name desc';

		if(isset($filters['filter_text']) && trim($filters['filter_text']) != '') {
			$search = $filters['filter_text'];
			$where .= " and lower(concat_ws(participant_name, ' ', participant_number, ' ', participant_email)) like lower('%$search%')";
			$order = "LOCATE('$search', concat_ws(participant_name, ' ', participant_number, ' ', participant_email))";
		}

		$select = $this->_db->select()
			->from(array('participant' => 'participant'))
			->joinLeft(array('areapost' => 'areapost'), 'areapost.areapost_code = participant.areapost_code', array('areapost_name'))
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
	public function getByCode($reference)
	{
		$select = $this->_db->select()	
			->from(array('participant' => 'participant'))
			->joinLeft(array('areapost' => 'areapost'), 'areapost.areapost_code = participant.areapost_code')
			->where('participant_code = ?', $reference)
			->where('participant_deleted = 0')
			->limit(1);

	   $result = $this->_db->fetchRow($select);	
        return ($result == false) ? false : $result = $result;					   
	}
	
	/**
	 * get domain by domain Account Id
 	 * @param string domain id
     * @return object
	 */
	public function getCode($reference)
	{
		$select = $this->_db->select()	
			->from(array('participant' => 'participant'))	
			->where('participant_code = ?', $reference)
			->limit(1);

	   $result = $this->_db->fetchRow($select);	
        return ($result == false) ? false : $result = $result;					   
	}
	
	function createPassword() {
		/* New code. */
		$password = "";
		$codeAlphabet = "abcdefghigklmnopqrstuvwxyz";
		$codeAlphabet .= "0123456789";
		$count = strlen($codeAlphabet) - 1;
		for($i=0;$i<5;$i++){
			$password .= $codeAlphabet[rand(0,$count)];
		}
		return $password;
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

		for($i=0;$i<2;$i++){
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
	/**
	 * get job by job participant Id
 	 * @param string job id
     * @return object
	 */
	public function getByEmail($email, $code = null) {
		if($code == null) {
			$select = $this->_db->select()	
				->from(array('participant' => 'participant'))	
				->where('participant_email = ?', $email)
				->where('participant_deleted = 0')
				->limit(1);
		} else {
			$select = $this->_db->select()	
				->from(array('participant' => 'participant'))	
				->where('participant_email = ?', $email)
				->where('participant_code != ?', $code)
				->where('participant_deleted = 0')
				->limit(1);		
		}
	   
		$result = $this->_db->fetchRow($select);
		return ($result == false) ? false : $result = $result;
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