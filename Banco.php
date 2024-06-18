<?php

class Banco {
    private $usuario;
    private $senha;
    private $servidor;
    private $porta;
    private $nome_banco;
    private $pdo;
    public function __construct() {
       $this->usuario = "root";
       $this->senha = "";
       $this->servidor = "localhost";
       $this->porta = "3306";
       $this->nome_banco = "teste";
       $this->pdo = new PDO("mysql:host={$this->servidor}:{$this->porta};dbname={$this->nome_banco}", $this->usuario, $this->senha);
    }
    public function Consultar($sql) {
        $stm = $this->Excutar($sql);
        return $stm->fetchAll(PDO::FETCH_ASSOC);
    }

    public function Excutar($sql) {
        $stm = $this->pdo->prepare($sql);
        $stm->execute();
        return $stm;
    }
}