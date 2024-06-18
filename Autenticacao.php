<?php
require_once("Banco.php");

class Autenticacao {
    private $banco;
    private $usuario;

    public function __construct($login) {
        $this->banco = new Banco();
        $sql = "SELECT * FROM usuario u WHERE u.email_login = '{$login}'";
        $result = $this->banco->Consultar($sql);
        if ($result) {
            $this->usuario = $result[0];
        } else {
            throw new Exception("Usuário não encontrado");
        }
    }

    public function validaSenha($senha) {
        return password_verify($senha, $this->usuario['senha']); // Verifica senha usando hash
    }

    public function tokenValido() {
        $token = null;
        $idusuario = $this->usuario['id'];
        $sql = "SELECT * FROM login_control WHERE idusuario = {$idusuario} AND NOW() BETWEEN criado AND expira ORDER BY id DESC LIMIT 1";
        $result = $this->banco->Consultar($sql);
        $log_acesso = $result[0];
        if (isset($log_acesso['token'])) {
            $token = $log_acesso['token'];
        }
        return $token;
    }

    public function gerarToken() {
        $token = md5(uniqid(mt_rand(), true));
        $idusuario = $this->usuario['id'];
        $sql = "INSERT INTO login_control (idusuario, token, criado, expira) VALUES ({$idusuario}, '{$token}', NOW(), DATE_ADD(NOW(), INTERVAL 12 HOUR))";
        $this->banco->Executar($sql);
        return $token;
    }
}
?>
