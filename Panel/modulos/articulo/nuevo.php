<?php
include 'lib/conexion.php';
include 'lib/autenticacion.php';

if(!$isAdmin && !$isEscritor){
	header('Location: index.php');
}

?>
