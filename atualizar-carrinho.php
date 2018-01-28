<?php
if(!isset($_SESSION)){
  session_start();
}
// error
ini_set("display_errors",1);
ini_set("display_startup_erros",1);
error_reporting(E_ALL);
// config
include("config.php");

if($_GET && (isset($_GET['id'])) ){
unset($_SESSION['carrinho'][$_GET['id']]); 
 header("Location: carrinho.php?mensagem=Produto removido! ");
 return;
}

$id = $_POST['subprodutoqtd'];
$qtd = count($_POST['subprodutoqtd']);
$i=1;
foreach($_POST['subprodutoqtd'] as $a1=>$key){

  if($_POST['subprodutoqtd'][$a1]){

    if (empty($_SESSION['carrinho'])) {
      $_SESSION['carrinho'] = [];
    }

    $id_produto = $_POST['id'][$a1];
    $quantidade = $_POST['subprodutoqtd'][$a1];

    array_push($_SESSION['carrinho'], [$id_produto, $quantidade]);

  }

  $i++;
}

header("Location: carrinho.php?mensagem=Produto adicionado com sucesso! "); /* Redirect browser */
?>
