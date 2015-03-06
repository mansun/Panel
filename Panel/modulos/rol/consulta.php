<?php

include '../../lib/conexion.php';

$sql = "SELECT rolID, rolNom, tipoRolNom FROM rol INNER JOIN tipo_rol on rol.tipoRolID = tipo_rol.tipoRolID";
$td = "";

$resultado = mysqli_query($con,$sql) or
die('Error consulta de roles : '. mysqli_error($con));

echo "<h3>Roles</h3>
<a href='nuevo.php'>Nuevo</a>
<table>
	<thead>
		<tr>
			<th>ID</th>
			<th>Nombre</th>
			<th>Tipo</th>
			<th>Botones</th>
		</tr>
	</thead>
					<tbody>";
while($fila = mysqli_fetch_array($resultado)){
	$rolID = $fila['rolID'];
	$rolNom = $fila['rolNom'];
	$tipoRolNom = $fila['tipoRolNom'];
	echo "<tr>
			<td>$rolID</td>
			<td>$rolNom</td>
			<td>$tipoRolNom</td>
			<td><a href='edicion.php?id=$rolID'>Editar</a><a href=''>Borrar</a></td>
		</tr>";
}
echo "			</tbody>";
echo "</table>";

mysqli_close($con);


?>

