<?php
echo "Iniciando ";

if ( isset( $_POST['json']) ) {
	echo 'Si Paso';
} else {
	echo 'No paso';
}

$data = json_decode($_POST['json']);
var_dump($data);

echo $data;

$to_Email   	= "fidel.hdz@me.com"; //Replace with recipient email address
$subject        = 'Mensaje desde el sitio ' . $_SERVER['SERVER_NAME']; //Subject line for emails

//Sanitize input data using PHP filter_var().
$user_Name      = !empty($_POST["name"]) ? $_POST['name'] : null;
$user_Phone     = !empty($_POST["phone"]) ? $_POST['phone'] : null;
$user_Email     = !empty($_POST["email"]) ? $_POST['email'] : null;
$user_Company   = !empty($_POST["company"]) ? $_POST['company'] : null;
$user_Message   = !empty($_POST["message"]) ? $_POST['message'] : null;

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