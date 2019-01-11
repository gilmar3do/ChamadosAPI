<?php

// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// include database and object file
include_once '../config/Database.php';
include_once '../objetos/Empresa.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare product object
$empresa = new Empresa($db);
 
// get product id
$data = json_decode(file_get_contents("php://input"));
 
// set product id to be deleted
$empresa->id = $data->id;
print("Deleted $data->id rows.\n");
$stmt = $empresa->queryBase('Deletar');
$num = $stmt->rowCount();
// delete the product
if($num > 0){
    // set response code - 200 ok
    http_response_code(200);

    // tell the user
    echo json_encode(array("message" => "Empresa foi deletada"));
}
 
// if unable to delete the product
else{
 
    // set response code - 503 service unavailable
    http_response_code(503);
 
    // tell the user
    echo json_encode(array("message" => "Não foi possível deletar a empresa"));
}