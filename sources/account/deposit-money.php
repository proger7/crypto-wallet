
<h2><small><?php echo $lang['deposit_money']; ?></small></h2>
<h3><small><?php echo $lang['deposit_money_info']; ?> <?php if($settings['process_time_to_buy'] == "1") { echo $lang['1_hour']; } else { echo $settings['process_time_to_buy']." $lang[hours]."; } ?></small></h3>
<br>
<?php
if(isset($_POST['btc_buy'])) {
    $waddress = protect($_POST['waddress']);
    $payment_method = protect($_POST['payment_method']);
    $amount_send = protect($_POST['amount_send']);
    $secret_pin = protect($_POST['secret_pin']);
    $u_field_1 = protect($_POST['u_field_1']);
    $u_field_2 = protect($_POST['u_field_2']);
    $u_field_3 = protect($_POST['u_field_3']);
    $u_field_4 = protect($_POST['u_field_4']);
    $u_field_5 = protect($_POST['u_field_5']);
    $ext = array('jpg','jpeg','pdf','png'); 
    $file_ext = end(explode('.',$_FILES['uploadFile']['name'])); 
    $file_ext = strtolower($file_ext); 
    $time = time();
    $totalbtc = addressinfo($waddress,"available_balance");
    $addr_lid = addressinfo($waddress,"lid");
    $addrid = 1; //addressinfo($waddress,"id");
    $totalbtc = $totalbtc - 0.0004;
    $time = time();
    if(empty($payment_method)) { echo error($lang['error_1']); }
    elseif(!is_numeric($amount_send)) { echo error($lang['error_9']); }
    elseif(!$_FILES['uploadFile']['name']) { echo error($lang['error_10']); }
    elseif(!in_array($file_ext,$ext)) { echo error($lang['error_11']); }
    else {
        $path = 'uploads/attachments/'.$_SESSION[btc_uid].'_'.time().'_money.'.$file_ext;
        $upload = move_uploaded_file($_FILES['uploadFile']['tmp_name'], $path);

        // var_dump($_FILES['uploadFile']['tmp_name'], $path, $upload);

        $query = "
            INSERT btc_users_money 
            (uid,transaction_type,status,amount,gateway_id,time,u_field_1,u_field_2,u_field_3,u_field_4,u_field_5,attachment) 
            VALUES 
            ('$_SESSION[btc_uid]','deposit','0','$amount_send','$payment_method','$time','$u_field_1','$u_field_2','$u_field_3','$u_field_4','$u_field_5','$path')";
        $insert = $db->query($query);
        $success_18 = $lang['success_18'];
        echo success($success_18);

        // var_dump($db->info);
    }
}
?>
<form action="" method="POST" enctype="multipart/form-data">
    <div class="form-group">
        <label><?php echo $lang['select_payment_method']; ?></label>
        <select class="form-control" name="payment_method" onchange="btc_get_payment_data(this.value);">
            <?php
            $gateways = $db->query("SELECT * FROM btc_gateways WHERE allow_send='1' ORDER BY id");
            if($gateways->num_rows>0) {
                echo '<option></option>';
                while($g = $gateways->fetch_assoc()) {
                    echo '<option value="'.$g[id].'">'.$g[name].' '.$g[currency].'</option>';
                }
            } else {
                echo '<option>'.$lang[info_4].'</option>'; 
            }
            ?>
        </select>
        <small><?php echo $lang['select_from_where_to_pay']; ?></small>
    </div>
    <div class="form-group">
        <label><?php echo $lang['amount']; ?></label>
        <div class="input-group">
          <input type="text" class="form-control" name="amount_send" onkeyup="calculate_to_btc(this.value);" onkeydown="calculate_to_btc(this.value);" placeholder="0.00">
          <span class="input-group-addon" id="currency"></span>
        </div>
    </div>
    <div id="btc_account_fields"></div>
    <div class="form-group">
        <label><?php echo $lang['attach_payment_proof']; ?></label>
        <input type="file" name="uploadFile" class="form-control">
    </div>
    <input type="hidden" id="btc_price" value="">
    <button type="submit" class="btn btn-primary" name="btc_buy"><?php echo $lang['btn_6']; ?></button>
    <span class="pull-right" id="fee_text"></span>
</form>
