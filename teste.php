<?php 
if(!isset($_SESSION)){
	session_start();
}

if (empty($_SESSION['cart2'])) {
	$_SESSION['cart2'] = [];
}

array_push($_SESSION['cart2'], ["teste", 14]);


foreach ($_SESSION['cart2'] as $key => $value) :
	echo $value[0];
	echo $value[1];

endforeach;

session_destroy();

?>