	<?php
	echo "Iniciando ";

	$data = json_decode(file_get_contents('php://input'), true);

	$to_Email   	= "fidel.hdz@me.com"; //Replace with recipient email address
	$subject        = 'Mensaje desde el sitio ' . $_SERVER['SERVER_NAME']; //Subject line for emails

	//Sanitize input data using PHP filter_var().
	$user_Name      = $data['name'];
	$user_Phone     = $data['phone'];
	$user_Email     = $data['email'];
	$user_Company   = $data['company'];
	$user_Message   = $data['message'];

	//proceed with PHP email.
	$headers = 'From: '.$user_Email.'' . "\r\n" . 'Reply-To: no-reply@bjrmlogistics.com.mx' . "\r\n" . 'X-Mailer: PHP/' . phpversion();

	$body = 'Nombre: ' . $user_Name . "\r\n\n";
	$body .= 'Teléfono: ' . $user_Phone . "\r\n";
	if ( $user_Email != '' ) $body .= 'Email: ' . $user_Email . "\r\n";
	if ( $user_Company != '' ) $body .= 'Compañía: ' . $user_Company . "\r\n";
	if ( $user_Message != '' ) $body .= 'Mensaje: ' . "\r\n" . $user_Message . "\r\n";

	echo "contenido: " . $body;

	if ( mail($to_Email, $subject, $body, $headers) ){
		echo "Mensaje enviado";
	} else {
		echo "No jalo";
	}
	?>