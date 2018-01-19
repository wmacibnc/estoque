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
                        <th>Quantidade</th>
                        <th>Preço</th>
                        <th>Ação</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $query = "SELECT IV.ID, IV.ID_PRODUTO, (SELECT CONCAT((SELECT P2.NOME FROM PRODUTO P2 WHERE P2.ID = P.ID_PRODUTO ), CONCAT(' - ',P.NOME)) FROM PRODUTO P WHERE P.ID = IV.ID_PRODUTO)AS PRODUTO, SUM(IV.QUANTIDADE) AS QUANTIDADE, SUM(IV.PRECO) AS PRECO FROM ITEM_VENDA IV 
                      GROUP BY IV.ID_PRODUTO, PRODUTO
                      ORDER BY IV.ID ";

                      $result = $con->query($query);
                      $cont = 1;
                      $totalQtd = 0;
                      $totalValor = 0;
                      while($carrinho = $result->fetch_array(MYSQLI_ASSOC)){
                        $totalQtd = $totalQtd + $carrinho['QUANTIDADE'];
                        $totalValor = $totalValor + $carrinho['PRECO'];
                        echo '<tr>';
                        echo '<td>';
                        echo $cont++;
                        echo '</td>';
                        echo '<td>';
                        echo $carrinho['PRODUTO'];
                        echo '</td>';
                        echo '<td>';
                        echo $carrinho['QUANTIDADE'];
                        echo '</td>';
                        echo '<td>';
                        echo $carrinho['PRECO'];
                        echo '</td>';
                        echo '<td>';
                        $id = $carrinho['ID'];
                        echo '
                        <a href="atualizar-carrinho.php?id='.$id.'"><button type="button" class="btn btn-danger"><i class="fa fa-fw fa-minus-square"></i></button></a>';
                        echo '</td>';
                        echo '</tr>';
                      }
                      ?>
                      <tr>
                        <td>-</td>
                        <td>Total</td>
                        <td><?php echo $totalQtd; ?></td>
                        <td><?php echo $totalValor; ?></td>
                        <td>-</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
              <?php 



class PagSeguroConfigWrapper{

  public static function getConfig(){

    $PagSeguroConfig = array();

    $PagSeguroConfig['environment'] = "production";

    $PagSeguroConfig['credentials'] = array();
    $PagSeguroConfig['credentials']['email'] = "eufefranco@gmail.com";
    $PagSeguroConfig['credentials']['token']['production'] = "F42E53B46EB443AEBE2EB6FD18B2A98A";
    $PagSeguroConfig['credentials']['appId']['production'] = "loja-da-nanda";
    $PagSeguroConfig['credentials']['appKey']['production'] = "65EBADCE8585A64444E0CFB5E7996652";

    $PagSeguroConfig['application'] = array();
        $PagSeguroConfig['application']['charset'] = "UTF-8"; // UTF-8, ISO-8859-1

        $PagSeguroConfig['log'] = array();
        $PagSeguroConfig['log']['active'] = false;
        $PagSeguroConfig['log']['fileLocation'] = "";

        return $PagSeguroConfig;
      }
    }

    class CreatePaymentRequest{

      public static function main()
      {
        // Instantiate a new payment request
        $paymentRequest = new PagSeguroPaymentRequest();

        // Set the currency
        $paymentRequest->setCurrency("BRL");

        // so iterar
        $query2 = "SELECT IV.ID, IV.ID_PRODUTO, (SELECT CONCAT((SELECT P2.NOME FROM PRODUTO P2 WHERE P2.ID = P.ID_PRODUTO ), CONCAT(' - ',P.NOME)) FROM PRODUTO P WHERE P.ID = IV.ID_PRODUTO)AS PRODUTO, SUM(IV.QUANTIDADE) AS QUANTIDADE, SUM(IV.PRECO) AS PRECO FROM ITEM_VENDA IV 
        GROUP BY IV.ID_PRODUTO, PRODUTO
        ORDER BY IV.ID ";

        $result2 = $GLOBALS['con']->query($query2);
        $cont2 = 1;
        while($carrinho2 = $result2->fetch_array(MYSQLI_ASSOC)){
          $preco_venda = ($carrinho2['PRECO'] / $carrinho2['QUANTIDADE']).".00";
          $paymentRequest->addItem($cont2++, $carrinho2['PRODUTO'], $carrinho2['QUANTIDADE'], $preco_venda, 100);            
        }
        

        // Set a reference code for this payment request. It is useful to identify this payment
        // in future notifications.
        $paymentRequest->setReference("REF123");

        // Set shipping information for this payment request
        $sedexCode = PagSeguroShippingType::getCodeByType('PAC');
        $paymentRequest->setShippingType($sedexCode);
        $paymentRequest->setShippingAddress(
          '01452002',
          'Av. Brig. Faria Lima',
          '1384',
          'apto. 114',
          'Jardim Paulistano',
          'São Paulo',
          'SP',
          'BRA'
        );

        // Set your customer information.
        $paymentRequest->setSender(
          'João Comprador',
          'email@comprador.com.br',
          '11',
          '56273440',
          'CPF',
          '156.009.442-76'
        );

        try {

          $credentials = PagSeguroConfig::getAccountCredentials();
          $GLOBALS['url'] = $paymentRequest->register($credentials);

    //        self::printPaymentUrl($GLOBALS['url']);

        } catch (PagSeguroServiceException $e) {
          die($e->getMessage());
        }
      }

    }

    CreatePaymentRequest::main();




              if ($GLOBALS['url']) {
                $url = $GLOBALS['url'];
                echo "<p><a target=\"_blank\" title=\"Pagar\" href=\"$url\">Finalizar compra</a></p>";
              }
              ?>
              <div class="card-footer small text-muted">Atualizado às 13:29 PM</div>
            </div>
          </div>
        </div>
      </div>
      <!-- /.container-fluid-->
      <!-- /.content-wrapper-->
      <?php include 'footer.php'; ?>