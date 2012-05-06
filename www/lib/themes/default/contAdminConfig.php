<?php 
	if(!defined("_access")) {
		die("Error: You don't have permission to access here..."); 
	}
	
?>
	<div class="span9">
		<?php $this->load(isset($view['adminConfig']) ? $view['adminConfig'] : NULL, TRUE); ?>		
		<?php $this->load(isset($view['registroAdmin']) ? $view['registroAdmin'] : NULL, TRUE); ?>


	</div>
