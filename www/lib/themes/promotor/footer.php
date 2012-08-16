<?php 
	if(!defined("_access")) {
		die("Error: You don't have permission to access here..."); 
	}
	
	if(isMobile()) {
		include "mobile/footer.php";
	} else {
?>
			
		</div>
		<hr>
		<footer>
			<p>&copy; <?php print __("All rights reserved"); ?> - Instituto Tecnológico Superior de Apatzingán</a></p>
		</footer>
	  
		</div>
	</body>
</html>
<?php } ?>