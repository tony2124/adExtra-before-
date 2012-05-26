<?php
if(isset($clubes))
	foreach ($clubes as $club) {
		if($URL['club'] == $club['id_club']){
			$URL['club_nombre'] = $club['nombre_club']; break;
		}
	}

if(isset($albumes))
	foreach ($albumes as $album) {
		if($URL['album'] == $album['id_album']){
			$URL['album_nombre'] = $album['nombre_album']; break;
		}
	}

if(isset($URL['tipo']))
	switch($URL['tipo'])
	{
		case '0': $URL['tipo_nombre'] = 'GENERAL'; break;
		case '1': $URL['tipo_nombre'] = 'DEPORTIVO'; break;
		case '2': $URL['tipo_nombre'] = 'CULTURAL'; break;
	}
?>			
<script type="text/javascript">
	function eliminarAlbum(id, tipo, club)
	{
		var r = confirm("¿Está seguro que desea eliminar este álbum?. Tome en cuenta que se eliminarán todas las fotos y no será posible recuperarlas después");
		if(r == 1)
		{				
			location.href="";
		}
	}

	function eliminarFoto( tipo, club, album, id)
	{
		var r = confirm("¿Está seguro que desea eliminar esta foto?. Tome en cuenta que no será posible recuperarla más tarde"+id);
		if(r == 1){				
			location.href="";
		}
	}
</script>
	
<style type="text/css">
	.gallery{
		position: relative;
		width: 730px;
	}

	.horizontalList{	
		list-style: none;
	}

	.horizontalListItem{
		float: left;
	}

	.borderContainer{
		position: relative;
		width: 190px;
		height: 140px;
		margin: 5px;
		border: 1px solid #009966;
		padding: 4px; 
	}

	.imageContainer{
		position: relative;
		width: 190px;
		height: 140px;
		background-size: cover;
	}
</style>
<?php if(!isset($URL['album'])) { ?>
<label>TIPO</label>
<select onchange="location.href='<?php print get('webURL')._sh.'admin/galeria/' ?>'+$(this).val()">
	<option value="">:::Selecciona una opción:::</option>
	<option <?php ($URL['tipo']=='1') ? print 'selected="selected"' : NULL ?> value="1">DEPORTIVO</option>
	<option <?php ($URL['tipo']=='2') ? print 'selected="selected"' : NULL ?> value="2">CULTURAL</option>
	<option <?php ($URL['tipo']=='0') ? print 'selected="selected"' : NULL ?> value="0">GENERAL</option>
</select> 
<br><br>
<?php }	if(isset($clubes)  && !isset($URL['album'])) { ?>
	<label>CLUB</label>
	<select id="club" name="club" onchange="location.href='<?php print get('webURL'). _sh .'admin/galeria/'.$URL['tipo'].'/'?>'+document.getElementById('club').value" >
		<option value="">:::Selecciona un club:::</option>
	<?php foreach ($clubes as $club) {	?>
		<option <?php if($URL['club'] == $club['id_club']) print 'selected="selected"' ?> value="<?php print $club['id_club'] ?>"><?php print $club['nombre_club'] ?></option>
	<?php } ?>
	</select>
	<p>&nbsp;</p>
 <?php } 

   if(isset($albumes) && !isset($URL['album'])) 
   {
		foreach ($albumes as $album) 
		{ ?>
			<a href="<?php print get('webURL'). _sh . 'admin/galeria'. _sh . $URL['tipo']. _sh . $URL['club'] . _sh . $album['id_album'] ?>">
				<div align="center" style="float: left; width: 150px; height: 150px; border: 1px solid #EEE; padding: 5px; margin: 5px">			
					<img src="<?php print path('www/lib/images/carpeta.jpg','www') ?>" width="100" height="100" />
					<br>
					<?php echo $album['nombre_album'] ?>				
				</div>
			</a>
			<a title="Eliminar álbum <?php print $album['nombre_album'] ?>" onclick="eliminarAlbum(<?php echo $album['id_album'].",".$tipo.",'".$club['id_club']."'" ?>)" href="#">
				<img style="width: 20px; height: 20px; float: left; margin-left: -30px;" src="<?php print path('www/lib/images/eliminar.gif',true) ?>" /> 
			</a>		
<?php 	}	
	} 

	if(isset($URL['album'])){ ?>
	<a href="<?php print get('webURL'). _sh . 'admin/galeria' ?>">GALERIA</a> /
	<a href="<?php print get('webURL'). _sh . 'admin/galeria'. _sh . $URL['tipo'] ?>"><?php print $URL['tipo_nombre'] ?></a> /
	<a href="<?php print get('webURL'). _sh . 'admin/galeria'. _sh . $URL['tipo'] . _sh . $URL['club'] ?>"><?php print $URL['club_nombre'] ?></a> /
	<a href=""><?php print $URL['album_nombre'] ?></a> /
	<p>&nbsp;</p>
		
		
		  <table>
			<tr>
				<td>
					<div id="gallery">
						<ul id="galleyList" class="horizontalList">
					<?php
				foreach ($fotos as $foto) { ?>					
						<li class="horizontalListItem">
						      <div class="borderContainer">
						           <a rel="galeria" class="galeria" title="Foto: <?php echo $foto['id_imagen']."\nÁlbum: ".$URL['album'] ?>" href="<?php echo _rs."/IMAGENES/clubes/".$URL['club']. _sh . $URL['album']. _sh .$foto['nombre_imagen'] ?>">
						              	<div class="imageContainer" style="background-image: url('<?php echo _rs."/IMAGENES/clubes/".$URL['club']. _sh . $URL['album'] "/thumbs/".$foto['nombre_imagen'] ?>');">						                    							                   						                    																	
						               	</div>
						           </a>
						           <a href="#">
						            	<div onclick="eliminarFoto(<?php echo $tipo.",".$club.",'".$album."','".$row['id_imagen']."'" ?>)" style="width: 20px; height: 20px; float: left; margin-left: 182px; margin-top: -156px" title="Eliminar foto <?php echo $row['nombre_imagen']  ?>"> 
											<img src='imagenes/eliminar.png' width="20" height="20" /> 
										</div>
									</a>
						      </div>
						 </li>						        							            
					<?php
					}
					?>
						</ul>
					</div>
				</td>
				</tr>
		   </table>
		<?php 
	}
	?>

