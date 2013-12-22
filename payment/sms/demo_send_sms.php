<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>.: ThaiBulkSMS :.</title>
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8"/>
</head>

<body>
<h2>Demo Send SMS Form</h2>
<form id="send_sms" name="send_sms" method="post" action="send_sms.php">
Username<br/>
<input type="text" id="username" name="username" value="" /><br/>
Password<br/>
<input type="text" id="password" name="password" value="" /><br/>
Credit Type<br/>
<select id="force" name="force">
<option value="standard" selected="selected">Standard</option>
<option value="premium">Premium</option>
</select><br/>
Sender Name<br/>
<select id="sender" name="sender">
<option value="THAIBULKSMS" selected="selected">THAIBULKSMS</option>
</select><br/>
Phone Number<br/>
<input type="text" id="msisdn" name="msisdn" value="" /><br/>
Message<br/>
<textarea id="message" name="message"></textarea><br/>
ScheduledDelivery<br/>
<input type="text" id="ScheduledDelivery" name="ScheduledDelivery" value="" /> 
* 1207011545 (ปีเดือนวันชั่วโมงนาที)<br/>
<input type="submit" value="Send Now"/> <input type="reset" value="Reset" />
</form>
</body>
</html>