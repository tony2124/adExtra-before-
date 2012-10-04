
<!--COMBO PARA SELECCIONAR EL PERIODO -->
<p>ALUMNOS INSCRITOS EN LOS CLUBES EN EL PERIODO: <?php print $periodo ?></p>
<select onchange="location.href='<?php print get("webURL").'/admin/estadistica/' ?>'+$(this).val()">
	<?php foreach ($periodos as $per ) {
		print "<option ";
		if($per == $periodo) print "selected='selected'";
		?>

		 id="<?php print $per ?>">
		
		<?php print $per;
		print "</option>";
	}?>
</select>

<!-- PESTAÑAS PARA MOSTRAR LA INFORMACIÓN POR SEPARADO. -->
    <ul class="nav nav-tabs">
	    <li class="active"><a href="#clubes" data-toggle="tab">CLUBES</a></li>
	    <li><a href="#carreras" data-toggle="tab">CARRERAS</a></li>
	    <li><a href="#grafico" data-toggle="tab">GRÁFICO PARTICIPACIÓN</a></li>
    </ul>

    <div class="tab-content">
		<div class="tab-pane active" id="clubes">
			<table id="estadistica" width="600" class="table table-striped table-bordered table-condensed">
				<thead>
			     	<tr align="center">
			     		<th rowspan="2">ID</th>
					    <th rowspan="2">Tipo</th>
					    <th rowspan="2">Nombre del club</th>
					    <th colspan="3">Alumnos inscritos</th>
					    <th colspan="3">Alumnos Liberados</th>
					    <th rowspan="2">Acreditado, %</th>
			    	</tr>
			    	<tr>
			    		<th>M</th>
			    		<th>H</th>
			    		<th>TOTAL</th>
			    		<th>M</th>
			    		<th>H</th>
			    		<th>TOTAL</th>
			    	</tr>
			  	</thead>
			  	<tbody>
				<?php

					$th = 0;
					$tm = 0;
					$thL = 0;
					$tmL = 0;
					$porcentaje = 0;
					$i = 0;
					
					while($i < sizeof($clubes))
					{
						if(strcmp($clubes[$i]['tipo_club'], "3") != 0)
						{

							$contador = 0;
							$hombres = 0;
							$mujeres = 0;
							$hLib = 0;
							$mLib = 0;
							if($alumnos != null)
							foreach ($alumnos as $al) {
								if($al['id_club'] == $clubes[$i]['id_club'])
								{
									if(strcmp($al['sexo'],'2')==0)
									{
										$mujeres++;
										if($al['acreditado'] == 1)
											$mLib++;
									}
									else
									{
										if($al['acreditado'] == 1)
											$hLib++;
										$hombres++;
									}
									
								}
							}
							$th += $hombres;
							$tm += $mujeres;
							$thL += $hLib;
							$tmL += $mLib;
							$por = ($mujeres + $hombres > 0) ? round( ($hLib + $mLib) / ($mujeres + $hombres) * 10000) / 100 : 0;
							
				?>
							<tr>
								<td><?php echo $clubes[$i]['id_club'] ?></td>
								<td><?php echo $clubes[$i]['tipo_club'] ?></td>		
								<td>
									<a href="<?php print get("webURL")._sh.'admin/listaclub/'.$clubes[$i]['id_club'].'/'.$periodo ?>"><?php echo $clubes[$i]['nombre_club'] ?></a>
								</td>
								<td><?php print $mujeres ?></td>
								<td><?php print $hombres ?></td>
								<td><?php print $mujeres + $hombres ?></td>
								<td><?php print $mLib ?></td>
								<td><?php print $hLib ?></td>
								<td><?php print $hLib+$mLib ?></td>
								<td style="color: <?php if($por > 90) print "green"; else if($por < 70) print "red" ?>"><?php print $por." %"  ?></td>
							</tr>
				<?php
						}
						$i++;
					}

					$porcentaje = ($tm+$th > 0) ? round( ($tmL+$thL) / ($tm+$th) * 10000 ) / 100 : 0;
				?>
					<tr bgcolor="#EEF">
						<td colspan="3"></td>
						<td style="font-size: 15px;"><b><?php print $tm ?></b></td>
						<td style="font-size: 15px;"><b><?php print $th ?></b></td>
						<td style="font-size: 20px;"><b><?php echo $tm+$th ?></b></td>
						<td style="font-size: 15px;"><b><?php echo $tmL ?></b></td>
						<td style="font-size: 15px;"><b><?php echo $thL ?></b></td>
						<td style="font-size: 20px;"><b><?php echo $tmL+$thL ?></b></td>
						<td style="font-size: 20px; color: <?php if($porcentaje > 90) print "green"; else if($porcentaje < 70) print "red" ?>"><b><?php print $porcentaje. " %"  ?></td>
					</tr>
				</tbody>
			</table>

		</div>
		<div class="tab-pane" id="carreras">
			<table id="estadistica" width="600" class="table table-striped table-bordered table-condensed">
				<thead>
			     	<tr align="center">
			     		<th rowspan="2">ID</th>
					    <th rowspan="2">Nombre de la carrera</th>
					    <th colspan="3">Alumnos inscritos</th>
					    <th colspan="3">Alumnos Liberados</th>
					    <th rowspan="2">Acreditado, %</th>
			    	</tr>
			    	<tr>
			    		<th>M</th>
			    		<th>H</th>
			    		<th>TOTAL</th>
			    		<th>M</th>
			    		<th>H</th>
			    		<th>TOTAL</th>
			    	</tr>
			  	</thead>
			  	<tbody>
			  		<?php

					$th = 0;
					$tm = 0;
					$thL = 0;
					$tmL = 0;
					$porcentaje = 0;
					$i = 0;
					
					while($i < sizeof($carreras))
					{

							$contador = 0;
							$hombres = 0;
							$mujeres = 0;
							$hLib = 0;
							$mLib = 0;
							if($alumnos != null)
							foreach ($alumnos as $al) {
								if($al['id_carrera'] == $carreras[$i]['id_carrera'])
								{
									if(strcmp($al['tipo_club'], "3") != 0)
									{
										if(strcmp($al['sexo'],'2')==0)
										{
											$mujeres++;
											if($al['acreditado'] == 1)
												$mLib++;
										}
										else
										{
											if($al['acreditado'] == 1)
												$hLib++;
											$hombres++;
										}
									}
									
									
								}
							}
							$th += $hombres;
							$tm += $mujeres;
							$thL += $hLib;
							$tmL += $mLib;
							$por = ($mujeres + $hombres > 0) ? round( ($hLib + $mLib) / ($mujeres + $hombres) * 10000) / 100 : 0;
							
				?>
							<tr>
								<td><?php echo $carreras[$i]['id_carrera'] ?></td>
										
								<td>
									<a href="<?php print get("webURL")._sh.'admin/listacarrera/'.$carreras[$i]['id_carrera'].'/'.$periodo ?>"><?php echo $carreras[$i]['nombre_carrera'] ?></a>		
								</td>
								<td><?php print $mujeres ?></td>
								<td><?php print $hombres ?></td>
								<td><?php print $mujeres + $hombres ?></td>
								<td><?php print $mLib ?></td>
								<td><?php print $hLib ?></td>
								<td><?php print $hLib+$mLib ?></td>
								<td style="color: <?php if($por > 90) print "green"; else if($por < 70) print "red" ?>"><?php print $por." %"  ?></td>
							</tr>
				<?php
						
						$i++;
					}

					$porcentaje = ($tm+$th > 0) ? round( ($tmL+$thL) / ($tm+$th) * 10000 ) / 100 : 0;
				?>
				<tr>
					<td colspan="2"></td>
					<td style="font-size: 15px;"><b><?php print $tm ?></b></td>
					<td style="font-size: 15px;"><b><?php print $th ?></b></td>
					<td style="font-size: 20px;"><b><?php echo $tm+$th ?></b></td>
					<td style="font-size: 15px;"><b><?php echo $tmL ?></b></td>
					<td style="font-size: 15px;"><b><?php echo $thL ?></b></td>
					<td style="font-size: 20px;"><b><?php echo $tmL+$thL ?></b></td>
					<td style="font-size: 20px; color: <?php if($porcentaje > 90) print "green"; else if($porcentaje < 70) print "red" ?>"><b><?php print $porcentaje. " %"  ?></td>
				</tr>
			  	</tbody>
			 </table>
		</div>
		<div class="tab-pane" id="grafico">
			<div class="alert">En construcción.</div>
		</div>
		
	</div>
<hr>

<p><h3>IMPORTANTE</h3><i>Los datos que aquí se presentan hacen referencia únicamente a los alumnos que se inscribieron a los diferentes clubes deportivos y culturales, no representa los datos de los alumnos que liberaron en otras actividades.</i></p>
