<?php
ini_set('max_execution_time', 1200); //300 seconds = 5 minutes
/* Add this on all pages on top. */
set_include_path($_SERVER['DOCUMENT_ROOT'].'/'.PATH_SEPARATOR.$_SERVER['DOCUMENT_ROOT'].'/library/classes/');

/**
 * Standard includes
 */
require_once 'config/database.php';
require_once 'config/smarty.php';
/** Check for login */
require_once 'includes/auth.php';

require_once 'class/checkoutitem.php';
require_once 'class/brand.php';
require_once 'class/areapostregion.php';
require_once 'class/checkoutstage.php';
require_once 'class/link.php';
require_once 'class/_comm.php';

$checkoutitemObject     = new class_checkoutitem(); 
$brandObject		    = new class_brand(); 
$areapostregionObject	= new class_areapostregion(); 
$checkoutstageObject	= new class_checkoutstage(); 
$linkObject	            = new class_link(); 
$commObject	            = new class_comm(); 

/* Setup Pagination. */
if(isset($_GET['action']) && trim($_GET['action']) == 'search') {

	$filter	= array();
	$csv	= 0;
	$start 	= isset($_REQUEST['iDisplayStart']) ? $_REQUEST['iDisplayStart'] : 0;
	$length	= isset($_REQUEST['iDisplayLength']) ? $_REQUEST['iDisplayLength'] : 100;
	
	$status         = array(0 => 'Not Done', 1 => 'Approved', 2 => 'Declined', 3 => 'Cancelled', 4 => 'User Cancelled');
	$statuscolour   = array(0 => '#3D3D3D', 1 => '#08AD37', 2 => '#F7160F', 3 => '#E6AD08', 4 => '#084CE6');
	
	if(isset($_REQUEST['filter_search']) && trim($_REQUEST['filter_search']) != '') $filter[] = array('filter_search' => trim($_REQUEST['filter_search']));
	if(isset($_REQUEST['filter_areapostregion']) && trim($_REQUEST['filter_areapostregion']) != '') $filter[] = array('filter_areapostregion' => trim($_REQUEST['filter_areapostregion']));	
	if(isset($_REQUEST['filter_brand']) && trim($_REQUEST['filter_brand']) != '') $filter[] = array('filter_brand' => trim($_REQUEST['filter_brand']));
	if(isset($_REQUEST['filter_status']) && trim($_REQUEST['filter_status']) != '') $filter[] = array('filter_status' => trim($_REQUEST['filter_status']));
	if(isset($_REQUEST['filter_stage']) && trim($_REQUEST['filter_stage']) != '') $filter[] = array('filter_stage' => trim($_REQUEST['filter_stage']));
	if(isset($_REQUEST['filter_csv']) && trim($_REQUEST['filter_csv']) != '') { $filter[] = array('filter_csv' => (int)trim($_REQUEST['filter_csv'])); $csv = (int)trim($_REQUEST['filter_csv']); }

	$checkoutitemData = $checkoutitemObject->paginate($start, $length, $filter);

	if(!$csv) {

        $checkout = array();

		if($checkoutitemData) {
			for($i = 0; $i < count($checkoutitemData['records']); $i++) {
				$item = $checkoutitemData['records'][$i];

				$checkout[$i] = array(
				    '<span style="color: '.$statuscolour[$item['checkout_status_code']].'; font-weight: bold;">'.$status[$item['checkout_status_code']].'</span>',
					'<img src="'.$zfsession->config['site'].$item['media_path'].'tny_'.$item['media_code'].$item['media_ext'].'" width="90px" />',
					'R '.number_format($item['checkoutitem_amount'],2,",",".").'<br /><br /><b>Sizes:</b><br />Size: '.($item['feature_size'] != '' ? $item['feature_size'] : 'N/A').'<br />Bust: '.($item['feature_size_bust'] != '' ? $item['feature_size_bust'] : 'N/A').'<br />Waist: '.($item['feature_size_waist'] != '' ? $item['feature_size_waist'] : 'N/A').'<br />Hips: '.($item['feature_size_hips'] != '' ? $item['feature_size_hips'] : 'N/A'),
					'#'.$item['checkout_code'],
					'<b>Name:</b><br />'.$item['brand_name'].'<br /><b>Email:</b><br />'.$item['brand_email'].'<br /><b>Cellphone Number:</b><br />'.$item['brand_number'],
					date('Y-m-d', strtotime('+'.$item['checkoutitem_delivery'].' week', strtotime($item['checkout_added']))),
					'<b>Name:</b><br />'.$item['participant_name'].'<br /><b>Email:</b><br />'.$item['checkout_email'].'<br /><b>Cellphone Number:</b><br />'.$item['participant_number'],
					'<b>Address:</b><br />'.$item['checkout_address'].'<br /><b>Location and Province</b><br />'.$item['areapost_name'],
					$item['checkoutitem_note'],
					'<span style="color: '.$item['checkoutstage_color'].'; font-weight: bold;">'.$item['checkoutstage_name'].'</span>',
					'<span style="color: '.$item['checkoutstage_color'].'; font-weight: bold;">'.$item['link_text'].'</span>',
					'<button value="Delete"onclick="stageModal(\''.$item['checkoutitem_code'].'\'); return false;">Update Stage</button>'
				);
			}
		}

		if($checkoutitemData) {
			$response['sEcho']					= $_REQUEST['sEcho'];
			$response['iTotalRecords']			= $checkoutitemData['displayrecords'];		
			$response['iTotalDisplayRecords']	= $checkoutitemData['count'];
			$response['aaData']					= $checkout;
		} else {
			$response['result']		= false;
			$response['message']	= 'There are no items to show.';			
		}

		echo json_encode($response);
		die();
	} else {

		$row = "Name, Email, Cellphone\r\n";
		if($checkoutData) {
			for($i = 0; $i < count($checkoutData); $i++) {
				$item = $checkoutData[$i];
				$Checkout[$i] = array(						
					str_replace(',', ' ',$item['checkout_name']),
					str_replace(',', ' ',$item['checkout_email']),
					str_replace(',', ' ',$item['checkout_cellphone'])
				);
			}

			foreach ($Checkout as $data) {
				$row .= implode(', ', $data)."\r\n";
			}			
		}

		header("Content-Type: text/csv");
		header("Content-Disposition: attachment; filename=checkout_report_".date('Y-m-d').".csv");
		Header("Cache-Control: private, must-revalidate" ); // HTTP/1.1
		Header("Pragma: private" ); // HTTP/1.0
	   
		print($row);
		exit;		
	}
}

