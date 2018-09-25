<?php
if(checkSession()) { header("Location: $settings[url]"); }
?>
<!DOCTYPE html>
<html lang="en" class="fullscreen-bg">

<head>
	<title><?php echo $lang['reset_password']; ?> - <?php echo $settings['name']; ?></title>
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
			<h1 class="heading"><?php echo $lang['reset_acc_pass']; ?></h1>
		</div>
		<div class="table-wrap">
			<div class="table-cell">
				<div class="auth-box">
					<div class="container">
						<div class="col-md-3"></div>
						<div class="col-md-6" style="z-index:9999;">
							<br/>
							<form class="form-auth-small" style="width:100%;" action="" method="POST">
								<h2 class="heading"><?php echo $lang['reset']; ?></h2>
								<?php 
								if(isset($_POST['btc_reset'])) {
									$email = protect($_POST['email']);
									$check = $db->query("SELECT * FROM btc_users WHERE email='$email'");
									if(empty($email)) { echo error("Please enter your email address."); }
									elseif($check->num_rows==0) { echo error("No such user with this email address."); }
									else {
										$row = $check->fetch_assoc();
										$email_hash = randomHash(10);
										$update = $db->query("UPDATE btc_users SET email_hash='$email_hash' WHERE id='$row[id]'");
										echo success("Link with instructions was sent to your email.");
										emailsys_reset_password($email,$email_hash);
									}
								}
								?>
								<div class="form-group">
									<label for="signup-email" class="control-label sr-only"><?php echo $lang['email_address']; ?></label>
									<input type="email" class="form-control" name="email" id="signup-email" placeholder="<?php echo $lang['email_address']; ?>">
								</div>
								<div class="form-group">
									<button type="submit" class="btn btn-primary btn-lg btn-block" name="btc_reset"><?php echo $lang['btn_25']; ?></button>
									<br>
									<p><?php echo $lang['already_have_account']; ?> <a href="<?php echo $settings['url']; ?>sign-in"><?php echo $lang['here']; ?></a>.</p> 	
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
