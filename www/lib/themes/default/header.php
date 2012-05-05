<?php 
	if(!defined("_access")) {
		die("Error: You don't have permission to access here..."); 
	}
	
?>
<!DOCTYPE html>
<html lang="<?php print get("webLang"); ?>">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<title><?php print $this->getTitle(); ?></title>
		
		<link href="<?php print path("vendors/css/frameworks/bootstrapnew/css/bootstrap.min.css", "zan"); ?>" rel="stylesheet">
		<!--<link href="<?php print $this->themePath; ?>/css/style.css" rel="stylesheet">-->
		<?php print $this->getCSS(); ?>
		<link href="<?php print path("vendors/css/frameworks/bootstrapnew/css/bootstrap-responsive.min.css", "zan"); ?>" rel="stylesheet">
		
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
		<script src="<?php print path("vendors/css/frameworks/bootstrapnew/js/bootstrap.min.js", "zan"); ?>"></script>
		<script>
			$(document).on('ready', function () {
				$('.dropdown-toggle').dropdown();
				$('.dropdown-menu').dropdown();
			});
		</script>

		 <style>
		      body {
		        padding-top: 60px; /* 60px to make the container go all the way to the bottom of the topbar */
		      }
		 </style>

	</head>

	<body>
		<div class="navbar navbar-fixed-top">
	      <div class="navbar-inner">
	        <div class="container">
	          <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
	            <span class="icon-bar"></span>
	            <span class="icon-bar"></span>
	            <span class="icon-bar"></span>
	          </a>
	          <a class="brand" href="#">Administrador Extraescolares</a>
	          <div class="nav-collapse">
	           <ul class="nav nav-pills">
				  <li class="active"><a href="#">Estadísticas</a></li>
				  <li class="dropdown" id="menu1">
				    <a class="dropdown-toggle" data-toggle="dropdown" href="#menu1">
				      Alumnos
				      <b class="caret"></b>
				    </a>
				    <ul class="dropdown-menu">
				      <li><a href="#">Buscar un alumno</a></li>
				      <li><a href="#">Listas de clubes</a></li>
				      <li><a href="#">Agregar un nuevo alumno</a></li>
				    </ul>
				  </li>
				  <li class="dropdown" id="menu2">
				    <a class="dropdown-toggle" data-toggle="dropdown" href="#menu2">
				      Promotores
				      <b class="caret"></b>
				    </a>
				    <ul class="dropdown-menu">
				      <li><a href="#">Ver promotores</a></li>
				      <li><a href="#">Agregar un nuevo promotor</a></li>
				      <li><a href="#">Configuración de liberación</a></li>
				    </ul>
				  </li>
				  <li class="dropdown" id="menu3">
				    <a class="dropdown-toggle" data-toggle="dropdown" href="#menu3">
				      Sitio web
				      <b class="caret"></b>
				    </a>
				    <ul class="dropdown-menu">
				      <li><a href="#">Administrar noticias</a></li>
				      <li><a href="#">Administrar avisos</a></li>
				      <li><a href="#">Administrar álbumes</a></li>
				      <li><a href="#">Administrar banners</a></li>
				    </ul>

				  </li>
				</ul>
				<div class="btn-group pull-right">
				  <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
				    Action
				    <span class="caret"></span>
				  </a>
				  <ul class="dropdown-menu">
				    <li><a href="#">Configuración de la cuenta</a></li>
				    <li><a href="#">Salir</a></li>
				  </ul>
				</div>
	          </div><!--/.nav-collapse -->
	        </div>
	      </div>
	    </div>
		
		<div class="container">
			<div class="row">
