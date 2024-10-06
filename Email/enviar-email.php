<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require "Email/vendor/autoload.php"; //Inclua o autoload do Composer


function enviarEmail($destinatario, $assunto, $corpo)
{
    try {
        $mail = new PHPMailer(true); //Cria uma nova instância do PHPMailer

        //Configurações do servidor
        $mail->isSMTP();
        $mail->Host       = "smtp.gmail.com"; //Endereço do servidor SMTP
        $mail->SMTPAuth   = true; //Habilita a autenticação SMTP
        $mail->Username   = ""; //Seu endereço de e-mail
        $mail->Password   = ""; //Sua senha do Gmail
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; //Habilita a criptografia TLS
        $mail->Port       = 587; //Porta TCP para a conexão
        $mail->CharSet = "UTF-8";

        //Destinatários
        $mail->setFrom("", "IFC"); //Adiciona o remetente
        $mail->addAddress($destinatario); //Adiciona um destinatário

        //Conteúdo do e-mail
        $corpo .= "<br/><br/>Este é um e-mail automático, favor não responder.";
        $mail->isHTML(true); //Define que o conteúdo do e-mail é em HTML
        $mail->Subject = $assunto;
        $mail->Body    = $corpo;
        $mail->AltBody = $corpo;

        //$mail->send();
    } catch (Exception $e) {
        echo "O e-mail não pode ser enviado. Erro: {$mail->ErrorInfo}";
    }
}
