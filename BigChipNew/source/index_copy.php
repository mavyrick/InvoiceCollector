<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Invoice Collector</title>
	</head>
	<body>

		<?

			//Include required database connection files

			//Init the connection into a variable
			$sql = get_db_conn();

			//Setup a query
			// $query = "SELECT `value` FROM `test`";

			$vendor_title = "SELECT * FROM `vendors`";

			$invoice_data = "SELECT * FROM `invoices`";

			//Prepare, execute and fetch the single row if it exists
			// if ($stmt = $sql->prepare($query) AND $stmt->execute(array()) AND $data = $stmt->fetch()) {
			// 	foreach ($data as $i) {
			// 		echo "Hi " . $i . " ";
			// 	}
			// }
			// else {
			// 	echo "Hi Nobody!";
			// }
			if ($stmt = $sql->prepare($vendor_title) AND $stmt->execute(array()) AND $data = $stmt->fetchAll()) {
				foreach ($data as $i) {
					echo $i["vendor_title"];
				}
			}
			else {
				echo "Hi Nobody!";
			}

			//When using fetch() you need to close the prepared statement otherwise the next
			// time you try to prepare another statement it will fail
			$stmt = null;

			/*

				To get multiple rows it is better to use the function fetchAll() instead of fetch() ...

				$query = "SELECT * FROM `vendors` WHERE `status` = 'Online' ORDER BY `title` ASC";

				//Notice how even though we have no variables, I still need to pass an empty array
				//	in the "execute" function
				if ($stmt = $sql->prepare($query) AND $stmt->execute(array()) AND $data = $stmt->fetchAll()) {

					foreach ($data as $vendor) {

						echo "Vendor Title: " . $vendor["title"] . "<br />";

					}

				}

				To Insert into the database you can use a query setup like this ...

				$query = "INSERT INTO `vendors` (`title`, `description`, `status`) VALUES(?,?,'Online')";

				if ($stmt = $sql->prepare($query) AND is_array($newVendors)) {

					foreach ($newVendors as $vendor) {

						//Execute the prepared statement
						$stmt->execute(array($vendor["title"], $vendor["description"]));

						//No need to fetch, as we are not returning anything - but to get the last id

						$vendorList[$vendor["title"]] = $sql->lastInsertId();

					}

				}

			*/

		// $link = mysqli_connect('localhost', 'myfr6168_dev002', 'JOSH002', 'myfr6168_dev002');
		//
		// if($link === false){
		//     die("ERROR: Could not connect. " . mysqli_connect_error());
		// }
		//
		// $invoice_date = mysqli_real_escape_string($link, $_REQUEST['invoice_date']);
		// $invoice_number = mysqli_real_escape_string($link, $_REQUEST['invoice_number']);
		// $vendor = mysqli_real_escape_string($link, $_REQUEST['vendor']);
		// $subtotal = mysqli_real_escape_string($link, $_REQUEST['subtotal']);
		// $pst = mysqli_real_escape_string($link, $_REQUEST['pst']);
		// $gst = mysqli_real_escape_string($link, $_REQUEST['gst']);
		// $total = mysqli_real_escape_string($link, $_REQUEST['total']);
		//
		// $sql_insert = "INSERT INTO `invoices` (invoice_date, invoice_number, vendor, subtotal, pst, gst, total) VALUES ('$invoice_date', '$invoice_number', '$vendor', '$subtotal', '$pst', '$gst', '$total')";
		// if(mysqli_query($link, $sql_insert)){
		//     echo "Records added successfully.";
		// } else{
		//     echo "ERROR: Could not able to execute $sql_insert. " . mysqli_error($link);
		// }
		//
		// mysqli_close($link);

	?>

		<h1>Invoice Collector</h1>

		<h2>Enter an Invoice<h2>

		<form action="/index.php" method="post">
	  	Invoice Date:<br>
	  <input type="date" name="invoice_date">
	  <br>
	  	Invoice Number:<br>
	  <input type="text" name="invoice_number">
		<br>
	  	Vendor:<br>
			<select name="vendor">
				<?
				if ($stmt = $sql->prepare($vendor_title) AND $stmt->execute(array()) AND $data = $stmt->fetchAll()) {
					foreach ($data as $i) {
						?>
						<option value=<? echo $i["vendor_title"]?>><? echo $i["vendor_title"] ?></option>;
						<?
					}
				}
				?>
			</select>
	  <br>
	  	Subtotal:<br>
	  <input type="text" name="subtotal">
		<br>
	  	PST:<br>
	  <input type="text" name="pst">
		<br>
	  	GST:<br>
	  <input type="text" name="gst">
	  <br><br>
	  <input type="submit" value="Submit">
		</form>

<? $data["value"] ?>

		<hr>

		<!-- <h1>Display All Invoices</h1>

		<table>
  		<tr>
    <th>Invoice Number</th>
    <th>Date</th>
    <th>Vendor</th>
		<th>Total</th>
  		</tr>
  <tr>
		<?
		if ($stmt = $sql->prepare($invoice_data) AND $stmt->execute(array()) AND $data = $stmt->fetchAll()) {
			foreach ($data as $i) {
		?>
		<td><? echo $i["invoice_number"];?></td>
		<td><? echo $i["invoice_date"];?></td>
		<td><? echo $i["vendor"];?></td>
		<td><? echo $i["total"];?></td>
	</tr>
		<?
			}
		}
		?>
</table> -->

	</body>
</html>
