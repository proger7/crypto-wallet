
		<div id="page-header-contact" class="page-header has-background-image">
			<div class="overlay"></div>
			<div class="container">
				<h1 class="page-title"><?php echo $lang['contact_us']; ?></h1>
			</div>
		</div>
		<!-- END PAGE HEADER WITH BACKGROUND IMAGE -->
		<!-- PAGE CONTENT -->
		<div class="page-content no-margin-bottom">
			<!-- SERVICES -->
			<section>
				<div class="container">
					<div class="row margin-top-20">
						<div class="col-md-12">
							<h2 class="heading-border-left"><?php echo $lang['head_contact_us']; ?></h2>
						<p><?php echo $lang['info_contact_us']; ?></p>
						<?php
							if(isset($_POST['bit_send'])) {
								$name = protect($_POST['name']);
								$email = protect($_POST['email']);
								$subject = protect($_POST['subject']);
								$message = protect($_POST['message']);
								
								if(empty($name) or empty($email) or empty($subject) or empty($message)) {
									echo error($lang['error_1']);
								} elseif(!isValidEmail($email)) {
									echo error($lang['error_2']);
								} else {
									$msubject = '['.$settings[name].'] '.$subject;
									$mreceiver = $settings['supportemail'];
									$headers = 'From: '.$supportemail.'' . "\r\n" .
										'Reply-To: '.$email.'' . "\r\n" .
										'X-Mailer: PHP/' . phpversion();
									$mail = mail($mreceiver, $msubject, $message, $headers);
									if($mail) { 
										echo success($lang['success_1']);
									} else {
										echo error($lang['error_3']);
									}
								}
							}
							?>
							<form method="post" id="contact-form" class="form-horizontal form-minimal margin-top-30" novalidate>
							<div class="row">
								<div class="col-sm-6">
									<div class="form-group">
										<label for="contact-name" class="control-label sr-only"><?php echo $lang['name']; ?></label>
										<input type="text" class="form-control" id="contact-name" name="name" placeholder="<?php echo $lang['name']; ?>*" required>
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group">
										<label for="contact-email" class="control-label sr-only"><?php echo $lang['email']; ?></label>
										<input type="email" class="form-control" id="contact-email" name="email" placeholder="<?php echo $lang['email']; ?>*" required>
									</div>
								</div>
							</div>
							<div class="form-group">
								<label for="contact-subject" class="control-label sr-only"><?php echo $lang['subject']; ?></label>
								<div class="col-sm-12">
									<input type="text" class="form-control" id="contact-subject" name="subject" placeholder="<?php echo $lang['subject']; ?>*">
								</div>
							</div>
							<div class="form-group">
								<label for="contact-message" class="control-label sr-only"><?php echo $lang['message']; ?></label>
								<div class="col-sm-12">
									<textarea class="form-control" id="contact-message" name="message" rows="5" cols="30" placeholder="<?php echo $lang['message']; ?>*" required></textarea>
								</div>
							</div>
							<div class="form-group">
								<div class="col-sm-12">
									<button id="submit-button" type="submit" name="bit_send" class="btn btn-primary"><i class="fa loading-icon"></i> <span><?php echo $lang['btn_1']; ?></span></button>
								</div>
							</div>
							<input type="hidden" name="msg-submitted" id="msg-submitted" value="true">
						</form>
						</div>
					</div>
				</div>
			</section>
			<!-- END SERVICES -->