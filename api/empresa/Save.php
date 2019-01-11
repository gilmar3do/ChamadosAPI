<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 

// include database and object files
include_once '../config/Database.php';
include_once '../objetos/Empresa.php';

// instantiate database and empresa object
$database = new Database();
$db = $database->getConnection();

// initialize object
$empresa = new Empresa($db);

// get posted data
$data = json_decode(file_get_contents("php://input"));
 
// make sure data is not empty
if( !empty($data->nome) &&
    !empty($data->cnpj))
    {
 
        // set product property values
        $empresa->nome = $data->nome;
        $empresa->cnpj = $data->cnpj;
        $tipo = 'Adicionar';
        if(!empty($data->id)){
            $empresa->id = $data->id;
            $tipo = 'Atualizar';
        }

        // create the product
        if(!empty($empresa->queryBase($tipo))){

            // set response code - 201 created
            http_response_code(201);

            // tell the user
            echo json_encode(array("message" => "Empresa Criada!"));
        }

        // if unable to create the product, tell the user
        else{

            // set response code - 503 service unavailable
            http_response_code(503);

            // tell the user
            echo json_encode(array("message" => "Empresa nao criada!"));
        }
    }
 
    // tell the user data is incomplete
else{

        // set response code - 400 bad request
        http_response_code(400);

        // tell the user
        echo json_encode(array("message" => "Empresa Não criada. Dados imcompletos."));
        echo json_encode(array("Erro" => $data->nome));
    }