<?php
include '../../header.php';

if(!$isAdmin && !$isEscritor){
	header('Location: ../../index.php');
};

if (isset($_GET['nuevo']) && ($_GET['nuevo'] == "true")){
	showSuccess("Articulo creado con éxito");
}

$id =$_GET['id'];

$sql = "SELECT * FROM articulo WHERE artID  = '$id'";

$resultado = mysqli_query($con,$sql);

$fila = mysqli_fetch_assoc($resultado);

if(!$resultado) {
		die("Error: no encontrado");
}
	$artDatCre = $fila['artDatCre'];
	$artTit = $fila['artTit'];
	$artTxt = $fila['artTxt'];
	$artImx = $fila['artImx'];
	$artLayout = $fila['artLayout'];
	$artClas = $fila['artClas'];

//Validación del usuario: sólo los lectores y los administradores pueden ver articulos clasificados (2)
if (($artClas == 2) && (!$isAdmin) && (!$isLector))
{
	//Este es un articulo clasificado y no eres ni admin ni lector, entonces..
	//No tienes permiso...
	header('Location: ../../index.php');
}	
	
if(isset($_POST['guardar'])) {	
	
	$todoOk = true;
	if (!isset($_POST['artDatCre']) || empty($_POST['artDatCre'])){
		showError('Formato de fecha no valido: dd-mm-aa');
		$todoOk = false;
	}
	if (!isset($_POST['artTit']) || empty($_POST['artTit'])){
		showError('No has introducido el nombre del artículo');
		$todoOk = false;
	}
	if (!isset($_POST['artTxt']) || empty($_POST['artTxt'])){
		showError('No has introducido el texto del artículo');
		$todoOk = false;
	}
	
	//Validaciones
	if ($todoOk){

		/******************/
		//Hay que diferencia cuando sube una nueva imagen (para sustiruir a la anterior)
		//y cuando no toca la imagen. Entonces:
		
		$subeNuevaImagen = false;
		if (isset($_FILES["artImx"]) && isset($_FILES["artImx"]["tmp_name"]) && !empty($_FILES["artImx"]["tmp_name"])){
			//Si ha subido una nueva imagen, hacemos lo mismo que en nuevo
		
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
						
					} else {
						echo "Sorry, there was an error uploading your file.";
					}
				}
				$subeNuevaImagen = true;
			}
			/******************/
		
		
		$artDatCreGuardado = mysql_real_escape_string($_POST['artDatCre']);
		$artTitGuardado = mysql_real_escape_string($_POST['artTit']);
		$artTxtGuardado = mysql_real_escape_string($_POST['artTxt']);
		$artLayoutGuardado = mysql_real_escape_string($_POST['artLayout']);
		$artClasGuardado = mysql_real_escape_string($_POST['artClas']);

		if ($subeNuevaImagen){
				$artImxGuardado = $target_file; 
			//Actualizamos tambien el campo "artImx"
				$sqlUpdate = "UPDATE articulo SET artDatCre ='$artDatCreGuardado', artTit = '$artTitGuardado', artTxt ='$artTxtGuardado',
				artImx = '$artImxGuardado', artLayout ='$artLayoutGuardado', artClas ='$artClasGuardado' WHERE artID = '$id'";
		}else{
			//No actualizamos tambien el campo "artImx"
			$sqlUpdate = "UPDATE articulo SET artDatCre ='$artDatCreGuardado', artTit = '$artTitGuardado', artTxt ='$artTxtGuardado',
			artLayout ='$artLayoutGuardado', artClas ='$artClasGuardado' WHERE artID = '$id'";
		}
		
		
		mysqli_query($con,$sqlUpdate) or
		die('Error: '. mysqli_error($con));	
		
		/******* log del sistema ***/
		
		$accion = 'Editar artículo';
		$observaciones = 'Artículo editado: '. $artTitGuardado .' por usuario: ' . $_SESSION["usuNom"];
		$fechaActual = date('Y-m-d H:i:s');
		
		if (isset($usuarioID)){
			$sqlLog = "INSERT INTO log (logDatEve, UsuId, logAction, logObserv) VALUES ('$fechaActual', $usuarioID, '$accion','$observaciones')";
		}else{
			$sqlLog = "INSERT INTO log (logDatEve, UsuId, logAction, logObserv) VALUES ('$fechaActual', NULL, '$accion','$observaciones')";
		}
		mysqli_query($con,$sqlLog) or die('Error en el log: '. mysqli_error($con));
		
		/****************************/

		showSuccess("Se ha editado con éxito");
		//Recargamos el articulo
		$sql = "SELECT * FROM articulo WHERE artID  = '$id'";		
		$resultado = mysqli_query($con,$sql);		
		$fila = mysqli_fetch_assoc($resultado);
		
		$artDatCre = $fila['artDatCre'];
		$artTit = $fila['artTit'];
		$artTxt = $fila['artTxt'];
		$artImx = $fila['artImx'];
		$artLayout = $fila['artLayout'];
		$artClas = $fila['artClas'];
		
		
		//header('location: ../../index.php');
	}
	//**********
}

?>
<section class='contenido'>
    <div class='container'>
      <div class='page-header'>
        <h3>Editar artículo</h3>
      </div>
      <form method="post" enctype="multipart/form-data">
  <div class="form-group col-xs-2">
    <label for="artDatCre">Fecha</label>
    <input type="date" class="form-control" name="artDatCre" id="artDatCre" value="<?php echo $artDatCre ?>">
  </div>
  <div class="clearfix"></div>
  <div class="form-group">
    <label for="artTit">Título</label>
    <input type="text" class="form-control" maxlength="200" name="artTit" id="artTit" value="<?php echo $artTit ?>">
  </div>
  <div class="form-group">
    <label for="artTxt">Texto</label>
    <textarea class="form-control" rows="5" name="artTxt" id="artTxt"><?php echo $artTxt ?></textarea>
  </div>
  <div class="form-group">
    <label for="artImx">Imagen</label>
    <input type="file" name="artImx" id="artImx" accept="image/*">
    <img type="text" class="imagen-edicion" name="artImxText" src="<?php echo $artImx ?>"/>
    <p class="help-block">Formatos admitidos: JPG y PNG. Tamaño máximo de archivo: 2MB</p>
  </div>
  <div class="form-group">
    <label for="artLayout">Layaout</label>
      <select class="form-control" name="artLayout" id="artLayout">
        <option value="1" <?php echo $artLayout == 1?"selected":"" ?>>Sin Imagen</option>
        <option value="2" <?php echo $artLayout == 2?"selected":"" ?>>Imagen a la izquierda</option>
        <option value="3" <?php echo $artLayout == 3?"selected":"" ?>>Imagen a la derecha</option>
      </select>
  </div>
  <div class="form-group">
    <label for="artClas">Clasificado</label>
      <select class="form-control" name="artClas" id="artClas">
        <option value="0" <?php echo $artClas == 0?"selected":"" ?>>Público</option>
        <option value="1" <?php echo $artClas == 1?"selected":"" ?>>Registrado</option>
        <option value="2" <?php echo $artClas == 2?"selected":"" ?>>Lector</option>
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
