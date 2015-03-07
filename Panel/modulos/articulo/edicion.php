<?php
include '../../lib/conexion.php';
$id =$_REQUEST['id'];

$sql = "SELECT * FROM articulo WHERE artID  = '$id'";
$td = "";

$resultado = mysqli_query($con,$sql);

$fila = mysqli_fetch_assoc($resultado);

if(!$resultado) 
		{
		die("Error: no encontrado");
		}
	$artDatCre = $fila['artDatCre'];
	$artTit = $fila['artTit'];
	$artTxt = $fila['artTxt'];
	$artImx = $fila['artImx'];
	$artLayout = $fila['artLayout'];
	$artClas = $fila['artClas'];

if(isset($_POST['guardar']))
{	
	$artDatCreGuardado = $_POST['artDatCre'];
	$artTitGuardado = $_POST['artTit'];
	$artTxtGuardado = $_POST['artTxt'];
	$artImxGuardado = $_POST['artImx'];
	$artLayoutGuardado = $_POST['artLayout'];
	$artClasGuardado = $_POST['artClas'];

	mysqli_query("UPDATE articulo SET artDatCre ='$artDatCreGuardado', artTit = '$artTitGuardado', artTxt ='$artTxtGuardado',
		 artImx = '$artImxGuardado', artLayout ='$artLayoutGuardado', artClas ='$artClasGuardado' WHERE id = '$id'")
				or die(mysqli_error()); 
			
}

?>
<!DOCTYPE html>
<html>
<head>
<title>Editar datos</title>
</head>

<body>
<form method="post">
<table>
	<tr>
		<td>Nombre:</td>
		<td><input type="text" name="artDatCre" value="<?php echo $artDatCre ?>"/></td>
	</tr>
	<tr>
		<td>Contraseña:</td>
		<td><input type="text" name="artTit" value="<?php echo $artTit ?>"/></td>
	</tr>
	<tr>
		<td>Email</td>
		<td><input type="text" name="artTxt" value="<?php echo $artTxt ?>"/></td>
	</tr>
	<tr>
		<td>Comentario</td>
		<td><input type="text" name="artImx" value="<?php echo $artImx ?>"/></td>
	</tr>
	<tr>
		<td>Estado</td>
		<td><input type="text" name="artLayout" value="<?php echo $artLayout ?>"/></td>
	</tr>
	<tr>
		<td>Estado</td>
		<td><input type="text" name="artClas" value="<?php echo $artClas ?>"/></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td><input type="submit" name="guardar" value="guardar" /></td>
	</tr>
</table>
</form>
</body>
</html>