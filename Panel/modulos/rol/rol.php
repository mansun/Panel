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
$accion = 'Consultar rol';
$observaciones = 'Consultó un rol: ' . $_SESSION["usuNom"];
$fechaActual = date('Y-m-d H:i:s');
$sqlLog = "INSERT INTO log (logDatEve, UsuId, logAction, logObserv) VALUES ('$fechaActual', $usuarioID, '$accion','$observaciones')";
mysqli_query($con,$sqlLog) or die('Error en el log: '. mysqli_error($con));
/****************************/
echo "<section class='contenido'>
    <div class='container'>
      <div class='page-header'>
        <h3>Roles</h3>
		 <a href='edicion.php?id=$id' class='btn btn-default btn-sm'><span class='glyphicon glyphicon-edit'></span> Editar</a>
      </div>
<table class='table'>
	<thead>
		<tr>
			<th class='col-md-6'>Nombre</th>
			<th class='col-md-5'>Tipo</th>
		</tr>
	</thead>
					<tbody>";
while($fila = mysqli_fetch_array($resultado)){
	$rolID = $fila['rolID'];
	$rolNom = $fila['rolNom'];
	$tipoRolNom = $fila['tipoRolNom'];
	echo "<tr>
			<td>$rolNom</a></td>
			<td>$tipoRolNom</td>
		</tr>";
}
echo "			</tbody>
		</table>
		<a href='consulta.php' class='btn btn-default btn-sm'><span class='glyphicon glyphicon-triangle-left'></span> Volver</a>
		</div>
    </section>";

mysqli_close($con);

include '../../footer.php';
?>
