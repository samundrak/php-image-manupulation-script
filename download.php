<?php
session_start();

$invoice = @filter_var($_GET['invoice'],FILTER_SANITIZE_STRING);
$true  = @filter_var($_GET['true'],FILTER_SANITIZE_STRING);


if(!empty($true) && $true === '1'){

if(!empty($invoice)){
    if(file_exists($invoice)){
        header("Content-Description: File Transfer");
        header("Content-Type: image/jpeg");
        header("Content-Disposition: attachment; filename=\"$invoice\"");
        readfile ($invoice);
    }else{
    	// echo 'file nt found';
        header("Location: index.php");
    }
}else{
	// echo 'no download';
   header("Location: index.php");

 }
}
?>
<a href="?invoice=<?php echo $invoice; ?>&true=1">Download Invoice</a>