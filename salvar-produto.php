<?php
// error
ini_set("display_errors",1);
ini_set("display_startup_erros",1);
error_reporting(E_ALL);
// config
include("config.php");

if($_GET && (isset($_GET['id'])) ){
  $sql = 'DELETE FROM PRODUTO WHERE ID='.$_GET['id'];
  mysqli_query($con, $sql) or die ('ERRO: '.mysql_error());
  header("Location: produto.php?mensagem=Dados excluidos! ");
  return;
}

$id = $_POST['id'];
$id_categoria = $_POST['id_categoria'];
$nome = $_POST['nome'];
$id_produto = $_POST['id_produto'];
$quantidade = $_POST['quantidade'];
$precoCusto = $_POST['precoCusto'];
$precoVenda = $_POST['precoVenda'];
$peso = $_POST['peso'];
$altura = $_POST['altura'];

if($_POST && (isset($_POST['id'])) ){
  $id = $_POST['id'];
}else{
  $id = null;
}

if($_POST['tipo'] == 1){
  $id_produto = null;
}else{
  $id_categoria = null;
}

if($id == null){
// Insere os dados no banco 
  $query = <<<QUERY
  INSERT INTO PRODUTO(
    ID,
    ID_CATEGORIA,
    NOME,
    ID_PRODUTO,
    QUANTIDADE,
    PRECO_CUSTO,
    PRECO_VENDA,
    PESO,
    ALTURA)
    VALUES (
      '$id',
      '$id_categoria',
      '$nome',
      '$id_produto',
      '$quantidade',
      '$precoCusto',
      '$precoVenda',
      '$peso',
      '$altura'
    )
QUERY;
  }else{

// Altere os dados no banco 
    $query = "UPDATE `PRODUTO` 
      SET `nome` = '".$nome."',
      `id_categoria` = '".$id_categoria."',
      `id_produto` = '".$id_produto."',
      `quantidade` = '".$quantidade."',
      `preco_custo` = '".$precoCusto."',
      `preco_venda` = '".$precoVenda."',
      `peso` = '".$peso."',
      `altura` = '".$altura."'
    WHERE (`id` = ".$id.")";
  }

  mysqli_query($con, $query) or die ('ERRO: '.mysql_error());
  header("Location: produto.php?mensagem=Dados Salvos! "); /* Redirect browser */
  ?>
