<?php
$servidor = "localhost";
$login = "root";
$senha = "";
$base = "estoque";
$con = mysqli_connect($servidor,$login, $senha) or die("MySql Error!");
$GLOBALS['con'] = $con;
mysqli_select_db($con, $base) or die("Database Error!"); 
?>