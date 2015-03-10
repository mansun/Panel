<?php
include 'header.php';

$id = $usuarioID;

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
	
	header('location: index.php');
}

?>
<section class='contenido'>
    <div class='container'>
      <div class='page-header'>
        <h3>Editar perfil</h3>
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
   				  		<input type='checkbox' id='roles[]' name='roles[]' value='$rol_rolID'disabled $isChecked>$rol_rolNom
   				  	</label>
   				  </div>";
		}
		
		
   	
	?>
	

  
  <button type="submit" name="guardar" value="guardar" class="btn btn-default">Guardar</button>
  </form>

     </div>
</section>
<?php
include 'footer.php';
?>
