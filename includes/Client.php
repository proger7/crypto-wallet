
<?php
//To enable developer mode (no need for an RPC server, replace this file with the snipet at https://gist.github.com/d3e148deb5969c0e4b60 

class Client {
	private $uri;
	private $jsonrpc;

	function __construct($host, $port, $user, $pass)
	{
		$this->uri = "http://" . $user . ":" . $pass . "@" . $host . ":" . $port . "/";
		$this->jsonrpc = new jsonRPCClient($this->uri);
	}

	function getBalance($user_session)
	{
		return $this->jsonrpc->getbalance("eswallet(" . $user_session . ")", 6);
		//return 21;
	}
	
	function getPendingBalance($user_session)
	{
		return $this->jsonrpc->getbalance("eswallet(" . $user_session . ")", 0);
		//return 21;
	}
	
	function getAccountAddress($user_session)
	{
		return $this->jsonrpc->getaccountaddress("eswallet(" . $user_session . ")", 0);
		//return 21;
	}

       function getAddress($user_session)
        {
                return $this->jsonrpc->getaccountaddress("eswallet(" . $user_session . ")");
	}

	function getAddressBalance($address) {
		return $this->jsonrpc->getreceivedbyaddress($address,1);
	}
	
	function getAddressList($user_session)
	{
		return $this->jsonrpc->getaddressesbyaccount("eswallet(" . $user_session . ")");
		//return array("1test", "1test");
	}

	function getTransactionList($user_session)
	{
		return $this->jsonrpc->listtransactions("eswallet(" . $user_session . ")", 10);
	}
	
	function getAdminTransactionList()
	{
		return $this->jsonrpc->listtransactions(null,10);
	}
	
	function getTransactionsCount($user_session)
	{
		return $this->jsonrpc->listtransactions("eswallet(" . $user_session . ")");
	}
	
	function getAllTransactions($user_session,$count,$from)
	{
		return $this->jsonrpc->listtransactions("eswallet(" . $user_session . ")",$count,$from);
	}

	function getNewAddress($user_session)
	{
		return $this->jsonrpc->getnewaddress("eswallet(" . $user_session . ")");
		//return "1test";
	}

	function withdraw($user_session, $address, $amount)
	{
		return $this->jsonrpc->sendfrom("eswallet(" . $user_session . ")", $address, (float)$amount, 6);
		//return "ok wow";
	}
	
	function adminwithdraw($adminacc, $address, $amount)
	{
		return $this->jsonrpc->sendfrom($adminacc, $address, (float)$amount, 6);
		//return "ok wow";
	}
	
	function sendmany($user_session, $to)
	{
		return $this->jsonrpc->sendmany("eswallet(" . $user_session . ")", $to);
		//return "ok wow";
	}
	
	function settxfee($txfee)
	{
		return $this->jsonrpc->settxfee((float)$txfee);
		//return "ok wow";
	}
	
	function getaccountbyaddress($address)
	{
		return $this->jsonrpc->getaccount($address);
		//return "ok wow";
	}
	
	function rpc($scheme,$ip,$port,$rpcuser,$rpcpass,$command,$params=null){
		$url = $scheme.'://'.$ip.':'.$port.'/';
		$request = '{"jsonrpc": "1.0", "id":"BitcoinWallet_1_0", "method": "'.$command.'", "params": ['.$params.'] }';		

		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_BINARYTRANSFER,true);
		curl_setopt($ch, CURLOPT_USERPWD, "$rpcuser:$rpcpass");
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: text/plain'));
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
		$response = curl_exec($ch);
		$response = json_decode($response,true);
		$result = $response['result'];
		$error  = $response['error'];
		curl_close($ch);

        switch($command){

			case "validateaddress":				
				return ($result['isvalid']);
				break;
			case "walletpassphrase":				
				if( empty($result) && empty($error) ) {
					return true;
				} else {
					return '<span class="ui-state-error" style="padding-left:2px;">'.nl2br(htmlentities($response['error']['message'])).'</span>';
				}
				break;				
			default:
				if (!is_null($error) ) {
					return $response['error']['message'];
				} else {
					return $result;
				}
		}
		
	} // /rpc
	
	function getinfo($info,$server_ip,$server_port,$rpc_user,$rpc_pass)
	{
		$check_login = $this->rpc("http",$server_ip,$server_port,$rpc_user,$rpc_pass,'getwalletinfo');

		if ( !is_array($check_login) ) {
			die (' There was an error with your Log In parameters. Is your RPC Username and Password correct?');
		}
		return $check_login[$info];
	}
}
?>
