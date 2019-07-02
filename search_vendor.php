<?php

include_once("source/config.php");

$sql = get_db_conn();

if(isset($_POST["hidden_vendors"]) && strlen($_POST["hidden_vendors"])>0)

{

  $search_save = filter_var($_POST["hidden_vendors"],FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);

  if ($stmt = $sql->prepare("SELECT * FROM `invoices` WHERE `vendor` = '$search_save'") AND $stmt->execute(array()) AND $data = $stmt->fetchAll()) {
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
