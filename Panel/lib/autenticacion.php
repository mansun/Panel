<?php
/**** verificacion de sesion ****/
session_start();
if (isset($_SESSION["usuID"])){
	/**** variables de control ****/
	$nombreUsuario = $_SESSION["usuNom"];
	$usuarioID = $_SESSION["usuID"];
	$isActivo = $_SESSION["isActivo"];

	//Roles
	$isAdmin = $isActivo && $_SESSION["isAdmin"];
	$isLector = $isActivo && $_SESSION["isLector"];
	$isEscritor = $isActivo && $_SESSION["isEscritor"];

	$isAnonimo = false;
}
else{
	$nombreUsuario = "Anonimo";
	$isActivo = false;
	$usuarioID = null;
	$isAnonimo = true;
	$isAdmin = false;
	$isLector = false;
	$isEscritor = false;
}

?>