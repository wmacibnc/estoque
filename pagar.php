<?php 
include 'head.php';

$formaPagamento = $_POST['formaPagamento'];
$id_cliente = $_POST['id_cliente'];

include'salvar-venda.php';


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


if($formaPagamento == 1){

}else if($formaPagamento == 2){

}else if($formaPagamento == 3){
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
        $query2 = "SELECT IV.ID, IV.VENDA, IV.ID_PRODUTO, (SELECT CONCAT((SELECT P2.NOME FROM PRODUTO P2 WHERE P2.ID = P.ID_PRODUTO ), CONCAT(' - ',P.NOME)) FROM PRODUTO P WHERE P.ID = IV.ID_PRODUTO)AS PRODUTO, SUM(IV.QUANTIDADE) AS QUANTIDADE, SUM(IV.PRECO) AS PRECO FROM ITEM_VENDA IV 
        WHERE IV.VENDA = ".$id_venda."
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
      $limpar = "index.php";
      // echo "<p align='center'>
      
      // <a target=\"_blank\" title=\"Cancelar Venda\" href=\"$limpar\">
      // <button class='btn btn-danger'>Cancelar Venda</button></a>
      // <a target=\"_blank\" title=\"Pagar\" href=\"$url\"><button class='btn btn-success'>Finalizar compra</button></a></p>";
    }
    
  }else{

  }
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
        <?php 
        switch ($formaPagamento) {
          case 1:
            echo "<h3>Forma Pagamento: À vista</h3>";
            break;
          case 2:
            echo "<h3>Forma Pagamento: Parcelado na loja</h3>";
            break;
          case 3:
            echo "<h3>Forma Pagamento: Pagseguro</h3>";
            echo "Link: ".$GLOBALS['url'];
            break;
          
          default:
            echo 'Ocorreu um problema!';
            break;
        }
         ?>
      </div>
    </div>
    <!-- /.container-fluid-->
    <!-- /.content-wrapper-->
    <?php include 'footer.php'; ?>