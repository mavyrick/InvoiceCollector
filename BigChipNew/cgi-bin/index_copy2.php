<!DOCTYPE html>
<html>
	<head>
		<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous"> -->
		<meta charset="utf-8">
		<title>Invoice Collector</title>

		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

		<script>

		// function showTable(invoiceNumber, invoiceDate, vendor, total) {
		//     if (invoiceNumber == "" || invoiceDate == "" || vendor == "" || total == "") {
		//         document.getElementById("empty").innerHTML = "";
		//         return;
		//     } else {
		//         if (window.XMLHttpRequest) {
		//             xmlhttp = new XMLHttpRequest();
		//         } else {
		//             xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		//         }
		//         xmlhttp.onreadystatechange = function() {
		//             if (this.readyState == 4 && this.status == 200) {
		//                 document.getElementById("txtHint").innerHTML = this.responseText;
		//             }
		//         };
		//         xmlhttp.open("GET","index.php?q="+str,true);
		//         xmlhttp.send();
		//     }
		// }

		// $(function () {
		//
		// 	$('#collection_form').on('submit', function (e) {
		//
		// 		e.preventDefault();
		//
		// 		$.ajax({
		// 			type: 'post',
		// 			url: 'index.php',
		// 			data: $('#collection_form').serialize(),
		// 			success: function () {
		// 				alert('Form was submitted');
		// 			}
		// 		});
		//
		// 	});
		//
		// });


		$(document).ready(function(){
		$("#submit").click(function(){
		var invoice_date = $("#invoice_date").val();
		var invoice_number = $("#invoice_number").val();
		var vendor = $("#vendor").val();
		var subtotal = $("#subtotal").val();
		var gst = $("#gst").val();
		var pst = $("#pst").val();
		// Returns successful data submission message when the entered information is stored in database.
		var dataString = 'name1='+ name + '&email1='+ email + '&password1='+ password + '&contact1='+ contact;
		if(invoice_date==''||invoice_number==''||vendor==''||subtotal=='')
			{
			alert("Please Fill All Fields");
			}
		else
			{
			// AJAX Code To Submit Form.
			$.ajax({
			type: "POST",
			url: "index.php",
			data: dataString,
			cache: false,
			success: function(result){
				alert(result);
			}
		});
		}
			return false;
		});
		});
		</script>

	</head>
	<body>

		<?

			//Include required database connection files
			include "source/database.class.php";
			include "source/config.php";

			//Init the connection into a variable
			$sql = get_db_conn();

			//Setup a query
			// $query = "SELECT `value` FROM `test`";

			$vendor_data = "SELECT * FROM `vendors`";

			$invoice_data = "SELECT * FROM `invoices`";

			//When using fetch() you need to close the prepared statement otherwise the next
			// time you try to prepare another statement it will fail
			$stmt = null;

			/*

				To get multiple rows it is better to use the function fetchAll() instead of fetch() ...

				$query = "SELECT * FROM `vendors` WHERE `status` = 'Online' ORDER BY `title` ASC";

				//Notice how even though we have no variables, I still need to pass an empty array
				//	in the "execute" function
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

		$link = mysqli_connect('localhost', 'myfr6168_dev002', 'JOSH002', 'myfr6168_dev002');

		if($link === false){
		    die("ERROR: Could not connect. " . mysqli_connect_error());
		}

		$invoice_date = mysqli_real_escape_string($link, $_POST['invoice_date']);
		$invoice_number = mysqli_real_escape_string($link, $_POST['invoice_number']);
		$vendor = mysqli_real_escape_string($link, $_POST['vendor']);
		$subtotal = mysqli_real_escape_string($link, $_POST['subtotal']);
		$pst = mysqli_real_escape_string($link, $_POST['pst']);
		$gst = mysqli_real_escape_string($link, $_POST['gst']);
		$total = "$" . (($subtotal) + (($subtotal/100) * $pst) + (($subtotal/100) * $gst));

		// $total = mysqli_real_escape_string($link, $_REQUEST['total']);

		// $total = ($subtotal + ($subtotal * $pst) + ($subtotal * $gst));

		$sql_insert = "INSERT INTO `invoices` (invoice_date, invoice_number, vendor, subtotal, pst, gst, total) VALUES ('$invoice_date', '$invoice_number', '$vendor', '$subtotal', '$pst', '$gst', '$total')";
		if(mysqli_query($link, $sql_insert)){
		    echo "Records added successfully.";
		} else{
		    echo "ERROR: Could not able to execute $sql_insert. " . mysqli_error($link);
		}

		// $sql_delete = "DELETE FROM `invoices` WHERE `invoice_number`=$invoice_number";
		// if(mysqli_query($link, $sql_delete)){
		//     echo "Record deleted successfully.";
		// } else{
		//     echo "ERROR: Could not able to execute $sql_delete. " . mysqli_error($link);
		// }

		mysqli_close($link);

		// if ($stmt = $sql->prepare($invoice_data) AND $stmt->execute(array()) AND $data = $stmt->fetchAll()) {
		// {

			// $invoice_data["total"] = (((float)$invoice_data["subtotal"]) + ((float)$invoice_data["subtotal"] * (float)$invoice_data["pst"]) + (float)($invoice_data["subtotal"] * (float)$invoice_data["gst"]));

		// }

		if (count($_POST) > 0) {
			if (!empty($_POST['invoice_number'])){
			 }
		}

	?>

		<h1>Invoice Collector</h1>

		<h2>Enter an Invoice<h2>

		<form action="index.php" method="post" name="form" id="collection_form">
	  	Invoice Date:<br>
	  <input type="date" name="invoice_date" id="invoice_date">
	  <br>
	  	Invoice Number:<br>
	  <input type="text" name="invoice_number" id="invoice_number">
		<br>
	  	Vendor:<br>
			<select name="vendor" id="vendor">
				<?
				if ($stmt = $sql->prepare($vendor_data) AND $stmt->execute(array()) AND $data = $stmt->fetchAll()) {
					foreach ($data as $i) {
						?>
						<option name=<? echo $i["vendor_title"]?>><? echo $i["vendor_title"] ?></option>;
						<?
					}
				}
				?>
			</select>
	  <br>
	  	Subtotal:<br>
	  <input type="text" name="subtotal" id="subtotal">
		<br>
	  	PST %:<br>
	  <input type="text" name="pst" id="pst">
		<br>
	  	GST %:<br>
	  <input type="text" name="gst" id="gst">
	  <br><br>

	  <input type="submit" value="Submit" name="submit" id="submit">
		</form>

		<hr>

		<h1>All Invoices</h1>

		<table>
  		<tr>
    <th>Invoice Number</th>
    <th>Date</th>
    <th>Vendor</th>
		<th>Subtotal</th>
		<th>Total</th>
		<th>Delete</th>
  		</tr>
  <tr>
		<?
		if ($stmt = $sql->prepare($invoice_data) AND $stmt->execute(array()) AND $data = $stmt->fetchAll()) {
			foreach ($data as $i) {
		?>
		<td><? echo $i["invoice_number"];?></td>
		<td><? echo $i["invoice_date"];?></td>
		<td><? echo $i["vendor"];?></td>
		<td><? echo $i["subtotal"];?></td>
		<td><? echo $i["total"];?></td>
		<td>
			<form action="index.php" method="post" name="delete">
				<input type="submit" value="Delete" name="delete">
			</form>
		</td>
	</tr>
		<?
			}
		}
		?>
</table>

	</body>
</html>
