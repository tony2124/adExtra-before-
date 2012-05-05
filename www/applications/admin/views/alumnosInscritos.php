ALUMNOS INSCRITOS EN LOS CLUBES EN EL PERIODO: <?php print $periodo ?>

<table width="600" class = "table table-striped table-bordered table-condensed">
	 <thead>
     <tr>
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
					
					<td>
						<?php echo $clubes[$i]['nombre_club'] ?>		
					</td>
					<td align="center">
				<?php 
						print "Numero de alumnos";
						
				?>
					</td>
				</tr>
	<?php
			}
			$i++;
		}
	?>
	<tr bgcolor="#EEF">
		<td></td>
		<td align="center" style="font-size: 20px;">
			<b>
				<?php echo $TOTAL ?>
			</b>
		</td>
	</tr>
</tbody>
</table>