<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of read
 *
 * @author gilmarf
 */
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// include database and object files
include_once '../config/Database.php';
include_once '../objetos/Empresa.php';

// instantiate database and empresa object
$database = new Database();
$db = $database->getConnection();

// initialize object
$empresa = new Empresa($db);

// query empresas
$stmt = $empresa->queryBase('Listar');
$num = $stmt->rowCount();

// check if more than 0 record found
if($num>0){

    // empresas array
    $empresas_arr=array();
    $empresas_arr["records"]=array();

    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['nome'] to
        // just $nome only
        extract($row);

        $empresa_item=array(
            "id" => $id,
            "nome" => $nome,
            "cnpj" => $cnpj
        );

        array_push($empresas_arr["records"], $empresa_item);
    }

    // set response code - 200 OK
    http_response_code(200);

    // show empresas data in json format
    echo json_encode($empresas_arr);
}else{

    // set response code - 404 Not found
    http_response_code(404);

    // tell the user no products found
    echo json_encode(
        array("message" => "Nenhuma empresa encontrada.")
    );
}