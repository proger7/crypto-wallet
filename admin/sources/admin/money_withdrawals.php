<?php
$id = protect($_GET['id']);
$b = protect($_GET['b']);

if($b == "explore") {
    $query = $db->query("SELECT * FROM btc_users_money WHERE id='$id'");
    if($query->num_rows==0) { header("Location; ./?a=money_withdrawals"); }
    $row = $query->fetch_assoc();

    $query_ba = $db->query("SELECT * FROM btc_users_bank_account WHERE uid = '$row[uid]' LIMIT 1");
    $bank_account = $query_ba->fetch_assoc();

    $withdraw_amount = ($row['amount']*(-1));

    $user_money = get_user_money($row['uid']);
?>
    <ol class="breadcrumb">
        <li><a href="./"><?php echo $settings['name']; ?> Administrator</a></li>
        <li><a href="./?a=money_withdrawals">Money withdrawals</a></li>
        <li class="active">Explore</li>
    </ol>

    <div class="panel panel-default">
        <div class="panel-heading">Explore</div>
        <div class="panel-body">
        <?php
            if(isset($_POST['btn_do_trancastion_confirm'])) {
                if ($user_money < $withdraw_amount) {
                    echo error("Users balance is to small to make withdraw.");
                } else {
                    $to_address = idinfo($row['uid'],"email");
                    echo success("You successfully confirmed withdraw <b>$withdraw_amount USD</b> to user <b>$to_address</b>.");
                    
                    $update = $db->query("UPDATE btc_users_money SET status='1' WHERE id='$row[id]'");
                    $query = $db->query("SELECT * FROM btc_users_money WHERE id='$id'");
                    $row = $query->fetch_assoc();   
                }
            }
            
            if(isset($_POST['btn_do_trancastion'])) {
        ?>
                <form action="" method="POST">
                <div class="alert alert-info">
                    <h3><small>Are you sure you want confirm that <b><?php echo $withdraw_amount; ?> USD</b> will be withdrawn to user <?php echo idinfo($row['uid'],"email"); ?></b>?</small></h3>
                    <button type="submit" class="btn btn-success" name="btn_do_trancastion_confirm"><i class="fa fa-check"></i> Yes</button> 
                    <a href="" class="btn btn-danger"><i class="fa fa-times"></i> No</a>
                </div>
                </form>
        <?php
            }
            
            if(isset($_POST['btn_cancel_transaction'])) {
                $status = protect($_POST['status']);
                $update = $db->query("UPDATE btc_users_money SET status='2' WHERE id='$row[id]'");
                $query = $db->query("SELECT * FROM btc_users_money WHERE id='$id'");
                $row = $query->fetch_assoc();   
                echo success("Withdraw transaction request was canceled.");
            }
            ?>
            <div class="row">
                <?php if($row['status'] == "0") { ?>
                <div class="col-md-12">
                    <div class="pull-right">
                        <form action="" method="POST">
                            <button type="submit" class="btn btn-success" name="btn_do_trancastion"><i class="fa fa-check"></i> Confirm withdraw</button>
                            <button type="submit" class="btn btn-danger" name="btn_cancel_transaction"><i class="fa fa-times"></i> Cancel transaction</button>
                        </form>
                    </div>
                </div>
                <?php } ?>
                <div class="col-md-6">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <td><h3><small>Trade info</small></h3></td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><b>Order ID:</b> <span class="pull-right"><?php echo $row['id']; ?></span></td>
                            </tr>
                            <tr>
                                <td><b>Trade type:</b> <span class="pull-right">User withdraws money</span></td>
                            </tr>
                            <tr>
                                <td><b>Amount :</b> <span class="pull-right"><?php echo $withdraw_amount; ?> USD</span></td>
                            </tr>
                            <tr>
                                <td><b>Available balance :</b> <span class="pull-right"><?php echo $user_money; ?> USD</span></td>
                            </tr>
                            <tr>
                                <td><b>Status</b> <span class="pull-right">
                                <?php
                                if($row['status'] == "0") { 
                                    $status = '<span class="label label-info">Awaiting</span>';
                                } elseif($row['status'] == "1") {
                                    $status = '<span class="label label-success">Processed</span>';
                                } elseif($row['status'] == "2") {
                                    $status = '<span class="label label-danger">Canceled</span>';
                                } else { $status = '<span class="label label-defualt">Unknown</span>'; }
                                echo $status;
                                ?>
                                </span></td>
                        </tbody>
                    </table>
                </div>
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
                            <tr>
                                <td><b>Bank Account Holder Name:</b> <span class="pull-right"><?php echo $bank_account['u_field_1']; ?></span></td>
                            </tr>
                            <tr>
                                <td><b>Bank Account Number/IBAN:</b> <span class="pull-right"><?php echo $bank_account['u_field_2']; ?></span></td>
                            </tr>
                            <tr>
                                <td><b>Bank Swift Code:</b> <span class="pull-right"><?php echo $bank_account['u_field_3']; ?></span></td>
                            </tr>
                            <tr>
                                <td><b>Bank Country,City,Address:</b> <span class="pull-right"><?php echo $bank_account['u_field_4']; ?></span></td>
                            </tr>
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
    <li class="active">Money withdrawals</li>
</ol>

<div class="panel panel-default">
    <div class="panel-heading">
        Money withdrawals
    </div>
    <div class="panel-body">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th width="20%">User</th>
                    <th width="20%">Amount</th>
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
    $statement = "btc_users_money";
    $query = $db->query("SELECT * FROM {$statement} WHERE transaction_type = 'withdraw' ORDER BY id DESC LIMIT {$startpoint} , {$limit}");
    if($query->num_rows>0) {
        while($row = $query->fetch_assoc()) {
            if($row['status'] == "0") { 
                $status = '<span class="label label-info">Awaiting</span>';
            } elseif($row['status'] == "1") {
                $status = '<span class="label label-success">Processed</span>';
            } elseif($row['status'] == "2") {
                $status = '<span class="label label-danger">Canceled</span>';
            } else { $status = '<span class="label label-defualt">Unknown</span>'; }
            ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><a href="./?a=users&b=edit&id=<?php echo $row['uid']; ?>"><?php echo idinfo($row['uid'],"email"); ?></a></td>
                <td><?php echo ($row[amount]*(-1)); ?> USD</td>
                <td><?php echo $status; ?></td>
                <td>
                    <a href="./?a=money_withdrawals&b=explore&id=<?php echo $row['id']; ?>" title="Explore"><i class="fa fa-search"></i> Explore</a>
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
    $ver = "./?a=money_withdrawals";
    if(admin_pagination($statement,$ver,$limit,$page,'?',"WHERE transaction_type = 'deposit'")) {
        echo admin_pagination($statement,$ver,$limit,$page,'?',"WHERE transaction_type = 'deposit'");
    }
?>
    </div>
</div>
<?php
}
?>