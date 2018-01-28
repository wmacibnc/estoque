<?php 

$query = <<<QUERY
INSERT INTO VENDA(
	ID_CLIENTE)
	VALUES (
		'$id_cliente'
	)
QUERY;

mysqli_query($con, $query) or die ('ERRO: '.mysql_error());
  
$queryVenda = "SELECT V.ID FROM VENDA V ORDER BY 1 DESC LIMIT 1";
$resultVenda = $con->query($queryVenda);

$id_venda = null;

while($vendas = $resultVenda->fetch_array(MYSQLI_ASSOC)){
	$id_venda = $vendas['ID'];
}

?>