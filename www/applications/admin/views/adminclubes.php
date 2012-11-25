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
function eliminar(nombre, id)
{
   $('#nombre_club').html(nombre);
   $('#id_club').val(id);
}
</script>

<h2>Administración de clubes</h2><hr>
<p><a class="btn btn-success pull-right" href="<?php print get('webURL').'/admin/adminclubes' ?>">Nuevo</a></p>
<p>
<form id="textoForm" action="<?php print isset($club) ? get('webURL')._sh.'admin/modclub/'.$club[0]['id_club'] : get('webURL')._sh.'admin/guardarclub' ?>" method="post" enctype="multipart/form-data">
	<label for="titulo">Nombre del club</label>
	<input style="width: 300px" name="name" id="titulo" type="text" size="40" maxlength="40" value="<?php print ($club) ? $club[0]['nombre_club'] : NULL ?>" />
	<?php
	if(isset($club))
		if($club[0]['foto_club'])
		{ ?>
			<p>Foto actual del club, para reemplazarla elija una nueva foto.</p>
			<img style="border: 3px solid black; " src="<?php print _rs ?>/paginas/clubes/IMAGEN/<?php print $club[0]['foto_club'] ?>" width="330">
			
			<p>
				<input type="checkbox" name="mostrarfoto" id="mostrarfoto" value="<?php echo $club[0]['foto_club'] ?>" checked="checked" />&nbsp;Mostrar esta foto.
			</p>

		<?php } 	?>
	<label for="foto">Subir una foto</label>
	<input name="foto" id="foto" type="file" /><br>
	Tipo de club<br>
	<select name="tipo">
		<option value="3">Selecciona un tipo</option>
		<option value="1" <?php if(strcmp($club[0]['tipo_club'], "1") == 0) print 'selected="selected"' ?>>Deportivo</option>
		<option value="2" <?php if(strcmp($club[0]['tipo_club'], "2") == 0) print 'selected="selected"' ?>>Cultural</option>
	</select>
	<textarea style="width: 100%"  name="aviso" id="aviso" class="txtDefaultHtmlArea" cols="100" rows="15">
	<?php 
	if(isset($club))
	{
		print $club[0]['texto_club'];
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
<input type="button" class="btn btn-primary pull-right" value="Guardar" onclick="document.getElementById('texto').value = $('#aviso').htmlarea('toHtmlString'); $('#textoForm').submit();" />
</p>
<h2>Todos los clubes inscritos</h2><hr>
<table class="table table-striped table-condensed">
	<thead>
		<th>Id</th>
		<th>Nombre del club</th>
		<th>Foto</th>
		<th>Fech. de creación</th>
		<th>Conf.</th>
	</thead>
	<tbody>
		<?php foreach ($clubes as $not) { ?>
		<tr class="roll">
			<td><?php echo $not['id_club'] ?></td>
			<td><a href="<?php print get("webURL")._sh.'admin/adminclubes/'.$not['id_club'] ?>"><?php echo $not['nombre_club'] ?></a></td>
			<td>
				<?php if($not['foto_club']!=NULL) { ?>
				<a href="#" rel="popover" data-content="<?php print "<img src='"._rs."/paginas/clubes/IMAGEN/".$not['foto_club']."' width='250' >" ?>" data-original-title="Imagen">ver</a>
				<?php } ?>
			</td>
			
			<td><?php echo $not['fecha_creacion'] ?></td>
			
			<td>
				<a rel="tooltip" title="Eliminar" class="pull-right" onclick="eliminar('<?php print $not['nombre_club'] ?>','<?php print $not['id_club'] ?>');" data-toggle="modal" href="#confirmModal">
					<i class="icon-trash"></i>
				</a>
				<a rel="tooltip" title="Editar" class="pull-right" href="<?php print get("webURL")._sh.'admin/adminclubes/'.$not['id_club'] ?>">
					<i class="icon-cog"></i>
				</a>
			</td>
		</tr>

		<?php } ?>
	</tbody>
</table>

<div class="modal hide fade" id="confirmModal">
  <div class="modal-header">
    <button class="close" data-dismiss="modal">×</button>
    <h3>Confirmación</h3>
  </div>
  <div class="modal-body">
    <p>¿Está seguro que desea eliminar el club de <span class="label label-important" id="nombre_club"></span>?</p>
   
    <form id="elimClub" method="post" action="<?php print get('webURL')._sh.'admin/elimClub' ?>">
      <input name="id_club" id="id_club" type="hidden" value="">
    </form> 
  </div>
  <div class="modal-footer">
    <a href="#" class="btn" data-dismiss="modal">Cancelar</a>
    <a href="#" class="btn btn-danger" onclick="$('#elimClub').submit()">Eliminar</a>
  </div>
</div>