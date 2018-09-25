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
include("../includes/rpc_settings.php");
include("../includes/functions.php");
//$settings['url'] = siteURL();
if(empty($rpc_host) or empty($rpc_port) or empty($rpc_user) or empty($rpc_pass)) {
	die("Please setup your Bitcoin RPC settings in <b>includes/rpc_settings.php</b>!");
}
$btcwallet = new Client($rpc_host, $rpc_port, $rpc_user, $rpc_pass);
include(getLanguage($settings['url'],null,2));
if(checkSession()) {
$type = protect($_GET['type']);
if($type == "receive") {

} elseif($type == "new_address") {
	$newaddress = $btcwallet->getNewAddress(idinfo($_SESSION['btc_uid'],"email"));
	echo 'You have new Bitcoin address.';
} elseif($type == "send_bitcoins") {
	$address = protect($_GET['from_address']);
	$to_address = protect($_POST['to_address']);
	$amount = protect($_POST['amount']);
	$secret_pin = protect($_POST['secret_pin']);
	$secret_pin = md5($secret_pin);
	$check = $db->query("SELECT * FROM btc_users_addresses WHERE uid='$_SESSION[btc_uid]' and address='$address'");
	if($check->num_rows==0) { 
		$data['status'] = 'error';
		$data['msg'] = error($lang['info_7']);
	} elseif(empty($address) or empty($to_address) or empty($amount)) { 
		$data['status'] = 'error';
		$data['msg'] = error($lang['error_1']); 
	} elseif(!is_numeric($amount)) {
		$data['status'] = 'error';
		$data['msg'] = error($lang['error_27']);
	} elseif(idinfo($_SESSION['btc_uid'],"secret_pin") && idinfo($_SESSION['btc_uid'],"secret_pin") !== $secret_pin) {
		$data['status'] = 'error';
		$data['msg'] = error($lang['error_29']);
	} else {
		$row = $check->fetch_assoc();
		$total = $row['available_balance'];
		$total = $total - 0.0008;
		$total = $total - $settings['withdrawal_comission'];
		if($total < 0) { $total = '0.0000'; }
		if($amount > $total) { 
			$data['status'] = 'error'; 
			$data['msg'] = error("Total available minus fees <b>$total</b> BTC."); 
		} else {
			$newamount = $row['available_balance']-$amount;
			$newamount = $newamount - 0.0008 - $settings['withdrawal_comission'];
			$license_query = $db->query("SELECT * FROM btc_blockio_licenses WHERE id='$row[lid]' ORDER BY id");
			$license = $license_query->fetch_assoc();
			$apiKey = $license['license'];
			$pin = $license['secret_pin'];
			$version = 2; // the API version
			$block_io = new BlockIo($apiKey, $pin, $version);
			$withdrawal = $block_io->withdraw_from_addresses(array('amounts' => $amount, 'from_addresses' => $address, 'to_addresses' => $to_address));
			$withdrawal = $block_io->withdraw_from_addresses(array('amounts' => $settings[withdrawal_comission], 'from_addresses' => $address, 'to_addresses' => $license[address]));
			$data['status'] = 'success';		
			$success_10 = str_ireplace("{{amount}}",$amount,$lang['success_10']);
			$success_10 = str_ireplace("{{to_address}}",$to_address,$success_10);			
			$data['msg'] = success($success_10);
			$data['btc_total'] = $newamount;
		}
	}
	echo json_encode($data);
} elseif($type == "receive_to_address") {

} elseif($type == "archive_address") {
	$address_id = protect($_GET['address_id']);
	$query = $db->query("SELECT * FROM btc_users_addresses WHERE uid='$_SESSION[btc_uid]' and id='$address_id'");
	if($query->num_rows>0) {
		$row = $query->fetch_assoc();
		if($row['archived'] == "1") {
			$info_8 = str_ireplace("{{address}}",$row[address],$lang['info_8']);
			echo $info_8;
		} else {
			$update = $db->query("UPDATE btc_users_addresses SET archived='1' WHERE id='$row[id]'");
			$info_9 = str_ireplace("{{address}}",$row[address],$lang['info_9']);
			echo $info_9;
		}
	} else {
		echo $lang['info_7'];
	}
} elseif($type == "unarchive_address") {
	$address_id = protect($_GET['address_id']);
	$query = $db->query("SELECT * FROM btc_users_addresses WHERE uid='$_SESSION[btc_uid]' and id='$address_id'");
	if($query->num_rows>0) {
		$row = $query->fetch_assoc();
		if($row['archived'] == "0") {
			$info_10 = str_ireplace("{{address}}",$row[address],$lang['info_10']);
			echo $info_10;
		} else {
			$update = $db->query("UPDATE btc_users_addresses SET archived='0' WHERE id='$row[id]'");
			$info_11 = str_ireplace("{{address}}",$row[address],$lang['info_11']);
			echo $info_11;
		}
	} else {
		echo $lang['info_7'];
	}
} else { }
}
?>