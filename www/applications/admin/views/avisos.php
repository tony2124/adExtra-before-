<script type="text/javascript" src="<?php print path("libraries/editor/scripts/jHtmlArea-0.7.0.js", "zan"); ?>"></script>
<link rel="stylesheet" type="text/css" href="<?php print path("libraries/editor/style/jHtmlArea.css", "zan"); ?>" />
<script>
$(document).ready(function() {
	$(".txtDefaultHtmlArea").htmlarea(); 

	$(".txtCustomHtmlArea").htmlarea({
	    toolbar: [
	        ["bold", "italic", "underline", "|", "forecolor"],
	        ["p", "h1", "h2", "h3", "h4", "h5", "h6"],
	        ["link", "unlink", "|", "image"],                    
	        [{
	            css: "custom_disk_button",
	            text: "Save",
	            action: function(btn) {
	                alert('SAVE!\n\n' + this.toHtmlString());
	            }
	        }]
	    ],

	    toolbarText: $.extend({}, jHtmlArea.defaultOptions.toolbarText, {
	            "bold": "fett",
	            "italic": "kursiv",
	            "underline": "unterstreichen"
	        }),

	    css: "style//jHtmlArea.Editor.css",

	    loaded: function() {   }
			 });
});
</script>
<h2>Publica un aviso</h2><hr>
<?php if($conf['mostraraviso'] == 0) { ?>
<div class="alert">
	<a href="#" class="close" data-dismiss="alert">x</a>
	<p>La configuración actual indica que el aviso NO se está mostrando en el sitio web.</p>
	</div>
<?php } ?>
<p>En el siguiente apartado usted podrá escribir un aviso o varios avisos a las personas que visiten el sitio de Servicios Extraescolores.</p>
<hr>
<form id="textoForm" name="textoForm" action="<?php print get('webURL'). _sh . 'admin/guardarAviso' ?>" method="post">
	<textarea style="width: 100%" name="aviso" id="aviso" class="txtDefaultHtmlArea" cols="50" rows="15">
		<?php echo $mensaje['texto_noticia'] ?>
	</textarea>
	<input type="hidden" id="texto" name="texto" value="" />
<p>
	<input type="button" style="background:red; width:20px" value="" onclick="$('#aviso').htmlarea('forecolor', 'red');" />
	<input type="button" style="background:blue; width:20px" value="" onclick="$('#aviso').htmlarea('forecolor', 'blue');" />
	<input type="button" style="background:green; width:20px" value="" onclick="$('#aviso').htmlarea('forecolor', 'green');" />
	<input type="button" style="background:black; width:20px" value="" onclick="$('#aviso').htmlarea('forecolor', 'black');" />
	<input type="button" style="background:yellow; width:20px" value="" onclick="$('#aviso').htmlarea('forecolor', 'yellow');" />
	<input type="button" style="background:orange; width:20px" value="" onclick="$('#aviso').htmlarea('forecolor', 'orange');" />
	<input type="button" style="background:purple; width:20px" value="" onclick="$('#aviso').htmlarea('forecolor', 'purple');" />
	<input type="button" class="btn btn-primary pull-right" value="Guardar aviso" onclick="document.getElementById('texto').value = $('#aviso').htmlarea('toHtmlString'); $('#textoForm').submit();" />
</p>
<p>
	<label class="checkbox" >
	<input type="checkbox"  
	<?php if($conf['mostraraviso'] == 1) print 'checked="checked"' ?>
	name="mostrarAviso"> Mostrar el aviso cuando se entre al sitio de extraescolares.</label>
</p>
</form>