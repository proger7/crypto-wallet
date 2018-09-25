<!-- HERO UNIT -->
		<section class="hero-unit hero-fullwidth fullwidth-image hero-rotating-words">
			<div class="hero-content">
				<div class="container">
					<h2 class="heading"><?php echo $settings['name']; ?></h2>
					<p class="lead"><?php echo $lang['made']; ?> <span id="rotating-words" class="rotating-words"><?php echo $lang['to_protect_your_wallet']; ?>, <?php echo $lang['for_fast_secure_payments']; ?>, <?php echo $lang['to_save_your_time']; ?></span></p>
					<?php if(checkSession()) { ?>
					<a href="<?php echo $settings['url']; ?>account/wallet" class="btn btn-primary btn-lg"><?php echo $lang['logged_as']; ?> <?php echo idinfo($_SESSION['btc_uid'],"email"); ?></a>
					<?php } else { ?>
					<form action="<?php echo $settings['url']; ?>sign-up" method="POST"> 
					<div class="row">
						<div class="col-md-5">
							<div class="form-group">
								<input type="text" class="form-control input-lg" name="email" placeholder="<?php echo $lang['email']; ?>">
							</div>
							<div class="form-group">
								<input type="password" class="form-control input-lg" name="password" placeholder="<?php echo $lang['password']; ?>">
							</div>
							<button type="submit" class="btn btn-primary btn-lg" name="btc_get_wallet"><i class="fa fa-bitcoin"></i> <?php echo $lang['btn_2']; ?></button>
						</div>
						<div class="col-md-7"></div>
					</div>	
					</form>
					
					<?php } ?>
				</div>
			</div>
		</section>
		<!-- END HERO UNIT -->
	
		<!-- WHAT WE DO -->
		<section>
			<div class="container">
				<h2 class="section-heading"><?php echo $lang['home_title_4']; ?><br/>
				<small><?php echo $lang['home_info_4']; ?></small></h2>
				<div class="row">
					<div class="col-md-12">
						<div class="row">
							<div class="col-md-4">
								<div class="icon-info icon-info-left">
									<i class="fa fa-bitcoin text-primary fa-3x"></i>
									<div class="text">
										<h2 class="title"><?php echo $lang['home_title_5']; ?></h2>
										<p><?php echo $lang['home_info_5']; ?></p>
									</div>
								</div>
							</div>
							<div class="col-md-4">
								<div class="icon-info icon-info-left">
									<i class="fa fa-lock text-primary fa-3x"></i>
									<div class="text">
										<h2 class="title"><?php echo $lang['home_title_6']; ?></h2>
										<p><?php echo $lang['home_info_6']; ?></p>
									</div>
								</div>
							</div>
							<div class="col-md-4">
								<div class="icon-info icon-info-left">
									<i class="fa fa-shield fa-3x text-primary"></i>
									<div class="text">
										<h2 class="title"><?php echo $lang['home_title_7']; ?></h2>
										<p><?php echo $lang['home_info_7']; ?></p>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!--<div class="col-md-6">
						<img src="assets/img/bitcoin2_complete.png" class="img-responsive">
					</div>-->
				</div>
			</div>
		</section>
		<!-- END WHAT WE DO -->
		