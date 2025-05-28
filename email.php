<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use Dotenv\Dotenv;
require 'vendor/autoload.php';
require '.env';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $dotenv = Dotenv::createImmutable(__DIR__);
    $dotenv->load();
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $mail = new PHPMailer(true);
    date_default_timezone_set('America/Sao_Paulo'); // Define o fuso horário para o Brasil
    $date = new DateTime();
    $formattedDate = $date->format('d/m/Y H:i:s');  
$tiked = uniqid(); // Get the current timestamp
$mensagem = "
<!DOCTYPE html>
<html lang='pt'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Confirmação de Abertura de Chamado</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            background: #fff;
            padding: 20px;
            margin: auto;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            color: #333;
        }
        .info {
            padding: 10px;
            background: #007bff;
            color: #fff;
            border-radius: 5px;
            text-align: center;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class='container'>
        <h2>Seu chamado foi aberto com sucesso!</h2>
        <p>Olá, {$email},</p>
        <p>Informamos que seu chamado foi registrado em nosso sistema. Nossa equipe já está analisando sua solicitação e retornaremos em breve.</p>
        <div class='info'>
            <strong>Data de Abertura:</strong> {$formattedDate}
        </div>
        <p>Fique tranquilo, estamos cuidando disso para você!</p>
        <div class='footer'>
            <p>Atenciosamente,</p>
            <p><strong>Robson Moura</strong></p>
        </div>
    </div>
</body>
</html>
";


$mensagemOut = `Seu chamado foi aberto com sucesso!

Olá, $email,

Informamos que seu chamado foi registrado em nosso sistema. Nossa equipe já está analisando sua solicitação e retornaremos em breve.

Detalhes do Chamado:

ID do Chamado: $tiked
Data de Abertura: $formattedDate

Fique tranquilo, estamos cuidando disso para você!

Atenciosamente, Robson Moura`;
    try {
        //Server settings
        $mail->SMTPDebug = SMTP::DEBUG_OFF;
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = getenv(USERNAME);                     //SMTP username
        $mail->Password   = getenv(PASSWORD);                               //SMTP password
       // $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
       // $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // STARTTLS para porta 587
        $mail->Port = 587;
        
        //Recipients
        $mail->setFrom('robsonic10@gmail.com', 'Equipe RM Sistemas');
        $mail->addAddress($email, $email);     //Add a recipient
    
        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->CharSet = 'UTF-8';
        $mail->Encoding = 'base64';
        $mail->Subject = "Abertura de Chamado - ID: $tiked";
        $mail->Body    = $mensagem;
        $mail->AltBody = $mensagemOut;
        $mail->send();
        die(json_encode(['status' => 'success', 'message' => 'A mensagem foi enviada com sucesso!']));
    } catch (Exception $e) {
        die(json_encode(['status' => 'error', 'message' => 'A mensagem não pôde ser enviada: ' . $mail->ErrorInfo]));
    }
}
