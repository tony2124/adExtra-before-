<?php if($conf[0]['fecha_inicio_liberacion'] <= fechaactual() && $conf[0]['fecha_fin_liberacion']>=fechaactual()) { ?>
Relación de alumnos del club de <b><?php print strtoupper($alumnos[0]['nombre_club']) ?></b><br>
PERIODO: <b><?php print $alumnos[0]['periodo'] ?></b>
<br><hr>
<form action="<?php print get('webURL')._sh.'promotor/acreditando' ?>" method="post">
	<input type="hidden" name="na" value="<?php print sizeOf($alumnos) ?>">
<table class="table table-striped table-condensed">
	<thead>
		<th>No. Control</th>
		<th>Nombre</th>
		<th>Sexo</th>
		<th>Sem</th>
		<th>Carrera</th>
		<th colspan="2">ACREDITADO</th>
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
		<td><input type="radio" <?php if($alumno['acreditado'] == 1) print 'checked="checked"' ?> name="res<?php print $i ?>" id="si<?php print $i ?>" value="1"><label for="si<?php print $i ?>">SI</label></td>
		<td><input type="radio" <?php if($alumno['acreditado'] == 0) print 'checked="checked"' ?> name="res<?php print $i ?>" id="no<?php print $i ?>" value="0"><label for="no<?php print $i ?>">NO</label>
			<input type="hidden" name="folio<?php print $i++ ?>" value="<?php print $alumno['folio'] ?>">
		</td>
	   </tr>
	   <?php } } ?>
	</tbody>
</table>

<input type="submit" value="Guardar reporte">
</form>
<?php } else { ?>
<div class="alert">
		<!--<a class="close" data-dismiss="alert" href="#">×</a>-->
		ESPERE A QUE EL PERIODO DE LIBERACIÓN SEA ABIERTO POR EL ADMINISTRADOR.
</div>
<?php } ?>