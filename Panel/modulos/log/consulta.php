<?php
include '../../header.php';

if(!$isAdmin){
 header('Location: ../../index.php');
 };

//setlocale(LC_TIME,"es_ES");
 
$sql = "SELECT logID, logDatEve, UsuID, logAction, logObserv FROM log ORDER BY logDatEve DESC";


$resultado = mysqli_query($con,$sql) or
die('Error consulta de log: '. mysqli_error($con));

echo "<section class='contenido'>
    <div class='container'>
      <div class='page-header'>
        <h3>Log</h3>
      </div>
<table class='table'>
	<thead>
		<tr>
			<th class='col-md-2'>Fecha Evento</th>
			<th class='col-md-2'>Usuario</th>
			<th class='col-md-3'>Acción</th>
			<th class='col-md-5'>Observaciones</th>
		</tr>
	</thead>
	<tbody>";
while($fila = mysqli_fetch_array($resultado)){
	$logID = $fila['logID'];
	$logDatEve = $fila['logDatEve'];
	
	$fecha = date("d-m-Y h:m:s", strtotime($logDatEve));
	
	$UsuID = $fila['UsuID'];
	$logAction = $fila['logAction'];
	$logObserv = $fila['logObserv'];
	echo "<tr>
			<td>$fecha</td>
			<td>$UsuID</td>
			<td>$logAction</td>
			<td>$logObserv</td>
		</tr>";
}
echo "			</tbody>
		</table>
		</div>
    </section>";

mysqli_close($con);

include '../../footer.php';
?>