<?php

include '../../lib/conexion.php';

$sql = "SELECT usuID, usuNom, usuAlias, usuSit FROM usuario";
$td = "";

$resultado = mysqli_query($con,$sql) or
die('Error seleccionar roles : '. mysqli_error($con));

echo "<h3>Usuarios</h3>
<a href='nuevo.php'>Nuevo</a>
<table>
	<thead>
		<tr>
			<th>ID</th>
			<th>Nombre</th>
			<th>Alias</th>
			<th>Situación</th>
			<th>Botones</th>
		</tr>
	</thead>
	<tbody>";
while($fila = mysqli_fetch_array($resultado)){
	$usuID = $fila['usuID'];
	$usuNom = $fila['usuNom'];
	$usuAlias = $fila['usuAlias'];
	$usuSit = $fila['usuSit'];
	echo "<tr>
			<td>$usuID</td>
			<td>$usuNom</td>
			<td>$usuAlias</td>
			<td>$usuSit</td>
			<td><a href='edicion.php?id=$usuID'><a href=''>Borrar</a></td>
		</tr>";
}
echo "</tbody>";
echo "</table>";

mysqli_close($con);


?>