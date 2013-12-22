<?
	//include("xml2array.php");
	include("sms.class.php");
	
	$username = $_REQUEST['username'];
	$password = $_REQUEST['password'];
	$force = $_REQUEST['force'];
	
	$result = sms::check_credit($username,$password,$force);
	
	echo $result;
	/*list($result,$code) = $result;
	
	if($code['http_code'] == 200){
		echo $result;
	}else{
		echo "The server responded: <br />";
        echo $code['http_code'] . " " . $http_codes[$code['http_code']];
	}*/
?>