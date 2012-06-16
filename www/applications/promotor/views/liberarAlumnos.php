Relación de alumnos del club de <?php print strtoupper($alumnos[0]['nombre_club']) ?>
<form action="<?php ?>" method="post">
<table class="table table-striped table-condensed">
	<thead>
		<th>No. Control</th>
		<th>Nombre</th>
		<th>Sexo</th>
		<th>Sem</th>
		<th>Carrera</th>
		<th colspan="2">Resultado</th>
	</thead>
	<tbody>
		<?php if($alumnos!=NULL) { $i=0;
			foreach ($alumnos as $alumno) { ?>
	   <tr>
		<td><?php print strtoupper($alumno['numero_control']) ?></td>
		<td><?php print strtoupper($alumno['apellido_paterno_alumno'].' '.$alumno['apellido_materno_alumno'].' '.$alumno['nombre_alumno']) ?></td>
		<td><?php print strtoupper($alumno['sexo']) ?></td>
		<td><?php print semestre($alumno['fecha_inscripcion']) ?></td>
		<td><?php print strtoupper($alumno['abreviatura_carrera']) ?></td>
		<td><input type="radio" selected="selected" name="res<?php print $i ?>" id="si<?php print $i ?>"><label for="si<?php print $i ?>">SI</label></td>
		<td><input type="radio" name="res<?php print $i ?>" id="no<?php print $i ?>"><label for="no<?php print $i++ ?>">NO</label></td>
	   </tr>
	   <?php } } ?>
	</tbody>
</table>

<input type="submit" value="Guardar reporte">
</form>