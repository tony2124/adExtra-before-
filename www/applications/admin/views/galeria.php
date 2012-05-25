Selecciona el tipo de club: <a href="<?php print get('webURL')._sh.'admin/galeria/1' ?>">DEPORTIVO</a> | 
<a href="<?php print get('webURL')._sh.'admin/galeria/2' ?>">CULTURAL</a> | 
<a href="<?php print get('webURL')._sh.'admin/galeria/0' ?>">GENERAL</a>

<br><br>

<?php if(isset($clubes)) { ?>
<label>CLUB</label>
	<select name="club">
	<?php
	foreach ($clubes as $club) {
	?>
		<option value="<?php print $club['id_club'] ?>"><?php print $club['nombre_club'] ?></option>
	<?php } ?>
	</select>

 <?php } ?>
