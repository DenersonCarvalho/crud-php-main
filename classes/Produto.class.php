<?php
include_once("interface/crud.php");
include_once("db.class.php");

class Produto implements crud{
    private $id;
    private $categoria_id;
    private $nome;
    private $preco;
    private $quantidade;

    public function __construct($id=false){
        if($id){
            
            $sql = "SELECT * FROM produtos WHERE id = ?";
            $conexao = DB::conexao();
            
            $stmt = $conexao->prepare($sql);
            $stmt->bindParam(1,$id, PDO::PARAM_INT);
            $stmt->execute();
            
            foreach($stmt as $obj){
                $this->setId($obj['id']);
                $this->setCat($obj['categoria_id']);
                $this->setNome($obj['nome']);
                $this->setPreco($obj['preco']);
                $this->setQuant($obj['quantidade']);
            }

            //$stmt = DB::conexao()->prepare($sql);
        }
    }

    #setters
    public function setId($id){
        $this -> id = $id;
    }
    public function setCat($categoria_id){
        $this -> categoria_id = $categoria_id;
    }
    public function setNome($nome){
        $this -> nome = $nome;
    }
    public function setPreco($preco){
        $this -> preco = $preco;
    }
    public function setQuant($quantidade){
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
        return $this -> preco;
    }
    public function getQuant(){
        return $this -> quantidade;
    }

        public function adicionar(){}
        public function listar(){}
        public function atualizar(){}
        public function excluir(){}
}