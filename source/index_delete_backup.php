<!DOCTYPE html>
<html>
	<head>
		<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous"> -->
		<meta charset="utf-8">
		<title>Invoice Collector</title>

		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

		<script>

		// $(document).ready(function(){
		// $("#submit").click(function(){
		// var invoice_date = $("#invoice_date").val();
		// var invoice_number = $("#invoice_number").val();
		// var vendor = $("#vendor").val();
		// var subtotal = $("#subtotal").val();
		// var gst = $("#gst").val();
		// var pst = $("#pst").val();
		// // Returns successful data submission message when the entered information is stored in database.
		// var dataString = 'invoice_date='+ invoice_date + '&invoice_number='+ invoice_number + '&vendor='+ vendor + '&subtotal='+ subtotal + '&gst='+ gst + '&pst='+ pst;
		// if(invoice_date==''||invoice_number==''||vendor==''||subtotal=='')
		// 	{
		// 	alert("Please Fill Required Fields");
		// 	}
		// else
		// 	{
		// 	// AJAX Code To Submit Form.
		// 	$.ajax({
		// 	type: "POST",
		// 	url: "index.php",
		// 	data: dataString,
		// 	cache: false,
		// 	success: function(result){
		// 		// alert(result);
		// 	}
		// });
		// }
		// 	return false;
		// });
		// });

		</script>

	</head>
	<body>

		<?

			//Include required database connection files
			include "source/database.class.php";
			include "source/config.php";
			include "response.php";
			// include "config.php";

			//Init the connection into a variable
			$sql = get_db_conn();

			$vendor_data = "SELECT * FROM `vendors`";

			$invoice_data = "SELECT * FROM `invoices`";

			$last_entry = "SELECT * FROM `invoices` ORDER BY `id` DESC LIMIT 1";

			// $delete_entry = "DELETE * FROM"

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

		// if ($stmt = $sql->prepare($invoice_data) AND $stmt->execute(array()) AND $data = $stmt->fetchAll()) {
		// {

			// $invoice_data["total"] = (((float)$invoice_data["subtotal"]) + ((float)$invoice_data["subtotal"] * (float)$invoice_data["pst"]) + (float)($invoice_data["subtotal"] * (float)$invoice_data["gst"]));

		// }

		// if (count($_POST) > 0) {
		// 	if (!empty($_POST['invoice_number'])){
		// 	 }
		// }

	?>

	<div id="collector">

		<h1>Invoice Collector</h1>

		<h2>Enter an Invoice<h2>

		<form action="response.php" method="post" name="form" id="collection_form">
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

				$stmt = null;
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

	</div>

	<div id="list">

		<!-- <hr> -->

		<h1>All Invoices</h1>

		<table id="headers">
  	<tr>
	    <th>Date</th>
	    <th>Invoice Number</th>
	    <th>Vendor</th>
			<th>Subtotal</th>
			<th>Total</th>
			<th>Delete</th>
		</tr>
	</table>

	<table id="data_table">

	</table>

</div>

	</body>

<script>

    // var frm = $('#collection_form');
    // frm.submit(function (ev) {
    //     $.ajax({
    //         type: frm.attr('POST'),
    //         url: frm.attr('data_connection.php'),
    //         data: frm.serialize(),
    //         success: function (data) {
    //             alert('ok');
    //         }
    //     });
		//
    //     ev.preventDefault();
    // });

		$(document).ready(function() {

			<?
			if ($stmt = $sql->prepare($invoice_data) AND $stmt->execute(array()) AND $data = $stmt->fetchAll()) {
				foreach ($data as $i) {

						?>
							$("#data_table").append("<?	echo "<tr>";
																					echo "<td>" . $i["invoice_date"] . "</td>";
																					echo "<td>" . $i["invoice_number"] . "</td>";
																					echo "<td>" . $i["vendor"] . "</td>";
																					echo "<td>" . $i["subtotal"] . "</td>";
																					echo "<td>" . $i["total"] . "</td>";
																					echo "<td>" . "<form>" . "<input type='submit' value='Delete' name=" . $i["id"] . " id=" . $i["id"] . ">" . "</form>" . "</td>";
																					echo "</tr>"; ?>");
						<?
				}
			}

			$stmt = null;
			?>

    //##### send add record Ajax request to response.php #########

    $("#collection_form").on("submit", function(e){
            e.preventDefault();

            if(($("#invoice_number").val()==='') || ($("#invoice_date").val()==='') || ($("#vendor").val()==='') || ($("#subtotal").val()===''))
            {
                alert("A required field is blank.");
                return false;
            }

            // var myData = {
						// 	"invoice_number":"$("#invoice_number").val()",
						//  	"invoice_date":"$("#invoice_date").val()",
						// 	"vendor":"$("#vendor").val()",
						// 	"subtotal":"$("#subtotal").val()",
						// 	"pst":"$("#pst").val()",
						// 	"gst":"$("#gst").val()"
						// };
						// 	}
						// 'invoice_number='+ $("#invoice_number").val()
						// + 'invoice_date='+ $("#invoice_date").val()
						// + 'vendor='+ $("#vendor").val()
						// + 'subtotal='+ $("#subtotal").val()
						// + 'gst='+ $("#gst").val()
						// + 'pst='+ $("#pst"); //build a post data structure
						// var myData = 'invoice_number='+ $("#invoice_number").val();
            $.ajax({
            type: "POST", // HTTP method POST or GET
						url: "response.php", //Where to make Ajax calls
            dataType: "text", // Data type, HTML, json etc.
            data: $('#collection_form').serialize(), //Form variables
            success:function(response){

							var total = (parseFloat($("#subtotal").val()) + (parseFloat($("#pst").val())/100 * parseFloat($("#subtotal").val())) + (parseFloat($("#gst").val())/100 * parseFloat($("#subtotal").val()))).toFixed(2);

											$("#data_table").append("<tr>" +
																							"<td>" + $("#invoice_date").val() + "</td>" +
																							"<td>" + $("#invoice_number").val() + "</td>" +
																							"<td>" + $("#vendor").val() + "</td>" +
																							"<td>" + parseFloat($("#subtotal").val()).toFixed(2) + "</td>" +
																							"<td>" + total + "</td>" +
																							"</tr>");
					  },
            error:function (xhr, ajaxOptions, thrownError){
                alert(thrownError);
            }
            });

    });

		<?
		if ($stmt = $sql->prepare($invoice_data) AND $stmt->execute(array()) AND $data = $stmt->fetchAll()) {
			foreach ($data as $i) {

					?>

		$("#<?echo $i["id"];?>").on("click", "#responds .del_button", function(e) {
         e.preventDefault();
        //  var clickedID = this.id.split('-'); //Split ID string (Split works as PHP explode)
        //  var DbNumberID = clickedID[1]; //and get number from array
         var myData = '<?echo $i["id"];?>'

            jQuery.ajax({
            type: "POST", // HTTP method POST or GET
            url: "response.php", //Where to make Ajax calls
            dataType:"text", // Data type, HTML, json etc.
            data:myData, //Form variables
            success:function(response){
                //on success, hide  element user wants to delete.
                $("#<?echo $i["id"];?>").fadeOut();
            },
            error:function (xhr, ajaxOptions, thrownError){
                //On error, we alert user
                alert(thrownError);
            }
            });
    });

		<?
		}
		}

		$stmt = null;
?>

});

</script>
</html>
