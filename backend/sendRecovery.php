<?php

$correo = $_POST["email"];
$token = $_POST["token"];
//$mensaje = $_POST["mensaje"];

//$body= "Nombre:" .$nombre . "<br>Correo:" .$correo . "<br>telefono:" . $telefono . "<br>Mensaje:" . $mensaje;

$mensaje = 'Click <a href="http://www.myproyectoonline.com/backend/recuperar.php?token='.$token.'"> aqui </a> para recuperar contraseña';


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/Exception.php';
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';

$mail = new PHPMailer(true);

try {
    //Server settings
    $mail->SMTPDebug =0;                                       // Enable verbose debug output
    $mail->isSMTP();                                            // Set mailer to use SMTP
    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
    $mail->SMTPSecure = 'ssl';                                  // Enable TLS encryption, `ssl` also accepted
    $mail->Port       = 465;                                  // TCP port to connect to
    $mail->Host       = 'mail.myproyectoonline.com';  // Specify main and backup SMTP servers
    $mail->Username   = 'xw_1745@myproyectoonline.com';                     // SMTP username
    $mail->Password   = '373fwh45';                               // SMTP password
   

    //Recipients
    $mail->setFrom('xw_1745@myproyectoonline.com', 'Gastos');
    $mail->addAddress($correo, 'Usuario Gastos');     // Add a recipient

    // Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = 'Recuperacion de contraseña';
    $mail->Body    = $mensaje;

    $mail->CharSet = 'UTF-8';
    
    $mail->send();
    echo 1;
} catch (Exception $e) {
    echo 2;
}
