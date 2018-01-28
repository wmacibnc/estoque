<?php 

$query = <<<QUERY
INSERT INTO ITEM_VENDA(
	ID_VENDA,
	QUANTIDADE,
	PRECO,
	ID_PRODUTO)
	VALUES (
		'$id_venda',
		'$quantidade',
		'$preco',
		'$id_produto'
	)
QUERY;

mysqli_query($con, $query) or die ('ERRO: '.mysql_error());

?>