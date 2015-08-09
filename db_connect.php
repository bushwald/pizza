<?php
$host = "bushwald-pizza-1695243";
$user = "bushwald";
$pass = "";
$db = "pizza_db";
$port = 3306;

//$conn = mysqli_connect($host, $user, $pass, $db, $port)or die(mysql_error());

//Create Connection
$mysqli = new mysqli($host, $user, $pass, $db, $port);

// Check Connection
if ($mysqli->connect_errno) {
	printf("Connect failed: %s\n", $mysqli->connect_error);
}

?>