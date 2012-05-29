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


<script type="text/javascript" src="<?php print path("www/lib/fancybox/jquery.mousewheel-3.0.4.pack.js",true) ?>"></script>
<script type="text/javascript" src="<?php print path("www/lib/fancybox/jquery.fancybox-1.3.4.pack.js",true) ?>"></script>
<link rel="stylesheet" type="text/css" href="<?php print path("www/lib/fancybox/jquery.fancybox-1.3.4.css",true); ?>" media="screen" />
<script type="text/javascript" src="<?php print path("www/lib/uploadify/jquery.uploadify.js",true) ?>"></script>
<link type="text/css" rel="stylesheet" href="<?php print path("www/lib/uploadify/uploadify.css",true) ?>"  />

<script type="text/javascript">
	$(document).ready(function() {

		$("a[rel=galeria]").fancybox({
			'transitionIn'		: 'elastic',
			'transitionOut'		: 'elastic',
			'titlePosition' 	: 'over',
			'titleFormat'		: function(title, currentArray, currentIndex, currentOpts) {
					return '<span id="fancybox-title-over">Image ' + (currentIndex + 1) + ' / ' + currentArray.length + (title.length ? ' &nbsp; ' + title : '') + '</span>';
						}
		});
		<?php if(isset($URL['album'])) { ?>
		$("#fileUpload").fileUpload({
				'uploader': '<?php print path("www/lib/uploadify/uploader.swf",true) ?>',
				'cancelImg': '<?php print path("www/lib/uploadify/cancel.png",true) ?>',
				'folder': '<?php print _spath . "/IMAGENES/clubes/" . $URL["club"] . _sh .$URL["album"] . _sh ?>',
				'buttonText': 'Selecciona fotos',
				'script': 'uploadify.php<?php //print //get("webURL") . _sh . "admin/subir" ?>',
				'multi': true,
				'simUploadLimit': 1
		});
		<?php } ?>
	});
</script>

<script type="text/javascript">
	function eliminarAlbum(id, tipo, club)
	{
		var r = confirm("¿Está seguro que desea eliminar este álbum?. Tome en cuenta que se eliminarán todas las fotos y no será posible recuperarlas después");
		if(r == 1)
		{				
			location.href="#";
		}
	}

	function eliminarFoto( id , imname)
	{
		$('#id_imagen').val(id);
		$('#image_name').val(imname);
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

	if(isset($URL['album'])) { ?>
	<a href="<?php print get('webURL'). _sh . 'admin/galeria' ?>">GALERIA</a> /
	<a href="<?php print get('webURL'). _sh . 'admin/galeria'. _sh . $URL['tipo'] ?>"><?php print $URL['tipo_nombre'] ?></a> /
	<a href="<?php print get('webURL'). _sh . 'admin/galeria'. _sh . $URL['tipo'] . _sh . $URL['club'] ?>"><?php print $URL['club_nombre'] ?></a> /
	<a href=""><?php print $URL['album_nombre'] ?></a> /
	<p>&nbsp;</p>
	<a rel="tooltip" title="Eliminar álbum" href="" class="btn btn-danger"><i class="icon-trash icon-white"></i></a>&nbsp;
	<a rel="tooltip" title="Editar nombre" href="" class="btn btn-primary"><i class="icon-edit icon-white"></i></a>&nbsp;
	<p>&nbsp;</p>
    <table>
	  <tr>
		<td>
		  <div id="gallery">
			<ul id="galleyList" class="horizontalList">
			<?php if($fotos == NULL) print 'No hay fotos en este álbum'; else foreach ($fotos as $foto) { ?>					
					<li class="horizontalListItem">
					    <div class="borderContainer">
					       <div class="btn-group">
					       	<a href="#" class="btn dropdown-toggle" data-toggle="dropdown" style="z-index: 1; position: absolute">
					       		<span class="caret"></span>
					       	</a>
				       		<ul class="dropdown-menu">
				              <li>
				              	<a href="#">
				              		<span class="icon-edit"></span> Editar descripción
				              	</a>
				              </li>
				              <li class="divider"></li>
						      <li>
				              	<a href="#">
				              		<span class="icon-refresh"></span> Cambiar a otro álbum
				              	</a>
				              </li>
				                <li class="divider"></li>
				              <li>
				              	<a data-toggle="modal" href="#confirmModal" onclick="eliminarFoto('<?php print $foto['id_imagen']."','".$foto['nombre_imagen'] ?>')">
				              		<span class="icon-trash"></span> Eliminar foto
				              	</a>
				              </li>
				            </ul>
					       </div>
					       <a rel="galeria" title="<?php print 'Descripción: '.$foto['pie'] ?>" href="<?php print _rs."/IMAGENES/clubes/".$URL['club']. _sh . $URL['album']. _sh .$foto['nombre_imagen'] ?>">
						       <div class="imageContainer" style="background-image: url('<?php echo _rs."/IMAGENES/clubes/".$URL['club']. _sh . $URL['album'] . "/thumbs/".$foto['nombre_imagen'] ?>');"></div>
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
   <p>&nbsp;</p>
   <table align="center" width="330" style="background: #EEE;">
		<tr>
			<td>
				<input name="fileUpload" id="fileUpload" type="file" />
				<a href="javascript:$('#fileUpload').fileUploadStart()">
					Subir
				</a> | 
				<a href="javascript:$('#fileUpload').fileUploadClearQueue()">
					Limpiar
				</a> |
				<a href="<?php echo "index.php?bloque=sitio&opcion=fotografias&tipo=$tipo&club=$club&album=$album" ?>">
					Actualizar
				</a>
			</td>
		</tr>
	</table>
<?php }	?>

<div class="modal hide fade" id="confirmModal">
  <div class="modal-header">
    <button class="close" data-dismiss="modal">×</button>
    <h3>Confirmación</h3>
  </div>
  <div class="modal-body">
    <p>¿Está seguro que desea eliminar esta foto?</p>
   
    <form id="elimPromo" method="post" action="<?php print get('webURL')._sh.'admin/elimFoto' ?>">
      <input name="id_imagen" id="id_imagen" type="hidden" value="">
      <input name="image_name" id="image_name" type="hidden" value="">
      <input name="path" id="path" type="hidden" value="<?php print $URL['club'] . _sh .$URL['album']  ?>">
      <input name="url" id="url" type="hidden" value="<?php print get('webURL') . _sh .'admin/galeria' . _sh . $URL['tipo'] . _sh . $URL['club'] . _sh .$URL['album'] ?>">
    </form> 
  </div>
  <div class="modal-footer">
    <a href="#" class="btn" data-dismiss="modal">Cancelar</a>
    <a href="#" class="btn btn-danger" onclick="$('#elimPromo').submit()">Eliminar</a>
  </div>
</div>