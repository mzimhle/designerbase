<?php


//custom account item class as account table abstraction
class class_brand extends Zend_Db_Table_Abstract
{
   //declare table variables
    protected $_name	= 'brand';
	protected $_primary	= 'brand_code';
	
	function init()	{
		global $zfsession;
		$this->_site	= $zfsession->config['site'];
	}

	/**
	 * Insert the database record
	 * example: $table->insert($data);
	 * @param array $data
     * @return boolean
	 */ 

	public function insert(array $data) {
        // add a timestamp
        $data['brand_added']	= date('Y-m-d H:i:s');
        $data['brand_code']		= $this->createCode();
		$data['brand_url']		= $this->toUrl($data['brand_name']);
		// $data['brand_bit']		= $this->createBit($this->_site.'/'.$data['brand_url']);

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
        $data['brand_updated'] = date('Y-m-d H:i:s');
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
	public function getBy($code) {
		$select = $this->_db->select()	
			->from(array('brand' => 'brand'))	
			->joinLeft(array('media' => 'media'), "media.media_category = 'IMAGE' and media.media_item_type = 'BRAND' and media.media_item_code = brand.brand_code and media_primary = 1 and media_deleted = 0", array('media_code', 'media_code', 'media_path', 'media_ext'))
			->where('brand.brand_deleted = 0')
		    ->where('brand.supplier_code = ?', $code);

		$result = $this->_db->fetchAll($select);	
        return ($result == false) ? false : $result = $result;					   
	}
	/**
	 * get job by job participant Id
 	 * @param string job id
     * @return object
	 */
	public function getByURL($url, $code = null) {
		if($code == null) {
			$select = $this->_db->select()	
				->from(array('brand' => 'brand'))	
				->where('brand_url = ?', $url)
				->where('brand_deleted = 0')
				->limit(1);
		} else {
			$select = $this->_db->select()	
				->from(array('brand' => 'brand'))	
				->where('brand_url = ?', $url)
				->where('brand_code != ?', $code)
				->where('brand_deleted = 0')
				->limit(1);		
		}
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
			->from(array('brand' => 'brand'))	
			->joinLeft(array('media' => 'media'), "media.media_category = 'IMAGE' and media.media_item_type = 'BRAND' and media.media_item_code = brand.brand_code and media_primary = 1 and media_deleted = 0", array('media_code', 'media_code', 'media_path', 'media_ext'))
			->where('brand.brand_deleted = 0');

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
	
	function createCode() {
		/* New code. */
		$code = "";
		// $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
		$codeAlphabet = '123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
		
		$count = strlen($codeAlphabet) - 1;
		
		for($i=0;$i<6;$i++){
			$code .= $codeAlphabet[rand(0,$count)];
		}
		
		$code = $code;
		
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
	 * get domain by domain supplier Id
 	 * @param string domain id
     * @return object
	 */
	public function getFile($file)
	{
		$select = $this->_db->select()	
				->from(array('brand' => 'brand'))	
				->where('brand_media_name = ?', $file)
				->limit(1);

	   $result = $this->_db->fetchRow($select);	
        return ($result == false) ? false : $result = $result;					   
	}
	
	function createFile() {
		/* New code. */
		$code = "";
		$codeAlphabet = '123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
		
		$count = strlen($codeAlphabet) - 1;
		
		for($i=0;$i<5;$i++){
			$code .= $codeAlphabet[rand(0,$count)];
		}
		
		/* First check if it exists or not. */
		$itemCheck = $this->getFile($code);
		
		if($itemCheck) {
			/* It exists. check again. */
			$this->createFile();
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
	public function validateNumber($string) {
		if(preg_match('/^0[0-9]{9}$/', $this->onlyNumber(trim($string)))) {
			return $this->onlyNumber(trim($string));
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
	
	public function toUrl($title) {
		$name = strtolower(trim($title));
		$name = preg_replace('/\W+/', '-', strtolower($name));
		$name = str_replace(' ' , '-' , $name);
		$name = str_replace('_' , '-' , $name);
		$name = str_replace('__' , '-' , $name);
		$name = str_replace(' ' , '-' , $name);
		$name = str_replace("é", "e", $name);
		$name = str_replace("è", "e", $name);
		$name = str_replace("`", "", $name);
		$name = str_replace("/", "", $name);
		$name = str_replace("\\", "", $name);
		$name = str_replace("'", "", $name);
		$name = str_replace("(", "", $name);
		$name = str_replace(")", "", $name);
		$name = str_replace(".", "", $name);
		$name = str_replace("ë", "e", $name);	
		$name = str_replace("â€“", "ae", $name);	
		$name = str_replace("â", "a", $name);	
		$name = str_replace("€", "e", $name);	
		$name = str_replace("“", "", $name);	
		$name = str_replace("#", "", $name);	
		$name = str_replace("$", "", $name);	
		$name = str_replace("@", "", $name);	
		$name = str_replace("!", "", $name);	
		$name = str_replace("&", "", $name);	
		$name = str_replace(';' , '' , $name);		
		$name = str_replace(':' , '' , $name);		
		$name = str_replace('[' , '' , $name);		
		$name = str_replace(']' , '' , $name);		
		$name = str_replace('|' , '' , $name);		
		$name = str_replace('\\' , '' , $name);		
		$name = str_replace('%' , '' , $name);	
		$name = str_replace(';' , '' , $name);		
		return $name;
	}
}
?>