
<h2><small><?php echo $lang['transfer_bitcoins']; ?></small></h2>
<h3><small><?php echo $lang['transfer_bitcoins_info']; ?></small></h3>
<br>
<?php
$txfee = $btcwallet->getinfo("paytxfee",$rpc_host,$rpc_port,$rpc_user,$rpc_pass);
if(isset($_POST['btc_transfer'])) {

	$to_address = protect($_POST['raddress']);
	$amount = protect($_POST['amount']);
	$secret_pin = protect($_POST['secret_pin']);
	$secret_pin = md5($secret_pin);
	$time = time();
	if(empty($to_address) or empty($amount)) { 
		$data['status'] = 'error';
		echo error($lang['error_1']); 
	} elseif(!is_numeric($amount)) {
		echo error($lang['error_27']);
	} elseif(idinfo($_SESSION['btc_uid'],"secret_pin") && idinfo($_SESSION['btc_uid'],"secret_pin") !== $secret_pin) {
		echo error($lang['error_29']);
	} else {
		$total = get_user_balance_btc($_SESSION['btc_uid']);
		$total = $total - (float)$txfee;
		$total = $total - (float)$settings['withdrawal_comission'];
		$total = number_format($total,8);
		if($total < 0) { $total = '0.0000'; }
		if($amount > $total) {
			echo error("$lang[error_30] <b>$total</b> BTC."); 
		} else {
			$sql = "INSERT INTO btc_transfers SET uid = '$_SESSION[btc_uid]', status = '0', recipient_address = '$to_address', btc_amount = '$amount', time = '$time'";
			$query = $db->query($sql);
			$success_10 = str_ireplace("{{amount}}",$amount,$lang['success_10']);
			$success_10 = str_ireplace("{{to_address}}",$to_address,$success_10);
			echo success($success_10);
		}
	}
}
?>
<form action="" method="POST">
	<div class="form-group">
		<label><?php echo $lang['recipient_address']; ?></label>
		<input type="text" class="form-control" name="raddress">
		<small><?php echo $lang['recipient_address_info']; ?></small>
	</div>
	<div class="form-group">
		<label><?php echo $lang['amount']; ?></label>
		<div class="input-group">
		  <input type="text" class="form-control" name="amount" placeholder="0.0000000">
		  <span class="input-group-addon" id="basic-addon2">BTC</span>
		</div>
	</div>
	<?php if(idinfo($_SESSION['btc_uid'],"secret_pin")) { ?>
	<div class="form-group">
		<label><?php echo $lang['your_secret_pin']; ?></label>
		<input type="password" class="form-control" name="secret_pin">
	</div>
	<?php } ?>
	<button type="submit" class="btn btn-primary" name="btc_transfer"><?php echo $lang['btn_18']; ?></button>
	<span class="pull-right" id="fee_text">Transaction fee: <?php echo $txfee+$settings['withdrawal_comission']; ?> BTC</span>
</form>