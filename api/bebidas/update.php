<?php

// Headers

header('Access-Control-Allow-Origin: *');

header('Content-Type: application/json');

header('Access-Control-Allow-Methods: PUT');

header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

 

include_once '../../config/db.php';

include_once '../../models/bebidas.php';

 



$database = new DB();

$db = $database->getConnection();

 


$bebidas = new bebidas($db);

 

if ($_SERVER['REQUEST_METHOD'] == 'PUT') {

    try {

        

        $data = json_decode(file_get_contents("php://input"));

 

       

        if (

            !empty($data->id) &&

            !empty($data->nome) &&

            !empty($data->tipo) &&

            !empty($data->valor)

        ) {

            

            $bebidas->idbebidas = $data->id; 

 

            

            $bebidas->nome = $data->nome;

            $bebidas->tipo = $data->tipo;

            $bebidas->valor = $data->valor;

 

            

            if ($bebidas->update()) {

                http_response_code(200);

                

                echo json_encode(

                    array('Mensagem' => 'Bebida Atualizada com Sucesso')

                );

            } else {

                http_response_code(500);

               

                echo json_encode(

                    array('Mensagem' => 'Nao foi possivel atualizar a bebida')

                );

            }

        } else {

            

            http_response_code(400);

            echo json_encode(

                array('Mensagem' => 'Dados Incompletos. Nao foi possivel atualizar a bebida.')

            );

        }

    } catch (Exception $e) {        

        echo json_encode(array("erro" => $e->getMessage()));

    }

} else {

    http_response_code(405);

    echo json_encode(array("erro" => "Método não suportado!"));

}

?>