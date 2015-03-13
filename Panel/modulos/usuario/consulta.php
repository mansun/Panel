<?php
include '../../header.php';

if(!$isAdmin){
 header('Location: ../../index.php');
 } 

$sql = "SELECT usuID, usuNom, usuAlias, usuSit FROM usuario";

$resultado = mysqli_query($con,$sql) or
die('Error consulta de usuarios: '. mysqli_error($con));

/******* log del sistema ***/

if (!$isAnonimo) {
	$accion = 'Consultar usuario';
	$observaciones = 'Consultó un usuario: ' . $_SESSION["usuNom"];
	$fechaActual = date('Y-m-d H:i:s');

	if (isset($usuarioID)){
		$sqlLog = "INSERT INTO log (logDatEve, UsuId, logAction, logObserv) VALUES ('$fechaActual', $usuarioID, '$accion','$observaciones')";
	}else{
		$sqlLog = "INSERT INTO log (logDatEve, UsuId, logAction, logObserv) VALUES ('$fechaActual', NULL, '$accion','$observaciones')";
	}
	mysqli_query($con,$sqlLog) or die('Error en el log: '. mysqli_error($con));
}

/****************************/

echo "<section class='contenido'>
    <div class='container'>
      <div class='page-header'>
        <h3>Listado de Usuarios</h3>";
		
if ($isAdmin || $isEscritor){
	echo "	 <a href='nuevo.php' class='btn btn-default btn-sm'><span class='glyphicon glyphicon-file'></span> Nuevo</a>";

}
echo "
      </div>
<table class='table'>
	<thead>
		<tr>
			<th class='col-md-5'>Nombre</th>
			<th class='col-md-3'>Alias</th>
			<th class='col-md-3'>Situación</th>
			<th class='col-md-1'></th>
		</tr>
	</thead>
	<tbody>";
while($fila = mysqli_fetch_array($resultado)){
	$usuID = $fila['usuID'];
	$usuNom = $fila['usuNom'];
	$usuAlias = $fila['usuAlias'];
	$usuSit = $fila['usuSit'];
	
	switch ($usuSit){
		case 0: $usuSit="Inactivo";
		break;
		
		case 1: $usuSit= "Activo";
		break;
	}

	
	echo "<tr>
			<td><a href='usuario.php?id=$usuID'>$usuNom</a></td>
			<td>$usuAlias</td>
			<td>$usuSit</td>
			<td><a href='edicion.php?id=$usuID' class='btn btn-default btn-xs'><span class='glyphicon glyphicon-edit'></span> Editar</a></td>
		</tr>";
}
echo "			</tbody>
			</table>
		<a href='../../index.php' class='btn btn-default btn-sm'><span class='glyphicon glyphicon-triangle-left'></span> Inicio</a>
		</div>
    </section>";

mysqli_close($con);

include '../../footer.php';
?>