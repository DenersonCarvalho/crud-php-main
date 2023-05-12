<?php

    include_once("interface/crud.php");
    include_once("classes/db.class.php");

class Produto implements crud{
    protected $id;
    protected $nome;
    protected $categoria_id;
    protected $preco;
    protected $quantidade;

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
                $this->setCategoria($obj['categoria_id']);
                $this->setPreco($obj['preco']);
                $this->setQuantidade($obj['quantidade']);
            }
        }
    }

    public function setId($id){
        $this -> id = $id;
    }
    public function setCategoria($categoria_id){
        $this -> categoria_id = $categoria_id;
    }
    public function setNome($nome){
        $this -> nome = $nome;
    }
    public function setPreco($preco){
        $this -> preco = $preco;
    }
    public function setQuantidade($quantidade){
        $this -> quantidade = $quantidade;
    }
    #getters
    public function getId(){
        return $this -> id;
    }
    public function getCat(){
        return $this -> categoria_id;
    }
    public function getNome(){
        return $this -> nome;
    }
    public function getPreco(){
        return $this->preco;
    }
    public function getQuantidade(){
        return $this->quantidade;
    }

    public function adicionar(){    
        $sql = "INSERT INTO produtos (categoria_id, nome, preco, quantidade)
                VALUES (?, ?, ?, ?)";       
                
            try{       
                $conexao = DB::conexao();
                $stmt = $conexao->prepare($sql); 
                $stmt->bindParam(1, $this->categoria_id);
                $stmt->bindParam(2, $this->nome);
                $stmt->bindParam(3, $this->preco);
                $stmt->bindParam(4, $this->quantidade); 
                $stmt->execute();
            }catch(PDOException $e){
                echo "Erro na Função Adicionar Produto:" .$e->getMessage();
            }
            }  


    public function listar(){  
        $sql = "SELECT * FROM produtos";
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
                    $temporario->setCategoria($registro['categoria_id']);
                    $temporario->setPreco($registro['preco']);
                    $temporario->setQuantidade($registro['quantidade']);
                    $objetos[] = $temporario;
                }
            return $objetos;
        }
        return false;
    }
    public function atualizar(){
        if($this->id){
            $sql = "UPDATE produtos SET nome = :nome, categoria = :categoria, preco = :preco, quantidade = :quantidade WHERE id = :id";
            $stmt = DB::conexao()->prepare($sql);
            $stmt->bindParam(':id', $this->id);
            $stmt->bindParam(':nome', $this->nome);
            $stmt->bindParam(':categoria', $this->categoria_id);
            $stmt->bindParam(':preco', $this->preco);
            $stmt->bindParam(':quantidade', $this->quantidade);
            $stmt->execute();
        }
    }   
    public function excluir(){
        if($this->id){
            $sql = "DELETE FROM produtos WHERE id = :id";
            $stmt = DB::conexao()->prepare($sql);
            $stmt->bindParam(':id', $this->id); 
            $stmt->execute();
        }
    }      
}
?>