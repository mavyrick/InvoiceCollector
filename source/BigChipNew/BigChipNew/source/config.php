<?

	function get_db_conn() {
		//These are the settings for your database connection
		// 'Location' , 'User' , 'Password' , 'Database'
			$db = HowardSQL::Connect('localhost', 'myfr6168_dev002', 'JOSH002', 'myfr6168_dev002'); //Create new connection
			return $db; //Return the database connection
	}

?>
