<h2>
	<small><?php echo $lang['buy_bitcoins']; ?></small> 
	<span class="pull-right" style="font-size:22px;">
		<span class="label label-primary">
			<i class="fa fa-bitcoin"></i> <?php echo $lang['buy_bitcoin']; ?>: <?php echo btc_buy_price(); ?> / <?php echo $lang['sell_bitcoin']; ?>: <?php echo btc_sell_price(); ?>
		</span>
	</span>
</h2>
<h3><small><?php echo $lang['buy_bitcoins_info']; ?> <?php if($settings['process_time_to_buy'] == "1") { echo $lang['1_hour']; } else { echo $settings['process_time_to_buy']." $lang[hours]."; } ?></small></h3>
<br>
<?php
$total_money = get_user_money($_SESSION['btc_uid']);

if(isset($_POST['btc_buy'])) {
	$order_type = protect($_POST['order_type']);
	$payment_method = protect($_POST['payment_method']);
	$amount_send = protect($_POST['amount_send']);
	$amount_minus = $amount_send*(-1);
	$amount_receive = protect($_POST['amount_receive']);
	$time = time();
	
	if(!is_numeric($amount_send)) {
		echo error($lang['error_9']);
	} elseif($amount_send > $total_money) { 
		echo error("$lang[error_28] $total_money USD");
	} else if ($order_type == 'market') {
		$query = "INSERT btc_users_money (uid,transaction_type,status,amount,time) VALUES ('$_SESSION[btc_uid]','buy_btc','1','$amount_minus','$time')";
        $insert = $db->query($query);

        $current_btc_balance = get_user_balance_btc($_SESSION['btc_uid']);
        $new_btc_balance = $current_btc_balance + $amount_receive;

        $query = "UPDATE btc_users SET btc_balance = '$new_btc_balance' WHERE id = '$_SESSION[btc_uid]' LIMIT 1";
        $update = $db->query($query);

		$success_4 = str_ireplace("{{amount_receive}}",$amount_receive,$lang['success_4']);
		echo success($success_4);
	} else if ($order_type == 'limit' || $order_type == 'stop') {
		$target_price = ($order_type == 'limit') ? protect($_POST['limit_price']) : protect($_POST['stop_price']);

		$query = "INSERT btc_orders (uid,transaction_type,order_type,status,amount,target_price,time) VALUES ('$_SESSION[btc_uid]','buy_btc','$order_type','0','$amount_send','$target_price','$time')";
        $insert = $db->query($query);

		echo success($lang['success_19']);
	}
}
?>
<form action="" method="POST" enctype="multipart/form-data">
	<div class="form-group">
		<label><?php echo $lang['current_balance']; ?>: <?php echo $total_money; ?> USD</label>
	</div>
	<div class="form-group">
		<label><?php echo $lang['select_order_type']; ?></label>
		<select class="form-control" name="order_type" onchange="btc_show_order_type_fields(this.value);">
			<option value="market">Market</option>
			<option value="limit">Limit</option>
			<option value="stop">Stop</option>
		</select>
		<small><?php echo $lang['select_from_where_to_pay']; ?></small>
	</div>
	<div class="form-group">
		<label><?php echo $lang['amount']; ?></label>
		<div class="input-group">
		  <input type="text" class="form-control" name="amount_send" id="amount_send" onkeyup="calculate_to_btc(this.value);" onkeydown="calculate_to_btc(this.value);" placeholder="0.00">
		  <span class="input-group-addon" id="currency">USD</span>
		</div>
	</div>
	<div class="form-group" id="stop_price">
		<label><?php echo $lang['stop_price']; ?></label>
		<div class="input-group">
		  <input type="text" class="form-control" name="stop_price" onkeyup="calculate_to_btc2($('#amount_send').val(),this.value);" onkeydown="calculate_to_btc2($('#amount_send').val(),this.value);" placeholder="0.00">
		  <span class="input-group-addon" id="currency">USD</span>
		</div>
	</div>
	<div class="form-group" id="limit_price">
		<label><?php echo $lang['limit_price']; ?></label>
		<div class="input-group">
		  <input type="text" class="form-control" name="limit_price" onkeyup="calculate_to_btc2($('#amount_send').val(),this.value);" onkeydown="calculate_to_btc2($('#amount_send').val(),this.value);" placeholder="0.00">
		  <span class="input-group-addon" id="currency">USD</span>
		</div>
	</div>
	<div class="form-group">
		<label><?php echo $lang['will_receive']; ?></label>
		<div class="input-group">
		  <input type="text" class="form-control" id="amount_receive" disabled placeholder="0.0000000">
		  <span class="input-group-addon" id="basic-addon2">BTC</span>
		  <input type="hidden" name="amount_receive" id="amount_receive2">
		</div>
	</div>
	<input type="hidden" id="btc_price" value="<?php echo btc_buy_price(true); ?>">
	<button type="submit" class="btn btn-primary" name="btc_buy"><?php echo $lang['btn_11']; ?></button>
	<span class="pull-right" id="fee_text"></span>
</form>
