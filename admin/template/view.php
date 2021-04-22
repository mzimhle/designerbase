<?php
/* Add this on all pages on top. */
set_include_path($_SERVER['DOCUMENT_ROOT'].'/'.PATH_SEPARATOR.$_SERVER['DOCUMENT_ROOT'].'/library/classes/');

/*** Standard includes */
require_once 'config/database.php';
require_once 'config/smarty.php';
/*** Check for login */
require_once 'includes/auth.php';
/* objects. */
require_once 'class/template.php';

$templateObject	= new class_template();

if (isset($_GET['code']) && trim($_GET['code']) != '') {
	
	$code = trim($_GET['code']);
	
	$templateData = $templateObject->getByCode($code);

	if(!$templateData) {
		header('Location: /template/');
		exit;		
	}
} else {
	header('Location: /template/');
	exit;		
}

$html = file_get_contents($zfsession->config['path'].$templateData['template_file']);

$html = str_replace('[fullname]', 'Mzimhle Mosiwe', $html);
$html = str_replace('[name]', 'Mzimhle', $html);
$html = str_replace('[surname]', 'Mosiwe', $html);
$html = str_replace('[cellphone]', '0735640764', $html);
$html = str_replace('[reference]', 'DKE84KDS', $html);
$html = str_replace('[hashcode]', 'ksdii48fs8e28438458fd8so3ldfg848fj', $html);
$html = str_replace('[email]', 'mzimhle.mosiwe@gmail.com', $html);
$html = str_replace('[password]', 'd4kdw8', $html);
$html = str_replace('[message]', 'This is a message, please write it somewhere...', $html);
$html = str_replace('[enquiry_name]', 'Mzimhle Mosiwe', $html);
$html = str_replace('[enquiry_email]', 'mzimhle.mosiwe@gmail.com', $html);
$html = str_replace('[enquiry_number]', '0735640764', $html);
$html = str_replace('[tracking]', '8472742o460894juf74fj723hf734fyf74', $html);		
$html = str_replace('[date]', date("F j, Y, g:i a"), $html);
$html = str_replace('[browser]', '<a style="text-decoration: none;color: black;" href="[host]/mailer/view/8472742o460894juf74fj723hf734fyf74">View mail on browser</a>', $html);
$html = str_replace('[unsubscribe]', '<a style="text-decoration: none;" href="[host]/mailer/unsubscribe/8472742o460894juf74fj723hf734fyf74">Click to unsubscribe</a>', $html);
$html = str_replace('[track]', '<img src="[host]/mailer/tracking/8472742o460894juf74fj723hf734fyf74" width="0" height="0" border="0"  />', $html);
$html = str_replace('[host]', $zfsession->config['site'], $html);	

echo $html;
exit;
?>