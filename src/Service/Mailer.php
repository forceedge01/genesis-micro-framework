<?php

namespace Genesis\MicroFramework\Service;

use \PHPMailer;

class Mailer
{
	public static function sendMail($to, $subject, $message, $from)
	{
		require_once __DIR__ . '/Mailer/class-phpmailer.php';
		require_once __DIR__ . '/Mailer/class-smtp.php';

		$mail = new PHPMailer();
		$mail->IsMail();
		// $mail->IsSMTP();                                      // set mailer to use SMTP
		// $mail->Host = "smtp1.example.com;smtp2.example.com";  // specify main and backup server
		// $mail->SMTPAuth = true;     // turn on SMTP authentication
		// $mail->Username = "jswan";  // SMTP username
		// $mail->Password = "secret"; // SMTP password

		$mail->From = $from;
		$mail->FromName = "Inevitable Tech: Project Indexer";
		$mail->AddAddress($to);
		// $mail->AddAddress("ellen@example.com");                  // name is optional
		// $mail->AddReplyTo("info@example.com", "Information");

		// $mail->WordWrap = 50;                                 // set word wrap to 50 characters
		// $mail->AddAttachment("/var/tmp/file.tar.gz");         // add attachments
		// $mail->AddAttachment("/tmp/image.jpg", "new.jpg");    // optional name
		// $mail->IsHTML(true);                                  // set email format to HTML

		$mail->IsHTML( true );
		$mail->Subject = $subject;
		$mail->Body    = $message;
		// $mail->AltBody = $message;

		if(!$mail->Send())
		{
			error_log('Mailer Error: ' . $mail->ErrorInfo);
			return [true, $mail->ErrorInfo];
		}

		return [false, null];
	}
}
