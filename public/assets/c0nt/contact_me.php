<?php
	$data = json_decode(file_get_contents('php://input'), true);

	$to_Email   	= "jfhdzp@gmail.com"; //Replace with recipient email address
	$subject        = 'Mensaje desde el sitio ' . $_SERVER['SERVER_NAME']; //Subject line for emails

	//Sanitize input data using PHP filter_var().
	$user_Name      = $data['name'];
	$user_Phone     = $data['phone'];
	$user_Email     = $data['email'];
	$user_Company   = $data['company'];
	$user_Message   = $data['message'];

	//proceed with PHP email.
	$headers = 'From: ' . $user_Email . "\r\n" . 'Reply-To: no-reply@jrmlogistics.com.mx' . "\r\n" . 'Reply-To: no-reply@jrmlogistics.com.mx' . "\r\n" . 'X-Mailer: PHP/' . phpversion();

	$body = 'Nombre: ' . $user_Name . "<br>\r\n\n";
	$body .= 'Teléfono: ' . $user_Phone . "<br>\r\n";
	if ( $user_Email != '' ) $body .= 'Email: ' . $user_Email . "<br>\r\n";
	if ( $user_Company != '' ) $body .= 'Compañía: ' . $user_Company . "<br>\r\n";
	if ( $user_Message != '' ) $body .= 'Mensaje: ' . "\r\n" . $user_Message . "<br>\r\n";

	echo $to_Email . "<br>\n\r" . $subject . "<br>\n\r" . $body . "<br>\n\r" . $headers . "<br>\n\r";

	$mailSent = @mail($to_Email, $subject, $body, $headers);

	if ( $mailSent ){
		echo "Mensaje enviado";
	} else {
		echo "No jalo";
	}
?>