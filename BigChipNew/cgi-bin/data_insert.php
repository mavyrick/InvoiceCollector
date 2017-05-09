<?

$link = mysqli_connect('localhost', 'myfr6168_dev002', 'JOSH002', 'myfr6168_dev002');

if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

$invoice_date = mysqli_real_escape_string($link, $_REQUEST['invoice_date']);
$invoice_number = mysqli_real_escape_string($link, $_REQUEST['invoice_number']);
$vendor = mysqli_real_escape_string($link, $_REQUEST['vendor']);
$subtotal = mysqli_real_escape_string($link, $_REQUEST['subtotal']);
$pst = mysqli_real_escape_string($link, $_REQUEST['pst']);
$gst = mysqli_real_escape_string($link, $_REQUEST['gst']);
$total = mysqli_real_escape_string($link, $_REQUEST['total']);

$sql_insert = "INSERT INTO `invoices` (invoice_date, invoice_number, vendor, subtotal, pst, gst, total) VALUES ('$invoice_date', '$invoice_number', '$vendor', '$subtotal', '$pst', '$gst', '$total')";
if(mysqli_query($link, $sql_insert)){
    echo "Records added successfully.";
} else{
    echo "ERROR: Could not able to execute $sql_insert. " . mysqli_error($link);
}

mysqli_close($link);

?>
