<?php

//custom account item class as account table abstraction
class class_mailing extends Zend_Db_Table_Abstract
{
   //declare table variables
    protected $_name	= 'mailing';
	protected $_primary	= 'mailing_code';
	/**
	 * Insert the database record
	 * example: $table->insert($data);
	 * @param array $data
     * @return boolean
	 */
	public function insert(array $data) {
        // add a timestamp
        $data['mailing_added']		= date('Y-m-d H:i:s');
        $data['mailing_code']		= $this->createCode();

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
		$data['mailing_updated'] = date('Y-m-d H:i:s');
        
        return parent::update($data, $where);
		
    }

	public function getSearch($start, $length, $filters = array()) {

		$where = 'mailing_deleted = 0';
		$order = 'mailing_name desc';

		if(isset($filters['filter_text']) && trim($filters['filter_text']) != '') {
			$search = $filters['filter_text'];
			$where .= " and lower(concat_ws(mailing_name, ' ', mailing_email, ' ', mailing_cellphone, ' ', mailing_category)) like lower('%$search%')";
			$order = "LOCATE('$search', concat_ws(mailing_name, ' ', mailing_email, ' ', mailing_cellphone, ' ', mailing_category))";
		}

		$select = $this->_db->select()
			->from(array('mailing' => 'mailing'))
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
			->from(array('mailing' => 'mailing'))	
			->where('mailing_code = ?', $reference)
			->where('mailing_deleted = 0')
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
			->from(array('mailing' => 'mailing'))	
			->where('mailing_code = ?', $reference)
			->limit(1);

	   $result = $this->_db->fetchRow($select);	
        return ($result == false) ? false : $result = $result;					   
	}

