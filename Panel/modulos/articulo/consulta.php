<?php

include 'lib/conexion.php';

$sql = "SELECT artID, artDatCre, artTit, artTxt, artImx, artLayout, artClas FROM articulo";
$td = "";

$resultado = mysqli_query($con,$sql) or
die('Error consulta de artículos: '. mysqli_error($con));

echo "
		<section class='articulos'>
    <div class='container'>
      <div class='page-header'>
        <h3>Listado de Artículos</h3>
		 <a href='nuevo.php' class='btn btn-default btn-sm'>Nuevo</a>
      </div>
		
		  

<table class='table'>
	<thead>
		<tr>
			<th class='col-md-1'>Fecha</th>
			<th class='col-md-9'>Artículo</th>
			<th class='col-md-2'></th>
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
	$usuNom = 'Enrique Prado Vilares'; // Esto hay que cambiarlo
	
	if($artLayout != 1){
		$iconClip = "<i class='fa fa-paperclip'></i>";
	}
	
	else{
		$iconClip = "";
	}
	
	echo "<tr>
			<td>$artDatCre</td>
			<td><h4>$artTit <span class='alias'>[$usuNom]</span>$iconClip</h4>$artTxt</td>
			<td><a href='modulos/articulo/edicion.php?id=$artID' class='btn btn-default btn-xs'><span class='glyphicon glyphicon-edit'></span> Editar</a>
			<a href='' class='btn btn-default btn-xs'><span class='glyphicon glyphicon-remove'></span> Eliminar</a></td>
		</tr>";
}
echo "</tbody>";
echo "</table>";

mysqli_close($con);


?>
