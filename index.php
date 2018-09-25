<?php
ob_start();
session_start();
error_reporting(1);
if(file_exists("./install.php")) {
	header("Location: ./install.php");
} 
include("includes/config.php");
$db = new mysqli($CONF['host'], $CONF['user'], $CONF['pass'], $CONF['name']);
if ($db->connect_errno) {
    echo "Failed to connect to MySQL: (" . $db->connect_errno . ") " . $db->connect_error;
}
$db->set_charset("utf8");
$settingsQuery = $db->query("SELECT * FROM btc_settings ORDER BY id DESC LIMIT 1");
$settings = $settingsQuery->fetch_assoc();
include("includes/rpc_settings.php");
include("includes/functions.php");
//$settings['url'] = siteURL();
if(empty($rpc_host) or empty($rpc_port) or empty($rpc_user) or empty($rpc_pass)) {
	die("Please setup your Bitcoin RPC settings in <b>includes/rpc_settings.php</b>!");
}
$btcwallet = new Client($rpc_host, $rpc_port, $rpc_user, $rpc_pass);
include("includes/email_templates.php");
include(getLanguage($settings['url'],null,null));

if(checkSession()) {	
	$btcwaddresses = $btcwallet->getAddressList(idinfo($_SESSION['btc_uid'],"email"));
	$btcwlatesttransactions =  $btcwallet->getTransactionList(idinfo($_SESSION['btc_uid'],"email"));
	update_activity($_SESSION['btc_uid']);
} else {
	if($_COOKIE['bitcoinwallet_uid']) {
		$_SESSION['btc_uid'] = $_COOKIE['bitcoinwallet_uid'];
		$redirect = $settings['url']."account/wallet";
		header("Location: $redirect");
	}
}

if(checkSession()) {
	check_user_verify_status();
}

$a = protect($_GET['a']);
if($a == "sign-in") {
	include("sources/sign-in.php");
} elseif($a == "sign-up") { 
	include("sources/sign-up.php");
} elseif($a == "password") { 
	include("sources/password.php");
}  elseif($a == "email") { 
	include("sources/email.php");
} else {
	include("sources/header.php");
	switch($a) {
		case "account": include("sources/account.php"); break;
		case "buy-bitcoins": include("sources/buy-bitcoins.php"); break;
		case "deposit-money": include("sources/deposit-money.php"); break;
		case "sell-bitcoins": include("sources/sell-bitcoins.php"); break;
		case "transfer-bitcoins": include("sources/transfer-bitcoins.php"); break;
		case "request-bitcoins": include("sources/request-bitcoins.php"); break;
		case "contact-us": include("sources/contact-us.php"); break;
		case "page": include("sources/page.php"); break;
		case "faq": include("sources/faq.php"); break;
		case "logout": 
			unset($_SESSION['btc_uid']);
			unset($_COOKIE['bitcoinwallet_uid']);
			setcookie("bitcoinwallet_uid", "", time() - (86400 * 30), '/'); // 86400 = 1 day
			session_unset();
			session_destroy();
			header("Location: $settings[url]");
			break;
		default: include("sources/homepage.php");
	}
	include("sources/footer.php");
}
mysqli_close($db);
?>