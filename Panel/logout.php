<?php
include 'lib/conexion.php';
include 'lib/autenticacion.php';

/******* log del sistema ***/
			
$accion = 'Logout';
$observaciones = 'Usuario deslogueado: ' . $_SESSION["usuNom"];
$fechaActual = date('Y-m-d H:i:s');
			
if (isset($usuarioID)){
	$sqlLog = "INSERT INTO log (logDatEve, UsuId, logAction, logObserv) VALUES ('$fechaActual', $usuarioID, '$accion','$observaciones')";
}else{
	$sqlLog = "INSERT INTO log (logDatEve, UsuId, logAction, logObserv) VALUES ('$fechaActual', NULL, '$accion','$observaciones')";
}
mysqli_query($con,$sqlLog) or die('Error en el log: '. mysqli_error($con));
			
/****************************/
			
session_destroy(); // destruyo la sesión
header("location:index.php"); // redirigimos al inicio
exit();
?>
