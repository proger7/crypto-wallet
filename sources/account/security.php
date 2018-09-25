
					<h2><small><?php echo $lang['security']; ?></small> </h2>
						<div class="row">
							<div class="col-md-12">
								<h4><?php echo $lang['password']; ?></h4>
								<p><?php echo $lang['password_info']; ?></p>
														<?php
														if(isset($_POST['btc_change_password'])) {
															$cpass = protect($_POST['cpass']);
															$npass = protect($_POST['npass']);
															$cnpass = protect($_POST['cnpass']);
															if(empty($cpass) or empty($npass) or empty($cnpass)) { echo error($lang['error_1']); }
															elseif(idinfo($_SESSION['btc_uid'],"password") !== md5($cpass)) { echo error($lang['error_17']); }
															elseif(strlen($npass)<8) { echo error($lang['error_18']); }
															elseif($npass !== $cnpass) { echo error($lang['error_19']); }
															else {
																$pass = md5($npass);
																$update = $db->query("UPDATE btc_users SET password='$pass' WHERE id='$_SESSION[btc_uid]'");
																echo success($lang['success_6']);
															}
														}
														?>
														<form action="" method="POST">
															<div class="form-group">
																<label><?php echo $lang['current_password']; ?></label>
																<input type="password" class="form-control" name="cpass">
															</div>
															<div class="form-group">
																<label><?php echo $lang['new_password']; ?></label>
																<input type="password" class="form-control" name="npass">
															</div>
															<div class="form-group">
																<label><?php echo $lang['confirm_new_password']; ?></label>
																<input type="password" class="form-control" name="cnpass">
															</div>
															<button type="submit" class="btn btn-primary" name="btc_change_password"><?php echo $lang['btn_13']; ?></button>
														</form>
														<br><br>
							</div>
							<div class="col-md-12">
								<h4><?php echo $lang['secret_pin']; ?></h4>
								<p><?php echo $lang['secret_pin_info']; ?></p>
														<?php
														$hide_form=0;
														if(idinfo($_SESSION['btc_uid'],"secret_pin")) {
														if(isset($_POST['btc_change_pin'])) {
															$cpin = protect($_POST['cpin']);
															$npin = protect($_POST['npin']);
															$cnpin = protect($_POST['cnpin']);
															if(empty($cpin) or empty($npin) or empty($cnpin)) { echo error($lang['error_1']); }
															elseif(idinfo($_SESSION['btc_uid'],"secret_pin") !== md5($cpin)) { echo error($lang['error_20']); }
															elseif(strlen($npin)<6) { echo error($lang['error_21']); }
															elseif($npin !== $cnpin) { echo error($lang['error_22']); }
															else {
																$pin = md5($cpin);
																$update = $db->query("UPDATE btc_users SET secret_pin='$pin' WHERE id='$_SESSION[btc_uid]'");
																echo success($lang['success_7']);
															}
														}
														if(isset($_POST['btc_remove_pin'])) {
															$cpin = protect($_POST['cpin']);
															if(empty($cpin)) { echo error($lang['error_23']); }
															elseif(idinfo($_SESSION['btc_uid'],"secret_pin") !== md5($cpin)) { echo error($lang['error_24']); }
															else {
																$update = $db->query("UPDATE btc_users SET secret_pin='' WHERE id='$_SESSION[btc_uid]'");
																echo success($lang['success_8']);
																$hide_form=1;
															}
														}
														if($hide_form !== "1") {
														?>
														<form action="" method="POST">
															<div class="form-group">
																<label><?php echo $lang['current_secret_pin']; ?></label>
																<input type="password" class="form-control" name="cpin">
															</div>
															<div class="form-group">
																<label><?php echo $lang['new_secret_pin']; ?></label>
																<input type="password" class="form-control" name="npin">
															</div>
															<div class="form-group">
																<label><?php echo $lang['confirm_secret_pin']; ?></label>
																<input type="password" class="form-control" name="cnpin">
															</div>
															<button type="submit" class="btn btn-primary" name="btc_change_pin"><?php echo $lang['btn_14']; ?></button> 
															<button type="submit" class="btn btn-danger" name="btc_remove_pin"><?php echo $lang['btn_15']; ?></button>
														</form>
														<?php
														}
														} else { 
														if(isset($_POST['btn_setup_secret_pin'])) {
															$secret_pin = protect($_POST['secret_pin']);
															if(empty($secret_pin)) { echo error($lang['error_25']); }
															elseif(strlen($secret_pin)<6) { echo error($lang['error_26']); }
															else {
																$pin = md5($secret_pin);
																$update = $db->query("UPDATE btc_users SET secret_pin='$pin' WHERE id='$_SESSION[btc_uid]'");
																echo success("You setup Secret PIN successfully.");
																$hide_form=1;
															}
														}
														if($hide_form !== "1") {
														?>
														<form action="" method="POST">
															<div class="form-group">
																<label><?php echo $lang['setup_secret_pin']; ?></label>
																<input type="password" class="form-control" name="secret_pin">
															</div>
															<button type="submit" class="btn btn-primary" name="btn_setup_secret_pin"><?php echo $lang['btn_16']; ?></button>
														</form>
														<?php
														}
														}
														?>
							</div>
						</div>