<?php

require_once 'config/DB.php';
echo "<h1>Testando Conexão com o Banco de Dados</h1>";
try {    
    $database = new DB();
    $conn = $database->getConnection();
    if ($conn) {
        echo "<p style='color: green;'>Conexão bem-sucedida!</p>";
    } else {
        echo "<p style='color: red;'>Falha na conexão. Verifique as credenciais no arquivo config/Database.php e se o banco de dados 'pizzariajucadb' existe.</p>";
    }
} catch (Exception $e) {
    echo "<p style='color: red;'>Erro ao conectar: " . $e->getMessage() . "</p>";
}