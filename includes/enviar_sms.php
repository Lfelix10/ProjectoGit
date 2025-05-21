<?php
require 'vendor/autoload.php';
use Twilio\Rest\Client;

function enviarSMS($telefone, $mensagem) {
    $account_sid = 'SEU_ACCOUNT_SID';
    $auth_token = 'SEU_AUTH_TOKEN';
    $twilio_number = '+5511999999999'; // Seu número Twilio

    $client = new Client($account_sid, $auth_token);

    try {
        $client->messages->create(
            $telefone,
            [
                'from' => $twilio_number,
                'body' => $mensagem
            ]
        );
        return true;
    } catch (Exception $e) {
        error_log("Erro ao enviar SMS: " . $e->getMessage());
        return false;
    }
}
?>