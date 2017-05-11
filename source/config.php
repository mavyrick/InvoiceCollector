<?

	include_once("source/database.class.php");

	function get_db_conn() {
		//These are the settings for your database connection
		// 'Location' , 'User' , 'Password' , 'Database'
			$db = mysqli_connect('us-cdbr-iron-east-03.cleardb.net', 'b89d1d0d390de1', 'cf33d27f'); //Create new connection
			return $db; //Return the database connection
	}

?>
