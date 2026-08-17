<?php

class Conexao {
    private $host = 'localhost';
    private $port = '3306';
    private $dbname = 'OdontoCare';
    private $username = 'root';
    private $password = '';
    private $conexao;


    public function getConexao() {
        try {
            $dsn = "mysql:host={$this->host};port={$this->port};dbname={$this->dbname};charset=utf8";

            $this->conexao = new PDO($dsn, $this->username, $this->password);
            $this->conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            return $this->conexao;
        } catch (PDOException $e) {
            echo "Erro na conexão: " . $e->getMessage();
            return null;
        }
    }
}

?>