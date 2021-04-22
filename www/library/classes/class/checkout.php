<?php
require_once 'checkoutitem.php';
require_once 'payweb3.php';
//custom account item class as account table abstraction
class class_checkout extends Zend_Db_Table_Abstract {
   //declare table variables
    protected	$_name 		= 'checkout';
	protected	$_primary	= 'checkout_code';

	public $_checkoutitem	= null;
	
    public $_paygateid  	= null;
    public $_paygatesecret  = null;
    
    public $_payweb3        = null;
    public $_process_url    = null;
    public $_environment    = null;
    
	function init()	{

		global $zfsession;

        $this->_environment     = $zfsession->config['environment'];
        $this->_paygateid       = $zfsession->config['paygate_id_'.$this->_environment];
        $this->_paygatesecret   = $zfsession->config['paygate_secret_'.$this->_environment];

		$this->_payweb3         = new PayGate_PayWeb3();
		$this->_process_url     = 'https://secure.paygate.co.za/payweb3/process.trans';
		$this->_checkoutitem    = new class_checkoutitem();
	}

	/**
	 * Insert the database record
	 * example: $table->insert($data);
	 * @param array $data
     * @return boolean
	 */
	public function insert(array $data) {
        // add a timestamp
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
        $data['checkout_updated'] = date('Y-m-d H:i:s');
		return parent::update($data, $where);
    }
	/**
	 * get job by job checkout Id
 	 * @param string job id
     * @return object
	 */
	public function getByCode($code) {

		$itemtotal = $this->_db->select()
			->from(array('checkoutitem' => 'checkoutitem'), array('checkout_code', 'checkout_item_total' => new Zend_Db_Expr('SUM(IFNULL(price.price_amount, 0))')))
			->joinLeft(array('price' => 'price'), 'price.price_code = checkoutitem.price_code', array())
			->where('checkoutitem_deleted = 0 and price_deleted = 0')
			->group('checkoutitem.checkout_code');

		$select = $this->_db->select()
			->from(array('checkout' => 'checkout'))
			->joinLeft(array('checkoutitem' => $itemtotal), 'checkoutitem.checkout_code = checkout.checkout_code', array('checkout_item_total'))
			->joinInner(array('participant' => 'participant'), 'participant.participant_code = checkout.participant_code')
			->joinInner(array('areapost' => 'areapost'), 'areapost.areapost_code = checkout.areapost_code')
			->joinInner(array('areapostregion' => 'areapostregion'), 'areapostregion.areapostregion_code = areapost.areapostregion_code')
			->where('checkout_deleted = 0')
			->where('checkout.checkout_code = ?', $code)
			->limit(1);

	   $result = $this->_db->fetchRow($select);
       return ($result == false) ? false : $result = $result;
	}
	
	/**
	 * get job by job checkouttype Id
 	 * @param string job id
     * @return object
	 */
	public function getAll() {
		$itemtotal = $this->_db->select()
					->from(array('checkoutitem' => 'checkoutitem'), array('checkout_code', 'checkout_item_total' => new Zend_Db_Expr('SUM(IFNULL(checkoutitem.price_amount, 0))')))
					->joinLeft(array('price' => 'price'), 'price.price_code = checkoutitem.price_code', array())
					->where('checkoutitem_deleted = 0 and price_deleted = 0')
					->group('checkoutitem.checkout_code');

		$select = $this->_db->select()
			->from(array('checkout' => 'checkout'))
			->joinLeft(array('checkoutitem' => $itemtotal), 'checkoutitem.checkout_code = checkout.checkout_code', array('checkout_item_total'))
			->joinInner(array('participant' => 'participant'), 'participant.participant_code = checkout.participant_code')
			->joinInner(array('areapost' => 'areapost'), 'areapost.areapost_code = checkout.areapost_code')
			->joinInner(array('areapostregion' => 'areapostregion'), 'areapostregion.areapostregion_code = areapost.areapostregion_code')
			->where('checkout_deleted = 0');

	   $result = $this->_db->fetchAll($select);
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
			->from(array('checkout' => 'checkout'))	
			->where('checkout_code = ?', $reference)
			->limit(1);

	   $result = $this->_db->fetchRow($select);	
       return ($result == false) ? false : $result = $result;					   
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
		/* Next six numbers */
		$count = strlen($Number) - 1;
		for($i=0;$i<2;$i++){
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
	function createReference(){
		return 'pg'.$this->_environment.'_'.date('YmdHis');
	}	
}
?>