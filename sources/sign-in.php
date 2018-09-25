<?php
if(checkSession()) { header("Location: $settings[url]"); }
?>
<!DOCTYPE html>
<html lang="en" class="fullscreen-bg">

<head>
	<title><?php echo $lang['sign_in']; ?> - <?php echo $settings['name']; ?></title>
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
	<link rel="apple-touch-icon-precomposed" sizes="144x144" href="assets/ico/bravana144.png">
	<link rel="apple-touch-icon-precomposed" sizes="114x114" href="assets/ico/bravana114.png">
	<link rel="apple-touch-icon-precomposed" sizes="72x72" href="assets/ico/bravana72.png">
	<link rel="apple-touch-icon-precomposed" href="assets/ico/bravana57.png">
	<link rel="shortcut icon" href="assets/ico/favicon.ico">
</head>

<body class="layout-full">
	<!-- WRAPPER -->
	<div id="wrapper">
		<div class="header">
			<a href="<?php echo $settings['url']; ?>"><img src="<?php echo $settings['url']; ?>assets/img/login-invert.png" class="logo" alt="<?php echo $settings['name']; ?> Logo"></a>
			<h1 class="heading"><?php echo $lang['sign_in_to_your_account']; ?></h1>
		</div>
		<div class="table-wrap">
			<div class="table-cell">
				<div class="auth-box">
					<div class="container">
						<div class="col-md-3"></div>
						<div class="col-md-6" style="z-index:9999;">
							<br/>
							<form class="form-auth-small" style="width:100%;" action="" method="POST">
								<h2 class="heading"><?php echo $lang['sign_in']; ?></h2>
								<?php 
								if(isset($_POST['btc_sign_in'])) {
									$email = protect($_POST['email']);
									$password = protect($_POST['password']);
									$password = md5($password);
									$check = $db->query("SELECT * FROM btc_users WHERE email='$email' and password='$password'");
									if($check->num_rows>0) {
										$row = $check->fetch_assoc();
										if($settings['email_verification'] == "1" && $row['email_verified'] !== "1") { echo error($lang['error_4']); }
										elseif($row['status'] == "2") { echo error($lang['error_5']); }
										else {
											if($_POST['remember_me'] == "yes") {
												setcookie("bitcoinwallet_uid", $row['id'], time() + (86400 * 30), '/'); // 86400 = 1 day
											}
											$_SESSION['btc_uid'] = $row['id'];
											$time = time();
											$update = $db->query("UPDATE btc_users SET time_signin='$time' WHERE id='$row[id]'");
											$redirect = $settings['url']."account/wallet";
											header("Location:$redirect");
										}
									} else {
										echo error("Wrong email address or password.");
									}
								}
								?>
								<div class="form-group">
									<label for="signup-email" class="control-label sr-only"><?php echo $lang['email']; ?></label>
									<input type="email" class="form-control" name="email" id="signup-email" placeholder="<?php echo $lang['email']; ?>">
								</div>
								<div class="form-group">
									<label for="signup-password" class="control-label sr-only"><?php echo $lang['password']; ?></label>
									<input type="password" name="password" class="form-control" id="signup-password" placeholder="<?php echo $lang['password']; ?>">
								</div>
								<div class="form-group clearfix">
									<label class="fancy-checkbox element-left">
										<input type="checkbox" name="remember_me" value="yes">
										<span><?php echo $lang['remember_me']; ?></span>
									</label>
									<a href="<?php echo $settings['url']; ?>password/reset" class="element-right"><?php echo $lang['i_forgot_my_password']; ?></a>
								</div>
								<div class="form-group">
									<button type="submit" class="btn btn-primary btn-lg btn-block" name="btc_sign_in"><?php echo $lang['btn_3']; ?></button>
									<br>
									<p><?php echo $lang['dont_have_account']; ?> <a href="<?php echo $settings['url']; ?>sign-up"><?php echo $lang['here']; ?></a></p>
								</div>
							</form>
						</div>
						<div class="col-md-3"></div>
					</div>
				</div>
			</div>
		</div>
		<!-- FOOTER -->
		<div class="container">
			<footer class="no-background footer-fixed ">
				<div class="container">
					<div class="footer-bottom">
						<div class="left">
						<nav class="clearfix">
							<ul class="list-inline">
								<li><a href="<?php echo $settings['url']; ?>page/terms-of-services"><?php echo $lang['terms_of_services']; ?></a></li>
								<li><a href="<?php echo $settings['url']; ?>page/privacy-policy"><?php echo $lang['privacy_policy']; ?></a></li>
								<li><a href="<?php echo $settings['url']; ?>faq"><?php echo $lang['faq_short']; ?></a></li>
								<li><a href="<?php echo $settings['url']; ?>contact-us"><?php echo $lang['contact_us']; ?></a></li>
							</ul>
						</nav>
						<p class="copyright-text">&copy; <?php echo date('Y') ?> <a href="http://mirak.no">www.mirak.no</a>. All Rights Reserved.</p>
					</div>
					<ul class="right list-inline social-icons social-icons-bordered social-icons-small social-icons-fullrounded">
						<li><a href="<?php echo $settings['fb_link']; ?>"><i class="fa fa-facebook"></i></a></li>
						<li><a href="<?php echo $settings['tw_link']; ?>"><i class="fa fa-twitter"></i></a></li>
					</ul>
					</div>
				</div>
			</footer>
			<!-- END FOOTER -->
		</div>
	</div>
	<!-- END WRAPPER -->
	<!-- JAVASCRIPT -->
	<script src="<?php echo $settings['url']; ?>assets/js/jquery-2.1.1.min.js"></script>
	<script src="<?php echo $settings['url']; ?>assets/js/bootstrap.min.js"></script>

</body>

</html>
