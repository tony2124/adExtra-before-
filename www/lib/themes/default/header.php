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
		
		<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>-->
		<script src="<?php print path("vendors/js/jquery-1.7.1.min.js","zan") ?>"></script>
		<script src="<?php print path("vendors/css/frameworks/bootstrapnew/js/bootstrap.min.js", "zan"); ?>"></script>
		 <style>
		      body {
		        padding-top: 60px; /* 60px to make the container go all the way to the bottom of the topbar */
		      }
		 </style>

		 <script>
		$(function(){
		 	  $("a[rel=popover]").popover();
			  $("a[rel=tooltip]").tooltip();
			  });

		 </script>

	</head>

	<body>
		<?php if(SESSION('user_admin')) { ?>
		<div class="navbar navbar-fixed-top">
	      <div class="navbar-inner">
	        <div class="container">
	          <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
	            <span class="icon-bar"></span>
	            <span class="icon-bar"></span>
	            <span class="icon-bar"></span>
	          </a>
	          <a class="brand" href="#">Extraescolares</a>
	          <div class="nav-collapse">
	           <ul class="nav nav-pills">
				  <li class="active"><a href="<?php print get('webURL') . _sh .'admin/estadisticas' ?>">Estadísticas</a></li>
				  <li class="dropdown" id="menu1">
				    <a class="dropdown-toggle" data-toggle="dropdown" href="#menu1">
				      Alumnos
				      <b class="caret"></b>
				    </a>
				    <ul class="dropdown-menu">
				      <!--<li><a href="#">Buscar un alumno</a></li>-->
				      <li><a href="<?php print get('webURL'). _sh .'admin/listaclub/'  ?>">Listas de alumnos</a></li>
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
				      Mantenimiento
				      <b class="caret"></b>
				    </a>
				    <ul class="dropdown-menu">
				      <li><a href="#">Respaldo de BD</a></li>
				      <li><a href="#">Actualizar datos</a></li>
				      <li><a href="#">Descarga de formatos</a></li>
				      <li><a href="#">Configuración de BD</a></li>
				    </ul>
				  </li>
				  <li class="dropdown" id="menu4">
				    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
				      Sitio web
				      <b class="caret"></b>
				    </a>
				    <ul class="dropdown-menu">
				      <li class><a href="<?php print get('webURL'). _sh .'admin/noticias/'  ?>">Administrar noticias</a></li>
				      <li><a href="#">Administrar avisos</a></li>
				      <li><a href="#">Administrar álbumes</a></li>				      
				      <li><a href="#">Administrar banners</a></li>
				    </ul>
				  </li>
				</ul>
				<!-- INICIO DE SESION -->
				 <div class="btn-group pull-right">
		            <a class="btn dropdown-toggle btn-danger" data-toggle="dropdown" href="#">
		              <i class="icon-user"></i> <?php print strtoupper(SESSION('profesion_admin').' '.SESSION('name_admin').' '.SESSION('last1_admin')) ?>
		              <span class="caret"></span>
		            </a>
		            <ul class="dropdown-menu">
		              <li><a href="<?php print get('webURL'). _sh .'admin/adminconfig/' ?>"><b class="icon-wrench"></b> Configuración del administrador</a></li>
		              <li class="divider"></li>
		              <li><a href="<?php print get('webURL') .  _sh .'admin/logout' ?>">Salir de la sesión</a></li>
		            </ul>
		          </div>
	

	          </div><!--/.nav-collapse -->
	        </div>
	      </div>
	    </div>
		<?php } ?>
		<div class="container">
			<div class="row">
