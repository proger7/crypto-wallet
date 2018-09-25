<ol class="breadcrumb">
	<li><a href="./"><?php echO $settings['name']; ?> Administrator</a></li>
	<li class="active">Dashboard</li>
</ol>

<div class="row">
	<div class="col-lg-3">
		 <div class="panel panel-default twitter">
                    <div class="panel-body fa-icons">
                        <small class="social-title">Users</small>
                        <h3 class="count">
                            <?php $get_stats = $db->query("SELECT * FROM btc_users"); echo $get_stats->num_rows; ?></h3>
                        <i class="fa fa-users"></i>
                    </div>
                </div>
	</div>
	<div class="col-lg-3">
		<div class="panel panel-default google-plus">
                    <div class="panel-body fa-icons">
                        <small class="social-title">CURRENT NETWORK FEE</small>
                        <h3 class="count">
                            <?php echo get_paytxfee(); ?></h3>
                        <i class="fa fa-globe"></i>
                    </div>
                </div>
	</div>
	<div class="col-lg-3">
		<div class="panel panel-default facebook-like">
                    <div class="panel-body fa-icons">
                        <small class="social-title">Total BTC in Bitcoin Node</small>
                        <h3 class="count">
                            <?php echo get_total_btc(); ?></h3>
                        <i class="fa fa-bitcoin"></i>
                    </div>
                </div>
	</div>
	<div class="col-lg-3">
		<div class="panel panel-default visitor">
                    <div class="panel-body fa-icons">
                        <small class="social-title">Your Balance</small>
                        <h3 class="count" style="font-size:25px;padding-top:6px;padding-bottom:6px;">
                            <?php echo admin_get_profit(); ?></h3>
                        <i class="fa fa-dollar"></i>
                    </div>
                </div>
	</div>
	<div class="col-lg-12">
		<?php 
		$buy_balance = formatBTC(convertToBTCFromSatoshi(getAddressBalance($buy_address)));
		$sell_balance = formatBTC(convertToBTCFromSatoshi(getAddressBalance($sell_address)));
		echo info("Your current balance in your BUY address ($buy_address): $buy_balance BTC");
		echo info("Your current balance in your SELL address ($sell_address): $sell_balance BTC");		
		?>
		<div class="panel panel-primary">
			<div class="panel-heading">New Buy & Sell Bitcoins Requests</div>
			<div class="panel-body">
				<table class="table table-striped">
					<thead>
						<tr>
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
						$query = $db->query("SELECT * FROM btc_requests WHERE status='1' ORDER BY id DESC");
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
			</div>	
		</div>
		
		<div class="panel panel-primary">
			<div class="panel-heading">Latest transactions</div>
			<div class="panel-body">
				<?php
				$btcwlatesttransactions =  $btcwallet->getAdminTransactionList();
				krsort($btcwlatesttransactions);
															foreach($btcwlatesttransactions as $transaction) {
				?>
						<div class="panel panel-default">
										<div class="panel-body">
											<div class="row">
												<div class="col-md-2 text-center">
													<?php
													if($transaction['category'] == "send") {
														echo '<span class="text text-danger text-center"><i class="fa fa-arrow-circle-o-up fa-2x"></i><br/>Sent</span>';
													} else {
														echo '<span class="text text-success text-center"><i class="fa fa-arrow-circle-o-down fa-2x"></i><br/>Received</span>';
													}
													?>
													<br><br>
													<span class="text-muted"><small><?php echo $transaction['confirmations']." confirmations"; ?></small></span>
												</div>
												<div class="col-md-10">
													<table class="table table-striped">
														<tbody>
															<tr>
																<td>Transaction:</td>
																<td><a href="https://chain.so/tx/BTC/<?php echo $transaction['txid']; ?>" target="_blank"><?php echo $transaction['txid']; ?></a></td>
															</tr>	
															<tr>
																<td>User:</td>
																<td><?php 
																$acc = $btcwallet->getaccountbyaddress($transaction['address']); 
																$acc = str_ireplace("eswallet(","",$acc);
																$acc = str_ireplace(")","",$acc);
																$query = $db->query("SELECT * FROM btc_users WHERE email='$acc'");
																if($query->num_rows>0) {
																	$row = $query->fetch_assoc();
																	echo '<a href="./?a=users&b=edit&id='.$row[id].'">'.$row[username].'</a>';
																} else {
																	echo 'not sent from this wallet';
																}
																?></td>
															</tr>
															<tr>
																<td>Address:</td>
																<td><?php echo $transaction['address']; ?></td>
															</tr>
															<tr>
																<td>Amount:</td>
																<td><?php echo $transaction['amount']; ?> BTC</td>
															</tr>
															<tr>
																<td>Time:</td>
																<td><?php echo date("d/m/Y H:i",$transaction['time']); ?></td>
															</tr>
														</tbody>
													</table>
												</div>
											</div>
										</div>
									</div>
						<?php
					}
			
				?>
			</div>	
		</div>
		
		<?php
		$query = $db->query("SELECT * FROM btc_users WHERE document_1 != '' and document_verified='0' ORDER BY id");
		if($query->num_rows>0) {
		?>
		<br>
		<div class="panel panel-primary">
			<div class="panel-heading">Pending documents for approval</div>
			<div class="panel-body">
				<table class="table">
		      <thead>
		        <tr>
					<th width="5%">ID</th>
					<th width="15%">Username</th>
					<th width="15%">Email address</th>
					<th width="15%">Document 1</th>
					<th width="15%">Document 2</th>
					<th width="15%">Registered on</th>
					<th width="10%">Action</th>
				</tr>
		      </thead>
		      <tbody>
		      <?php
			    while($row = $query->fetch_assoc()) {
				?>
						<tr>
							<td><?php echo $row['id']; ?></td>
							<td><?php echo $row['username']; ?></td>
							<td><?php echo $row['email']; ?></td>
							<td><a href="<?php echo $settings['url'].$row['document_1']; ?>" target="_blank"><?php echo basename($row['document_1']); ?></a></td>
							<td><a href="<?php echo $settings['url'].$row['document_2']; ?>" target="_blank"><?php echo basename($row['document_2']); ?></a></td>
							<td><span class="label label-primary"><?php echo date("d/m/Y H:i:s",$row['signup_time']); ?></span></td>
							<td>
								<a href="./?a=users&b=edit&id=<?php echo $row['id']; ?>" title="Approve"><i class="fa fa-check"></i></a>
							</td>
						</tr>
				<?php 
				$i++;
				}
			  ?>
		      </tbody>
		    </table>
			
			</div>	
		</div>
		<?php
		}
		?>
		
				
	</div>
</div>