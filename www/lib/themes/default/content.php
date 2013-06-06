<?php 
	if(!defined("_access")) {
		die("Error: You don't have permission to access here..."); 
	}
	
?>
	<div class="span9">
		<?php $this->load(isset($view) ? $view : NULL, TRUE); ?>
	</div>
	<!-- search for the student -->
<?php if(SESSION('user_admin'))	{ ?>
	<div class="span3">
		<h3><b class="icon-search"></b> Búsqueda de alumnos</h3>
		<form class="well" align="center" action="<?php print get('webURL'). _sh .'admin/buscar' ?>" method="post">
		  <label>Nombre o número de control</label>
		  <input type="text" name="bus" class="input-medium">
		  <label class="checkbox">
		    <input type="checkbox" name="sit" value="5"> Buscar también en alumnos egresados.
		  </label>
		  <button type="submit" class="btn btn-primary">Buscar</button>
		</form>
		<p><a target="_blank" href="https://www.dropbox.com/s/yoniq6vddq62nvp/Manual%20para%20el%20administrador.docx">¡Descargar manual de administrador!</a></p>
		<a class="pull-right" href="http://www.itsa.edu.mx/"  title="Ir a la página del ITSA" rel="tooltip">
			<img class="pull-right" src="<?php print _rs._sh.'IMAGENES/cargando/logo.png' ?>">
		</a>
		
	
	</div>

<?php } ?>