<?php
$id = protect($_GET['id']);
$b = protect($_GET['b']);

if($b == "explore") {
    $query = $db->query("SELECT * FROM btc_transfers WHERE id='$id'");
    if($query->num_rows==0) { header("Location; ./?a=transfers"); }
    $row = $query->fetch_assoc();
    ?>
    <ol class="breadcrumb">
        <li><a href="./"><?php echo $settings['name']; ?> Administrator</a></li>
        <li><a href="./?a=transfers">Transfers</a></li>
        <li class="active">Explore</li>
    </ol>

    <div class="panel panel-default">
        <div class="panel-heading">
            Explore
        </div>
        <div class="panel-body">
        <?php
            if(isset($_POST['btn_do_transfer_confirm'])) {
                $txfee = $btcwallet->getinfo("paytxfee",$rpc_host,$rpc_port,$rpc_user,$rpc_pass);
                $to_address = $row['recipient_address'];
                $amount = $row['btc_amount'];

                $total = (float)get_user_balance_btc($row['uid']);
                $total = $total - (float)$txfee;
                $total = $total - (float)$settings['withdrawal_comission'];
                $total = number_format($total,8);
                if($total < 0) { $total = '0.0000'; }
                if($amount > $total) {
                    echo error("$lang[error_30] <b>$total</b> BTC."); 
                } else {
                    $to[$to_address] = (float)$amount;
                    $to[$fee_address] = (float)$settings['withdrawal_comission'];
                    $doit = $btcwallet->sendmany($sell_address, $to);

                    $new_btc_balance = $total - $amount;
                    $query = "UPDATE btc_users SET btc_balance = '$new_btc_balance' WHERE id = '$row[uid]' LIMIT 1";
                    $update = $db->query($query);

                    $update = $db->query("UPDATE btc_transfers SET status='1' WHERE id='$row[id]'");
                    $query = $db->query("SELECT * FROM btc_transfers WHERE id='$id'");
                    $row = $query->fetch_assoc();

                    echo success("You successfully transfered <b>$row[btc_amount] BTC</b> to address: <b>$row[recipient_address]</b>.");
                }
            }
            
            if(isset($_POST['btn_do_transfer'])) {
        ?>
                <form action="" method="POST">
                <div class="alert alert-info">
                    <h3><small>Are you sure you want confirm that <b><?php echo $row['btc_amount']; ?> BTC</b> will be transfered to address: <?php echo $row['recipient_address']; ?></b>?</small></h3>
                    <button type="submit" class="btn btn-success" name="btn_do_transfer_confirm"><i class="fa fa-check"></i> Yes</button> 
                    <a href="" class="btn btn-danger"><i class="fa fa-times"></i> No</a>
                </div>
                </form>
        <?php
            }
            
            if(isset($_POST['btn_cancel_transaction'])) {
                $status = protect($_POST['status']);
                $update = $db->query("UPDATE btc_transfers SET status='2' WHERE id='$row[id]'");
                $query = $db->query("SELECT * FROM btc_transfers WHERE id='$id'");
                $row = $query->fetch_assoc();   
                echo success("Transfer request was canceled.");
            }
            ?>
            <div class="row">
                <?php if($row['status'] == "0") { ?>
                <div class="col-md-12">
                    <div class="pull-right">
                        <form action="" method="POST">
                            <button type="submit" class="btn btn-success" name="btn_do_transfer"><i class="fa fa-check"></i> Confirm transfer</button>
                            <button type="submit" class="btn btn-danger" name="btn_cancel_transaction"><i class="fa fa-times"></i> Cancel transfer</button>
                        </form>
                    </div>
                </div>
                <?php } ?>
                <div class="col-md-6">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <td><h3><small>User info</small></h3></td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><b>User</b> <span class="pull-right"><a href="./?a=users&b=edit&id=<?php echo $row['uid']; ?>"><?php echo idinfo($row['uid'],"email"); ?></a></span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-md-6">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <td><h3><small>Trade info</small></h3></td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><b>Transfer ID:</b> <span class="pull-right"><?php echo $row['id']; ?></span></td>
                            </tr>
                            <tr>
                                <td><b>Trade type:</b> <span class="pull-right">User transfers BTC</span></td>
                            </tr>
                            <tr>
                                <td><b>Amount :</b> <span class="pull-right"><?php echo $row['btc_amount']; ?> BTC</span></td>
                            </tr>
                            <tr>
                                <td><b>Recipient address :</b> <span class="pull-right"><?php echo $row['recipient_address']; ?></span></td>
                            </tr>
                            <tr>
                                <td><b>Status</b> <span class="pull-right">
                                <?php
                                if($row['status'] == "0") { 
                                    $status = '<span class="label label-info">Awaiting</span>';
                                } elseif($row['status'] == "1") {
                                    $status = '<span class="label label-success">Transfered</span>';
                                } elseif($row['status'] == "2") {
                                    $status = '<span class="label label-danger">Canceled</span>';
                                } else { $status = '<span class="label label-defualt">Unknown</span>'; }
                                echo $status;
                                ?>
                                </span></td>
                        </tbody>
                    </table>
                </div>
            </div>
        
        </div>
    </div>
    <?php
} else {
?>
<ol class="breadcrumb">
    <li><a href="./"><?php echo $settings['name']; ?> Administrator</a></li>
    <li class="active">Transfers</li>
</ol>

<div class="panel panel-default">
    <div class="panel-heading">
        Transfers
    </div>
    <div class="panel-body">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Transfer ID</th>
                    <th width="40%">User</th>
                    <th width="30%">Amount</th>
                    <th width="15%">Status</th>
                    <th width="10%">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $page = (int) (!isset($_GET["page"]) ? 1 : $_GET["page"]);
                $limit = 20;
                $startpoint = ($page * $limit) - $limit;
                if($page == 1) {
                    $i = 1;
                } else {
                    $i = $page * $limit;
                }
                $statement = "btc_transfers";
                $query = $db->query("SELECT * FROM {$statement} ORDER BY id DESC LIMIT {$startpoint} , {$limit}");
                if($query->num_rows>0) {
                    while($row = $query->fetch_assoc()) {
                        if($row['status'] == "0") { 
                            $status = '<span class="label label-info">Awaiting</span>';
                        } elseif($row['status'] == "1") {
                            $status = '<span class="label label-success">Processed</span>';
                        } elseif($row['status'] == "2") {
                            $status = '<span class="label label-danger">Canceled</span>';
                        } else { $status = '<span class="label label-defualt">Unknown</span>'; }
                        $payment_method = gatewayinfo($row['gateway_id'],"name");
                        $currency = gatewayinfo($row['gateway_id'],"currency");
                        $payment_method = $payment_method.' '.$currency;
                        if($row['type'] == "1") { $type = 'Buy Bitcoins'; } elseif($row['type'] == "2") { $type = 'Sell Bitcoins'; } else { $type = 'Unknown'; }
                        ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><a href="./?a=users&b=edit&id=<?php echo $row['uid']; ?>"><?php echo idinfo($row['uid'],"email"); ?></a></td>
                            <td><?php echo $row['btc_amount']; ?> BTC</td>
                            <td><?php echo $status; ?></td>
                            <td>
                                <a href="./?a=transfers&b=explore&id=<?php echo $row['id']; ?>" title="Explore"><i class="fa fa-search"></i> Explore</a>
                            </td>
                        </tr>
                        <?php
                    }
                } else {
                    echo '<tr><td colspan="6">Still no have trade requests yet.</td></tr>';
                }
                ?>
            </tbody>
        </table>
        <?php
        $ver = "./?a=transfers";
        if(admin_pagination($statement,$ver,$limit,$page)) {
            echo admin_pagination($statement,$ver,$limit,$page);
        }
        ?>
    </div>
</div>
<?php
}
?>