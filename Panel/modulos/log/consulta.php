<?php

include '../../lib/conexion.php';

$sql = "SELECT logID, logDatEve, UsuID, logAction, logObserv FROM log";
$td = "";

$resultado = mysqli_query($con,$sql) or
die('Error consulta de log: '. mysqli_error($con));

echo "<h3>Roles</h3>
<h3>Log</h3>
<table>
	<thead>
		<tr>
			<th>ID</th>
			<th>Fecha Evento</th>
			<th>Usuario</th>
			<th>Acción</th>
			<th>Observaciones</th>
		</tr>
	</thead>
	<tbody>";
while($fila = mysqli_fetch_array($resultado)){
	$logID = $fila['logID'];
	$logDatEve = $fila['logDatEve'];
	$UsuID = $fila['UsuID'];
	$logAction = $fila['logAction'];
	$logObserv = $fila['logObserv'];
	echo "<tr>
			<td>$logID</td>
			<td>$logDatEve</td>
			<td>$UsuID</td>
			<td>$logAction</td>
			<td>$logObserv</td>
		</tr>";
}
echo "			</tbody>";
echo "</table>";

mysqli_close($con);


?>