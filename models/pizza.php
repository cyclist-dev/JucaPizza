<?php

class Pizza
{
    private $conn;
    private $tabela = "pizzas";
    public $idPizza;
    public $nome;
    public $ingredientes;
    public $valor;

    public function __construct($conexao) {
        $this->conn = $conexao;
    }
    public function getall(){
        $query = "SELECT IdPizza, nome, ingredientes, valor FROM " . $this->tabela;

        $stmt = $this->conn->prepare($query);

        $stmt->execute();

        return $stmt;
    }
}

?>