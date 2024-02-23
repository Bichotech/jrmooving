	<?php
	echo "Iniciando ";

	$to_Email   	= "fidel.hdz@me.com"; //Replace with recipient email address
	$subject        = 'Mensaje desde el sitio ' . $_SERVER['SERVER_NAME']; //Subject line for emails

	//Sanitize input data using PHP filter_var().
	$user_Name      = $_POST['name'];
	$user_Phone     = $_POST['phone'];
	$user_Email     = $_POST['email'];
	$user_Company   = $_POST['company'];
	$user_Message   = $_POST['message'];

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