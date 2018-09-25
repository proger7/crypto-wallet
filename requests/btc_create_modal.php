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
if($type == "new_address") {
?>
<div class="modal fade" id="modal_new_address" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><i class="fa fa-plus"></i> <?php echo $lang['new_address']; ?></h4>
      </div>
      <div class="modal-body">
        <div id="html_new_address_results"></div>
		<div id="html_new_address_form"></div>
      </div>
    </div>
  </div>
</div>
<?php
} elseif($type == "send_from_address") {
?>
<div class="modal fade" id="modal_send_from_address" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><i class="fa fa-arrow-circle-o-up"></i> <?php echo $lang['send_bitcoins']; ?></h4>
      </div>
      <div class="modal-body" id="html_send_from_address">
		
      </div>
    </div>
  </div>
</div>
<?php
} elseif($type == "receive_to_address") {
?>
<div class="modal fade" id="modal_receive_to_address" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><i class="fa fa-arrow-circle-o-down"></i> <?php echo $lang['receive_bitcoins']; ?></h4>
      </div>
      <div class="modal-body" id="html_receive_to_address">
		
      </div>
    </div>
  </div>
</div>
<?php
} elseif($type == "archive_address") {

} elseif($type == "unarchive_address") {

} else { }
}
?>