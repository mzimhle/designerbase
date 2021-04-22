<?php

require_once 'class/media.php';

//custom account item class as account table abstraction
class class_social extends Zend_Db_Table_Abstract
{
   //declare table variables
    protected $_name 			= 'social';
	protected $_primary 		= 'social_code';
	protected $_media			= null; 
	
	function init()	{
		$this->_media	= new class_media();
	}
	
	/**
	 * Insert the database record
	 * example: $table->insert($data);
	 * @param array $data
     * @return boolean
	 */ 
	 public function insert(array $data) {
        // add a timestamp
        $data['social_added']	= date('Y-m-d H:i:s');
		$data['social_code']	= $this->createCode();
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
        $data['social_updated'] = date('Y-m-d H:i:s');
        
        return parent::update($data, $where);
    }
	
	/**
	 * get job by job social Id
 	 * @param string job id
     * @return object
	 */
	public function getByCode($code) {
		$select = $this->_db->select()	
			->from(array('social' => 'social'))
			->joinLeft(array('media' => 'media'), "media.media_category = 'IMAGE' and media.media_primary = 1 and media.media_item_code = social.social_code and media.media_item_type = 'SOCIAL'", array('media_code', 'media_path', 'media_ext', 'media_category'))
			->where('social_deleted = 0')
			->where('social_code = ?', $code)
			->limit(1);
       
		$result = $this->_db->fetchRow($select);
        return ($result == false) ? false : $result = $result;
	}
	
	public function getSearch($start, $length, $filters = array()) {

		$where = 'social_deleted = 0';
		$order = 'social_added desc';

		if(isset($filters['filter_text']) && trim($filters['filter_text']) != '') {
			$search = $filters['filter_text'];
			$where .= " and lower(social_message) like lower('%$search%')";
			$order = "LOCATE('$search', social_message)";
		}

		$select = $this->_db->select()	
			->from(array('social' => 'social'))	
			->joinLeft(array('media' => 'media'), "media.media_category = 'IMAGE' and media.media_primary = 1 and media.media_item_code = social.social_code and media.media_item_type = 'SOCIAL'", array('media_code', 'media_path', 'media_ext', 'media_category'))
			->where($where)
			->order($order);			
 
		$result_count = $this->_db->fetchRow("select count(*) as query_count from ($select) as query");

		$result = $this->_db->fetchAll($select . " limit $start, $length");
		
		if($result) {
			for($i = 0; $i < count($result); $i++) {
				if($result[$i]['social_item_type'] != 'SOCIAL' && $result[$i]['social_item_type'] != '') {
					$temp = $this->_media->getPrimaryByReference($result[$i]['social_item_type'], $result[$i]['social_item_code']);
					if($temp) {
						$result[$i] = array_merge($result[$i], $temp);
					}
				}
			}
		}

		return ($result === false) ? false : $result = array('count'=>$result_count['query_count'],'displayrecords'=>count($result),'records'=>$result);	
	}
	
	function createBit($longurl){

		$url = "http://api.bit.ly/shorten?version=2.0.1&longUrl=$longurl&login=willownettica&apiKey=R_7e4f545822114a9d9e6ace21904c57e1&format=json&history=1"; 

		$result = file_get_contents($url);

		$obj = json_decode($result, true); 

		return $obj["results"]["$longurl"]["shortUrl"];  
	}
	/**
	 * get domain by domain Account code
 	 * @param string domain code
     * @return object
	 */
	public function getCode($code) {
		$select = $this->_db->select()	
			->from(array('social' => 'social'))
			->where('social_code = ?', $code)
			->limit(1);

		$result = $this->_db->fetchRow($select);	
        return ($result == false) ? false : $result = $result;					   
	}
	
	function createCode() {
		/* New code. */
		$code = "";
		$codeAlphabet = "123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";

		$count = strlen($codeAlphabet) - 1;
		
		for($i=0;$i<10;$i++){
			$code .= $codeAlphabet[rand(0,$count)];
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