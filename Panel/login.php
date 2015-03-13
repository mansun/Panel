<?php
include 'header.php';
include 'lib/validaciones.php';

if(isset($_POST['enviar'])) {
	
	$todoOk = true;
	if (!isset($_POST['usuAlias']) || empty($_POST['usuAlias']) ){
		showError('Alias / Password incorrectos');
		$todoOk = false;
	}
	
	if (!isset($_POST['usuPw']) || empty($_POST['usuPw']) ){
		showError('Alias / Password incorrectos');
		$todoOk = false;
	}

	if ($todoOk){
		$usuAlias = mysql_real_escape_string($_POST['usuAlias']);
		$usuPw = mysql_real_escape_string($_POST['usuPw']);
		
		$sqlSelect = "SELECT * FROM usuario WHERE usuAlias='$usuAlias'";
		$resultado = mysqli_query($con,$sqlSelect);
		$fila = mysqli_fetch_assoc($resultado);
		
		//Si la consulta anterior devuelve resultados, entonces el usuario está relacionado con el rol actual ($rol_rolID)
		if ($resultado){
			//if ($fila['usuPw'] == password_hash($usuPw, PASSWORD_DEFAULT)){
			if ($fila['usuPw'] == $usuPw){
				//1. Usuario autenticado
				//> Guardar en sesion sus datos: id, nombre y activo
				$_SESSION["usuID"] = $fila['usuID'];
				$_SESSION["usuNom"] = $fila['usuNom'];
				$_SESSION["isActivo"] = $fila['usuSit'] == 1;
				
				//2. Busqueda de roles
				$sqlSelect = "SELECT rol.tipoRolID FROM usuario_rol inner join rol on usuario_rol.rolID = rol.rolID WHERE usuID=".$fila['usuID'];
				$resultado = mysqli_query($con,$sqlSelect);
				$roles = array();
				while($fila = mysqli_fetch_array($resultado)){ 
					array_push($roles, $fila['tipoRolID']); 
				}
				$_SESSION["isAdmin"] = in_array(1, $roles);
				$_SESSION["isLector"] =  in_array(2, $roles); 
				$_SESSION["isEscritor"] =  in_array(3, $roles);
				
				/******* log del sistema ***/
				
				$accion = 'Login';
				$observaciones = 'Usuario logueado: ' . $_SESSION["usuNom"];
				$fechaActual = date('Y-m-d H:i:s');
				
				if (isset($usuarioID)){
					$sqlLog = "INSERT INTO log (logDatEve, UsuId, logAction, logObserv) VALUES ('$fechaActual', $usuarioID, '$accion','$observaciones')";
				}else{
					$sqlLog = "INSERT INTO log (logDatEve, UsuId, logAction, logObserv) VALUES ('$fechaActual', NULL, '$accion','$observaciones')";
				}
				mysqli_query($con,$sqlLog) or die('Error en el log: '. mysqli_error($con));
				
				/****************************/
	
				header('location: index.php'); 
				
				//echo "Buenos días, Mr ".$_SESSION["usuNom"];
				//exit();
				
			}
		}
		//Usuario no autenticado => mostrar mensaje
	}
}

if (!$isAnonimo){
	echo "Buenos días, Mr ".$_SESSION["usuNom"];
	exit();
}

?>
	<section class='contenido'>
    <div class='container'>
      <div class='page-header'>
        <h3>Login</h3>
      </div>
      <form class="formulario-login" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
  <div class="form-group">
    <label for="usuAlias">Alias</label>
    <input type="text" class="form-control" maxlength="15" name="usuAlias" id="usuAlias" value="">
  </div>
  <div class="form-group">
    <label for="usuPw">Contraseña</label>
    <input type="password" class="form-control" maxlength="10" name="usuPw" id="usuPw" value="">
  </div>
  <button type="submit" name="enviar" value="enviar" class="btn btn-default">Login</button>
  </form>
  

     </div>
     </section>
<?php
include 'footer.php';
?>