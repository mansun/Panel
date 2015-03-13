<?php
include '../../header.php';

if(!$isAdmin && !$isEscritor){
	header('Location: ../../index.php');
}

if(isset($_POST['guardar'])) {	
	

	
	/******************/
	$uniqueId = GUID();
	$target_dir = "img/";
	$target_file = $target_dir . basename($uniqueId.'-'.$_FILES["artImx"]["name"]);
	$uploadOk = 1;
	$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
	// Check if image file is a actual image or fake image
		$check = getimagesize($_FILES["artImx"]["tmp_name"]);
		if($check !== false) {
			echo "File is an image - " . $check["mime"] . ".";
			$uploadOk = 1;
		} else {
			echo "File is not an image.";
			$uploadOk = 0;
		}
	// Check if file already exists
	if (file_exists($target_file)) {
		echo "Sorry, file already exists.";
		$uploadOk = 0;
	}
	// Check file size
	if ($_FILES["artImx"]["size"] > 500000) {
		echo "Sorry, your file is too large.";
		$uploadOk = 0;
	}
	// Allow certain file formats
	if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
			&& $imageFileType != "gif" ) {
				echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
				$uploadOk = 0;
			}
			// Check if $uploadOk is set to 0 by an error
			if ($uploadOk == 0) {
				echo "Sorry, your file was not uploaded.";
				// if everything is ok, try to upload file
			} else {
				if (move_uploaded_file($_FILES["artImx"]["tmp_name"], $target_file)) {
					echo "The file ". basename( $_FILES["artImx"]["name"]). " has been uploaded.";
				} else {
					echo "Sorry, there was an error uploading your file.";
				}
			}
	/******************/
	
	$artDatCreGuardado = $_POST['artDatCre'];
	$artTitGuardado = $_POST['artTit'];
	$artTxtGuardado = $_POST['artTxt'];
	$artImxGuardado = $target_file; //$_POST['artImx'];
	$artLayoutGuardado = $_POST['artLayout'];
	$artClasGuardado = $_POST['artClas'];
	
	$sqlUpdate = "INSERT INTO articulo (artDatCre, artTit, artTxt, artImx, artLayout, artClas, usuID) VALUES ('$artDatCreGuardado', '$artTitGuardado', '$artTxtGuardado', '$artImxGuardado', '$artLayoutGuardado', '$artClasGuardado', $usuarioID)";
	
	mysqli_query($con,$sqlUpdate) or
	die('Error: '. mysqli_error($con));	
	
	/******* log del sistema ***/
	$accion = 'Crear Artículo';
	$observaciones = 'Creó el artículo: '.$artTitGuardado .' por usuario: '. $_SESSION["usuNom"];
	$fechaActual = date('Y-m-d H:i:s');
	$sqlLog = "INSERT INTO log (logDatEve, UsuId, logAction, logObserv) VALUES ('$fechaActual', $usuarioID, '$accion','$observaciones')";
	mysqli_query($con,$sqlLog) or die('Error en el log: '. mysqli_error($con));
	/****************************/

	//header('location: ../../index.php');
}

?>
<section class='contenido'>
    <div class='container'>
      <div class='page-header'>
        <h3>Nuevo artículo</h3>
      </div>
      <form method="post" enctype="multipart/form-data">
  <div class="form-group col-xs-2">
    <label for="artDatCre">Fecha</label>
    <input type="date" class="form-control" name="artDatCre" id="artDatCre" value="">
  </div>
  <div class="clearfix"></div>
  <div class="form-group">
    <label for="artTit">Título</label>
    <input type="text" class="form-control" name="artTit" id="artTit" value="">
  </div>
  <div class="form-group">
    <label for="artTxt">Texto</label>
    <textarea class="form-control" rows="5" name="artTxt" id="artTxt"></textarea>
  </div>
  <div class="form-group">
    <label for="exampleInputFile">Imagen</label>
    <input type="file" id="artImx" name="artImx" accept="image/*">
    <!-- <input type="text" name="artImxText" value=""/> -->
    <p class="help-block">Formatos admitidos: JPG y PNG. Tamaño máximo de archivo: 2MB</p>
  </div>
  <div class="form-group">
    <label for="artLayout">Layaout</label>
      <select class="form-control" name="artLayout" id="artLayout">
        <option value="1">Sin Imagen</option>
        <option value="2">Imagen a la izquierda</option>
        <option value="3">Imagen a la derecha</option>
      </select>
  </div>
  <div class="form-group">
    <label for="artClas">Clasificado</label>
      <select class="form-control" name="artClas" id="artClas">
        <option value="0">Público</option>
        <option value="1">Registrado</option>
        <option value="2">Lector</option>
      </select>    
  </div>
  <button type="submit" name="guardar" value="guardar" class="btn btn-default btn-sm"><span class='glyphicon glyphicon-floppy-disk'></span> Guardar</button>
  <a href="../../index.php" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-triangle-left"></span> Volver</a>
  </form>

     </div>
</section>
<?php
include '../../footer.php';
?>

