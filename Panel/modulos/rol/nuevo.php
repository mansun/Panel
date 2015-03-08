<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Auditoria y Gestión de la Calidad">
    <link rel="icon" href="../../favicon.ico">

    <title>Proyecto PHP</title>

    <!-- Bootstrap core CSS -->
    <link href="../../css/bootstrap.min.css" rel="stylesheet">
    <link href="../../css/font-awesome.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="../../css/panel-template.css" rel="stylesheet">
    <link href="../../css/font-awesome.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>
    <nav class="navbar navbar-default navbar-static-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="../../index.php">Panel DAWB</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="navbar-form navbar-right">
            <li class="login"><a href="#" class="btn btn-default btn-sm" role="button">Registro</a></li>
            <li class="login"><a href="#" class="btn btn-default btn-sm" role="button">Login</a></li>
          </ul>
          <form class="navbar-form navbar-right">
            <input type="text" class="form-control" placeholder="Buscar...">
          </form>
          <ul class="nav navbar-nav navbar-right">
            <li><a href="#">Listado de Artículos</a></li>
            <li><a href="#">Contacto</a></li>
          </ul>
        </div>
      </div>
    </nav>
	  
	  <section id="menu-admin">
		  <div class="container">
			  <div class="row">
				<div class="col-md-3"><a href="modulos/articulo/consulta.php"><i class="fa fa-file-text-o"></i>Artículos</a></div>
				<div class="col-md-3"><a href="modulos/usuario/consulta.php"><i class="fa fa-user"></i>Usuarios</a></div>
				<div class="col-md-3"><a href="modulos/rol/consulta.php"><i class="fa fa-lock"></i>Roles</a></div>
				<div class="col-md-3"><a href="modulos/log/consulta.php"><i class="fa fa-list-alt"></i>Logs</a></div>
			</div>
		  </div>
	  </section>
		 
		<section class="diamante">
		  <div class="container">
		  <div class="row">
		  	<div class="foto col-md-1">
		  		<img width="100" height="100" class="redondel" src="img/quique.jpg">
		  	</div>
				<div class="bienvenida col-md-5">
				<h1>Fernando Wirtz</h1>
				<h4 class="bienvenida">Bienvenido al panel de artículos DAWB de Enrique Prado</h4>
				<ul class="list-inline">
				<li><i class="fa fa-facebook-official"></i></li>
				<li><i class="fa fa-linkedin-square"></i></li>
				<li><i class="fa fa-twitter-square"></i></li>
				<li><i class="fa fa-tumblr-square"></i></li>
				</ul>
				</div>
</div>
				


      </div>
    </section>
<?php
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
}

?>
<section class='edicion-articulos'>
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

<footer class="footer">
      <div class="container">
        <p class="text-muted">© Copyright Enrique Prado - 2015</p>
      </div>
   </footer>


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="../../js/bootstrap.min.js"></script>
  </body>
</html>

