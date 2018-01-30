<?php 
include 'head.php';

//ini_set("display_errors",0);
//ini_set("display_startup_erros",0);
//error_reporting(E_ALL);

$GLOBALS['url'] = "teste";

$formaPagamento = $_POST['formaPagamento'];
$id_cliente = $_POST['id_cliente'];

include'salvar-venda.php';

$GLOBALS['id_venda'] = $id_venda;
$GLOBALS['id_cliente'] = $id_cliente;

$cont = 1;
$totalQtd = 0;
$totalValor = 0;

foreach ($_SESSION['carrinho'] as $key => $value) :
  $query = "SELECT P.ID, (SELECT CONCAT( (SELECT P2.NOME FROM PRODUTO P2 WHERE P2.ID = P.ID_PRODUTO ), CONCAT(' - ', P.NOME) ) ) AS PRODUTO, (SELECT P2.PRECO_VENDA FROM PRODUTO P2 WHERE P2.ID = P.ID_PRODUTO) AS PRECO FROM PRODUTO P WHERE P.ID = ".$value[0]."";
  $result = $con->query($query);

  while($carrinho = $result->fetch_array(MYSQLI_ASSOC)){

    $totalQtd = $totalQtd + $value[1];
    $totalValor = $totalValor + $carrinho['PRECO'];
    
    $id_produto = $value[0];
    $quantidade = $value[1];
    $preco = $carrinho['PRECO'];

    include 'salvar-item-venda.php';
  }
endforeach;
?>




<div class="content-wrapper">
  <div class="container-fluid">
    <!-- Breadcrumbs-->
    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <a href="index.php">Início</a>
      </li>
      <li class="breadcrumb-item active">Cadastros</li>
      <li class="breadcrumb-item active">Carrinho</li>
    </ol>
    <div class="row">
      <div class="col-12">
        <?php 
        switch ($formaPagamento) {
          case 1:
          echo '
          <div class="card mb-3">
          <div class="card-header">
          <i class="fa fa-shopping-cart"></i> Forma de Pagamento:<b> À vista </b></div>
          <div class="card-body">';
          
          echo '</div>
          <div class="card-footer small text-muted">Loja Nanda agradece a sua compra!</div>
          </div>
          ';
          break;
          case 2:
          echo '
          <div class="card mb-3">
          <div class="card-header">
          <i class="fa fa-shopping-cart"></i> Forma de Pagamento:<b> Parcelado na loja </b></div>
          <div class="card-body">';
          
          echo '</div>
          <div class="card-footer small text-muted">Loja Nanda agradece a sua compra!</div>
          </div>
          ';
          break;
          case 3:
          include 'pagseguro.php';
          echo '
          <div class="card mb-3">
          <div class="card-header">
          <i class="fa fa-shopping-cart"></i> Forma de Pagamento:<b> PagSeguro </b></div>
          <div class="card-body">';
          if($id_cliente == 0){
              echo '<b>Cliente:</b> Consumidor Padrão';
          }else{
            $queryCliente = "SELECT C.ID, C.NOME FROM CLIENTE C WHERE C.ID = ".$id_cliente;
            $resultCliente = $con->query($queryCliente);

            while($cliente = $resultCliente->fetch_array(MYSQLI_ASSOC)){
              echo '<b>Cliente:</b> '.$cliente['NOME'];
            }  
          }
          ?>
          <br /><br />
          <div class="table-responsive">
            <table class="table table-bordered" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>*</th>
                  <th>Produto</th>
                  <th>Qtd</th>
                  <th>Preço</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $query = "
                SELECT 
                case 
                when PROD.ID_CATEGORIA > 0 
                then 
                (PROD.NOME) 
                else 
                  CONCAT(
                (SELECT P.NOME FROM PRODUTO P WHERE P.ID = PROD.ID_PRODUTO), CONCAT(' - ', PROD.NOME)
                )
                END AS PRODUTO, 

                IV.PRECO AS PRECO,
                IV.QUANTIDADE AS QUANTIDADE
                
                FROM ITEM_VENDA IV 
                
                JOIN PRODUTO PROD
                ON PROD.ID = IV.ID_PRODUTO

                WHERE IV.ID_VENDA = ".$id_venda."
                
                ORDER BY PROD.NOME asc";

                $result = $con->query($query);
                $contador = 1;
                while($produto = $result->fetch_array(MYSQLI_ASSOC)){
                  echo '<tr>';
                  echo '<td>';
                  echo $contador ++;
                  echo '</td>';
                  echo '<td>';
                  echo $produto['PRODUTO'];
                  echo '</td>';
                  echo '<td>';
                  echo $produto['QUANTIDADE'];
                  echo '</td>';
                  echo '<td>';
                  echo 'R$ ' . number_format($produto['PRECO'], 2, ',', '.');
                  echo '</td>';
                  echo '</tr>';
                }
                ?>
                <td>
                  -
                </td>
                <td>
                  <b>Total</b>
                </td>
                <td>
                  <b><?php echo $totalQtd; ?></b>
                </td>
                <td>
                  <b><?php echo 'R$ ' . number_format($totalValor, 2, ',', '.'); ?></b>
                </td>
              </tbody>
            </table>
            <?php 
            echo '<a href="'.$GLOBALS["url"].' target="_blank" ">'.$GLOBALS["url"].'</a>';
            echo '<br /> <br />';
            echo '</div>
            <div class="card-footer small text-muted">Loja Nanda agradece a sua compra!</div>
            </div>
            ';

            break;

            default:
            echo 'Ocorreu um problema!';
            break;
          }
          ?>
        </div>
      </div>
    </div>
    <!-- /.container-fluid-->
    <!-- /.content-wrapper-->
    <?php include 'footer.php'; ?>