	function createCode() {
		/* New code. */
		$code	= "";
		$Number	= '1234567890';
		$limit	= rand(7, 10);
		/* First two alphabets. */
		$count = strlen($Number) - 1;
		/* Create the code. */
		for($i=0;$i<$limit;$i++){
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
	/**
	 * get job by job mailing Id
 	 * @param string job id
     * @return object
	 */
	public function getByEmail($email, $code = null) {
		if($code == null) {
			$select = $this->_db->select()	
				->from(array('mailing' => 'mailing'))	
				->where('mailing_email = ?', $email)
				->where('mailing_deleted = 0')
				->limit(1);
		} else {
			$select = $this->_db->select()	
				->from(array('mailing' => 'mailing'))	
				->where('mailing_email = ?', $email)
				->where('mailing_code != ?', $code)
				->where('mailing_deleted = 0')
				->limit(1);		
		}

		$result = $this->_db->fetchRow($select);
		return ($result == false) ? false : $result = $result;
	}
	/**
	 * get job by job mailing Id
 	 * @param string job id
     * @return object
	 */
	public function getByCell($cellphone, $code = null) {
		if($code == null) {
			$select = $this->_db->select()	
				->from(array('mailing' => 'mailing'))	
				->where('mailing_cellphone = ?', $cellphone)
				->where('mailing_deleted = 0')
				->limit(1);
		} else {
			$select = $this->_db->select()	
				->from(array('mailing' => 'mailing'))	
				->where('mailing_cellphone = ?', $cellphone)
				->where('mailing_code != ?', $code)
				->where('mailing_deleted = 0')
				->limit(1);		
		}

		$result = $this->_db->fetchRow($select);
		return ($result == false) ? false : $result = $result;
	}
	
	public function readImport($files, $category) {
		//Import uploaded file to Database
		$handle 	= fopen($files['tmp_name'], "r");
		$imported 	= array();
		$lines 		= 0;
		$i 			= 0;

		$errors								= array();			
		$errors['successful']		= 0;
		$errors['baddata']			= 0;
		$errors['badlines']			= '';
		$errors['duplicatecell']	= 0;
		$errors['duplicateemail']	= 0;	
		$errors['total']			= 0;	
		
		while (($line = fgets($handle)) !== FALSE) {

			$check			= false;
			$data			= array();			
			$originalline	= $line;

			$line	= $this->importLineFormat($line);
			/* Check Email. */						
			$email	= $this->extractEmail($line);

			if($email) {
				/* Remove email address. */
				$line = str_replace($email, '', $line);
				/* Check if email already exists. */
				$emailCheck = $this->getByEmail($email);
				
				if(!$emailCheck) {
					/* Add email. */
					$check = true;
					$data['mailing_email'] = $email;
				} else {
					$errors['duplicateemail']++;
				}
			}
			/* Check cellphone */
			$number = $this->extractNumber($line);
			if($number) {
				/* Remove cellphone. */				
				$line = str_replace($number, '', $line);
				/* Check if cellphone already exists. */					
				$cellCheck = $this->getByCell($number);
				
				if(!$cellCheck) {
					$check = true;
					/* Add cellphone */
					$data['mailing_cellphone'] = $number;
				} else {
					$errors['duplicatecell']++;
				}				
			}
			/* Check name. */
			if($check) {
				$data['mailing_name']		= trim($line);
				$data['mailing_category']	= trim($category);
				/* Insert. */
				$success = $this->insert($data);
			} else {
				$errors['baddata']++;
				$errors['badlines'] .= 'Email and Cellphone exists: '.$originalline.'<br />';
			}
			$errors['total']++;
		}
		return $errors;
	}
	
	public function importLineFormat($string) {
		/* Remove some weird charactors that windows dont like. */
		$string = str_replace('  ' , ' ' , $string);
		$string = str_replace(',' , ' ' , $string);
		return $string;
	}
	
	function extractEmail($string){	
		preg_match_all("/[\._a-zA-Z0-9-]+@[\._a-zA-Z0-9-]+/i", $string, $matches);
		if(isset($matches[0][0]) && $this->validateEmail(trim($matches[0][0])) != '') {			
			return $this->validateEmail(trim($matches[0][0]));			
		} else {
			return false;
		}
	}
	
	function extractNumber($string){	
		preg_match_all("/0[0-9]{9}+/i", $string, $matches);
		if(isset($matches[0][0]) && $this->validateCellphone(trim($matches[0][0])) != '') {			
			return $this->validateCellphone(trim($matches[0][0]));			
		} else {
			return false;
		}
	}	
	public function validateEmail($string) {
		if(!filter_var($string, FILTER_VALIDATE_EMAIL)) {
			return '';
		} else {
			return trim($string);
		}
	}
	public function validateCellphone($string) {
		if(preg_match('/^0[0-9]{9}$/', $this->onlyNumber(trim($string)))) {
			return $this->onlyNumber(trim($string));
		} else {
			return '';
		}
	}
	public function validateDate($string) {
		if(preg_match('/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/', $string)) {
			if(date('Y-m-d', strtotime($string)) != $string) {
				return '';
			} else {
				return $string;
			}
		} else {
			return '';
		}
	}	
	public function onlyNumber($string) {
		/* Remove some weird charactors that windows dont like. */
		$string = strtolower($string);
		$string = str_replace(' ' , '' , $string);
		$string = str_replace('__' , '' , $string);
		$string = str_replace(' ' , '' , $string);
		$string = str_replace("`", "", $string);
		$string = str_replace("/", "", $string);
		$string = str_replace("\\", "", $string);
		$string = str_replace("'", "", $string);
		$string = str_replace("(", "", $string);
		$string = str_replace(")", "", $string);
		$string = str_replace("-", "", $string);
		$string = str_replace(".", "", $string);	
		$string = str_replace('___' , '' , $string);
		$string = str_replace('__' , '' , $string);	 
		$string = str_replace(' ' , '' , $string);
		$string = str_replace('__' , '' , $string);
		$string = str_replace(' ' , '' , $string);
		$string = str_replace("`", "", $string);
		$string = str_replace("/", "", $string);
		$string = str_replace("\\", "", $string);
		$string = str_replace("'", "", $string);
		$string = str_replace("(", "", $string);
		$string = str_replace(")", "", $string);
		$string = str_replace("-", "", $string);
		$string = str_replace(".", "", $string);	
		$string = str_replace("–", "", $string);	
		$string = str_replace("#", "", $string);	
		$string = str_replace("$", "", $string);	
		$string = str_replace("@", "", $string);	
		$string = str_replace("!", "", $string);	
		$string = str_replace("&", "", $string);	
		$string = str_replace(';' , '' , $string);		
		$string = str_replace(':' , '' , $string);		
		$string = str_replace('[' , '' , $string);		
		$string = str_replace(']' , '' , $string);		
		$string = str_replace('|' , '' , $string);		
		$string = str_replace('\\' , '' , $string);		
		$string = str_replace('%' , '' , $string);	
		$string = str_replace(';' , '' , $string);		
		$string = str_replace(' ' , '' , $string);
		$string = str_replace('__' , '' , $string);
		$string = str_replace(' ' , '' , $string);	
		$string = str_replace('-' , '' , $string);	
		$string = str_replace('+27' , '0' , $string);	
		$string = str_replace('(0)' , '' , $string);	
		$string = preg_replace('/^00/', '0', $string);
		$string = preg_replace('/^27/', '0', $string);
		
		$string = preg_replace('!\s+!',"", strip_tags($string));
		
		return $string;
	}
}
?>