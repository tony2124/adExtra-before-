
<!-- <script src="<?php print path("www/lib/datatable-base/yui-min.js","www") ?>"></script>

<link rel="stylesheet" type="text/css" href="<?php print path("www/lib/yui/build/assets/skins/sam/datatable-base.css","www") ?>">
<script>
// Create a new YUI instance and populate it with the required modules.
YUI().use('datatable', function (Y) {
    // DataTable is available and ready for use. Add implementation
    // code here.
    // Columns must match data object property names
var data = [
    { id: "ga-3475", name: "gadget",   price: "$6.99", cost: "$5.99" },
    { id: "sp-9980", name: "sprocket", price: "$3.75", cost: "$3.25" },
    { id: "wi-0650", name: "widget",   price: "$4.25", cost: "$3.75" }
];

var table = new Y.DataTable({
    columns: ["id", "name", "price"],
    data: data,
    // and/or a summary (table attribute)
    summary: "Example DataTable showing basic instantiation configuration",
    sortable: true
});

table.render("#tabla");
});

</script>
-->

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

<div id="tabla"></div>
<table width="600" class = "table table-striped table-bordered table-condensed">
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
			if($clubes[$i]['tipo_club'] == 1 || $clubes[$i]['tipo_club'] == 2)
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
						<?php echo $clubes[$i]['nombre_club'] ?>		
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
<button class="btn">Ver por carreras</button>
<button class="btn">Ver por clubes</button>
<button class="btn btn-success">Mostrar gráfico</button>