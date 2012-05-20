<?php 
	if(!defined("_access")) {
		die("Error: You don't have permission to access here..."); 
	}
	
?>
	<div class="span9">
		<?php $this->load(isset($view['adminConfig']) ? $view : NULL, TRUE); ?>		
	</div>
