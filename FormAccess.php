<?php
require_once('ImgGenerator.php');

	  function checkIn(){
		if(isset($_POST['submit'])){
			$inputFields = array(
				'accountBillder',
				'invoiceID',
				'amount',
				);


			$pass =  true;
			foreach ($inputFields as $val) {
				if(empty($_POST[$val])){
					$pass =  false;
				}
			}

			if($pass){

				$accountBilled = $_POST['accountBillder'];
				$invoiceId = $_POST['invoiceID'];
				$amount = $_POST['amount'];

				$imgGenerator =  new ImgGenerator();
				$imgGenerator->setAccountBilld($accountBilled);
                $imgGenerator->setAmount($amount);
                $imgGenerator->setInvoiceId($amount);
                $imgGenerator->initConfigs();
				$link = $imgGenerator->createImage();
				 if($link === null){
					 echo 'unable to create image';
				 }else{
					 echo '<a href="'.$link.'"> Look Image</a>';
				 }
			}
			// $imgGenerator->_
		}
	}

?>