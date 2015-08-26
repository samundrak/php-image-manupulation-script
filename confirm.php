<?php
session_start();
include 'FormAccess.php';

if(empty($_SESSION['data'])) header('Location: index.php');


if(isset($_POST['submit'])){
            $ref =  $_POST;
            $old = $_SESSION['data'];
            if($ref['invoiceID'] === $old['invoiceID']){
                checkIn($old);
                sendMail($old);
            }else{
                echo 'Invoice Didnt Matched!';
            }
    session_destroy();
}
?>
<html>
<head>
    <title>Confirm</title>
</head>
<body>

<form method="post" action="confirm.php">
    <table >
        <caption>Please re confirm your invoice and amount</caption>
        <tr><td>Invoice Id</td><td>
                <input type="text" name="invoiceID">
            </td></tr>
        <tr><td>Amount</td><td>
                <input type="text" name="amount">

            </td></tr>
        <tr><td><input type="submit" name="submit"  value="submit"/></td></tr>

    </table>
    </form>
</body>
</html>