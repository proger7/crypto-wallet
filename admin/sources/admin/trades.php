<?php
$id = protect($_GET['id']);
$b = protect($_GET['b']);

if($b == "explore") {
	$query = $db->query("SELECT * FROM btc_requests WHERE id='$id'");
	if($query->num_rows==0) { header("Location; ./?a=trades"); }
	$row = $query->fetch_assoc();
	$gateway = gatewayinfo($row['gateway_id'],"name");
	$currency = gatewayinfo($row['gateway_id'],"currency");
	$payment_method = $gateway.' '.$currency;
	?>
	<ol class="breadcrumb">
		<li><a href="./"><?php echo $settings['name']; ?> Administrator</a></li>
		<li><a href="./?a=pages">Buy & Sell Trades</a></li>
		<li class="active">Explore</li>
	</ol>

	<div class="panel panel-default">
		<div class="panel-heading">
			Explore
		</div>
		<div class="panel-body">
			<?php
			if($row['type'] == "1") {
			
			if(isset($_POST['btn_release_bitcoins_confirmed'])) {
				$admin_balance = 100000; //formatBTC(convertToBTCFromSatoshi(getAddressBalance($sell_address)));
				$to_address = idinfo($row['uid'],"email");
				$accaddress = $btcwallet->getAccountAddress($to_address);
				$from = $btcwallet->getaccountbyaddress($sell_address);
				$withdrawal = $btcwallet->adminwithdrawal($from,$accaddress,$row['btc_amount']); 
				echo success("You successfully deposit <b>$row[btc_amount] BTC</b> to account <b>$to_address</b>.");
				$update = $db->query("UPDATE btc_requests SET status='2' WHERE id='$row[id]'");
				$query = $db->query("SELECT * FROM btc_requests WHERE id='$id'");
				$row = $query->fetch_assoc();	
			
			}
			
			if(isset($_POST['btn_release_bitcoins'])) {
				$admin_balance = 100000; //formatBTC(convertToBTCFromSatoshi(getAddressBalance($sell_address)));
				if($row['btc_amount'] > $admin_balance) { 
					echo error("You do not have enough available Bitcoin. You can deposit at the following address: $sell_address");
				} else {
					?>
					<form action="" method="POST">
					<div class="alert alert-info">
						<h3><small>Are you sure you want to give <b><?php echo $row['btc_amount']; ?> BTC</b> to account <?php echo idinfo($row['uid'],"email"); ?></b>?</small></h3>
						<button type="submit" class="btn btn-success" name="btn_release_bitcoins_confirmed"><i class="fa fa-check"></i> Yes</button> 
						<a href="" class="btn btn-danger"><i class="fa fa-times"></i> No</a>
					</div>
					</form>
					<?php
				}
			}
			
			if(isset($_POST['btn_cancel_trade'])) {
				$status = protect($_POST['status']);
				$update = $db->query("UPDATE btc_requests SET status='3' WHERE id='$row[id]'");
				$query = $db->query("SELECT * FROM btc_requests WHERE id='$id'");
				$row = $query->fetch_assoc();	
				echo success("Trade request was canceled.");
			}
			?>
			<div class="row">
				<?php if($row['status'] == "1") { ?>
				<div class="col-md-12">
					<div class="pull-right">
						<form action="" method="POST">
							<button type="submit" class="btn btn-success" name="btn_release_bitcoins"><i class="fa fa-check"></i> Give Bitcoins</button>
							<button type="submit" class="btn btn-danger" name="btn_cancel_trade"><i class="fa fa-times"></i> Cancel trade</button>
						</form>
					</div>
				</div>
				<?php } ?>
				<div class="col-md-6">
					<table class="table table-striped">
						<thead>
							<tr>
								<td><h3><small>Trade info</small></h3></td>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td><b>Order ID:</b> <span class="pull-right"><?php echo $row['id']; ?></span></td>
							</tr>
							<tr>
								<td><b>Trade type:</b> <span class="pull-right">User buy Bitcoins from you</span></td>
							</tr>
							<tr>
								<td><b>Amount in Bitcoins</b> <span class="pull-right"><?php echo $row['btc_amount']; ?> BTC</span></td>
							</tr>
							<tr>
								<td><b>Payment method</b> <span class="pull-right"><?php echo $payment_method; ?></span></td>
							</tr>
							<tr>
								<td><b>Amount in <?php echo $payment_method; ?></b> <span class="pull-right"><?php echo $row['amount']; ?> <?php echo $currency; ?></span></td>
							</tr>
							<tr>
								<td><b>Status</b> <span class="pull-right">
								<?php
								if($row['status'] == "1") { 
									$status = '<span class="label label-info">Awaiting</span>';
								} elseif($row['status'] == "2") {
									$status = '<span class="label label-success">Processed</span>';
								} elseif($row['status'] == "3") {
									$status = '<span class="label label-danger">Canceled</span>';
								} else { $status = '<span class="label label-defualt">Unknown</span>'; }
								echo $status;
								?>
								</span></td>
						</tbody>
					</table>
				</div>
				<div class="col-md-6">
					<table class="table table-striped">
						<thead>
							<tr>
								<td><h3><small>User info</small></h3></td>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td><b>User</b> <span class="pull-right"><a href="./?a=users&b=edit&id=<?php echo $row['uid']; ?>"><?php echo idinfo($row['uid'],"email"); ?></a></span></td>
							</tr>
							<tr>
								<td><b>User wallet address:</b> <span class="pull-right"><?php echo addrinfo($row['from_address'],"address"); ?></span></td>
							</tr>
							<tr>
								<td><b>Document for payment:</b><br/>
								<a href="<?php echo $settings['url'].$row['attachment']; ?>" target="_blank">
								<img src="<?php echo $settings['url'].$row['attachment']; ?>" class="img-responsive">
								<small>Click to preview full size.</small>
								</a></td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			<?php
			} elseif($row['type'] == "2") {
			
			if(isset($_POST['btn_upload'])) {
				$ext = array('jpg','jpeg','pdf','png'); 
				$file_ext = end(explode('.',$_FILES['uploadFile']['name'])); 
				$file_ext = strtolower($file_ext); 
				if(!$_FILES['uploadFile']['name']) { echo error("Please select payment proof image or pdf file."); }
				elseif(!in_array($file_ext,$ext)) { echo error("Allowed file format is jpg,png and pdf."); }
				else {
					$path = 'uploads/attachments/'.$_SESSION[btc_admin_uid].'_'.time().'_attachment.'.$file_ext;
					$uploadpath = '../'.$path;
					@move_uploaded_file($_FILES['uploadFile']['tmp_name'], $uploadpath); 
					$update = $db->query("UPDATE btc_requests SET status='2',attachment='$path' WHERE id='$row[id]'");
						$query = $db->query("SELECT * FROM btc_requests WHERE id='$id'");
				$row = $query->fetch_assoc();	
					echo success("Trade completed!");
				}
			}
			
			if(isset($_POST['btn_payment_was_made'])) {
				?>
					<form action="" method="POST"  enctype="multipart/form-data">
					<div class="alert alert-info">
						<h3><small>Are you sure you made payment? Upload payment proof to mark payment as made.</small></h3>
						<div class="form-group">
							<label>Attach payment proof (allowed: jpg,png and pdf, max 5MB)</label>
							<input type="file" name="uploadFile" class="form-control">
						</div>
						<input type="hidden" id="btc_price" value="">
						<button type="submit" class="btn btn-primary" name="btn_upload">Upload</button>
					</div>
					</form>
					<?php
			}
			
			if(isset($_POST['btn_cancel_trade'])) {
				$status = protect($_POST['status']);
				$update = $db->query("UPDATE btc_requests SET status='3' WHERE id='$row[id]'");
				$query = $db->query("SELECT * FROM btc_requests WHERE id='$id'");
				$row = $query->fetch_assoc();	
				echo success("Trade request was canceled.");
			}
			?>
			<div class="row">
				<?php if($row['status'] == "1") { ?>
				<div class="col-md-12">
					<div class="pull-right">
						<form action="" method="POST">
							<button type="submit" class="btn btn-success" name="btn_payment_was_made"><i class="fa fa-check"></i> Payment was made.</button>
							<button type="submit" class="btn btn-danger" name="btn_cancel_trade"><i class="fa fa-times"></i> Cancel trade</button>
						</form>
					</div>
				</div>
				<?php } ?>
				<div class="col-md-6">
					<table class="table table-striped">
						<thead>
							<tr>
								<td><h3><small>Trade info</small></h3></td>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td><b>Order ID:</b> <span class="pull-right"><?php echo $row['id']; ?></span></td>
							</tr>
							<tr>
								<td><b>Trade type:</b> <span class="pull-right">User sell Bitcoins to you</span></td>
							</tr>
							<tr>
								<td><b>Amount in Bitcoins</b> <span class="pull-right"><?php echo $row['btc_amount']; ?> BTC</span></td>
							</tr>
							<tr>
								<td><b><span class="text text-success"><i class="fa fa-check"></i> Bitcoins are released to your address.</span></b></td>
							</tr>
							<tr>
								<td><b>Payment method</b> <span class="pull-right"><?php echo $payment_method; ?></span></td>
							</tr>
							<tr>
								<td><b>Amount in <?php echo $payment_method; ?></b> <span class="pull-right"><?php echo $row['amount']; ?> <?php echo $currency; ?></span></td>
							</tr>
							<tr>
								<td><b>Status</b> <span class="pull-right">
								<?php
								if($row['status'] == "1") { 
									$status = '<span class="label label-info">Awaiting</span>';
								} elseif($row['status'] == "2") {
									$status = '<span class="label label-success">Processed</span>';
								} elseif($row['status'] == "3") {
									$status = '<span class="label label-danger">Canceled</span>';
								} else { $status = '<span class="label label-defualt">Unknown</span>'; }
								echo $status;
								?>
								</span></td>
							</tr>
						</tbody>
					</table>
					<table class="table table-striped">
						<thead>
							<tr>
								<td><h3><small>Data for payment</small></h3></td>
							</tr>
						</thead>
						<tbody>
							<?php
							if($gateway == "Wire Transfer") {
							?>
							<tr>
								<td><b>Bank Name:</b> <span class="pull-right"><?php echo $row['u_field_1']; ?></span></td>
							</tr>
							<tr>
								<td><b>Bank Country,City,Address:</b> <span class="pull-right"><?php echo $row['u_field_2']; ?></span></td>
							</tr>
							<tr>
								<td><b>Bank Account Holder Name:</b> <span class="pull-right"><?php echo $row['u_field_3']; ?></span></td>
							</tr>
							<tr>
								<td><b>Bank Account Number/IBAN:</b> <span class="pull-right"><?php echo $row['u_field_4']; ?></span></td>
							</tr>
							<tr>
								<td><b>Bank Swift Code:</b> <span class="pull-right"><?php echo $row['u_field_5']; ?></span></td>
							</tr>
							<?php
							} elseif($gateway == "Western Union" or $gateway == "Moneygram") {
							?>
							<tr>
								<td><b>Name:</b> <span class="pull-right"><?php echo $row['u_field_1']; ?></span></td>
							</tr>
							<tr>
								<td><b>Location:</b> <span class="pull-right"><?php echo $row['u_field_2']; ?></span></td>
							</tr>
							<?php
							} elseif($gateway == "Credit Card") {
							?>
							<tr>
								<td><b>Name on Card:</b> <span class="pull-right"><?php echo $row['u_field_1']; ?></span></td>
							</tr>
							<tr>
								<td><b>Card Number:</b> <span class="pull-right"><?php echo $row['u_field_2']; ?></span></td>
							</tr>
							<tr>
								<td><b>Expire date:</b> <span class="pull-right"><?php echo $row['u_field_3']; ?></span></td>
							</tr>
							<tr>
								<td><b>CVV:</b> <span class="pull-right"><?php echo $row['u_field_4']; ?></span></td>
							</tr>
							<?php
							} else {
							?>
							<tr>
								<td><b><?php echo $gateway; ?> account:</b> <span class="pull-right"><?php echo $row['u_field_1']; ?></span></td>
							</tr>
							<?php
							}
							?>
						</tbody>
					</table>
					<br>
				</div>
				<div class="col-md-6">
					<table class="table table-striped">
						<thead>
							<tr>
								<td><h3><small>User info</small></h3></td>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td><b>User</b> <span class="pull-right"><a href="./?a=users&b=edit&id=<?php echo $row['uid']; ?>"><?php echo idinfo($row['uid'],"email"); ?></a></span></td>
							</tr>
							<tr>
								<td><b>User wallet address:</b> <span class="pull-right"><?php echo addrinfo($row['from_address'],"address"); ?></span></td>
							</tr>
							<?php
								if($row['attachment']) { ?>
							<tr>
								<td><b>Document for payment:</b><br/>
								
								<a href="<?php echo $settings['url'].$row['attachment']; ?>" target="_blank">
								<img src="<?php echo $settings['url'].$row['attachment']; ?>" class="img-responsive">
								<small>Click to preview full size.</small>
								</a></td>
							</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
			</div>
			<?php
			} else {
				echo  error("Unkown trade type.");
			}
			?>
		</div>
	</div>
	<?php
} else {
?>
<ol class="breadcrumb">
	<li><a href="./"><?php echo $settings['name']; ?> Administrator</a></li>
	<li class="active">Buy & Sell Trades</li>
</ol>

<div class="panel panel-default">
	<div class="panel-heading">
		Buy & Sell Trades
	</div>
	<div class="panel-body">
		<table class="table table-striped">
			<thead>
				<tr>
					<th>Order ID</th>
					<th width="20%">User</th>
					<th width="15%">Type</th>
					<th width="20%">Payment Method</th>
					<th width="20%">Amount</th>
					<th width="15%">Status</th>
					<th width="10%">Action</th>
				</tr>
			</thead>
			<tbody>
				<?php
				$page = (int) (!isset($_GET["page"]) ? 1 : $_GET["page"]);
				$limit = 20;
				$startpoint = ($page * $limit) - $limit;
				if($page == 1) {
					$i = 1;
				} else {
					$i = $page * $limit;
				}
				$statement = "btc_requests";
				$query = $db->query("SELECT * FROM {$statement} ORDER BY id DESC LIMIT {$startpoint} , {$limit}");
				if($query->num_rows>0) {
					while($row = $query->fetch_assoc()) {
						if($row['status'] == "1") { 
							$status = '<span class="label label-info">Awaiting</span>';
						} elseif($row['status'] == "2") {
							$status = '<span class="label label-success">Processed</span>';
						} elseif($row['status'] == "3") {
							$status = '<span class="label label-danger">Canceled</span>';
						} else { $status = '<span class="label label-defualt">Unknown</span>'; }
						$payment_method = gatewayinfo($row['gateway_id'],"name");
						$currency = gatewayinfo($row['gateway_id'],"currency");
						$payment_method = $payment_method.' '.$currency;
						if($row['type'] == "1") { $type = 'Buy Bitcoins'; } elseif($row['type'] == "2") { $type = 'Sell Bitcoins'; } else { $type = 'Unknown'; }
						?>
						<tr>
							<td><?php echo $row['id']; ?></td>
							<td><a href="./?a=users&b=edit&id=<?php echo $row['uid']; ?>"><?php echo idinfo($row['uid'],"email"); ?></a></td>
							<td><?php echo $type; ?></td>
							<td><?php echo $payment_method; ?></td>
							<td><?php echo $row[btc_amount]; ?> BTC (<?php echo $row[amount].' '.$currency; ?>)</td>
							<td><?php echo $status; ?></td>
							<td>
								<a href="./?a=trades&b=explore&id=<?php echo $row['id']; ?>" title="Explore"><i class="fa fa-search"></i> Explore</a>
							</td>
						</tr>
						<?php
					}
				} else {
					echo '<tr><td colspan="6">Still no have trade requests yet.</td></tr>';
				}
				?>
			</tbody>
		</table>
		<?php
		$ver = "./?a=trades";
		if(admin_pagination($statement,$ver,$limit,$page)) {
			echo admin_pagination($statement,$ver,$limit,$page);
		}
		?>
	</div>
</div>
<?php
}
?>