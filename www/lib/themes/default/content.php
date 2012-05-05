<?php 
	if(!defined("_access")) {
		die("Error: You don't have permission to access here..."); 
	}
	
?>
	<div class="span9">
		

		<?php $this->load(isset($view) ? $view : NULL, TRUE); ?>
		
		

		<button class="btn btn-success">Mostrar gráfico</button>
	</div>
