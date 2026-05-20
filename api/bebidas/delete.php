<?php


header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: DELETE');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../config/db.php';
include_once '../../models/bebidas.php';


$database = new DB();
$db = $database->getConnection();


$bebidas = new bebidas($db);

if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {

    try {

        
        $data = json_decode(file_get_contents("php://input"));

        
        if (!empty($data->id)) {

          
            if ($bebidas->delete($data->id)) {

                http_response_code(200);

                echo json_encode(
                    array("Mensagem" => "Bebida deletada com sucesso")
                );

            } else {

                http_response_code(500);

                echo json_encode(
                    array("Mensagem" => "Nao foi possivel deletar a bebida")
                );

            }

        } else {

            http_response_code(400);

            echo json_encode(
                array("Mensagem" => "ID nao informado")
            );

        }

    } catch (Exception $e) {

        echo json_encode(
            array("Erro" => $e->getMessage())
        );

    }

} else {

    http_response_code(405);

    echo json_encode(
        array("Erro" => "Metodo nao suportado!")
    );

}

?>