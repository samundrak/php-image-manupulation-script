<?php
session_start();

$invoice = @filter_var($_GET['invoice'],FILTER_SANITIZE_STRING);
$true  = @filter_var($_GET['true'],FILTER_SANITIZE_STRING);


if(!empty($true) && $true === '1'){

if(!empty($invoice)){
    $config =  json_decode(file_get_contents('config.json'),false);
    if(file_exists($config->imageSavePath.$invoice)){
        header("Content-Description: File Transfer");
        header("Content-Type: image/jpeg");
        $file = $config->imageSavePath.$invoice;
        header("Content-Disposition: attachment; filename=\"$file\"");
        readfile ($file);
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