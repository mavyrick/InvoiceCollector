<?php
session_start();
?>

<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="style.css" />
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
		<meta charset="utf-8">
		<title>Invoice Collector</title>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<style>

body {
	font-family: arial;
}

#collection_form {
  font-size: 20px;
}

#title {
	font-family: "arial";
	font-size: 50px;
	font-weight: bold;
	background-color: lightblue;
	border-radius: 15px;
	padding: 10px;
	margin: auto;
	width: 50%;
	margin-top: 15px;

}

#collector {
	position: fixed;
	left: 3%;
	top: 20%;
	background-color: lightgrey;
	padding: 10px;
	border-radius: 15px;
}

#list {
	padding-top: 25px;
	padding-right: 3%;
}

#data_table {
	border: 1px solid black;
	display: table-header-group;
}

td {
	padding-left: 12px;
	padding-right: 12px;
	border: solid lightgrey 1px;
	vertical-align: middle;
	text-align: center;
}

th {
	font-size: 20px;
	padding-left: 12px;
	padding-right: 12px;
	border: solid lightgrey 1px;
	vertical-align: middle;
	text-align: center;
}

.del_button {
	margin: 1px;
}

#all_invoices {
	border-radius: 15px;
	padding: 10px;
	background-color: palegreen;
	font-weight: bold;
}

#invoice_title {
	font-weight: bold;
}

.form-control {
	width: 80%;
}

.errorClass {
	border: 2px solid red;
}

.okClass {
	border: 2px solid green;
}

#error {
	float: right;
	font-size: 15px;
	color: white;
	background-color: red;
	padding: 1px;
	border-radius: 4px;
	position: relative;
	top: 10px;
}

#manage_vendors_position {
	display: block;
	position: relative;
	right: 15px;
}

#submit_position {
	display: block;
	position: relative;
	left: 7px;
}

#scroll {
	height: 200px;
	width: 500px;
	overflow: scroll;
}

#my-modal {
	alignment: center;
}

.modal-title {
	font-size: 30px;
}

</style>
	</head>
	<body>

<?

			// include "source/database.class.php";
			include "source/config.php";
			include "response.php";

			$sql = get_db_conn();

			$vendor_data = "SELECT * FROM `vendors`";

			$invoice_data = "SELECT * FROM `invoices` ORDER BY `id` ASC";

			$last_id = "SELECT `id` FROM `invoices` ORDER BY `id` DESC LIMIT 1";

			$last_entry = "SELECT * FROM `invoices` ORDER BY `id` DESC LIMIT 1";

			// $last_entry = "SELECT * FROM `invoices` where id=(SELECT max(id) FROM `invoices`)";

			$stmt = null;

			$duplicate = null;

?>

	<h1 id="title"><center>Invoice Collector</center></h1>

	<div id="collector" class="col-xs-4 col-sm-4 col-md-4 col-lg-4">

		<h2 id="invoice_title"><center>Enter an Invoice</center><h2>

	<form action="response.php" method="post" name="form" class="form-horizontal" id="collection_form">
  <div class="form-group">
    <label for="inputEmail3" class="col-sm-2 control-label">Date:</label>
    <div class="col-sm-10">
			<input type="date" name="invoice_date" id="invoice_date" class="form-control col-xs-offset-1 col-sm-offset-1 col-md-offset-1 col-lg-offset-1" >
    </div>
  </div>
  <div class="form-group">
    <label for="inputPassword3" class="col-sm-2 control-label">Number:</label>
    <div class="col-sm-10">
			<input type="text" name="invoice_number" id="invoice_number" class="form-control col-xs-offset-1 col-sm-offset-1 col-md-offset-1 col-lg-offset-1">
    </div>
  </div>
	<div class="form-group">
    <label for="inputPassword3" class="col-sm-2 control-label">Vendor:</label>
    <div class="col-sm-10">
			<select name="vendor" id="vendor" class="form-control col-xs-offset-1 col-sm-offset-1 col-md-offset-1 col-lg-offset-1">
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
		</div>
  </div>
	<div class="form-group">
    <label for="inputPassword3" class="col-sm-2 control-label">Subtotal:</label>
    <div class="col-sm-10">
			<input type="text" name="subtotal" id="subtotal" class="form-control col-xs-offset-1 col-sm-offset-1 col-md-offset-1 col-lg-offset-1">
    </div>
  </div>
	<div class="form-group">
    <label for="inputPassword3" class="col-sm-2 control-label">PST&nbsp;%:</label>
    <div class="col-sm-10">
				<input type="text" name="pst" id="pst" class="form-control col-xs-offset-1 col-sm-offset-1 col-md-offset-1 col-lg-offset-1"></div>
  </div>
	<div class="form-group">
    <label for="inputPassword3" class="col-sm-2 control-label">GST&nbsp;%:</label>
    <div class="col-sm-10">
			<input type="text" name="gst" id="gst" class="form-control col-xs-offset-1 col-sm-offset-1 col-md-offset-1 col-lg-offset-1"></div>
  </div>
	<div id="submit_position" class="col-sm-6">
  <div class="form-group">
    <div class=" col-sm-offset-5">
			<input type="submit" value="Submit" name="submit" id="submit" class="btn btn-primary btn-lg col-xs-offset-1 col-sm-offset-1 col-md-offset-1 col-lg-offset-1">
			<div id="error">
			</div>
    </div>
  </div>
