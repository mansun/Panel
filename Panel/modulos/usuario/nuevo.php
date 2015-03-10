<?php
include '../../header.php';

if(isset($_POST['guardar'])) {	
	$usuNomGuardado = $_POST['usuNom'];
	$usuAliasGuardado = $_POST['usuAlias'];
	$usuPwGuardado = $_POST['usuPw'];
	$usuSitGuardado = $_POST['usuSit'];
	
	$sqlInsert = "INSERT INTO usuario (usuNom, usuAlias, usuPw, usuSit) VALUES ('$usuNomGuardado', '$usuAliasGuardado', '$usuPwGuardado', '$usuSitGuardado')";
	
	mysqli_query($con,$sqlInsert) or
	die('Error: '. mysqli_error($con));
	
	header('location: consulta.php');
}

?>
<section class='contenido'>
    <div class='container'>
      <div class='page-header'>
        <h3>Nuevo usuario</h3>
      </div>
      <form method="post">
  <div class="form-group">
    <label for="usuNom">Nombre</label>
    <input type="text" class="form-control" name="usuNom" id="usuNom" value="">
  </div>
  <div class="form-group">
    <label for="usuAlias">Alias</label>
    <input type="text" class="form-control" name="usuAlias" id="usuAlias" value="">
  </div>
  <div class="form-group">
    <label for="usuPw">Contraseña</label>
    <input type="password" class="form-control" name="usuPw" id="usuPw" value="">
  </div>
  <div class="form-group">
    <label for="usuSit">Situación</label>
      <select class="form-control" name="usuSit" id="usuSit">
        <option value="0">Inactivo</option>
        <option value="1">Activo</option>
      </select>
  </div>
  <button type="submit" name="guardar" value="guardar" class="btn btn-default">Guardar</button>
  </form>

     </div>
</section>
<?php
include '../../footer.php';
?>

