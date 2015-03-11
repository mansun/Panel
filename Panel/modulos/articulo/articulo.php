<?php
include '../../header.php';

$id =$_GET['id'];

$sql = "SELECT artID, artDatCre, artTit, artTxt, artImx, artLayout, artClas, usuNom FROM articulo inner join usuario on articulo.usuID = usuario.usuID WHERE artID  = '$id'";

if($isAnonimo){
	$sql .= " AND artClas = 0"; //Solo puede ver tipo 0 - Publico
	echo 'Aquí no hay nada que ver';
}else{
	if (!$isLector && !$isAdmin){
		$sql .= " AND artClas in (0, 1)"; //No es lector ni admin, sólo es escritor => solo pued ever tipos 0 y 1
	}
}

$resultado = mysqli_query($con,$sql) or
die('Error consulta de artículos: '. mysqli_error($con));

/******* log del sistema ***/

$accion = 'Consultó 1 artículo';
$observaciones = 'No hay observaciones';
$fechaActual = date('Y-m-d H:i:s');

if (isset($usuarioID)){
	$sqlLog = "INSERT INTO log (logDatEve, UsuId, logAction, logObserv) VALUES ('$fechaActual', $usuarioID, '$accion','$observaciones')";	
}else{
	$sqlLog = "INSERT INTO log (logDatEve, UsuId, logAction, logObserv) VALUES ('$fechaActual', NULL, '$accion','$observaciones')";
}
mysqli_query($con,$sqlLog) or die('Error en el log: '. mysqli_error($con));

/****************************/

while($fila = mysqli_fetch_array($resultado)){
	$artID = $fila['artID'];
	$artDatCre = $fila['artDatCre'];
	$artTit = $fila['artTit'];
	$artTxt = $fila['artTxt'];
	$artImx = $fila['artImx'];
	$artLayout = $fila['artLayout'];
	$artClas = $fila['artClas'];
	$usuNom = $fila['usuNom'];
	
	echo "
		<section class='contenido'>
    		<div class='container'>
      			<div class='page-header'>
        			<h3 class='titulo-ampliado'>$artTit</h3>
     			</div>
     			<div class='detalles'>
     			Escrito por <span class='alias'>[$usuNom]</span> el $artDatCre
     			</div>
     			<div>$artTxt<div>

	";
	
	if ($isAdmin || $isEscritor){
		echo "<div class='botones-articulo-ampliado'>
				<a href='edicion.php?id=$artID' class='btn btn-default btn-sm'><span class='glyphicon glyphicon-edit'></span> Editar</a>
		<a href='../../index.php' class='btn btn-default btn-sm'><span class='glyphicon glyphicon-triangle-left'></span> Volver</a>
		</div>
		";
	
	}


}
echo "			
		</div>
    </section>";

mysqli_close($con);
include '../../footer.php';
?>

