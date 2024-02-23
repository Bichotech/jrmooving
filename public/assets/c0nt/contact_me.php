<?php
echo "Iniciando";
if ($_POST) {
	$to_Email   	= "fidel.hdz@me.com"; //Replace with recipient email address
	$subject        = 'Mensaje desde el sitio ' . $_SERVER['SERVER_NAME']; //Subject line for emails

	echo "Jalo el post";

	//Sanitize input data using PHP filter_var().
	$user_Name      = filter_var($_POST["name"], FILTER_SANITIZE_STRING);
	$user_Phone     = filter_var($_POST["phone"], FILTER_SANITIZE_STRING);
	$user_Email     = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
	$user_Company   = filter_var($_POST["company"], FILTER_SANITIZE_STRING);
	$user_Message   = filter_var($_POST["message"], FILTER_SANITIZE_STRING);
	
	$user_Message = str_replace("\&#39;", "'", $user_Message);
	$user_Message = str_replace("&#39;", "'", $user_Message);
	
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
}
?>