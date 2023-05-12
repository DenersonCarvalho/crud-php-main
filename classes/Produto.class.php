<?php

    include_once("interfaces/crud.php");
    include_once("classes/DB.class.php");

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
    public function getId(){
        return $this -> id;
    }
    public function setCategoria($categoria_id){
        $this -> categoria_id = $categoria_id;
    }
    public function getCategoria(){
        return $this -> categoria_id;
    }
    public function setNome($nome){
        $this -> nome = $nome;
    }
    public function getNome(){
        return $this -> nome;
    }
    public function setPreco($preco){
        $this -> preco = $preco;
    }
    public function getPreco(){
        return $this->preco;
    }
    public function setQuantidade($quantidade){
        $this -> quantidade = $quantidade;
    }
    public function getQuantidade(){
        return $this->quantidade;
    }

    public function adicionar(){    //C
        $sql = "INSERT INTO produtos (categoria_id, nome, preco, quantidade)
                VALUES (:categoria_id, :nome, :preco, :quantidade)";       
                
            try{        //try-catch serve como if else, só que usado pra tratar erros e mostrar só uma mensagem
                $conexao = DB::conexao();
                $stmt = $conexao->prepare($sql); //$stmt =  STATEMANT
                $stmt->bindParam(':categoria_id', $this->categoria_id);
                $stmt->bindParam(':nome', $this->nome);
                $stmt->bindParam(':preco', $this->preco);
                $stmt->bindParam('quantidade', $this->quantidade); //os numeros representam a ordem dos "?"
                $stmt->execute();
            }catch(PDOException $e){
                echo "Erro na Função Adicionar Produto:" .$e->getMessage();
            }
            }  


    public function listar(){   //R
        $sql = "SELECT * FROM produtos";
        $conexao = DB::conexao();
        $stmt = $conexao->prepare($sql);
        $stmt->execute();
        $registros = $stmt->fetchAll(PDO::FETCH_ASSOC); //os registros que vem do bd tá na $registros e o fetchall é o que traz os dados do bd
        if($registros){
                $objetos = array();   //foreach serve para tratar arrays, $objetos vai guardar e transformar para objetos
                foreach($registros as $registro){  //esse foreach vai se repetir pra cada objeto, pegando todos os dados
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
    public function atualizar(){            //UPDATE
        if($this->id){
        $sql = "UPDATE produtos SET nome = :nome, categoria_id = :categoria_id, preco = :preco, quantidade = :quantidade WHERE id = :id";
        $stmt = DB::conexao()->prepare($sql);
        $stmt->bindParam(':nome', $this->nome);
        $stmt->bindParam(':categoria_id', $this->categoria_id);
        $stmt->bindParam(':preco', $this->preco);
        $stmt->bindParam(':quantidade', $this->quantidade);
        $stmt->bindParam(':id', $this->id);
        $stmt->execute();
        }
    }
    public function excluir(){              //DELETE
        if($this->id){
            $sql = "DELETE FROM produtos WHERE id = :id";
            $stmt = DB::conexao()->prepare($sql);
            $stmt->bindParam(':id', $this->id);
            $stmt->execute();
        }
    } 
}
?>