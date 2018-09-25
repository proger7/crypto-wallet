
					<h2><small><?php echo $lang['transactions']; ?></small> 

															</h2>
															<div class="timeline">
															<?php
															$transactionsCount = $btcwallet->getTransactionsCount(idinfo($_SESSION['btc_uid'],"email"));
															$txncount = count($transactionsCount);
															$page = (int) (!isset($_GET["page"]) ? 1 : $_GET["page"]);
															$limit = 5;
															$startpoint = ($page * $limit) - $limit;
															$transactions = $btcwallet->getAllTransactions(idinfo($_SESSION['btc_uid'],"email"),$limit,$startpoint);
															krsort($transactions);
															foreach($transactions as $transaction) {
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
																
															$ver = $settings['url']."account/transactions";
															if(web2_pagination($txncount,$ver,$limit,$page)) {
																echo '<br><br><br>';
																echo web2_pagination($txncount,$ver,$limit,$page);
															}
															?>