<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>.: ThaiBulkSMS :.</title>
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8"/>
</head>

<body>
<h2>Demo Send SMS Form</h2>
<form id="send_sms" name="send_sms" method="post" action="check_credit.php">
Username<br/>
<input type="text" id="username" name="username" value="kriangkrai" /><br/>
Password<br/>
<input type="text" id="password" name="password" value="123456" /><br/>
Credit Type<br/>
<select id="force" name="force">
<option value="credit_remain" selected="selected">Standard</option>
<option value="credit_remain_premium">Premium</option>
</select><br/>
<input type="submit" value="Send Now"/> <input type="reset" value="Reset" />
</form>
</body>
</html>