<?php
include 'FormAccess.php';
if(isset($_POST['submit'])){
	$_SESSION['data'] =  $_POST;
	header("Location: confirm.php");
}
?>
<html>
	<head>
	<title>Image mani</title>	
	</head>
	<body>

		<form method="post" >
			<table >
				<tr><td>Firstname</td><td>
						<input type="text" name="firstname">
					</td></tr>
				<tr><td>Lastname</td><td>
						<input type="text" name="lastname">

					</td></tr>
				<tr><td>Your Email</td><td>
						<input type="text" name="email">

					</td></tr>
				<tr><td>Phone number</td><td>
						<input type="text" name="number">

					</td></tr>
				<tr>
					<td><label>Account Billed</label></td>
					<td><input type="text" name="accountBilld" /></td>
			</tr>
			<tr>
				<td><label>Invoice ID</label></td>
				<td><input type="text" name="invoiceID" /></td>
			</tr>
				<tr>
			<td><label>Amount</label></td>
			<td><input type="text" name="amount" /></td>
				<tr><td>Zip Code</td><td>
						<input type="text" name="zip">

					</td></tr>
				<tr><td>Address</td><td>
						<input type="text" name="address">

					</td></tr>
				<tr><td>Country</td><td>
						<select name="country">
							<option value="usa">usa</option>
							<option value="uk">uk</option>
							<option value="france">france</option>
						</select>
					</td></tr>

				</tr>
			   <tr><td><input type="submit" name="submit"  value="submit"/></td></tr>
			</table>
		</form>
	</body>
</html>