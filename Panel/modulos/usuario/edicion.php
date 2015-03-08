<?php
include '../../header.php';
include '../../lib/conexion.php';
include '../../lib/autenticacion.php';

$id =$_GET['id'];

$sql = "SELECT * FROM usuario WHERE usuID  = '$id'";

$resultado = mysqli_query($con,$sql);

$fila = mysqli_fetch_assoc($resultado);

if(!$resultado) {
		die("Error: no encontrado");
}
	$usuNom = $fila['usuNom'];
	$usuAlias = $fila['usuAlias'];
	$usuPw = $fila['usuPw'];
	$usuSit = $fila['usuSit'];

if(isset($_POST['guardar'])) {	
	$usuNomGuardado = $_POST['usuNom'];
	$usuAliasGuardado = $_POST['usuAlias'];
	$usuPwGuardado = $_POST['usuPw'];
	$usuSitGuardado = $_POST['usuSit'];
	
	$sqlUpdate = "UPDATE usuario SET usuNom = '$usuNomGuardado', usuAlias ='$usuAliasGuardado', usuPw ='$usuPwGuardado', usuSit = '$usuSitGuardado' WHERE usuID = '$id'";
	
	mysqli_query($con,$sqlUpdate) or
	die('Error: '. mysqli_error($con));			
}

?>
<section class='edicion-usuarios'>
    <div class='container'>
      <div class='page-header'>
        <h3>Editar usuario</h3>
      </div>
      <form method="post">
  <div class="form-group">
    <label for="usuNom">Nombre</label>
    <input type="text" class="form-control" name="usuNom" id="usuNom" value="<?php echo $usuNom ?>">
  </div>
  <div class="form-group">
    <label for="usuAlias">Alias</label>
    <input type="text" class="form-control" name="usuAlias" id="usuAlias" value="<?php echo $usuAlias ?>">
  </div>
  <div class="form-group">
    <label for="usuPw">Contraseña</label>
    <input type="password" class="form-control" name="usuPw" id="usuPw" value="<?php echo $usuPw ?>">
  </div>
  <div class="form-group">
    <label for="usuSit">Situación</label>
      <select class="form-control" name="usuSit" id="usuSit">
        <option value="0" <?php echo $usuSit == 0?"selected":"" ?>>Inactivo</option>
        <option value="1" <?php echo $usuSit == 1?"selected":"" ?>>Activo</option>
      </select>
  </div>
  <button type="submit" name="guardar" value="guardar" class="btn btn-default">Guardar</button>
  </form>

     </div>
</section>
<?php
include '../../footer.php';
?>
