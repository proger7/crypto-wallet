<?php
ob_start();
session_start();
error_reporting(0);
include("../includes/config.php");
$db = new mysqli($CONF['host'], $CONF['user'], $CONF['pass'], $CONF['name']);
if ($db->connect_errno) {
    echo "Failed to connect to MySQL: (" . $db->connect_errno . ") " . $db->connect_error;
}
$db->set_charset("utf8");
$settingsQuery = $db->query("SELECT * FROM btc_settings ORDER BY id DESC LIMIT 1");
$settings = $settingsQuery->fetch_assoc();
include("../includes/block_io.php");
include("../includes/functions.php");
include(getLanguage($settings['url'],null,2));
if(checkSession()) {
$type = protect($_GET['type']);

if($type == "receive") {

} elseif($type == "new_address") {
?>
<form id="form_new_address">
	<p><?php echo $lang['this_modal_create_address']; ?></p>
	<div class="form-group">
		<label><?php echo $lang['label']; ?></label>
		<input type="text" class="form-control" name="label" placeholder="<?php echo $lang['label_info']; ?>">
	</div>
	<p><?php echo $lang['label_info_2']; ?></p>
	<button type="button" onclick="btc_submit_new_address();" class="btn btn-primary"><i class="fa fa-plus"></i> <?php echo $lang['btn_26']; ?></button>
</form>
<?php
} elseif($type == "send_from_address") {
$address_id = protect($_GET['address_id']);
$query = $db->query("SELECT * FROM btc_users_addresses WHERE uid='$_SESSION[btc_uid]' and id='$address_id'");
?>
	<?php if($query->num_rows>0) { $row = $query->fetch_assoc(); 
	$total = $row['available_balance'];
	$total = $total - 0.0008;
	$total = $total - $settings['withdrawal_comission'];
	if($total < 0) { $total = '0.0000'; }
	?>
		<div id="btc_send_from_address_results"></div>
		<div class="row">
			<div class="col-md-12">
				<form id="btc_from_send_bitcoins">
					<div class="form-group">
						<label><?php echo $lang['from_wallet_address']; ?></label>
						<input type="text" class="form-control" disabled value="<?php $expl = explode("_",$row['label']); echo $expl[2]; ?> - <?php echo $row['address']; ?>">
					</div>
					<div class="form-group">
						<label><?php echo $lang['to_wallet_address']; ?></label>
						<input type="text" class="form-control" name="to_address">
					</div>
					<div class="form-group">
						<label><?php echo $lang['amount']; ?></label>
						<input type="text" class="form-control" name="amount" placeholder="0.000000">
					</div>
					<?php if(idinfo($_SESSION['btc_uid'],"secret_pin")) { ?>
					<div class="form-group">
						<label><?php echo $lang['your_secret_pin']; ?></label>
						<input type="password" class="form-control" name="secret_pin">
					</div>
					<?php } ?>
					<button type="button" class="btn btn-primary" onclick="btc_send_bitcoins('<?php echo $row['address']; ?>');"><?php echo $lang['btn_6']; ?></button>
					<span class="pull-right">
						<?php echo $lang['error_30']; ?>: <span id="btc_total"><?php echo $total; ?></span> BTC
					</span>	
				</form>
			</div>
		</div>
		<?php } else { ?>
		<?php echo info($lang['info_7']); ?>
		<?php } ?>
<?php
} elseif($type == "receive_to_address") {
$address_id = protect($_GET['address_id']);
?>
		<div class="row">
			<div class="col-md-8">
				<form id="btc_generate_qr_code">
					<div class="form-group">
						<label><?php echo $lang['wallet_address']; ?></label>
						<input type="text" class="form-control" disabled value="<?php echo $address_id; ?>">
					</div>
					<div class="form-group">
						<label><?php echo $lang['amount']; ?></label>
						<input type="text" class="form-control" name="amount" placeholder="0.000000">
					</div>
					<button type="button" class="btn btn-primary" onclick="btc_generate_qr_code('<?php echo $row['address']; ?>');"><?php echo $lang['btn_27']; ?></button>
				</form>
			</div>	
			<div class="col-md-4">
				<center><div id="btc_qr_code"></div></center>
			</div>
		</div>
<?php
} elseif($type == "archive_address") {

} elseif($type == "unarchive_address") {

} elseif($type == "qr_code") {
	$address = protect($_GET['address']);
	$amount = protect($_POST['amount']);
	echo '<img src="https://chart.googleapis.com/chart?chs=150x150&cht=qr&chl=bitcoin:'.$address.'?amount='.$amount.'&choe=UTF-8">';
} else { }
}
?>