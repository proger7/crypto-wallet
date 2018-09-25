
					<h2><small><?php echo $lang['addresses']; ?></small> <span class="pull-right"><small><a href="javascript:void(0);" class="btn btn-default btn-sm" onclick="btc_new_address();"><i class="fa fa-plus"></i> <?php echo $lang['btn_5']; ?></a></small></span></h2>
							<table class="table">
								<thead>
									<tr>
										<th><?php echo $lang['label']; ?></th>
										<th><?php echo $lang['address']; ?></th>
										<th><?php echo $lang['balance']; ?></th>
										<th><?php echo $lang['action']; ?></th>
									</tr>
								</thead>
								<tbody id="btc_addresses">
									<?php
																	$query = $db->query("SELECT * FROM btc_users_addresses WHERE uid='$_SESSION[btc_uid]' ORDER BY id");
																	if($query->num_rows>0) { 
																		$i=1;
																		while($row = $query->fetch_assoc()) {
																		?>
																		<tr id="btc_addresss_<?php echo $row['id']; ?>">
																			<td> <?php $exp = 'usr_'.$_SESSION[btc_uid].'_';
																					$expl = explode($exp,$row['label']); echo $expl[1]; ?> </td>
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
																		echo info($lang[info_2]); 
																		echo '</td></tr>';
																	}
																	?>
								</tbody>
							</table>