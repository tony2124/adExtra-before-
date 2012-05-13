<script type="text/javascript" src="<?php print path("libraries/editor/scripts/jHtmlArea-0.7.0.js", "zan"); ?>"></script>
<link rel="stylesheet" type="text/css" href="<?php print path("libraries/editor/style/jHtmlArea.css", "zan"); ?>" />
<script>
$(document).ready(function() {
	$(".txtDefaultHtmlArea").htmlarea(); 

	$(".txtCustomHtmlArea").htmlarea({
	    // Override/Specify the Toolbar buttons to show
	    toolbar: [
	        ["bold", "italic", "underline", "|", "forecolor"],
	        ["p", "h1", "h2", "h3", "h4", "h5", "h6"],
	        ["link", "unlink", "|", "image"],                    
	        [{
	            // This is how to add a completely custom Toolbar Button
	            css: "custom_disk_button",
	            text: "Save",
	            action: function(btn) {
	                // 'this' = jHtmlArea object
	                // 'btn' = jQuery object that represents the <A> "anchor" tag for the Toolbar Button
	                alert('SAVE!\n\n' + this.toHtmlString());
	            }
	        }]
	    ],

	    // Override any of the toolbarText values - these are the Alt Text / Tooltips shown
	    // when the user hovers the mouse over the Toolbar Buttons
	    // Here are a couple translated to German, thanks to Google Translate.
	    toolbarText: $.extend({}, jHtmlArea.defaultOptions.toolbarText, {
	            "bold": "fett",
	            "italic": "kursiv",
	            "underline": "unterstreichen"
	        }),

	    // Specify a specific CSS file to use for the Editor
	    css: "style//jHtmlArea.Editor.css",

	    // Do something once the editor has finished loading
	    loaded: function() {
	        //// 'this' is equal to the jHtmlArea object
	        //alert("jHtmlArea has loaded!");
	        //this.showHTMLView(); // show the HTML view once the editor has finished loading
	    }
			 });
});
</script>

<script type="text/javascript">

function eliminar(id)
{
	var con = confirm("Está seguro que desea eliminar la noticia con el id = "+id,'Titulo');
	if(con==true)
	{
		location.href="<?php print get('webURL')._sh.'admin/elimnoticia/' ?>"+id;
	}
}

</script>

<h2>Publica una nueva notica</h2><hr>
<p>
<form id="textoForm" action="<?php print ($id) ? get('webURL')._sh.'admin/modnoticia/'.$id : get('webURL')._sh.'admin/guardarnoticia' ?>" method="post" enctype="multipart/form-data">
	<label for="titulo">Título</label>
	<input style="width: 300px" name="name" id="titulo" type="text" size="40" maxlength="40" value="<?php print ($id) ? $modnot['nombre_noticia'] : NULL ?>" />
	<?php
	if($id)
		if($modnot['imagen_noticia'])
		{ ?>
		
			<p>Foto actual de la noticia, para reemplazarla elija una nueva foto.</p>
			<div style="border: 3px solid black; width: 330px; height: 250px; background-size: cover; background:url(<?php print _rs ?>/IMAGENES/fotosNoticias/<?php print $modnot['imagen_noticia'] ?>)">
			</div>
			<p>
				<input type="checkbox" name="mostrarfoto" id="mostrarfoto" value="<?php echo $modnot['imagen_noticia'] ?>" checked="checked" />&nbsp;Mostrar esta foto.
			</p>

		<?php } 	?>
	<label for="foto">Subir una foto</label>
	<input name="foto" id="foto" type="file" />

	<textarea style="width: 100%"  name="aviso" id="aviso" class="txtDefaultHtmlArea" cols="100" rows="15">
	<?php 
	if($id)
	{
		print $modnot['texto_noticia'];
	}
	?>
	</textarea>
	<input type="hidden" id="texto" name="texto" />
</form>
</p>
<p>
<input type="button" style="background:red; width:20px" value="" onclick="$('#aviso').htmlarea('forecolor', 'red');" />
<input type="button" style="background:blue; width:20px" value="" onclick="$('#aviso').htmlarea('forecolor', 'blue');" />
<input type="button" style="background:green; width:20px" value="" onclick="$('#aviso').htmlarea('forecolor', 'green');" />
<input type="button" style="background:black; width:20px" value="" onclick="$('#aviso').htmlarea('forecolor', 'black');" />
<input type="button" style="background:yellow; width:20px" value="" onclick="$('#aviso').htmlarea('forecolor', 'yellow');" />
<input type="button" style="background:orange; width:20px" value="" onclick="$('#aviso').htmlarea('forecolor', 'orange');" />
<input type="button" style="background:purple; width:20px" value="" onclick="$('#aviso').htmlarea('forecolor', 'purple');" />
<input type="button" class="btn btn-primary pull-right" value="Guardar noticia" onclick="document.getElementById('texto').value = $('#aviso').htmlarea('toHtmlString'); $('#textoForm').submit();" />
</p>
<h2>Historial de noticias.</h2><hr>
<table class="table table-striped table-condensed">
	<thead>
		<th>Id noticia</th>
		<th>Título de la noticia</th>
		<th>Foto</th>
		<th>Desc.</th>
		<th>Fech. de pub.</th>
		<th>Hora. de pub.</th>
		<th>Configuración</th>
	</thead>
	<tbody>
		<?php foreach ($noticias as $not) { ?>
		<tr class="roll">
			<td><?php echo $not['id_noticias'] ?></td>
			<td><?php echo $not['nombre_noticia'] ?></td>
			<td>
				<?php if($not['imagen_noticia']!=NULL) { ?>
				<a href="#" rel="popover" data-content="<?php print "<div style='width: 250px; height: 200px; background-size: cover;  background: url("._rs."/IMAGENES/fotosNoticias/".$not['imagen_noticia'].")'></div>" ?>" data-original-title="Imagen">ver</a>
				<?php } ?>
			</td>
			<td>
				<?php if($not['texto_noticia']!=NULL) { ?>
				<a href="#" rel="popover" data-content='<?php print $not['texto_noticia'] ?>' data-original-title="Descripción">ver</a>
				<?php } ?>
			</td>
			<td><?php echo $not['fecha_modificacion'] ?></td>
			<td><?php echo $not['hora'] ?></td>
			<td>
				<a rel="tooltip" title="Eliminar" class="pull-right" onclick="eliminar('<?php print $not['id_noticias'] ?>');" href="#">
					<i class="icon-trash"></i>
				</a>
				<a rel="tooltip" title="Editar noticia" class="pull-right" href="<?php print get('webURL')._sh.'admin/noticias/'.$not['id_noticias'] ?>">
					<i class="icon-cog"></i>
				</a>
			</td>
		</tr>

		<?php } ?>
	</tbody>
</table>
