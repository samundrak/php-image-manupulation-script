<?php include 'FormAccess.php';
//$form  =  new FormAccess();
checkIn();
echo 'Image generation';
?>
<html>
	<head>
	<title>Image mani</title>	
	</head>
	<body>

		<form method="post" action="">
			<table >

				<tr>
					<td><label>Account Billed</label></td>
					<td><input type="text" name="accountBillder" /></td>
			</tr>
			<tr>
				<td><label>Invoice ID</label></td>
				<td><input type="text" name="invoiceID" /></td>
			</tr>
				<tr>
			<td><label>Amount</label></td>
			<td><input type="text" name="amount" /></td>

				</tr>
			   <tr><td><input type="submit" name="submit"  value="submit"/></td></tr>
			</table>
		</form>
	</body>
</html>