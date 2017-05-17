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
}

td {
	padding-left: 25px;
	padding-right: 25px;
}

th {
	padding-left: 25px;
	padding-right: 25px;
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

</style>
	</head>
	<body>

<?

			include "source/database.class.php";
			include "source/config.php";
			include "response.php";

			$sql = get_db_conn();

			$vendor_data = "SELECT * FROM `vendors`";

			$invoice_data = "SELECT * FROM `invoices`";

			$last_id = "SELECT `id` FROM `invoices` ORDER BY `id` DESC LIMIT 1";

			$last_entry = "SELECT * FROM `invoices` ORDER BY `id` DESC LIMIT 1";

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
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
			<input type="submit" value="Submit" name="submit" id="submit" class="btn btn-primary btn-lg col-xs-offset-1 col-sm-offset-1 col-md-offset-1 col-lg-offset-1">
    </div>
  </div>

</form>

	</div>

	<div id="list" class="col-xs-offset-5 col-sm-offset-5 col-md-offset-5 col-lg-offset-5">

		<!-- <hr> -->

		<h2 id="all_invoices"><center>All Invoices</center></h2>

		<br>

		<table id="headers" class="table">
  	<tr>
	    <th>Date</th>
	    <th>Invoice Number</th>
	    <th>Vendor</th>
			<th>Subtotal</th>
			<th>Total</th>
			<th>Delete</th>
		</tr>
	</table>

	<table id="data_table" class="table">
		<div id="data_table_entry">
		</div>
	</table>

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

	$('#invoice_number').keyup(function(e){
					e.preventDefault();

		var invoice_num = $('#invoice_number').val();

		$.ajax({
		type: "POST",
		url: "check_duplicate.php",
		dataType: "text",
		data: $('#collection_form').serialize(),
		success:function(response){
			if (response == "duplicate"){
				$('#invoice_number').change(function(){
					$(this).addClass("errorClass");
			});
		}
			else
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

    $("#collection_form").on("submit", function(e){
            e.preventDefault();

            if(($("#invoice_number").val()==='') || ($("#invoice_date").val()==='') || ($("#vendor").val()==='') || ($("#subtotal").val()==='') || ($("#pst").val()==='') || ($("#pst").val()===''))
            {
                alert("You left a field blank.");
                return false;
            };

							$("#invoice_number").removeClass("errorClass");

							var invoice_num = $('#invoice_number').val();
							$.ajax({
							type: 'POST',
							url: 'response.php',
							dataType: "text",
							data: $('#collection_form').serialize(),
							success: function(response){

							var total = (parseFloat($("#subtotal").val()) + (parseFloat($("#pst").val())/100 * parseFloat($("#subtotal").val())) + (parseFloat($("#gst").val())/100 * parseFloat($("#subtotal").val()))).toFixed(2);

							<? if ($stmt = $sql->prepare($last_entry) AND $stmt->execute(array()) AND $data = $stmt->fetchAll()) {
								foreach ($data as $i) { ?>

							$("#data_table_entry").prepend("<?	echo "<tr id=" . "row_" . $i["id"] . ">";
																					echo "<td>" . $i["invoice_date"] . "</td>";
																					echo "<td>" . $i["invoice_number"] . "</td>";
																					echo "<td>" . $i["vendor"] . "</td>";
																					echo "<td>" . "$" . number_format((float)$i["subtotal"], 2, '.', '') . "</td>";
																					echo "<td>" . "$" . number_format((float)$i["total"], 2, '.', '') . "</td>";
																					echo "<td>" . "<input type='submit' value='Delete' class='del_button btn btn-danger btn-sm' id=" . $i["id"] . ">" . "</td>";
																					echo "</tr>"; ?>");

          //   error:function(xhr, ajaxOptions, thrownError){
          //       alert(thrownError);
          //   }
					//
					// }

				<? }

			}
				 ?>

				},

			});

            });

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
			             }



								});
			     });

			 });

</script>
</html>
