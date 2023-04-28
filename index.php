<?php
include_once("classes/Produto.class.php");
include_once("classes/Categoria.class.php");

$produto = new Produto(3);
echo $produto->getId();
echo $produto->getNome();
echo $produto->getCat();
echo $produto->getPreco();
echo $produto->getQuant();
//var_dump($produto);
$categoria = new Categoria();
//var_dump($categoria);