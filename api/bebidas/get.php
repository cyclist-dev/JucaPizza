<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
include_once '../../config/db.php';
include_once '../../models/bebidas.php';
$database = new DB();
$db = $database->getConnection();
$bebidas = new Bebidas($db);
$bebidas->idbebidas = isset($_GET['id']) ? $_GET['id'] : null;
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if ($bebidas->idbebidas) {
        $bebidas->get();
        $bebidas_arr = array(
            "id" => $bebidas->idbebidas,
            "nome" => $bebidas->nome,
            "tipo" => $bebidas->tipo,
            "valor" => $bebidas->valor
        );
        echo json_encode($bebidas_arr, JSON_PRETTY_PRINT);
    } else {
        http_response_code(400);
        echo json_encode(
            array("Mensagem" => "Id não informado.")
        );
    }
} else {
    http_response_code(405);
    echo json_encode(
        array("Mensagem" => "Método não permitido.")
    );
}