<?php
// echo checkRepeatNumber('12345');
// echo  generateOTP();
//send_sms('0816864361',"ทดสอบ ทดสอบ รหัส= 504045");

function send_sms($mobile,$message)
{

$url = "http://www.thaibulksms.com/sms_api.php";
$data_string = "username=0901317525&password=908951&msisdn=$mobile&message=$message&force=standard";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string); 
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 15); 
curl_setopt($ch, CURLOPT_HEADER, FALSE); 
$result = curl_exec($ch);
curl_close($ch);


// $xml = xml($result);
// $count = count($xml['SMS']['QUEUE']); 
// if($count > 0)
// {
// 	$count_pass = 0; 
// 	$count_fail = 0; 
// 	$used_credit = 0; 
// 	for($i=0;$i<$count;$i++){
// 		if($xml['SMS']['QUEUE'][$i]['Status']){ 
// 			$count_pass++;
// 			$used_credit += $xml['SMS']['QUEUE'][$i]['UsedCredit']; 
// 		}
// 		else{
// 			$count_fail++;
// 		} 
// 	}
// 	if($count_pass > 0) {
// 		echo "สามารถสง่ ออกไดจ้ านวน $count_pass หมายเลข, ใชเ้ ครดติ ทัง้ หมด $used_credit เครดติ ";
// 	}
// 	if($count_fail > 0) {
// 		echo "ไมส่ ามารถสง่ ออกไดจ้ านวน $count_fail หมายเลข";
// 	} 
// }
// else{
// 	echo "เกดิ ขอ้ ผดิ พลาดในการทางาน, (".$xml['SMS']['Detail'].")"; 
// }

}


?>