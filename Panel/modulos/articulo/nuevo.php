<?php
include '../../header.php';
include '../../lib/conexion.php';
include '../../lib/autenticacion.php';

/* if(!$isAdmin && !$isEscritor){
	header('Location: ../../index.php');
} */

if(isset($_POST['guardar'])) {	
	$artDatCreGuardado = $_POST['artDatCre'];
	$artTitGuardado = $_POST['artTit'];
	$artTxtGuardado = $_POST['artTxt'];
	$artImxGuardado = $_POST['artImx'];
	$artLayoutGuardado = $_POST['artLayout'];
	$artClasGuardado = $_POST['artClas'];
	
	$sqlUpdate = "INSERT INTO articulo (artDatCre, artTit, artTxt, artImx, artLayout, artClas) VALUES ('$artDatCreGuardado', '$artTitGuardado', '$artTxtGuardado', '$artImxGuardado', '$artLayoutGuardado', '$artClasGuardado')";
	
	mysqli_query($con,$sqlUpdate) or
	die('Error: '. mysqli_error($con));			
}

?>
<section class='contenido'>
    <div class='container'>
      <div class='page-header'>
        <h3>Nuevo artículo</h3>
      </div>
      <form method="post">
  <div class="form-group">
    <label for="artDatCre">Fecha</label>
    <input type="text" class="form-control" name="artDatCre" id="artDatCre" value="">
  </div>
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
    <input type="file" id="exampleInputFile">
    //<input type="text" name="artImx" value=""/>
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
  <button type="submit" name="guardar" value="guardar" class="btn btn-default">Guardar</button>
  </form>

     </div>
</section>
<?php
include '../../footer.php';
?>

