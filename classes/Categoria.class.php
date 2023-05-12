<?php

    include_once("interfaces/crud.php");
    include_once("classes/DB.class.php");

class Categoria implements crud{
    protected $id;
    protected $nome;

    public function __construct($id=false){
        if($id){
            $sql = "SELECT * FROM categorias where id = ?";
            $conexao = DB::conexao();
            $stmt = $conexao->prepare($sql);
            $stmt->bindParam(1, $id, PDO::PARAM_INT);
            $stmt->execute();
            foreach($stmt as $obj){
                $this->setId($obj['id']);
                $this->setNome($obj['nome']);
            }
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

    public function adicionar(){    //C
        $sql = "INSERT INTO categorias (nome)
                VALUES (:nome)";       
                
            try{        //try-catch serve como if else, só que usado pra tratar erros e mostrar só uma mensagem
                $conexao = DB::conexao();
                $stmt = $conexao->prepare($sql); //$stmt =  STATEMANT
                $stmt->bindParam(':nome',$this->nome);
                $stmt->execute();
            }catch(PDOException $e){
                echo "Erro na Função Adicionar categoria:" .$e->getMessage();
            }
            }
    public  function listar(){   //R
        $sql = "SELECT * FROM categorias";
        $conexao = DB::conexao();
        $stmt = $conexao->prepare($sql);
        $stmt->execute();
        $registros = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if($registros){
                $objetos = array();  
                foreach($registros as $registro){  
                    $temporario = new Categoria();
                    $temporario->setId($registro['id']);
                    $temporario->setNome($registro['nome']);
                    $objetos[] = $temporario;
                }
            return $objetos;
        }
        return false;
    }
    public function atualizar(){            //UPDATE
        if($this->id){
            $sql = "UPDATE categorias SET nome = :nome WHERE id = :id"; //Essa é uma outra forma de fazer, tirando os "?" porém funciona do msm jeito
            $stmt = DB::conexao()->prepare($sql);
            $stmt->bindParam(':nome', $this->nome);
            $stmt->bindParam(':id', $this->id);
            $stmt->execute();
        }
    }

    public function excluir(){ //DELETE
        if($this->id){
            $sql = "DELETE FROM categorias WHERE id = :id";
            $stmt = DB::conexao()->prepare($sql);
            $stmt->bindParam(':id', $this->id);
            $stmt->execute();
        }
    } 
}