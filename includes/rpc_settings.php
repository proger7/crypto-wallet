<?php
include('jsonRPCClient.php');
include('Client.php');
//include('User.php');

// function by zelles to modify the number to bitcoin format ex. 0.00120000
function satoshitize($satoshitize) {
   return sprintf("%.8f", $satoshitize);
}

// function by zelles to trim trailing zeroes and decimal if need
function satoshitrim($satoshitrim) {
   return rtrim(rtrim($satoshitrim, "0"), ".");
}

function convertToBTCFromSatoshi($value) {
    $BTC = $value / 100000000 ;
    return $BTC;
}
function formatBTC($value) {
    $value = sprintf('%.8f', $value);
    $value = rtrim($value, '0');
    return $value;
}

$rpc_host = "172.104.240.48";
$rpc_port = "8332";
$rpc_user = "anspot";
$rpc_pass = "2666df3307327d5fcc35225a91167f939ccd7c9bd5cabd24d230ddf6c646ab14";

// fee_address is generated with: bitcoin-cli getnewaddress btccore@anspot.com
$fee_address = '1K9WBXbFj9jKtoEV3iphe4qwcVuzZpYgMY'; // enter here your Bitcoin address to receive fees. which you are setuped in Admin Panel -> Bitcoin Settings.
$sell_address = 'btccore@anspot.com'; // enter here your Bitcoin address where will receive Bitcoins when client/customer sell bitcoin to you (Use local address from your Bitcoin Core)
$buy_address = 'btccore@anspot.com'; // enter here your Bitcoin address from which you will transfer bitcoins to client/customer addresses when they buy from you (Use local address from your Bitcoin core)


