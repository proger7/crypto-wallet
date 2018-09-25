<h2><small><?php echo $lang['account_verification']; ?></small></h2>

<?php
$status = get_verify_type();

if(isset($_POST['bit_send_email'])) {
	$email = idinfo($_SESSION['btc_uid'],"email");
	$hash = md5($email);
	$update = $db->query("UPDATE btc_users SET email_hash='$hash' WHERE id='$_SESSION[btc_uid]'");
	$mail = emailsys_email_verify($email,$hash);
	if($mail) {
		echo success($lang['success_11']);
	} else {
		echo error($lang['error_31']);
	}
} 

if(isset($_POST['bit_upload'])) { 
	$ext = array('jpg','png','jpeg','pdf'); 
	$fileext1 = end(explode('.',$_FILES['document_1']['name'])); 
	$fileext1 = strtolower($fileext1); 
	$fileext2 = end(explode('.',$_FILES['document_2']['name'])); 
	$fileext2 = strtolower($fileext2); 
	if(empty($_FILES['document_1']['name']) or empty($_FILES['document_2']['name'])) { echo error($lang['error_32']); }
	elseif(!in_array($fileext1,$ext)) { echo error($lang['error_33']); }
	elseif(!in_array($fileext2,$ext)) { echo error($lang['error_33']); }
	else {
		$upload_dir = md5($settings['name'])."/";
		if(!is_dir($upload_dir)) { mkdir($upload_dir,0777); }
		$user_dir = $upload_dir."user_".$_SESSION['btc_uid'];
		if(!is_dir($user_dir)) { mkdir($user_dir,0777); }
		$document_1 = $user_dir."/".$_FILES['document_1']['name'];
		$document_2 = $user_dir."/".$_FILES['document_2']['name'];
		@move_uploaded_file($_FILES['document_1']['tmp_name'], $document_1);
		@move_uploaded_file($_FILES['document_2']['tmp_name'], $document_2);
		$update = $db->query("UPDATE btc_users SET document_1='$document_1',document_2='$document_2' WHERE id='$_SESSION[btc_uid]'");
		echo success($lang['success_12']);
	}
}

if(isset($_POST['bit_send_sms_code'])) { 
	include("includes/NexmoMessage.php");
	$nexmo_sms = new NexmoMessage($settings[nexmo_api_key],$settings[nexmo_api_secret]);
	// Step 2: Use sendText( $to, $from, $message ) method to send a message. 
	$rand = rand(00000,99999);
	$number = idinfo($_SESSION['btc_uid'],"mobile_number");
	$insert = $db->query("INSERT btc_sms_codes (uid,sms_code,verified) VALUES ('$_SESSION[btc_uid]','$rand','0')");
	$message = 'Your code for '.$settings[name].' is: '.$rand.' ';
	$info = $nexmo_sms->sendText( '+'.$number, $settings[name], $message );
	$success_13 = str_ireplace("{{number}}",$number,$lang['success_13']);
	echo success($success_13);
}

if(isset($_POST['bit_verify_sms_code'])) {
	$sms_code = protect($_POST['sms_code']);
	$check_code = $db->query("SELECT * FROM btc_sms_codes WHERE uid='$_SESSION[btc_uid]' and sms_code='$sms_code' and verified='0'");
	if(empty($sms_code)) { echo error($lang['error_34']); }
	elseif($check_code->num_rows==0) { echo error($lang['error_35']); }
	else {
		$update = $db->query("UPDATE btc_sms_codes SET verified='1' WHERE uid='$_SESSION[btc_uid]' and sms_code='$sms_code'");
		$update = $db->query("UPDATE btc_users SET mobile_verified='1' WHERE id='$_SESSION[btc_uid]'");
		echo success($lang['success_14']);
	}
} 

if(isset($_POST['bit_add_number'])) {
	$mobile_number = protect($_POST['mobile_number']);
	if(empty($mobile_number)) { echo error($lang['error_36']); }
	elseif(!is_numeric($mobile_number)) { echo error($lang['error_37']); }
	else {
		$update = $db->query("UPDATE btc_users SET mobile_number='$mobile_number' WHERE id='$_SESSION[btc_uid]'");
		echo success($lang['success_15']);
	}
}

