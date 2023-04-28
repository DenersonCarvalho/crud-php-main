<?php
include_once("interface/crud.php");

class Categoria implements crud{
    private $id;
    private $nome;

    public function __construct($id=false){
        if($id){
            echo "Testando o construtor";
        }
    }

    public function setId($id){
        $this -> id = $id;
    }
    public function setNome($nome){
        $this -> nome = $nome;
    }

    public function getId(){
        return $this -> id;
    }
    public function getNome(){
        return $this -> nome;
    }

    public function adicionar(){}
    public function listar(){}
    public function atualizar(){}
    public function excluir(){}
}