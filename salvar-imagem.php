<?php
include 'config.php';

if($_GET && (isset($_GET['id'])) ){
	$sql = 'DELETE FROM IMAGEM WHERE ID='.$_GET['id'];
	mysqli_query($con, $sql) or die ('ERRO: '.mysql_error());
	header("Location: imagem-produto.php?id=".$_GET['id_produto']."&mensagem=Dados excluidos! ");
	return;
}

$id_produto = $_POST['id'];

if(isset($_POST["enviar"])) {
	$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
	if($check !== false) {
		$data = base64_encode(file_get_contents( $_FILES["fileToUpload"]["tmp_name"] ));
		$base_64 = "data:".$check["mime"].";base64,".$data;
	} else {
		echo "Arquivo enviado não é uma imagem.";
	}
}

// Insere os dados no banco 
$query = <<<QUERY
INSERT INTO IMAGEM(
	ID_PRODUTO,
	BASE_64)
	VALUES (
		'$id_produto',
		'$base_64'
	)
QUERY;

mysqli_query($con, $query) or die ('ERRO: '.mysql_error());
header("Location: imagem-produto.php?id=".$id_produto."&mensagem=Dados Salvos! ");

?>
