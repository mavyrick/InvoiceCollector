<?php
session_start();

// $conn = new PDO("mysql:host=127.0.0.1;dbname=sys", "root", "root");

// $url = parse_url(getenv("DATABASE_URL"));
//
// $server = $url["host"];
// $username = $url["user"];
// $password = $url["pass"];
// $db = substr($url["path"], 1);
//
// $conn = new PDO("mysql:host=$server;dbname=$db", $username, $password);


include_once("source/config.php");

$sql = get_db_conn();

if(isset($_POST["invoice_number"]) && strlen($_POST["invoice_number"])>0) {

$invoice_number_data = filter_var($_POST["invoice_number"],FILTER_SANITIZE_NUMBER_INT);

if ($stmt = $sql->prepare("SELECT 'invoice_number' FROM `invoices` WHERE `invoice_number` = $invoice_number_data") AND $stmt->execute(array()) AND $data = $stmt->fetchAll()) {

  if ($data >= 0) {

    echo "duplicate";

  }

  }

  }




?>
