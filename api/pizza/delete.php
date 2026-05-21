<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: DELETE');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../config/db.php';
include_once '../../models/pizza.php';

// Conexão com banco
$database = new DB();
$db = $database->getConnection();

// Instancia a classe Pizza
$pizza = new Pizza($db);

// Verifica se o método é DELETE
if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {

    try {

        // Recebe os dados enviados no body
        $data = json_decode(file_get_contents("php://input"));

        // Verifica se o ID foi informado
        if (!empty($data->id)) {

            // Define o ID da pizza
            $pizza->idPizza = $data->id;

            // Executa o delete
            if ($pizza->delete()) {

                http_response_code(200);

                echo json_encode(
                    array(
                        "Mensagem" => "Pizza deletada com sucesso"
                    )
                );

            } else {

                // Pizza não encontrada
                http_response_code(404);

                echo json_encode(
                    array(
                        "Mensagem" => "Pizza nao encontrada"
                    )
                );

            }

        } else {

            // ID não enviado
            http_response_code(400);

            echo json_encode(
                array(
                    "Mensagem" => "ID nao informado"
                )
            );

        }

    } catch (Exception $e) {

        // Erro interno
        http_response_code(500);

        echo json_encode(
            array(
                "Erro" => $e->getMessage()
            )
        );

    }

} else {

    // Método inválido
    http_response_code(405);

    echo json_encode(
        array(
            "Erro" => "Metodo nao suportado!"
        )
    );

}

?>