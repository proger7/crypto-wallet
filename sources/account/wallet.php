				<div class="row">
					<div class="col-md-4">
						<div class="count-info-solid clearfix">
							<i><img src="https://www.masterinvest.info/uploads/coins/128/ethereum-lite.png" width="35px" alt="ethereum" ></i>
							<p><span class="number"><?php echo get_user_balance_eth($_SESSION['eth_uid']); ?> ETH</span> <span class="text"><?php echo $lang['current_balance']; ?></span></p>
						</div>
					</div>					
					<div class="col-md-4">
						<div class="count-info-solid clearfix">
							<i class="fa fa-bitcoin"></i>
							<p><span class="number"><?php echo get_user_balance_btc($_SESSION['btc_uid']); ?> BTC</span> <span class="text"><?php echo $lang['current_balance']; ?></span></p>
						</div>
					</div>
					<div class="col-md-4">
						<div class="count-info-solid clearfix">	
							<i class="fa fa-dollar"></i>
							<p><span class="number"><?php echo get_user_balance_usd($_SESSION['btc_uid']); ?></span> <span class="text"><?php echo $lang['current_balance']; ?></span></p>
						</div>
					</div>
					<div class="col-md-4">
						<div class="count-info-solid clearfix">
							<i class="fa fa-dollar"></i>
							<p><span class="number"><?php echo get_user_money($_SESSION['btc_uid']); ?> USD</span> <span class="text"><?php echo $lang['available_money']; ?></span></p>
						</div>
					</div>
					<div class="col-md-4">
						<div class="count-info-solid clearfix">
							<i class="fa fa-euro"></i>
							<p><span class="number"><?php echo get_user_balance_euro($_SESSION['btc_uid']); ?> EUR</span> <span class="text"><?php echo $lang['current_balance']; ?></span></p>
						</div>
					</div>
					<div class="col-md-4">
						<div class="count-info-solid clearfix">
							<i class="fa fa-euro"></i>
							<p><span class="number"><?php echo get_user_money($_SESSION['btc_uid']); ?> EUR</span> <span class="text"><?php echo $lang['available_money']; ?></span></p>
						</div>
					</div>										
				</div>

				<div class="wallet_chart">
<!-- TradingView Widget BEGIN -->
<div id="tv-medium-widget-4de82"></div>
<script type="text/javascript" src="https://s3.tradingview.com/tv.js"></script>

<script type="text/javascript">
new TradingView.MediumWidget({
  "container_id": "tv-medium-widget-4de82",
  "symbols": [
    [
      "BTC/USD",
      "COINBASE:BTCUSD|1y"
    ]
  ],
  "greyText": "Quotes by",
  "gridLineColor": "#e9e9ea",
  "fontColor": "#83888D",
  "underLineColor": "#dbeffb",
  "trendLineColor": "#4bafe9",
  "width": "845px",
  "height": "400px",
  "locale": "en"
});
</script>
<!-- TradingView Widget END -->

				</div>
				
				<div class="panel panel-default">
					<div class="panel-body">
					<h2><small><?php echo $lang['addresses']; ?></small> <span class="pull-right"><small><a href="javascript:void(0);" class="btn btn-default btn-sm" onclick="btc_new_address();"><i class="fa fa-plus"></i> <?php echo $lang['btn_5']; ?></a> <a href="<?php echo $settings['url']; ?>account/transfer-bitcoins" class="btn btn-default btn-sm" onclick="btc_new_address();"><i class="fa fa-arrow-circle-o-up"></i> <?php echo $lang['btn_6']; ?></a></small></span></h2>
							<table class="table">
								<thead>
									<tr>
										<th width="75%"><?php echo $lang['address']; ?></th>
										<th width="20%"><?php echo $lang['balance']; ?></th>
										<th><?php echo $lang['action']; ?></th>
									</tr>
								</thead>
								<tbody id="btc_addresses">
									<?php
									
																	foreach($btcwaddresses as $waddress) { 
																		$i=1;
																		
																		?>
																		<tr id="btc_address_<?php echo $row['id']; ?>">																			</td>
																			<td> <?php echo $waddress; ?> </td>
																			<td><?php echo formatBTC(convertToBTCFromSatoshi(getAddressBalance($waddress))); ?> BTC</td>
																			<td>
																				<a class="btn btn-circle btn-sm btn-icon btn-default" href="javascript:;" data-toggle="tooltip" data-placement="top" title="<?php echo $lang['btn_7']; ?>" onclick="btc_receive_to_address('<?php echo $waddress; ?>');"><i class="fa fa-arrow-circle-o-down" style="margin:0px;"></i></a>
																			
																			</td>
																		</tr>
																		<?php
																		
																	}
																	?>
								</tbody>
							</table>
					</div>
				</div>
				
				<div class="panel panel-default">
					<div class="panel-body">
					<h2><small><?php echo $lang['latest_transactions']; ?></small></h2>
							<div class="timeline">
															<?php
															krsort($btcwlatesttransactions);
															foreach($btcwlatesttransactions as $transaction) {
																	?>
																	 <!-- TIMELINE ITEM -->
																	<div class="timeline-item">
																		<div class="timeline-badge">
																			<?php if($transaction['category'] == "send") { ?>
																			<div style="margin-left:20px;margin-top:35px;font-size:16px;" class="text text-danger"><i class="fa fa-arrow-circle-o-up fa-3x"></i></div>
																			<?php } else { ?>
																			<div style="margin-left:20px;margin-top:35px;font-size:16px;" class="text text-success"><i class="fa fa-arrow-circle-o-down fa-3x"></i></div>
																			<?php }  ?>
																		</div>
																		<div class="timeline-body">
																			<div class="timeline-body-arrow"> </div>
																			<div class="timeline-body-head">
																				<div class="timeline-body-head-caption">
																					<a href="javascript:void(0);" class="timeline-body-title font-blue-madison"><?php if($transaction['category'] == "send") { echo $lang['sent']; } else { echo $lang['received']; }  ?> <?php echo satoshitize($transaction['amount']); ?> BTC</a>
																				</div>
																			</div>
																			<div class="timeline-body-content">
																				<span class="font-grey-cascade"> 
																					<?php echo $lang['transaction_id']; ?>: <b><a href="https://chain.so/tx/BTC/<?php echo $transaction['txid']; ?>" target="_blank"><?php echo $transaction['txid']; ?></a></b><br/>
																					<?php echo $lang['address']; ?>: <b><?php echo $transaction['address']; ?></b><br/>
																					<?php echo $lang['confirmations']; ?>: <b><?php echo $transaction['confirmations']; ?></b><br/>
																					<?php echo $lang['time']; ?>: <b><?php echo date("d/m/Y H:i",$transaction['time']); ?></b>
																					
																				</span>
																			</div>
																		</div>
																	</div>
																	<!-- END TIMELINE ITEM -->
																	<?php
																}
															
															?>


														</div>

					</div>

				</div>

