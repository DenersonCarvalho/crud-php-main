<?php
    class db{
        /*public static $servidor = "localhost";
        public static $root = "root";
        public static $senha = "";
        public static $nome_banco = "crud";*/
        
        public static function conexao(){
            $conexao = null;
            try {
                $conexao = new PDO("mysql:host=localhost;dbname=crud", "root", "");
                $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                echo "Erro de Conexão:" .$e->getMessage();
            }
            return $conexao;
        }
    }
?>