</div>
	<div id="manage_vendors_position" class="col-sm-6">
	<div class="form-group">
    <div class="col-sm-8">
			<input type="button" value="Manage Vendors" name="manage_vendors" id="manage_vendors" class="btn btn-success btn-lg" data-toggle="modal" data-target="#myModal">
			<div id="error">
			</div>
    </div>
  </div>
</div>

</form>

	</div>

	<div id="list" class="col-xs-offset-5 col-sm-offset-5 col-md-offset-5 col-lg-offset-5">

		<!-- <hr> -->

		<h2 id="all_invoices"><center>All Invoices</center></h2>

		<br>

	<table id="data_table" class="table">
		<div id="data_table_entry">
		</div>
	</table>

</div>

<div id="vendor_modal">
</div>

<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><center>Manage Vendors</center></h4>
      </div>
      <div class="modal-body">
				<table id="vendor_table" class="table">
					<div id="vendor_table_entry">
					</div>
				</table>
				<div id="#scroll">

				<script>
				<?
								if ($stmt = $sql->prepare($vendor_data) AND $stmt->execute(array()) AND $data = $stmt->fetchAll()) {
									foreach ($data as $i) {
				?>
				$("#vendor_table_entry").prepend("<?	echo "<tr id=" . "row_" . $i["vendor_title"] . ">";
																		echo "<td>" . $i["vendor_title"] . "</td>";
																		echo "<td>" . $i["address"] . "</td>";
																		echo "<td>" . "<input type='submit' value='Delete' class='del_button btn btn-danger btn-xs' id=" . $i["id"] . ">" . "</td>";
																		echo "</tr>"; ?>");

				<?
									}
								}

								$stmt = null;


				?>

				$("#vendor_table_entry").prepend("<tr id='vendor_headers'><th>Vendor</th><th>Address</th><th>Delete</th></div>");

				</script>

			</div>

				<form action="vendor_response.php" method="post" name="form" class="form-horizontal" id="collection_form">
			  <div class="form-group">
			    <label for="inputEmail3" class="col-sm-2 control-label">Vendor:</label>
			    <div class="col-sm-10">
						<input type="date" name="invoice_date" id="invoice_date" class="form-control col-xs-offset-1 col-sm-offset-1 col-md-offset-1 col-lg-offset-1" >
			    </div>
			  </div>
			  <div class="form-group">
			    <label for="inputPassword3" class="col-sm-2 control-label">Address:</label>
			    <div class="col-sm-10">
						<input type="text" name="invoice_number" id="invoice_number" class="form-control col-xs-offset-1 col-sm-offset-1 col-md-offset-1 col-lg-offset-1">
			    </div>
			  </div>
				<div id="submit_position" class="col-sm-6">
			  <div class="form-group">
			    <div class=" col-sm-offset-5">
						<input type="submit" value="Add Vendor" name="submit" id="submit" class="btn btn-primary btn-md col-xs-offset-1 col-sm-offset-1 col-md-offset-1 col-lg-offset-1">
						<div id="error">
						</div>
			    </div>
			  </div>
			</div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

	</body>

<script>

$(document).ready(function() {

	<?
			if ($stmt = $sql->prepare($invoice_data) AND $stmt->execute(array()) AND $data = $stmt->fetchAll()) {
				foreach ($data as $i) {

?>
							$("#data_table_entry").prepend("<?	echo "<tr id=" . "row_" . $i["id"] . ">";
																					echo "<td>" . $i["invoice_date"] . "</td>";
																					echo "<td>" . $i["invoice_number"] . "</td>";
																					echo "<td>" . $i["vendor"] . "</td>";
																					echo "<td>" . "$" . number_format((float)$i["subtotal"], 2, '.', '') . "</td>";
																					echo "<td>" . "$" . number_format((float)$i["total"], 2, '.', '') . "</td>";
																					echo "<td>" . "<input type='submit' value='Delete' class='del_button btn btn-danger btn-sm' id=" . $i["id"] . ">" . "</td>";
																					echo "</tr>"; ?>");
	<?

				}
			}

			$stmt = null;
	?>

	$("#data_table_entry").prepend("<tr id='headers'><th>Date</th><th>Number</th><th>Vendor</th><th>Subtotal</th><th>Total</th><th>Delete</th></tr><div id='before_header'></div>");

	// $('#vendor_modal').append('<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"><div class="modal-dialog" role="document"><div class="modal-content"><div id="contact" class="modal-body"></div></div></div></div>')

// 	$('#manage_vendors').on('click', function(e){
// 		e.preventDefault();
// 		$('#myModal').modal('show');
// 		$.ajax({
// 			url: "manage_vendors.php",
// 		}).done(function(data) {
// 			$("#contact").html(data);
// 			// $(".navbar:last").remove();
// 		// });
// 	});
// });

	$('#invoice_number').change(function(e){
					e.preventDefault();

		var invoice_num = $('#invoice_number').val();

		$.ajax({
		type: "POST",
		url: "check_duplicate.php",
		dataType: "text",
		data: $('#collection_form').serialize(),
		success:function(response){
			if (response == "duplicate"){
					$('#invoice_number').addClass("errorClass");
					$('#submit').click(function(){
						$('#error').append("<p>Invoice number already taken.</p>");
					});
		}
			else
					$('#invoice_number').removeClass("errorClass");
		{
			// $('#invoice_number').change(function(){
			// 	$(this).addClass("okClass");
			// });
	};
},

			// alert(response);

		// var invoice_dup = "<echo $_SESSION["duplicate"];?>";
		//
		// if(invoice_dup == "duplicate") {
		// 	alert("test");
		// 	$('#invoice_number').addClass('.errorClass');
// };

		},

	);

});



    $("#submit").on("click", function(e){
            e.preventDefault();



            if(($("#invoice_number").val()==='') || ($("#invoice_date").val()==='') || ($("#vendor").val()==='') || ($("#subtotal").val()==='') || ($("#pst").val()==='') || ($("#pst").val()===''))
            {
                $("#error").append("You left a field blank.");
                return false;
            };


							var invoice_num = $('#invoice_number').val();
							$.ajax({
							type: 'POST',
							url: 'response.php',
							dataType: "text",
							data: $('#collection_form').serialize(),
							success: function(data) {

								$("#headers").remove();

							$("#invoice_number").removeClass("errorClass");

								var total = (parseFloat($("#subtotal").val()) + (parseFloat($("#pst").val())/100 * parseFloat($("#subtotal").val())) + (parseFloat($("#gst").val())/100 * parseFloat($("#subtotal").val()))).toFixed(2);

								var invoice_num_new = "";

								var invoice_id = "";


								<? if ($stmt = $sql->prepare($last_entry) AND $stmt->execute(array()) AND $data = $stmt->fetch()) { ?>

									var invoice_num_new = <? echo $data["invoice_number"]; ?>

									var invoice_id = <? echo $data["id"]; ?>

									<?

										}

										$stmt = null

									?>

								var new_data = JSON.parse(data);



							$("#data_table_entry").prepend(	"<tr id='headers'><th>Date</th><th>Number</th><th>Vendor</th><th>Subtotal</th><th>Total</th><th>Delete</th></tr><div id='before_header'></div>" +
																							"<tr id='row_" + invoice_id + "' class='" + invoice_num_new + "'>" +
																							"<td>" + new_data.invoice_date + "</td>" +
																							"<td>" + new_data.invoice_number + "</td>" +
																							"<td>" + new_data.vendor + "</td>" +
																							"<td>" + "$" + parseFloat(new_data.subtotal).toFixed(2) + "</td>" +
																							"<td>" + "$" + total + "</td>" +
																							"<td><form><input type='submit' value='Delete' class='del_button btn btn-danger btn-sm' id='" + invoice_id + "' </form></td>" +
																										"</tr>"
																									);





							// var total = (parseFloat($("#subtotal").val()) + (parseFloat($("#pst").val())/100 * parseFloat($("#subtotal").val())) + (parseFloat($("#gst").val())/100 * parseFloat($("#subtotal").val()))).toFixed(2);
							//
							// var invoice_num_new = "";
							//
							// var invoice_id = "";


							<? if ($stmt = $sql->prepare($last_entry) AND $stmt->execute(array()) AND $data = $stmt->fetch()) { ?>

								var invoice_num_new = <? echo $data["invoice_number"]; ?>

								var invoice_id = <? echo $data["id"]; ?>

								<? }

								$stmt = null;

								?>






								// var new_id = parseInt(invoice_id) + 1;

								// if (($("#data_table_entry tr:first").attr("class") != invoice_num_new) && ($("#data_table_entry tr:first").attr("class") != $("#invoice_number").val())) {




								},

								// if (($("#data_table_entry tr:first").attr("class") != invoice_num_new)  && invoice_num_new != $("#invoice_number").val()) {

								// if ($("#data_table_entry tr:first").attr("class") != invoice_num_value) {

									// $("#data_table_entry").prepend(			"<tr id='row_" + invoice_id + "' class='" + invoice_num_new + "'>" +
									// 																 		"<td>" + $("#invoice_date").val() + "</td>" +
									// 																		"<td>" + $("#invoice_number").val() + "</td>" +
									// 																		"<td>" + $("#vendor").val() + "</td>" +
									// 																		"<td>" + "$" + parseFloat($("#subtotal").val()).toFixed(2) + "</td>" +
									// 																		"<td>" + "$" + total + "</td>" +
									// 																		"<td><form><input type='submit' value='Delete' class='del_button btn btn-danger btn-sm' id='" + invoice_id + "' </form></td>" +
									// 																			"</tr>");


							// }
							// else {
							// 	alert("Invoice number already taken.")
							// }
            // error:function(xhr, ajaxOptions, thrownError){
            //     alert(thrownError);
            // }

					// }



				},

			// }).done(function(data) {
			// 	// debugger
			// 	alert(data);
			// 	< $stmt = $sql->prepare("SELECT * FROM `invoices` ORDER BY `id` DESC LIMIT 1");
			// 		 $stmt->execute();
			// 		 $data = $stmt->fetch(PDO::FETCH_ASSOC);>
			// 			//  debugger
			//
			// 		$("#data_table_entry").prepend("<	echo "<tr id=" . "row_" . $data["id"] . ">";
			// 																echo "<td>" . $data["invoice_date"] . "</td>";
			// 																echo "<td>" . $data["invoice_number"] . "</td>";
			// 																echo "<td>" . $data["vendor"] . "</td>";
			// 																echo "<td>" . "$" . number_format((float)$data["subtotal"], 2, '.', '') . "</td>";
			// 																echo "<td>" . "$" . number_format((float)$data["total"], 2, '.', '') . "</td>";
			// 																echo "<td>" . "<input type='submit' value='Delete' class='del_button btn btn-danger btn-sm' id=" . $data["id"] . ">" . "</td>";
			// 																echo "</tr>"; >")
			//
			// 																<
			//
			// 																$stmt = null;
			//
			// 																>


			);



					$("body").on("click", ".del_button", function(e) {
			          e.preventDefault();
			          var DbNumberID = $(this).attr('id');
			          var myData = "recordToDelete=" + DbNumberID;
			         $(this).hide();

			             $.ajax({
			             type: "POST",
			             url: "response.php",
			             dataType: "text",
			             data: myData,
			             success:function(response){
			                $("#row_"+DbNumberID).fadeOut();
			             },
			             error:function (xhr, ajaxOptions, thrownError){
			                 alert(thrownError);
			             },




								});

			     });

					//  $("#submit").click(function() {
						//  debugger
							//  setTimeout(function() {

																					//  }, 2000);


						// < if ($stmt = $sql->prepare($last_entry) AND $stmt->execute(array()) AND $data = $stmt->fetch()) { ?>
						//
						// 	var invoice_num_new = < echo $data["invoice_number"]; ?>
						//
						// 	var invoice_id = < echo $data["id"]; ?>
						//
						// 	< }
						//
						// 	$stmt = null;
						//
						// 	?






							// var new_id = parseInt(invoice_id) + 1;

							// if (($("#data_table_entry tr:first").attr("class") != invoice_num_new) && ($("#data_table_entry tr:first").attr("class") != $("#invoice_number").val())) {



								});



							});




</script>
</html>
