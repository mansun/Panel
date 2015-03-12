<?php 
include 'lib/utils.php';
include 'lib/conexion.php';
include 'lib/autenticacion.php';
setlocale(LC_ALL,"es_ES");

$textoBusqueda = '';
if (isset($_GET['textoBusqueda'])){
	$textoBusqueda = $_GET['textoBusqueda'];
};
?>
<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Proyecto de Desarrollo Web Entorno Servidor">
    <meta name="author" content="Enrique Prado Vilares">
    <link rel="icon" href="../../favicon.ico">

    <title>Proyecto PHP</title>

    <!-- Bootstrap core CSS -->
    <link href="/panel/css/bootstrap.min.css" rel="stylesheet">
    <link href="/panel/css/font-awesome.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="/panel/css/panel-template.css" rel="stylesheet">
    <link href="/panel/css/font-awesome.css" rel="stylesheet">

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
          <a class="navbar-brand" href="/panel/index.php">Panel DAWB</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="navbar-form navbar-right">
            <?php
            if ($isAdmin) {
            	echo '<li class="login"><a href="/panel/modulos/usuario/nuevo.php" class="btn btn-default btn-sm" role="button">Registro</a></li>';
            }
            
            if ($isAnonimo){
            	echo '<li class="login"><a href="/panel/login.php" class="btn btn-default btn-sm" role="button">Login</a></li>';
            } else{
            	echo '<li class="login"><a href="/panel/perfil.php" class="btn btn-default btn-sm" role="button">Perfil</a></li>';
            	echo '<li class="login"><a href="/panel/logout.php" class="btn btn-default btn-sm" role="button">Logout</a></li>';
            }
            ?>
            
          </ul>
          <form class="navbar-form navbar-right" action="/Panel/index.php" method="get">
            <input type="text" class="form-control" id="textoBusqueda" name="textoBusqueda" placeholder="Buscar..." value="<?php echo $textoBusqueda?>">
          </form>
          <?php
          if (!$isAnonimo) {
          	echo '
          <ul class="nav navbar-nav navbar-right">
            <li class="nombre-usuario">'.$_SESSION["usuNom"].'</li>
          </ul> ';
          }
          ?>
        </div>
      </div>
    </nav>
			
		<section id="menu-admin">
			<div class="container">
			  <div class="row">  
				<div class="col-md-3"><a href="/panel/index.php"><i class="fa fa-file-text-o"></i>Artículos</a></div>
				<?php
		            if ($isAdmin) {
		            	echo '<div class="col-md-3"><a href="/panel/modulos/usuario/consulta.php"><i class="fa fa-user"></i>Usuarios</a></div>
						<div class="col-md-3"><a href="/panel/modulos/rol/consulta.php"><i class="fa fa-lock"></i>Roles</a></div>
						<div class="col-md-3"><a href="/panel/modulos/log/consulta.php"><i class="fa fa-list-alt"></i>Logs</a></div>';
		            }
            	?>

			</div>
		  </div>
	  </section>
		 
		<section class="diamante">
		  <div class="container">
		  	<div class="row">
		  		<div class="foto col-md-1">
		  			<img width="100" height="100" class="redondel" src="/panel/img/quique.jpg">
		  		</div>
					<div class="bienvenida col-md-5">
						<h1>Fernando Wirtz</h1>
						<h4 class="bienvenida">Panel de artículos DAWB de Enrique Prado</h4>
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
    
