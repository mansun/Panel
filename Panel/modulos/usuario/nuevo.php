<?php
include '../../header.php';
include '../../lib/validaciones.php'; //1. Añadir este archivo a nuevo y edicion 

if(!$isAdmin){
	header('Location: ../../index.php');
};


if(isset($_POST['guardar'])) {	

	//2.- Justo despues de la comprobacion "if(isset($_POST['guardar'])) {	"
	//empiezan las validaciones
	//Validaciones
	$todoOk = true;
	
	$valUsuNom = '';
	if (!isset($_POST['usuNom']) || !(validarNombre($_POST['usuNom']))){ //2.1 Coge la funcion del archivo validaciones.php
		//pasword no le gusta
		$valUsuNom = 'Nombre de usuario no valido';
		showError($valUsuNom);
		$todoOk = false;
	}
	
	$valUsuAlias = '';
	if (!isset($_POST['usuAlias']) || !(validarAlias($_POST['usuAlias']))){ //2.1 Coge la funcion del archivo validaciones.php
		//alias no le gusta
		$valUsuAlias = 'Alias no valido. Mínimo 3 caracteres y máximo 15';
		showError($valUsuAlias);
		$todoOk = false;
	}else 
	{
		$alias = $_POST['usuAlias'];
		//No se puede usar el mismo nombre de usuario
		$sql = "SELECT * FROM usuario WHERE usuAlias  = '$alias'";		
		$resultado = mysqli_query($con,$sql);		
		$fila = mysqli_fetch_assoc($resultado);
		if ($fila){
			//Este usuario ya existe
			$valUsuAlias = 'Alias ya en uso';
			showError($valUsuAlias);
			$todoOk = false;
		}
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
		
		$sqlInsert = "INSERT INTO usuario (usuNom, usuAlias, usuPw, usuSit) VALUES ('$usuNomGuardado', '$usuAliasGuardado', '$usuPwGuardado', '$usuSitGuardado')";
		
		mysqli_query($con,$sqlInsert) or
		die('Error: '. mysqli_error($con));
		
		//Obtenemos Id de usuario recien creado
		$id = $con->insert_id;
		//---------------------------------------
		
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
		
		$accion = 'Crear usuario';
		$observaciones = 'Creó el usuario: '. $usuNomGuardado .' el administrador: ' . $_SESSION["usuNom"];
		$fechaActual = date('Y-m-d H:i:s');
		
		if (isset($usuarioID)){
			$sqlLog = "INSERT INTO log (logDatEve, UsuId, logAction, logObserv) VALUES ('$fechaActual', $usuarioID, '$accion','$observaciones')";
		}else{
			$sqlLog = "INSERT INTO log (logDatEve, UsuId, logAction, logObserv) VALUES ('$fechaActual', NULL, '$accion','$observaciones')";
		}
		mysqli_query($con,$sqlLog) or die('Error en el log: '. mysqli_error($con));
		
		/****************************/
		
		
		header("location: edicion.php?id=$id&nuevo=true");
	}
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
    <input type="text" class="form-control" maxlength="50" name="usuNom" id="usuNom" value="">
  </div>
  <div class="form-group">
    <label for="usuAlias">Alias</label>
    <input type="text" class="form-control" maxlength="15" name="usuAlias" id="usuAlias" value="">
  </div>
  <div class="form-group">
    <label for="usuPw">Contraseña</label>
    <input type="password" class="form-control" maxlength="10" name="usuPw" id="usuPw" value="">
  </div>
  <div class="form-group">
    <label for="usuSit">Situación</label>
      <select class="form-control" name="usuSit" id="usuSit">
        <option value="0">Inactivo</option>
        <option value="1">Activo</option>
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
   			echo "<div class='checkbox'>
   				  	<label>
   				  		<input type='checkbox' id='roles[]' name='roles[]' value='$rol_rolID' >$rol_rolNom </label>
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

