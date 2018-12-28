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
    function queryBase($tipo){
        // create SQL based on HTTP method
        switch ($tipo) {
          case 'Listar':
            $sql = "select p.id, p.nome, p.cnpj from ". $this->table_name ." p".($this->id?" WHERE id=$this->id":'')." ORDER BY p.nome DESC"; break;
          case 'Atualizar':
            $sql = "update ". $this->table_name ." set nome = '$this->nome', cnpj = '$this->cnpj' where id='$this->id'"; break;
          case 'Adicionar':
            $sql = "insert into ". $this->table_name ." (nome, cnpj) values('$this->nome', '$this->cnpj')"; break;
          case 'Deletar':
            $sql = "delete from ". $this->table_name ." where id='$this->id'"; break;
        }
        
        $stmt = $this->conn->prepare($sql);
        try{
            $stmt->execute();
        }catch(PDOException $e){
            echo $e->getMessage();
        }
        
        return $stmt;
    }
}
