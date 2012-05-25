Selecciona el tipo de club: 
<a href="<?php print get('webURL')._sh.'admin/galeria/1' ?>">DEPORTIVO</a> | 
<a href="<?php print get('webURL')._sh.'admin/galeria/2' ?>">CULTURAL</a> | 
<a href="<?php print get('webURL')._sh.'admin/galeria/0' ?>">GENERAL</a>
<br><br>

<?php if(isset($clubes)) { ?>
	<label>CLUB</label>
	<select id="club" name="club" onchange="location.href='<?php print get('webURL'). _sh .'admin/galeria/'.$tipo.'/'?>'+document.getElementById('club').value" >
	<?php
	foreach ($clubes as $club) {
	?>
		<option value="<?php print $club['id_club'] ?>"><?php print $club['nombre_club'] ?></option>
	<?php } ?>
	</select>

 <?php } if(isset($albumes)) { 
foreach ($albumes as $album) {
	print $album['nombre_album'].'<br>';
}
 	?>

 <?php } ?>
