<?php
/* Add this on all pages on top. */
set_include_path($_SERVER['DOCUMENT_ROOT'].'/'.PATH_SEPARATOR.$_SERVER['DOCUMENT_ROOT'].'/library/classes/');

/* Setup Database Connection. */

require_once('Zend/Db.php');
require_once('Zend/Db/Table.php');

$parse		= parse_ini_file($_SERVER['DOCUMENT_ROOT']."config/settings.ini", true);

if(isset($parse[$_SERVER['HTTP_HOST']])) {
	$settings = $parse[$_SERVER['HTTP_HOST']];
} else {
	echo 'No settings file present...';
	exit;
}

try {
	$conn = Zend_Db::factory('Mysqli', array(
		'host'			=> $settings['dbhost'],
		'username' 	=> $settings['dbuser'],
		'password' 	=> $settings['dbpassword'],
		'dbname'   	=> $settings['dbname']
	));
	
	$conn->getConnection();
} catch (Zend_Db_Adapter_Exception $e) {
	/* perhaps a failed login credential, or perhaps the RDBMS is not running */
} catch (Zend_Exception $e) {
	/* perhaps factory() failed to load the specified Adapter class */
	echo 'Failed to connect to database.';
}

/* set the fetchmode to object (this enables you to choose fetchAssoc as well as object */
$conn->setFetchMode(Zend_Db::FETCH_ASSOC);

/* set $conn as the default adapter for all abstracted tables */
Zend_Db_Table_Abstract::setDefaultAdapter($conn);

?>