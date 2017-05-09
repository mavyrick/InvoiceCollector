<?php

//include db configuration file
include_once("source/config.php");

$sql = get_db_conn();

if(isset($_POST["invoice_date"]) && strlen($_POST["invoice_date"])>0)
if(isset($_POST["invoice_number"]) && strlen($_POST["invoice_number"])>0)
if(isset($_POST["vendor"]) && strlen($_POST["vendor"])>0)
if(isset($_POST["subtotal"]) && strlen($_POST["subtotal"])>0)
if(isset($_POST["pst"]) && strlen($_POST["pst"])>0)
if(isset($_POST["gst"]) && strlen($_POST["gst"])>0)
{   //check $_POST["content_txt"] is not empty

    //sanitize post value, PHP filter FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH Strip tags, encode special characters.
    $invoice_date_save = filter_var($_POST["invoice_date"],FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
    $invoice_number_save = filter_var($_POST["invoice_number"],FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
    $vendor_save = filter_var($_POST["vendor"],FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
    $subtotal_save = filter_var($_POST["subtotal"],FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
    $pst_save = filter_var($_POST["pst"],FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
    $gst_save = filter_var($_POST["gst"],FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
    $total_save = $subtotal_save + ($pst_save/100 * $subtotal_save) + ($gst_save/100 * $subtotal_save);
    // Insert sanitize string in record
    $insert_row = $sql->query("INSERT INTO `invoices` (invoice_date, invoice_number, vendor, subtotal, pst, gst, total) VALUES ('$invoice_date_save', '$invoice_number_save', '$vendor_save', '$subtotal_save', '$pst_save', '$gst_save', '$total_save')");

    if($insert_row)
    {
         //Record was successfully inserted, respond result back to index page
          $my_id = $sql->insert_id; //Get ID of last inserted row from MySQL
          echo '<li id="item_'.$my_id.'">';
          echo '<div class="del_wrapper"><a href="#" class="del_button" id="del-'.$my_id.'">';
          echo '<img src="images/icon_del.gif" border="0" />';
          echo '</a></div>';
          echo $invoice_date_save.'</li>';

    }else{

        //header('HTTP/1.1 500 '.mysql_error()); //display sql errors.. must not output sql errors in live mode.
        header('HTTP/1.1 500 Looks like mysql error, could not insert record!');
        exit();
    }

}

elseif(isset($_POST["id"]) && strlen($_POST["id"])>0 && is_numeric($_POST["id"]))
{   //do we have a delete request? $_POST["recordToDelete"]

    //sanitize post value, PHP filter FILTER_SANITIZE_NUMBER_INT removes all characters except digits, plus and minus sign.
    $id = filter_var($_POST["id"],FILTER_SANITIZE_NUMBER_INT);

    //try deleting record using the record ID we received from POST
    $delete_row = $sql->query("DELETE FROM `invoices` WHERE id=".$id);

    if(!$delete_row)
    {
        //If mysql delete query was unsuccessful, output error
        header('HTTP/1.1 500 Could not delete record!');
        exit();
    }
}
else
{
    //Output error
    header('HTTP/1.1 500 Error occurred, Could not process request!');
    exit();

    }

?>
