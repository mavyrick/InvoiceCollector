<!--
	// include_once("source/database.class.php");
	//
	// function get_db_conn() {
	// 	//These are the settings for your database connection
	// 	// 'Location' , 'User' , 'Password' , 'Database'
	// 		$db = mysqli_connect('us-cdbr-iron-east-03.cleardb.net', 'b89d1d0d390de1', 'cf33d27f'); //Create new connection
	// 		return $db; //Return the database connection
	// } -->
<?php

// mysql://b89d1d0d390de1:cf33d27f@us-cdbr-iron-east-03.cleardb.net/heroku_f99b13abac46a60?reconnect=true?

// include_once("source/database.class.php");

function get_db_conn() {

$url = parse_url(getenv("DATABASE_URL"));

$server = $url["host"];
$username = $url["user"];
$password = $url["pass"];
$db = substr($url["path"], 1);

// $conn = new mysqli($server, $username, $password, $db);
// $conn = new PDO("mysql:host=127.0.0.1", "root", "root", "sys");

// $conn = new PDO("mysql:host=$server;dbname=$db", $username, $password);

$conn = new PDO("mysql:host=127.0.0.1;dbname=sys", "root", "root");

return $conn;

}

?>
