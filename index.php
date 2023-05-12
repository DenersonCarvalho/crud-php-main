<?php
include_once("classes/Produto.class.php");
include_once("classes/Categoria.class.php");

$produto = new Produto(3);
echo $produto->getId();
echo $produto->getNome();
echo $produto->getPreco();
//var_dump($produto);
$categoria = new Categoria(1);
echo $categoria->getId();
echo $categoria->getNome();

//var_dump($categoria);