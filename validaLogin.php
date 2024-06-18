<?php
date_default_timezone_set('America/Sao_Paulo');
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once("Autenticacao.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $login = $_POST['email']; // Correção: 'email' para coincidir com o campo name do formulário HTML
    $senha = $_POST['password']; // Correção: 'password' para coincidir com o campo name do formulário HTML

    // Debugging: Verificar os valores recebidos do formulário
    error_log("Email: $login, Senha: $senha");

    try {
        $auth = new Autenticacao($login);

        if ($auth->validaSenha($senha)) {
            // Login bem-sucedido
            $token = $auth->tokenValido();
            if ($token == null) {
                $token = $auth->gerarToken();
            }
            $_SESSION['token'] = $token;

            // Redireciona para index.php
            $response = [
                "status" => "1",
                "msg" => "Login efetuado com sucesso!",
                "token" => $token
            ];
        } else {
            // Login falhou
            $response = [
                "status" => "0",
                "msg" => "Usuário ou senha inválido"
            ];
        }
    } catch (Exception $e) {
        $response = [
            "status" => "0",
            "msg" => $e->getMessage()
        ];
    }

    // Retorna resposta JSON para o frontend
    echo json_encode($response);
} else {
    // Se não for método POST, redireciona para página de login ou faz outro tratamento
    header("Location: login.php");
    exit;
}
