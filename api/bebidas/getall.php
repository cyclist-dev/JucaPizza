<?php
echo "hello" ?>;
<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
include_once '../../config/DB.php';
include_once '../../models/bebidas.php';
$database = new DB();
$db = $database->getConnection();
$bebidas = new bebidas($db);
$stmt = $bebidas->read();
$num = $stmt->rowCount();
if ($num > 0) {
    $bebidas_arr = array();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        $bebidas_item = array(
            "id" => $idbebidas,
            "nome" => $nome,
            "tipo" => $tipo,
            "valor" => $valor
        );
        array_push($bebidas_arr, $bebidas_item);
    }
    http_response_code(200);
    echo json_encode($bebidas_arr);
} else {
    http_response_code(404);
    echo json_encode(
        array("message" => "Nenhuma bebidas encontrada.")
    );
}

