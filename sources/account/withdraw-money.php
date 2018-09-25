
<h2><small><?php echo $lang['withdraw_money']; ?></small></h2>
<h3><small><?php echo $lang['withdraw_money_info']; ?></small></h3>
<br>
<?php
$query_ba = $db->query("SELECT * FROM btc_users_bank_account WHERE uid = '$_SESSION[btc_uid]' LIMIT 1");
$bank_account = $query_ba->fetch_assoc();

$total_money = get_user_money($_SESSION['btc_uid']);
if(isset($_POST['btc_transfer'])) {

    $amount = protect($_POST['amount']);
    $bank_holder_name = protect($_POST['bank_holder_name']);
    $bank_account_number = protect($_POST['bank_account_number']);
    $bank_swift = protect($_POST['bank_swift']);
    $bank_address = protect($_POST['bank_address']);
    $secret_pin = protect($_POST['secret_pin']);
    $secret_pin = md5($secret_pin);
    $time = time();
    if(empty($amount) or empty($bank_holder_name) or empty($bank_account_number) or empty($bank_swift) or empty($bank_address)) { 
        $data['status'] = 'error';
        echo error($lang['error_1']); 
    } elseif(!is_numeric($amount)) {
        echo error($lang['error_27']);
    } elseif(idinfo($_SESSION['btc_uid'],"secret_pin") && idinfo($_SESSION['btc_uid'],"secret_pin") !== $secret_pin) {
        echo error($lang['error_29']);
    } else {
        if($amount > $total_money) {
            echo error("$lang[error_44] <b>$total_money</b> USD."); 
        } else {
            $amount_minus = $amount * (-1);

            $query = "
                INSERT btc_users_money 
                (uid,transaction_type,status,amount,time,u_field_1,u_field_2,u_field_3,u_field_4) 
                VALUES 
                ('$_SESSION[btc_uid]','withdraw','0','$amount_minus','$time','$bank_holder_name','$bank_account_number','$bank_swift','$bank_address')";
            $insert = $db->query($query);
            $query = $db->query($sql);

            if ($bank_account) {
                $sql = "UPDATE btc_users_bank_account SET u_field_1='$bank_holder_name', u_field_2='$bank_account_number', u_field_3='$bank_swift', u_field_4='$bank_address', time='$time' WHERE id = '$bank_account[id]' LIMIT 1";
            } else {
                $sql = "INSERT INTO btc_users_bank_account (uid, u_field_1,u_field_2,u_field_3,u_field_4,time) VALUES ('$_SESSION[btc_uid]','$bank_holder_name','$bank_account_number','$bank_swift','$bank_address','$time')";
            }

            $q = $db->query($sql);

            echo success($lang['success_20']);
        }
    }
}
?>
<form action="" method="POST">
    <div class="form-group">
        <label><?php echo $lang['current_balance']; ?>: <?php echo $total_money; ?> USD</label>
    </div>
    <div class="form-group">
        <label><?php echo $lang['amount']; ?></label>
        <div class="input-group">
          <input type="text" class="form-control" name="amount" placeholder="0.0000000">
          <span class="input-group-addon" id="basic-addon2">USD</span>
        </div>
    </div>
    <?php if(idinfo($_SESSION['btc_uid'],"secret_pin")) { ?>
    <div class="form-group">
        <label><?php echo $lang['your_secret_pin']; ?></label>
        <input type="password" class="form-control" name="secret_pin">
    </div>
    <?php } ?>

    <div class="form-group">
        <label><?php echo $lang['bank_holder_name']; ?></label>
        <input type="text" class="form-control" name="bank_holder_name" value="<?php echo ($bank_account) ? $bank_account['u_field_1'] : '' ; ?>">
    </div>
    <div class="form-group">
        <label><?php echo $lang['bank_account_number']; ?></label>
        <input type="text" class="form-control" name="bank_account_number" value="<?php echo ($bank_account) ? $bank_account['u_field_2'] : '' ; ?>">
    </div>
    <div class="form-group">
        <label><?php echo $lang['bank_swift']; ?></label>
        <input type="text" class="form-control" name="bank_swift" value="<?php echo ($bank_account) ? $bank_account['u_field_3'] : '' ; ?>">
    </div>
    <div class="form-group">
        <label><?php echo $lang['bank_address']; ?></label>
        <input type="text" class="form-control" name="bank_address" value="<?php echo ($bank_account) ? $bank_account['u_field_4'] : '' ; ?>">
    </div>
    <button type="submit" class="btn btn-primary" name="btc_transfer"><?php echo $lang['withdraw_money']; ?></button>
</form>