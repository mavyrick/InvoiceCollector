<?php

	/* 	################################################
		BADIEE.OS Database class file
			Database access and query handler
			for all instalments of BADIEE.OS

			!! This file should not be modified !!

		Author: Brian Howard
		Revision Date: May 27, 2012
		################################################  */

class HowardSQL extends PDO {

	var $_db_linkid = 0;
	var $_db_qresult = 0;
	var $_auto_commit = false;
	var $RowData = array();
	var $NextRowNumber = 0;
	var $RowCount = 0;
	var $_db_qresult_ex = array();
	var $RowDataEx = array();
	var $RowCountEx = array();
	var $NextRowNumberEx = array();

	public static $recent = null;
	public static $totalconnections = 0;
	public static $host;

	public static $database = array();

	protected static $dbconn = array();

	function __construct($host, $user, $pass, $database="") {
		if ($user AND $pass AND $host AND $database) {
			//Construct the database connection with mysqli
			$dsn = "mysql:host=" . $host . ";dbname=" . $database;
			try {
					self::$totalconnections++;

					return parent::__construct($dsn, $user, $pass);



			}
			catch(PDOException $dbError) {
				$error = "The connection could not be established, fatal error caught by the handler.  Make sure your PHP and MySQL versions are up to date and support PDO.";
				trigger_error($error);
				return false;
			}
		}
		else {
			$error = "Bad mysql connection attempt, please verify parameters\n\tHost: " . $host . "\n\tDatabase: " . $database . "\n\tUser: " . $user . "\n\tUsing Password: " . ($pass ? "YES" : "NO") . "";
			trigger_error($error);
			return false;
		}
	}

	public static function Connect($host, $user, $pass, $database) {
		if (!in_array($database, self::$database)) {
			if ($newconn = new HowardSQL($host, $user, $pass, $database)) {

				//Assign instance number to new connection
				self::$dbconn[$database] = $newconn;
				$newconn->setAttribute(PDO::ATTR_EMULATE_PREPARES,false);

				self::$database[] = $database;
				self::$recent = $database;
				self::$host = $host;

				$newconn->query("SET time_zone = '+00:00';");

				if (isset($_SESSION["uid"]) AND is_numeric($_SESSION["uid"])) {
					$newconn->query("SET @myUserId:=" . $_SESSION["uid"] . ";");
				}

				return $newconn;
			}
			else {
				trigger_error("Could not connect to the database '" . $database . "' on '" . $host . "', check your username and password and try again");
				//exit();
				return false;
			}

		}
		else {
			//Find connection
			if (self::$dbconn[$database]) {
				self::$recent = $database;
				return self::$dbconn[$database];
			}
			else {
				trigger_error("Database existed in master list, but no connection was found");
				return false;
			}
		}
	}

	private function GetLastConn() {

		if (isset(self::$recent)) return self::$dbconn[self::$recent];
		else return false;

	}

	function prepare($querystr, $options = array()) {

		if ($sth = parent::prepare($querystr)) {
			return $sth;
		}
		else {
			// Database Prepare Error
			$arr = parent::errorInfo();
			$trace = debug_backtrace(3);
			trigger_error("MySQL PDO Prepare Error: " . $arr[2] . "\n\tQuery: " . $querystr . "\n\tLine: " . $trace[0]['file'] . " (" . $trace[0]['line'] . ")\n\tLine: " . $trace[1]['file'] . " (" . $trace[1]['line'] . ")\n\tLine: " . $trace[2]['file'] . " (" . $trace[2]['line'] . ")");
			return false;
		}

	}


	function Query($querystr) {

		if ($sql = $this->GetLastConn()) {
			//Reset pointer to 0
			$this->NextRowNumber = 0;

			//Run the statement
			if ($sth = $sql::prepare($querystr)) {
				if ($sth->execute()) {
					$this->_qresult = $sth->fetchAll();
					$this->RowCount = $sth->rowCount();
					return true;
				}
				else {
					$arr = $sth->errorInfo();
					$trace = debug_backtrace(1);
					$error = "The MySQL connection was established (" . self::$host . " / " . self::$recent . ") , and a query prepared, but the query could not be executed.\n\tQuery: " . $querystr . "\n\t\tError:" . $arr[2] . "\n\t\tLine: " . $trace[0]['file'] . " (" . $trace[0]['line'] . ")";
					trigger_error($error);
					return false;
				}
			}
			else {
				$arr = $sql->errorInfo();
				$trace = debug_backtrace(1);
				$error = "The MySQL connection was established (" . self::$host . " / " . self::$recent . "), but the query could not be prepared.  Make sure your MySQL and PHP versions are up to date and meet requirements.\n\tQuery: " . $querystr . "\n\tError: " . $arr[2] . "\n\tLine: " . $trace[0]['file'] . " (" . $trace[0]['line'] . ")";
				trigger_error($error);
				return false;
			}
		}
		else {
			trigger_error("No recent database connection existed\n\tQuery: " . $querystr);
			return false;
		}
	}

	function ReadRow() {
		if (isset($this->_qresult[$this->NextRowNumber])) {
			if ($this->RowData = $this->_qresult[$this->NextRowNumber]) {
				$this->NextRowNumber++;
				return 1;
			}
			else return false;
		}
		else return false;
	}

	function ReadRowAsObj() {
		return parent::fetch_object ($this->_qresult);
	}


	function NumberRows() {
		if ($this->RowCount > 0) return $this->RowCount;
		else return false;
	}

	function ShowSetValues( $table , $field ){
		$query = "SHOW COLUMNS FROM `$table` LIKE '$field'";
		$result = parent::query($query) or die( 'Error getting Enum/Set field ' . mysqli_error() );
		$row = mysqli_fetch_array($result);
		if(stripos(".".$row[1],"enum(") > 0) $row[1]=str_replace("enum('","",$row[1]);
		else $row[1]=str_replace("set('","",$row[1]);
		$row[1]=str_replace("','","\n",$row[1]);
		$row[1]=str_replace("')","",$row[1]);
		$ar = split("\n",$row[1]);
		for ($i=0;$i<count($ar);$i++) $arOut[str_replace("''","'",$ar[$i])]=str_replace("''","'",$ar[$i]);
		return $arOut ;
	}

	function GetNewID() {
		//mysql_insert_id!!!
		return parent::lastInsertId();
	}

}


?>
