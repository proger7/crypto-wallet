<?php
function emailsys_new_user($email,$password,$email_hash) {
	global $db, $settings;
	$to = $email;
	$subject = '['.$settings[name].'] Account verification';
	$headers = "From: " . strip_tags($settings['infoemail']) . "\r\n";
	$headers .= "Reply-To: ". strip_tags($settings['infoemail']) . "\r\n";
	$headers .= "MIME-Version: 1.0\r\n";
	$headers .= "Content-Type: text/html; charset=UTF-8\r\n";
	$message .= '
<style type="text/css">
.table {
	border:1px solid #c1c1c1;
	-webkit-border-radius: 5px;
-moz-border-radius: 5px;
border-radius: 5px;
padding:10px;
}
</style>
<table border="0" width="600px" align="center" class="table">
	<tr>
		<td><img src="'.$settings[url].'assets/img/login-invert.png"><br><br></td>
	</tr>
		<td>
			<b>Your account was created successfully.</b><br><br>
			Your email address: '.$email.'<br/>
			Your password: '.$password.'<br/>
			<br>
			To unlock your '.$settings[name].' account, need to activate it from the following link:<br/>
			<a href="'.$settings[url].'email/verification/'.$email_hash.'">'.$settings[url].'email/verification/'.$email_hash.'</a>
		</td>
	</tr>
</table>';
	$mail = mail($to, $subject, $message, $headers);
	if($mail) {
		return true;
	} else {
		return false;
	}
}

function emailsys_email_verify($email,$email_hash) {
	global $db, $settings;
	$to = $email;
	$subject = '['.$settings[name].'] Account verification';
	$headers = "From: " . strip_tags($settings['infoemail']) . "\r\n";
	$headers .= "Reply-To: ". strip_tags($settings['infoemail']) . "\r\n";
	$headers .= "MIME-Version: 1.0\r\n";
	$headers .= "Content-Type: text/html; charset=UTF-8\r\n";
	$message .= '
<style type="text/css">
.table {
	border:1px solid #c1c1c1;
	-webkit-border-radius: 5px;
-moz-border-radius: 5px;
border-radius: 5px;
padding:10px;
}
</style>
<table border="0" width="600px" align="center" class="table">
	<tr>
		<td><img src="'.$settings[url].'assets/img/login-invert.png"><br><br></td>
	</tr>
		<td>
			To unlock your '.$settings[name].' account, need to activate it from the following link:<br/>
			<a href="'.$settings[url].'email/verification/'.$email_hash.'">'.$settings[url].'email/verification/'.$email_hash.'</a>
		</td>
	</tr>
</table>';
	$mail = mail($to, $subject, $message, $headers);
	if($mail) {
		return true;
	} else {
		return false;
	}
}

function emailsys_reset_password($email,$email_hash) {
	global $db, $settings;
	$to = $email;
	$subject = '['.$settings[name].'] Reset password request';
	$headers = "From: " . strip_tags($settings['infoemail']) . "\r\n";
	$headers .= "Reply-To: ". strip_tags($settings['infoemail']) . "\r\n";
	$headers .= "MIME-Version: 1.0\r\n";
	$headers .= "Content-Type: text/html; charset=UTF-8\r\n";
	$message .= '
<style type="text/css">
.table {
	border:1px solid #c1c1c1;
	-webkit-border-radius: 5px;
-moz-border-radius: 5px;
border-radius: 5px;
padding:10px;
}
</style>
<table border="0" width="600px" align="center" class="table">
	<tr>
		<td><img src="'.$settings[url].'assets/img/login-invert.png"><br><br></td>
	</tr>
		<td>
			<b>We receive request to change your account password.</b><br><br>
			Use following link to change your password:<br/>
			<a href="'.$settings[url].'password/change/'.$email_hash.'">'.$settings[url].'password/change/'.$email_hash.'</a><br><br>
			If request not sent from you, just ignore it.
		</td>
	</tr>
</table>';
	$mail = mail($to, $subject, $message, $headers);
	if($mail) {
		return true;
	} else {
		return false;
	}
}

function emailsys_request_bitcoins($waddress,$fromemail,$toemail,$amount,$note) {
	global $db, $settings;
	$to = $toemail;
	$btcaddr = 'bitcoin:'.$waddress.'?amount='.$amount;
	$subject = '['.$settings[name].'] Payment Request';
	$headers = "From: " . strip_tags($settings['infoemail']) . "\r\n";
	$headers .= "Reply-To: ". strip_tags($settings['infoemail']) . "\r\n";
	$headers .= "MIME-Version: 1.0\r\n";
	$headers .= "Content-Type: text/html; charset=UTF-8\r\n";
	$message .= '
<style type="text/css">
.table {
	border:1px solid #c1c1c1;
	-webkit-border-radius: 5px;
-moz-border-radius: 5px;
border-radius: 5px;
padding:10px;
}
</style>
<table border="0" width="600px" align="center" class="table">
	<tr>
		<td><img src="'.$settings[url].'assets/img/login-invert.png"><br><br></td>
	</tr>
		<td>
			<center>
				<b>'.$fromemail.'</b> request <b>'.$amount.' BTC</b> from you.
				<br><br>
				<img src="https://chart.googleapis.com/chart?chs=150x150&cht=qr&chl='.$btcaddr.'&choe=UTF-8"><br>
				Bitcoin address: <b>'.$waddress.'</b><br/>
				Note: <b>'.$note.'</b>
			</center>
		</td>
	</tr>
</table>';
	$mail = mail($to, $subject, $message, $headers);
	if($mail) {
		return true;
	} else {
		return false;
	}
}
?>