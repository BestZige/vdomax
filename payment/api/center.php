<?php
// Web Service for Max Point Center (Main) and for other uses.

// fetch kernal
require('/home/new2/kernal.php');

// check access level
AccessLevel('restricted');

//Create DB Connection Object
global $DBServer, $DBUser, $DBPass, $DBName;

$DBServer = 'localhost'; // e.g 'localhost' or '192.168.1.100'
$DBUser   = 'payment';
$DBPass   = 'payment7410';
$DBName   = 'payment';

//Get an action to determine the function

$action = $_GET['action'];
$user_id = $_REQUEST['user_id'];
if($user_id=='')
{
	$user_id = $userArray['UserID'];
}

switch($action)
{
	case "getbalance":
		echo getBalance($user_id);
	break;

	case "getpopularitem":
		echo getPopularItem();
	break;

	case "fillpoint":
		$channel_id = $_POST['channel_id'];
		$ref1 = $_POST['true_pass_tmp'];
		echo fillPoint($user_id, $userArray['UserToken'], $channel_id, 1, $ref1);
	break;

	case "maxpointtransfer":
		$amount_maxpoint = $_POST['amount_maxpoint'];
		$to_uid = $_POST['to_uid'];
		$from_uid = $user_id;
		echo pointtransfer($from_uid, $to_uid, $amount_maxpoint, $userArray['UserToken']);
	break;

	case "transactionhistory":
		echo getTransactionHistory($user_id);
	break;

	case "withdraw":
		$amount_maxpoint = $_POST['amount_maxpoint'];
		$amount_baht = $_POST['amount_baht'];
		$current_rate = $_POST['current_rate'];
		$withdraw_fee = $_POST['withdraw_fee'];
		$otp = $_POST['otp'];

		echo withdraw($user_id, $userArray['UserToken'], $amount_maxpoint, $amount_baht, $current_rate, $withdraw_fee, $otp);
	break;

	case "accountverify":
		$bank_id = $_POST['bank_id'];
		$acc_no = $_POST['acc_no'];
		$mobile = $_POST['mobile'];
		$otp = $_POST['otp'];

		echo accountVerify($userArray['UserToken'], $bank_id, $acc_no, $user_id, $mobile, $otp);
	break;

	case "getUserDetail":
		echo getUserDetail($userArray['UserName'], $userArray['UserToken']);
	break;

	case "useitem":
		$from_uid   = $user_id;
		$to_uid     = $_REQUEST['to_uid'];
		$item_id    = $_REQUEST['item_id'];
		$quantity   = $_REQUEST['quantity'];
		echo itemtransfer($from_uid,$userArray['UserToken'], $to_uid, $item_id, $quantity);
	break;

	case "buyitem":
		$from_uid   = 0; //MARKET USER_ID
		$to_uid     = $user_id;
		$item_id    = $_REQUEST['item_id'];
		$quantity   = $_REQUEST['quantity'];
		echo itemtransfer($from_uid,$userArray['UserToken'], $to_uid, $item_id, $quantity);
	break;

	case "getitem":
		echo getOwnItem($user_id);
	break;
	default:
	break;
}


//------------------------------------------
//FUNCTION
//------------------------------------------

function print_info($userArray) {
	print "UserID : ". $userArray['UserID'] . "<br/>";
	print "UserName : ". $userArray['UserName'] . "<br/>";
	print "UserToken : ". $userArray['UserToken'] . "<br/>";
}

function check_require_field($array)
{

}

function CHECK_USER_TOKEN($username, $token)
{
	$url = 'http://api.vdomax.com/?action=getprofileinfo';
	$fields = array(
						'username' => $username,
						'tokenid' => $token
				);

	//url-ify the data for the POST
	foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
	rtrim($fields_string, '&');

	//open connection
	$ch = curl_init();

	//set the url, number of POST vars, POST data
	curl_setopt($ch,CURLOPT_URL, $url);
	curl_setopt($ch,CURLOPT_POST, count($fields));
	curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

	//execute post
	$result = curl_exec($ch);

	//close connection
	curl_close($ch);

	//print_r($result);

	$result = json_decode($result, true);

	return $result['status'];
}

