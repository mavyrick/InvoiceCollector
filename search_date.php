<?php

include_once("source/config.php");

$sql = get_db_conn();

if(isset($_POST["date_field_1"]) && strlen($_POST["date_field_1"])>0)
if(isset($_POST["date_field_2"]) && strlen($_POST["date_field_2"])>0)

{

  $date_save_1 = filter_var($_POST["date_field_1"]);
  $date_save_2 = filter_var($_POST["date_field_2"]);


  if ($stmt = $sql->prepare("SELECT * FROM `invoices` WHERE `invoice_date` BETWEEN '$date_save_1' AND '$date_save_2' ORDER BY `invoice_date` DESC") AND $stmt->execute(array()) AND $data = $stmt->fetchAll()) {
    foreach ($data as $i) {

      $total_save = $i["subtotal"] + ($i["pst"]/100 * $i["subtotal"]) + ($i["gst"]/100 * $i["subtotal"]);

      echo "<tr id=" . "row_" . $i["id"] . ">";
      echo "<td>" . $i["invoice_date"] . "</td>";
      echo "<td>" . $i["invoice_number"] . "</td>";
      echo "<td>" . $i["vendor"] . "</td>";
      echo "<td>" . "$" . number_format((float)$i["subtotal"], 2, '.', '') . "</td>";
      echo "<td>" . "$" . number_format((float)$total_save, 2, '.', '') . "</td>";
      echo "<td>" . "<input type='submit' value='Delete' class='del_button btn btn-danger btn-sm' id=" . $i["id"] . ">" . "</td>";
      echo "</tr>";

    }

  }
    $stmt = null;


  }

    ?>
