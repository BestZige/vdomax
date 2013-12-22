<?php

//Create DB Connection Object
$DBServer = 'localhost'; // e.g 'localhost' or '192.168.1.100'
$DBUser   = 'payment';
$DBPass   = 'payment7410';
$DBName   = 'payment';

$db2 = new mysqli($DBServer, $DBUser, $DBPass, $DBName);

//When Access to Max Point Cneter

//Generate Max Point Account if that User dont have it
$smarty->assign('gen_acc',generatempaccount($userArray['UserID']));
$smarty->assign('is_acc_verify',isVerifyBankAccount($userArray['UserID']));
$smarty->assign('banks',getBank());

// Generate Max Point Account
function generatempaccount($user_id)
{
	$db2 = new mysqli('localhost', 'payment', 'payment7410', 'payment');

	$return_data = array();

	//Check if already has account
	$check = $db2->query("SELECT * from maxpoint_account WHERE user_id = {$user_id}")->fetch_array(MYSQLI_ASSOC);

	if(!$check)
	{
		$sql = sprintf("INSERT INTO maxpoint_account (user_id,current_amount) VALUES(%s, %s)", $user_id, 10);
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

function isVerifyBankAccount($user_id)
{
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
		return 1;
		$result_data['status'] = 1;
	}
	else
	{
		return 0;
		$result_data['status'] = 0;
	}

	return $result_data['status'];
}

function getFillChannel()
{
	$db2 = new mysqli('localhost', 'payment', 'payment7410', 'payment');

	//SQL
	$sql = "SELECT * FROM 
		fill_channel
		";

	$res = $db2->query($sql);

	$fill_channel = fetchAll($res);

	return $fill_channel;
}

function getBank()
{
	$db2 = new mysqli('localhost', 'payment', 'payment7410', 'payment');

	//SQL
	$sql = "SELECT * FROM 
		bank
		";

	$res = $db2->query($sql);

	$bank = fetchAll($res);

	return $bank;
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

?>