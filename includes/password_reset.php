<?php
session_start();
require 'includes/db.php';
require 'vendor/autoload.php'; // Carrega PHPMailer e Twilio

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Twilio\Rest\Client;

// ==============================================
// FUNÇÕES AUXILIARES
// ==============================================

/**
 * Gera um token seguro para recuperação
 */
function gerarToken() {
    return bin2hex(random_bytes(32)); // 64 caracteres hexadecimais
}

/**
 * Envia e-mail com link de recuperação via PHPMailer
 */
function enviarEmailRecuperacao($email, $token) {
    $mail = new PHPMailer(true);
    try {
        // Configurações SMTP (exemplo para Gmail)
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'seuemail@gmail.com'; // Substitua pelo seu e-mail
        $mail->Password = 'suasenha'; // Use "App Password" se tiver 2FA ativado
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Remetente e destinatário
        $mail->setFrom('nao-responda@seusite.com', 'Convite Romântico');
        $mail->addAddress($email);

        // Conteúdo do e-mail
        $mail->isHTML(true);
        $mail->Subject = 'Redefinição de Senha';
        $mail->Body = "
            <h1>Redefina sua senha</h1>
            <p>Clique no link abaixo (válido por 1 hora):</p>
            <a href='http://seusite.com/nova_senha.php?token=$token'>Redefinir Senha</a>
            <p>Ou use este código no site: $token</p>
        ";

        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log("Erro PHPMailer: " . $mail->ErrorInfo);
        return false;
    }
}

/**
 * Envia SMS com token via Twilio
 */
function enviarSMS($telefone, $token) {
    try {
        $client = new Client('SEU_ACCOUNT_SID', 'SEU_AUTH_TOKEN'); // Substitua pelas suas credenciais Twilio
        $client->messages->create(
            $telefone, // Número do destinatário (ex: '+5511999999999')
            [
                'from' => '+5511999999999', // Seu número Twilio
                'body' => "Seu código de recuperação: $token. Válido por 1 hora."
            ]
        );
        return true;
    } catch (Exception $e) {
        error_log("Erro Twilio: " . $e->getMessage());
        return false;
    }
}

// ==============================================
// LÓGICA PRINCIPAL
// ==============================================

// 1. SOLICITAÇÃO DE RECUPERAÇÃO (via e-mail ou telefone)
if (isset($_POST['solicitar_recuperacao'])) {
    $input = $_POST['email_ou_telefone'];
    $token = gerarToken();
    $expiracao = date('Y-m-d H:i:s', strtotime('+1 hour'));
    $ip = $_SERVER['REMOTE_ADDR'];

    // Verifica se é e-mail ou telefone
    if (filter_var($input, FILTER_VALIDATE_EMAIL)) {
        // Busca usuário por e-mail
        $stmt = $pdo->prepare("SELECT id, email, telefone FROM usuarios WHERE email = ?");
        $stmt->execute([$input]);
        $usuario = $stmt->fetch();

        if ($usuario) {
            // Atualiza token no banco
            $pdo->prepare("UPDATE usuarios SET token_recuperacao = ?, token_expiracao = ? WHERE id = ?")
                ->execute([$token, $expiracao, $usuario['id']]);

            // Registra no log
            $pdo->prepare("INSERT INTO log_recuperacoes (usuario_id, token, ip) VALUES (?, ?, ?)")
                ->execute([$usuario['id'], $token, $ip]);

            // Envia e-mail e SMS (opcional)
            enviarEmailRecuperacao($usuario['email'], $token);
            if (!empty($usuario['telefone'])) {
                enviarSMS($usuario['telefone'], $token);
            }

            $_SESSION['mensagem'] = "Link de recuperação enviado para seu e-mail e telefone!";
            header("Location: login.php");
        } else {
            $_SESSION['erro'] = "E-mail não cadastrado!";
            header("Location: recuperar.php");
        }
    } else {
        // Lógica para SMS (se implementado)
        $_SESSION['erro'] = "Recuperação apenas por e-mail no momento.";
        header("Location: recuperar.php");
    }
    exit();
}

// 2. REDEFINIÇÃO DE SENHA (quando usuário clica no link)
if (isset($_POST['redefinir_senha'])) {
    $token = $_POST['token'];
    $nova_senha = $_POST['nova_senha'];

    // Validação básica de senha
    if (strlen($nova_senha) < 8) {
        $_SESSION['erro'] = "A senha deve ter pelo menos 8 caracteres!";
        header("Location: nova_senha.php?token=$token");
        exit();
    }

    // Verifica token válido e não expirado
    $stmt = $pdo->prepare("SELECT id FROM usuarios WHERE token_recuperacao = ? AND token_expiracao > NOW()");
    $stmt->execute([$token]);
    $usuario = $stmt->fetch();

    if ($usuario) {
        $senha_hash = password_hash($nova_senha, PASSWORD_BCRYPT);

        // Atualiza senha e limpa token
        $pdo->prepare("UPDATE usuarios SET senha_hash = ?, token_recuperacao = NULL, token_expiracao = NULL WHERE id = ?")
            ->execute([$senha_hash, $usuario['id']]);

        // Marca o token como utilizado no log
        $pdo->prepare("UPDATE log_recuperacoes SET utilizado = TRUE, data_uso = NOW() WHERE token = ?")
            ->execute([$token]);

        $_SESSION['sucesso'] = "Senha redefinida com sucesso!";
        header("Location: login.php");
    } else {
        $_SESSION['erro'] = "Token inválido ou expirado!";
        header("Location: recuperar.php");
    }
    exit();
}