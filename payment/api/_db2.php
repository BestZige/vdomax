<?
	
	global $db2;
	$db2 = connect();
	function connect() {
		global $error;
		$db2 = new mysqli("localhost", "payment", "payment7410", "payment");
		if ($db2 === false) {
			$error = 'มีปัญหาในการเชื่อมต่อกับฐานข้อมูล';
			return null;
		}
		return $db2;
	}

function current_db() {
	$db2 = connect();
	if ($result = $db2->query("SELECT DATABASE()")) {
		$row = $result->fetch_row();
    	printf("Default database is %s.\n", $row[0]);
	    $result->close();
	}
}

function retrieve($sql) {
	global $error;
	$db2 = connect();
	$db2->select_db("payment");
	$result = $db2->query($sql) or SQLError();
echo $sql;
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
