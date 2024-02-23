<?php
if ($_POST) {
	$to_Email   	= "fidel.hdz@me.com"; //Replace with recipient email address
	$subject        = 'Mensaje desde el sitio '.$_SERVER['SERVER_NAME']; //Subject line for emails
	
	
	//check if its an ajax request, exit if not
    if(!isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') {
	
		//exit script outputting json data
		$output = json_encode(
		array(
			'type'=>'error', 
			'text' => 'Error en servidor, favor de intentar más tarde.'
		));
		
		die($output);
    } 
	
	//check $_POST vars are set, exit if any missing
	if(!isset($_POST["name"]) || !isset($_POST["phone"]) || !isset($_POST["aviso"]))
	{
		$output = json_encode(array('type'=>'error', 'text' => 'No se permiten campos vacíos'));
		die($output);
	}

	//Sanitize input data using PHP filter_var().
	$user_Name      = filter_var($_POST["name"], FILTER_SANITIZE_STRING);
	$user_Phone     = filter_var($_POST["phone"], FILTER_SANITIZE_STRING);
	$user_Email     = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
	$user_Company   = filter_var($_POST["company"], FILTER_SANITIZE_STRING);
	$user_Message   = filter_var($_POST["message"], FILTER_SANITIZE_STRING);
	
	$user_Message = str_replace("\&#39;", "'", $user_Message);
	$user_Message = str_replace("&#39;", "'", $user_Message);
	
	//additional php validation
	if(strlen($user_Name)<4) // If length is less than 4 it will throw an HTTP error.
	{
		$output = json_encode(array('type'=>'error', 'text' => 'Nombre muy corto o está vacío'));
		die($output);
	}
	if(!filter_var($user_Phone, FILTER_VALIDATE_EMAIL)) //email validation
	{
		$output = json_encode(array('type'=>'error', 'text' => 'Necesitamos su número telefónico'));
		die($output);
	}
	if($user_aviso) //check emtpy message
	{
		$output = json_encode(array('type'=>'error', 'text' => 'Es necesario que este de acuerdo con lo leido en las políticas de privacidad.'));
		die($output);
	}
	if (strlen($user_Email) < 6){
		$user_Email = 'no-reply@jrmlogistics.com.mx';
	}
	
	//proceed with PHP email.
	$headers = 'From: '.$user_Email.'' . "\r\n" .
	'Reply-To: no-reply@bjrmlogistics.com.mx' . "\r\n" .
	'X-Mailer: PHP/' . phpversion();

	$body = 'Nombre: ' . $user_Name . "\r\n\n";
	$body .= 'Teléfono: ' . $user_Phone . "\r\n";
	if ( $user_Email != '' ) $body .= 'Email: ' . $user_Email . "\r\n";
	if ( $user_Company != '' ) $body .= 'Compañía: ' . $user_Company . "\r\n";
	if ( $user_Message != '' ) $body .= 'Mensaje: ' . "\r\n" . $user_Message . "\r\n";
	
	$sentMail = @mail($to_Email, $subject, $body, $headers);
	
	if(!$sentMail)
	{
		$output = json_encode(array('type'=>'error', 'text' => 'No se pudo enviar la informacíon, favor de intentar más tarde.'));
		die($output);
	}else{
		$output = json_encode(array('type'=>'message', 'text' => $user_Name .', gracias por tu mensaje'));
		die($output);
	}
}
?>