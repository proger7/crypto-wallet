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
	$gateway_id = protect($_GET['gateway_id']);
	$query = $db->query("SELECT * FROM btc_gateways WHERE id='$gateway_id' and status='1'");
	if($query->num_rows>0) {
		$row = $query->fetch_assoc();
		$currency = $row['currency'];
		if($settings['autoupdate_bitcoin_price'] == "1") {
			if($currency == "USD") {
				$btcprice = get_current_bitcoin_price();
				$calculate1 = ($btcprice * $settings['bitcoin_buy_fee']) / 100;
				$calculate2 = $btcprice - $calculate1;
				$btc_price = $calculate2;
			} else {
				$btcprice = get_current_bitcoin_price();
				$amm = currencyConvertor($btcprice,"USD",$currency);
				$btc_price = $amm;
				$calculate1 = ($btc_price * $settings['bitcoin_buy_fee']) / 100;
				$calculate2 = $btc_price - $calculate1;
				$btc_price = $calculate2;
			}
		} elseif($settings['autoupdate_bitcoin_price'] == "0") {
			if($currency == "USD") {
				$btcprice = $settings['bitcoin_fixed_price'];
				$btc_price = $btcprice;
			} else {
				$btcprice = $settings['bitcoin_fixed_price'];
				$amm = currencyConvertor($btcprice,"USD",$currency);
				$btc_price = $amm;
			}
		} else {
			$btc_price = 0;
		}
		$data['currency'] = $row['currency'];
		$data['btcprice'] = $btc_price;
		$lang_our_details = str_ireplace("{{name}}",$row[name],$lang['our_bank_details']);
		$lang_our_account = str_ireplace("{{name}}",$row[name],$lang['our_payment_account']);
		if($row['name'] == "Wire Transfer") {
			$fields = '<div class="panel panel-default">
				<div class="panel-body">
					<b>'.$lang_our_details.':</b><br/>
					'.$lang[bank_name].': <b>'.$row[a_field_1].'</b><br/>
					'.$lang[bank_address].': <b>'.$row[a_field_2].'</b><br/>
					'.$lang[bank_holder_name].': <b>'.$row[a_field_3].'</b><br/>
					'.$lang[bank_account_number].': <b>'.$row[a_field_4].'</b><br/>
					'.$lang[bank_swift].': <b>'.$row[a_field_5].'</b>
				</div>
			</div>';
		} elseif($row['name'] == "Western Union" or $row['name'] == "Moneygram") {
			$fields = '<div class="panel panel-default">
				<div class="panel-body">
					<b>'.$lang_our_details.':</b><br/>
					'.$lang[name].': <b>'.$row[a_field_1].'</b><br/>
					'.$lang[location].': <b>'.$row[a_field_2].'</b>
				</div>
			</div>';
		} else {
			$fields = '<div class="panel panel-default">
				<div class="panel-body">
					<b>'.$lang_our_account.': '.$row[a_field_1].'</b>
				</div>
			</div>';
		}
		$data['fields'] = $fields;
	} else {
		$data['currency'] = 'NaN';
		$data['fields'] = '';
	}
	echo json_encode($data);
}
?>