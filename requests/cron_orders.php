<?php
error_reporting(0);
include("../includes/config.php");
$db = new mysqli($CONF['host'], $CONF['user'], $CONF['pass'], $CONF['name']);
if ($db->connect_errno) {
  echo "Failed to connect to MySQL: (" . $db->connect_errno . ") " . $db->connect_error;
}
$db->set_charset("utf8");
$settingsQuery = $db->query("SELECT * FROM btc_settings ORDER BY id DESC LIMIT 1");
$settings = $settingsQuery->fetch_assoc();
include("../includes/functions.php");

$buy_price = btc_buy_price(true);
$sell_price = btc_sell_price(true);

$query = $db->query('SELECT * FROM btc_orders WHERE status = 0 ORDER BY id ASC');

while($row = $query->fetch_assoc()) {
  if ($row['transaction_type'] == 'buy_btc') {
    $amount_minus = $row['amount'] * (-1);
    $time = time();
    $amount_receive = $row['amount'] / $buy_price;
    
    if (($buy_price <= $row['target_price'] && $row['order_type'] == 'limit') || ($buy_price >= $row['target_price'] && $row['order_type'] == 'stop')) {
      $query = "INSERT btc_users_money (uid,transaction_type,status,amount,time) VALUES ('$row[uid]','buy_btc','1','$amount_minus','$time')";
      $insert = $db->query($query);

      $current_btc_balance = get_user_balance_btc($row['uid']);
      $new_btc_balance = $current_btc_balance + $amount_receive;

      $query = "UPDATE btc_users SET btc_balance = '$new_btc_balance' WHERE id = '$row[uid]' LIMIT 1";
      $update = $db->query($query);
    }
  } else if ($row['transaction_type'] == 'sell_btc') {
    $amount_receive = $row['amount'] * $sell_price;
    $time = time();
    $amount_send = $row['amount'];
    
    if (($sell_price >= $row['target_price'] && $row['order_type'] == 'limit') || ($sell_price <= $row['target_price'] && $row['order_type'] == 'stop')) {
      $query = "INSERT btc_users_money (uid,transaction_type,status,amount,time) VALUES ('$row[uid]','buy_btc','1','$amount_receive','$time')";
      $insert = $db->query($query);

      $current_btc_balance = get_user_balance_btc($row['uid']);
      $new_btc_balance = $current_btc_balance - $amount_send;

      $query = "UPDATE btc_users SET btc_balance = '$new_btc_balance' WHERE id = '$row[uid]' LIMIT 1";
      $update = $db->query($query);
    }
  }
}