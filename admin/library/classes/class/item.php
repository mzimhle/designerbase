<?php

//custom account item class as account table abstraction
class class_item extends Zend_Db_Table_Abstract
{
   //declare table variables
    protected $_name 			= 'item';
	protected $_primary 		= 'item_code';
	
	/**
	 * Insert the database record
	 * example: $table->insert($data);
	 * @param array $data
     * @return boolean
	 */ 
	public function insert(array $data) {
        // add a timestamp
        $data['item_added']		= date('Y-m-d H:i:s');
        $data['item_code']		= $this->createCode();
		
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
        $data['item_updated'] = date('Y-m-d H:i:s');
        
        return parent::update($data, $where);
    }
	
	/**
	 * get job by job item Id
 	 * @param string job id
     * @return object
	 */
	public function getByCode($code) {
		$select = $this->_db->select()	
			->from(array('item' => 'item'))
			->where('item_deleted = 0')
			->where('item_code = ?', $code)
			->limit(1);
       
	   $result = $this->_db->fetchRow($select);
        return ($result == false) ? false : $result = $result;

	}	

	public function getByType($type) {
		$select = $this->_db->select()	
			->from(array('item' => 'item'))
			->joinLeft(array('media' => 'media'), "media.media_category = 'IMAGE' and media.media_item_type = 'FEATURE' and media.media_item_code = item.item_code and media_primary = 1 and media_deleted = 0", array('media_code', 'media_path', 'media_ext'))
			->where('item.item_type = ?', $type)
			->where('item_deleted = 0')
			->order('item_added DESC');					

		$result = $this->_db->fetchAll($select);
		return ($result == false) ? false : $result = $result;
	}

	public function typePairs($type) {
		$select = $this->_db->select()	
			->from(array('item' => 'item'), array('item_code', 'item_name'))
			->where('item.item_type = ?', $type)
			->where("item.item_parent = '' or item.item_parent is null")
			->where('item_deleted = 0')
			->order('item_added DESC');					

		$result = $this->_db->fetchPairs($select);
		return ($result == false) ? false : $result = $result;
	}

	public function getByParentType($parent, $type) {
		if($type == '') {
			$select = $this->_db->select()
				->from(array('item' => 'item'))
				->joinLeft(array('media' => 'media'), "media.media_category = 'IMAGE' and media.media_item_type = 'FEATURE' and media.media_item_code = item.item_code and media_primary = 1 and media_deleted = 0", array('media_code', 'media_path', 'media_ext'))
				->where('item.item_parent = ?', $parent)
				->where('item_deleted = 0')
				->order('item_added DESC');
		} else {
			$select = $this->_db->select()
				->from(array('item' => 'item'))
				->joinLeft(array('media' => 'media'), "media.media_category = 'IMAGE' and media.media_item_type = 'FEATURE' and media.media_item_code = item.item_code and media_primary = 1 and media_deleted = 0", array('media_code', 'media_path', 'media_ext'))
				->where('item.item_parent = ?', $parent)
				->where('item.item_type = ?', $type)
				->where('item_deleted = 0')
				->order('item_added DESC');
		}
		$result = $this->_db->fetchAll($select);
		return ($result == false) ? false : $result = $result;
	}

	public function getByParent($parent) {
		$select = $this->_db->select()
				->from(array('item' => 'item'))
				->joinLeft(array('media' => 'media'), "media.media_category = 'IMAGE' and media.media_item_type = 'FEATURE' and media.media_item_code = item.item_code and media_primary = 1 and media_deleted = 0", array('media_code', 'media_path', 'media_ext'))
				->where('item.item_parent = ?', $parent)
				->where('item_deleted = 0')
				->order('item_added DESC');					

		$result = $this->_db->fetchAll($select);
		return ($result == false) ? false : $result = $result;
	}

	public function selectCipher($type) {
		$select = $this->_db->select()
				->from(array('item' => 'item'), array('item_cipher', 'item_cipher'))
				->where('item_deleted = 0 and item_type = ?', $type)
				->group('item_cipher')
				->order('item_added DESC');					

		$result = $this->_db->fetchPairs($select);
		return ($result == false) ? false : $result = $result;
	}

	public function getSearch($start, $length, $filters = array()) {

		$where = 'item_deleted = 0';
		$order = 'item_name desc';

		if(isset($filters['filter_text']) && trim($filters['filter_text']) != '') {
			$search = $filters['filter_text'];
			$where .= " and lower(concat_ws(item_name, ' ', item_value)) like lower('%$search%')";
			$order = "LOCATE('$search', concat_ws(item_name, item_value))";
		}
		if(isset($filters['filter_type']) && trim($filters['filter_type']) != '') {
			$text = trim($filters['filter_type']);
			$where .= " and item_type = '$text'";
		}
		if(isset($filters['filter_variable']) && trim($filters['filter_variable']) != '') {
			$text = trim($filters['filter_variable']);
			$where .= " and item_variable = '$text'";
		}
		if(isset($filters['filter_cipher']) && trim($filters['filter_cipher']) != '') {
			$text = trim($filters['filter_cipher']);
			$where .= " and item_cipher = '$text'";
		}
		if(isset($filters['filter_parent']) && trim($filters['filter_parent']) != '') {
			$text = trim($filters['filter_parent']);
			$where .= " and item_parent = '$text'";
		}

		$select = $this->_db->select()
			->from(array('item' => 'item'))
			->joinLeft(array('media' => 'media'), "media.media_category = 'IMAGE' and media.media_item_type = 'FEATURE' and media.media_item_code = item.item_code and media_primary = 1 and media_deleted = 0", array('media_code', 'media_path', 'media_ext'))
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
	public function getCode($code)
	{
		$select = $this->_db->select()	
			->from(array('item' => 'item'))	
			->where('item_code = ?', $code)
			->limit(1);

	   $result = $this->_db->fetchRow($select);	
        return ($result == false) ? false : $result = $result;					   
	}
	
	function createCode() {
		/* New code. */
		$code = "";
		$codeAlphabet = "1234567890";

		$count = strlen($codeAlphabet) - 1;
		
		for($i=0;$i<5;$i++){
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

	public function toUrl($title) {
		
		$name = strtolower(trim($title));
		$name = preg_replace('/\W+/', '-', strtolower($name));
		$name = str_replace(' ' , '-' , $name);
		$name = str_replace('__' , '-' , $name);
		$name = str_replace('_' , '-' , $name);
		$name = str_replace(' ' , '' , $name);
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
		$name = str_replace(' ' , '-' , $name);
		$name = str_replace('__' , '-' , $name);
		$name = str_replace(' ' , '-' , $name);
		
		return $name;
	}	
}
?>