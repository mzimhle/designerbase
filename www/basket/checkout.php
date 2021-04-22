<?php
/* Add this on all pages on top. */
set_include_path($_SERVER['DOCUMENT_ROOT'].'/'.PATH_SEPARATOR.$_SERVER['DOCUMENT_ROOT'].'/library/classes/');

/*** Standard includes */
require_once 'config/database.php';
require_once 'config/smarty.php';
/* Get global sessions. */
require_once 'includes/auth.php';

/* Class files. */
require_once 'class/participant.php';
require_once 'class/checkout.php';
require_once 'class/checkoutitem.php';
/* Class objects. */
$participantObject  = new class_participant();
$checkoutObject     = new class_checkout();
$checkoutitemObject = new class_checkoutitem();
/* Check if there is a basket. */
if(count($zfsession->basket) == 0) {
	header('Location: /');
	exit;
}
/* Make sure the user is logged in. */
if(!isset($zfsession->identity) || trim($zfsession->identity) == '') {
	header('Location: /');
	exit;
} else {
    $zfsession->participant = $participantObject->getByCode(trim($zfsession->identity));
    
    if(!$zfsession->participant) {
    	header('Location: /');
    	exit;
    }
    /* Make sure the delivery amount has been added. */
    if(!isset($zfsession->checkoutdelivery)) {
    	header('Location: /');
    	exit;
    } else if((int)trim($zfsession->checkoutdelivery) == 0) {
    	header('Location: /');
    	exit;
    }
}

/* Checkout reference we will be working with. */
$checkout                   = array();
$checkout['checkout_code']	= $checkoutObject->createCode();
/* Build paygate data */
$paygate = array(
	'PAYGATE_ID'        => $checkoutObject->_paygateid,
	'REFERENCE'         => $checkoutObject->createReference(),
	'AMOUNT'            => $zfsession->basketgrandtotal*100,
	'CURRENCY'          => 'ZAR',
	'RETURN_URL'        => 'https://www.designerbase.co.za/basket/result.php?payref='.$checkout['checkout_code'].'&ref='.md5(date('YmdHis')),
	'TRANSACTION_DATE'  => date('Y-m-d H:i:s'),
	'LOCALE'            => 'en-za',
	'COUNTRY'           => 'ZAF',
	'EMAIL'             => $zfsession->participant['participant_email']
);

$paygateOptional = array(
	'PAY_METHOD'        => '',
	'PAY_METHOD_DETAIL'	=> '',
	'NOTIFY_URL'		=> '',
	'USER1'             => '',
	'USER2'             => '',
	'USER3'             => '',
	'VAULT'             => '',
	'VAULT_ID'          => ''
);

/* Merge the required and optional data. */
$paygate = array_merge($paygate, $paygateOptional);
/** Set the encryption key of your PayGate PayWeb3 configuration */
$checkoutObject->_payweb3->setEncryptionKey($checkoutObject->_paygatesecret);
/** Set the array of fields to be posted to PayGate */
$checkoutObject->_payweb3->setInitiateRequest($paygate);
/** Do the curl post to PayGate */
$returnData = $checkoutObject->_payweb3->doInitiate();
/* Incase there are errors. */
$errors = array();
/* Lets do this. */
if(!isset($checkoutObject->_payweb3->lastError)) {
    /* Check if the checksum and request id are valid. */
	$isValid = $checkoutObject->_payweb3->validateChecksum($checkoutObject->_payweb3->initiateResponse);
	if($isValid){   
	    /* Okey, add them to the paygate data to be posted. */
        foreach($checkoutObject->_payweb3->processRequest as $key => $value) {
            $paygate[$key] = $value;
        }
        /* Add data to the database before sending out. */
        $checkout['participant_code']           = $zfsession->identity;
        $checkout['areapost_code']              = $zfsession->participant['areapost_code'];
        $checkout['checkout_address']           = $zfsession->participant['participant_address'];
        $checkout['checkout_id']                = $paygate['PAYGATE_ID'];
        $checkout['checkout_reference']         = $paygate['REFERENCE'];
        $checkout['checkout_email']             = $paygate['EMAIL'];
        $checkout['checkout_encryptionkey']     = $checkoutObject->_paygatesecret;
        $checkout['checkout_request_id']        = $paygate['PAY_REQUEST_ID'];
        $checkout['checkout_checksum']          = $paygate['CHECKSUM'];
        $checkout['checkout_added']             = $paygate['TRANSACTION_DATE'];
        $checkout['checkout_amount']            = $paygate['AMOUNT'];
        $checkout['checkout_reference']         = $paygate['REFERENCE'];
        $checkout['checkout_amount_delivery']   = $zfsession->config['delivery_'.$zfsession->participant['areapostregion_id']];
        /* Save this bitch! */
        $success = $checkoutObject->insert($checkout);
        if($success) {
            /* Add checkitems. */
            foreach($zfsession->basket as $basket) {
                $checkoutitem                           = array();
                $checkoutitem['checkout_code']          = $success;
                $checkoutitem['price_code']             = $basket['price_code'];
                $checkoutitem['checkoutitem_quantity']  = $basket['basket_quantity'];
                $checkoutitem['checkoutitem_amount']    = $basket['basket_total'];
                $checkoutitem['checkoutitem_note']      = $basket['basket_text'];
                $checkoutitem['checkoutitem_delivery']  = $basket['brand_delivery'];
                
                /* Save this bitch. */
                $checkoutitemsuccess = $checkoutitemObject->insert($checkoutitem);

                if(!$checkoutitemsuccess) {
                    $errors[] = 'We could not add one of the items, please retry or contact administrator with reference: '.$success;
                    break;
                }
            }
            /* Check if we cool. */
            if(count($errors) == 0) {
                /* Use javascript to redirect.*/
                echo 'Redirecting to PayGate online payment page... please wait...';
                echo '<form id="my_form" action="'.$checkoutObject->_process_url.'" method="post">';
                foreach($paygate as $key => $value) {
                    echo "<input type='hidden' name='$key' id=name='$key' value='".htmlspecialchars($value)."' />";
                }
                echo '</form>';
                echo "<script type='text/javascript'>function submitForm() { document.getElementById('my_form').submit(); } window.onload = submitForm;</script>";
                exit;
            }
        } else {
            $errors[] = 'Could not add details to the database, please contact administrator.';
        }        
	} else {
	    $errors[] = 'The checksum and request id are invalid, please try again or contact the administrator of the website.';
	}
} else {
    $errors[] = 'Error processing payment: '.$checkoutObject->_payweb3->lastError;
}

$smarty->assign('errors', implode('<br />', $errors));
$smarty->display('basket/checkout.tpl');
?>