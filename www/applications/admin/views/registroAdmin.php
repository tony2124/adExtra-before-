<script>
$(document).ready(
    function()
    {
      
    }
  );
</script>

<?php
if(isset($success))
  print "success";
if(isset($regAdminError))
{
  $error = explode(":",$regAdminError); ?>
<div class="alert alert-block alert-error fade in">
<button class="close" data-dismiss="alert">×</button>
  <h3><?php print $error[0];?></h3>
  <p><?php print $error[1];?></p>
</div>

<?php } ?>

<form class="form-horizontal" method="post" action="<?php print get('webURL')._sh.'admin/regisAdmin';?>" id="registroAdmin">
  <fieldset>
    <legend>Formulario de registro de nuevo administrador</legend>
    <div class="control-group">
      <label class="control-label" for="adminUser">Usuario</label>
      <div class="controls">
        <input type="text" name="usuario" class="input-xlarge" id="adminUser" required>
      </div><br>
      <label class="control-label" for="passUno">Contraseña</label>
      <div class="controls">
        <input type="password" name="passone" class="input-xlarge" id="passUno" required>
      </div><br>
      <label class="control-label" for="passDos">Repetir contraseña</label>
      <div class="controls">
        <input type="password" name="passtwo" class="input-xlarge" id="passDos" required>
      </div><br>
      <label class="control-label" for="adminNombre">Nombre</label>
      <div class="controls">
        <input type="text" name="nombre" class="input-xlarge" id="adminNombre" required>
      </div><br>
      <label class="control-label" for="adminap">Apellido paterno</label>
      <div class="controls">
        <input type="text" name="apepat" class="input-xlarge" id="adminap" required>
      </div><br>
      <label class="control-label" for="adminam">Apellido materno</label>
      <div class="controls">
        <input type="text" name="apemat" class="input-xlarge" id="adminam" required>
      </div><br>
      <label class="control-label" for="adminEmail">Correo electrónico</label>
      <div class="controls">
        <input type="email" name="email" class="input-xlarge" id="adminEmail" required>
      </div><br>
      <label class="control-label" for="admindir">Dirección</label>
      <div class="controls">
        <input type="text" name="direccion" class="input-xlarge" id="admindir" required>
      </div><br>
      <label class="control-label" for="adminpro">Profesión</label>
      <div class="controls">
        <input type="text" name="prof" class="input-xlarge" id="adminpro" required>
      </div><br>
      <label class="control-label" for="adminabr">Abreviatura de la profesión</label>
      <div class="controls">
        <input type="text" name="abprof" class="input-xlarge" id="adminabr" required>
      </div><br>
      <div class="controls">
        <input type="submit" name="btnSubmit" class="input-xlarge btn-primary" id="ejeRegAdmin" value="Registrar Administrador">
      </div><br>
    </div>
  </fieldset>
</form>
<?php
if(isset($date))
    print "Fecha del servidor ".$date;
?>