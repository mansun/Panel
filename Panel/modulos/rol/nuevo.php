<?php
include '../../header.php';
include '../../lib/conexion.php';
include '../../lib/autenticacion.php';

$sqlTipos = "SELECT * FROM tipo_rol";

$resultadoTipos = mysqli_query($con,$sqlTipos);

if(isset($_POST['guardar'])) {	
	$rolNomGuardado = $_POST['rolNom'];
	$tipoRolIDGuardado = $_POST['tipoRolID'];
	
	$sqlInsert = "INSERT INTO rol (rolNom, tipoRolID) VALUES ('$rolNomGuardado', '$tipoRolIDGuardado')";
	
	mysqli_query($con,$sqlInsert) or
	die('Error: '. mysqli_error($con));		

	/******* log del sistema ***/
	$accion = 'Crear rol';
	$observaciones = 'No hay observaciones';
	$fechaActual = date('Y-m-d H:i:s');
	$sqlLog = "INSERT INTO log (logDatEve, UsuId, logAction, logObserv) VALUES ('$fechaActual', $usuarioID, '$accion','$observaciones')";
	mysqli_query($con,$sqlLog) or die('Error en el log: '. mysqli_error($con));
	/****************************/
	
	header('location: consulta.php');
}

?>
<section class='contenido'>
    <div class='container'>
      <div class='page-header'>
        <h3>Nuevo rol</h3>
      </div>
      <form class="form-inline" method="post">
  <div class="form-group">
    <label for="rolNom">Nombre</label>
    <input type="text" class="form-control" name="rolNom" id="rolNom" value="">
  </div>
  <div class="form-group">
    <label for="tipoRolID">Tipo de Rol</label>
   <?php
   echo "<select class='form-control' name='tipoRolID' id='tipoRolID'>";
   
   while($fila = mysqli_fetch_array($resultadoTipos)){
   	$tipoRol_tipoRolID = $fila['tipoRolID'];
   	$tipoRol_tipoRolNom = $fila['tipoRolNom'];
   	
   	echo "<option value='$tipoRol_tipoRolID'>$tipoRol_tipoRolNom</option>";
   }
   
   echo "</select>";
    				
   ?>
      
  </div>
  <button type="submit" name="guardar" value="guardar" class="btn btn-default">Guardar</button>
  </form>

     </div>
</section>

<?php
include '../../footer.php';
?>