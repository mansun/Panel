<?php
$textoBusqueda = '';
if (isset($_GET['textoBusqueda'])){
	$textoBusqueda = $_GET['textoBusqueda'];
};


$isVistaAmpliada = false;
if (isset($_GET['ampliada'])){
	$isVistaAmpliada = $_GET['ampliada'] == "true";
};

$sql = "SELECT artID, artDatCre, artTit, artTxt, artImx, artLayout, artClas, usuNom FROM articulo inner join usuario on articulo.usuID = usuario.usuID WHERE (artTxt like '%$textoBusqueda%' OR  artTit like '%$textoBusqueda%')";
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
		<a href='index.php' class='btn btn-default btn-sm pull-right'><span class='glyphicon glyphicon-zoom-out'></span> Vista Normal</a>";
	
}
if ($isAdmin || $isEscritor){
	echo "	 <a href='modulos/articulo/nuevo.php' class='btn btn-default btn-sm'><span class='glyphicon glyphicon-file'></span> Nuevo</a>";
	
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
			<th class='col-md-9'>Artículo</th>
			<th class='col-md-1'></th>
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
		echo "<a href='modulos/articulo/edicion.php?id=$artID' class='btn btn-default btn-xs'><span class='glyphicon glyphicon-edit'></span> Editar</a>";
	
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
			<th class='col-md-10'>Artículo</th>
			<th class='col-md-1'></th>
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
	
		$claseImagen = '';
		switch ($artLayout) {
			case 2:
				//$imagen = "<div class='media'><img src='$artImx' class='pull-left' /><div>";
				$claseImagen = 'pull-left';
				break;
			;
			case 3:
				//$imagen = "<div class='media'><img src='$artImx' class='pull-right crop' /><div>";
				$claseImagen = 'pull-right';
				break;
			;
			break;
			
			case 1:
			default:
				$claseImagen = 'hidden';
				;
			break;
		}
		
		if(strlen($fila['artTxt']) > 500){
			$artTxt = substr($fila['artTxt'], 0,500)." (...)";
		}
	
	
		$plantillaMedia =
		 "	<div class='media'>
        <a class='$claseImagen'>
            <img src='modulos/articulo/$artImx' class='media-object' style='height: 140px' />
        </a>
        <div class='media-body'>
            <h4 class='media-heading'><a href='modulos/articulo/articulo.php?id=$artID' class='titulo'>$artTit</a></h4>$artTxt
            <p class='alias'>[$usuNom]</p>
        </div>
    </div>";
		

	
		/*
		 * $imagen
		
		
		<br /><span class='alias'>[$usuNom]</span>
		
		 */
		
		echo "<tr>
		<td>$fecha</td>
		<td class='noticia'>
		$plantillaMedia
		</td>
		<td class='edicion'>";
	
		if ($isAdmin || $isEscritor){
		echo "<a href='modulos/articulo/edicion.php?id=$artID' class='btn btn-default btn-xs'><span class='glyphicon glyphicon-edit'></span> Editar</a>";
	
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
