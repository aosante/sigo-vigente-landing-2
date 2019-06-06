<?php

$email = filter_var($_POST['email'], FILTER_SANITIZE_STRING);

//echo $email;

// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require 'vendor/autoload.php';

// Instantiation and passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    //Server settings
    //se deben de configurar estos settings con los de otra cuenta
    $mail->SMTPDebug = 0;                                       // Enable verbose debug output
    $mail->isSMTP();                                            // Set mailer to use SMTP
    $mail->Host       = 'smtp.sendgrid.net';  // Specify main and backup SMTP servers
    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
    $mail->Username   = 'username';                     // SMTP username
    $mail->Password   = 'password';                               // SMTP password
    $mail->SMTPSecure = 'tls';                                  // Enable TLS encryption, `ssl` also accepted
    $mail->Port       = 587;                                    // TCP port to connect to

    //Sender
    $mail->setFrom($email, 'Sigo Vigente', 0);
    //Recipient
    //este correo tendría que reemplazarse con el de AGECO o Proximity
    $mail->addAddress('andres.osante@proximitycr.com', 'Proximity');     // Add a recipient

    // Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = 'Solicitud de informacion - Sigo Vigente';

    //Body content
    $body = '<p>El usuario con correo '. $email . ' desea recibir mas informacion de Sigo Vigente</p>';

    $mail->Body    = $body;
    $mail->AltBody = strip_tags($body);

    $mail->send();

    header("location: successMessage.html");
    //successMessage.html es una página con una alerta exito
    // echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}