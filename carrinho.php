<?php 
include 'head.php'; 
require_once "PagSeguroLibrary/PagSeguroLibrary.php";
ini_set("display_errors",0);
ini_set("display_startup_erros",0);
error_reporting(E_ALL);

$GLOBALS['url'] = "teste";


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
        <?php if(isset($_GET['mensagem'])){ ?>
        <div class="alert alert-success alert-dismissable">
          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
          <strong>Sucesso!</strong> <?php echo $_GET['mensagem']; ?>
        </div>
        <?php } ?>


        <h1>Carrinho</h1>

        <div class="card mb-3">
         <div class="card-header">
          <i class="fa fa-table"></i> Produtos</div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-bordered" width="100%" cellspacing="0">
                <thead>
                  <tr>
                    <th>Item</th>
                    <th>Produto</th>
                    <th>Qtd</th>
                    <th>Preço</th>
                    <th>Ação</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $cont = 1;
                  $totalQtd = 0;
                  $totalValor = 0;
                  foreach ($_SESSION['carrinho'] as $key => $value) :
                    $query = "SELECT P.ID, (SELECT CONCAT( (SELECT P2.NOME FROM PRODUTO P2 WHERE P2.ID = P.ID_PRODUTO ), CONCAT(' - ', P.NOME) ) ) AS PRODUTO, (SELECT P2.PRECO_VENDA FROM PRODUTO P2 WHERE P2.ID = P.ID_PRODUTO) AS PRECO FROM PRODUTO P WHERE P.ID = ".$value[0]."";
                    $result = $con->query($query);

                    while($carrinho = $result->fetch_array(MYSQLI_ASSOC)){

                      $totalQtd = $totalQtd + $value[1];
                      $totalValor = $totalValor + $carrinho['PRECO'];
                      echo '<tr>';
                      echo '<td>';
                      echo $cont++;
                      echo '</td>';
                      echo '<td>';
                      echo $carrinho['PRODUTO'];
                      echo '</td>';
                      echo '<td>';
                      echo $value[1];
                      echo '</td>';
                      echo '<td>';
                      echo 'R$ ' . number_format($carrinho['PRECO'], 2, ',', '.');
                      echo '</td>';
                      echo '<td>';
                      $id = $carrinho['ID'];
                      echo '
                      <a href="atualizar-carrinho.php?id='.$id.'"><button type="button" class="btn btn-danger"><i class="fa fa-fw fa-minus-square"></i></button></a>';
                      echo '</td>';
                      echo '</tr>';
                    }
                  endforeach;
                  ?>
                  <tr>
                    <td>-</td>
                    <td>Total</td>
                    <td><?php echo $totalQtd; ?></td>
                    <td><?php echo 'R$ ' . number_format($totalValor, 2, ',', '.'); ?></td>
                    <td>-</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>

          <div align="left">
            <form action="pagar.php" method="POST">

              <!-- Select Basic -->
              <div class="form-group" id="prod">
                <label class="control-label" for="cliente">Cliente</label>
                <div>
                  <select id="id_cliente" name="id_cliente" class="form-control">
                    <option value="0">Consumidor Padrão</option>;
                    <?php
                    $queryClientes = "SELECT C.ID, C.NOME FROM CLIENTE C ORDER BY C.NOME ";
                    $resultClientes = $con->query($queryClientes);

                    while($clientes = $resultClientes->fetch_array(MYSQLI_ASSOC)){
                      $id_cliente = $clientes['ID'];
                      $nome_cliente = $clientes['NOME'];
                      echo "<option value=".$id_cliente.">".$nome_cliente."</option>";
                      }
                      ?>
                    </select>
                  </div>
                </div>
                


                <!-- Select Basic -->
                <div class="form-group" id="prod">
                  <label class="control-label" for="formaPagamento">Forma de Pagamento</label>
                  <div>
                    <select id="formaPagamento" name="formaPagamento" class="form-control">
                      <option value="1" selected>À vista</option>
                      <option value="2">Parcelado na loja</option>
                      <option value="3">PagSeguro</option>
                    </select>
                  </div>
                </div>
                <button id="pagar" type="submit" name="pagar" class="btn btn-success">Finalizar compra</button>
              </form>
            </div>



            <!-- <div class="card-footer small text-muted">Atualizado às 13:29 PM</div> -->
          </div>
        </div>
      </div>
    </div>
    <!-- /.container-fluid-->
    <!-- /.content-wrapper-->
    <?php include 'footer.php'; ?>