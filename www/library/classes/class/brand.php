<?php


//custom account item class as account table abstraction
class class_brand extends Zend_Db_Table_Abstract
{
   //declare table variables
    protected $_name				= 'brand';
	protected $_primary			= 'brand_code';

	function init()	{
		global $zfsession;
		$this->_site			= $zfsession->config['site'];
	}
	/**
	 * get domain by domain supplier Id
 	 * @param string domain id
     * @return object
	 */
	public function getByCode($code) {
		$select = $this->_db->select()	
			->from(array('brand' => 'brand'))	
			->joinLeft(array('media' => 'media'), "media.media_category = 'IMAGE' and media.media_item_type = 'BRAND' and media.media_item_code = brand.brand_code and media_primary = 1 and media_deleted = 0", array('media_code', 'media_code', 'media_path', 'media_ext'))
			->where('brand.brand_deleted = 0')	
			->where('brand_code = ?', $code)
			->limit(1);

		$result = $this->_db->fetchRow($select);	
        return ($result == false) ? false : $result = $result;					   
	}
	
	/**
	 * get domain by domain supplier Id
 	 * @param string domain id
     * @return object
	 */
	public function getByUrl($url) {
		$select = $this->_db->select()	
			->from(array('brand' => 'brand'))	
			->joinLeft(array('media' => 'media'), "media.media_category = 'IMAGE' and media.media_item_type = 'BRAND' and media.media_item_code = brand.brand_code and media_primary = 1 and media_deleted = 0", array('media_code', 'media_code', 'media_path', 'media_ext'))
			->where('brand.brand_deleted = 0')
			->where('brand_url = ?', $url)
			->limit(1);

		$result = $this->_db->fetchRow($select);	
        return ($result == false) ? false : $result = $result;					   
	}
	
	/**
	 * get domain by domain supplier Id
 	 * @param string domain id
     * @return object
	 */
	public function getAll()
	{
		$select = $this->_db->select()	
					->from(array('brand' => 'brand'))	
					->joinLeft(array('media' => 'media'), "media.media_category = 'IMAGE' and media.media_item_type = 'BRAND' and media.media_item_code = brand.brand_code and media_primary = 1 and media_deleted = 0", array('media_code', 'media_code', 'media_path', 'media_ext'))
					->joinLeft('supplier', 'supplier.supplier_code = brand.supplier_code')
					->where('brand.brand_deleted = 0 and supplier_deleted = 0');

	   $result = $this->_db->fetchAll($select);	
        return ($result == false) ? false : $result = $result;					   
	}
	
	public function pairs() {
		$select = $this->select()
					   ->from(array('brand' => 'brand'), array('brand.brand_code', 'brand.brand_name'))
					   ->where('brand.brand_deleted = 0')
					   ->order('brand.brand_added asc');

		$result = $this->_db->fetchPairs($select);
		return ($result == false) ? false : $result = $result;
	}
	/**
	 * get domain by domain supplier Id
 	 * @param string domain id
     * @return object
	 */
	public function getCode($code)
	{
			$select = $this->_db->select()	
						->from(array('brand' => 'brand'))
						->where('brand_code = ?', $code)
						->limit(1);

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
	
	public function validateTwitter($handler) {
		
		$handler = str_replace('@' , '' , $handler);
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_URL, 'https://twitter.com/users/username_available?username='.$handler);
		$result = curl_exec($ch);
		curl_close($ch);

		$obj = json_decode($result);

		if($obj->reason == 'taken') {
			return $handler;
		} else {
			return '';
		}
	}
	
	function createBit($longurl){

		$url = "http://api.bit.ly/shorten?version=2.0.1&longUrl=$longurl&login=willownettica&apiKey=R_7e4f545822114a9d9e6ace21904c57e1&format=json&history=1"; 
		
		$s = curl_init();
		curl_setopt($s,CURLOPT_URL, $url);  
		curl_setopt($s,CURLOPT_HEADER,false);  
		curl_setopt($s,CURLOPT_RETURNTRANSFER,1);  
		$result = curl_exec($s);  
		curl_close( $s );  

		$obj = json_decode($result, true); 

		return $obj["results"]["$longurl"]["shortUrl"];  
	}
	
	public function validateInstagram($handler) {
		if(!empty($handler) && preg_match('/^[a-zA-Z0-9._]+$/', $handler)) {
			return $handler;
		} else {
			return '';
		}
	}
}
?>