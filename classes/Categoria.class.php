<?php
include_once("interface/crud.php");

class Categoria implements crud{
    private $id;
    private $nome;

    public function __construct($id=false){
        if($id){
            
            $sql = "SELECT * FROM categoria WHERE id = ?";
            $conexao = DB::conexao();
            
            $stmt = $conexao->prepare($sql);
            $stmt->bindParam(1,$id, PDO::PARAM_INT);
            $stmt->execute();
            
            foreach($stmt as $obj){
                $this->setId($obj['id']);
                $this->setNome($obj['nome']);
            }

            //$stmt = DB::conexao()->prepare($sql);
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