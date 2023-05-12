<?php
    include_once("interfaces/crud.php");
    include_once("classes/DB.class.php");

    class Clientes implements crud{
        protected $id;
        protected $nome;
        protected $cpf;
        protected $sexo;
        protected $d_nascimento;

        public function __construct($id=false){
            if($id){
                $sql = "SELECT * FROM clientes where id = ?";
                $conexao = DB::conexao();
                $stmt = $conexao->prepare($sql);
                $stmt->bindParam(1, $id, PDO::PARAM_INT);
                $stmt->execute();
                foreach($stmt as $obj){
                    $this->setId($obj['id']);
                    $this->setNome($obj['nome']);
                    $this->setCpf($obj['cpf']);
                    $this->setSexo($obj['sexo']);
                    $this->setDNascimento($obj['d_nascimento']);
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
        public function setCpf($cpf){
            $this -> cpf = $cpf;
        }
        public function getCpf(){
            return $this -> cpf;
        }
        public function setSexo($sexo){
            $this -> sexo = $sexo;
        }
        public function getSexo(){
            return $this -> sexo;
        }
        public function setDNascimento($d_nascimento){
            $this -> d_nascimento = $d_nascimento;
        }
        public function getDNascimento(){
            return $this -> d_nascimento;
        }

        public function adicionar(){    //função ADICIONAR
            $sql = "INSERT INTO clientes (nome, cpf, sexo, d_nascimento)
                    VALUES (:nome, :cpf, :sexo, :d_nascimento)";       
                    
                try{       
                    $conexao = DB::conexao();
                    $stmt = $conexao->prepare($sql); //$stmt =  STATEMANT
                    $stmt->bindParam(':nome', $this->nome);
                    $stmt->bindParam(':cpf', $this->cpf);
                    $stmt->bindParam(':sexo', $this->sexo);
                    $stmt->bindParam(':d_nascimento', $this->d_nascimento); 
                    $stmt->execute();
                }catch(PDOException $e){
                    echo "Erro na Função Cadastrar clientes:" .$e->getMessage();
                }
                }
        public function listar(){        //READ
            $sql = "SELECT * FROM clientes";
            $conexao = DB::conexao();
            $stmt = $conexao->prepare($sql);
            $stmt->execute();
            $registros = $stmt->fetchAll(PDO::FETCH_ASSOC); 
                    $objetos = array();   
                    foreach($registros as $registro){ 
                    $temporario = new Clientes();
                        $temporario->setId($registro['id']);
                        $temporario->setNome($registro['nome']);
                        $temporario->setCpf($registro['cpf']);
                        $temporario->setSexo($registro['sexo']);
                        $temporario->setDNascimento($registro['d_nascimento']);
                        $objetos[] = $temporario;
                    }
                return $objetos;
                }

        public function atualizar(){            //UPDATE
            if($this->id){
                $sql = "UPDATE clientes SET nome = :nome, cpf = :cpf, sexo = :sexo, d_nascimento = :d_nascimento WHERE id = :id";
                $stmt = DB::conexao()->prepare($sql);
                $stmt->bindParam(':nome', $this->nome);
                $stmt->bindParam(':cpf', $this->cpf);
                $stmt->bindParam(':sexo', $this->sexo);
                $stmt->bindParam(':d_nascimento', $this->d_nascimento);
                $stmt->bindParam(':id', $this->id);
                $stmt->execute();
            }
        }
        public function excluir(){              //DELETE
            if($this->id){
                $sql = "DELETE FROM clientes WHERE id = :id";
                $stmt = DB::conexao()->prepare($sql);
                $stmt->bindParam(':id', $this->id);
                $stmt->execute();
            }
        } 

    }