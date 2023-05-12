<?php

    include_once("interface/crud.php");
    include_once("classes/db.class.php");

class Categoria implements crud{
    protected $id;
    protected $nome;

    public function __construct($id=false){
        if($id){
            $sql = "SELECT * FROM produtos where id = ?";
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
    #getters
    public function getId(){
        return $this -> id;
    }
    public function getNome(){
        return $this -> nome;
    }

    public function adicionar(){    
        $sql = "INSERT INTO categoria (nome)
                VALUES (?)";       
                
            try{       
                $conexao = DB::conexao();
                $stmt = $conexao->prepare($sql); 
                $stmt->bindParam(2, $this->nome);
                $stmt->execute();
            }catch(PDOException $e){
                echo "Erro na Função Adicionar Produto:" .$e->getMessage();
            }
            }  


    public function listar(){  
        $sql = "SELECT * FROM categorias";
        $conexao = DB::conexao();
        $stmt = $conexao->prepare($sql);
        $stmt->execute();
        $registros = $stmt->fetchAll(PDO::FETCH_ASSOC); 
        if($registros){
                $objetos = array();  
                foreach($registros as $registro){  
                    $temporario = new Produto();
                    $temporario->setId($registro['id']);
                    $temporario->setNome($registro['nome']);
                    $objetos[] = $temporario;
                }
            return $objetos;
        }
        return false;
    }
    public function atualizar(){
        if($this->id){
            $sql = "UPDATE categorias SET nome = :nome WHERE id = :id";
            $stmt = DB::conexao()->prepare($sql);
            $stmt->bindParam(':id', $this->id);
            $stmt->bindParam(':nome', $this->nome);
            $stmt->execute();
        }
    }   
    public function excluir(){
        if($this->id){
            $sql = "DELETE FROM categorias WHERE id = :id";
            $stmt = DB::conexao()->prepare($sql);
            $stmt->bindParam(':id', $this->id); 
            $stmt->execute();
        }
    }      
}
?>