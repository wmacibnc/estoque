<?php
// error
ini_set("display_errors",1);
ini_set("display_startup_erros",1);
error_reporting(E_ALL);
// config
include("config.php");

if($_GET && (isset($_GET['id'])) ){
  $sql = 'DELETE FROM CLIENTE WHERE ID='.$_GET['id'];
  mysqli_query($con, $sql) or die ('ERRO: '.mysql_error());
  header("Location: cliente.php?mensagem=Dados excluidos! ");
  return;
}

$id = $_POST['id'];
$nome = $_POST['nome'];
$senha = $_POST['senha'];
$dd = substr($_POST['telefone'], 0, 2);
$telefone = substr($_POST['telefone'], 2);
$cpf = $_POST['cpf'];
$email = $_POST['email'];
$cep = $_POST['cep'];
$numero = $_POST['numero'];
$complemento = $_POST['complemento'];


if($_POST && (isset($_POST['id'])) ){
  $id = $_POST['id'];
}else{
  $id = null;
}

if($id == null){
// Insere os dados no banco 
  $query = <<<QUERY
  INSERT INTO CLIENTE(
    ID,
    NOME,
    SENHA,
    DD,
    TELEFONE,
    CPF,
    EMAIL,
    CEP,
    NUMERO,
    COMPLEMENTO)
    VALUES (
      '$id',
      '$nome',
      '$senha',
      '$dd',
      '$telefone',
      '$cpf',
      '$email',
      '$cep',
      '$numero',
      '$complemento'
    )
QUERY;
  }else{

// Altere os dados no banco 
    $query = "UPDATE `CLIENTE` 
      SET `nome` = '".$nome."',
      `senha` = '".$senha."',
      `dd` = '".$dd."',
      `telefone` = '".$telefone."',
      `cpf` = '".$cpf."',
      `email` = '".$email."',
      `cep` = '".$cep."',
      `numero` = '".$numero."',
      `complemento` = '".$complemento."'
    WHERE (`id` = ".$id.")";
  }

  mysqli_query($con, $query) or die ('ERRO: '.mysql_error());
  header("Location: cliente.php?mensagem=Dados Salvos! "); /* Redirect browser */
  ?>
