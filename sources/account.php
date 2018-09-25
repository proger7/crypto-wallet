<?php
if(!checkSession()) { $redirect = $settings['url']."sign-in"; header("Location: $redirect"); }
$b = protect($_GET['b']);
?>

		<!-- PAGE CONTENT -->
		<div class="page-content">
			<div class="container">
				<div class="row">
					<div class="col-sm-3">
						<button class="btn btn-default-gray sidebarnav-toggle btn-block margin-bottom-30 visible-xs-block"><i class="fa fa-bars"></i> <?php echo $lang['menu']; ?></button>
						<ul id="sidebar-nav" class="nav nav-pills nav-stacked sidebar-nav">
							<li class="<?php if($b == "wallet") { echo 'active'; } ?>"><a href="<?php echo $settings['url']; ?>account/wallet"><?php echo $lang['my_wallet']; ?></a></li>
							<li class="<?php if($b == "deposit-money") { echo 'active'; } ?>"><a href="<?php echo $settings['url']; ?>account/deposit-money"><?php echo $lang['deposit_money']; ?></a></li>
							<li class="<?php if($b == "withdraw-money") { echo 'active'; } ?>"><a href="<?php echo $settings['url']; ?>account/withdraw-money"><?php echo $lang['withdraw_money']; ?></a></li>
							<?php if($settings['plugin_buy_bitcoins'] == "1") { ?><li class="<?php if($b == "buy-bitcoins") { echo 'active'; } ?>"><a href="<?php echo $settings['url']; ?>account/buy-bitcoins"><?php echo $lang['buy_bitcoins']; ?></a></li><?php } ?>
							<?php if($settings['plugin_sell_bitcoins'] == "1") { ?><li class="<?php if($b == "sell-bitcoins") { echo 'active'; } ?>"><a href="<?php echo $settings['url']; ?>account/sell-bitcoins"><?php echo $lang['sell_bitcoins']; ?></a></li><?php } ?>
							<?php if($settings['plugin_transfer_bitcoins'] == "1") { ?><li class="<?php if($b == "transfer-bitcoins") { echo 'active'; } ?>"><a href="<?php echo $settings['url']; ?>account/transfer-bitcoins"><?php echo $lang['transfer_bitcoins']; ?></a></li><?php } ?>
							<?php if($settings['plugin_request_bitcoins'] == "1") { ?><li class="<?php if($b == "request-bitcoins") { echo 'active'; } ?>"><a href="<?php echo $settings['url']; ?>account/request-bitcoins"><?php echo $lang['request_bitcoins']; ?></a></li><?php } ?>
							<li class="<?php if($b == "transactions") { echo 'active'; } ?>"><a href="<?php echo $settings['url']; ?>account/transactions"><?php echo $lang['transactions']; ?></a></li>
							<li class="<?php if($b == "security") { echo 'active'; } ?>"><a href="<?php echo $settings['url']; ?>account/security"><?php echo $lang['security']; ?></a></li>
							<?php if(idinfo($_SESSION['btc_uid'],"status") !== "3") { ?><li class="<?php if($b == "verification") { echo 'active'; } ?>"><a href="<?php echo $settings['url']; ?>account/verification"><?php echo $lang['account_verification']; ?></a></li><?php } ?>
						</ul>
					</div>
					<div class="col-sm-9">
					<?php
					if($b == "wallet") {
						include("account/wallet.php"); 
					} elseif($b == "transactions") {
						include("account/transactions.php");
					}  elseif($b == "security") {
						include("account/security.php");
					}  elseif($b == "buy-bitcoins") {
						include("account/buy-bitcoins.php");
					}  elseif($b == "sell-bitcoins") {
						include("account/sell-bitcoins.php");
					}  elseif($b == "transfer-bitcoins") {
						include("account/transfer-bitcoins.php");
					}    elseif($b == "request-bitcoins") {
						include("account/request-bitcoins.php");
					}  elseif($b == "verification") {
						include("account/verification.php");
					}  elseif($b == "deposit-money") {
						include("account/deposit-money.php");
					}  elseif($b == "withdraw-money") {
						include("account/withdraw-money.php");
					} else {
						header("Location: $settings[url]");
					}
					?>
					</div>
				</div>
			</div>
		</div>
		<!-- END PAGE CONTENT -->
		<div id="btc_modals"></div>