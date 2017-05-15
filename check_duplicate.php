<?php
session_start();

// $conn = new PDO("mysql:host=127.0.0.1;dbname=sys", "root", "root");
$conn = new PDO("mysql:host=$server;dbname=$db", $username, $password);


// include_once("source/config.php");
//
// $sql = get_db_conn();

if(isset($_POST["invoice_number"]) && strlen($_POST["invoice_number"])>0) {

$invoice_number_data = filter_var($_POST["invoice_number"],FILTER_SANITIZE_NUMBER_INT);

// $stmt = $conn->query("SELECT `invoice_number` FROM `invoices` WHERE `invoice_number` = $invoice_number_data");
// $stmt->execute();
// $result = $stmt->fetch();
// $row = mysqli_fetch_array($duplicates);

// SELECT 'invoice_number' COUNT(*) FROM 'invoices' HAVING COUNT(*) > 1

// $stmt = $conn->prepare("SELECT 'invoice_number' FROM `invoices` WHERE `invoice_number` = $invoice_number_data");
// $dçata = $stmt->fetchColumn();
// foreach ($data as $i) {


if ($stmt = $sql->prepare("SELECT 'invoice_number' FROM `invoices` WHERE `invoice_number` = $invoice_number_data") AND $stmt->execute(array()) AND $data = $stmt->fetchAll()) {

  if ($data >= 0) {

    echo "duplicate";

  }

// if (strlen(implode("", $data)) >= 0) {
//   echo "Invoice number already taken.";
//   // $_SESSION["duplicate"] = "duplicate";
// }
// else {
//   exit();
// }

      //     if (($i["invoice_number"]) > 0) {
      //         $_SESSION["duplicate"] = "duplicate";
      //       }
      //       else {
      //         $_SESSION["duplicate"] = null;
      //         exit();
      //       }
      //
      // }

    }

  }




?>
