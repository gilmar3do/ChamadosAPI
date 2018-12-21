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
    function queryBase($tipo, $key, $nome, $cnpj){
        // create SQL based on HTTP method
        switch ($tipo) {
          case 'Listar':
            $sql = "select p.id, p.nome, p.cnpj from ". $this->table_name ." p".($key?" WHERE id=$key":'')." ORDER BY p.nome DESC"; break;
          case 'Atualizar':
            $sql = "update ". $this->table_name ." p set (p.nome, p.cnpj) values($nome, $cnpj) where id=$key"; break;
          case 'Editar':
            $sql = "insert into ". $this->table_name ." (p.nome, p.cnpj) values($nome, $cnpj)"; break;
          case 'Deletar':
            $sql = "delete ". $this->table_name ." where id=$key"; break;
        }
        // select all query
        /*$query = "SELECT
                    p.id, p.nome, p.cnpj
                FROM
                    " . $this->table_name . " p
                ORDER BY
                    p.nome DESC";*/

        // prepare query statement
        $stmt = $this->conn->prepare($sql);

        // execute query
        $stmt->execute();

        return $stmt;
    }
}
