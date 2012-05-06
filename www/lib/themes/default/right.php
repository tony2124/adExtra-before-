<?php 
	if(!defined("_access")) {
		die("Error: You don't have permission to access here..."); 
	}
	if(SESSION('user_admin'))
	{
?>
<div class="span3">
	<h3><b class="icon-search"></b> Búsqueda de alumnos</h3>
	<form class="well" align="center" action="<?php print get('webURL'). _sh .'admin/buscar' ?>" method="post">
	  <label>Nombre o número de control</label>
	  <input type="text" name="bus" class="input-medium">
	 <!-- <span class="help-block">Buscar también alumnos egresados</span>-->
	  <label class="checkbox">
	    <input type="checkbox" name="sit"> Buscar también en alumnos egresados.
	  </label>
	  <button type="submit" class="btn btn-primary">Buscar</button>
	</form>
</div>
<?php } ?>