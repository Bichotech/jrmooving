<?php
	$data = json_decode(file_get_contents('php://input'), true);
	ini_set("include_path", '/home/jrmlogis/php');

	//Import PHPMailer classes into the global namespace
	//These must be at the top of your script, not inside a function
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\SMTP;
	use PHPMailer\PHPMailer\Exception;

	require ini_get("include_path") . '/PHPMailer/src/Exception.php';
	require ini_get("include_path") . '/PHPMailer/src/PHPMailer.php';
	require ini_get("include_path") . '/PHPMailer/src/SMTP.php';
	require_once(ini_get("include_path") . '/define_vars.php');

	//Create an instance; passing `true` enables exceptions
	$mail = new PHPMailer(true);

	$form_Name      = $data['nombre'];
	$form_Company   = $data['compania'];
	$form_Phone     = $data['telefono'];
	$form_Email     = $data['correo'];
	$form_City      = $data['ciudad'];
	$form_State     = $data['estado'];
	$form_Fleet     = $data['unidades'];
	$form_Message   = $data['mensaje'];
	$form_Trucks    = $data['tipoUnidades'];

	$body = "---------- <br>\r\n\n";
	$body .= 'Nombre: ' . $form_Name . "<br>\r\n\n";
	$body .= 'Teléfono: ' . $form_Phone . "<br>\r\n";
	$body .= 'Email: ' . $form_Email . "<br>\r\n";
	$body .= 'Compañía: ' . $form_Company . "<br>\r\n";
	$body .= 'Ciudad: ' . $form_City . ", " . $form_State . "<br>\r\n";
	$body .= 'Cantidad de unidades: ' . $form_Fleet . " unidades <br>\r\n";
	if ( $form_Trucks != '' ) $body .= $form_Trucks . "<br>\r\n";
	if ( $form_Message != '' ) $body .= 'Mensaje: ' . "\r\n" . $form_Message . "<br>\r\n";
	$body .= "---------- <br>\r\n\n";

	$body_alt = "---------- \r\n\n";
	$body_alt .= 'Nombre: ' . $form_Name . "\r\n\n";
	$body_alt .= 'Teléfono: ' . $form_Phone . "\r\n";
	$body_alt .= 'Email: ' . $form_Email . "\r\n";
	$body_alt .= 'Compañía: ' . $form_Company . "\r\n";
	$body_alt .= 'Ciudad: ' . $form_City . ", " . $form_State . "\r\n";
	$body_alt .= 'Cantidad de unidades: ' . $form_Fleet . " unidades \r\n";
	if ( $form_Trucks != '' ) $body_alt .= $form_Trucks . "\r\n";
	if ( $form_Message != '' ) $body_alt .= 'Mensaje: ' . "\r\n" . $form_Message . "\r\n";
	$body_alt .= "---------- \r\n\n";

	try {
		//Server settings
		$mail->CharSet    = "UTF-8";
		$mail->Encoding   = 'base64';
		$mail->SMTPDebug  = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
		$mail->isSMTP();                                            //Send using SMTP
		$mail->Host       = MAIL_SMTPSERVER;	            //Set the SMTP server to send through
		$mail->SMTPAuth   = true;                                   //Enable SMTP authentication
		$mail->Username   = MAIL_USERNAME;	                //SMTP username
		$mail->Password   = MAIL_PASSWORD;                  //SMTP password
		$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
		$mail->Port       = MAIL_SMTPPORT;                  //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

		//Recipients
		$mail->setFrom($form_Email);
		$mail->addAddress(MAIL_PRINCIPAL, 'JR Mooving Logistics');     //Add a recipient
		$mail->addReplyTo(MAIL_PRINCIPAL, 'Información');
		$mail->addBCC(MAIL_SECONDARY, 'Departamento de IT');

		//Attachments
		// $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
		// $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

		//Content
		$mail->isHTML(true);                                  //Set email format to HTML
		$mail->Subject = 'Registro completado en JR Mooving Logistics';
		$mail->Body    = $body;
		$mail->AltBody = $body_alt;

		$mail->send();
		echo 'Mensaje enviado exitosamente.';
	} catch (Exception $e) {
		echo "No se pudo enviar el mensaje.";
	}
?>