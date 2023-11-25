<?php
if($_SERVER['REQUEST_METHOD'] != 'POST' ){
    header("Location: index.html" );
}

require 'phpmailer/PHPMailer.php';
require 'phpmailer/Exception.php';
require 'phpmailer/SMTP.php'; // Asegúrate de agregar esta línea

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];
$email = $_POST['email'];
$asunto = $_POST['asunto'];
$mensaje = $_POST['mensaje'];
$foto = $_FILES['foto']; //array assoc - $foto['tmp_name']; $foto['size'] - $foto['name']

if( empty(trim($nombre)) ) $nombre = 'anonimo';
if( empty(trim($apellido)) ) $apellido = '';

$body = <<<HTML
    <h1>Contacto desde la web</h1>
    <p>De: $nombre $apellido / $email</p>
    <h2>Mensaje</h2>
    $mensaje
HTML;

$mailer = new PHPMailer();

 $mailer->isSMTP();
    $mailer->Host = 'smtp.gmail.com';
    $mailer->SMTPAuth = true;
    $mailer->Username = 'ejemplo2024@gmail.com';
    $mailer->Password = '';
    $mailer->SMTPSecure = 'tls'; 
    $mailer->Port = 587; 


$mailer->setFrom( $email, "$nombre $apellido" );
$mailer->addAddress('ejemplo2023@gmail.com','Sitio web');
$mailer->Subject = "Mensaje web: $asunto";
$mailer->msgHTML($body);
$mailer->AltBody = strip_tags($body);
$mailer->CharSet = 'UTF-8';

if( $foto['size'] > 0 ){
    $mailer->addAttachment( $foto['tmp_name'], $foto['name'] );
}

$rta = $mailer->send( );
if (!$mailer->send()) {
    echo "Error: " . $mailer->ErrorInfo;
} else {
    header("Location: gracias.html" );
}
//var_dump($rta);
