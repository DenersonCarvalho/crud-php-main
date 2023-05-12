<?php
    include_once('classes/produto.class.php');
    include_once('classes/categoria.class.php');

    //$categoria = new Categoria();
    //echo $produto->getId(). "<br>";
    //echo $produto->getNome(). "<br>";

    //$produto = new Produto();
    //echo $produto->getId(). "<br>";
    //echo $produto->getNome(). "<br>";
    //echo $produto->getPreco(). "<br>";

    //$produto =new Produto();  //esse aqui é pro create, cadastrar produto
    //$produto->setCategoria(2);
    //$produto->setNome("Produto 01");
    //$produto->setPreco(10.00);
    //$produto->setQuantidade(2000);
    //$produto->adicionar();

    $produtos = Produto::Listar(); // esse aqui é pra listar tudo que tem no banco crud
    if($produtos){  //já que isso é um array, usar foreach pra quebrar e ler tudo que ele pegar
        foreach($produtos as $produto){
            echo $produto->getId(). "</br>";
            echo $produto->getNome(). "</br>";
            echo $produto->getCategoria(). "</br>";
            echo $produto->getPreco(). "</br>";
            echo $produto->getQuantidade(). "</br>";
            echo " ------ ";
            echo "</br>";

        }
    }

?>