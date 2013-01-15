
<script type="text/javascript">
function eliminar(nombre, id)
{
   $('#nombre_carrera').html(nombre);
   $('#id_carrera').val(id);
}
</script>

<h2>Administración de carreras</h2><hr>
<p><a class="btn btn-success pull-right" href="<?php print get('webURL').'/admin/carreras' ?>">Nuevo</a></p>
<p>
<form id="textoForm" action="<?php print isset($carrera) ? get('webURL')._sh.'admin/modcarrera/'.$carrera[0]['id_carrera'] : get('webURL')._sh.'admin/guardarcarrera' ?>" method="post">
	<label for="titulo">Nombre de la carrera</label>
	<input style="width: 300px" name="name" id="titulo" type="text" size="40" maxlength="40" value="<?php print ($carrera) ? $carrera[0]['nombre_carrera'] : NULL ?>" />
	<label>Abreviatura de la carrera</label>
	<input style="width: 300px" name="abreviatura" type="text" size="40" maxlength="40" value="<?php print ($carrera) ? $carrera[0]['abreviatura_carrera'] : NULL ?>" />
	<label>Semestres</label>
	<input style="width: 300px" name="sem" type="text" size="40" maxlength="40" value="<?php print ($carrera) ? $carrera[0]['semestres_carrera'] : NULL ?>" />
	<br>
	<input type="submit" class="btn" value="Guardar">
</form>
</p>

<h2>Carreras registradas</h2><hr>
<table class="table table-striped table-condensed">
	<thead>
		<th>Id</th>
		<th>Nombre de la carrera</th>
		<th>Abreviatura</th>
		<th>Semestres</th>
	</thead>
	<tbody>
		<?php foreach ($carreras as $car) { ?>
		<tr class="roll">
			<td><?php echo $car['id_carrera'] ?></td>
			<td><a href="<?php print get("webURL")._sh.'admin/carreras/'.$car['id_carrera'] ?>"><?php echo $car['nombre_carrera'] ?></a></td>
			<td><a href="<?php print get("webURL")._sh.'admin/carreras/'.$car['id_carrera'] ?>"><?php echo $car['abreviatura_carrera'] ?></a></td>
			<td><?php echo $car['semestres_carrera'] ?></td>
			
			<td>
				<a rel="tooltip" title="Eliminar" class="pull-right" onclick="eliminar('<?php print $car['nombre_carrera'] ?>','<?php print $car['id_carrera'] ?>');" data-toggle="modal" href="#confirmModal">
					<i class="icon-trash"></i>
				</a>
				<a rel="tooltip" title="Editar" class="pull-right" href="<?php print get("webURL")._sh.'admin/carreras/'.$car['id_carrera'] ?>">
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
    <p>¿Está seguro que desea eliminar e la carrera de <span class="label label-important" id="nombre_carrera"></span>?</p>
   
    <form id="elimClub" method="post" action="<?php print get('webURL')._sh.'admin/elimcarrera' ?>">
      <input name="id_carrera" id="id_carrera" type="hidden" value="">
    </form> 
  </div>
  <div class="modal-footer">
    <a href="#" class="btn" data-dismiss="modal">Cancelar</a>
    <a href="#" class="btn btn-danger" onclick="$('#elimClub').submit()">Eliminar</a>
  </div>
</div>