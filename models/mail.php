<?php





use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require $_SERVER['DOCUMENT_ROOT'] . '/mail/Exception.php';
require $_SERVER['DOCUMENT_ROOT'] . '/mail/PHPMailer.php';
require $_SERVER['DOCUMENT_ROOT'] . '/mail/SMTP.php';

$mail = new PHPMailer;
$mail->isSMTP(); 
$mail->SMTPDebug = 0;//2; // 0 = off (for production use) - 1 = client messages - 2 = client and server messages
$mail->Host = "smtp.gmail.com"; // use $mail->Host = gethostbyname('smtp.gmail.com'); // if your network does not support SMTP over IPv6
$mail->Port = 587; // TLS only
$mail->SMTPSecure = 'tls'; // ssl is deprecated
$mail->SMTPAuth = true;
$mail->Username = 'addmail8918@gmail.com'; // email - NAPRAVI LEGIT MAIL
$mail->Password = "Shrimp12!"; // password
$mail->setFrom($from, $usernameFrom); // From email and name
$mail->addAddress($to, $usernameTo); // to email and name
$mail->Subject = $subject;
$mail->msgHTML($messageHTML); //$mail->msgHTML(file_get_contents('contents.html'), DIR); //Read an HTML message body from an external file, convert referenced images to embedded,
$mail->AltBody = $message; // If html emails is not supported by the receiver, show this body
// $mail->addAttachment('images/phpmailer_mini.png'); //Attach an image file
$mail->SMTPOptions = array(
                    'ssl' => array(
                        'verify_peer' => false,
                        'verify_peer_name' => false,
                        'allow_self_signed' => true
                    )
                );
if(!$mail->send()){
    header("Location:../index.php?page=contact&error=2");
}