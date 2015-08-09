<?php
$host = "****";
$user = "bushwald";
$pass = "****";
$db = "****";
$port = ****;

//Create Connection
$mysqli = new mysqli($host, $user, $pass, $db, $port);

// Check Connection
if ($mysqli->connect_errno) {
	printf("Connect failed: %s\n", $mysqli->connect_error);
}

?>
