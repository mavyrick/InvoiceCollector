<?

	// include_once("source/database.class.php");
	//
	// function get_db_conn() {
	// 	//These are the settings for your database connection
	// 	// 'Location' , 'User' , 'Password' , 'Database'
	// 		$db = mysqli_connect('us-cdbr-iron-east-03.cleardb.net', 'b89d1d0d390de1', 'cf33d27f'); //Create new connection
	// 		return $db; //Return the database connection
	// }

?>
<?php

$url = parse_url(getenv("mysql://b89d1d0d390de1:cf33d27f@us-cdbr-iron-east-03.cleardb.net/heroku_f99b13abac46a60?reconnect=true"));

$server = $url["us-cdbr-iron-east-03.cleardb.net"];
$username = $url["b89d1d0d390de1"];
$password = $url["cf33d27f"];
$db = substr($url["heroku_f99b13abac46a60"], 1);

$sql = new mysqli($server, $username, $password, $db);

?>
