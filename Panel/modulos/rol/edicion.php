<?php
include '../../header.php';
include '../../lib/validaciones.php';

if(!$isAdmin){
 header('Location: ../../index.php');
 } 


 if (isset($_GET['nuevo']) && ($_GET['nuevo'] == "true")){
 	showSuccess("Rol creado con éxito");
 }
 
$id =$_GET['id'];

$sql = "SELECT * FROM rol WHERE rolID  = '$id'";

$sqlTipos = "SELECT * FROM tipo_rol";

$resultado = mysqli_query($con,$sql);

$resultadoTipos = mysqli_query($con,$sqlTipos);

$fila = mysqli_fetch_assoc($resultado);

if(!$resultado) {
		die("Error: no encontrado");
}
	$rolNom = $fila['rolNom'];
	$tipoRolID = $fila['tipoRolID'];

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
		
		$sqlUpdate = "UPDATE rol SET rolNom = '$rolNomGuardado', tipoRolID = '$tipoRolIDGuardado' WHERE rolID = '$id'";
		
		mysqli_query($con,$sqlUpdate) or
		die('Error: '. mysqli_error($con));	
	
		/******* log del sistema ***/
		$accion = 'Editar rol';
		$observaciones = 'Rol editado: '. $rolNom .' por el administrador: ' . $_SESSION["usuNom"];
		$fechaActual = date('Y-m-d H:i:s');
		$sqlLog = "INSERT INTO log (logDatEve, UsuId, logAction, logObserv) VALUES ('$fechaActual', $usuarioID, '$accion','$observaciones')";
		mysqli_query($con,$sqlLog) or die('Error en el log: '. mysqli_error($con));
		/****************************/
		
		showSuccess("Se ha editado con éxito");
		
		//Recargamos el rol
		$sql = "SELECT * FROM rol WHERE rolID  = '$id'";		
		$resultado = mysqli_query($con,$sql);		
		$fila = mysqli_fetch_assoc($resultado);
		
		$rolNom = $fila['rolNom'];
		$tipoRolID = $fila['tipoRolID'];
	}
}

?>
<section class='contenido'>
    <div class='container'>
      <div class='page-header'>
        <h3>Editar rol</h3>
      </div>
      <form class="form" method="post">
  <div class="form-group">
    <label for="rolNom">Nombre</label>
    <input type="text" class="form-control" name="rolNom" id="rolNom" value="<?php echo $rolNom ?>">
  </div>
  <div class="form-group">
    <label for="tipoRolID">Tipo de Rol</label>
   <?php
   echo "<select class='form-control' name='tipoRolID' id='tipoRolID'>";
   
   while($fila = mysqli_fetch_array($resultadoTipos)){
   	$tipoRol_tipoRolID = $fila['tipoRolID'];
   	$tipoRol_tipoRolNom = $fila['tipoRolNom'];
   	$IsSelected = $tipoRol_tipoRolID == $tipoRolID ? "selected":"";
   	
   	echo "<option value='$tipoRol_tipoRolID' $IsSelected>$tipoRol_tipoRolNom</option>";
   }
   
   echo "</select>";
    				
   ?>
      
  </div>
  <button type="submit" name="guardar" value="guardar" class="btn btn-default btn-sm"><span class='glyphicon glyphicon-floppy-disk'></span> Guardar</button>
  <a href="consulta.php" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-triangle-left"></span> Volver</a>
  </form>

     </div>
</section>
<?php
include '../../footer.php';
?>

