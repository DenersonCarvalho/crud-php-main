<?php
    include_once("interfaces/crud.php");
    include_once("classes/DB.class.php");

    class Vendas implements crud{
        protected $id;
        protected $nome;
        protected $categoria_id;
        protected $preco;
        protected $quantidade;
        protected $data_venda;

        public function __construct($id=false){
            if($id){
                $sql = "SELECT * FROM vendas where id = ?";
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
                    $this->setDataVenda($obj['data_venda']);
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
        public function setDataVenda($data_venda){
            $this -> data_venda = $data_venda;
        }
        public function getDataVenda(){
            return $this->data_venda;
        }

        public function adicionar(){    //função ADICIONAR
            $sql = "INSERT INTO vendas (nome, categoria_id, preco, quantidade, data_venda)
                    VALUES (:nome, :categoria_id, :preco, :quantidade, :data_venda)";      
                    
                try{        //try-catch serve como if else, só que usado pra tratar erros e mostrar só uma mensagem
                    $conexao = DB::conexao();
                    $stmt = $conexao->prepare($sql); //$stmt =  STATEMANT
                    $stmt->bindParam(':nome', $this->nome);
                    $stmt->bindParam(':categoria_id', $this->categoria_id);
                    $stmt->bindParam(':preco', $this->preco);
                    $stmt->bindParam(':quantidade', $this->quantidade);
                    $stmt->bindParam(':data_venda', $this->data_venda);
                    $stmt->execute();
                }catch(PDOException $e){
                    echo "Erro na Função Realizar Venda:" .$e->getMessage();
                }
                }
        public function listar(){        //READ
            $sql = "SELECT * FROM vendas";
            $conexao = DB::conexao();
            $stmt = $conexao->prepare($sql);
            $stmt->execute();
            $registros = $stmt->fetchAll(PDO::FETCH_ASSOC); 
                $objetos = array();   
                foreach($registros as $registro){ 
                $temporario = new Vendas();
                    $temporario->setId($registro['id']);
                    $temporario->setNome($registro['nome']);
                    $temporario->setCategoria($registro['categoria_id']);
                    $temporario->setPreco($registro['preco']);
                    $temporario->setQuantidade($registro['quantidade']);
                    $temporario->setDataVenda($registro['data_venda']);
                $objetos[] = $temporario;
                }
                return $objetos;
                }
        public function atualizar(){            //UPDATE
            if($this->id){
            $sql = "UPDATE vendas SET nome = :nome, categoria_id = :categoria_id, preco = :preco, quantidade = :quantidade, data_venda = :data_venda WHERE id = :id";
            $stmt = DB::conexao()->prepare($sql);
            $stmt->bindParam(':nome', $this->nome);
            $stmt->bindParam(':categoria_id', $this->categoria_id);
            $stmt->bindParam(':preco', $this->preco);
            $stmt->bindParam(':quantidade', $this->quantidade);
            $stmt->bindParam(':data_venda', $this->data_venda);
            $stmt->bindParam(':id', $this->id);
            $stmt->execute();
            }
        }
        public function excluir(){              //DELETE
            if($this->id){
                $sql = "DELETE FROM vendas WHERE id = :id";
                $stmt = DB::conexao()->prepare($sql);
                $stmt->bindParam(':id', $this->id);
                $stmt->execute();
            }
        } 

    }