<!-- TradingView Widget BEGIN -->
<div id="tv-medium-widget-4de80"></div>
<script type="text/javascript" src="https://s3.tradingview.com/tv.js"></script>

<script type="text/javascript">
new TradingView.MediumWidget({
  "container_id": "tv-medium-widget-4de80",
  "symbols": [
    [
      "BTC/USD",
      "COINBASE:ETHUSD|1y"
    ]
  ],
  "greyText": "Quotes by",
  "gridLineColor": "#e9e9ea",
  "fontColor": "#83888D",
  "underLineColor": "#dbeffb",
  "trendLineColor": "#4bafe9",
  "width": "845px",
  "height": "400px",
  "locale": "en"
});
</script>
<!-- TradingView Widget END -->					

				<div class="panel panel-default">
					<div class="panel-body">
					<h2><small><?php echo $lang['latest_transactions']; ?></small></h2>
							<div class="timeline">
															<?php
															krsort($btcwlatesttransactions);
															foreach($btcwlatesttransactions as $transaction) {
																	?>
																	 <!-- TIMELINE ITEM -->
																	<div class="timeline-item">
																		<div class="timeline-badge">
																			<?php if($transaction['category'] == "send") { ?>
																			<div style="margin-left:20px;margin-top:35px;font-size:16px;" class="text text-danger"><i class="fa fa-arrow-circle-o-up fa-3x"></i></div>
																			<?php } else { ?>
																			<div style="margin-left:20px;margin-top:35px;font-size:16px;" class="text text-success"><i class="fa fa-arrow-circle-o-down fa-3x"></i></div>
																			<?php }  ?>
																		</div>
																		<div class="timeline-body">
																			<div class="timeline-body-arrow"> </div>
																			<div class="timeline-body-head">
																				<div class="timeline-body-head-caption">
																					<a href="javascript:void(0);" class="timeline-body-title font-blue-madison"><?php if($transaction['category'] == "send") { echo $lang['sent']; } else { echo $lang['received']; }  ?> <?php echo satoshitize($transaction['amount']); ?> BTC</a>
																				</div>
																			</div>
																			<div class="timeline-body-content">
																				<span class="font-grey-cascade"> 
																					<?php echo $lang['transaction_id']; ?>: <b><a href="https://chain.so/tx/BTC/<?php echo $transaction['txid']; ?>" target="_blank"><?php echo $transaction['txid']; ?></a></b><br/>
																					<?php echo $lang['address']; ?>: <b><?php echo $transaction['address']; ?></b><br/>
																					<?php echo $lang['confirmations']; ?>: <b><?php echo $transaction['confirmations']; ?></b><br/>
																					<?php echo $lang['time']; ?>: <b><?php echo date("d/m/Y H:i",$transaction['time']); ?></b>
																					
																				</span>
																			</div>
																		</div>
																	</div>
																	<!-- END TIMELINE ITEM -->
																	<?php
																}
															
															?>


														</div>

					</div>

				</div>