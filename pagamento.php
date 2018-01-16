<?php 
include 'head.php'; 
require_once "PagSeguroLibrary/PagSeguroLibrary.php";

$GLOBALS['url'] = "teste";
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
        $paymentRequest->addItem('1', 'Notebook prata', 2, 430.00, 100);

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
?>

<div class="content-wrapper">
  <div class="container-fluid">
    <!-- Breadcrumbs-->
    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <a href="index.php">Início</a>
    </li>
    <li class="breadcrumb-item active">Cadastros</li>
    <li class="breadcrumb-item active">Categoria</li>
</ol>
<div class="row">

  <div class="col-12">
    <?php 
    
        if ($GLOBALS['url']) {
            $url = $GLOBALS['url'];
            echo "<h2>Criando requisi&ccedil;&atilde;o de pagamento</h2>";
            echo "<p>URL do pagamento: <strong>$url</strong></p>";
            echo "<p><a title=\"URL do pagamento\" href=\"$url\">Ir para URL do pagamento.</a></p>";
        }
    

    ?>
</div>
</div>
</div>
</div>
<?php  include 'footer.php'; ?>


