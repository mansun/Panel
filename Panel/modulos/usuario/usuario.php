<?php
include '../../header.php';

$id =$_GET['id'];

$sql = "SELECT usuID, usuNom, usuAlias, usuSit FROM usuario WHERE usuID  = '$id'";

if(!$isAdmin){
 header('Location: ../../index.php');
 } 

$resultado = mysqli_query($con,$sql) or
die('Error consulta de usuarios: '. mysqli_error($con));

echo "<section class='contenido'>
    <div class='container'>
      <div class='page-header'>
        <h3>Consulta de Usuario</h3>
		<a href='edicion.php?id=$id' class='btn btn-default btn-xs'><span class='glyphicon glyphicon-edit'></span> Editar</a>";
		
echo "
      </div>
<table class='table'>
	<thead>
		<tr>
			<th class='col-md-4'>Nombre</th>
			<th class='col-md-3'>Alias</th>
			<th class='col-md-3'>Situación</th>
			<th class='col-md-2'></th>
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
			<td>$usuNom</td>
			<td>$usuAlias</td>
			<td>$usuSit</td>
			<td>Faltan los roles aquí</td>
		</tr>";
}
echo "			</tbody>
			</table>
		</div>
    </section>";

mysqli_close($con);

include '../../footer.php';
?>