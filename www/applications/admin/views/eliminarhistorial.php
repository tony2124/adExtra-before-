<script>
function generacion(gen)
{
   $('#generacion').html(gen);
   $('#generacion_enviar').val(gen);
}
</script>

<?php if(strcmp($elim,"error")!=0) { ?>
<div class="alert alert-success">
	<h2>¡Eliminado!</h2>
	<p>Se ha eliminado la generación <?php print $elim ?> de la base de datos.</p>
</div>
<?php } ?>

<?php if(strcmp($elim,"error")==0) { ?>
<div class="alert alert-danger">
	<h2>¡Error!</h2>
	<p>No se pudo realizar la operación, debido a que no se proporcionó una contraseña correcta.</p>
</div>
<?php } ?>

<div class="alert">
	<h2>¡Advertencia!</h2>
	<p>Tenga cuidado al momento de realizar una operación en este apartado ya que repercute en la base de datos y alterará los datos que se encuentren en ella. Si no está seguro de querer eliminar el historial salga de este apartado, de lo contrario se le recomienda que haga primero un respaldo de la base de datos para regresar a un estado pasado en caso de haber algún problema.</p>
	<p>Esta acción elimina los datos de los alumnos y el historial de participación de éstos.</p>
</div>

<h3>Generación a eliminar</h3>
<input type="text" name="anio" id="anio" placeholder="Año de la generación (aaaa)" /><br>
<a class="btn btn-danger" onclick="generacion($('#anio').val())" data-toggle="modal" href="#confirmModal">Eliminar</a>


<div class="modal hide fade" id="confirmModal">
  <div class="modal-header">
    <button class="close" data-dismiss="modal">×</button>
    <h3>Confirmación</h3>
  </div>
  <div class="modal-body">
    <p>¿Está seguro que desea eliminar el historial de la generación: <span class="label label-important" id="generacion"></span>?</p>
    <form id="gen" method="post" action="<?php print get('webURL')._sh."admin/eliminargeneracion" ?>">
    	<label>Introduzca la contraseña</label>
    	<input type="password" name="clave" />
      <input name="generacion" id="generacion_enviar" type="hidden" value="">
    </form> 
  </div>
  <div class="modal-footer">
    <a href="#" class="btn" data-dismiss="modal">Cancelar</a>
    <a href="#" class="btn btn-danger" onclick="$('#gen').submit()">Eliminar</a>
  </div>
</div>

