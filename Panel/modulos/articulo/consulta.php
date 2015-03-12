<?php
$textoBusqueda = '';
if (isset($_GET['textoBusqueda'])){
	$textoBusqueda = $_GET['textoBusqueda'];
};


$isVistaAmpliada = false;
if (isset($_GET['ampliada'])){
	$isVistaAmpliada = $_GET['ampliada'] == "true";
};

$sql = "SELECT artID, artDatCre, artTit, artTxt, artImx, artLayout, artClas, usuNom FROM articulo inner join usuario on articulo.usuID = usuario.usuID WHERE artTxt like '%$textoBusqueda%'";
if($isAnonimo){
	$sql .= " AND artClas = 0"; //Solo puede ver tipo 0 - Publico
	
}else{
	if (!$isLector && !$isAdmin){
	$sql .= " AND artClas in (0, 1)"; //No es lector ni admin, sólo es escritor => solo pued ever tipos 0 y 1
	}
}

$sql .= " ORDER BY artDatCre DESC";

$resultado = mysqli_query($con,$sql) or
die('Error consulta de artículos: '. mysqli_error($con));

if (!$isVistaAmpliada){
echo "
		<section class='contenido'>
    <div class='container'>
      <div class='page-header'>
        <h3>Listado de Artículos</h3>
		<a href='index.php?ampliada=true' class='btn btn-default btn-sm pull-right'><span class='glyphicon glyphicon-zoom-in'></span> Vista Ampliada</a>";
		
}else{

	echo "
		<section class='contenido'>
    <div class='container'>
      <div class='page-header'>
        <h3>Listado de Artículos</h3>
		<a href='index.php' class='btn btn-default btn-sm pull-right'><span class='glyphicon glyphicon-zoom-in'></span> Vista Normal</a>";
	
}
if ($isAdmin || $isEscritor){
	echo "	 <a href='modulos/articulo/nuevo.php' class='btn btn-default btn-sm'>Nuevo</a>";
	
}
echo "
      </div>";


if (!$isVistaAmpliada){
	//No es Vista Ampliada

	echo "
<table class='table'>
	<thead>
		<tr>
			<th class='col-md-1'>Fecha</th>
			<th class='col-md-1 clip'><i class='fa fa-paperclip'></i></th>
			<th class='col-md-8'>Artículo</th>
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
		$usuNom = $fila['usuNom'];
	
		$fecha = date("d-m-Y", strtotime($artDatCre));
	
		if($artLayout != 1){
			$iconClip = "<i class='fa fa-paperclip'></i>";
		}
	
		else{
			$iconClip = "";
		}
	
		if(strlen($fila['artTxt']) > 150){
			$artTxt = substr($fila['artTxt'], 0,150)." (...)";
		}
	
	
	
		echo "<tr>
		<td>$fecha</td>
		<td class='clip'>$iconClip</td>
		<td class='noticia'><a href='modulos/articulo/articulo.php?id=$artID' class='titulo'>$artTit</a>$artTxt<br /><span class='alias'>[$usuNom]</span></td>
		<td class='edicion'>";
	
		if ($isAdmin || $isEscritor){
		echo "<a href='modulos/articulo/edicion.php?id=$artID' class='btn btn-default btn-xs'><span class='glyphicon glyphicon-edit'></span> Editar</a>
		<a href='' class='btn btn-default btn-xs'><span class='glyphicon glyphicon-remove'></span> Eliminar</a>";
	
		}
	
		echo "</td>
			</tr>";
	}


	echo "			</tbody>
			</table>
		</div>";
}
else{
	//Es Vista Ampliada
	/***************/

	echo "
<table class='table'>
	<thead>
		<tr>
			<th class='col-md-1'>Fecha</th>
			<th class='col-md-9'>Artículo</th>
			<th class='col-md-2'></th>
		</tr>
	</thead>
	<tbody>";
	/*
	 * 1-Sin Imagen
		2-Con Imagen izda.
		3-Con Imagen dcha
	 */
	while($fila = mysqli_fetch_array($resultado)){
		$artID = $fila['artID'];
		$artDatCre = $fila['artDatCre'];
		$artTit = $fila['artTit'];
		$artTxt = $fila['artTxt'];
		$artImx = $fila['artImx'];
		$artLayout = $fila['artLayout'];
		$artClas = $fila['artClas'];
		$usuNom = $fila['usuNom'];
	
		$fecha = date("d-m-Y", strtotime($artDatCre));
	
		$imagen = '';
		switch ($artLayout) {
			case 2:
				$imagen = "<img src='$artImx' class='pull-left thumb' />";
				break;
			;
			case 3:
				$imagen = "<img src='$artImx' class='pull-right thumb' />";
				break;
			;
			break;
			
			default:
				;
			break;
		}
		
		if(strlen($fila['artTxt']) > 500){
			$artTxt = substr($fila['artTxt'], 0,500)." (...)";
		}
	
	
	
		echo "<tr>
		<td>$fecha</td>
		<td class='noticia'>
		
		$imagen
		<a href='modulos/articulo/articulo.php?id=$artID' class='titulo'>$artTit</a>$artTxt<br /><span class='alias'>[$usuNom]</span>
		
		</td>
		<td class='edicion'>";
	
		if ($isAdmin || $isEscritor){
		echo "<a href='modulos/articulo/edicion.php?id=$artID' class='btn btn-default btn-xs'><span class='glyphicon glyphicon-edit'></span> Editar</a>
		<a href='' class='btn btn-default btn-xs'><span class='glyphicon glyphicon-remove'></span> Eliminar</a>";
	
		}
	
		echo "</td>
		</tr>";
	}
	
	
				echo "			</tbody>
			</table>
		</div>";
	/***************/
}



echo "
    </section>";

mysqli_close($con);

?>
