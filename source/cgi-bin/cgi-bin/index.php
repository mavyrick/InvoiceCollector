<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Invoice Collector</title>
	</head>
	<body>

		<?

			//Include required database connection files
			include "source/database.class.php";
			include "source/config.php";

			//Init the connection into a variable
			$sql = get_db_conn();

			//Setup a query
			$query = "SELECT `value` FROM `test` WHERE `id` = ? LIMIT 10";

			$vendor_title = "SELECT `vendor_title` FROM `vendors`";

			//Prepare, execute and fetch the single row if it exists
			if ($stmt = $sql->prepare($query) AND $stmt->execute(array("1")) AND $data = $stmt->fetch()) {
				foreach ($data as $i) {
					echo "Hi " . $i . "!";
				}
			}
			else {
				echo "Hi Nobody!";
			}

			if ($stmt = $sql->prepare($vendor_title) AND $stmt->execute(array("1")) AND $data = $stmt->fetch()) {
				foreach ($data as $i) {
					echo $i;
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

		?>

		<h1>The Invoice Collector</h1>

		<h2>Enter an Invoice<h2>

		<form action="/action_page.php">
	  	Invoice Date:<br>
	  <input type="text" name="Invoice Date">
	  <br>
	  	Invoice Number:<br>
	  <input type="text" name="Invoice Number">
		<br>
	  	Vendor:<br>
			<select>
	  		<option value="honda"><?echo $data["value"] ?></option>
	  		<option value="saab">Saab</option>
	  		<option value="mercedes">Mercedes</option>
	  		<option value="audi">Audi</option>
			</select>
	  <br>
	  	Subtotal:<br>
	  <input type="text" name="Subtotal">
		<br>
	  	PST:<br>
	  <input type="text" name="PST">
		<br>
	  	GST:<br>
	  <input type="text" name="GST">
		<br>
	  	Total:<br>
	  <input type="text" name="Total"s>
	  <br><br>
	  <input type="submit" value="Submit">
		</form>

<? $data["value"] ?>

		<hr>

		<h2>Display All Invoices</h2>

	</body>
</html>
