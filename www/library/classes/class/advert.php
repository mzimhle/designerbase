<?php

require_once 'media.php';
require_once 'link.php';

//custom account item class as account table abstraction
class class_advert extends Zend_Db_Table_Abstract 
{
	//declare table variables
    protected	$_name		= 'advert';
	protected 	$_primary	= 'advert_code';
	protected	$_media		= null;
	protected	$_link		= null;
	
	function init()	{
		$this->_media   = new class_media();
		$this->_link   = new class_link();
	}
	/**
	 * Insert the database record
	 * example: $table->insert($data);
	 * @param array $data
     * @return boolean
	 */
	public function insert(array $data) {
        // add a timestamp
        $data['advert_added']	= date('Y-m-d H:i:s');
		$data['advert_code']	= $this->createCode();
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
        $data['advert_updated'] = date('Y-m-d H:i:s');
        
        return parent::update($data, $where);
    }
	/**
	 * get job by job advert Id
 	 * @param string job id
     * @return object
	 */
	public function getByCode($code) {
		$select = $this->_db->select()	
			->from(array('advert' => 'advert'))
			->joinLeft(array('media' => 'media'), "media.media_category = 'IMAGE' and advert.advert_code = media.media_item_code and media.media_item_type = 'ADVERT' and media.media_primary = 1", array('media_code', 'media_path', 'media_ext'))
			->where('advert_code = ?', $code)
			->where('advert_deleted = 0')
			->limit(1);
       
		$result = $this->_db->fetchRow($select);
        return ($result == false) ? false : $result = $result;
	}
	/**
	 * get job by job advert Id
 	 * @param string job id
     * @return object
	 */
	public function dateRange($type, $position, $page) {
	    
		$select = $this->_db->select()	
			->from(array('advert' => 'advert'))
			->where('advert_type = ?', $type)
			->where('advert_position = ?', $position)
			->where('advert_page = ?', $page)
			->where('advert_deleted = 0')
			->limit(1);

		$result = $this->_db->fetchRow($select);

		if($result) {
		    if($result['advert_type'] == 'PRODUCT') {
                $feature = $this->_link->getByParent('ADVERT', $result['advert_code'], 'CATALOG');
    			if($feature) {
    				$result['product'] = $feature;
    			} else {
    				return false;
    			}                
		    } else {
    			$media = $this->_media->getByItem('ADVERT', $result['advert_code']);
    			
    			if($media) {
    				$result['media'] = $media;
    			} else {
    				return false;
    			}
		    }
		}
        return ($result == false) ? false : $result = $result;
	}
	/**
	 * get job by job advert Id
 	 * @param string job id
     * @return object
	 */	
	function validateDate($date, $format = 'Y-m-d') {
		$d = DateTime::createFromFormat($format, $date);
		return $d && $d->format($format) == $date;
	}	
	/**
	 * get job by job advert Id
 	 * @param string job id
     * @return object
	 */
	public function getAll() {
		$select = $this->_db->select()	
			->from(array('advert' => 'advert'))
			->joinLeft(array('media' => 'media'), "media.media_category = 'IMAGE' and advert.advert_code = media.media_item_code and media.media_item_type = 'ADVERT' and media.media_primary = 1", array('media_code', 'media_path', 'media_ext'))		
			->where('advert_deleted = 0');					

		$result = $this->_db->fetchAll($select);
		return ($result == false) ? false : $result = $result;	
	}
	/**
	 * get job by job advert Id
 	 * @param string job id
     * @return object
	 */
	public function getCode($code) {
		$select = $this->_db->select()	
			->from(array('advert' => 'advert'))
			->where('advert_code = ?', $code)
			->limit(1);
       
		$result = $this->_db->fetchRow($select);
        return ($result == false) ? false : $result = $result;
	}	
	/**
	 * get job by job advert Id
 	 * @param string job id
     * @return object
	 */
	function createCode() {
		/* New code. */
		$code		= "";
		$Alphabet 	= "ABCEGHKLMNOPQRSUXYZ";
		$Number 	= '1234567890';
		/* First two Alphabets. */
		$count = strlen($Alphabet) - 1;
		
		for($i=0;$i<3;$i++){
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
}
?>