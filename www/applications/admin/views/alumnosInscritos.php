
<script src="http://yui.yahooapis.com/3.6.0/build/yui/yui-min.js"></script>
<style type="text/css">
.yui3-skin-sam .yui3-datatable-caption {
    font-size: 13px;
    font-style: normal;
    text-align: left;
}

.yui3-datatable-col-nchars {
    text-align: center;
}

.yui3-skin-sam .yui3-datatable td.myhilite td {
    background-color: #C0ffc0;
}

#mtable tbody tr {      /*  Turn on cursor to show TR's are selectable on Master DataTable only  */
    cursor: pointer;
}
</style>

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
     	<tr>
     		<th>ID</th>
		    <th>Tipo</th>
		    <th>Nombre del club</th>
		    <th>Mujeres</th>
		    <th>Hombres</th>
		    <th>No. Alumnos</th>
    	</tr>
  	</thead>
  	<tbody>
	
	<?php

		$th = 0;
		$tm = 0;
		$i = 0;
		while($i < sizeof($clubes))
		{
			if($clubes[$i]['tipo_club'] == 1 || $clubes[$i]['tipo_club'] == 2)
			{

				$contador = 0;
				$hombres = 0;
				$mujeres = 0;
				if($alumnos != null)
				foreach ($alumnos as $al) {
					if($al['id_club'] == $clubes[$i]['id_club'])
					{
						if($al['sexo'] != 1)
							$mujeres++;
						else $hombres++;
						
					}
				}
				$th += $hombres;
				$tm += $mujeres;
				
	?>
				<tr>
					<td><?php echo $clubes[$i]['id_club'] ?></td>
					<td><?php echo $clubes[$i]['tipo_club'] ?></td>		
					<td>
						<?php echo $clubes[$i]['nombre_club'] ?>		
					</td>
					<td align="center">
					<?php print $mujeres ?>		
					</td>
					<td><?php print $hombres ?></td>
					<td><?php print $mujeres + $hombres ?></td>
				</tr>
	<?php
			}
			$i++;
		}
	?>
	<tr bgcolor="#EEF">
		<td colspan="3"></td>
		<td><b><?php print $tm ?></b></td>
		<td><b><?php print $th ?></b></td>
		<td align="center" style="font-size: 20px;">
			<b>
				<?php echo $tm+$th ?>
			</b>
		</td>
	</tr>
</tbody>
</table>
<button class="btn">Ver por carreras</button>
<button class="btn">Ver por clubes</button>
<button class="btn btn-success">Mostrar gráfico</button>