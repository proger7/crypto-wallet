<?php
error_reporting(0);
ob_start();
session_start(); 
if(file_exists("../install.php")) {
	header("Location: ../install.php");
} 
include("../includes/config.php");
$db = new mysqli($CONF['host'], $CONF['user'], $CONF['pass'], $CONF['name']);
if ($db->connect_errno) {
    echo "Failed to connect to MySQL: (" . $db->connect_errno . ") " . $db->connect_error;
}
$db->set_charset("utf8");
$settingsQuery = $db->query("SELECT * FROM btc_settings ORDER BY id DESC LIMIT 1");
$settings = $settingsQuery->fetch_assoc();
include("../includes/rpc_settings.php");
$btcwallet = new Client($rpc_host, $rpc_port, $rpc_user, $rpc_pass);
include("../includes/functions.php");

$a = protect($_GET['a']);

if(checkAdminSession()) {
	include("sources/admin/header.php");
	switch($a) {
		case "gateways": include("sources/admin/gateways.php"); break;
		case "transactions": include("sources/admin/transactions.php"); break;
		case "transfers": include("sources/admin/transfers.php"); break;
		case "money": include("sources/admin/money.php"); break;
		case "money_withdrawals": include("sources/admin/money_withdrawals.php"); break;
		case "api_keys": include("sources/admin/api_keys.php"); break;
		case "trades": include("sources/admin/trades.php"); break;
		case "users": include("sources/admin/users.php"); break;
		case "faq": include("sources/admin/faq.php"); break;
		case "pages": include("sources/admin/pages.php"); break;
		case "plugins": include("sources/admin/plugins.php"); break;
		case "bitcoin_settings": include("sources/admin/bitcoin_settings.php"); break;
		case "settings": include("sources/admin/settings.php"); break;
		case "logout": 
			unset($_SESSION['btc_admin_uid']);
			session_unset();
			session_destroy();
			header("Location: ./");
		break;
		default: include("sources/admin/dashboard.php"); 
	}
	include("sources/admin/footer.php");
} else { 
	include("sources/login.php");
}
mysqli_close($db);
?>