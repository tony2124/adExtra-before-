<script>
function eliminar(name)
{
   $('#nombre_archivo').html(name);
   $('#eliminar').attr("href","<?php print get('webURL') . _sh . 'admin/eliminararchivo/' ?>"+name);
}
</script>
<h2>Subir un archivo</h2>
<p>
	<form action="<?php print get('webURL')._sh.'admin/subiendo' ?>" method="post" enctype="multipart/form-data">
		<label>Elige el archivo</label>
		<input type="file" name="archivo"><br>
		<input type="submit" value="Subir" class="btn">
	</form>

</p>

<h2>Historial de archivos.</h2><hr>
<table class="table table-striped table-condensed">
	<thead>
		<th width="500">Nombre del archivo</th>
		<th></th>
	</thead>
	<tbody>
		<?php $i = 0; while($i < sizeof($files)) { ?>
		<tr class="roll">
			<td><a href="<?php print _rs . '/descarga/' . $files[$i] ?>" target="_blank"><?php echo $files[$i] ?></a></td>
			<td>
				<a rel="tooltip" title="Eliminar" data-toggle="modal" class="pull-right" onclick="eliminar('<?php print $files[$i++] ?>')" href="#confirmModal">
					<i class="icon-trash"></i>
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
    <p>¿Está seguro que desea eliminar el archivo <span class="label label-important" id="nombre_archivo"></span> de la lista de descargas?</p>
  </div>
  <div class="modal-footer">
    <a href="#" class="btn" data-dismiss="modal">Cancelar</a>
    <a href="#" class="btn btn-danger" id="eliminar">Eliminar</a>
  </div>
</div>