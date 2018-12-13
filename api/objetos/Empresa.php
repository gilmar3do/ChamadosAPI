<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Empresa
 *
 * @author gilmarf
 */
class Empresa {
    // database connection and table name
    private $conn;
    private $table_name = "empresas";
 
    // object properties
    public $id;
    public $nome;
    public $cnpj;
 
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }
    
    // read empresas
    function read(){

        // select all query
        $query = "SELECT
                    p.id, p.nome, p.cnpj
                FROM
                    " . $this->table_name . " p
                ORDER BY
                    p.nome DESC";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // execute query
        $stmt->execute();

        return $stmt;
    }
}
