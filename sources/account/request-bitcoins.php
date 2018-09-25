
<h2><small><?php echo $lang['request_bitcoins']; ?></small></h2>
<h3><small><?php echo $lang['request_bitcoins_info']; ?></small></h3>
<br>
<?php
if(isset($_POST['btc_send_request'])) {
	$waddress = protect($_POST['waddress']);
	$email = protect($_POST['email']);
	$amount = protect($_POST['amount']);
	$note = protect($_POST['note']);
	
	if(empty($waddress)) { echo error($lang['error_12']); }
	elseif(empty($email)) { echo error($lang['error_13']); }
	elseif(!isValidEmail($email)) { echo error($lang['error_14']); }
	elseif(empty($amount)) { echo error($lang['error_15']); }
	elseif(!is_numeric($amount)) { echo error($lang['error_16']); }
	else {
		emailsys_request_bitcoins($waddress,idinfo($_SESSION[btc_uid],"email"),$email,$amount,$note);
		$success_5 = str_ireplace("{{email}}",$email,$lang['success_5']);
		echo success("$success_5");
	}
}
?>
<form action="" method="POST">
	<div class="form-group">
		<label><?php echo $lang['select_wallet_address']; ?></label>
		<select class="form-control" name="waddress">
			<?php
			foreach($btcwaddresses as $waddress) { 
																		$i=1;
					echo '<option value="'.$waddress.'">'.$waddress.'</option>';
				}
			?>
		</select>
		<small><?php echo $lang['address_to_receive']; ?></small>
	</div>
	<div class="form-group">
		<label><?php echo $lang['email']; ?></label>
		<input type="text" class="form-control" name="email">
		<small><?php echo $lang['requested_email_info']; ?></small>
	</div>
	<div class="form-group">
		<label><?php echo $lang['amount']; ?></label>
		<div class="input-group">
		  <input type="text" class="form-control" name="amount" placeholder="0.0000000">
		  <span class="input-group-addon" id="basic-addon2">BTC</span>
		</div>
	</div>
	<div class="form-group">
		<label><?php echo $lang['note']; ?></label>
		<textarea class="form-control" name="note" rows="2"></textarea>
		<small><?php echo $lang['note_info']; ?></small>
	</div>
	<button type="submit" class="btn btn-primary" name="btc_send_request"><?php echo $lang['btn_12']; ?></button>
</form>