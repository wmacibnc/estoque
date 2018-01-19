<?php
// error
ini_set("display_errors",1);
ini_set("display_startup_erros",1);
error_reporting(E_ALL);
// config
include("config.php");

 if($_GET && (isset($_GET['id'])) ){
   $sql = 'DELETE FROM ITEM_VENDA WHERE ID='.$_GET['id'];
  mysqli_query($con, $sql) or die ('ERRO: '.mysql_error());
   header("Location: carrinho.php?mensagem=Produto removido! ");
   return;
 }

$id = $_POST['subprodutoqtd'];
$qtd = count($_POST['subprodutoqtd']);
$i=1;
foreach($_POST['subprodutoqtd'] as $a1=>$key){

  if($_POST['subprodutoqtd'][$a1]){
  //$id_venda = $_SESSION['venda'];
  $id_venda = 1;
  $id_produto = $_POST['id'][$a1];
  $id_cliente = 1; // recuperar da sessão;
  $quantidade = $_POST['subprodutoqtd'][$a1];
  $preco = 10;// recuperar do banco o valor


// Insere os dados no banco 
  $query = <<<QUERY
  INSERT INTO ITEM_VENDA(
    ID_VENDA,
    ID_PRODUTO,
    ID_CLIENTE,
    QUANTIDADE,
    PRECO)
    VALUES (
      '$id_venda',
      '$id_produto',
      '$id_cliente',
      '$quantidade',
      '$preco'
    )
QUERY;

mysqli_query($con, $query) or die ('ERRO: '.mysql_error());


    // echo "id - ".$_POST['id'][$a1];
    // echo "<br />";
    // echo "qtd".$_POST['subprodutoqtd'][$a1];
    // echo "<br />";  
  }

  $i++;
}



  header("Location: carrinho.php?mensagem=Produto adicionado com sucesso! "); /* Redirect browser */
?>
