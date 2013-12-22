<?php 
 
 // fetch kernal
//require('/home/new2/kernal.php');

$db2 = new mysqli('localhost', 'payment', 'payment7410', 'payment');

 $transaction_id = $_GET['transaction_id']; 
 $password = $_GET['password']; 
 $amount = $_GET['real_amount']; 
 $status = $_GET['status']; 

$user_id = $_GET['user_id'];
//print_r($userArray);
//echo 'asda';

if($status==1)
{
  //SELECT TO CHECK WITH LOG (เพราะต้องใช้เวลาซักพักกว่าจะยิงกลับมาที่ไฟล์นี้)

  $sql = "SELECT * FROM fill
    WHERE ref1 = '$password'
    AND api = '$transaction_id'
    AND user_id = $user_id
    ";
// AND api = '$transaction_id'
  $res = $db2->query($sql);

  if($res)
  {
    //Match

    $result = $res->fetch_array(MYSQLI_ASSOC);

    $current_rate = 10;
    $amount_maxpoint = $amount * $current_rate;
    
    $sql = "UPDATE fill
      SET amount_baht = $amount, amount_maxpoint = $amount_maxpoint, success = 1, eff_date = NOW()
      WHERE api = '$transaction_id'
      AND user_id = $user_id
      ";

    $upd = $db2->query($sql);

    $sql = "UPDATE maxpoint_account
      SET current_amount = current_amount + $amount_maxpoint
      WHERE user_id = $user_id
      ";      

    $upd = $db2->query($sql);

  }

  die(‘SUCCEED|TOPPED_UP_THB_’ . $amount . ‘_TO_’ . $user_id); 

}
else 
{
   /* ไม่สามารถเติมเงินได ้ */ 
   $sql = "UPDATE fill
      SET ref3 = 'FAILED STATUS=$status'
      WHERE api = '$transaction_id'
      AND user_id = $user_id
      ";

    $upd = $db2->query($sql) or die("ERROR: ".$sql);

   die(‘ERROR|ANY_REASONS’);
}

// $sql = "INSERT INTO fill(
// channel_id,
// amount_baht,
// amount_maxpoint,
// current_rate,
// user_id,
// ref1,
// fill_date,
// success
// )
// VALUES ( 1, 2, 3, 4, 5,  $password , NOW(), 0 )
// 				";

// if($status==1)
// {
// 	$result['message'] = ‘SUCCEED|TOPPED_UP_THB_’ . $amount . ‘_TO_’ . $user_id_refill;
// }
// else
// {
// 	$result['message'] = ‘ERROR|ANY_REASONS’;
// }
// echo 'tmpay_result.php';
// print_r($result);
// echo json_encode($result);

 ////if( $status == 1 ) 
  ////{ 
 	//echo "fill success";
 /* Code เพิ่มเงินที่นี่ */ 
 /* เชน่ 
 $user_id_refill = $this->db->query( ‘SELECT TOP 1 user_id FROM truemoney WHERE 
truemoney = ? ’, password); 
 $this->db->query( ‘UPDATE point = pount + ? WHERE user_id = ? ’, $amount, $user_id_refill); 
 */ 

 //// die(‘SUCCEED|TOPPED_UP_THB_’ . $amount . ‘_TO_’ . $user_id_refill); 
  ////} 
  ////else 
  ////{ 
 // /* ไม่สามารถเติมเงินได ้ */ 
  ////die(‘ERROR|ANY_REASONS’); 
//echo "fill failed";
 
?>