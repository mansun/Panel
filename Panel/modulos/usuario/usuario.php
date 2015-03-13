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
		<a href='edicion.php?id=$id' class='btn btn-default btn-sm'><span class='glyphicon glyphicon-edit'></span> Editar</a>";
		
echo "
      </div>
<table class='table'>
	<thead>
		<tr>
			<th class='col-md-4'>Nombre</th>
			<th class='col-md-3'>Alias</th>
			<th class='col-md-3'>Situación</th>
			<th class='col-md-2'>Roles</th>
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

	//Por cada usuario, consultamos sus roles
	$sqlRoles = "SELECT rol.* FROM usuario_rol inner join rol on usuario_rol.rolID = rol.rolID WHERE usuario_rol.usuID='$usuID'";
	$resultadoRolesDeUsuario = mysqli_query($con,$sqlRoles);
	
	$rolesAMostrar ="";
	while($fila = mysqli_fetch_array($resultadoRolesDeUsuario)){
		$rol_rolID = $fila['rolID'];
		$rol_rolNom = $fila['rolNom'];
		
		$rolesAMostrar .= $rol_rolNom."<br />";
	}
	//---------------------------------------
	
	echo "<tr>
			<td>$usuNom</td>
			<td>$usuAlias</td>
			<td>$usuSit</td>
	
			<td>$rolesAMostrar</td>
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