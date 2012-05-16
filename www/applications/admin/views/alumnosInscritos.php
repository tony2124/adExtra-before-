<p>ALUMNOS INSCRITOS EN LOS CLUBES EN EL PERIODO: <?php print $periodo ?></p>

<table width="600" class = "table table-striped table-bordered table-condensed">
	<thead>
     	<tr>
     		<th>ID</th>
		    <th>Tipo</th>
		    <th>Nombre del club</th>
		    <th>No. Alumnos</th>
    	</tr>
  	</thead>
  	<tbody>
	
	<?php

		$TOTAL = 0;
		$i = 0;
		while($i < sizeof($clubes))
		{
			if($clubes[$i]['tipo_club'] == 1 || $clubes[$i]['tipo_club'] == 2)
			{
	?>
				<tr>
					<td><?php echo $clubes[$i]['id_club'] ?></td>
					<td><?php echo $clubes[$i]['tipo_club'] ?></td>		
					<td>
						<?php echo $clubes[$i]['nombre_club'] ?>		
					</td>
					<td align="center">
				<?php 
						$contador = 0;
						foreach ($alumnos as $al) {
							if($al['id_club'] == $clubes[$i]['id_club'])
								$contador++;
						}
						print $contador;
						$TOTAL += $contador;
						 
						
				?>
					</td>
				</tr>
	<?php
			}
			$i++;
		}
	?>
	<tr bgcolor="#EEF">
		<td colspan="3"></td>
		<td align="center" style="font-size: 20px;">
			<b>
				<?php echo $TOTAL ?>
			</b>
		</td>
	</tr>
</tbody>
</table>

<button class="btn btn-success">Mostrar gráfico</button>