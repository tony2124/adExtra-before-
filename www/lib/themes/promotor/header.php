<?php 
	if(!defined("_access")) {
		die("Error: You don't have permission to access here..."); 
	}
	
	if(isMobile()) {
		include "mobile/header.php";
	} else {
?>
<!DOCTYPE html>
<html lang="<?php print get("webLang"); ?>">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<title><?php print $this->getTitle(); ?></title>

		<link href="<?php print path("vendors/css/frameworks/bootstrapnew/css/bootstrap.min.css", "zan"); ?>" rel="stylesheet">
    <link href="<?php print path("vendors/css/frameworks/bootstrapnew/css/bootstrap-responsive.min.css", "zan"); ?>" rel="stylesheet">
    <link href="<?php print path("vendors/css/frameworks/smoothness/jquery-ui-1.8.21.custom.css", "zan"); ?>" rel="stylesheet">
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
    <script src="<?php print path("www/lib/scripts/ouwScript.js","www") ?>"></script>
    <script src="<?php print path("vendors/js/jquery-1.7.2.min.js","zan") ?>"></script>
    <script src="<?php print path("vendors/css/frameworks/bootstrapnew/js/bootstrap.min.js", "zan"); ?>"></script>
    <script src="<?php print path("vendors/js/jquery.validate.js","zan") ?>"></script>
    <script src="<?php print path("vendors/js/jquery-ui-1.8.21.custom.min.js","zan") ?>"></script>
		<style>
        body {
          padding-top: 60px; /* 60px to make the container go all the way to the bottom of the topbar */
        }
    </style>

		<!-- Le HTML5 shim, for IE6-8 support of HTML elements -->
			<!--[if lt IE 9]>
			  <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
			<![endif]-->
		<!-- Le styles -->
	</head>

	<body>
		
		<div class="navbar navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container-fluid">
        	<?php if(SESSION('usuario_promotor')) { ?>
          <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
          <a class="brand" href="#">Promotores Extraescolares</a>
          <div class="btn-group pull-right">
            <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
              <i class="icon-user"></i> <?php print SESSION('nombre_promotor').' '.SESSION('ap_promotor').' '.SESSION('am_promotor') ?>
              <span class="caret"></span>
            </a>
            <ul class="dropdown-menu">
              <li><a href="<?php print get('webURL')._sh.'promotor/salirSesion' ?>">Salir</a></li>
            </ul>
          </div>
          <div class="nav-collapse">
            <ul class="nav">
              <li class="active"><a href="<?php print get('webURL')._sh.'promotor/liberarAlumnos' ?>">Alumnos</a></li>
              <li><a href="#about">Mi información</a></li>
              
            </ul>
          </div><!--/.nav-collapse -->
              <?php } ?>
        </div>
      </div>
    </div>


		<div class="container" style="background: white">
			<div class="row">
<?php } ?>