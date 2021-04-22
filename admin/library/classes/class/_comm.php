<?php

require_once 'class/template.php';

//custom account item class as account table abstraction
class class_comm extends Zend_Db_Table_Abstract
{
   //declare table variables
    protected $_name	= '_comm';
	protected $_primary	= '_comm_code';

	public $_template	= null;
    public $_path       = null;
    public $_site       = null;
    
	function init()	{
		global $zfsession;
		$this->_template	= new class_template();
		$this->_path        = $zfsession->config['path'];
		$this->_site        = $zfsession->config['site'];
	}
	/**
	 * Insert the database record
	 * example: $table->insert($data);
	 * @param array $data
     * @return boolean
	 */ 
	public function insert(array $data) {
        // add a timestamp
        $data['_comm_added'] 	= date('Y-m-d H:i:s');
        $data['_comm_code'] 	= isset($data['_comm_code']) ? $data['_comm_code'] : $this->createCode();        		
		
		return parent::insert($data);		
    }
	/**
	 * get job by job _comm Id
 	 * @param string job id
     * @return object
	 */
	public function viewComm($code) {
		$select = $this->_db->select()	
			->from(array('_comm' => '_comm'))				
			->where('_comm_code = ?', $code)					
			->limit(1);
       
	    $result = $this->_db->fetchRow($select);
        return ($result == false) ? false : $result = $result;
	}
	/**
	 * get job by job _comm Id
 	 * @param string job id
     * @return object
	 */
	public function getByCode($code) {		
		$select = $this->_db->select()	
			->from(array('_comm' => '_comm'))						
			->where('_comm_code = ?', $code)					
			->limit(1);
       
		$result = $this->_db->fetchRow($select);
        return ($result == false) ? false : $result = $result;
	}

	/**
	 * get job by job _comm Id
 	 * @param string job id
     * @return object
	 */
	public function getByRecipient($type, $code)
	{		
		$select = $this->_db->select()	
			->from(array('_comm' => '_comm'))						
			->where('_comm_recipient_type = ?', $type)
			->where('_comm_recipient_code = ?', $code);

		$result = $this->_db->fetchAll($select);
        return ($result == false) ? false : $result = $result;
	}
	
