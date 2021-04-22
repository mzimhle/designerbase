<?php
//custom account item class as account table abstraction
class class_checkout extends Zend_Db_Table_Abstract
{
   //declare table variables
    protected	$_name 		= 'checkout';
	protected	$_primary	= 'checkout_code';
	/**
	 * get job by job checkout Id
 	 * @param string job id
     * @return object
	 */
	public function getByCode($code) {
		
		$itemtotal = $this->_db->select()	
			->from(array('checkoutitem' => 'checkoutitem'), array('checkout_code', 'checkout_item_total' => new Zend_Db_Expr('SUM(IFNULL(checkoutitem.checkoutitem_amount, 0))')))
			->where('checkoutitem_deleted = 0')
			->group('checkoutitem.checkout_code');

		$select = $this->_db->select()	
			->from(array('checkout' => 'checkout'))	
			->joinLeft(array('checkoutitem' => $itemtotal), 'checkoutitem.checkout_code = checkout.checkout_code', array('ifnull(checkout_item_total, 0) as checkout_item_total'))
			->joinLeft(array('participant' => 'participant'), 'participant.participant_code = checkout.participant_code', array('participant_name', 'participant_number'))
			->joinLeft(array('areapost' => 'areapost'), 'areapost.areapost_code = checkout.areapost_code', array('areapost_name'))			
			->joinLeft(array('participant' => 'participant'), 'participant.participant_code = checkout.participant_code')
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
	public function paginate($start, $length, $filter = array()) {

		$where 	= 'checkout.checkout_deleted = 0';
		$csv 	= 0;

		if(count($filter) > 0) {	
			for($i = 0; $i < count($filter); $i++) {
				if(isset($filter[$i]['filter_search']) && trim($filter[$i]['filter_search']) != '') {
					$array = explode(" ",trim($filter[$i]['filter_search']));					
					if(count($array) > 0) {
						$where .= " and (";
						for($s = 0; $s < count($array); $s++) {
							$text = $array[$s];
							$this->sanitize($text);
							$where .= "lower(concat_ws(checkout_code, checkout_email, participant_number)) like lower('%$text%')";
							if(($s+1) != count($array)) {
								$where .= ' or ';
							}
						}
					}
					$where .= ")";
				} else if(isset($filter[$i]['filter_arearegionid']) && trim($filter[$i]['filter_arearegionid']) != '') {
					$arearegionid = trim($filter[$i]['filter_arearegionid']);
					$this->sanitize($arearegionid);
					$where .= " and areapostregion.areapostregion_id = '$arearegionid'";						
				} else if(isset($filter[$i]['filter_csv']) && (int)trim($filter[$i]['filter_csv']) == 1) {
					$csv = 1;
				}
			}
		}
			
		$itemtotal = $this->_db->select()	
			->from(array('checkoutitem' => 'checkoutitem'), array('checkout_code', 'checkout_item_total' => new Zend_Db_Expr('SUM(IFNULL(checkoutitem.checkoutitem_amount, 0))')))
			->where('checkoutitem_deleted = 0')
			->group('checkoutitem.checkout_code');
					
		$select = $this->_db->select()	
			->from(array('checkout' => 'checkout'))	
			->joinLeft(array('checkoutitem' => $itemtotal), 'checkoutitem.checkout_code = checkout.checkout_code', array('ifnull(checkout_item_total, 0) as checkout_item_total'))
			->joinLeft(array('participant' => 'participant'), 'participant.participant_code = checkout.participant_code', array('participant_name', 'participant_number'))
			->joinLeft(array('areapost' => 'areapost'), 'areapost.areapost_code = checkout.areapost_code', array('areapost_name'))			
			->joinLeft(array('participant' => 'participant'), 'participant.participant_code = checkout.participant_code')
			->where('checkout_deleted = 0')
			->where($where)
			->order('checkout_added desc');

		if($csv) {
			$result = $this->_db->fetchAll($select);
			return ($result == false) ? false : $result = $result;	
		} else {
			$result_count = $this->_db->fetchRow("select count(*) as query_count from ($select) as query");
			$result = $this->_db->fetchAll($select . " limit $start, $length");
			return ($result === false) ? false : $result = array('count'=>$result_count['query_count'],'displayrecords'=>count($result),'records'=>$result);	
		}
	}	
}
?>