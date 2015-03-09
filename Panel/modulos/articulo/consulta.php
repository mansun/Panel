<?php
include '../../header.php';
include '../../lib/conexion.php';
include '../../lib/autenticacion.php';


$sql = "SELECT artID, artDatCre, artTit, artTxt, artImx, artLayout, artClas FROM articulo";
if($isAnonimo){
	$sql .= " WHERE artClas = 0";
}

$resultado = mysqli_query($con,$sql) or
die('Error consulta de artículos: '. mysqli_error($con));

/******* log del sistema ***/
$accion = 'Consulta de listado de artículos';
$observaciones = 'No hay observaciones';
$fechaActual = date('Y-m-d');
$sqlLog = "INSERT INTO log (logDatEve, UsuId, logAction, logObserv) VALUES ('$fechaActual', $usuarioID, '$accion','$observaciones')";
mysqli_query($con,$sqlLog) or die('Error en el log: '. mysqli_error($con));
/****************************/

echo "
		<section class='contenido'>
    <div class='container'>
      <div class='page-header'>
        <h3>Listado de Artículos</h3>";

if ($isAdmin || $isEscritor){
	echo "	 <a href='nuevo.php' class='btn btn-default btn-sm'>Nuevo</a>";
	
}
echo "
      </div>
		
		  

<table class='table'>
	<thead>
		<tr>
			<th class='col-md-1'>Fecha</th>
			<th class='col-md-9'>Artículo</th>
			<th class='col-md-2'></th>
		</tr>
	</thead>
	<tbody>";
while($fila = mysqli_fetch_array($resultado)){
	$artID = $fila['artID'];
	$artDatCre = $fila['artDatCre'];
	$artTit = $fila['artTit'];
	$artTxt = $fila['artTxt'];
	$artImx = $fila['artImx'];
	$artLayout = $fila['artLayout'];
	$artClas = $fila['artClas'];
	$usuNom = 'Enrique Prado Vilares'; // Esto hay que cambiarlo
	
	if($artLayout != 1){
		$iconClip = "<i class='fa fa-paperclip'></i>";
	}
	
	else{
		$iconClip = "";
	}
	
	if(strlen($fila['artTxt']) > 250){
		$artTxt = substr($fila['artTxt'], 0,250)." (...)";
	}
	
	echo "<tr>
			<td>$artDatCre</td>
			<td><h4><a href='articulo.php?id=$artID'>$artTit </a><span class='alias'>[$usuNom]</span>$iconClip</h4>$artTxt</td>
			<td><a href='edicion.php?id=$artID' class='btn btn-default btn-xs'><span class='glyphicon glyphicon-edit'></span> Editar</a>
			<a href='' class='btn btn-default btn-xs'><span class='glyphicon glyphicon-remove'></span> Eliminar</a></td>
		</tr>";
}
echo "			</tbody>
			</table>
		</div>
    </section>";

mysqli_close($con);

include '../../footer.php';
?>
