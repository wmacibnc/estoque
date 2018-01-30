<?php 
require_once "PagSeguroLibrary/PagSeguroLibrary.php";
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
        $query2 = "SELECT IV.ID, IV.ID_VENDA, IV.ID_PRODUTO, (SELECT CONCAT((SELECT P2.NOME FROM PRODUTO P2 WHERE P2.ID = P.ID_PRODUTO ), CONCAT(' - ',P.NOME)) FROM PRODUTO P WHERE P.ID = IV.ID_PRODUTO)AS PRODUTO, IV.QUANTIDADE AS QUANTIDADE, IV.PRECO AS PRECO FROM ITEM_VENDA IV WHERE IV.ID_VENDA = ".$GLOBALS['id_venda']." GROUP BY IV.ID_PRODUTO, PRODUTO ORDER BY IV.ID ";

        $result2 = $GLOBALS['con']->query($query2);
        $cont2 = 1;

        while($carrinho2 = $result2->fetch_array(MYSQLI_ASSOC)){
        //$preco_venda = ($carrinho2['PRECO'] / $carrinho2['QUANTIDADE']).".00";
          ECHO $carrinho2['PRODUTO'];
          ECHO $carrinho2['QUANTIDADE'];
          ECHO $carrinho2['PRECO'];
        $paymentRequest->addItem($cont2++, $carrinho2['PRODUTO'], $carrinho2['QUANTIDADE'], $carrinho2['PRECO'], 100);            
        }
        

        // Set a reference code for this payment request. It is useful to identify this payment
        // in future notifications.
        $paymentRequest->setReference($GLOBALS['id_venda']);

        // Set shipping information for this payment request
        $sedexCode = PagSeguroShippingType::getCodeByType('PAC');
        $paymentRequest->setShippingType($sedexCode);

        $queryCliente = "SELECT C.CEP, C.COMPLEMENTO, C.NUMERO, C.ID, C.NOME, C.CPF, C.DD, C.TELEFONE, C.EMAIL FROM CLIENTE C WHERE C.ID = ".$GLOBALS['id_cliente'];
        $resultCliente = $GLOBALS['con']->query($queryCliente);
        $cep = null;
        while($cliente = $resultCliente->fetch_array(MYSQLI_ASSOC)){
          echo $cep = $cliente['CEP'];
        }

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

            //self::printPaymentUrl($GLOBALS['url']);

        } catch (PagSeguroServiceException $e) {
          die($e->getMessage());
        }
      }

    }

    CreatePaymentRequest::main();

    if ($GLOBALS['url']) {
      $url = $GLOBALS['url'];
      $limpar = "index.php";
      // echo "<p align='center'> <a target=\"_blank\" title=\"Cancelar Venda\" href=\"$limpar\"> <button class='btn btn-danger'>Cancelar Venda</button></a> <a target=\"_blank\" title=\"Pagar\" href=\"$url\"><button class='btn btn-success'>Finalizar compra</button></a></p>";
    }
    ?>