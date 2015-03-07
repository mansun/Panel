<?php
?>
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
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/panel-template.css" rel="stylesheet">
    <link href="css/font-awesome.css" rel="stylesheet">

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
          <a class="navbar-brand" href="#">Panel DAWB</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="navbar-form navbar-right">
            <li class="login"><a href="#" class="btn btn-default btn-sm" role="button">Registrarse</a></li>
            <li class="login"><a href="#" class="btn btn-default btn-sm" role="button">Login</a></li>
          </ul>
          <form class="navbar-form navbar-right">
            <input type="text" class="form-control" placeholder="Buscar...">
          </form>
          <ul class="nav navbar-nav navbar-right">
            <li><a href="#">Listado de Cursos</a></li>
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
				<h1 class="medium">Fernando Wirtz</h1>
				<h4 class="normal">Bienvenido al panel de artículos del Panel DAWB</h4>
      </div>
    </section>
		
    <section class="articulos">
    <div class="container">
      <div class="page-header">
        <h3>Listado de Artículos</h3>
      </div>
      <?php
		 include 'modulos/articulo/consulta.php';
?> 
    </div>
    </section>
      
    <footer class="footer">
      <div class="container">
        <p class="text-muted">Copyright</p>
      </div>
    </footer>


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>
