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
$query = $db->query("SELECT * FROM btc_users_addresses WHERE uid='$_SESSION[btc_uid]' ORDER BY id");
																	if($query->num_rows>0) { 
																		$i=1;
																		while($row = $query->fetch_assoc()) {
																		?>
																		
																		<tr id="btc_addresss_<?php echo $row['id']; ?>">
																			<td> <?php $exp = 'usr_'.$_SESSION[btc_uid].'_';
																					$expl = explode($exp,$row['label']); echo $expl[1]; ?> </td>																			</td>
																			<td> <?php echo $row['address']; ?> </td>
																			<td> <?php echo $row['available_balance']; ?> BTC </td>
																			<td>
																				 <a class="btn btn-circle btn-sm btn-icon btn-default" href="javascript:;" data-toggle="tooltip" data-placement="top" title="<?php echo $lang['btn_6']; ?>" onclick="btc_send_from_address('<?php echo $row['id']; ?>');"><i class="fa fa-arrow-circle-o-up" style="margin:0px;"></i></a>
																				<a class="btn btn-circle btn-sm btn-icon btn-default" href="javascript:;" data-toggle="tooltip" data-placement="top" title="<?php echo $lang['btn_7']; ?>" onclick="btc_receive_to_address('<?php echo $row['id']; ?>');"><i class="fa fa-arrow-circle-o-down" style="margin:0px;"></i></a> 
																				<?php if($row['archived'] == "1") { ?>
																				<a class="btn btn-circle btn-sm btn-icon btn-default" href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="<?php echo $lang['btn_8']; ?>" onclick="btc_unarchive_address('<?php echo $row['id']; ?>');"><i class="fa fa-archive" style="margin:0px;"></i></a>
																				<?php } else { ?>
																				<a class="btn btn-circle btn-sm btn-icon btn-default" href="javascript:;" data-toggle="tooltip" data-placement="top" title="<?php echo $lang['btn_9']; ?>" onclick="btc_archive_address('<?php echo $row['id']; ?>');"><i class="fa fa-archive" style="margin:0px;"></i></a>
																				<?php } ?>
																				<a class="btn btn-circle btn-sm btn-icon btn-default" data-toggle="tooltip" data-placement="top" title="<?php echo $lang['btn_10']; ?>" href="<?php echo $settings['url']; ?>account/transactions_by_address/<?php echo $row['address']; ?>"><i class="fa fa-bars" style="margin:0px;"></i></a> 
																			</td>
																		</tr>
																		<?php
																		}
																	} else {
																		echo '<tr><td colspan="4">';
																		echo info($lang['info_2']); 
																		echo '</td></tr>'; 
																	}
}
?>