	public function sendEmail($recepient, $template, $receiver = array()) {

		if(count($receiver) == 0) {
			$receiver[] = array('name' => $recepient['recipient_name'], 'email' => $recepient['recipient_email']);
		}

		global $smarty;
 
		require_once('Zend/Mail.php');

		$mail = new Zend_Mail();

		$data				= array();
		$data['_comm_code']	= $this->createCode();

		$file = $this->_path.$template['template_file'];

		$html = file_get_contents($file);
		/* Participant. */
		if(isset($recepient['recipient_name'])) $html = str_replace('[fullname]', $recepient['recipient_name'], $html);
		if(isset($recepient['recipient_name'])) $html = str_replace('[name]', $recepient['recipient_name'], $html);
		if(isset($recepient['recipient_surname'])) $html = str_replace('[surname]', $recepient['recipient_surname'], $html);
		if(isset($recepient['recipient_cellphone'])) $html = str_replace('[cellphone]', $recepient['recipient_cellphone'], $html);
		if(isset($recepient['recipient_reference'])) $html = str_replace('[reference]', $recepient['recipient_reference'], $html);
		if(isset($recepient['recipient_hashcode'])) $html = str_replace('[hashcode]', $recepient['recipient_hashcode'], $html);
		if(isset($recepient['recipient_email'])) $html = str_replace('[email]', $recepient['recipient_email'], $html);
		if(isset($recepient['recipient_password'])) $html = str_replace('[password]', $recepient['recipient_password'], $html);
		if(isset($recepient['recipient_message'])) $html = str_replace('[message]', $recepient['recipient_message'], $html);
		if(isset($recepient['recipient_title'])) $html = str_replace('[title]', $recepient['recipient_title'], $html);
		/* Enquiry. */
		if(isset($recepient['enquiry_name'])) $html = str_replace('[enquiry_name]', $recepient['enquiry_name'], $html);
		if(isset($recepient['enquiry_email'])) $html = str_replace('[enquiry_email]', $recepient['enquiry_email'], $html);
		if(isset($recepient['enquiry_number'])) $html = str_replace('[enquiry_number]', $recepient['enquiry_number'], $html);
		/* Subject: Participant */
		if(isset($recepient['recipient_name'])) $template['template_subject'] = str_replace('[name]', $recepient['recipient_name'], $template['template_subject']);
		if(isset($recepient['recipient_surname'])) $template['template_subject'] = str_replace('[surname]', $recepient['recipient_surname'], $template['template_subject']);
		if(isset($recepient['recipient_cellphone'])) $template['template_subject'] = str_replace('[cellphone]', $recepient['recipient_cellphone'], $template['template_subject']);
		if(isset($recepient['recipient_reference'])) $template['template_subject'] = str_replace('[reference]', $recepient['recipient_reference'], $template['template_subject']);
		if(isset($recepient['recipient_hashcode'])) $template['template_subject'] = str_replace('[hashcode]', $recepient['recipient_hashcode'], $template['template_subject']);
		if(isset($recepient['recipient_email'])) $template['template_subject'] = str_replace('[email]', $recepient['recipient_email'], $template['template_subject']);
		if(isset($recepient['recipient_password'])) $template['template_subject'] = str_replace('[password]', $recepient['recipient_password'], $template['template_subject']);
		if(isset($recepient['recipient_message'])) $template['template_subject'] = str_replace('[message]', $recepient['recipient_message'], $template['template_subject']);
		if(isset($recepient['recipient_subject'])) $template['template_subject'] = str_replace('[subject]', $recepient['recipient_subject'], $template['template_subject']);
		/* Subject: Enquiry */
		if(isset($recepient['enquiry_name'])) $template['template_subject'] = str_replace('[enquiry_name]', $recepient['enquiry_name'], $template['template_subject']);
		if(isset($recepient['enquiry_email'])) $template['template_subject'] = str_replace('[enquiry_email]', $recepient['enquiry_email'], $template['template_subject']);
		if(isset($recepient['enquiry_number'])) $template['template_subject'] = str_replace('[enquiry_number]', $recepient['enquiry_number'], $template['template_subject']);
		/* Other details. */
		$html = str_replace('[tracking]', $data['_comm_code'], $html);		
		$html = str_replace('[date]', date("F j, Y, g:i a"), $html);
		$html = str_replace('[browser]', '<a style="text-decoration: none;color: black;" href="'.$this->_site.'/mailer/view/'.$data['_comm_code'].'">View mail on browser</a>', $html);
		$html = str_replace('[unsubscribe]', '<a style="text-decoration: none;" href="'.$this->_site.'/mailer/unsubscribe/'.$data['_comm_code'].'">Click to unsubscribe</a>', $html);
		$html = str_replace('[track]', '<img src="'.$this->_site.'/mailer/tracking/'.$data['_comm_code'].'" width="0" height="0" border="0"  />', $html);
		$html = str_replace('[host]', $this->_site, $html);	
		/* From details. */
		$mail->setFrom('info@designerbase.co.za', 'DesignerBase'); //EDIT!!			
		/* Get all the recepients to the email class. */
		for($i = 0; $i < count($receiver); $i++) {
			$mail->addTo($receiver[$i]['email'], $receiver[$i]['name']);
		}
		/* Add the email body and subject. */
		$mail->setSubject($template['template_subject']);
		$mail->setBodyHtml($html);
		/* Save data to the comms table. */
		$data['_comm_sent']			= null;
		$data['_comm_type']			= 'EMAIL';		
		$data['_comm_name']			= $recepient['recipient_name'];
		$data['_comm_item_type']	= $recepient['recipient_type'];
		$data['_comm_item_code']	= $recepient['recipient_code'];
		$data['_comm_sent']			= null;
		$data['_comm_email']		= $recepient['recipient_email'];
		$data['_comm_html']			= $html;
		$data['_comm_subject']		= $template['template_subject'];
		$data['template_code']		= $template['template_code'];
		/* Send the email. */
		try {		
			$mail->send();
			$data['_comm_sent']		= 1;	
			$data['_comm_output']	= 'Email Sent!';
		} catch (Exception $e) {
			$data['_comm_sent']		= 0;	
			$data['_comm_output']	= $e->getMessage();
		}
		/* Insert the record. */
		$success = $this->insert($data);
		/* Return the data. */
		$mail = null; unset($mail);
		$return = $data['_comm_sent'] == 1 ? $data['_comm_code'] : false;
		return $return;
	}
	
