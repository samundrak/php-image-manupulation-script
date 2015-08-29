<?php
ob_start();
if(session_status() == PHP_SESSION_NONE) session_start();
require_once('ImgGenerator.php');
require_once('mail/lib/swift_required.php');

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
				$firstname      = filter_var($credits['firstname'],FILTER_SANITIZE_STRING);
				$lastname       = filter_var($credits['lastname'],FILTER_SANITIZE_STRING);
				$phone          = filter_var($credits['number'],FILTER_SANITIZE_STRING);
				$zip            = filter_var($credits['zip'],FILTER_SANITIZE_STRING);
				$address        = filter_var($credits['address'],FILTER_SANITIZE_STRING);
				$email          = filter_var($credits['email'],FILTER_SANITIZE_STRING);
				$name 			= filter_var($credits['firstname'] .' '. $credits['lastname'],FILTER_SANITIZE_STRING);

				/*
					private $accountBilld;
					private $invoiceId;
					private $date;
					private $amount;
					private $plan;
					private $logoImage;
					private $companyName;
					private $config;
					private $ClientName;
					private $ClientFullName;
					private $ClientLastName;
					private $ClientPhone;
					private $ClientZip;
					private $ClientAddress;
  
				*/
				$imgGenerator = new ImgGenerator();
				$imgGenerator->setAccountBilld($accountBilled);
				$imgGenerator->setAmount($amount);
				$imgGenerator->setInvoiceId($invoiceId);
				$imgGenerator->setClientName($name);
				$imgGenerator->setClientFullName($firstname);
				$imgGenerator->setClientLastname($lastname);
				$imgGenerator->setClientPhone($phone);
				$imgGenerator->setClientZip($zip);
				$imgGenerator->setClientEmail($email);
				$imgGenerator->setClientAddress($address);
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
		 $config =  json_decode(file_get_contents('config.json'),false);
		 
				 // Create the Transport
		 $email =  $config->email;
		$transport = Swift_SmtpTransport::newInstance($email->smtp, $email->port,'ssl')
		  ->setUsername($email->username)
		  ->setPassword('ur password')
		  ;

		/*
		You could alternatively use a different transport such as Sendmail or Mail:

		// Sendmail
		$transport = Swift_SendmailTransport::newInstance('/usr/sbin/sendmail -bs');

		// Mail
		$transport = Swift_MailTransport::newInstance();
		*/

		// Create the Mailer using your created Transport
		$mailer = Swift_Mailer::newInstance($transport);

		// Create a message
		$message = Swift_Message::newInstance($email->subject)
		  ->setFrom(array($email->from => $email->sender_name))
		  ->setTo(array($email->to))
		  ;

		// Send the message
		  $message->setBody ('<div>
			Hello sir <br/>
			Here is detail of new Invoice <br/>
			<table border="1">
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
		</div>','text/html');
		$result = $mailer->send($message);
		  
	}

	public static function confirmation(){
        if(empty($_SESSION['data'])) header('Location: index.php');
        if(isset($_POST['submit'])){
            $ref =  $_POST;
            $old = $_SESSION['data'];
            if($ref['invoiceID'] === $old['invoiceID']){
                Form::sendMail($old);
                Form::checkIn($old);
            }else{
                echo 'Invoice Didnt Matched!';
            }
            session_destroy();
        }
    }
}
ob_flush();
?>