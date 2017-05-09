<?php
session_start();

include_once("source/config.php");

$sql = get_db_conn();

// $invoice_number = $_POST['invoice_number'];
//
// $stmt = $sql->prepare("SELECT `invoice_number` FROM `invoices` WHERE `invoice_number` = '$invoice_number' ");
// $stmt->execute(array($_POST['invoice_number']));
// $result = $sql;
//
// if ($result == $invoice_number)
// {
//         $id_exists = true;
// }
//
// elseif ($result != $result)
// {
//         $id_exists = false;
//
//         exit();
// }


if(isset($_POST["invoice_date"]) && strlen($_POST["invoice_date"])>0)
if(isset($_POST["invoice_number"]) && strlen($_POST["invoice_number"])>0)
if(isset($_POST["vendor"]) && strlen($_POST["vendor"])>0)
if(isset($_POST["subtotal"]) && strlen($_POST["subtotal"])>0)
if(isset($_POST["pst"]) && strlen($_POST["pst"])>0)
if(isset($_POST["gst"]) && strlen($_POST["gst"])>0)
{

    $invoice_date_save = filter_var($_POST["invoice_date"],FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
    $invoice_number_save = filter_var($_POST["invoice_number"],FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
    $vendor_save = filter_var($_POST["vendor"],FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
    $subtotal_save = filter_var($_POST["subtotal"],FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
    $pst_save = filter_var($_POST["pst"],FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
    $gst_save = filter_var($_POST["gst"],FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
    $total_save = $subtotal_save + ($pst_save/100 * $subtotal_save) + ($gst_save/100 * $subtotal_save);


  //  {
  //      echo('NUMBER_AVAILABLE');
  //  }
  //  else
  //  {
  //      echo('NUMBER_EXISTS');
  //  }

    // if ($result == $invoice_number_save)
    // {
    //         $id_exists = true;
    // }
    //
    // elseif ($result != $result)
    // {
    //         $id_exists = false;
    //
    //         exit();
    // }

    $insert_row = $sql->query("INSERT INTO `invoices` (invoice_date, invoice_number, vendor, subtotal, pst, gst, total) VALUES ('$invoice_date_save', '$invoice_number_save', '$vendor_save', '$subtotal_save', '$pst_save', '$gst_save', '$total_save')");

    if($insert_row)
    {
          $my_id = $sql->insert_id;

    }else{

        header('HTTP/1.1 500 Looks like mysql error, could not insert record!');
        exit();
    }

    // if ($stmt = $sql->prepare("SELECT `invoice_number` FROM `invoices` WHERE `invoice_number` = $invoice_number_save LIMIT 2") AND $stmt->execute(array("1")) AND $data = $stmt->fetch()) {
    //
    //   echo $data;
  	// }
  	// else {
    //
  	// }

    // if ($stmt = $sql->prepare("SELECT `invoice_number` FROM `invoices` WHERE `invoice_number` = $invoice_number_save LIMIT 2") AND $stmt->execute(array()) AND $data = $stmt->fetchAll()) {
    // 					foreach ($data as $i) {
    //
    //           if ($i["invoice_number"] == ($invoice_number_save . $number_number_save))
    //             {
    //               echo "i";
    //             }
    //             else {
    //
    //             }
    //     	}
    //   }
    //
    // 				$stmt = null;


    // $stmt = $sql->prepare("SELECT `invoice_number` FROM `invoices` WHERE `invoice_number` = $invoice_number_save");
    // $stmt->execute(array($_POST['invoice_number']));
    //
    // echo $stmt['invoice_number']

  //  if($row)
  //  {
  //      echo 'login';
  //  }
  //  else
  //  {
  //      echo "error";
  //  }

    // $count = $stmt->rowCount();
    //
    // echo $count;

    $_SESSION["duplicate"] = "";

    if ($stmt = $sql->prepare("SELECT `invoice_number` FROM `invoices` WHERE `invoice_number` = $invoice_number_data ") AND $stmt->execute(array()) AND $data = $stmt->fetchAll()) {

    					if (count($data) > 0)
    						{
    							$_SESSION["duplicate"] = "duplicate";
    						}

    			}
    	}


if(isset($_POST["recordToDelete"]) && strlen($_POST["recordToDelete"])>0 && is_numeric($_POST["recordToDelete"]))
{


    $idToDelete = filter_var($_POST["recordToDelete"],FILTER_SANITIZE_NUMBER_INT);

    $delete_row = $sql->query("DELETE FROM `invoices` WHERE `id` = $idToDelete");

    if(!$delete_row)
    {

        header('HTTP/1.1 500 Could not delete record!');
        exit();

    }

}
?>
