<?php

include_once("source/config.php");

$sql = get_db_conn();

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
