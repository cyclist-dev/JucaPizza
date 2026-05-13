<?php

class Bebidas   
{
    private $conn;
    private $tabela = "bebidas";

    public $idbebidas;
    public $nome;
    public $tipo;
    public $valor;
    public function __construct($conexao)
    {
        $this->conn = $conexao;
    }
    public function getall()
    {
        $query = "SELECT idbebidas, nome, tipo, valor FROM " . $this->tabela;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
    public function get()
    {
        $query = "SELECT
                    idbebidas,
                    nome,
                    tipo,
                    valor
                  FROM
                    " . $this->tabela . "
                  WHERE
                    idbebidas = ?
                  LIMIT 1";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->idbebidas);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if($row){
            $this->nome = $row['nome'];
            $this->tipo = $row['tipo'];
            $this->valor = $row['valor'];
        }
    }

     public function find($id)
    {
        $query = "SELECT idbebidas AS idbebidas, nome, tipo, valor FROM " . $this->tabela . " WHERE idbebidas = ? LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(1, $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
 
    public function create()
    {
        $query = "INSERT INTO " . $this->tabela . " (nome, tipo, valor) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $success = $stmt->execute(array($this->nome, $this->tipo, $this->valor));
 
        if ($success) {
            $this->idbebidas = $this->conn->lastInsertId();
            $this->idbebidas = $this->idbebidas;
        }
 
        return $success;
    }
 
    public function update()
    {
        $id = $this->getIdValue();
        if (!$id) {
            return false;
        }
 
        $query = "UPDATE " . $this->tabela . " SET nome = ?, tipo = ?, valor = ? WHERE idbebidas = ?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute(array($this->nome, $this->tipo, $this->valor, $id));
    }
 
    public function delete($id)
    {
        $query = "DELETE FROM " . $this->tabela . " WHERE idbebidas = ?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute(array($id));
    }
 
 
 
    public function add()
{
    $query = "INSERT INTO " . $this->tabela . "
              SET
                nome = :nome,
                tipo = :tipo,
                valor = :valor";

    $stmt = $this->conn->prepare($query);

    $this->nome = htmlspecialchars(strip_tags($this->nome));
    $this->tipo = htmlspecialchars(strip_tags($this->tipo));
    $this->valor = htmlspecialchars(strip_tags($this->valor));

    $stmt->bindParam(':nome', $this->nome);
    $stmt->bindParam(':tipo', $this->tipo);
    $stmt->bindParam(':valor', $this->valor);

    if($stmt->execute()){
        return true;
    }

    return false;
}

    
}
?>