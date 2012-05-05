<?php 
	if(!defined("_access")) {
		die("Error: You don't have permission to access here..."); 
	}
	
?>
	<div class="span9">
		<form class="well form-search">
		  <input type="text" class="input-medium search-query">
		  <button type="submit" class="btn">Búsqueda de alumno</button>
		</form>

		<?php $this->load(isset($view) ? $view : NULL, TRUE); ?>
		
		<div class="btn-group">
		  <button class="btn">Action</button>
		  <button class="btn dropdown-toggle" data-toggle="dropdown">
		    <span class="caret"></span>
		  </button>
		  <ul class="dropdown-menu">
		    <li><a href="#">Hola</a></li>
		  </ul>
		</div>

		<button class="btn btn-success">Hola mundo</button>
	</div>
