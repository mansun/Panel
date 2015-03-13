<?php
include '../../header.php';
include '../../lib/validaciones.php'; //1. Añadir este archivo a nuevo y edicion

if(!$isAdmin){
	header('Location: ../../index.php');
} 


if (isset($_GET['nuevo']) && ($_GET['nuevo'] == "true")){
		showSuccess("Usuario creado con éxito");
}


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
	
	//Validaciones
	$todoOk = true;
	
	$valUsuAlias = '';
	if (!isset($_POST['usuAlias']) || !(validarAlias($_POST['usuAlias']))){ //2.1 Coge la funcion del archivo validaciones.php
		//alias no le gusta
		$valUsuAlias = 'Alias no valido. Mínimo 3 caracteres y máximo 15';
		showError($valUsuAlias);
		$todoOk = false;
	}
	
		$valUsuPw = '';
		if (!isset($_POST['usuPw']) || !(validarContrasenha($_POST['usuPw']))){ //2.1 Coge la funcion del archivo validaciones.php
			//pasword no le gusta
			$valUsuPw = 'Password no valido. Mínimo 6 caracteres y máximo 10. Debe contener un caracter especial, un número y una letra';
		showError($valUsuPw);
			$todoOk = false;
		}
		//	**********
		
		//3. Si todo está ok, guardamos/actualziamos
		if ($todoOk){
					//Guardamos
			
			$usuNomGuardado = mysql_real_escape_string($_POST['usuNom']);
			$usuAliasGuardado = mysql_real_escape_string($_POST['usuAlias']);
			$usuPwGuardado = mysql_real_escape_string($_POST['usuPw']);
			$usuSitGuardado = mysql_real_escape_string($_POST['usuSit']);
			
			
			$sqlUpdate = "UPDATE usuario SET usuNom = '$usuNomGuardado', usuAlias ='$usuAliasGuardado', usuPw ='$usuPwGuardado', usuSit = '$usuSitGuardado' WHERE usuID = '$id'";
			
			/********************************************************/
			/* Opción de mensaje de error */
			if (!mysqli_query($con,$sqlUpdate)){
				echo '<div class="alert alert-error">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
		  <span aria-hidden="true">&times;</span>
		</button>
					Error guardando: '.mysqli_error($con).'</div>';
				die();
			}
			/********************************************************/
			
			//Guardamos los roles
			//1. Borramos las relaciones antiguas
			mysqli_query($con, "DELETE FROM usuario_rol WHERE usuID=$id") or
				die('Error: '. mysqli_error($con));
			
			//2. Insertamos las relaciones nuevas
			if(!empty($_POST['roles'])) {
				foreach($_POST['roles'] as $rolID) {
					mysqli_query($con, "INSERT INTO usuario_rol (usuID, rolID) VALUES ($id, $rolID)") or
						die('Error: '. mysqli_error($con));
				}
			}
				
			
			/******* log del sistema ***/
			
			$accion = 'Editar usuario';
			$observaciones = 'Editó el usuario: '. $usuNomGuardado .' el administrador: ' . $_SESSION["usuNom"];
			$fechaActual = date('Y-m-d H:i:s');
			
			if (isset($usuarioID)){
				$sqlLog = "INSERT INTO log (logDatEve, UsuId, logAction, logObserv) VALUES ('$fechaActual', $usuarioID, '$accion','$observaciones')";
			}else{
				$sqlLog = "INSERT INTO log (logDatEve, UsuId, logAction, logObserv) VALUES ('$fechaActual', NULL, '$accion','$observaciones')";
			}
			mysqli_query($con,$sqlLog) or die('Error en el log: '. mysqli_error($con));
			
			/****************************/
			showSuccess("Se ha editado con éxito");
			
			//Recargamos el usurio
			$sql = "SELECT * FROM usuario WHERE usuID  = '$id'";			
			$resultado = mysqli_query($con,$sql);			
			$fila = mysqli_fetch_assoc($resultado);
			
			$usuNom = $fila['usuNom'];
			$usuAlias = $fila['usuAlias'];
			$usuPw = $fila['usuPw'];
			$usuSit = $fila['usuSit'];
		}
	//HAsta aqui 
}

?>
<section class='contenido'>
    <div class='container'>
      <div class='page-header'>
        <h3>Editar usuario</h3>
      </div>
      <form method="post">
  <div class="form-group">
    <label for="usuNom">Nombre</label>
    <input type="text" class="form-control" maxlength="50" name="usuNom" id="usuNom" value="<?php echo $usuNom ?>">
  </div>
  <div class="form-group">
    <label for="usuAlias">Alias</label>
    <input type="text" class="form-control" maxlength="15" name="usuAlias" id="usuAlias" readonly value="<?php echo $usuAlias ?>">
  </div>
  <div class="form-group">
    <label for="usuPw">Contraseña</label>
    <input type="password" class="form-control" maxlength="10" name="usuPw" id="usuPw" value="<?php echo $usuPw ?>">
  </div>
  <div class="form-group">
    <label for="usuSit">Situación</label>
      <select class="form-control" name="usuSit" id="usuSit">
        <option value="0" <?php echo $usuSit == 0?"selected":"" ?>>Inactivo</option>
        <option value="1" <?php echo $usuSit == 1?"selected":"" ?>>Activo</option>
      </select>
  </div>
  

  <?php

  //Obtenemos todos los roles de la tabla "ROL"
  $sqlRoles = "SELECT * FROM rol";
	$resultadoRoles = mysqli_query($con,$sqlRoles);
  
  		$isChecked ="";
		while($fila = mysqli_fetch_array($resultadoRoles)){
   			$rol_rolID = $fila['rolID'];
   			$rol_rolNom = $fila['rolNom'];	
   			
   			//Para cada rol miramos si está relacionado con el usuario en la tabla/relacion "usuario_rol"
   			$sqlRelacionUsuarioRol = "SELECT * FROM usuario_rol WHERE rolID=$rol_rolID AND usuID=$id";
   			$resultadoRelacionUsuarioRol = mysqli_query($con,$sqlRelacionUsuarioRol);
   			
   			//Si la consulta anterior devuelve resultados, entonces el usuario está relacionado con el rol actual ($rol_rolID)  
   			if (mysqli_fetch_array($resultadoRelacionUsuarioRol)){
   				$isChecked = "checked='checked'";
   			}else{
   				$isChecked = "";
   			}
   			echo "<div class='checkbox'>
   				  	<label>
   				  		<input type='checkbox' id='roles[]' name='roles[]' value='$rol_rolID' $isChecked>$rol_rolNom
   				  	</label>
   				  </div>";
		}
		
		
   	
	?>
	

  
  <button type="submit" name="guardar" value="guardar" class="btn btn-default btn-sm"><span class='glyphicon glyphicon-floppy-disk'></span> Guardar</button>
  <a href='consulta.php' class='btn btn-default btn-sm'><span class='glyphicon glyphicon-triangle-left'></span> Volver</a>
  </form>

     </div>
</section>
<?php
include '../../footer.php';
?>
