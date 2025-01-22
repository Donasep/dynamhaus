<?php

namespace App\Lib\Mailer;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Mailer
{
    private function sendMail(string $address, string $subject, string $body, string $altBody)
    {
        $mail = new PHPMailer(true);
        $mail->CharSet = "UTF-8";
        try {
            //Server settings
            $mail->SMTPDebug = SMTP::DEBUG_OFF;                      //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host = 'smtp.gmail.com';                     //Set the SMTP server to send through
            $mail->SMTPAuth = true;                                   //Enable SMTP authentication
            $mail->Username = 'dynamhaus@gmail.com';                     //SMTP username
            $mail->Password = $_ENV['MAILER_PASSWORD'];                               //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            $mail->Port = 465;

            $mail->setFrom('dynamHaus@gmail.com', 'DynamHaus');
            $mail->addAddress($address);

            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = $subject;
            $mail->Body = $body;
            $mail->AltBody = $altBody;

            $mail->send();
        } catch (Exception $e) {
        }
    }
    
    private function loadTemplate(string $template, array $fields)
    {
        $templateContent = file_get_contents(__DIR__ . '/MailTemplates/' . $template . '.html');

        foreach ($fields as $key => $value) {
            $templateContent = str_replace("{" . $key . "}", $value, $templateContent);
        }

        return $templateContent;
    }

    private function mail(string $address, string $bodyTemplate, string $subject, string $link = null, string $name = null)
    {
        $fields = ["LINK" => $link, "NAME" => $name];
        $body = $this->loadTemplate($bodyTemplate, $fields);
        $altBody = "This mail need html";
        
        $this->sendMail($address, $subject, $body, $altBody);
    }

    public function sendEmailVerificationMail($user, $verificationToken)
    {
        $template = "verification";
        $subject = "[DynamHaus] Vérifier votre compte sur DynamHaus";
        $link = $_ENV['DYNAMHAUS_URL'] . "/verifyAccount/" . $verificationToken;

        $this->mail($user->email, $template, $subject, $link, $user->firstName);
    }
    public function sendResetPasswordMail($user, $resetToken) {
        $template ="resetPassword";
        $subject = "[DynamHaus] Demande de réinitialisation de mot de passe";
        $link = $_ENV['DYNAMHAUS_URL'] ."/resetPassword/" . $resetToken;

        $this->mail($user->email, $template, $subject, $link, $user->firstName);
    }
}