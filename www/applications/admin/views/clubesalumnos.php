<form action="<?php print get('webURL')._sh.'admin/listaclub/' ?>" method="get" class="form-horizontal span6">
	<fieldset>
		<legend>Elije un club y un periodo</legend>
		<div class="control-group">
			<label class="control-label">CLUB</label>
			<div class="controls">
				<select name="club">
					<?php 
					foreach ($clubes as $row)
					{ ?>
						<option value="<?php echo $row['id_club'] ?>">
							<?php echo $row['nombre_club'] ?>	
						</option>
					<?php 
					} ?>
				</select>
			</div>
			<br>
			<label class="control-label">PERIODO</label> 
		    <div class="controls">
			  	<select name="periodo">
				<?php
					$tamano = 0;
					while($tamano < sizeof($periodos))
					{
						?>
						<option	value="<?php echo $periodos[$tamano] ?>">
								<?php echo $periodos[$tamano] ?>
						</option>
							<?php
						$tamano++;
					}
					?>
				</select>
			</div>
			<br>
			<p align="center">
				<input type="submit" value="Enviar" class="btn btn-primary" />
			</p>
		</div>
		<hr>
	</fieldset>
</form>

<table class="table table-striped table-condensed">
  <thead>
    <tr>
      <th>N0.</th>
      <th>N. control</th>
      <th>Nombre</th>
      <th>Carrera</th>
      <th>Sexo</th>
      <th>edad</th>
      <th>resultado</th>
    </tr>
  </thead>
  <tbody>
<?php
$i=1;
foreach ($alumnos as $alum) {	?>

      <tr>
        <td><?php print $i++ ?></td>
        <td><?php print $alum['numero_control'] ?></td>
        <td><?php echo $alum['apellido_paterno_alumno']." ".$alum['apellido_materno_alumno']." ".$alum['nombre_alumno'] ?></td>
        <td><?php echo $alum['abreviatura_carrera'] ?></td>
        <td><?php echo $alum['sexo'] ?></td>
        <td><?php echo edad($alum['fecha_nacimiento']) ?></td>
        <td><?php echo $alum['acreditado'] ?></td>
      </tr>
<?php	
}
?>
   </tbody>
 </table>