if(isset($_REQUEST['modal_stage_submit']) && (int)trim($_REQUEST['modal_stage_submit']) == 1) {
    
    $result = array('result' => 1, 'message' => '');
    
    if(!isset($_GET['modal_stage_code'])) {
       $result = array('result' => 0, 'message' => 'Please select a stage');  
    } else if((int)trim($_GET['modal_stage_code']) == 0) {
       $result = array('result' => 0, 'message' => 'Please select a stage');   
    }
    
    if(!isset($_GET['modal_stage_notes'])) {
       $result = array('result' => 0, 'message' => 'Please add notes');  
    } else if(trim($_GET['modal_stage_notes']) == '') {
       $result = array('result' => 0, 'message' => 'Please add notes');   
    }
    
    if(!isset($_GET['checkoutitemcode'])) {
       $result = array('result' => 0, 'message' => 'Please select an item');  
    } else if(trim($_GET['checkoutitemcode']) == '') {
       $result = array('result' => 0, 'message' => 'Please select an item');
    }    
    
    if(!isset($_GET['modal_mail_customer'])) {
       $result = array('result' => 0, 'message' => 'Please tell us if you want to send an email to the customer');  
    } else if((int)trim($_GET['modal_mail_customer']) == 1) {
        if(!isset($_GET['modal_mail_customer_message'])) {
           $result = array('result' => 0, 'message' => 'Please add a message to the customer');  
        } else if(trim($_GET['modal_mail_customer_message']) == '') {
           $result = array('result' => 0, 'message' => 'Please add a message to the customer');  
        }  
    }
    
    if(!isset($_GET['modal_mail_customer'])) {
       $result = array('result' => 0, 'message' => 'Please tell us if you want to send an email to the customer');  
    } else if((int)trim($_GET['modal_mail_customer']) == 1) {
        if(!isset($_GET['modal_mail_customer_message'])) {
           $result = array('result' => 0, 'message' => 'Please add a message to the customer');  
        } else if(trim($_GET['modal_mail_customer_message']) == '') {
           $result = array('result' => 0, 'message' => 'Please add a message to the customer');  
        }  
    }
    
    if($result['result'] == 1) {
        /* Update the previous ones by simply making them not active. */
        $data                   = array();
        $data['link_active']    = 0;
        /* get the update. */
        $where      = array();
		$where[]    = $linkObject->getAdapter()->quoteInto('link_parent_type = ?', 'CHECKOUTITEM');
		$where[]    = $linkObject->getAdapter()->quoteInto('link_parent_code = ?', trim($_GET['checkoutitemcode']));
		$where[]    = $linkObject->getAdapter()->quoteInto('link_child_type = ?', 'CHECKOUTSTAGE');
		$success    = $linkObject->update($data, $where);
		/* Check if all is good. */
		if($success) {
    		/* Now add a new one. */
            $link                       = array(); 
            $link['link_parent_type']   = 'CHECKOUTITEM';
            $link['link_parent_code']   = trim($_GET['checkoutitemcode']);
            $link['link_child_type']    = 'CHECKOUTSTAGE';
            $link['link_child_code']    = (int)trim($_GET['modal_stage_code']);
            $link['link_text']          = trim($_GET['modal_stage_notes']);
            $linksuccess                = $linkObject->insert($link);
            
            if(!$linksuccess) {
               $result = array('result' => 0, 'message' => 'Could not add the new stage'); 
            } else {
                /* Get the details. */
                $checkoutitemData = $checkoutitemObject->getByCode(trim($_GET['checkoutitemcode']));
                if($checkoutitemData) {
                    /* Get the template. */
                    $templateData = $commObject->_template->getTemplate('MESSAGE', 'ENQUIRY', 'EMAIL');
                    if($templateData) {
                        /* SEND CUSTOMER EMAIL. */
                        if((int)trim($_GET['modal_mail_customer']) == 1) {
        				/* Check if email template exists. */
        				    /* Build HTML for the item being talked about. */
        				    $html = '<b>Progress on item bought:</b><br /><br /><i>'.trim($_GET['modal_mail_customer_message']).'</i><br /><br /><b>Item purchased:</b><br /><br />
        				    <table width="100%" class="gridtable"><tr><th width="10%">Product</th><th>Delivery Time</th><th>Extra Info</th><th>Price</th><th width="5%">Quantity</th>
							<th>Total</th><tr><td valign="top">
							<img src="http://www.designerbase.co.za'.$checkoutitemData['media_path'].'tmb_'.$checkoutitemData['media_code'].$checkoutitemData['media_ext'].'" width="50" />
							</td><td valign="top">'.$checkoutitemData['brand_delivery_date'].'</td><td valign="top">'.$checkoutitemData['checkoutitem_note'].'</td><td valign="top">R '.$checkoutitemData['checkoutitem_amount'].'</td>
							<td valign="top">'.$checkoutitemData['checkoutitem_quantity'].'</td><td valign="top">R '.number_format($checkoutitemData['checkoutitem_amount_total'],2,",",".").'</td></tr>
							<tr><td valign="top" colspan="2">Catalog Item: </td><td valign="top" colspan="4">'.$checkoutitemData['catalog_name'].'</td></tr>';
							$html .= '<tr><th valign="top" colspan="6">Features</th></tr>';
							if((int)$checkoutitemData['feature_size'] != 0) $html .= '<tr><td valign="top" colspan="2">Size:</td><td valign="top" colspan="4">'.$checkoutitemData['feature_size'].'</td></tr>';
							if((int)$checkoutitemData['feature_size_bust'] != 0) $html .= '<tr><td valign="top" colspan="2">Size - Bust</td><td valign="top" colspan="4">'.$checkoutitemData['feature_size_bust'].'</td></tr>';
							if((int)$checkoutitemData['feature_size_hips'] != 0) $html .= '<tr><td valign="top" colspan="2">Size - Hips</td><td valign="top" colspan="4">'.$checkoutitemData['feature_size_hips'].'</td></tr>';
							if((int)$checkoutitemData['feature_size_waist'] != 0) $html .= '<tr><td valign="top" colspan="2">Size - Waist</td><td valign="top" colspan="4">'.$checkoutitemData['feature_size_waist'].'</td></tr>';
							$html .= '</table>';
        					/* Details to add on the email */
        					$recepient                          = array();
        					$recepient['recipient_name']		= $checkoutitemData['participant_name'];
        					$recepient['recipient_email']		= $checkoutitemData['participant_email'];
        					$recepient['recipient_cellphone']	= $checkoutitemData['participant_number'];
        					$recepient['recipient_type']		= 'PARTICIPANT_CHECKOUTITEMSTAGE_'.$checkoutitemData['checkoutstage_code'];
        					$recepient['recipient_code']		= $checkoutitemData['checkoutitem_code'];
        					$recepient['recipient_title']		= 'Item bought progress: '.$checkoutitemData['checkoutstage_name'];
        					$recepient['recipient_message']		= $html;
        					$recepient['recipient_subject']     = 'DesignerBase - Purchased Item Process: '.$checkoutitemData['checkoutstage_name'];
        					/* Email to send to people. */
        					$emails[] = array('name' => $checkoutitemData['participant_name'], 'email' => $checkoutitemData['participant_email']);
        					/* Send the email. */
        					$commObject->sendEmail($recepient, $templateData, $emails);
        				}
                        /* SEND BRAND EMAIL. */
                        if((int)trim($_GET['modal_mail_brand']) == 1) {
        				/* Check if email template exists. */
        				    /* Build HTML for the item being talked about. */
        				    $html = '<b>Progress on item bought:</b><br /><br /><i>'.trim($_GET['modal_mail_customer_message']).'</i><br /><br /><b>Item purchased:</b><br /><br />
        				    <table width="100%" class="gridtable"><tr><th width="10%">Product</th><th>Delivery Time</th><th>Extra Info</th><th>Price</th><th width="5%">Quantity</th>
							<th>Total</th><tr><td valign="top">
							<img src="https://www.designerbase.co.za'.$checkoutitemData['media_path'].'tmb_'.$checkoutitemData['media_code'].$checkoutitemData['media_ext'].'" width="50" />
							</td><td valign="top">'.$checkoutitemData['brand_delivery_date'].'</td><td valign="top">'.$checkoutitemData['checkoutitem_note'].'</td><td valign="top">R '.$checkoutitemData['checkoutitem_amount'].'</td>
							<td valign="top">'.$checkoutitemData['checkoutitem_quantity'].'</td><td valign="top">R '.number_format($checkoutitemData['checkoutitem_amount_total'],2,",",".").'</td></tr>
							<tr><td valign="top" colspan="2">Catalog Item: </td><td valign="top" colspan="4">'.$checkoutitemData['catalog_name'].'</td></tr>';
							$html .= '<tr><th valign="top" colspan="6">Features</th></tr>';
							if((int)$checkoutitemData['feature_size'] != 0) $html .= '<tr><td valign="top" colspan="2">Size:</td><td valign="top" colspan="4">'.$checkoutitemData['feature_size'].'</td></tr>';
							if((int)$checkoutitemData['feature_size_bust'] != 0) $html .= '<tr><td valign="top" colspan="2">Size - Bust</td><td valign="top" colspan="4">'.$checkoutitemData['feature_size_bust'].'</td></tr>';
							if((int)$checkoutitemData['feature_size_hips'] != 0) $html .= '<tr><td valign="top" colspan="2">Size - Hips</td><td valign="top" colspan="4">'.$checkoutitemData['feature_size_hips'].'</td></tr>';
							if((int)$checkoutitemData['feature_size_waist'] != 0) $html .= '<tr><td valign="top" colspan="2">Size - Waist</td><td valign="top" colspan="4">'.$checkoutitemData['feature_size_waist'].'</td></tr>';
							$html .= '</table>';
        					/* Details to add on the email */
        					$recepient                          = array();
        					$recepient['recipient_name']		= $checkoutitemData['brand_name'];
        					$recepient['recipient_email']		= $checkoutitemData['brand_email'];
        					$recepient['recipient_cellphone']	= $checkoutitemData['brand_number'];
        					$recepient['recipient_type']		= 'BRAND_CHECKOUTITEMSTAGE_'.$checkoutitemData['checkoutstage_code'];
        					$recepient['recipient_code']		= $checkoutitemData['checkoutitem_code'];
        					$recepient['recipient_title']		= 'Item bought progress: '.$checkoutitemData['checkoutstage_name'];
        					$recepient['recipient_message']		= $html;
        					$recepient['recipient_subject']     = 'DesignerBase - Purchased Item Process: '.$checkoutitemData['checkoutstage_name'];
        					/* Email to send to people. */
        					$emails[] = array('name' => $checkoutitemData['brand_name'], 'email' => $checkoutitemData['brand_email']);
        					/* Send the email. */
        					$commObject->sendEmail($recepient, $templateData, $emails);
        				}        				
    				}
                }
            }
		} else {
            $result = array('result' => 0, 'message' => 'Could not update the link table before adding new stage');
		}
    }
    echo json_encode($result);
    exit;
}

