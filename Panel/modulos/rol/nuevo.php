<?php
include '../../header.php';
include '../../lib/validaciones.php';

if(!$isAdmin){
 header('Location: ../../index.php');
 } 

$sqlTipos = "SELECT * FROM tipo_rol";

$resultadoTipos = mysqli_query($con,$sqlTipos);

if(isset($_POST['guardar'])) {	
	
	//Validaciones
	$todoOk = true;
	
	$valRolNom = '';
	if (!isset($_POST['rolNom']) || !(validarNombre($_POST['rolNom']))){ //2.1 Coge la funcion del archivo validaciones.php
		//pasword no le gusta
		$valRolNom = 'Nombre de rol no valido. Prohibidos los numeros';
		showError($valRolNom);
		$todoOk = false;
	}
	
	if ($todoOk){
	
		$rolNomGuardado = mysql_real_escape_string($_POST['rolNom']);
		$tipoRolIDGuardado = $_POST['tipoRolID'];
		
		$sqlInsert = "INSERT INTO rol (rolNom, tipoRolID) VALUES ('$rolNomGuardado', '$tipoRolIDGuardado')";
		
		mysqli_query($con,$sqlInsert) or
		die('Error: '. mysqli_error($con));		
	
		/******* log del sistema ***/
		$accion = 'Crear rol';
		$observaciones = 'Creó el rol: '.$rolNomGuardado .' el administrador: '. $_SESSION["usuNom"];
		$fechaActual = date('Y-m-d H:i:s');
		$sqlLog = "INSERT INTO log (logDatEve, UsuId, logAction, logObserv) VALUES ('$fechaActual', $usuarioID, '$accion','$observaciones')";
		mysqli_query($con,$sqlLog) or die('Error en el log: '. mysqli_error($con));
		/****************************/
		

		//Obtenemos Id de ROL recien creado
		$id = $con->insert_id;
		//---------------------------------------
		header("location: edicion.php?id=$id&nuevo=true");
	}
}

?>
<section class='contenido'>
    <div class='container'>
      <div class='page-header'>
        <h3>Nuevo rol</h3>
      </div>
      <form class="form" method="post">
  <div class="form-group">
    <label for="rolNom">Nombre</label>
    <input type="text" class="form-control" maxlength="50" name="rolNom" id="rolNom" value="">
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