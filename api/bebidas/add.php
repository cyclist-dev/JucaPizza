<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');
 
include_once '../../config/db.php';
include_once '../../models/bebidas.php';
 
// Instanciar o banco de dados e conectar
$database = new DB();
$db = $database->getConnection();
 
// Instanciar o objeto bebidas
$bebidas = new bebidas($db);
 
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        // Obter os dados postados
        $data = json_decode(file_get_contents("php://input"));
 
        // Verificar se os dados não estão vazios
        if (
            !empty($data->nome) &&
            !empty($data->tipo) &&
            !empty($data->valor)
        ) {
            // Atribuir os valores ao objeto bebidas
            $bebidas->nome = $data->nome;
            $bebidas->tipo = $data->tipo;
            $bebidas->valor = $data->valor;
 
            // Criar a bebidas
            if ($bebidas->add()) {
                http_response_code(201);
                // Resposta de sucesso
                echo json_encode(
                    array('Mensagem' => 'Bebida Criada com Sucesso')
                );
            } else {
                http_response_code(500);
                // Resposta de erro
                echo json_encode(
                    array('Mensagem' => 'Nao foi possivel criar a bebida')
                );
            }
        } else {
            http_response_code(400);
            // Resposta se dados estiverem incompletos
            echo json_encode(
                array('Mensagem' => 'Dados Incompletos. Nao foi possivel criar a bebida.')
            );
        }
    } catch (Exception $e) {
        echo json_encode(array("erro" => $e->getMessage()));
    }
} else {
    http_response_code(405);
    echo json_encode(array("erro" => "Método não suportado!"));
}