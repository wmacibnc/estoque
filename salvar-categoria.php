<?php
// error
ini_set("display_errors",1);
ini_set("display_startup_erros",1);
error_reporting(E_ALL);
// config
include("config.php");

if($_GET && (isset($_GET['id'])) ){
  $sql = 'DELETE FROM CATEGORIA WHERE ID='.$_GET['id'];
  mysqli_query($con, $sql) or die ('ERRO: '.mysql_error());
  header("Location: categoria.php?mensagem=Dados excluidos! ");
  return;
}

$nome = $_POST['nome'];
if($_POST && (isset($_POST['id'])) ){
  $id = $_POST['id'];
}else{
  $id = null;
}

if($id ==null){
// Insere os dados no banco 
  $query = <<<QUERY
  INSERT INTO CATEGORIA(
    NOME)
    VALUES (
      '$nome'
    )
QUERY;
  }else{
// Altere os dados no banco 
    $query = "UPDATE `CATEGORIA` SET `nome` = '".$nome."'
    WHERE (`id` = ".$id.")";
  }

  mysqli_query($con, $query) or die ('ERRO: '.mysql_error());
  header("Location: categoria.php?mensagem=Dados Salvos! "); /* Redirect browser */
  ?>
