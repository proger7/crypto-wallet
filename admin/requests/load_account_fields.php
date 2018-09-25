<?php
ob_start();
session_start();
error_reporting(0);
include("../../includes/config.php");
$db = new mysqli($CONF['host'], $CONF['user'], $CONF['pass'], $CONF['name']);
if ($db->connect_errno) {
    echo "Failed to connect to MySQL: (" . $db->connect_errno . ") " . $db->connect_error;
}
$db->set_charset("utf8");
$settingsQuery = $db->query("SELECT * FROM btc_settings ORDER BY id DESC LIMIT 1");
$settings = $settingsQuery->fetch_assoc();
include("../../includes/functions.php");
//include(getLanguage($settings['url'],null,2));
$gateway = protect($_GET['gateway']);
if($gateway == "Wire Transfer") {
			echo '<div class="form-group">
								<label>Your Bank Name <span class="right">(for '.$gateway.' transfer)</span></label>
								<input type="text" class="form-control" name="a_field_1">
							</div>
							<div class="form-group">
								<label>Your Bank Country,City,Address <span class="right">(for '.$gateway.' transfer)</span></label>
								<input type="text" class="form-control" name="a_field_2">
							</div><div class="form-group">
								<label>Your Bank Account Holder Name <span class="right">(for '.$gateway.' transfer)</span></label>
								<input type="text" class="form-control" name="a_field_3">
							</div><div class="form-group">
								<label>Your Bank Account Number/IBAN <span class="right">(for '.$gateway.' transfer)</span></label>
								<input type="text" class="form-control" name="a_field_4">
							</div><div class="form-group">
								<label>Your Bank Swift Code <span class="right">(for '.$gateway.' transfer)</span></label>
								<input type="text" class="form-control" name="a_field_5">
							</div>';
		} elseif($gateway == "Credit Card") { echo '<input type="hidden" name="a_field_1" value="creditcard">'; 
		} elseif($gateway == "Western Union" or $gateway == "Moneygram") {
			echo '<div class="form-group">
								<label>Your name <span class="right">(for '.$gateway.' transfer)</span></label>
								<input type="text" class="form-control" name="a_field_1">
							</div>
							<div class="form-group">
								<label>Your location <span class="right">(for '.$gateway.' transfer)</span></label>
								<input type="text" class="form-control" name="a_fa_field_2">
							</div>';
		} else {
			echo  '<div class="form-group">
								<label>Your '.$gateway.' account</label>
								<input type="text" class="form-control" name="a_field_1">
							</div>';
		}
?>