<?
echo 'sendmail';
sendEmail("heartmon12@gmail.com","TEST","
	ช่องทางการเติมเงิน: TRUEMONEY\r\n
    สถานะการเติมเงิน: ผ่าน\r\n
    จำนวน MAXPOINT ที่ได้รับ: test\r\n
    ------------------------------------------\r\n
    This is automatically generated message. Do not reply.");

echo $website = $_GET['website'];
echo $user_id = $_GET['user_id'];
echo $email = $_GET['email'];

function sendEmail($to, $subject, $message)
{


	 //mail($to,$subject,$message);

	// $webmaster_email = "emmy@kundecorate.com";

	// $feedback_page = "contacts.html";
	// $error_page = "error_message.html";
	// $thankyou_page = "thank_you.html";

	// $subject = $_REQUEST['p1'];
	// $name = $_REQUEST['p2'];
	// $email_address = $_REQUEST['p3'];
	// $phone = $_REQUEST['p4'];
	// $comments = $_REQUEST['p5'];

	// //console.log('this is a test');

	// if (empty($subject) || empty($email_address) || empty($comments) || empty($phone)) {
	// 	header( "Location: $error_page" );
	// }

	// // If we passed all previous tests, send the email then redirect to the thank you page.

	// else {
	// 	mail( "$webmaster_email", "Feedback Form Results",$comments, "From: $name, $email_address, $phone" );
	// 	header( "Location: $thankyou_page" );
	// }
}
?>
