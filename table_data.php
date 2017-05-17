<?php
session_start();

include_once("source/config.php");

$sql = get_db_conn();

if(isset($_GET["invoice_date"]) && strlen($_GET["invoice_date"])>0)
if(isset($_GET["invoice_number"]) && strlen($_GET["invoice_number"])>0)
if(isset($_GET["vendor"]) && strlen($_GET["vendor"])>0)
if(isset($_GET["subtotal"]) && strlen($_GET["subtotal"])>0)
if(isset($_GET["pst"]) && strlen($_GET["pst"])>0)
if(isset($_GET["gst"]) && strlen($_GET["gst"])>0)
{

    $invoice_date_save = filter_var($_GET["invoice_date"],FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
    $invoice_number_save = filter_var($_GET["invoice_number"],FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
    $vendor_save = filter_var($_GET["vendor"],FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
    $subtotal_save = filter_var($_GET["subtotal"],FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
    $pst_save = filter_var($_GET["pst"],FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
    $gst_save = filter_var($_GET["gst"],FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
    $total_save = $subtotal_save + ($pst_save/100 * $subtotal_save) + ($gst_save/100 * $subtotal_save);

    // $insert_row = $sql->query("SELECT `invoices` (invoice_date, invoice_number, vendor, subtotal, pst, gst, total) VALUES ('$invoice_date_save', '$invoice_number_save', '$vendor_save', '$subtotal_save', '$pst_save', '$gst_save', '$total_save')");

    $retrieve_data = $sql->query("SELECT * FROM `invoices`")

    if($retrieve_data)
    {
          $my_id = $sql->insert_id;

    }else{

        header('HTTP/1.1 500 Looks like mysql error, could not insert record!');
        exit();
    }

?>
