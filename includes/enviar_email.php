<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

function enviarEmailRecuperacao($email, $token) {
    $mail = new PHPMailer(true);
    
    try {
        // Configurações do servidor SMTP (ex: Gmail)
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'seuemail@gmail.com'; // Seu e-mail
        $mail->Password = 'suasenha'; // Senha do e-mail ou "App Password"
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Remetente e destinatário
        $mail->setFrom('nao-responda@seusite.com', 'Convite Romântico');
        $mail->addAddress($email);

        // Conteúdo do e-mail
        $mail->isHTML(true);
        $mail->Subject = 'Redefinir Senha';
        $mail->Body = "
            <h1>Redefina sua senha</h1>
            <p>Clique no link abaixo (válido por 1 hora):</p>
            <a href='http://seusite.com/nova_senha.php?token=$token'>Redefinir Senha</a>
        ";

        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log("Erro ao enviar e-mail: " . $mail->ErrorInfo);
        return false;
    }
}
?>