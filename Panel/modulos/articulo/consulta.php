<?php

include '../../lib/conexion.php';

$sql = "SELECT artID, artDatCre, artTit, artTxt, artImx, artLayout, artClas FROM articulo";
$td = "";

$resultado = mysqli_query($con,$sql) or
die('Error seleccionar roles : '. mysqli_error($con));

echo "<h3>Artículos</h3>
<a href='nuevo.php'>Nuevo</a>
<table>
	<thead>
		<tr>
			<th>ID</th>
			<th>Fecha Creación</th>
			<th>Título</th>
			<th>Texto</th>
			<th>Imagen</th>
			<th>Layaout</th>
			<th>Clasificado</th>
			<th>Botones</th>
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
	echo "<tr>
			<td>$artID</td>
			<td>$artDatCre</td>
			<td>$artTit</td>
			<td>$artTxt</td>
			<td>$artImx</td>
			<td>$artLayout</td>
			<td>$artClas</td>
			<td><a href='edicion.php?id=$artID'>Editar</a><a href=''>Borrar</a></td>
		</tr>";
}
echo "</tbody>";
echo "</table>";

mysqli_close($con);


?>