if(isset($_REQUEST['checkoutitem_stage']) && trim($_REQUEST['checkoutitem_stage']) != '') {
    
    $result = array('result' => 1, 'message' => '', 'data' => array());
    $code = trim($_REQUEST['checkoutitem_stage']);
    
    $checkouteitemData = $checkoutitemObject->getByCode($code);

    if(!$checkouteitemData) {
        $result = array('result' => 0, 'message' => 'Item was not found, please try again.', 'data' => array());
    } else {
        $checkouteitemData['brand_delivery'] = date('Y-m-d', strtotime('+'.$checkouteitemData['checkoutitem_delivery'].' week', strtotime($checkouteitemData['checkout_added'])));
		$checkouteitemData['checkoutstage_name'] = '<span style="color: '.$checkouteitemData['checkoutstage_color'].'; font-weight: bold;">'.$checkouteitemData['checkoutstage_name'].'</span>';
		$checkouteitemData['link_text'] = '<span style="color: '.$checkouteitemData['checkoutstage_color'].'; font-weight: bold;">'.$checkouteitemData['link_text'].'</span>';
					
        $result = array('result' => 1, 'message' => 'Item was found', 'data' => $checkouteitemData);
    }
    echo json_encode($result);
    exit;
}

$brandPairs = $brandObject->pairs();
if($brandPairs) $smarty->assign('brandPairs', $brandPairs);

$stagePairs = $checkoutstageObject->pairs();
if($stagePairs) $smarty->assign('stagePairs', $stagePairs);

$areapostregionPairs = $areapostregionObject->provincePairs();
if($areapostregionPairs) $smarty->assign('areapostregionPairs', $areapostregionPairs);

$smarty->assign('statusPairs', array(0 => 'Not Done', 1 => 'Approved', 2 => 'Declined', 3 => 'Cancelled', 4 => 'User Cancelled'));

$smarty->display('checkout/default.tpl');
?>