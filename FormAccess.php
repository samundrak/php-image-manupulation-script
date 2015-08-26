<?php
require_once('ImgGenerator.php');
require_once('vendor/autoload.php');

	  function checkIn($credits){
		if(isset($_POST['submit'])){
//			$inputFields = array(
//				'accountBillder',
//				'invoiceID',
//				'amount',
//				);


			$pass =  true;
//			foreach ($inputFields as $val) {
//				if(empty($_POST[$val])){
//					$pass =  false;
//				}
//			}

			if($pass){

				$accountBilled = $credits['accountBilld'];
				$invoiceId = $credits['invoiceID'];
				$amount = $credits['amount'];

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

	function sendMail($credits){
		$mail = new PHPMailer;

//Enable SMTP debugging.
//		$mail->SMTPDebug = 3;
//Set PHPMailer to use SMTP.
//		$mail->isSMTP();
//Set SMTP host name
//		$mail->Host = "smtp.gmail.com";
//Set this to true if SMTP host requires authentication to send email
//		$mail->SMTPAuth = true;
//Provide username and password
//		$mail->Username = "wholenights@gmail.com";
//		$mail->Password = "m0rd";
//If SMTP requires TLS encryption then set it
//		$mail->SMTPSecure = "tls";
//Set TCP port to connect to
//		$mail->Port = 587;

		$mail->From = "samundra.kc6@gmail.com";
		$mail->FromName = "Samundra";

		$mail->addAddress("samundrak@yahoo.com", "Admin");
//Address to which recipient will reply
        $mail->addReplyTo("reply@yourdomain.com", "Reply");

//CC and BCC
        $mail->addCC("cc@example.com");
        $mail->addBCC("bcc@example.com");
		$mail->isHTML(true);

		$mail->Subject = "Information about invoice";
		$mail->Body = '<p>
			Hello sir <br/>
			Here is detail of new Invoice <br/>
			<table >
				<tr><td>Firstname</td><td>
						 '.$credits['firstname'].'
					</td></tr>
				<tr><td>Lastname</td><td>
						 '.$credits['lastname'].'
					</td></tr>
				<tr><td>Your Email</td><td>
						 '.$credits['email'].'

					</td></tr>
				<tr><td>Phone number</td><td>
						 '.$credits['number'].'
					</td></tr>
				<tr>
					<td><label>Account Billed</label></td>
					<td> '.$credits['accountBilld'].'</td>
			</tr>
			<tr>
				<td><label>Invoice ID</label></td>
				<td>'.$credits['invoiceID'].'</td>
			</tr>
				<tr>
			<td><label>Amount</label></td>
			<td>'.$credits['amount'].'</td>
				<tr><td>Zip Code</td><td>

						'.$credits['zip'].'
					</td></tr>
				<tr><td>Address</td><td>

						'.$credits['address'].'
					</td></tr>
				<tr><td>Country</td><td>
						 '.$credits['country'].'
					</td></tr>

				</tr>

			</table>
		</p>';
		$mail->AltBody = "Thankyou";

		if(!$mail->send())
		{
//			echo "Mailer Error: " . $mail->ErrorInfo;
		}
		else
		{
//			echo "Message has been sent successfully";
		}
	}
?>