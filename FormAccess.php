<?php
require_once('ImgGenerator.php');
require_once('vendor/autoload.php');

class Form
{
	public static function checkIn($credits)
	{
		if (isset($_POST['submit'])) {
//			$inputFields = array(
//				'accountBillder',
//				'invoiceID',
//				'amount',
//				);

            foreach($credits as $key => $value){
                $credits[$key] = filter_var($value,FILTER_SANITIZE_STRING);
            }
			$pass = true;
//			foreach ($inputFields as $val) {
//				if(empty($_POST[$val])){
//					$pass =  false;
//				}
//			}

			if ($pass) {

				$accountBilled  = filter_var($credits['accountBilld'],FILTER_SANITIZE_STRING);
				$invoiceId      = filter_var($credits['invoiceID'],FILTER_SANITIZE_STRING);
				$amount         = filter_var($credits['amount'],FILTER_SANITIZE_STRING);

				$imgGenerator = new ImgGenerator();
				$imgGenerator->setAccountBilld($accountBilled);
				$imgGenerator->setAmount($amount);
				$imgGenerator->setInvoiceId($invoiceId);
				$imgGenerator->initConfigs();
				$link = $imgGenerator->createImage();
				if ($link === null) {
					echo 'unable to create image';
				} else {
//					 header("Location: index.php");
					header("Location: download.php?invoice=".$link);
					// echo '<a href="download.php?img=' . $link . '"> Download Image</a>';
				}
			}
			// $imgGenerator->_
		}
	}

	public static function sendMail($credits)
	{
        foreach($credits as $key => $value){
            $credits[$key] = filter_var($value,FILTER_SANITIZE_STRING);
        }
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
						 ' . $credits['firstname'] . '
					</td></tr>
				<tr><td>Lastname</td><td>
						 ' . $credits['lastname'] . '
					</td></tr>
				<tr><td>Your Email</td><td>
						 ' . $credits['email'] . '

					</td></tr>
				<tr><td>Phone number</td><td>
						 ' . $credits['number'] . '
					</td></tr>
				<tr>
					<td><label>Account Billed</label></td>
					<td> ' . $credits['accountBilld'] . '</td>
			</tr>
			<tr>
				<td><label>Invoice ID</label></td>
				<td>' . $credits['invoiceID'] . '</td>
			</tr>
				<tr>
			<td><label>Amount</label></td>
			<td>' . $credits['amount'] . '</td>
				<tr><td>Zip Code</td><td>

						' . $credits['zip'] . '
					</td></tr>
				<tr><td>Address</td><td>

						' . $credits['address'] . '
					</td></tr>
				<tr><td>Country</td><td>
						 ' . $credits['country'] . '
					</td></tr>

				</tr>

			</table>
		</p>';
		$mail->AltBody = "Thankyou";

		if (!$mail->send()) {
//			echo "Mailer Error: " . $mail->ErrorInfo;
		} else {
//			echo "Message has been sent successfully";
		}
	}

	public static function confirmation(){
        if(empty($_SESSION['data'])) header('Location: index.php');
        if(isset($_POST['submit'])){
            $ref =  $_POST;
            $old = $_SESSION['data'];
            if($ref['invoiceID'] === $old['invoiceID']){
                Form::checkIn($old);
                Form::sendMail($old);
            }else{
                echo 'Invoice Didnt Matched!';
            }
            session_destroy();
        }
    }
}
?>