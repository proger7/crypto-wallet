<!DOCTYPE html>
<html lang="en">

<head>
	<title><?php echo $settings['title']; ?></title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="<?php echo $settings['description']; ?>">
	<meta name="keywords" content="<?php echo $settings['keywords']; ?>">
	<meta name="author" content="mirak.no">
	<!-- CORE CSS -->
	<link href="<?php echo $settings['url']; ?>assets/css/bootstrap.css" rel="stylesheet" type="text/css">
	<link href="<?php echo $settings['url']; ?>assets/css/font-awesome.min.css" rel="stylesheet" type="text/css">
	<link href="<?php echo $settings['url']; ?>assets/css/elegant-icons.css" rel="stylesheet" type="text/css">
	<!-- THEME CSS -->
	<link href="<?php echo $settings['url']; ?>assets/css/main.css" rel="stylesheet" type="text/css">
	<link href="<?php echo $settings['url']; ?>assets/css/my-custom-styles.css" rel="stylesheet" type="text/css">
	
	<!-- GOOGLE FONTS -->
	<link href='https://fonts.googleapis.com/css?family=Raleway:700,400,400italic,500' rel='stylesheet' type='text/css'>
	<link href='https://fonts.googleapis.com/css?family=Lato:400,400italic,700,300,300italic' rel='stylesheet' type='text/css'>
	<!-- FAVICONS -->
	<?php if($lang['lang_type'] == "rtl") { ?>
	<link href="<?php echo $settings['url']; ?>assets/css/bootstrap-flipped.min.css" rel="stylesheet" type="text/css" media="all" />
	<link href="<?php echo $settings['url']; ?>assets/css/bootstrap-rtl.min.css" rel="stylesheet" type="text/css" media="all" />
	<?php } ?>


</head>

<body>
	<!-- WRAPPER -->
	<div id="wrapper">
		<!-- NAVBAR -->
		<nav class="navbar navbar-default navbar-fixed-top ">
		<!-- TOP BAR -->
			<div class="nav-topbar clearfix ">
				<div class="container">
					<div class="left">
						<!--<ul class="list-inline social-icons social-icons-small social-icons-fullrounded">
							<li><a href="<?php echo $settings['fb_link']; ?>" target="_blank"><i class="fa fa-facebook"></i></a></li>
							<li><a href="<?php echo $settings['tw_link']; ?>" target="_blank"><i class="fa fa-twitter"></i></a></li>
						</ul>-->

						<div class="list-inline social-icons social-icons-small social-icons-fullrounded">
							<div class="dropdown"> 
								<button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown">
									Select currency
								</button>
								<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
									 <a class="dropdown-item disabled" href="#">USD</a> <a class="dropdown-item" href="#">Dollar</a><br/>
									 <a class="dropdown-item" href="#">EUR Euro</a>
								</div>
							</div>
						</div>

					</div>
					<div class="left">
						<!--<ul class="list-inline social-icons social-icons-small social-icons-fullrounded">
							<li><a href="<?php echo $settings['fb_link']; ?>" target="_blank"><i class="fa fa-facebook"></i></a></li>
							<li><a href="<?php echo $settings['tw_link']; ?>" target="_blank"><i class="fa fa-twitter"></i></a></li>
						</ul>-->

						<div class="list-inline social-icons social-icons-small social-icons-fullrounded">
							<div class="dropdown"> 
								<button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown">
									Select cryptocurrency
								</button>
								<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
									 <a class="dropdown-item disabled" href="#">BTC</a> <a class="dropdown-item" href="#">Bitcoin</a><br/>
									 <a class="dropdown-item" href="#">ETH Ethereum</a>
								</div>
							</div>
						</div>

					</div>

					<div class="right">
						<ul class="nav navbar-nav navbar-right">
							<?php if(checkSession()) { ?>
							<li><a href="<?php echo $settings['url']; ?>account/wallet"><img src="https://www.masterinvest.info/uploads/coins/128/ethereum-lite.png" width="15px" alt="ethereum" /> <?php echo get_user_balance_eth($_SESSION['eth_uid']); ?> ETH</a></li>		
							<li><a href="<?php echo $settings['url']; ?>account/wallet"><i class="fa fa-bitcoin"></i> <?php echo get_user_balance_btc($_SESSION['btc_uid']); ?> BTC</a></li>
							<li><a href="<?php echo $settings['url']; ?>account/wallet"><?php echo $lang['strong_my_wallet']; ?></a></li>
							<li><a href="<?php echo $settings['url']; ?>logout"><?php echo $lang['strong_logout']; ?></a></li>
							<?php } else { ?>
							<li><a href="<?php echo $settings['url']; ?>sign-in"><?php echo $lang['sign_in']; ?></a></li>
							<li><a href="<?php echo $settings['url']; ?>sign-up"><?php echo $lang['sign_up']; ?></a></li>
							<?php } ?>
						</ul>
					</div>
				</div>
			</div>
			<!-- END TOP BAR -->
			<div class="container">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#main-nav-collapse">
					<span class="sr-only">Toggle Navigation</span>
					<i class="fa fa-bars"></i>
				</button>
				<a href="<?php echo $settings['url']; ?>" class="navbar-brand">
					<img src="<?php echo $settings['url']; ?>assets/img/login-invert.png" alt="<?php echo $settings['name']; ?> Logo">
				</a>
				<div id="main-nav-collapse" class="collapse navbar-collapse">
					<ul class="nav navbar-nav main-navbar-nav">
						<li><a href="<?php echo $settings['url']; ?>"><?php echo $lang['menu_home']; ?></a></li>
						<?php if($settings['plugin_buy_bitcoins'] == "1") { ?><li><a href="<?php echo $settings['url']; ?>buy-bitcoins"><?php echo $lang['menu_buy_bitcoins']; ?></a></li><?php } ?>
						<?php if($settings['plugin_sell_bitcoins'] == "1") { ?><li><a href="<?php echo $settings['url']; ?>sell-bitcoins"><?php echo $lang['menu_sell_bitcoins']; ?></a></li><?php } ?>					
						<?php if($settings['plugin_transfer_bitcoins'] == "1") { ?><li><a href="<?php echo $settings['url']; ?>transfer-bitcoins"><?php echo $lang['menu_transfer_bitcoins']; ?></a></li><?php } ?>	
						<?php if($settings['plugin_request_bitcoins'] == "1") { ?><li><a href="<?php echo $settings['url']; ?>request-bitcoins"><?php echo $lang['menu_request_bitcoins']; ?></a></li><?php } ?>
					</ul>
				</div>
				<!-- END MAIN NAVIGATION -->
			</div>
		</nav>
		<!-- END NAVBAR -->