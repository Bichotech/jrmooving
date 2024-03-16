<?php
	$data = json_decode(file_get_contents('php://input'), true);
	ini_set("include_path", '/home/jrmlogis/php:' . ini_get("include_path") );

	//Import PHPMailer classes into the global namespace
	//These must be at the top of your script, not inside a function
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\SMTP;
	use PHPMailer\PHPMailer\Exception;

	echo ini_get("include_path");

	require ini_get("include_path") . '/PHPMailer/src/Exception.php';
	require ini_get("include_path") . '/PHPMailer/src/PHPMailer.php';
	require ini_get("include_path") . '/PHPMailer/src/SMTP.php';

	//Create an instance; passing `true` enables exceptions
	$mail = new PHPMailer(true);

	$form_Name      = $data['name'];
	$form_Phone     = $data['phone'];
	$form_Email     = $data['email'];
	$form_Company   = $data['company'];
	$form_Message   = $data['message'];

	$body = 'Nombre: ' . $form_Name . "<br>\r\n\n";
	$body .= 'Teléfono: ' . $form_Phone . "<br>\r\n";
	if ( $form_Email != '' ) {
		$body .= 'Email: ' . $form_Email . "<br>\r\n";
	} else {
		$form_Email = 'no_email@jrmlogistics.com';
	}
	if ( $form_Company != '' ) $body .= 'Compañía: ' . $form_Company . "<br>\r\n";
	if ( $form_Message != '' ) $body .= 'Mensaje: ' . "\r\n" . $form_Message . "<br>\r\n";

	try {
		//Server settings
		$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
		$mail->isSMTP();                                            //Send using SMTP
		$mail->Host       = 'mail.jrmlogistics.com.mx';             //Set the SMTP server to send through
		$mail->SMTPAuth   = true;                                   //Enable SMTP authentication
		$mail->Username   = 'it@jrmlogistics.com.mx';               //SMTP username
		$mail->Password   = 'Perote_033';                           //SMTP password
		$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
		$mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

		//Recipients
		$mail->setFrom($form_Email);
		$mail->addAddress('contacto@jrmlogistics.com.mx', 'JR Mooving Logistics');     //Add a recipient
		$mail->addReplyTo('contacto@jrmlogistics.com.mx', 'Información');
		$mail->addBCC('it@jrmlogistics.com.mx', 'Departamento de IT');

		//Attachments
		// $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
		// $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

		//Content
		$mail->isHTML(true);                                  //Set email format to HTML
		$mail->Subject = 'Mensaje para JR Mooving Logistics';
		$mail->Body    = $body;
		$mail->AltBody = $body;

		$mail->send();
		echo 'Mensaje enviado exitosamente';
	} catch (Exception $e) {
		echo "No se pudo enviar el mensaje. Errores de entrega: {$mail->ErrorInfo}";
	}
?>