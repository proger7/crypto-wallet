<ol class="breadcrumb">
	<li><a href="./"><?php echo $settings['name']; ?> Administrator</a></li>
	<li class="active">Bitcoin Settings</li>
</ol>

<div class="panel panel-default">
	<div class="panel-heading">
		Bitcoin Settings
	</div>
	<div class="panel-body">
		<?php
		if(isset($_POST['btn_save'])) {
			if(isset($_POST['autoupdate_bitcoin_price'])) { $autoupdate_bitcoin_price = '1'; } else { $autoupdate_bitcoin_price = '0'; }
			$bitcoin_buy_fee = protect($_POST['bitcoin_buy_fee']);
			$bitcoin_sell_fee = protect($_POST['bitcoin_sell_fee']);
			$bitcoin_fixed_price = protect($_POST['bitcoin_fixed_price']);
			$btc_fee = protect($_POST['btc_fee']);
			$btc_fee = $btc_fee;
			if($autoupdate_bitcoin_price == "0" && empty($bitcoin_fixed_price)) { echo error("Please enter Bitcoin fixed price."); }
			elseif($autoupdate_bitcoin_price == "1" && !is_numeric($bitcoin_buy_fee)) { echo error("Please enter Bitcoin buy fee with numbers. Example: -3"); }
			elseif($autoupdate_bitcoin_price == "1" && !is_numeric($bitcoin_sell_fee)) { echo error("Please enter Bitcoin sell fee with numbers. Example: 3"); }
			else {
				if($btc_fee !== get_paytxfee()) {
					$setnewfee = $btcwallet->settxfee($btc_fee);
				}
				$update = $db->query("UPDATE btc_settings SET autoupdate_bitcoin_price='$autoupdate_bitcoin_price',bitcoin_buy_fee='$bitcoin_buy_fee',bitcoin_sell_fee='$bitcoin_sell_fee',bitcoin_fixed_price='$bitcoin_fixed_price'");
				$settingsQuery = $db->query("SELECT * FROM btc_settings ORDER BY id DESC LIMIT 1");
				$settings = $settingsQuery->fetch_assoc();
				echo success("Your changes was saved successfully.");
			}
		}	
		?>
		<form action="" method="POST">
			<div class="checkbox">
					<label>
					  <input type="checkbox" name="autoupdate_bitcoin_price" value="yes" <?php if($settings['autoupdate_bitcoin_price'] == "1") { echo 'checked'; }?>> Auto update Bitcoin price
					</label>
			</div>
			<div class="form-group">
				<label>Bitcoin Buy fee</label>
				<input type="text" class="form-control" name="bitcoin_buy_fee" value="<?php echo $settings['bitcoin_buy_fee']; ?>">
				<small>If autoupdate is turned on, enter fee percentage without <b>%</b>, for buy fee enter percentage with minus. For example: -3</small>
			</div>
			<div class="form-group">
				<label>Bitcoin Sell fee</label>
				<input type="text" class="form-control" name="bitcoin_sell_fee" value="<?php echo $settings['bitcoin_sell_fee']; ?>">
				<small>If autoupdate is turned on, enter fee percentage without <b>%</b>, for sell fee enter percentage without minus. For example: 3</small>
			</div>
			<div class="form-group">
				<label>Bitcoin Fixed Price</label>
				<input type="text" class="form-control" name="bitcoin_fixed_price" value="<?php echo $settings['bitcoin_fixed_price']; ?>">
				<small>If autoupdate is turned off, Enter your bitcoin price will be used for buy and sell. If autoupdae is turned on, leave empty.</small>
			</div>
			<div class="form-group">
				<label>Bitcoin Network Transaction Fee</labeL>
				<input type="text" class="form-control" name="btc_fee" value="<?php echo get_paytxfee(); ?>">
				<small>Enter the transaction fee which Bitcoin Node will charge clients for their transaction. The bitcoin fee should be tailored to the current cost of Bitcoin. This will be important factor for transaction confirmation. For example if Bitcoin price is 8000 USD, and client send 1 BTC, the fee must be 0.001 to confirm transaction from ~1 up to ~3 hours. The 0.0003 is best solution for transaction fee.</small>
			</div>
			<button type="submit" class="btn btn-primary" name="btn_save"><i class="fa fa-check"></i> Save changes</button>
		</form>
	</div>
</div>