<?php
/* Add this on all pages on top. */
set_include_path($_SERVER['DOCUMENT_ROOT'].'/'.PATH_SEPARATOR.$_SERVER['DOCUMENT_ROOT'].'/library/classes/');

/*** Standard includes */
require_once 'config/database.php';
require_once 'config/smarty.php';
/* Get global sessions. */
require_once 'includes/auth.php';
/* Class files. */
require_once 'class/checkout.php';
require_once 'class/checkoutitem.php';
require_once 'class/link.php';
require_once 'class/_comm.php';
/* Class objects. */
$checkoutObject     = new class_checkout();
$checkoutitemObject = new class_checkoutitem();
$linkObject         = new class_link();
$commObject         = new class_comm(); 
/* In case there is an error. */
$errors = array();
/* Checkout reference code. */
if(!isset($_GET['payref'])) {
   header('Location: /404');
   exit;
} else if(trim($_GET['payref']) == '') {
   header('Location: /404');
   exit;
} else {
    /* Just random string to check if it went through the payment system. */
    if(!isset($_GET['ref'])) {
       $errors[] = 'Payment has not been made, please retry.';
    } else if(count($zfsession->basket) == 0) {
       header('Location: /404');
       exit;     
    } else if(trim($_GET['ref']) == '') {
        $errors[] = 'Payment has not been made, please retry.';
    } else {
        $checkoutData = $checkoutObject->getByCode(trim($_GET['payref']));
        
        if(!$checkoutData) {
            $errors[] = 'Illegal payemnt, please pay through the website';
        } else {
            /* Meaning of status. */
            $transactionstatus = array(
                0 => 'Not Done',
                1 => 'Approved',
                2 => 'Declined',
                3 => 'Cancelled',
                4 => 'User Cancelled'
            );
            /* Save the status returned. */
            $checkout = array();
            $checkout['checkout_status_code'] = trim($_POST['TRANSACTION_STATUS']);
            $checkout['checkout_status_text'] = $transactionstatus[trim($_POST['TRANSACTION_STATUS'])];
            
			$where      = $checkoutObject->getAdapter()->quoteInto('checkout_code = ?', $checkoutData['checkout_code']);
			$success    = $checkoutObject->update($checkout, $where);
            
            if($success) {
                /* All is well, lets do this! */
                $data = array(
                	'PAYGATE_ID'         => $checkoutData['checkout_id'],
                	'PAY_REQUEST_ID'     => $_POST['PAY_REQUEST_ID'],
                	'TRANSACTION_STATUS' => $_POST['TRANSACTION_STATUS'],
                	'REFERENCE'          => $checkoutData['checkout_reference'],
                	'CHECKSUM'           => $_POST['CHECKSUM']
                );
            	/** Set the encryption key of your PayGate PayWeb3 configuration */
            	$checkoutObject->_payweb3->setEncryptionKey($checkoutData['checkout_encryptionkey']);
            	/** Check that the checksum returned matches the checksum we generate */
            	$isValid = $checkoutObject->_payweb3->validateChecksum($data);  
            	/* Check checksum if its all good. */
            	if(!$isValid) {
            	    $errors[] = 'Checksum does not match, there is data that was changed coming back to this page. Please try again.';
            	} else {
            	    $smarty->assign('success', 1);
            	    /* Remove everything in the basket. */
            	    $zfsession->basket = $zfsession->baskettotal = $zfsession->basketgrandtotal = $zfsession->checkoutdelivery = null;
            	    unset($zfsession->basket, $zfsession->baskettotal, $zfsession->basketgrandtotal, $zfsession->checkoutdelivery);
            	    /* Lets save the first stage. */
            	    $checkoutitemData = $checkoutitemObject->getByCheckout($checkoutData['checkout_code']);

            	    if($checkoutitemData) {
            	        /* Add the first stage on the db. */
            	        foreach($checkoutitemData as $item) {
            	            $link                       = array(); 
            	            $link['link_parent_type']   = 'CHECKOUTITEM_1';
            	            $link['link_parent_code']   = $item['checkoutitem_code'];
            	            $link['link_child_type']    = 'CHECKOUTSTAGE';
            	            $link['link_child_code']    = 1;
            	            $linkObject->insert($link);
            	        }
                        /* Get the template. */
                        $templateData = $commObject->_template->getTemplate('MESSAGE', 'ENQUIRY', 'EMAIL');
                        /* Check if email template exists. */
                        if($templateData) {
        				    /* Build HTML for the item being talked about. */
        				    $html = '<p style="color: #558e0a;">Your online purchase was successful, your invoice number is REF#<b>'.$checkoutData['checkout_code'].'</b></p><p>Below are the items you bought.</p>
        				    <table width="100%" class="gridtable"><tr><th width="10%">Product</th><th>Brand</th><th>Delivery Time</th><th>Extra Info</th><th>Price</th><th width="5%">Quantity</th>
							<th>Total</th>';
							foreach($checkoutitemData as $item) {
    	                        $html .= '<tr><td valign="top"><img src="http://www.designerbase.co.za'.$item['media_path'].'tmb_'.$item['media_code'].$item['media_ext'].'" width="50" /></td>';
    	                        $html .= '<td valign="top"><a href="https://www.designerbase.co.za/'.$item['brand_url'].'" target="_blank">'.$item['brand_name'].'</a></td>';
    	                        $html .= '<td valign="top">'.$item['brand_delivery_date'].'</td><td valign="top">'.$item['checkoutitem_note'].'</td>';
    	                        $html .= '<td valign="top">R '.$item['checkoutitem_amount'].'</td><td valign="top">'.$item['checkoutitem_quantity'].'</td>';
    	                        $html .= '<td valign="top">R '.number_format($item['checkoutitem_amount_total'],2,",",".").'</td></tr>';
							}
							$html .= '<tr><th align="right" colspan="2">Delivery Address</th><td valign="top" colspan="5">'.$checkoutData['checkout_address'].'</td></tr>';
							$html .= '<tr><th align="right" colspan="2">Province</th><td valign="top" colspan="5">'.$checkoutData['demarcation_name'].'</td></tr>';
							$html .= '<tr><th align="right" colspan="2">Delivery Cost</th><td valign="top" colspan="5">R '.number_format($checkoutData['checkout_amount_delivery'],2,",",".").'</td></tr>';
							$html .= '<tr><th align="right" colspan="2">Item Cost Sub-Total</th><td valign="top" colspan="5">R '.number_format(($checkoutData['checkout_amount']/100),2,",",".").'</td></tr>';
							$html .= '<tr><th align="right" colspan="2">FINAL TOTAL</th><td valign="top" colspan="5">R '.number_format((($checkoutData['checkout_amount']/100)+$checkoutData['checkout_amount_delivery']),2,",",".").'</td></tr>';
							$html .= '</table>';
							$html .= '<br /><p>Thank you for supporting our local designers. DesignerBase appriciates it! Have an awesome day!<br />We will make sure that we communicate with you on each step or if there are any issues on the way.</p>';
        					/* Details to add on the email */
        					$recepient                          = array();
        					$recepient['recipient_name']		= $checkoutData['participant_name'];
        					$recepient['recipient_email']		= $checkoutData['checkout_email']; 
        					$recepient['recipient_cellphone']	= $checkoutData['participant_number'];
                            $recepient['recipient_code']		= $checkoutData['checkout_code'];
        					$recepient['recipient_type']		= 'CHECKOUT';
        					$recepient['recipient_code']		= $checkoutData['checkout_code'];
        					$recepient['recipient_title']		= "Successful Online Payment Confirmation";
        					$recepient['recipient_message']		= $html;
        					$recepient['recipient_subject']     = 'DesignerBase - Successful Online Payment - Invoice REF#'.$checkoutData['checkout_code'];
        					/* Email to send to people. */
        					$emails[] = array('name' => $checkoutData['participant_name'], 'email' => $checkoutData['checkout_email']);
        					/* Send the email. */
        					$commObject->sendEmail($recepient, $templateData, $emails);
        				}  
            	    }
            	}
            } else {
                $errors[] = 'We could not update the system, please contact the administrator.';
            }
            $smarty->assign('checkoutData', $checkoutData);
        }
    }  
}

$smarty->assign('errors', implode('<br />', $errors));
$smarty->display('basket/result.tpl');
?>