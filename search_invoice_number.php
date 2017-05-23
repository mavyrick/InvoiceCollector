<?php

include_once("source/config.php");

$sql = get_db_conn();

if(isset($_POST["search-field"]) && strlen($_POST["search-field"])>0)

{

  $search_save = filter_var($_POST["search-field"],FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);

  if ($stmt = $sql->prepare("SELECT * FROM `invoices` WHERE `invoice_number` = $search_save") AND $stmt->execute(array()) AND $data = $stmt->fetch()) {

    $total_save = $data["subtotal"] + ($data["pst"]/100 * $data["subtotal"]) + ($data["gst"]/100 * $data["subtotal"]);

    echo "<tr id=" . "row_" . $data["id"] . ">";
    echo "<td>" . $data["invoice_date"] . "</td>";
    echo "<td>" . $data["invoice_number"] . "</td>";
    echo "<td>" . $data["vendor"] . "</td>";
    echo "<td>" . "$" . number_format((float)$data["subtotal"], 2, '.', '') . "</td>";
    echo "<td>" . "$" . number_format((float)$total_save, 2, '.', '') . "</td>";
    echo "<td>" . "<input type='submit' value='Delete' class='del_button btn btn-danger btn-sm' id=" . $data["id"] . ">" . "</td>";
    echo "</tr>";

  //   echo json_encode(array( 'invoice_date' => $data["invoice_date"],
  //   'invoice_number' => $data["invoice_number"],
  //   'vendor' => $data["vendor"],
  //   'subtotal' => $data["subtotal"],
  //   'total' => $total_save,
  //   'id' => $data["id"],
  // ));

    }

    $stmt = null;

    }

    ?>
