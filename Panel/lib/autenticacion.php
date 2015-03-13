<?php
/**** verificacion de sesion ****/
session_start();
if (isset($_SESSION["usuID"])){
	/***** recargamos los datos del usuario conectado, 
	 * por si ha cambiado algo desde que inició sesión ***/
	$isValid = false;
	$id = $_SESSION["usuID"];
	
	$sqlSelect = "SELECT * FROM usuario WHERE usuID='$id'";
	$resultado = mysqli_query($con,$sqlSelect);
	$fila = mysqli_fetch_assoc($resultado);
	
	if ($resultado){
		//1. Usuario sigue existiendo. Lo recargamos por si algo ha cambiado
		//> Guardar en sesion sus datos: id, nombre y activo
		$_SESSION["usuID"] = $fila['usuID'];
		$_SESSION["usuNom"] = $fila['usuNom'];
		$_SESSION["isActivo"] = $fila['usuSit'] == 1;

		//2. Busqueda de roles
		$sqlSelect = "SELECT rol.tipoRolID FROM usuario_rol inner join rol on usuario_rol.rolID = rol.rolID WHERE usuID=".$fila['usuID'];
		$resultado = mysqli_query($con,$sqlSelect);
		$roles = array();
		while($fila = mysqli_fetch_array($resultado)){
			array_push($roles, $fila['tipoRolID']);
		}
		$_SESSION["isAdmin"] = in_array(1, $roles);
		$_SESSION["isLector"] =  in_array(2, $roles);
		$_SESSION["isEscritor"] =  in_array(3, $roles);
		
		$isValid = true;
	}
	
	if (!$isValid){
		//El usuario ya no es válido -lo borraron, quitaron permisos, o algo
		//-> Destruir sesión y enviar al inicio
		session_destroy(); // destruyo la sesión
		header("location:index.php"); // redirigimos al inicio
	}
	
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