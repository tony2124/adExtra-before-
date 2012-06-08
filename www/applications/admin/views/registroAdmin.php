<script>
$(document).ready(
    function()
    {
      
    }
  );
</script>

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
      <label class="control-label" for="input04">Apellido paterno</label>
      <div class="controls">
        <input type="text" name="ap" class="input-xlarge" id="input04" required>
      </div><br>
      <label class="control-label" for="input05">Apellido materno</label>
      <div class="controls">
        <input type="text" name="am" class="input-xlarge" id="input05" required>
      </div><br>
      <label class="control-label" for="adminEmail">Correo electrónico</label>
      <div class="controls">
        <input type="email" name="email" class="input-xlarge" id="adminEmail" required>
      </div><br>
      <label class="control-label" for="input07">Dirección</label>
      <div class="controls">
        <input type="text" name="direccion" class="input-xlarge" id="input07" required>
      </div><br>
      <label class="control-label" for="input08">Profesión</label>
      <div class="controls">
        <input type="text" name="prof" class="input-xlarge" id="input08" required>
      </div><br>
      <label class="control-label" for="input09">Abreviatura de la profesión</label>
      <div class="controls">
        <input type="text" name="abprof" class="input-xlarge" id="input09" required>
      </div><br>
      <div class="controls">
        <input type="submit" class="input-xlarge btn-primary" id="ejeRegAdmin" value="Registrar Administrador">
      </div><br>
    </div>
  </fieldset>
</form>