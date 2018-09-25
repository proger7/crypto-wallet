<?php
ob_start();
session_start();
error_reporting(0);
include("../includes/config.php");
$db = new mysqli($CONF['host'], $CONF['user'], $CONF['pass'], $CONF['name']);
if ($db->connect_errno) {
    echo "Failed to connect to MySQL: (" . $db->connect_errno . ") " . $db->connect_error;
}
$db->set_charset("utf8");
$settingsQuery = $db->query("SELECT * FROM btc_settings ORDER BY id DESC LIMIT 1");
$settings = $settingsQuery->fetch_assoc();
include("../includes/block_io.php");
include("../includes/functions.php");
include(getLanguage($settings['url'],null,2));
if(checkSession()) {
	$address = protect($_GET['address']);
	$query = $db->query("SELECT * FROM btc_users_addresses WHERE uid='$_SESSION[btc_uid]' and address='$address'");
	if($query->num_rows>0) { 
	$row = $query->fetch_assoc(); 
	$total = $row['available_balance'];
	$total = $total - 0.0004;
	if($total < 0) { $total = '0.0000'; }
	echo $lang[error_30].': '.$total.' BTC';
	}
}
?>