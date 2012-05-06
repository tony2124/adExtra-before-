<?php 
	if(!defined("_access")) {
		die("Error: You don't have permission to access here..."); 
	}
	
?>
	<div class="span12"  align="center">
		
		<?php $this->load(isset($view) ? $view : NULL, TRUE); ?>

	</div>