if($status == "1") {
	?>
	<h3><?php echo $lang['email_verification']; ?></h3>
	<hr/>
	<?php if(idinfo($_SESSION['btc_uid'],"email_verified") == "1") { ?>
	<p><span class="text text-success"><i class="fa fa-check"></i> <?php echo $lang['your_email_was_verified']; ?></span></p>
	<?php } else { ?>
	<p><?php echo $lang['your_email_not_verified']; ?></p>
	<form action="" method="POST">
		<button type="submit" class="btn btn-primary btn-sm" name="bit_send_email"><i class="fa fa-reply"></i> <?php echo $lang['btn_19']; ?></button>
	</form>
	<?php } ?>

	<br>
	<h3><?php echo $lang['document_verification']; ?></h3>
	<hr/>
	<?php if(idinfo($_SESSION['btc_uid'],"document_verified") == "1") { ?>
	<p><span class="text text-success"><i class="fa fa-check"></i> <?php echo $lang['documents_are_accepted']; ?></span></p>
	<?php } else { ?>
		<?php if(idinfo($_SESSION['btc_uid'],"document_1")) { ?>
		<p><span class="text text-info"><i class="fa fa-clock-o"></i> <?php echo $lang['documents_are_awaiting']; ?></span></p>
		<?php } else { ?>
		<form action="" method="POST" enctype="multipart/form-data">
			<div class="form-group">
				<label><?php echo $lang['scanned_copy_id']; ?></label>
				<input type="file" class="form-control" name="document_1">
			</div>
			<div class="form-group">
				<label><?php echo $lang['scanned_copy_invoice']; ?></label>
				<input type="file" class="form-control" name="document_2">
			</div>
			<button type="submit" class="btn btn-primary btn-sm" name="bit_upload"><i class="fa fa-upload"></i> <?php echo $lang['btn_20']; ?></button>
		</form>
		<?php } ?>
	<?php } ?>
	
	<br>
	<h3>Mobile verification</h3>
	<hr/>
	<?php if(idinfo($_SESSION['btc_uid'],"mobile_verified") == "1") { ?>
	<p><span class="text text-success"><i class="fa fa-check"></i> <?php echo $lang['your_mobile_verified']; ?></span></p>
	<?php } else { ?>
		<?php if(idinfo($_SESSION['btc_uid'],"mobile_number")) { ?>
		<p><?php echo $lang['click_button_sms_code']; ?> <b><?php echo idinfo($_SESSION['btc_uid'],"mobile_number"); ?></b></p>
		<form action="" method="POST">
			<div class="form-group">
				<label><?php echo $lang['enter_sms_code']; ?></label>
				<input type="text" class="form-control" name="sms_code">
			</div>
			<button type="submit" class="btn btn-primary btn-sm" name="bit_send_sms_code"><i class="fa fa-reply"></i> <?php echo $lang['btn_21']; ?></button> 
			<button type="submit" class="btn btn-primary btn-sm" name="bit_verify_sms_code"><i class="fa fa-check"></i> <?php echo $lang['btn_22']; ?></button>
		</form>
		<?php } else { ?>
		<form action="" method="POST">
			<div class="form-group">
				<label><?php echo $lang['your_mobile_number']; ?></label>
				<input type="text" class="form-control" name="mobile_number">
			</div>
			<button type="submit" class="btn btn-primary btn-sm" name="bit_add_number"><i class="fa fa-plus"></i> <?php echo $lang['btn_23']; ?></button>
		</form>
		<?php } ?>
	<?php } ?>
	
	<?php
} elseif($status == "2") {
?>
	<h3><?php echo $lang['email_verification']; ?></h3>
	<hr/>
	<?php if(idinfo($_SESSION['btc_uid'],"email_verified") == "1") { ?>
	<p><span class="text text-success"><i class="fa fa-check"></i> <?php echo $lang['your_email_was_verified']; ?></span></p>
	<?php } else { ?>
	<p><?php echo $lang['your_email_not_verified']; ?></p>
	<form action="" method="POST">
		<button type="submit" class="btn btn-primary btn-sm" name="bit_send_email"><i class="fa fa-reply"></i> <?php echo $lang['btn_19']; ?></button>
	</form>
	<?php } ?>

	<br>
	<h3><?php echo $lang['document_verification']; ?></h3>
	<hr/>
	<?php if(idinfo($_SESSION['btc_uid'],"document_verified") == "1") { ?>
	<p><span class="text text-success"><i class="fa fa-check"></i> <?php echo $lang['documents_are_accepted']; ?></span></p>
	<?php } else { ?>
		<?php if(idinfo($_SESSION['btc_uid'],"document_1")) { ?>
		<p><span class="text text-info"><i class="fa fa-clock-o"></i> <?php echo $lang['documents_are_awaiting']; ?></span></p>
		<?php } else { ?>
		<form action="" method="POST" enctype="multipart/form-data">
			<div class="form-group">
				<label><?php echo $lang['scanned_copy_id']; ?></label>
				<input type="file" class="form-control" name="document_1">
			</div>
			<div class="form-group">
				<label><?php echo $lang['scanned_copy_invoice']; ?></label>
				<input type="file" class="form-control" name="document_2">
			</div>
			<button type="submit" class="btn btn-primary btn-sm" name="bit_upload"><i class="fa fa-upload"></i> <?php echo $lang['btn_20']; ?></button>
		</form>
		<?php } ?>
	<?php } ?>
	
	<?php
} elseif($status == "3") {
?>
	<h3><?php echo $lang['document_verification']; ?></h3>
	<hr/>
	<?php if(idinfo($_SESSION['btc_uid'],"document_verified") == "1") { ?>
	<p><span class="text text-success"><i class="fa fa-check"></i> <?php echo $lang['documents_verified']; ?></span></p>
	<?php } else { ?>
		<?php if(idinfo($_SESSION['btc_uid'],"document_1")) { ?>
		<p><span class="text text-info"><i class="fa fa-clock-o"></i> <?php echo $lang['documents_are_awaiting']; ?></span></p>
		<?php } else { ?>
		<form action="" method="POST" enctype="multipart/form-data">
			<div class="form-group">
				<label><?php echo $lang['scanned_copy_id']; ?></label>
				<input type="file" class="form-control" name="document_1">
			</div>
			<div class="form-group">
				<label><?php echo $lang['scanned_copy_invoice']; ?></label>
				<input type="file" class="form-control" name="document_2">
			</div>
			<button type="submit" class="btn btn-primary btn-sm" name="bit_upload"><i class="fa fa-upload"></i> <?php echo $lang['btn_20']; ?></button>
		</form>
		<?php } ?>
	<?php } ?>
	
	<br>
	<h3>Mobile verification</h3>
	<hr/>
	<?php if(idinfo($_SESSION['btc_uid'],"mobile_verified") == "1") { ?>
	<p><span class="text text-success"><i class="fa fa-check"></i> <?php echo $lang['your_mobile_verified']; ?></span></p>
	<?php } else { ?>
		<?php if(idinfo($_SESSION['btc_uid'],"mobile_number")) { ?>
		<p><?php echo $lang['click_button_sms_code']; ?> <b><?php echo idinfo($_SESSION['btc_uid'],"mobile_number"); ?></b></p>
		<form action="" method="POST">
			<div class="form-group">
				<label><?php echo $lang['enter_sms_code']; ?></label>
				<input type="text" class="form-control" name="sms_code">
			</div>
			<button type="submit" class="btn btn-primary btn-sm" name="bit_send_sms_code"><i class="fa fa-reply"></i> <?php echo $lang['btn_21']; ?></button> 
			<button type="submit" class="btn btn-primary btn-sm" name="bit_verify_sms_code"><i class="fa fa-check"></i> <?php echo $lang['btn_22']; ?></button>
		</form>
		<?php } else { ?>
		<form action="" method="POST">
			<div class="form-group">
				<label><?php echo $lang['your_mobile_number']; ?></label>
				<input type="text" class="form-control" name="mobile_number">
			</div>
			<button type="submit" class="btn btn-primary btn-sm" name="bit_add_number"><i class="fa fa-plus"></i> <?php echo $lang['btn_23']; ?></button>
		</form>
		<?php } ?>
	<?php } ?>
	
	<?php
} elseif($status == "4") {
?>
	<h3><?php echo $lang['email_verification']; ?></h3>
	<hr/>
	<?php if(idinfo($_SESSION['btc_uid'],"email_verified") == "1") { ?>
	<p><span class="text text-success"><i class="fa fa-check"></i> <?php echo $lang['your_email_was_verified']; ?></span></p>
	<?php } else { ?>
	<p><?php echo $lang['your_email_not_verified']; ?></p>
	<form action="" method="POST">
		<button type="submit" class="btn btn-primary btn-sm" name="bit_send_email"><i class="fa fa-reply"></i> <?php echo $lang['btn_19']; ?></button>
	</form>
	<?php } ?>
	
	<br>
	<h3>Mobile verification</h3>
	<hr/>
	<?php if(idinfo($_SESSION['btc_uid'],"mobile_verified") == "1") { ?>
	<p><span class="text text-success"><i class="fa fa-check"></i> <?php echo $lang['your_mobile_verified']; ?></span></p>
	<?php } else { ?>
		<?php if(idinfo($_SESSION['btc_uid'],"mobile_number")) { ?>
		<p><?php echo $lang['click_button_sms_code']; ?> <b><?php echo idinfo($_SESSION['btc_uid'],"mobile_number"); ?></b></p>
		<form action="" method="POST">
			<div class="form-group">
				<label><?php echo $lang['enter_sms_code']; ?></label>
				<input type="text" class="form-control" name="sms_code">
			</div>
			<button type="submit" class="btn btn-primary btn-sm" name="bit_send_sms_code"><i class="fa fa-reply"></i> <?php echo $lang['btn_21']; ?></button> 
			<button type="submit" class="btn btn-primary btn-sm" name="bit_verify_sms_code"><i class="fa fa-check"></i> <?php echo $lang['btn_22']; ?></button>
		</form>
		<?php } else { ?>
		<form action="" method="POST">
			<div class="form-group">
				<label><?php echo $lang['your_mobile_number']; ?></label>
				<input type="text" class="form-control" name="mobile_number">
			</div>
			<button type="submit" class="btn btn-primary btn-sm" name="bit_add_number"><i class="fa fa-plus"></i> <?php echo $lang['btn_23']; ?></button>
		</form>
		<?php } ?>
	<?php } ?>
	
	<?php
} elseif($status == "5") {
?>
	<h3><?php echo $lang['email_verification']; ?></h3>
	<hr/>
	<?php if(idinfo($_SESSION['btc_uid'],"email_verified") == "1") { ?>
	<p><span class="text text-success"><i class="fa fa-check"></i> <?php echo $lang['your_email_was_verified']; ?></span></p>
	<?php } else { ?>
	<p><?php echo $lang['your_email_not_verified']; ?></p>
	<form action="" method="POST">
		<button type="submit" class="btn btn-primary btn-sm" name="bit_send_email"><i class="fa fa-reply"></i> <?php echo $lang['btn_19']; ?></button>
	</form>
	<?php } ?>

	<br>
	<h3><?php echo $lang['document_verification']; ?></h3>
	<hr/>
	<?php if(idinfo($_SESSION['btc_uid'],"document_verified") == "1") { ?>
	<p><span class="text text-success"><i class="fa fa-check"></i> <?php echo $lang['documents_are_accepted']; ?></span></p>
	<?php } else { ?>
		<?php if(idinfo($_SESSION['btc_uid'],"document_1")) { ?>
		<p><span class="text text-info"><i class="fa fa-clock-o"></i> <?php echo $lang['documents_are_awaiting']; ?></span></p>
		<?php } else { ?>
		<form action="" method="POST" enctype="multipart/form-data">
			<div class="form-group">
				<label><?php echo $lang['scanned_copy_id']; ?></label>
				<input type="file" class="form-control" name="document_1">
			</div>
			<div class="form-group">
				<label><?php echo $lang['scanned_copy_invoice']; ?></label>
				<input type="file" class="form-control" name="document_2">
			</div>
			<button type="submit" class="btn btn-primary btn-sm" name="bit_upload"><i class="fa fa-upload"></i> <?php echo $lang['btn_20']; ?></button>
		</form>
		<?php } ?>
	<?php } ?>
	
	<?php
} elseif($status == "6") {
?>
	<h3><?php echo $lang['document_verification']; ?></h3>
	<hr/>
	<?php if(idinfo($_SESSION['btc_uid'],"document_verified") == "1") { ?>
	<p><span class="text text-success"><i class="fa fa-check"></i> <?php echo $lang['documents_are_accepted']; ?></span></p>
	<?php } else { ?>
		<?php if(idinfo($_SESSION['btc_uid'],"document_1")) { ?>
		<p><span class="text text-info"><i class="fa fa-clock-o"></i> <?php echo $lang['documents_are_awaiting']; ?></span></p>
		<?php } else { ?>
		<form action="" method="POST" enctype="multipart/form-data">
			<div class="form-group">
				<label><?php echo $lang['scanned_copy_id']; ?></label>
				<input type="file" class="form-control" name="document_1">
			</div>
			<div class="form-group">
				<label><?php echo $lang['scanned_copy_invoice']; ?></label>
				<input type="file" class="form-control" name="document_2">
			</div>
			<button type="submit" class="btn btn-primary btn-sm" name="bit_upload"><i class="fa fa-upload"></i> <?php echo $lang['btn_20']; ?></button>
		</form>
		<?php } ?>
	<?php } ?>
	
	
	<?php
} elseif($status == "7") {
?>
	<h3><?php echo $lang['email_verification']; ?></h3>
	<hr/>
	<?php if(idinfo($_SESSION['btc_uid'],"email_verified") == "1") { ?>
	<p><span class="text text-success"><i class="fa fa-check"></i> <?php echo $lang['your_email_was_verified']; ?></span></p>
	<?php } else { ?>
	<p><?php echo $lang['your_email_not_verified']; ?></p>
	<form action="" method="POST">
		<button type="submit" class="btn btn-primary btn-sm" name="bit_send_email"><i class="fa fa-reply"></i> <?php echo $lang['btn_19']; ?></button>
	</form>
	<?php } ?>

	
	<?php
} elseif($status == "8") {
?>
	
	<h3>Mobile verification</h3>
	<hr/>
	<?php if(idinfo($_SESSION['btc_uid'],"mobile_verified") == "1") { ?>
	<p><span class="text text-success"><i class="fa fa-check"></i> <?php echo $lang['your_mobile_verified']; ?></span></p>
	<?php } else { ?>
		<?php if(idinfo($_SESSION['btc_uid'],"mobile_number")) { ?>
		<p><?php echo $lang['click_button_sms_code']; ?> <b><?php echo idinfo($_SESSION['btc_uid'],"mobile_number"); ?></b></p>
		<form action="" method="POST">
			<div class="form-group">
				<label><?php echo $lang['enter_sms_code']; ?></label>
				<input type="text" class="form-control" name="sms_code">
			</div>
			<button type="submit" class="btn btn-primary btn-sm" name="bit_send_sms_code"><i class="fa fa-reply"></i> <?php echo $lang['btn_21']; ?></button> 
			<button type="submit" class="btn btn-primary btn-sm" name="bit_verify_sms_code"><i class="fa fa-check"></i> <?php echo $lang['btn_22']; ?></button>
		</form>
		<?php } else { ?>
		<form action="" method="POST">
			<div class="form-group">
				<label><?php echo $lang['your_mobile_number']; ?></label>
				<input type="text" class="form-control" name="mobile_number">
			</div>
			<button type="submit" class="btn btn-primary btn-sm" name="bit_add_number"><i class="fa fa-plus"></i> <?php echo $lang['btn_23']; ?></button>
		</form>
		<?php } ?>
	<?php } ?>
	
	<?php
} else {
	if($status == "9") {
		$update = $db->query("UPDATE btc_users SET status='3' WHERE id='$_SESSION[btc_uid]'");
	}	
}
?>
