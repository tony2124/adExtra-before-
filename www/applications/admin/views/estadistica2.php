
<script src="http://cdn.kendostatic.com/2012.3.1315/js/kendo.all.min.js"></script>
<link href="styles/kendo.common.css" rel="stylesheet" />
<link href="http://cdn.kendostatic.com/2012.3.1315/styles/kendo.default.min.css" rel="stylesheet" />
<!--COMBO PARA SELECCIONAR EL PERIODO  -->
<p>ALUMNOS INSCRITOS EN LOS CLUBES EN EL PERIODO: <?php print $periodo ?></p>
<select onchange="location.href='<?php print get("webURL").'/admin/estadistica/' ?>'+$(this).val()">
	<?php foreach ($periodos as $per ) {
		print "<option ";
		if($per == $periodo) print "selected='selected'";
		?>

		 id="<?php print $per ?>">
		
		<?php print $per;
		print "</option>";

		$periodos = periodos("2112");
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
		<?php for ($indice = 0; $indice < sizeof($periodos); $indice++)
			{ 

				$th = 0;
				$tm = 0;
				$thL = 0;
				$tmL = 0;
				$porcentaje = 0;
				$i = 0;
				$conta = 0;
				while($i < sizeof($clubes))
				{
					if(strcmp($clubes[$i]['tipo_club'], "3") != 0)
					{
						$contador = 0;
						$hombres = 0;
						$mujeres = 0;
						$hLib = 0;
						$mLib = 0;
						if($todos_alumnos != null)
						foreach ($todos_alumnos as $al) {
							if(strcmp($al['periodo'],$periodos[$indice])==0)
							{
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
						}

						$th += $hombres;
						$tm += $mujeres;
						$thL += $hLib;
						$tmL += $mLib;
						$por = ($mujeres + $hombres > 0) ? round( ($hLib + $mLib) / ($mujeres + $hombres) * 10000) / 100 : 0;
						
						if( strcmp( $periodo, $periodos[$indice]) == 0 )
						{
							$mostrar[$conta][0] = $clubes[$i]['id_club'];
							$mostrar[$conta][1] = $clubes[$i]['tipo_club'];
							$mostrar[$conta][2] = $clubes[$i]['nombre_club'];
							$mostrar[$conta][3] = $mujeres;
							$mostrar[$conta][4] = $hombres;
							$mostrar[$conta][5] = $mujeres + $hombres;
							$mostrar[$conta][6] = $mLib;
							$mostrar[$conta][7] = $hLib;
							$mostrar[$conta][8] = $hLib+$mLib;
							$mostrar[$conta][9] = $por;
							$conta++;
						}
					}

					$i++;
				}

				$totales[0] = $tm; 
				$totales[1] = $th;
				$totales[2] = $tm+$th;
				$totales[3] = $tmL;
				$totales[4] = $thL;
				$totales[5] = $tmL+$thL;

				$porcentaje = ($tm+$th > 0) ? round( ($tmL+$thL) / ($tm+$th) * 10000 ) / 100 : 0;

				if(strcmp($periodo,$periodos[$indice])==0)
					$ppa = $porcentaje;

				$pct[$indice] = $porcentaje;
			}
				?>		
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
					$i = 0;
					while($i < sizeof($clubes))
					{
				?>

					<tr>
						<td><?php echo $mostrar[$i][0] ?></td>
						<td><?php echo $mostrar[$i][1] ?></td>		
						<td>
							<a href="<?php print get("webURL")._sh.'admin/listaclub/'.$clubes[$i]['id_club'].'/'.$periodo ?>"><?php echo $mostrar[$i][2] ?></a>
						</td>
						<td><?php print $mostrar[$i][3] ?></td>
						<td><?php print $mostrar[$i][4] ?></td>
						<td><?php print $mostrar[$i][5] ?></td>
						<td><?php print $mostrar[$i][6] ?></td>
						<td><?php print $mostrar[$i][7] ?></td>
						<td><?php print $mostrar[$i][8] ?></td>
						<td style="color: <?php if($mostrar[$i][9] > 90) print "green"; else if($mostrar[$i][9] < 70) print "red" ?>"><?php print $mostrar[$i][9]." %"  ?></td>
					</tr>
					<?php
					
					$i++;
					}
				?>
					<tr bgcolor="#EEF">
						<td colspan="3"></td>
						<td style="font-size: 15px;"><b><?php print $totales[0] ?></b></td>
						<td style="font-size: 15px;"><b><?php print $totales[1] ?></b></td>
						<td style="font-size: 20px;"><b><?php echo $totales[2] ?></b></td>
						<td style="font-size: 15px;"><b><?php echo $totales[3] ?></b></td>
						<td style="font-size: 15px;"><b><?php echo $totales[4] ?></b></td>
						<td style="font-size: 20px;"><b><?php echo $totales[5] ?></b></td>
						<td style="font-size: 20px; color: <?php if($ppa > 90) print "green"; else if($ppa < 70) print "red" ?>"><b><?php print $ppa. " %"  ?></td>
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
			 <div id="example" class="k-content">
          	<div class="configuration" style="width:400px;">
                <span class="configHead">Periodos</span>
                <ul class="options">
                    <li style="list-style: none;">
	                   De <select name="per1">
							<?php

								 foreach ($periodos as $per ) {
								print "<option ";
								if(strcmp($per, "AGO2011-ENE2012") == 0) print "selected='selected'";
								?>

								 id="<?php print $per ?>">
								
								<?php print $per;
								print "</option>";
							}?>
						</select> <br>
						hasta <select name="per2">
							<?php foreach ($periodos as $per ) {
								print "<option ";
								if(strcmp($per, $periodo)==0) print "selected='selected'";
								?>

								 id="<?php print $per ?>">
								
								<?php print $per;
								print "</option>";
							}?>
						</select> 
                    </li>
                </ul>
            </div>
            <div class="chart-wrapper">
                <div id="chart"></div>
            </div>

            <script>
                function createChart() {
                    $("#chart").kendoChart({
                        theme: $(document).data("kendoSkin") || "default",
                        title: {
                            text: "Participación de alumnos"
                        },
                        series: [{
                            type: "column",
                            data: [<?php print $pct[0] ?>,<?php print $pct[1] ?>,<?php print $pct[2] ?>],
 
                        }],
                        categoryAxis: {

                            categories: [
                                <?php 
                                $cad = "";
                                for($i = 0; $i < sizeof($periodos); $i++)
                                {
                                	$cad .= "\"".$periodos[$i]."\",";
                                }
                                $cad = substr($cad, 0,-1);
                                print $cad;
                                ?>
                            ]
                             
                        },
                        tooltip: {
                            visible: true,
                            format: "{0}%"
                        }
                    });
                }

                $(document).ready(function() {
                    setTimeout(function() {
                        // Initialize the chart with a delay to make sure
                        // the initial animation is visible
                        createChart();

                        $("#example").bind("kendo:skinChange", function(e) {
                            createChart();
                        });
                    }, 400);

                    $(".configuration").bind("change", refresh);
                });

                function refresh() {
                    var chart = $("#chart").data("kendoChart"),
                        series = chart.options.series,
                        categoryAxis = chart.options.categoryAxis,
                        baseUnitInputs = $("select[name=per1]"),
                        aggregateInputs = $("select[name=per2]");
                        
                    for (var i = 0, length = series.length; i < length; i++) {
                        series[i].aggregate = aggregateInputs.filter(":checked").val();
                    };

                    categoryAxis.baseUnit = baseUnitInputs.filter(":checked").val();

                    chart.refresh();
                }
            </script>
          
        </div>
		</div>
		
	</div>
<hr>

<p><h3>IMPORTANTE</h3><i>Los datos que aquí se presentan hacen referencia únicamente a los alumnos que se inscribieron a los diferentes clubes deportivos y culturales, no representa los datos de los alumnos que liberaron en otras actividades.</i></p>-->