// Generate Max Point Account
function generatempaccount($user_id)
{
	$db2 = new mysqli($DBServer, $DBUser, $DBPass, $DBName);
	$db2 = new mysqli('localhost', 'payment', 'payment7410', 'payment');

	$return_data = array();

	//Check if already has account
	$check = $db2->query("SELECT * from maxpoint_account WHERE user_id = {$user_id}")->fetch_array(MYSQLI_ASSOC);

	if(!$check)
	{
		$sql = sprintf(
			"INSERT INTO maxpoint_account (user_id,current_amount)
				VALUES(%s, %s)
			", 
			$user_id, 10);
		//print $sql;
		$ins = $db2->query($sql) or SQLError();

		$return_data['status'] = "1";
		$return_data['message']= "Account successfully created";
	}
	else
	{
		$return_data['status'] = "0";
		$return_data['message']= "Alreay has account";
	}

	return json_encode($return_data);
}

// Check Balance
function getBalance($user_id)
{
	$db2 = new mysqli('localhost', 'payment', 'payment7410', 'payment');

	$query = $db2->query(
		"SELECT user_id, current_amount 
			FROM maxpoint_account
			WHERE user_id = {$user_id}
		") 
		or SQLError();
	$balance = $query->fetch_array(MYSQLI_ASSOC);

	return json_encode($balance);
}

// Fill
function fillPoint($user_id, $token, $channel_id, $current_rate=1, $ref1='', $ref2='', $ref3='')
{
	//Check Token (FROM UID)
	$status = CHECK_USER_TOKEN($user_id, $token);

	if($status!=0)
	{
		//แยกตามประเภท
		//TRUE MONEY
		if($channel_id==1)
		{
			require_once('../tmpay/fill.php');

			


			$tm_result = tmn_refill($ref1, $user_id);



			//Fill Success
			$return_data = array();
			print_r($tm_result);
			if($tm_result['status'] == 1)
			{
				$return_data['status'] = 1;
				$current_rate = getExchangeRate($channel_id);
				$amount_maxpoint = $current_rate * $tm_result['amount'];
				$return_data['message'] = "You have got ".$amount_maxpoint." Max Points!";

				//UPDATE USER's MAXPOINT_ACCOUNT
				$sql = "UPDATE maxpoint_account
					SET current_amount = current_amount + $amount_maxpoint;
					WHERE user_id = $user_id
					";

				$upd = $db2->query($sql) or SQLError();
			}
			else
			{
				$return_data['status'] = 0;
				$amount_maxpoint = 0;
				$return_data['message'] = $tm_result['message'];
			}

			//INSERT LOG into DB
			$amount_baht = $tm_result['amount'];
			$status = $tm_result['status'];
			$password = $tm_result['password'];

			$date = getDateNow();
			$sql = "INSERT INTO fill
			(channel_id, amount_baht, amount_maxpoint, current_rate, user_id, ref1, fill_date, success)
			VALUES
			($channel_id, $amount_baht, $amount_maxpoint, $current_rate, $user_id, '$password',
				NOW(), $status)
				";

			echo $sql;

			$ins = $db2->query($sql) or SQLError();

		}

		//PAYPAL
		elseif($channel_id==2)
		{

		}

	}
	else
	{
		$return_data['status'] = 0;
		$return_data['message'] = "Token mismatched";
	}

	return $return_data;
}

// Point Transfer
function pointtransfer($from_uid, $to_uid, $amount, $token)
{
	//DB Connect
	$db2 = new mysqli('localhost', 'payment', 'payment7410', 'payment');

	$return_data = array();

	if($to_uid=='' || $from_uid=='')
	{
		$return_data['status'] = 1;
		$return_data['message'] = "Parameter ไม่ครบ";
		return json_encode($return_data);
	}
	//Check Token (FROM UID)
	$status = CHECK_USER_TOKEN($from_uid, $token);

	if($status!=0)
	{
		//Check If the point is enough
		$sql = "SELECT current_amount 
			FROM maxpoint_account
			WHERE user_id = $from_uid
			";

		$res = $db2->query($sql);
		$res = $res->fetch_array(MYSQLI_ASSOC);

		$current_amount = $res['current_amount'];

	if($current_amount - $amount >= 0)
	{
		//Start SQL Transaction
		try 
		{
			/* switch autocommit status to FALSE. Actually, it starts transaction */
			$db2->autocommit(FALSE);

			//Decrease FROM_UID Account
			$sql = 
			"UPDATE maxpoint_account
			SET current_amount = current_amount - $amount
			WHERE user_id = $from_uid
			";

			$res = $db2->query($sql) or die('1234');

			if($res === false)
				throw new Exception('Wrong SQL: ' . $sql . ' Error: ' . $db2->error);

			//Increase TO_UID Account
			$sql =  
			"UPDATE maxpoint_account
			SET current_amount = current_amount + $amount
			WHERE user_id = $to_uid
			";

			$res = $db2->query($sql) or SQLError();

			if($res === false)
				throw new Exception('Wrong SQL: ' . $sql . ' Error: ' . $db2->error);

			//Insert Max Point Transfer Log
			$date = getDateNow();
			$sql =
			"INSERT INTO maxpoint_transfer
			(from_uid,to_uid,amount,transfer_date)
			VALUES ($from_uid,$to_uid,$amount,NOW())
			";

			$res = $db2->query($sql) or SQLError();

			if($res === false)
				throw new Exception('Wrong SQL: ' . $sql . ' Error: ' . $db2->error);

			/* commit transaction */
			$db2->commit();

			$return_data['status'] = 1;
			$return_data['message'] = "โอน Max Point จำนวน $amount ไปยัง UserID:$to_uid สำเร็จ";
		}
		catch (Exception $e)
		{
			$db2->rollback();

			$return_data['status'] = 0;
			$return_data['message'] = "Transaction Failed";
		}
	}
	else
	{
		//Not have enough point to transfer
		$return_data['status'] = 0;
		$return_data['message'] = "คุณมีแต้มไม่เพียงพอในการโอนเงิน";
	}
	}
	else
	{
		$return_data['status'] = 0;
		$return_data['message'] = "Token mismatched";
	}

	return json_encode($return_data);
}

// Get List of Own Item
function getOwnItem($user_id)
{
	//DB Connection
	$db2 = new mysqli('localhost', 'payment', 'payment7410', 'payment');
	$return_data = array();

	$sql = "SELECT i.id, i.name as item_name, i.desc, i.cat_id, ic.name as category_name, i.imgpath, i.price, io.quantity
			FROM item_own io
			INNER JOIN item i
				ON i.id = io.item_id
			INNER JOIN item_category ic
				ON i.cat_id = ic.id
			WHERE io.user_id = $user_id
			AND io.quantity > 0
			";

	$res = $db2->query($sql);

	$res = fetchAll($res);

	return json_encode($res);
}

// Item Transfer
function itemtransfer($from_uid,$token, $to_uid, $item_id, $quantity)
{
	//DB Connection
	$db2 = new mysqli('localhost', 'payment', 'payment7410', 'payment');

	$return_data = array();

	if($to_uid=='' || $from_uid=='')
	{
		$return_data['status'] = 1;
		$return_data['message'] = "Parameter ไม่ครบ";
		return json_encode($return_data);
	}

	//CHECK USER TOKEN
	if(CHECK_USER_TOKEN($from_uid,$token))
	{
		//Get 
		//Check If the user own enough item quantity
		$sql = "SELECT quantity 
			FROM item_own
			WHERE user_id = $from_uid
			AND item_id = $item_id
			";

		$res = $db2->query($sql);

		if($res->num_rows<=0)
		{
			//Don't have this Item [Item_ID]
			$return_data['status'] = 0;
			$return_data['message'] = "คุณมีไอเทมไม่พอในการส่ง";
		}
		else
		{
			$res = $res->fetch_array(MYSQLI_ASSOC);
			$current_quantity = $res['quantity'];

			if($current_quantity - $quantity < 0)
			{
				//จำนวน item ไม่เพียงพอสำหรับการส่ง
				$return_data['status'] = 0;
				$return_data['message'] = "คุณมีไอเทมไม่พอในการส่ง";
			}
			else
			{
				//ส่งได้

				//Get to_uid item_own
				$sql = "SELECT id
					FROM item_own
					WHERE item_id = $item_id
					AND user_id = $to_uid
					";
				$res = $db2->query($sql) or die('SQLError: '.$sql);
				if($res->num_rows>0)
					$already_own = 1;
				else
					$already_own = 0;

				//Get Infomation of Item
				$sql =  
					"SELECT name, price, total
					FROM item
					WHERE id = $item_id
					";

				$res = $db2->query($sql) or die('Error: '.$sql);

				$res = $res->fetch_array(MYSQLI_ASSOC);

				$price  = $res['price'];
				$item_name = $res['item_name'];

				$total_maxpoint_used = $price * $quantity;

				//Get Account infomation of $to_uid

				$sql = "SELECT current_amount
							FROM maxpoint_account
							WHERE user_id = $to_uid
							";

				$res = $db2->query($sql) or die('Error: '.$sql);
				$res = $res->fetch_array(MYSQLI_ASSOC);

				$current_amount = $res['current_amount'];

				if($from_uid == 0)
				{
					if($current_amount - $total_maxpoint_used < 0)
					{
						//เงินไม่พอซื้อ
						$return_data['status'] = 0;
						$return_data['message'] = "คุณมีเงินไม่พอในการซื้อ";
						return $return_data;
					}
				}

				//Start SQL Transaction
				try 
				{
					/* switch autocommit status to FALSE. Actually, it starts transaction */
					$db2->autocommit(FALSE);

					//If $from_uid is MARKET เท่ากับว่าเป็นการซื้อจากตลาด
					//ต้องมีการหักพ้อยจาก to_uid
					if($from_uid == 0)
					{
						$sql =  
							"UPDATE maxpoint_account
							SET current_amount = current_amount - $total_maxpoint_used
							WHERE user_id = $to_uid
							";

						$res = $db2->query($sql) or die('SQLError: '.$sql);

						if($res === false)
							throw new Exception('Wrong SQL: ' . $sql . ' Error: ' . $db2->error);
					}
					
					//Decrease FROM_UID item_own
					$sql = 
					"UPDATE item_own
					SET quantity = quantity - $quantity
					WHERE user_id = $from_uid
					AND item_id = $item_id
					";

					$res = $db2->query($sql) or die('1234');

					if($res === false)
						throw new Exception('Wrong SQL: ' . $sql . ' Error: ' . $db2->error);


					//Increase TO_UID item_own

					//Check if already own this ITEM_ID
					if($already_own)
					{
						//Update
						$sql =  
						"UPDATE item_own
						SET quantity = quantity + $quantity
						WHERE user_id = $to_uid
						AND item_id = $item_id
						";

						$res = $db2->query($sql) or die('Error: '.$sql);

						if($res === false)
							throw new Exception('Wrong SQL: ' . $sql . ' Error: ' . $db2->error);
					}
					else
					{
						//Insert
						$sql =  
						"INSERT INTO item_own
						(user_id, item_id, quantity, own_date)
						VALUES ($to_uid, $item_id, $quantity, NOW())
						";

						$res = $db2->query($sql) or die('Error: '.$sql);

						if($res === false)
							throw new Exception('Wrong SQL: ' . $sql . ' Error: ' . $db2->error);
					}

					//Insert to DB [item_transfer]
					$date = getDateNow();
					$sql =
					"INSERT INTO item_transfer
					(from_uid,to_uid,item_id,quantity,transfer_date)
					VALUES ($from_uid,$to_uid,$item_id,$quantity,NOW())
					";

					$res = $db2->query($sql) or SQLError();

					if($res === false)
						throw new Exception('Wrong SQL: ' . $sql . ' Error: ' . $db2->error);

					/* commit transaction */
					$db2->commit();


					$return_data['status'] = 1;
					$return_data['item_name'] = $item_name;
					$return_data['item_id'] = $item_id;
					$return_data['quantity'] = $quantity;
					$return_data['total_price'] = $total_maxpoint_used;

					if($from_uid==0) //MARKET_USER_ID
					{
						$return_data['message'] = "ทำการซื้อไอเทม '$item_name' จำนวน $quantity เป็นเงิน $total_maxpoint_used เรียบร้อย";
					}
					else
					{
						$return_data['message'] = "ส่ง $item_name จำนวน $quantity ไปยัง User_ID: $to_uid เรียบร้อย";
					}
					
				}
				catch (Exception $e)
				{
					$db2->rollback();

					$return_data['status'] = 0;
					$return_data['message'] = "Transaction Failed";
				}
			}
		}
	}
	else
	{
		$return_data['status'] = 0;
		$return_data['message'] = "Token mismatched";
	}

	return json_encode($return_data);
}

// Withdraw
function withdraw($user_id, $token, $amount_maxpoint, $amount_baht, $current_rate, $withdraw_fee, $otp)
{
	//DB Connection
	$db2 = new mysqli('localhost', 'payment', 'payment7410', 'payment');

	//CHECK USER TOKEN
	if(CHECK_USER_TOKEN($user_id,$token))
	{
		//Step1
		if($otp=='')
		{
			//Check If the point is enough
			$sql = "SELECT current_amount 
				FROM maxpoint_account
				WHERE user_id = $user_id
				";

			$res = $db2->query($sql);
			$res = $res->fetch_array(MYSQLI_ASSOC);

			$current_amount = $res['current_amount'];

			if($current_amount - $amount_maxpoint >= 0)
			{
				//Check If the point is enough
				$sql = "SELECT mobile 
					FROM bank_account
					WHERE user_id = $user_id
					";

				$res = $db2->query($sql);
				$res = $res->fetch_array(MYSQLI_ASSOC);

				$mobile = $res['mobile'];

				//Generate OTP  
				$otp = generateOTP();

				//SEND OTP
				require('../thaibulksms/sms.php');

				send_sms($mobile, "รหัส OTP สำหรับการรับเงินบาทจาก Max Point คือ $otp");
				
				//UPDATE Previous Withdraw as EXPIRED
				$sql =  "UPDATE withdraw
						SET expired = 1
						WHERE user_id = $user_id
						"; 

				$upd = $db2->query($sql) or die('ERROR'.$sql);

				//INSERT TO withdraw
				//SQL
				$date = getDateNow();
				$sql =  "INSERT INTO withdraw
				(user_id, amount_baht, amount_maxpoint, current_rate, last_otp, confirm, withdraw_date,
					withdraw_fee)
				VALUES
				($user_id, $amount_baht, $amount_maxpoint, $current_rate, $otp, 0, NOW(), 0)
				";

				$res = $db2->query($sql) or die('ERROR'.$sql);
				$return_data = array();

				//Return Status, Message, OTP and id
				if($res)
				{
					$return_data['status'] = 1;
					$return_data['message'] = "";
					$return_data['id'] = $db2->insert_id;
				}
				else
				{
					$return_data['status'] = 0;
					$return_data['message'] = "Please try again later";
				}
			}
			else
			{
				$return_data['status'] = 0;
				$return_data['message'] = "จำนวน Max Point ไม่เพียงพอ";
			}
		}
		elseif($otp!='')
		{
			//Check OTP in bank_account by id
			//SQL
			$sql =  "SELECT * FROM withdraw
			WHERE user_id = $user_id
			AND last_otp = $otp
			AND confirm = 0
			AND expired = 0
			ORDER BY withdraw_date DESC
			LIMIT 0,1 
			";

			$res = $db2->query($sql);

			$res = $res->fetch_array(MYSQLI_ASSOC);

			//Check If OTP is correct

			$return_data = array();

			if($res)
			{
				$id = $res['id'];
				$amount = $res['amount_maxpoint'];
				$date = getDateNow();
				//Check If OTP is expired (5 MIN)
				$time_now = strtotime($date);
				$time_last_add = strtotime($res['withdraw_date']);
				
				$LIFE_TIME = 5*60;

				if($time_now - $time_last_add > $LIFE_TIME)
				{
					//Expired
					$sql =  "UPDATE withdraw
					SET expired = 1
					WHERE id = $id
					";

					$upd = $db2->query($sql) or SQLError();

					$return_data['status'] = 0;
					$return_data['message'] = "Your OTP is expired";
				}
				else
				{
					//Confirm
					$sql =  "UPDATE withdraw
					SET confirm = 1, confirm_date = NOW()
					WHERE id = $id
					";

					$upd = $db2->query($sql) or SQLError();

					$sql =  "UPDATE maxpoint_account
					SET current_amount = current_amount - $amount
					WHERE user_id = $user_id
					";

					$upd = $db2->query($sql) or SQLError();

					$return_data['status'] = 1;
					$return_data['message'] = "Your Withdrawal is accept.";
				}
			}
			else
			{
				//Return Status
				$return_data['status'] = 0;
				$return_data['message'] = "OTP is incorrect";
			}
		}

	}
	else
	{

	}

	return json_encode($return_data);
}

// Get Popular Item
function getPopularItem($market_uid=0)
{
	//DB Connection
	//$db2 = new mysqli($DBServer, $DBUser, $DBPass, $DBName);
	$db2 = new mysqli('localhost', 'payment', 'payment7410', 'payment');

	//Assume MARKET_USER_ID


	//SQL
	$sql =  "SELECT i.id,i.name,i.desc,i.cat_id,i.price,i.imgpath,i.total, SUM(it.quantity) as popularity
			FROM item_transfer it
			INNER JOIN item i
			ON i.id = it.item_id
			WHERE it.from_uid = {$market_uid}
			GROUP BY i.id,i.name,i.desc,i.cat_id,i.price,i.imgpath,i.total
			LIMIT 0,10
			";

	$res = $db2->query($sql);

	$arr = fetchAll($res);

	return json_encode($arr);
}

// Transaction History
function getTransactionHistory($user_id)
{
	$db2 = new mysqli('localhost', 'payment', 'payment7410', 'payment');
//echo $user_id;
	//Fill Transfer
	//SQL
	$sql = "SELECT f.channel_id, fc.name, fc.desc, f.amount_maxpoint, f.fill_date 
		FROM fill f
		INNER JOIN fill_channel fc
			ON f.channel_id = fc.id
		WHERE user_id = $user_id
		";

	$fill = $db2->query($sql);
	$fill_arr = fetchAll($fill);

	//Maxpoint Transfer
	//SQL
	$sql = "SELECT to_uid, amount, transfer_date
		FROM maxpoint_transfer
		WHERE from_uid = $user_id
		";	

	$mp = $db2->query($sql);
	$mp_arr = fetchAll($mp);

	//Withdraw Transfer
	//SQL
	$sql = "SELECT b.name, ba.acc_no, amount_maxpoint, amount_baht, withdraw_fee, withdraw_date
		FROM withdraw w
		INNER JOIN bank_account ba
			ON ba.user_id = w.user_id 
		INNER JOIN bank b
			ON b.id = ba.bank_id
		WHERE ba.confirm = 1
		AND w.user_id = $user_id
		";	

	$withdraw = $db2->query($sql);
	$withdraw_arr = fetchAll($withdraw);

	$return_data = array();
	$return_data['fill'] = $fill_arr;
	$return_data['maxpoint_transfer'] = $mp_arr;
	$return_data['withdraw'] = $withdraw_arr;

	return json_encode($return_data);
}

// Bank Account Verification
function accountVerify($token, $bank_id, $acc_no, $user_id, $mobile, $otp)
{
	//DB Connection
	$db2 = new mysqli('localhost', 'payment', 'payment7410', 'payment');

	$date = getDateNow();

	//CHECK USER TOKEN
	if(CHECK_USER_TOKEN($user_id,$token))
	{
		//Step1
		if($otp=='' && $acc_no!='')
		{
			//Generate OTP  
			$otp = generateOTP();

			//SEND OTP
			require('../thaibulksms/sms.php');

			send_sms($mobile, "รหัส OTP สำหรับการยืนยันเลขที่บัญชี คือ $otp");

			//UPDATE Previous add bank_account as EXPIRED
			$sql =  "UPDATE bank_account
					SET expired = 1
					WHERE user_id = $user_id
					"; 

			$upd = $db2->query($sql) or die('1234' + $sql);

			//INSERT TO bank_account
			//SQL

			$sql =  "INSERT INTO bank_account
			(user_id, acc_no, bank_id, mobile, last_otp, confirm, add_date, expired)
			VALUES
			($user_id, '$acc_no', $bank_id, '$mobile', $otp, 0, NOW(), 0)
			";

			$res = $db2->query($sql) or die('error' + $sql);
			$return_data = array();

			//Return Status, Message, OTP and id
			if($res)
			{
				$return_data['status'] = 1;
				$return_data['message'] = "";
				$return_data['id'] = $db2->insert_id;
			}
			else
			{
				$return_data['status'] = 0;
				$return_data['message'] = "Please try again later";
			}
		}

		//Step2
		elseif($otp!='' && $acc_no=='')
		{
			//Check OTP in bank_account by id
			//SQL
			$sql =  "SELECT * FROM bank_account
			WHERE user_id = $user_id
			AND last_otp = $otp
			AND confirm = 0
			AND expired = 0
			ORDER BY add_date DESC
			LIMIT 0,1 
			";

			$res = $db2->query($sql);

			$res = $res->fetch_array(MYSQLI_ASSOC);

			//Check If OTP is correct

			$return_data = array();

			if($res)
			{
				//Check If OTP is expired (5 MIN)
				$time_now = strtotime($date);
				$time_last_add = strtotime($res['add_date']);
				
				$LIFE_TIME = 5*60;
				$id = $res['id'];

				if($time_now - $time_last_add > $LIFE_TIME)
				{
					//Expired
					$sql =  "UPDATE bank_account
					SET expired = 1
					WHERE id = $id
					";

					$upd = $db2->query($sql) or SQLError();

					$return_data['status'] = 0;
					$return_data['message'] = "Your OTP is expired";
				}
				else
				{
					//Confirm
					$sql =  "UPDATE bank_account
					SET confirm = 1, confirm_date = NOW()
					WHERE id = $id
					";

					$upd = $db2->query($sql) or SQLError();

					$return_data['status'] = 1;
					$return_data['message'] = "Your Bank Account is successfully verified";
				}
			}
			else
			{
				//Return Status
				$return_data['status'] = 0;
				$return_data['message'] = "OTP is incorrect";
			}
		}
	}
	else
	{
		//Return Status
		$return_data['status'] = 0;
		$return_data['message'] = "Token mismatched";
	}

	return json_encode($return_data);
}

function isVerifyBankAccount($user_id)
{
	$db2 = new mysqli($DBServer, $DBUser, $DBPass, $DBName);
	$db2 = new mysqli('localhost', 'payment', 'payment7410', 'payment');

	//SQL
	$sql = "SELECT * FROM 
		bank_account
		WHERE user_id = $user_id
		AND confirm = 1
		";

	$res = $db2->query($sql);
	$result_data = array();
	if($res->num_rows>0)
	{
		$result_data['status'] = 1;
	}
	else
	{
		$result_data['status'] = 0;
	}

	return json_encode($result_data);
}

function generateOTP()
{
	$otp = "xxxxxx";
	while(checkRepeatNumber($otp))
	{
		$otp = rand(100000, 999999);
	}

	return $otp;
}

function bahtToPoint($point, $channel_id)
{
	//Fix
	return ($point*10)+100;
}

function getExchangeRate($channel_id)
{
	//Fix
	return 10;
}

function checkRepeatNumber($str)
{
	$char = str_split($str);
	$prev = $char[0];
	for($i=1;$i<count($char);$i++)
	{
		if($prev==$char[$i])
		{
			return true;
		}
		$prev = $char[$i];
	}
	return false;
}

function getDateNow()
{
	return date("Y-m-d H:i:s");    
}

function fetchAll($result)
{
	if ($result !== false) {
		while($row = $result->fetch_assoc()) {
			//print_r($row);
			$rows[] = $row;
		}
		$result->close();	    
		return $rows;	    
	}
}

function getUserDetail($uname,$token) {

	//
	// A very simple PHP example that sends a HTTP POST to a remote site
	//

	$ch = curl_init();

	curl_setopt($ch, CURLOPT_URL,"http://api.vdomax.com/?action=getprofileinfo");
	curl_setopt($ch, CURLOPT_POST, 1);
	//curl_setopt($ch, CURLOPT_POSTFIELDS,
	//            "username=".$uname."1&tokenid=".$token);

	// in real life you should use something like:
	curl_setopt($ch, CURLOPT_POSTFIELDS, 
	         http_build_query(array('username' => $uname, 'tokenid' => $token)));

	// receive server response ...
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

	$server_output = curl_exec ($ch);

	curl_close ($ch);

	// further processing ....
	//echo "<script>alert(".$server_output.")</script>";
	return $server_output;

}


?>