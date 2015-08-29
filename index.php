<?php
ob_start();
include 'FormAccess.php';
if(isset($_POST['submit'])){
	session_start();
	$_SESSION['data'] =  $_POST;
	header("Location: confirm.php");

}
ob_flush();

 // function patternMatcher(){
//       $txt =   "{{ invoice_id }} {{invoice_amount}} {{client_name}} Of on affixed civilly moments 
// promise  explain fertile in. Assurance advantage belonging happiness departure so of.
// Now improving and one sincerity intention allowance commanded not. 
// Oh an am frankness be necessary earnestly advantage estimable extensive.
// Five he wife gone ye. Mrs suffering sportsmen earnestly any. 
// In am do giving to afford parish settle easily garret.
// ";

// $commands = array(
// 	"invoice_id",
// 	"invoice_amount",
// 	"client_name"
// 	);

// foreach ($commands as $key => $value) {
// 	$txt = str_replace('{{'.$value.'}}', changedText($value),$txt);
// 	$txt = str_replace('{{ '.$value.' }}', changedText($value),$txt);
// }

// function changedText($value){
// 	switch($value){
// 		case "invoice_id":
// 		$op = "invoice";
// 		break;
// 		case "invoice_amount":
// 		$op = "amount";
// 		break;
// 		case "client_name":
// 		$op = "client_name";
// 		break;
// 		default:
// 		break;
// 	}
// 	return $op;
// }
// echo $txt;
//   // }


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