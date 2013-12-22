<?php 
 
tmn_refill('77001272256594',310);

function tmn_refill($truemoney_password, $user_id) 
{ 
	if(function_exists('curl_init')) 
	{ 
		$website = 'www.vdomax.com/payment';
		$curl = curl_init("https://www.tmpay.net/TPG/backend.php?merchant_id=YS13121022&password=" . $truemoney_password . "&resp_url=http://".$website."/tmpay/tmpay_result.php?user_id=".$user_id); 

		curl_setopt($curl, CURLOPT_TIMEOUT, 10); 
		curl_setopt($curl, CURLOPT_HEADER, FALSE); 
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); 
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); 
		curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true); 
		$curl_content = curl_exec($curl); 
		//echo $curl_content;

		print_r($curl_content);
		curl_close($curl); 
	} 
	else 
	{ 
		$curl_content = file_get_contents("http://www.tmpay.net/TPG/backend.php?merchant_id=YS13121022&password=" . $truemoney_password . "&resp_url= http://".$website."/tmpay/tmpay_result.php?user_id=".$user_id); 
	} 

	if(strpos($curl_content,'SUCCEED') !== FALSE) 
	{
		//IF SUCCEED GET TRANACTION ID
		$transaction_id = substr($curl_content, strpos($curl_content,'|')+1); 
	}

//INSERT TO DB
$db2 = new mysqli('localhost', 'payment', 'payment7410', 'payment');
$sql = "INSERT INTO fill
	(channel_id, user_id, ref1, api, ref3)
	VALUES
	(1, $user_id, '$truemoney_password', '$transaction_id', '$curl_content')
	";

$ins = $db2->query($sql);

 print_r($curl_content);
 //echo 'fill.php';

 if(strpos($curl_content,'SUCCEED') !== FALSE) 
 { 
 	$return_data['status'] = 1;
 	$return_data['message'] = "";
 } 
 else 
 { 
 	$return_data['status'] = 0;
 	$return_data['message'] = $curl_content;
 } 

echo json_encode($return_data);

return json_encode($return_data);
// return json_decode($curl_content, true);
 // if(strpos($curl_content,'SUCCEED') !== FALSE) 
 // { 
 // return true; 
 // } 
 // else 
 // { 
 // return false; 
 // } 
}
 
?>