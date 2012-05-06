<?php 
	if(!defined("_access")) {
		die("Error: You don't have permission to access here..."); 
	}
	if(SESSION('user_admin'))
	{
?>
<div class="span3">
	<h3>Búsqueda de alumnos</h3>
	<form class="well" align="center" action="#" method="post">
	  <label>Nombre o número de control</label>
	  <input type="text" class="input-medium">
	 <!-- <span class="help-block">Buscar también alumnos egresados</span>-->
	  <label class="checkbox">
	    <input type="checkbox"> Buscar también en alumnos egresados.
	  </label>
	  <button type="submit" class="btn btn-primary">Buscar</button>
	</form>
</div>
<?php } ?>