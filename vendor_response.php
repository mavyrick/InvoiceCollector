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


if(isset($_POST["vendor_title"]) && strlen($_POST["vendor_title"])>0)
if(isset($_POST["address"]) && strlen($_POST["address"])>0)
{

    $vendor_title_save = filter_var($_POST["vendor_title"],FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
    $address_save = filter_var($_POST["address"],FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);

    if ($stmt = $sql->prepare("SELECT * FROM `vendors` ORDER BY `id` DESC LIMIT 1") AND $stmt->execute(array()) AND $data = $stmt->fetch()) {

      $id_save = $data["id"];

        }

        $stmt = null;


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

    $insert_row = $sql->query("INSERT INTO `vendors` (vendor_title, address) VALUES ('$vendor_title_save', '$address_save')");

    // $stmt->bindParam(":ename", $invoice_date_save);
    // $stmt->bindParam(":edept", $invoice_number_save);
    // $stmt->bindParam(":esalary", $vendor_save);
    // $stmt->bindParam(":ename", $subtotal_save);
    // $stmt->bindParam(":edept", $pst_save);
    // $stmt->bindParam(":esalary", $gst_save);
    // $stmt->bindParam(":ename", $total);
    // $stmt->bindParam(":edept", $total_save);

    if($insert_row)
    {

        header('Content-Type: application/json');


          echo json_encode(array( 'vendor_title' => $vendor_title_save,
                                  'address' => $address_save,
                                  'id' => $id_save,
                                ));


        $my_id = $sql->insert_id;

        exit();

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


    	}

if(isset($_POST["vendorToDelete"]) && strlen($_POST["vendorToDelete"])>0 && is_numeric($_POST["vendorToDelete"]))
{


    $idToDelete = filter_var($_POST["vendorToDelete"],FILTER_SANITIZE_NUMBER_INT);

    $delete_row = $sql->query("DELETE FROM `vendors` WHERE `id` = $idToDelete");

    if(!$delete_row)
    {

        header('HTTP/1.1 500 Could not delete record!');
        exit();

    }

}
?>
