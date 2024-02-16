<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

$mail = new PHPMailer(true);
$mail->isSMTP();
$mail->Host       = 'smtp.gmail.com';
$mail->SMTPAuth   = true;
$mail->Username   = 'oyuncoyt@gmail.com';
$mail->Password   = 'dyanckhmkduuezga'; //ihxt swjp rsii sgea
$mail->SMTPSecure = 'ssl';
$mail->Port       = 465;
$mail->isHTML(true);
$mail->CharSet = "UTF-8";
