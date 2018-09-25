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
include("../includes/rpc_settings.php");
include("../includes/functions.php");
//$settings['url'] = siteURL();
if(empty($rpc_host) or empty($rpc_port) or empty($rpc_user) or empty($rpc_pass)) {
	die("Please setup your Bitcoin RPC settings in <b>includes/rpc_settings.php</b>!");
}
$btcwallet = new Client($rpc_host, $rpc_port, $rpc_user, $rpc_pass);
include(getLanguage($settings['url'],null,2));
if(checkSession()) {
	$btcwaddresses = $btcwallet->getAddressList(idinfo($_SESSION['btc_uid'],"email"));
	foreach($btcwaddresses as $waddress) { 
																		$i=1;
																		
																		?>
																		<tr id="btc_address_<?php echo $row['id']; ?>">																			</td>
																			<td> <?php echo $waddress; ?> </td>
																			<td><?php echo formatBTC(convertToBTCFromSatoshi(getAddressBalance($waddress))); ?> BTC</td>
																			<td>
																				<a class="btn btn-circle btn-sm btn-icon btn-default" href="javascript:;" data-toggle="tooltip" data-placement="top" title="<?php echo $lang['btn_7']; ?>" onclick="btc_receive_to_address('<?php echo $waddress; ?>');"><i class="fa fa-arrow-circle-o-down" style="margin:0px;"></i></a>
																			</td>
																		</tr>
																		<?php
																		
																	}
}
?>