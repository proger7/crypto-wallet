<ol class="breadcrumb">
	<li><a href="./"><?php echo $settings['name']; ?> Administrator</a></li>
	<li class="active">Plugins</li>
</ol>

<div class="panel panel-default">
	<div class="panel-heading">
		Plugins
	</div>
	<div class="panel-body">
		<?php
		if(isset($_POST['btn_save'])) {
			if(isset($_POST['plugin_buy_bitcoins'])) { $plugin_buy_bitcoins = '1'; } else { $plugin_buy_bitcoins = '0'; }
			if(isset($_POST['plugin_sell_bitcoins'])) { $plugin_sell_bitcoins = '1'; } else { $plugin_sell_bitcoins = '0'; }
			if(isset($_POST['plugin_transfer_bitcoins'])) { $plugin_transfer_bitcoins = '1'; } else { $plugin_transfer_bitcoins = '0'; }
			if(isset($_POST['plugin_request_bitcoins'])) { $plugin_request_bitcoins = '1'; } else { $plugin_request_bitcoins = '0'; }
			$process_time_to_sell = protect($_POST['process_time_to_sell']);
			$process_time_to_buy = protect($_POST['process_time_to_buy']);
			if($plugin_buy_bitcoins == "1" && empty($process_time_to_buy)) { echo error("Please enter process time for buy Bitcoins."); }
			elseif($plugin_sell_bitcoins == "1" && empty($process_time_to_sell)) { echo error("Please enter process time for sell Bitcoins."); }
			elseif($plugin_buy_bitcoins == "1" && !is_numeric($process_time_to_buy)) { echo error("Please enter process time with numbers."); }
			elseif($plugin_sell_bitcoins == "1" && !is_numeric($process_time_to_sell)) { echo error("Please enter process time with numbers."); }
			else {
				$update = $db->query("UPDATE btc_settings SET process_time_to_buy='$process_time_to_buy',process_time_to_sell='$process_time_to_sell',plugin_buy_bitcoins='$plugin_buy_bitcoins',plugin_sell_bitcoins='$plugin_sell_bitcoins',plugin_transfer_bitcoins='$plugin_transfer_bitcoins',plugin_request_bitcoins='$plugin_request_bitcoins'");
				$settingsQuery = $db->query("SELECT * FROM btc_settings ORDER BY id DESC LIMIT 1");
				$settings = $settingsQuery->fetch_assoc();
				echo success("Your changes was saved successfully.");
			}
		}	
		?>
		<form action="" method="POST">
			<div class="checkbox">
				<label>
					<input type="checkbox" name="plugin_buy_bitcoins" value="yes" <?php if($settings['plugin_buy_bitcoins'] == "1") { echo 'checked'; }?>> Enable/disable Buy Bitcoins Plugin
				</label>
			</div>
			<div class="checkbox">
				<label>
					<input type="checkbox" name="plugin_sell_bitcoins" value="yes" <?php if($settings['plugin_sell_bitcoins'] == "1") { echo 'checked'; }?>> Enable/disable Sell Bitcoins Plugin
				</label>
			</div>
			<div class="checkbox">
				<label>
					<input type="checkbox" name="plugin_transfer_bitcoins" value="yes" <?php if($settings['plugin_transfer_bitcoins'] == "1") { echo 'checked'; }?>> Enable/disable Transfer Bitcoins Plugin
				</label>
			</div>
			<div class="checkbox">
				<label>
					<input type="checkbox" name="plugin_request_bitcoins" value="yes" <?php if($settings['plugin_request_bitcoins'] == "1") { echo 'checked'; }?>> Enable/disable Request Bitcoins Plugin
				</label>
			</div>
			<div class="form-group">
				<label>Process time in hours when client make request to buy Bitcoins</label>
				<input type="text" class="form-control" name="process_time_to_buy" value="<?php echo $settings['process_time_to_buy']; ?>">
			</div>
			<div class="form-group">
				<label>Process time in hours when client make request to sell Bitcoins</label>
				<input type="text" class="form-control" name="process_time_to_sell" value="<?php echo $settings['process_time_to_sell']; ?>">
			</div>
			<button type="submit" class="btn btn-primary" name="btn_save"><i class="fa fa-check"></i> Save changes</button>
		</form>
	</div>
</div>