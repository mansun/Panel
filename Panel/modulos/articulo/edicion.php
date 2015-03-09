<?php
include '../../header.php';
include '../../lib/conexion.php';
include '../../lib/autenticacion.php';

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

if(isset($_POST['guardar'])) {	
		
	$artDatCreGuardado = $_POST['artDatCre'];
	$artTitGuardado = $_POST['artTit'];
	$artTxtGuardado = $_POST['artTxt'];
	$artImxGuardado = $_POST['artImx'];
	$artLayoutGuardado = $_POST['artLayout'];
	$artClasGuardado = $_POST['artClas'];
	
	$sqlUpdate = "UPDATE articulo SET artDatCre ='$artDatCreGuardado', artTit = '$artTitGuardado', artTxt ='$artTxtGuardado',
		 artImx = '$artImxGuardado', artLayout ='$artLayoutGuardado', artClas ='$artClasGuardado' WHERE artID = '$id'";
	
	mysqli_query($con,$sqlUpdate) or
	die('Error: '. mysqli_error($con));			
}

?>
<section class='edicion-articulos'>
    <div class='container'>
      <div class='page-header'>
        <h3>Editar artículo</h3>
      </div>
      <form method="post">
  <div class="form-group">
    <label for="artDatCre">Fecha</label>
    <input type="text" class="form-control" name="artDatCre" id="artDatCre" value="<?php echo $artDatCre ?>">
  </div>
  <div class="form-group">
    <label for="artTit">Título</label>
    <input type="text" class="form-control" name="artTit" id="artTit" value="<?php echo $artTit ?>">
  </div>
  <div class="form-group">
    <label for="artTxt">Texto</label>
    <textarea class="form-control" rows="5" name="artTxt" id="artTxt"><?php echo $artTxt ?></textarea>
  </div>
  <div class="form-group">
    <label for="artImx">Imagen</label>
    <input type="file" name="artImx" id="artImx">
    <input type="text" name="artImx" value="<?php echo $artImx ?>"/>
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
  <button type="submit" name="guardar" value="guardar" class="btn btn-default">Guardar</button>
  </form>
     </div>
</section>
<?php
include '../../footer.php';
?>
