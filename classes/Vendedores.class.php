<?php
    include_once("interfaces/crud.php");
    include_once("classes/DB.class.php");

    class Vendedores implements crud{
        protected $id;
        protected $nome;
        protected $cargo;
        protected $salario;

        public function __construct($id=false){
            if($id){
                $sql = "SELECT * FROM vendedores where id = ?";
                $conexao = DB::conexao();
                $stmt = $conexao->prepare($sql);
                $stmt->bindParam(1, $id, PDO::PARAM_INT);
                $stmt->execute();
                foreach($stmt as $obj){
                    $this->setId($obj['id']);
                    $this->setNome($obj['nome']);
                    $this->setCargo($obj['cargo']);
                    $this->setSalario($obj['salario']);
                }
            }
        }

        public function setId($id){
            $this -> id = $id;
        }
        public function getId(){
            return $this -> id;
        }
        public function setNome($nome){
            $this -> nome = $nome;
        }
        public function getNome(){
            return $this -> nome;
        }
        public function setCargo($cargo){
            $this -> cargo = $cargo;
        }
        public function getCargo(){
            return $this -> cargo;
        }
        public function setSalario($salario){
            $this -> salario = $salario;
        }
        public function getSalario(){
            return $this -> salario;
        }

        public function adicionar(){            //CREATE
            $sql = "INSERT INTO vendedores (nome, cargo, salario)
                    VALUES (:nome, :cargo, :salario)";       
                    
                try{        
                    $conexao = DB::conexao();
                    $stmt = $conexao->prepare($sql); //$stmt =  STATEMANT
                    $stmt->bindParam(':nome', $this->nome);
                    $stmt->bindParam(':cargo', $this->cargo);
                    $stmt->bindParam(':salario', $this->salario); 
                    $stmt->execute();
                }catch(PDOException $e){
                    echo "Erro na Função Cadastrar vendedor (a) :" .$e->getMessage();
                }
                }

        public function listar(){        //READ
            $sql = "SELECT * FROM vendedores";
            $conexao = DB::conexao();
            $stmt = $conexao->prepare($sql);
            $stmt->execute();
            $registros = $stmt->fetchAll(PDO::FETCH_ASSOC); 
                    $objetos = array();   
                    foreach($registros as $registro){ 
                    $temporario = new Vendedores();
                        $temporario->setId($registro['id']);
                        $temporario->setNome($registro['nome']);
                        $temporario->setCargo($registro['cargo']);
                        $temporario->setSalario($registro['salario']);
                        $objetos[] = $temporario;
                    }
                return $objetos;
                }

        public function atualizar(){            //UPDATE
        if($this->id){
            $sql = "UPDATE vendedores SET nome = :nome, cargo = :cargo, salario = :salario WHERE id = :id";
            $stmt = DB::conexao()->prepare($sql);
            $stmt->bindParam(':nome', $this->nome);
            $stmt->bindParam(':cargo', $this->cargo);
            $stmt->bindParam(':salario', $this->salario);
            $stmt->bindParam(':id', $this->id);
            $stmt->execute();
            }
        }
        public function excluir(){              //DELETE
            if($this->id){
                $sql = "DELETE FROM vendedores WHERE id = :id";
                $stmt = DB::conexao()->prepare($sql);
                $stmt->bindParam(':id', $this->id);
                $stmt->execute();
            }
        }     
    }
?>