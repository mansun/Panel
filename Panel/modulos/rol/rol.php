<?php
include '../../header.php';

$id =$_GET['id'];

if(!$isAdmin){
 header('Location: ../../index.php');
 }

$sql = "SELECT rolID, rolNom, tipoRolNom FROM rol INNER JOIN tipo_rol on rol.tipoRolID = tipo_rol.tipoRolID WHERE rolID  = '$id'";

$resultado = mysqli_query($con,$sql) or
die('Error consulta de roles : '. mysqli_error($con));

/******* log del sistema ***/
$accion = 'Consulta de rol';
$observaciones = 'No hay observaciones';
$fechaActual = date('Y-m-d H:i:s');
$sqlLog = "INSERT INTO log (logDatEve, UsuId, logAction, logObserv) VALUES ('$fechaActual', $usuarioID, '$accion','$observaciones')";
mysqli_query($con,$sqlLog) or die('Error en el log: '. mysqli_error($con));
/****************************/
echo "<section class='contenido'>
    <div class='container'>
      <div class='page-header'>
        <h3>Roles</h3>
		 <a href='edicion.php?id=$id' class='btn btn-default btn-sm'>Editar</a>
      </div>
<table class='table'>
	<thead>
		<tr>
			<th class='col-md-5'>Nombre</th>
			<th class='col-md-5'>Tipo</th>
			<th class='col-md-2'></th>
		</tr>
	</thead>
					<tbody>";
while($fila = mysqli_fetch_array($resultado)){
	$rolID = $fila['rolID'];
	$rolNom = $fila['rolNom'];
	$tipoRolNom = $fila['tipoRolNom'];
	echo "<tr>
			<td><a href='rol.php?id=$rolID'>$rolNom</a></td>
			<td>$tipoRolNom</td>
			<td><a href='edicion.php?id=$rolID' class='btn btn-default btn-xs'><span class='glyphicon glyphicon-edit'></span> Editar</a>
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
