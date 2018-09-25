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
				$calculate1 = ($btcprice * $settings['bitcoin_sell_fee']) / 100;
				$calculate2 = $btcprice - $calculate1;
				$btc_price = $calculate2;
			} else {
				$btcprice = get_current_bitcoin_price();
				$amm = currencyConvertor($btcprice,"USD",$currency);
				$btc_price = $amm;
				$calculate1 = ($btc_price * $settings['bitcoin_sell_fee']) / 100;
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
		if($row['name'] == "Wire Transfer") {
			$data['fields'] = '<div class="form-group">
								<label>'.$lang[your_bank_name].' <span class="right">(for '.$row[name].' transfer)</span></label>
								<input type="text" class="form-control" name="u_field_1">
							</div>
							<div class="form-group">
								<label>'.$lang[your_bank_location].' <span class="right">(for '.$row[name].' transfer)</span></label>
								<input type="text" class="form-control" name="u_field_2">
							</div><div class="form-group">
								<label>'.$lang[your_holder_name].' <span class="right">(for '.$row[name].' transfer)</span></label>
								<input type="text" class="form-control" name="u_field_3">
							</div><div class="form-group">
								<label>'.$lang[your_account_number].'/IBAN <span class="right">(for '.$row[name].' transfer)</span></label>
								<input type="text" class="form-control" name="u_field_4">
							</div><div class="form-group">
								<label>'.$lang[your_swift].' <span class="right">(for '.$row[name].' transfer)</span></label>
								<input type="text" class="form-control" name="u_field_5">
							</div>';
		} elseif($row['name'] == "Credit Card") {
			$data['fields'] = '<div class="form-group">
								<label>'.$lang[name_on_card].' <span class="right">(for '.$row[name].' transfer)</span></label>
								<input type="text" class="form-control" name="u_field_1">
							</div>
							<div class="form-group">
								<label>'.$lang[card_number].' <span class="right">(for '.$row[name].' transfer)</span></label>
								<input type="text" class="form-control" name="u_field_2">
							</div><div class="form-group">
								<label>'.$lang[expire_date].' <span class="right">(for '.$row[name].' transfer)</span></label>
								<input type="text" class="form-control" name="u_field_3" placeholder="month/year">
							</div><div class="form-group">
								<label>'.$lang[cvv].' <span class="right">(for '.$row[name].' transfer)</span></label>
								<input type="text" class="form-control" name="u_field_4">
							</div>';
		} elseif($row['name'] == "Western Union" or $row['name'] == "Moneygram") {
			$data['fields'] = '<div class="form-group">
								<label>'.$lang[your_name].' <span class="right">(for '.$row[name].' transfer)</span></label>
								<input type="text" class="form-control" name="u_field_1">
							</div>
							<div class="form-group">
								<label>'.$lang[your_location].' <span class="right">(for '.$row[name].' transfer)</span></label>
								<input type="text" class="form-control" name="u_field_2">
							</div>';
		} else {
			$data['fields'] = '<div class="form-group">
								<label>'.$lang[your].' '.$row[name].' '.$lang[account].'</label>
								<input type="text" class="form-control" name="u_field_1">
							</div>';
		}
	} else {
		$data['currency'] = 'NaN';
		$data['fields'] = '';
	}
	echo json_encode($data);
}
?>