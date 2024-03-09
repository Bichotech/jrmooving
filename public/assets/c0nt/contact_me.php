<?php
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;

	require 'phpmailer/Exception.php';
	require 'phpmailer/PHPMailer.php';
	require 'phpmailer/SMTP.php';

	//Load Composer's autoloader
	// require 'vendor/autoload.php';

	$mail = new PHPMailer();
	function enviarCorreoSMTP($para, $asunto, $mensaje, $smtpHost, $smtpPort, $smtpUsername, $smtpPassword) {
		// Crear el objeto PHPMailer
		$mail = new PHPMailer();
		
		// Configurar el servidor SMTP
		$mail->isSMTP();
		$mail->Host = $smtpHost;
		$mail->Port = $smtpPort;
		$mail->SMTPAuth = true;
		$mail->Username = $smtpUsername;
		$mail->Password = $smtpPassword;
		
		// Configurar el remitente y el destinatario
		$mail->setFrom('it@logisitics.com.mx', 'Departamento de IT');
		$mail->addAddress($para);
		
		// Configurar el asunto y el cuerpo del mensaje
		$mail->Subject = $asunto;
		$mail->Body = $mensaje;
		
		// Enviar el correo electrónico
		if (!$mail->send()) {
			echo "Error al enviar el correo electrónico: " . $mail->ErrorInfo;
			return false;
		} else {
			echo "Correo electrónico enviado correctamente.";
			return true;
		}
	}

	$smtpHost = getenv('SMTP');
	$smtpPort = getenv('PORT');
	$smtpUsername = getenv('USERNAME');
	$smtpPassword = getenv('USERPASS');

	echo $smtpHost . "\n" . $smtpPort . "\n" . $smtpUsername . "\n" . $smtpPassword;

	$data = json_decode(file_get_contents('php://input'), true);

	$to_Email   	= "it@jrmlogistics.com.mx"; //Replace with recipient email address
	$subject        = 'Mensaje desde el sitio de JR Mooving Logistics'; //Subject line for emails

	//Sanitize input data using PHP filter_var().
	$user_Name      = $data['name'];
	$user_Phone     = $data['phone'];
	$user_Email     = $data['email'];
	$user_Company   = $data['company'];
	$user_Message   = $data['message'];

	//proceed with PHP email.
	$body = 'Nombre: ' . $user_Name . "<br>\r\n\n";
	$body .= 'Teléfono: ' . $user_Phone . "<br>\r\n";
	if ( $user_Email != '' ) $body .= 'Email: ' . $user_Email . "<br>\r\n";
	if ( $user_Company != '' ) $body .= 'Compañía: ' . $user_Company . "<br>\r\n";
	if ( $user_Message != '' ) $body .= 'Mensaje: ' . "\r\n" . $user_Message . "<br>\r\n";

	// $headers  = "From: ".$user_Email."\n";
    // $headers .= "Bcc: it@jrmlogistics.com.mx\n"; 
    // $headers .= "X-Sender: ".$user_Email."\n";
    // $headers .= 'X-Mailer: PHP/' . phpversion();
    // $headers .= "X-Priority: 1\n"; // Urgent message!
    // $headers .= "Return-Path: no-reply@jrmlogistics.com.mx\n"; // Return path for errors
    // $headers .= "MIME-Version: 1.0\r\n";
    // $headers .= "Content-Type: text/html; charset=iso-8859-1\n";

	// echo $to_Email . "<br>\n\r" . $subject . "<br>\n\r" . $body . "<br>\n\r" . $headers . "<br>\n\r";

	enviarCorreoSMTP($to_Email, $subject, $body, $smtpHost, $smtpPort, $smtpUsername, $smtpPassword);

	// $mailSent = @mail($to_Email, $subject, $body, $headers);

	// if ( $mailSent ){
	// 	echo "Mensaje enviado";
	// } else {
	// 	echo "No jalo";
	// }
?>