	public function sendSMS($recepient, $template) {

		$user 		= urlencode('willowvine'); //"willowvine"; 
		$password = urlencode('DUJbgGdNRXROaA'); //"DUJbgGdNRXROaA"; 
		$api_id 		= urlencode('3420082'); //"3420082"; 
		$baseurl 	= "https://api.clickatell.com"; 
		
		$text = $template['template_message']; 
		$text = str_replace('[fullname]', trim($recepient['recipient_name'].' '.$recepient['recipient_surname']), $text);
		$text = str_replace('[name]', $recepient['recipient_name'], $text);
		$text = str_replace('[surname]', $recepient['recipient_surname'], $text);
		$text = str_replace('[cellphone]', $recepient['recipient_cellphone'], $text);
		$text = str_replace('[email]', $recepient['recipient_email'], $text);
		$text = str_replace('[password]', $recepient['recipient_password'], $text);

		$to 	= trim($recepient['recipient_cellphone']);

		$data										= array();
		$data['_comm_sent']					= null;
		$data['_comm_type']					= 'SMS';		
		$data['_comm_name']				= $recepient['recipient_name'];
		$data['_comm_recipient_type']	= $recepient['recipient_type'];
		$data['_comm_recipient_code']	= $recepient['recipient_code'];
		$data['_comm_number']				= $recepient['recipient_cellphone'];
		$data['_comm_message']			= $text;
		$data['_comm_subject']				= $template['template_subject'];
		$data['template_code']				= $template['template_code'];
		
		$text = urlencode($text); 
		
		if( preg_match( "/^0[0-9]{9}$/", $to)) {
			
			$url = "$baseurl/http/auth?user=$user&password=$password&api_id=$api_id"; 

			// do auth call 
			$ret = file($url); 

			// split our response. return string is on first line of the data returned 

			$sess = explode(":",$ret[0]); 
			
			if ($sess[0] == "OK") {
			
				$sess_id = trim($sess[1]); // remove any whitespace 
				
				$url = "$baseurl/http/sendmsg?session_id=$sess_id&to=$to&text=$text"; 
				
				// do sendmsg call 
				$ret = file($url); 
				
				$send = explode(":",$ret[0]); 
				
				if ($send[0] == "ID") { 																						
					$data['_comm_output']	= 'Success! : '.$send[0].' : '.$send[1];
					$data['_comm_sent']		= 1;					
				} else  {
					$data['_comm_output']	= 'Send message failed : '.$send[0].' : '.$send[1];
					$data['_comm_sent']		= 0;	  
				}
			} else { 
				$data['_comm_output']	= "Authentication failure: ". $ret[0]; 
				$data['_comm_sent']		= 0;	  
			} 
		} else {
			$data['_comm_output']	=  "Invalid number ".$participant['participant_number'];	
			$data['_comm_sent']		= 0;		  
		}
		
		$this->insert($data);
		
		return $data['_comm_sent'];
	}
	
	/**
	 * get domain by domain Account Id
 	 * @param string domain id
     * @return object
	 */
	public function getCode($reference)
	{
		$select = $this->_db->select()	
			->from(array('_comm' => '_comm'))		
			->where('_comm_code = ?', $reference)
			->limit(1);

	   $result = $this->_db->fetchRow($select);
        return ($result == false) ? false : $result = $result;				   		
	}

	function createCode() {
		/* New reference. */
		$reference = "";
		$codeAlphabet = "123456789";

		$count = strlen($codeAlphabet) - 1;
		
		for($i=0;$i<10;$i++) {
			$reference .= $codeAlphabet[rand(0,$count)];
		}
		
		$reference = md5($reference.date('Y-m-d H:i:s'));
		
		/* First check if it exists or not. */
		$itemCheck = $this->getCode($reference);
		
		if($itemCheck) {
			/* It exists. check again. */
			$this->createCode();
		} else {
			return $reference;
		}
	}

	function reference() {
		return date('Y-m-d-H:i:s');
	}	
}
?>